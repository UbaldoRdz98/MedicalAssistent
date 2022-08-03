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
    <title>Medical Assistent - Empleados</title>
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
        <h1>Empleados</h1>
        <form action="Empleados.php" method="GET">
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
                            <div class='col-3'>
                                <label class='class-label'>Hospital:</label>
                                <select class='form-select w-100' aria-label='Default select example' name='filtroemp'>
                                    <option value='All'>Todos</option>";
                                    $db = new database();
                                    $db->ConectarDB();
                                    $Cadena = "SELECT Id_Empresa, Empresa FROM empresas WHERE Id_Empresa = '".$_SESSION["Id_Empresa"]."'";
                                    $reg = $db->Selects($Cadena);
                                    foreach($reg as $value)
                                    {
                                        echo    "<option value='".$value->Id_Empresa."'>".$value->Empresa."</option>";
                                    }
                        echo "  </select>
                            </div>
                            <div class='col-3'>
                                <label class='class-label'>Sucursal:</label>
                                <select class='form-select w-100' aria-label='Default select example' name='filtrosuc'>
                                    <option value='All' selected>Todos</option>";
                                    $db = new database();
                                    $db->ConectarDB();
                                    $Cadena = "SELECT Id_Sucursal, Sucursal FROM sucursales WHERE Id_Empresa = '".$_SESSION["Id_Empresa"]."'";
                                    $reg = $db->Selects($Cadena);
                                    foreach($reg as $value)
                                    {
                                        echo    "<option value='".$value->Id_Sucursal."'>".$value->Sucursal."</option>";
                                    }
                        echo "  </select>
                            </div>
                            <div class='col-2'>
                                <label class='class-label'>Departamento:</label>
                                <select class='form-select w-100' aria-label='Default select example' name='filtrodep'>
                                    <option value='All' selected>Todos</option>
                                    <option value='DOCTOR'>Doctor</option>
                                    <option value='ANALISTA'>Analista</option>
                                    <option value='ADMIN'>Administrador</option>
                                </select>
                            </div>
                            <div class='col-1'>
                                <label class='class-label'>Estatus:</label>
                                <select class='form-select w-100' aria-label='Default select example' name='filtroest'>
                                    <option value='All' selected>Todos</option>
                                    <option value='Activo'>Activo</option>
                                    <option value='Inactivo'>Inactivo</option>
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
            
            $Query = "CALL ConsultarEmpleados ('$filtroemp', '$filtrosuc', '$filtrodep', '$filtroest', $filtro) ";

            $tabla = $conexion->Selects($Query);
            echo "  <table id='TablaEmpleados' class='table table-hover text-center'>
                        <thead class='table-dark'>
                            <tr>
                                <th>Hospital</th>
                                <th>Sucursal</th>
                                <th>Departamento</th>
                                <th>Puesto</th>
                                <th>Empleado</th>
                                <th>Nombre Completo</th>
                                <th>Estatus</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>";
            foreach($tabla as $registro)
            {
                echo "<tr>
                        <form action='../Forms/FormEmpleadosAdmin.php' method='GET'>
                            <td>$registro->Empresa</td>
                            <td>$registro->Sucursal</td>
                            <td>$registro->Departamento</td>
                            <td>$registro->Puesto</td>
                            <td name='MyTable'>
                                <input type='hidden' name='Id_Empleado' value='$registro->Id_Empleado'>$registro->Id_Empleado</td>
                            </td>
                            <td>$registro->NombreCompleto</td>
                            <td>$registro->Estatus</td>
                            <td class='col'>
                                <button type='submit' class='btn btn-outline-warning' href='../Forms/FormEmpleadosAdmin.php'>Editar</button>
                            </td>
                            </form>
                        </tr>";
            }
                    echo "</tbody>
                        </table>";
            $conexion->DesconectarDB();
        }   
        ?>
    </div>
    <?php include('../../Plantillas/Footer/Footer.php')?>
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