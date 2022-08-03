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
    <title>Medical Assistent - Estados</title>
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
                        $id_estado=$_GET['Id_Estado'];
                        if(isset($_GET['btned']))
                        {
                            echo "  <h1>Editar Estado</h1>
                                <form method='POST'>
                                    <div class='mb-3 w-100'>
                                        <label class='class-label'>Id_Pais:</label>";
                                        $Query="SELECT * FROM estados e JOIN paises p ON e.Id_Pais = p.Id_Pais WHERE Id_Estado = $id_estado";
                                        $reg = $db->Selects($Query);
                                        foreach($reg as $value)
                                        {
                                echo "      <input type='text' name='Id_Estado' placeholder='Escriba el Nombre Corto de la Sucursal' class='form-control text-uppercase' value='$id_estado' disabled>
                                        </div>
                                        <div class='mb-3 w-100'>
                                            <label class='class-label'>Nombre:</label>
                                            <input type='text' name='Estado' placeholder='Escriba el Nombre del Estados' class='form-control' value='$value->Estado' required>
                                        </div>
                                        <div class='mb-3 w-100'>
                                            <label class='class-label'>País:</label>
                                            <select name='idpais' class='form-select' required>";
                                            $Query="SELECT * FROM paises";
                                            $reg1 = $db->Selects($Query);
                                            foreach($reg1 as $value1)
                                            {
                                                if($value->Id_Pais == $value1->Id_Pais)
                                                {
                                                    echo "      <option value='".$value1->Id_Pais."' selected>".$value1->Pais."</option>";
                                                }
                                                else
                                                {
                                                    echo "      <option value='".$value1->Id_Pais."'>".$value1->Pais."</option>";
                                                }
                                            }
                            echo "      </select>
                                    </div>
                                        <button type='submit' class='btn btn-outline-success' href='../Forms/FormEstados.php'>Guardar Cambios</button>
                                        <button type='submit' class='btn btn-outline-secondary' href='../Otros/Estados.php'>Cancelar</button>
                                        <input type='hidden' name='Tipo' value='Editar'>
                                        <input type='hidden' name='IdEstado' value='$id_estado'>
                                    </form>
                                    </div>";
                                }
                        }
                        else
                        {
                            echo "
                                    <h1>Eliminar Estado</h1>
                                    <h3>¿Esta seguro de Eliminar el Siguiente Estado?</h3>
                            <form method='POST'>
                                <div class='mb-3 w-100'>
                                    <label class='class-label'>Id_Estado:</label>";
                                    $Query="SELECT e.Id_Estado, e.Estado, p.Id_Pais, p.Pais FROM estados e JOIN paises p ON e.Id_Pais = p.Id_Pais WHERE Id_Estado = $id_estado";
                                    $reg = $db->Selects($Query);
                                    foreach($reg as $value)
                                    {
                            echo "      <input type='text' name='Id_Estado' placeholder='Escriba el Nombre Corto de la Sucursal' class='form-control text-uppercase' value='$id_estado' disabled>
                                    </div>
                                    <div class='mb-3 w-100'>
                                        <label class='class-label'>Nombre:</label>
                                        <input type='text' name='Estado' placeholder='Escriba el Nombre del País' class='form-control' value='$value->Estado' required disabled>
                                    </div>
                                    <div class='mb-3 w-100'>
                                            <label class='class-label'>País:</label>
                                            <select name='idpais' class='form-select' disabled required>";
                                            $Query="SELECT * FROM paises";
                                            $reg1 = $db->Selects($Query);
                                            foreach($reg1 as $value1)
                                            {
                                                if($value->Id_Pais == $value1->Id_Pais)
                                                {
                                                    echo "      <option value='".$value1->Id_Pais."' selected>".$value1->Pais."</option>";
                                                }
                                                else
                                                {
                                                    echo "      <option value='".$value1->Id_Pais."'>".$value1->Pais."</option>";
                                                }
                                            }
                            echo "      </select>
                                    </div>
                                    <button type='submit' class='btn btn-outline-danger' href='../Forms/FormEstados.php'>Eliminar Estado</button>
                                    <button type='submit' class='btn btn-outline-secondary' href='../Otros/Estados.php'>Cancelar</button>
                                    <input type='hidden' name='Tipo' value='Eliminar'>
                                    <input type='hidden' name='IdEstado' value='$id_estado'>
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
                $query = "  UPDATE estados
                        SET
                            Estado = '$Estado',
                            Id_Pais = $idpais,
                            FUM                 = NOW()
                        WHERE Id_Estado = $IdEstado";
                $band= $db2->Insert($query);
                switch($band)
                {
                    case 23000:
                        echo "  <br>
                                <div class='container'>
                                    <div class='alert alert-danger'>
                                    <h3>Error al Actualizar Estado</h3>
                                    <p>El Estado que quiere eliminar ya tiene relacion con otras tablas, elimine primero esos registros.</p>
                                    </div>
                                </div>";
                        $db2->DesconectarDB();
                        break;
                    case 42000:
                        echo "  <br>
                                <div class='container'>
                                    <div class='alert alert-danger'>
                                    <h3>Error al Actualizar Estado</h3>
                                    <p>Error de Sintaxis.</p>
                                    </div>
                                </div>";
                        break;
                    default:
                        $db2->DesconectarDB();
                        echo "<br><div class='container'><div class='alert alert-success'>Estado Actualizado</div></div>";
                        echo "<script> setTimeout(function() { window.location = '../Otros/Estados.php'; }, 100); </script>";
                        break;
                }
            }
            else
            {
                $query = "  DELETE FROM estados WHERE Id_Estado = '$IdEstado'";
                $band= $db2->Insert($query);
                switch($band)
                {
                    case 23000:
                        echo "  <br>
                                <div class='container'>
                                    <div class='alert alert-danger'>
                                    <h3>Error al Eliminar Estado</h3>
                                    <p>El Estado que quiere eliminar ya tiene relacion con otras tablas, elimine primero esos registros.</p>
                                    </div>
                                </div>";
                        $db2->DesconectarDB();
                        break;
                    default:
                        echo "<div class='container'><div class='alert alert-success'>Estado Eliminado</div></div>";
                        $db2->DesconectarDB();
                        echo "<script> setTimeout(function() { window.location = '../Otros/Estados.php'; }, 100); </script>";
                        break;
                }
            }
            
        }
        ?>
    <?php include('../../Plantillas/Footer/Footer.php')?>
</body>
</html>