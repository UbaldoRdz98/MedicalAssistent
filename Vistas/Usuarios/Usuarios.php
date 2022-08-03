<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <script src="../../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">    
    <link rel="icon" href="../../Imagenes/Logo.png">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/medical.css">
    <title>Medical Assistent - Usuarios</title>
</head>
<body>
<?php
        session_start();
        if(isset($_SESSION["Usuario"]))
        {
            $date= date('Y-m-d');
            if (($_SESSION["FechaActivo"] > $date) && ($_SESSION["Estatus"] == 'Activo'))
            {
    ?>
        <?php
            include '../../Database/Database.php';
            $db=new Database();
            $db->ConectarDB();

            $Query="SELECT * FROM usuarios WHERE Usuario = '".$_SESSION["Usuario"]."'";
            $reg = $db->Selects($Query);
            foreach($reg as $valor)
            {
                switch($valor->TipoUsuario)
                {
                    case 'Admin':
                        require '../../Plantillas/Headers/Admins/HeaderAdmins2.php';
                        ?>
                        <div class="container">
        <h1>Usuarios</h1>
        <form action="Usuarios.php" method="GET">
            <?php
                echo "  <div class='row align-items-start'>
                            <div class='col-1'>
                                <label class='class-label'>Filtrar por:</label>
                                <select class='form-select w-100' aria-label='Default select example' name='filtro'>
                                    <option value='10'selected>10</option>
                                    <option value='25'>25</option>
                                    <option value='50'>50</option>
                                    <option value='100'>100</option>
                                    <option value='All'>Todos</option>
                                </select>
                            </div>
                            <div class='col-1'>
                                <br>
                                <button type='submit' class='btn btn-secondary'>Ver</button>
                            </div>
                        </div>";
                ?>
        </form>
        <br>
        <?php
        if($_GET)
        {
            extract($_GET);
            $conexion = new Database();
            $conexion->ConectarDB();
            
            if($filtro == "All")
            {
                $Query = "SELECT * FROM usuarios WHERE Id_Empresa = '".$_SESSION["Id_Empresa"]."' limit 100000000000000 ";
            }
            else
            {
                $Query = "SELECT * FROM usuarios WHERE Id_Empresa = '".$_SESSION["Id_Empresa"]."' limit $filtro ";
            }

            $tabla = $conexion->Selects($Query);
            echo "  <table id='TablaUsuarios' class='table table-hover text-center'>
                        <thead class='table-dark'>
                            <tr>
                                <th>Empresa</th>
                                <th>Sucursal</th>
                                <th>Usuario</th>
                                <th>Tipo de Usuario</th>
                                <th>Estatus</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>";
            foreach($tabla as $registro)
            {
                echo "<tr>
                        <form action='../Forms/FormUsuariosAdmin.php' method='GET'>
                            <td class='col'>$registro->Id_Empresa</td>
                            <td class='col'>$registro->Id_Sucursal</td>
                            <td name='MyTable'>
                                <input type='hidden' name='Usuario' value='$registro->Id_Usuario'>$registro->Usuario</td>
                            </td>
                            <td class='col'>$registro->TipoUsuario</td>
                            <td>$registro->Estatus</td>
                            <td class='col'>
                                <button type='submit' class='btn btn-outline-warning' href='../Forms/FormUsuariosAdmin.php'>Editar</button>
                            </td>
                            </form>
                        </tr>";
            }
                    echo "</tbody>
                        </table>";
            $conexion->DesconectarDB();
        }   
        ?>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#Nuevo">Nuevo Usuario</button>
        </div>
        <br>
    </div>
    <?php include('../../Plantillas/Footer/Footer.php')?>
    <!--INSERT-->
    <div class="modal fade" id="Nuevo" tabindex="-1" aria-labelledby="NuevoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="NuevoLabel">Nuevo Usuarios</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="modal-usuarios">
                        <div class="mb-3 w-100">
                            <label class='class-label'>Empresa:</label>
                            <select id='Empresa' name='Empresa' class='form-control mb-4'>
                                <?php
                                    $db = new database();
                                    $db->ConectarDB();
                                    $Cadena = "SELECT Id_Empresa, Empresa FROM empresas WHERE Id_Empresa = '".$_SESSION["Id_Empresa"]."'";
                                    $reg = $db->Selects($Cadena);
                                    foreach($reg as $value)
                                    {
                                        echo    "<option value='".$value->Id_Empresa."'>".$value->Empresa."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Sucursal:</label>
                            <select id='Sucursal' name='Sucursal' class='form-control mb-4'>
                                <?php
                                    $db = new database();
                                    $db->ConectarDB();
                                    $Cadena = "SELECT Id_Sucursal, Sucursal FROM sucursales WHERE Id_Empresa = '".$_SESSION["Id_Empresa"]."'";
                                    $reg = $db->Selects($Cadena);
                                    foreach($reg as $value)
                                    {
                                        echo    "<option value='".$value->Id_Sucursal."'>".$value->Sucursal."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Nombre:</label>
                            <input type="text" name="Nombre" placeholder="Escriba el Nombre" class="form-control" required>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Apellido Paterno:</label>
                            <input type="text" name="ApellidoPaterno" placeholder="Escriba el Apellido Paterno" class="form-control" required>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Apellido Materno:</label>
                            <input type="text" name="ApellidoMaterno" placeholder="Escriba el Apellido Materno" class="form-control" required>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Correo Electronico:</label>
                            <input type="text" name="CorreoElectronico" placeholder="Escriba el Correo Electronico" class="form-control" required>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Password:</label>
                            <input type="password" name="Password" placeholder="Escriba la Contraseña" class="form-control" required>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Tipo de Usuario:</label>
                            <select name="TipoUsuario" class="form-select">
                                <option value="Doctor" Selected>Doctor</option>
                                <option value="Analista">Analista</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Estatus:</label>
                            <select name="Estatus" class="form-select">
                                <option value="Activo" Selected>Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                        
                        <div class="mb-3 w-100">
                            <label class='class-label'>Activo hasta:</label>
                            <input type="date" name="FechaActivo"
                            value='<?php echo date('Y-m-d');?>' min='<?php echo date('Y-m-d');?>' max="2030-12-31" class="form-control w-50" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" form="modal-usuarios">Guardar</button>
                </div>
                <?php
                    if($_POST)
                    {
                        $db2 = new Database();
                        $db2->ConectarDB();
                        extract($_POST);
                        
                        $hash = password_hash($Password, PASSWORD_DEFAULT);
                    
                        $mystring = $CorreoElectronico;
                        $findme   = '@';
                        $pos = strpos($mystring, $findme);
                        $rest = substr($CorreoElectronico, 0, $pos - 0);

                        $Query=" CALL CreaEmpleado ('$rest', '$CorreoElectronico', '$Empresa', '$Sucursal', '$hash', '$Estatus', '$TipoUsuario', '$Nombre', '$ApellidoPaterno', '$ApellidoMaterno')";
                        $band = $db->Insert($Query);
                        $db->DesconectarDB();

                        if ($band == 0)
                        {
                            echo "<div class='alert alert-success'>Usuario Registrado</div>";
                            $db2->DesconectarDB();
                            echo "<script> setTimeout(function() { window.location = 'Usuarios.php'; }, 10); </script>";
                        }
                        else
                        {
                            switch($band)
                            {
                                case 23000:
                                    echo "  <div class='alert alert-danger'>
                                                <h1>ERROR</h1>
                                                <p>El Correo Electronico ya ha sido Registrado</p>
                                            </div>";
                                    break;
                                default:
                                    echo "  <div class='alert alert-danger'>
                                                <h1>ERROR</h1>
                                                <p>El Correo Electronico ya ha sido Registrado</p>
                                            </div>";
                                    break;
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <?php
                    break;
                    default:
                        echo "<script> setTimeout(function() { window.location = '../NoAutorizado.php'; }, 10); </script>";
                    break;
                }
            }
        ?>
    <?php
        }
        else
        {
            ?>
            <?php echo "<script> setTimeout(function() { window.location = '../FechaNoValida.php'; }, 10); </script>";
            
        }}
        else
        {
            ?>
            <?php require '../Plantillas/Headers/HeaderIndexLogin.php' ?>
            <?php
        }
    ?>  
</body>
</html>