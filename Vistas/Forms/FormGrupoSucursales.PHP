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
    <title>Medical Assistent - Grupo de Sucursales</title>
</head>
<body>
    <?php
        session_start();
        if(isset($_SESSION["Usuario"]))
        {
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
                    <h1>Editar Grupo de Sucursales</h1>
                    <form method="POST">
                        <div class="mb-3 w-100">
                            <label class='class-label'>Grupo de Sucursales:</label>
                        <?php
                            extract($_GET);
                            $id_gruposucursal=$_GET['Id_GrupoSuc'];
                            $Query="SELECT * FROM grupo_sucursales WHERE Id_GrupoSuc = '$id_gruposucursal' LIMIT 1";
                            $reg = $db->Selects($Query);
                            foreach($reg as $valor)
                            {
                    echo "  
                            <input type='text' name='id_grupo' placeholder='Escriba el nombre del Grupo de Empresas' class='form-control' value='$valor->Id_GrupoSuc' disabled required>
                        </div>
                    </form>";
                            }
                            $Query = "SELECT GS.Id_GrupoSuc Id_GrupoSuc, S.Id_Sucursal, S.Sucursal Sucursal FROM grupo_sucursales GS JOIN sucursales S ON GS.Id_Sucursal = S.Id_Sucursal WHERE GS.Id_GrupoSuc = '$id_gruposucursal'";
                            $tabla = $db->Selects($Query);
                echo "  <table id='TablaRelacion' class='table table-hover text-center'>
                            <thead class='table-dark'>
                            <tr>
                                <th>Grupo de Sucursal</th>
                                <th>Sucursales</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>";
            foreach($tabla as $registro)
            {
                echo "<tr>
                        <form action='../Forms/FormGrupoSucursalesEliminar.php' method='GET'>
                            <td name='MyTable'>
                                <input type='hidden' name='Id_GrupoSuc' value='$registro->Id_GrupoSuc'>$registro->Id_GrupoSuc</td>
                            </td>
                            <td class='col'>
                                <input type='hidden' name='Id_Sucursal' value='$registro->Id_Sucursal'>$registro->Sucursal</td>
                            </td>
                            <td class='col'>
                                <button type='submit' class='btn btn-outline-danger' href='../Forms/FormGrupoSucursalesEliminar.php'>Eliminar</button>
                            </td>
                            </form>
                        </tr>";
            }
                    echo "</tbody>
                        </table>";
            $db->DesconectarDB();
                        
            echo "      <div class='d-grid gap-2 d-md-flex justify-content-md-end'>
                            <button type='button' class='btn btn-outline-success' data-bs-toggle='modal' data-bs-target='#Nuevo'>Nueva Relación</button>
                            <button type='submit' class='btn btn-outline-secondary' href='../Otros/GrupoEmpresas.php'>Cancelar</button>
                        </div>
                        <br>
                    </form>
                    <br>
                </div>
                <div class='modal fade' id='Nuevo' tabindex='-1' aria-labelledby='NuevoLabel' aria-hidden='true'>
                    <div class='modal-dialog modal-dialog-scrollable'>
                        <div class='modal-content'>
                            <div class='modal-header bg-dark text-white'>
                                <h5 class='modal-title' id='NuevoLabel'>Nueva Relación</h5>
                                <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <form method='POST' action='FormGrupoSucursales.php' id='modal-relacion'>
                                    <div class='mb-3 w-100'>
                                        <input type='text' name='id_g' placeholder='Escriba el Nombre del Grupo' class='form-control' value='$valor->Id_GrupoSuc' hidden>
                                    </div>
                                    <div class='mb-3 w-100'>
                                        <label class='class-label'>Grupo Empresa:</label>
                                        <input type='text' name='Id_Gpo' placeholder='Escriba el Nombre del Grupo' class='form-control' value='$valor->Id_GrupoSuc' disabled required>
                                    </div>
                                    <div class='mb-3 w-100'>
                                        <label class='class-label'>Empresa:</label>";
                                            $db1 = new database();
                                            $db1->ConectarDB();
                                            $Cadena1 = "CALL RellenaSucursalesGpo('$id_gruposucursal')";
                                            $reg1 = $db1->Selects($Cadena1);
                                echo "  <select name='Id_Suc' class='form-select' required>";
                                foreach($reg1 as $value1)
                                {
                                    echo "      <option value='".$value1->Id_Sucursal."'>".$value1->Sucursal."</option>";
                                }
                                echo "      </select>";
                                $db1->DesconectarDB();
                            
                            echo " </div>
                            </form>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                            <button type='submit' class='btn btn-primary' form='modal-relacion'>Guardar</button>
                        </div>";
                    ?>
                <?php
                    if($_POST)
                    {
                        $db2 = new Database();
                        $db2->ConectarDB();
                        extract($_POST);
                        $query = "INSERT INTO grupo_sucursales
                                        VALUES('$id_g', '$Id_Suc', '".$_SESSION["Id_Usuario"]."', NOW(),
                                            '".$_SESSION["Id_Usuario"]."', NOW())";
                        $db2->Insert($query);
                        $db2->DesconectarDB();
                        echo "<div class='alert alert-success'>Grupo Registrado</div>";
                        echo "<script> setTimeout(function() { window.location = 'FormGrupoSucursales.php?Id_GrupoSuc=$id_g'; }, 0); </script>";
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
        }
    ?>
    <?php include('../../Plantillas/Footer/Footer.php')?>
</body>
</html>