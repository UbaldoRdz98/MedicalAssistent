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
    <title>Medical Assistent - Síntomas</title>
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
                switch($_SESSION["TipoUsuario"])
                    {
                        case 'Admin':
                            require '../../Plantillas/Headers/Admins/HeaderAdmins2.php';
                        break;
                        case 'Doctor':
                            require '../../Plantillas/Headers/Empleados/HeaderEmpleados.php';
                            break;
                            case 'Analista':
                                require '../../Plantillas/Headers/Empleados/HeaderEmpleados.php';
                                break;
                            default:
                                    require '../Plantillas/Headers/HeaderIndexLogin.php';
                            break;
                    }
                        ?>
                        <div class="container">
        <h1>Síntomas</h1>
        <form action="Sintomas.php" method="GET">
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
                $Query = "SELECT * FROM sintomas limit 100000000000000 ";
            }
            else
            {
                $Query = "SELECT * FROM sintomas limit $filtro ";
            }

            $tabla = $conexion->Selects($Query);
            echo "  <table id='TablaSintomas' class='table table-hover text-center'>
                        <thead class='table-dark'>
                            <tr>
                                <th>Id_Sintoma</th>
                                <th>Nombre</th>
                                <th>Estatus</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>";
            foreach($tabla as $registro)
            {
                echo "<tr>
                        <form action='../Forms/FormSintomas.php' method='GET'>
                            <td name='MyTable'>
                                <input type='hidden' name='Id_Sintoma' value='$registro->Id_Sintoma'>$registro->Id_Sintoma</td>
                            </td>
                            <td class='col'>$registro->Sintoma</td>
                            <td>$registro->Estatus</td>
                            <td class='col'>
                                <button type='submit' class='btn btn-outline-warning' href='../Forms/FormSintomas.php'>Editar</button>
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
            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#Nuevo">Nuevo Síntoma</button>
        </div>
        <br>
    </div>
    <?php include('../../Plantillas/Footer/Footer.php')?>
    <!--INSERT-->
    <div class="modal fade" id="Nuevo" tabindex="-1" aria-labelledby="NuevoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="NuevoLabel">Nuevo Síntoma</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="Sintomas.php" id="modal-sintomas">
                        <div class="mb-3 w-100">
                            <label class='class-label'>Síntoma:</label>
                            <input type="text" name="Sintoma" placeholder="Escriba el Nombre del Síntoma" class="form-control text-uppercase" required>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Estatus:</label>
                            <select name="Estatus" class="form-select">
                                <option value="Activo" Selected>Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" form="modal-sintomas">Guardar</button>
                </div>
                <?php
                    if($_POST)
                    {
                        session_start();
                        $db2 = new Database();
                        $db2->ConectarDB();
                        extract($_POST);
                        $query = "INSERT INTO sintomas( Sintoma, Estatus, UsuarioCreacion, FechaCreacion,
                                                            UUM, FUM)
                                    VALUES( '$Sintoma', '$Estatus', '".$_SESSION["Id_Usuario"]."', NOW(),
                                            '".$_SESSION["Id_Usuario"]."', NOW())";
                        $db2->Insert($query);
                        echo "<div class='alert alert-success'>Síntoma Registrado</div>";
                        header("refresh:0; Sintomas.php");
                        $db2->DesconectarDB();
                    }
                ?>
            </div>
        </div>
    </div>
    <?php
            }
        ?>
    <?php
        }
        else
        {
            ?>
            <?php echo "<script> setTimeout(function() { window.location = '../FechaNoValida.php'; }, 0); </script>";
            
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