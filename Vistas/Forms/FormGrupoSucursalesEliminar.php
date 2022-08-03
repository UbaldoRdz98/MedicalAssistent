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
                    <h1>Eliminar Relación</h1>
                    <h3>¿Esta seguro de Eliminar la Siguiente Relación?</h3>
                    <form method="POST">
                        <div class="mb-3 w-100">
                            <label class='class-label'>Grupo de Sucursales:</label>
                        <?php
                            extract($_GET);
                            $id_gruposucursal=$_GET['Id_GrupoSuc'];
                            $sucursal=$_GET['Id_Sucursal'];
                            $Query="SELECT * FROM grupo_sucursales WHERE Id_GrupoSuc ='$id_gruposucursal' AND Id_Sucursal = '$sucursal'";
                            $reg = $db->Selects($Query);
                            foreach($reg as $valor)
                            {
            echo "          <select name='idgpo' class='form-select' required>
                                <option value='$valor->Id_GrupoSuc'>$valor->Id_GrupoSuc</option>
                            </select>
                        </div>
                        <div class='mb-3 w-100'>
                            <label class='class-label'>Sucursal:</label>
                            <select name='id_suc' class='form-select' required>
                                <option value='$valor->Id_Sucursal'>$valor->Id_Sucursal</option>
                            </select>
                        </div>";
                            }
                        ?>
                        <button type='submit' class='btn btn-outline-danger' href='FormGrupoSucursalesEliminar.php'>Eliminar</button>
                        <button type='submit' class='btn btn-outline-secondary' href='FormGrupoSucursales.php'>Cancelar</button>
                        <br>
                    </form>
                    <br>
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
    <?php
        if($_POST)
        {
            $db2 = new Database();
            $db2->ConectarDB();
            extract($_POST);
            $query = "  DELETE FROM grupo_sucursales WHERE Id_GrupoSuc = '$idgpo' AND Id_Sucursal = '$id_suc'";
            $db2->Insert($query);
            echo "<div class='container'><div class='alert alert-success'>Relación Eliminada</div></div>";
            $db2->DesconectarDB();
            echo "<script> setTimeout(function() { window.location = 'FormGrupoSucursales.php?Id_GrupoSuc=$idgpo'; }, 0); </script>";
        }
        ?>
    <?php include('../../Plantillas/Footer/Footer.php')?>
</body>
</html>