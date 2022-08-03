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
    <title>Medical Assistent - Relación Enfermedades-Síntomas</title>
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
        <h1>Relación Enfermedades-Síntomas</h1>
        <form action="Enfermedades_Sintomas.php" method="GET">
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
                                <label class='class-label'>Enfermedad:</label>";
                                $db1 = new database();
                                $db1->ConectarDB();
                                $Cadena1 = "SELECT Id_Enfermedad, Enfermedad FROM enfermedades";
                                $reg1 = $db1->Selects($Cadena1);
                                echo "  <select name='filtroenf' class='form-select' required>
                                            <option value='All' selected>Todas</option>";
                                foreach($reg1 as $value1)
                                {
                                    echo "      <option value='".$value1->Id_Enfermedad."'>".$value1->Enfermedad."</option>";
                                }
                                echo "      </select>";
                                $db1->DesconectarDB();
                    echo   "</div>
                            <div class='col-3'>
                                <label class='class-label'>Síntoma:</label>";
                                $db1 = new database();
                                $db1->ConectarDB();
                                $Cadena1 = "SELECT Id_Sintoma, Sintoma FROM sintomas";
                                $reg1 = $db1->Selects($Cadena1);
                                echo "  <select name='filtrosin' class='form-select' required>
                                            <option value='All' selected>Todos</option>";
                                foreach($reg1 as $value1)
                                {
                                    echo "      <option value='".$value1->Id_Sintoma."'>".$value1->Sintoma."</option>";
                                }
                                echo "      </select>";
                                $db1->DesconectarDB();
                    echo   "</div>
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
                if(($filtroenf == "All") && ($filtrosin == "All"))
                {
                    $Query = "SELECT E.Id_Enfermedad, E.Enfermedad, S.Id_Sintoma, S.Sintoma FROM enfermedades_sintomas ES JOIN enfermedades E ON ES.Id_Enfermedad = E.Id_Enfermedad JOIN sintomas S ON ES.Id_Sintoma = S.Id_Sintoma limit 100000000000000 ";
                }
                else
                {
                    if(($filtroenf == "All") && ($filtrosin != "All"))
                    {
                        $Query = "SELECT E.Id_Enfermedad, E.Enfermedad, S.Id_Sintoma, S.Sintoma FROM enfermedades_sintomas ES JOIN enfermedades E ON ES.Id_Enfermedad = E.Id_Enfermedad JOIN sintomas S ON ES.Id_Sintoma = S.Id_Sintoma WHERE ES.Id_Sintoma = $filtrosin limit 100000000000000 ";
                    }
                    elseif(($filtroenf != "All") && ($filtrosin == "All"))
                    {
                        $Query = "SELECT E.Id_Enfermedad, E.Enfermedad, S.Id_Sintoma, S.Sintoma FROM enfermedades_sintomas ES JOIN enfermedades E ON ES.Id_Enfermedad = E.Id_Enfermedad JOIN sintomas S ON ES.Id_Sintoma = S.Id_Sintoma WHERE ES.Id_Enfermedad = $filtroenf limit 100000000000000 ";
                    }
                    else
                    {
                        $Query = "SELECT E.Id_Enfermedad, E.Enfermedad, S.Id_Sintoma, S.Sintoma FROM enfermedades_sintomas ES JOIN enfermedades E ON ES.Id_Enfermedad = E.Id_Enfermedad JOIN sintomas S ON ES.Id_Sintoma = S.Id_Sintoma WHERE ES.Id_Enfermedad = $filtroenf AND ES.Id_Sintoma = $filtrosin limit 100000000000000 ";
                    }
                }
            }
            else
            {
                if(($filtroenf == "All") && ($filtrosin == "All"))
                {
                    $Query = "SELECT E.Id_Enfermedad, E.Enfermedad, S.Id_Sintoma, S.Sintoma FROM enfermedades_sintomas ES JOIN enfermedades E ON ES.Id_Enfermedad = E.Id_Enfermedad JOIN sintomas S ON ES.Id_Sintoma = S.Id_Sintoma limit 100000000000000 ";
                }
                else
                {
                    if(($filtroenf == "All") && ($filtrosin != "All"))
                    {
                        $Query = "SELECT E.Id_Enfermedad, E.Enfermedad, S.Id_Sintoma, S.Sintoma FROM enfermedades_sintomas ES JOIN enfermedades E ON ES.Id_Enfermedad = E.Id_Enfermedad JOIN sintomas S ON ES.Id_Sintoma = S.Id_Sintoma WHERE S.Id_Sintoma = $filtrosin limit $filtro ";
                    }
                    elseif(($filtroenf != "All") && ($filtrosin == "All"))
                    {
                        $Query = "SELECT E.Id_Enfermedad, E.Enfermedad, S.Id_Sintoma, S.Sintoma FROM enfermedades_sintomas ES JOIN enfermedades E ON ES.Id_Enfermedad = E.Id_Enfermedad JOIN sintomas S ON ES.Id_Sintoma = S.Id_Sintoma WHERE ES.Id_Enfermedad = $filtroenf limit $filtro";
                    }
                    else
                    {
                        $Query = "SELECT E.Id_Enfermedad, E.Enfermedad, S.Id_Sintoma, S.Sintoma FROM enfermedades_sintomas ES JOIN enfermedades E ON ES.Id_Enfermedad = E.Id_Enfermedad JOIN sintomas S ON ES.Id_Sintoma = S.Id_Sintoma WHERE ES.Id_Enfermedad = $filtroenf AND ES.Id_Sintoma = $filtrosin limit $filtro ";
                    }
                }
            }

            $tabla = $conexion->Selects($Query);
            echo "  <table id='TablaRelacion' class='table table-hover text-center'>
                        <thead class='table-dark'>
                            <tr>
                                <th>Id_Enfermedad</th>
                                <th>Enfermedad</th>
                                <th>Id_Sintoma</th>
                                <th>Sintoma</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>";
            foreach($tabla as $registro)
            {
                echo "<tr>
                        <form action='../Forms/FormEnfermedades_Sintomas.php' method='GET'>
                            <td name='MyTable'>
                                <input type='hidden' name='Id_Enfermedad' value='$registro->Id_Enfermedad'>$registro->Id_Enfermedad</td>
                            </td>
                            <td class='col'>$registro->Enfermedad</td>
                            <td name='MyTable'>
                                <input type='hidden' name='Id_Sintoma' value='$registro->Id_Sintoma'>$registro->Id_Sintoma</td>
                            </td>
                            <td class='col'>$registro->Sintoma</td>
                            <td class='col'>
                                <button type='submit' class='btn btn-outline-danger' href='../Forms/FormEnfermedades_Sintomas.php'>Eliminar</button>
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
            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#Nuevo">Nueva Relación</button>
        </div>
        <br>
    </div>
    <?php include('../../Plantillas/Footer/Footer.php')?>
    <!--INSERT-->
    <div class="modal fade" id="Nuevo" tabindex="-1" aria-labelledby="NuevoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="NuevoLabel">Nueva Relación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="Enfermedades_Sintomas.php" id="modal-relacion">
                        <div class="mb-3 w-100">
                            <label class='class-label'>Enfermedad:</label>
                            <?php
                                $db1 = new database();
                                $db1->ConectarDB();
                                $Cadena1 = "SELECT Id_Enfermedad, Enfermedad FROM enfermedades";
                                $reg1 = $db1->Selects($Cadena1);
                                echo "  <select name='idenf' class='form-select' required>";
                                foreach($reg1 as $value1)
                                {
                                    echo "      <option value='".$value1->Id_Enfermedad."'>".$value1->Enfermedad."</option>";
                                }
                                echo "      </select>";
                                $db1->DesconectarDB();
                            ?>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Síntoma:</label>
                            <?php
                                $db1 = new database();
                                $db1->ConectarDB();
                                $Cadena1 = "SELECT Id_Sintoma, Sintoma FROM sintomas";
                                $reg1 = $db1->Selects($Cadena1);
                                echo "  <select name='idsin' class='form-select' required>";
                                foreach($reg1 as $value1)
                                {
                                    echo "      <option value='".$value1->Id_Sintoma."'>".$value1->Sintoma."</option>";
                                }
                                echo "      </select>";
                                $db1->DesconectarDB();
                            ?>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" form="modal-relacion">Guardar</button>
                </div>
                <?php
                    if($_POST)
                    {
                        session_start();
                        $db2 = new Database();
                        $db2->ConectarDB();
                        extract($_POST);
                        $query = "INSERT INTO enfermedades_sintomas( Id_Enfermedad, Id_Sintoma, UsuarioCreacion, FechaCreacion,
                                                            UUM, FUM)
                                VALUES($idenf, $idsin, '".$_SESSION["Id_Usuario"]."', NOW(),
                                            '".$_SESSION["Id_Usuario"]."', NOW())";
                        $db2->Insert($query);
                        echo "<div class='alert alert-success'>Relación Registrada</div>";
                        header("refresh:0; Enfermedades_Sintomas.php");
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