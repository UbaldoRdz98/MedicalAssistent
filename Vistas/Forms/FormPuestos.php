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
    <title>Medical Assistent - Puestos</title>
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
                    <h1>Editar Puestos</h1>
                    <form method="POST">
                        <div class="mb-3 w-100">
                        <label class='class-label'>Puesto:</label>
                        <?php
                            extract($_GET);
                            $id_puesto=$_GET['Id_Puesto'];
                            $Query="SELECT * FROM puestos WHERE Id_Puesto = '$id_puesto'";
                            $reg = $db->Selects($Query);
                            foreach($reg as $valor)
                            {
                                echo "
                                        <input type='text' name='Id_Puesto' placeholder='Escriba el Nombre Corto del Puesto' class='form-control text-uppercase' value='$valor->Id_Puesto' disabled>
                                    </div>
                                    <div class='mb-3 w-100'>
                                        <label class='class-label'>Nombre:</label>
                                        <input type='text' name='Puesto' placeholder='Escriba el Nombre Completo del Puesto' class='form-control' value='$valor->Puesto' required>
                                    </div>
                                    <div class='mb-3 w-100'>
                                        <label class='class-label'>Estatus:</label>
                                        <select name='Estatus' class='form-select'>";
                                    if($valor->Estatus == 'Activo')
                                    {
                                        echo "  <option value='Activo' Selected>Activo</option>
                                                <option value='Inactivo'>Inactivo</option>";
                                    }
                                    else
                                    {
                                        echo "  <option value='Activo'>Activo</option>
                                                <option value='Inactivo' Selected>Inactivo</option>";
                                    }
                                echo "  </select>
                                    </div>
                                <button type='submit' class='btn btn-outline-success' href='../Forms/FormPuestos.php'>Guardar Cambios</button>
                                <button type='submit' class='btn btn-outline-secondary' href='../Empresas/Departamentos.php'>Cancelar</button>
                                <br>
                            </form>
                            <br>
                        </div>";
                    }
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
            $query = "  UPDATE puestos
                        SET
                            Puesto              = '$Puesto',
                            Estatus             = '$Estatus',
                            UUM                 = '".$_SESSION["Id_Usuario"]."',
                            FUM                 = NOW()
                        WHERE Id_Puesto = '".strtoupper($id_puesto)."'";
                $db2->Insert($query);
                echo "<div class='container'><div class='alert alert-success'>Puesto Actualizado</div></div>";
                $db2->DesconectarDB();
                echo "<script> setTimeout(function() { window.location = '../Empresas/Puestos.php'; }, 100); </script>";
            }
        ?>
    <?php include('../../Plantillas/Footer/Footer.php')?>
</body>
</html>