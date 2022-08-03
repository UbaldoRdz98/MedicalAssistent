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
    <title>Medical Assistent - Países</title>
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
                    <?php
                        extract($_GET);
                        $id_pais=$_GET['Pais'];
                        if(isset($_GET['btned']))
                        {
                            echo "  <h1>Editar Países</h1>
                                <form method='POST'>
                                    <div class='mb-3 w-100'>
                                        <label class='class-label'>Id_Pais:</label>";
                                        $Query="SELECT * FROM paises WHERE Id_Pais = $id_pais";
                                        $reg = $db->Selects($Query);
                                        foreach($reg as $value)
                                        {
                                echo "      <input type='text' name='Id_Pais' placeholder='Escriba el Nombre Corto de la Sucursal' class='form-control text-uppercase' value='$id_pais' disabled>
                                        </div>
                                        <div class='mb-3 w-100'>
                                            <label class='class-label'>Nombre:</label>
                                            <input type='text' name='Pais' placeholder='Escriba el Nombre del País' class='form-control' value='$value->Pais' required>
                                        </div>
                                        <button type='submit' class='btn btn-outline-success' href='../Forms/FormPaises.php'>Guardar Cambios</button>
                                        <button type='submit' class='btn btn-outline-secondary' href='../Otros/Paises.php'>Cancelar</button>
                                        <input type='hidden' name='Tipo' value='Editar'>
                                        <input type='hidden' name='IdPais' value='$id_pais'>
                                    </form>
                                    </div>";
                                }
                        }
                        else
                        {
                            echo "
                                    <h1>Eliminar País</h1>
                                    <h3>¿Esta seguro de Eliminar la Siguiente Relación?</h3>
                            <form method='POST'>
                                <div class='mb-3 w-100'>
                                    <label class='class-label'>Id_Pais:</label>";
                                    $Query="SELECT * FROM paises WHERE Id_Pais = $id_pais";
                                    $reg = $db->Selects($Query);
                                    foreach($reg as $value)
                                    {
                            echo "      <input type='text' name='Id_Pais' placeholder='Escriba el Nombre Corto de la Sucursal' class='form-control text-uppercase' value='$id_pais' disabled>
                                    </div>
                                    <div class='mb-3 w-100'>
                                        <label class='class-label'>Nombre:</label>
                                        <input type='text' name='Pais' placeholder='Escriba el Nombre del País' class='form-control' value='$value->Pais' required disabled>
                                    </div>
                                    <button type='submit' class='btn btn-outline-danger' href='../Forms/FormPaises.php'>Eliminar País</button>
                                    <button type='submit' class='btn btn-outline-secondary' href='../Otros/Paises.php'>Cancelar</button>
                                    <input type='hidden' name='Tipo' value='Eliminar'>
                                    <input type='hidden' name='IdPais' value='$id_pais'>
                                </form>
                                </div>";
                            }
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
            if($Tipo == 'Editar')
            {
                $query = "  UPDATE paises
                        SET
                            Pais = '$Pais',
                            FUM                 = NOW()
                        WHERE Id_Pais = '$IdPais'";
                $db2->Insert($query);
                echo "<div class='container'><div class='alert alert-success'>País Actualizado</div></div>";
                $db2->DesconectarDB();
                echo "<script> setTimeout(function() { window.location = '../Otros/Paises.php'; }, 100); </script>";
            }
            else
            {
                $query = "  DELETE FROM paises WHERE Id_Pais = '$IdPais'";
                $band= $db2->Insert($query);
                switch($band)
                {
                    case 23000:
                        echo "  <br>
                                <div class='container'>
                                    <div class='alert alert-danger'>
                                    <h3>Error al Eliminar País</h3>
                                    <p>El país que quiere eliminar ya tiene relacion con otras tablas, elimine primero esos registros.</p>
                                    </div>
                                </div>";
                        $db2->DesconectarDB();
                        break;
                    default:
                        echo "<div class='container'><div class='alert alert-success'>País Eliminado</div></div>";
                        $db2->DesconectarDB();
                        echo "<script> setTimeout(function() { window.location = '../Otros/Paises.php'; }, 100); </script>";
                        break;
                }
            }
            
        }
        ?>
    <?php include('../../Plantillas/Footer/Footer.php')?>
</body>
</html>