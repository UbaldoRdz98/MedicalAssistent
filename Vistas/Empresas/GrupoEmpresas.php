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
    <title>Medical Assistent - Grupo de Empresas</title>
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
        <h1>Grupo de Empresas</h1>
        <form action="GrupoEmpresas.php" method="GET">
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
                                <label class='class-label'>Grupo de Empresa:</label>";
                                $db1 = new database();
                                $db1->ConectarDB();
                                $Cadena1 = "SELECT Id_GrupoEmp FROM grupo_empresas";
                                $reg1 = $db1->Selects($Cadena1);
                        echo "  <select name='filtrogrupo' class='form-select' required>
                                    <option value='All' selected>Todos</option>";
                            foreach($reg1 as $value1)
                            {
                                echo "      <option value='".$value1->Id_GrupoEmp."'>".$value1->Id_GrupoEmp."</option>";
                            }
                            echo "      </select>";
                            $db1->DesconectarDB();
                echo   "</div>
                            <div class='col-3'>
                                <label class='class-label'>Empresa:</label>";
                                $db1 = new database();
                                $db1->ConectarDB();
                                $Cadena1 = "SELECT Id_Empresa, Empresa FROM empresas";
                                $reg1 = $db1->Selects($Cadena1);
                                echo "  <select name='filtroemp' class='form-select' required>
                                            <option value='All' selected>Todas</option>";
                                foreach($reg1 as $value1)
                                {
                                    echo "      <option value='".$value1->Id_Empresa."'>".$value1->Empresa."</option>";
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
                if(($filtrogrupo == "All") && ($filtroemp == "All"))
                {
                    $Query = "SELECT Id_GrupoEmp, GROUP_CONCAT(E.Empresa SEPARATOR '\n') Empresas FROM grupo_empresas GE JOIN empresas E ON GE.Id_Empresa = E.Id_Empresa GROUP BY Id_GrupoEmp LIMIT 100000000000000 ";
                }
                else
                {
                    if(($filtrogrupo == "All") && ($filtroemp != "All"))
                    {
                        $Query = "SELECT Id_GrupoEmp, GROUP_CONCAT(E.Empresa SEPARATOR '\n') Empresas FROM grupo_empresas GE JOIN empresas E ON GE.Id_Empresa = E.Id_Empresa WHERE E.Id_Empresa= '$filtroemp' GROUP BY Id_GrupoEmp LIMIT 100000000000000 ";
                    }
                    elseif(($filtrogrupo != "All") && ($filtroemp == "All"))
                    {
                        $Query = "SELECT Id_GrupoEmp, GROUP_CONCAT(E.Empresa SEPARATOR '\n') Empresas FROM grupo_empresas GE JOIN empresas E ON GE.Id_Empresa = E.Id_Empresa WHERE GE.Id_GrupoEmp = '$filtrogrupo' GROUP BY Id_GrupoEmp LIMIT 100000000000000 ";
                    }
                    else
                    {
                        $Query = "SELECT Id_GrupoEmp, GROUP_CONCAT(E.Empresa SEPARATOR '\n') Empresas FROM grupo_empresas GE JOIN empresas E ON GE.Id_Empresa = E.Id_Empresa WHERE GE.Id_GrupoEmp = '$filtrogrupo' AND E.Id_Empresa = '$filtroemp' GROUP BY Id_GrupoEmp LIMIT 100000000000000 ";
                    }
                }
            }
            else
            {
                if(($filtrogrupo == "All") && ($filtroemp == "All"))
                {
                    $Query = "SELECT Id_GrupoEmp, GROUP_CONCAT(E.Empresa SEPARATOR '\n') Empresas FROM grupo_empresas GE JOIN empresas E ON GE.Id_Empresa = E.Id_Empresa GROUP BY Id_GrupoEmp LIMIT $filtro ";
                }
                else
                {
                    if(($filtrogrupo == "All") && ($filtroemp != "All"))
                    {
                        $Query = "SELECT Id_GrupoEmp, GROUP_CONCAT(E.Empresa SEPARATOR '\n') Empresas FROM grupo_empresas GE JOIN empresas E ON GE.Id_Empresa = E.Id_Empresa WHERE E.Id_Empresa = '$filtroemp' GROUP BY Id_GrupoEmp LIMIT $filtro ";
                    }
                    elseif(($filtrogrupo != "All") && ($filtroemp == "All"))
                    {
                        $Query = "SELECT Id_GrupoEmp, GROUP_CONCAT(E.Empresa SEPARATOR '\n') Empresas FROM grupo_empresas GE JOIN empresas E ON GE.Id_Empresa = E.Id_Empresa WHERE GE.Id_GrupoEmp = '$filtrogrupo' GROUP BY Id_GrupoEmp LIMIT $filtro ";
                    }
                    else
                    {
                        $Query = "SELECT Id_GrupoEmp, GROUP_CONCAT(E.Empresa SEPARATOR '\n') Empresas FROM grupo_empresas GE JOIN empresas E ON GE.Id_Empresa = E.Id_Empresa WHERE GE.Id_GrupoEmp = '$filtrogrupo' AND E.Id_Empresa = '$filtroemp' GROUP BY Id_GrupoEmp LIMIT $filtro ";
                    }
                }
            }

            $tabla = $conexion->Selects($Query);
            echo "  <table id='TablaRelacion' class='table table-hover text-center'>
                        <thead class='table-dark'>
                            <tr>
                                <th>Grupo de Empresa</th>
                                <th>Empresa</th>
                                <th>Acci??n</th>
                            </tr>
                        </thead>
                        <tbody>";
            foreach($tabla as $registro)
            {
                echo "<tr>
                        <form action='../Forms/FormGrupoEmpresas.php' method='GET'>
                            <td name='MyTable' style='vertical-align:middle;'>
                                <input type='hidden' name='Id_GrupoEmpresa' value='$registro->Id_GrupoEmp'>$registro->Id_GrupoEmp</td>
                            </td>
                            <td class='col'>";
                                echo nl2br($registro->Empresas);
                    echo"   </td>
                            <td class='col'>
                                <button type='submit' class='btn btn-outline-warning' href='../Forms/FormGrupoEmpresas.php'>Editar</button>
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
            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#Nuevo">Nuevo Grupo</button>
        </div>
        <br>
    </div>
    <?php include('../../Plantillas/Footer/Footer.php')?>
    <!--INSERT-->
    <div class="modal fade" id="Nuevo" tabindex="-1" aria-labelledby="NuevoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="NuevoLabel">Nueva Grupo de Empresa</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="GrupoEmpresas.php" id="modal-relacion">
                        <div class="mb-3 w-100">
                            <label class='class-label'>Nombre del Grupo:</label>
                            <input type="text" name="Id_GrupoEmp" placeholder="Escriba el Nombre del Grupo" class="form-control" required>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Empresa:</label>
                            <?php
                                $db1 = new database();
                                $db1->ConectarDB();
                                $Cadena1 = "SELECT Id_Empresa, Empresa FROM empresas";
                                $reg1 = $db1->Selects($Cadena1);
                                echo "  <select name='Id_Emp' class='form-select' required>";
                                foreach($reg1 as $value1)
                                {
                                    echo "      <option value='".$value1->Id_Empresa."'>".$value1->Empresa."</option>";
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
                        $db2 = new Database();
                        $db2->ConectarDB();
                        extract($_POST);
                        $query = "INSERT INTO grupo_empresas
                                        VALUES('$Id_GrupoEmp', '$Id_Emp', '".$_SESSION["Id_Usuario"]."', NOW(),
                                            '".$_SESSION["Id_Usuario"]."', NOW())";
                        $db2->Insert($query);
                        echo "<div class='alert alert-success'>Grupo Registrado</div>";
                        header("refresh:0; GrupoEmpresas.php");
                        $db2->DesconectarDB();
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
            
        }
        }
        else
        {
            ?>
            <?php require '../Plantillas/Headers/HeaderIndexLogin.php' ?>
            <?php
        }
    ?>    
</body>
</html>