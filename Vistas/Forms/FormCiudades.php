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
    <title>Medical Assistent - Ciudades</title>
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
                        $id_ciudad=$_GET['Id_Ciudad'];
                        if(isset($_GET['btned']))
                        {
                            echo "  <h1>Editar Ciudades</h1>
                                <form method='POST'>
                                    <div class='mb-3 w-100'>
                                        <label class='class-label'>Id_Ciudad:</label>";
                                        $Query="SELECT c.Id_Ciudad, c.Ciudad, e.Id_Estado, e.Estado, p.Id_Pais, p.Pais FROM ciudades c JOIN estados e ON c.Id_Estado = e.Id_Estado JOIN paises p ON e.Id_Pais = p.Id_Pais WHERE Id_Ciudad = $id_ciudad";
                                        $reg = $db->Selects($Query);
                                        foreach($reg as $value)
                                        {
                                echo "      <input type='text' name='Id_Ciudad' placeholder='Escriba el Nombre Corto de la Sucursal' class='form-control text-uppercase' value='$id_ciudad' disabled>
                                        </div>
                                        <div class='mb-3 w-100'>
                                            <label class='class-label'>Nombre:</label>
                                            <input type='text' name='Ciudad' placeholder='Escriba el Nombre de la Cíudad' class='form-control' value='$value->Ciudad' required>
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
                                    <div class='mb-3 w-100'>
                                            <label class='class-label'>Estado:</label>
                                            <select name='idestado' class='form-select' required>";
                                            $Query="SELECT * FROM estados";
                                            $reg1 = $db->Selects($Query);
                                            foreach($reg1 as $value1)
                                            {
                                                if($value->Id_Estado == $value1->Id_Estado)
                                                {
                                                    echo "      <option value='".$value1->Id_Estado."' selected>".$value1->Estado."</option>";
                                                }
                                                else
                                                {
                                                    echo "      <option value='".$value1->Id_Estado."'>".$value1->Estado."</option>";
                                                }
                                            }
                            echo "      </select>
                                    </div>
                                        <button type='submit' class='btn btn-outline-success' href='../Forms/FormCiudades.php'>Guardar Cambios</button>
                                        <button type='submit' class='btn btn-outline-secondary' href='../Otros/Ciudades.php'>Cancelar</button>
                                        <input type='hidden' name='Tipo' value='Editar'>
                                        <input type='hidden' name='IdCiudad' value='$id_ciudad'>
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
                            <label class='class-label'>Id_Ciudad:</label>";
                            $Query="SELECT c.Id_Ciudad, c.Ciudad, e.Id_Estado, e.Estado, p.Id_Pais, p.Pais FROM ciudades c JOIN estados e ON c.Id_Estado = e.Id_Estado JOIN paises p ON e.Id_Pais = p.Id_Pais WHERE Id_Ciudad = $id_ciudad";
                            $reg = $db->Selects($Query);
                            foreach($reg as $value)
                            {
                    echo "      <input type='text' name='Id_Ciudad' placeholder='Escriba el Nombre Corto de la Sucursal' class='form-control text-uppercase' value='$id_ciudad' disabled>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>Nombre:</label>
                                <input type='text' name='Ciudad' placeholder='Escriba el Nombre de la Cíudad' class='form-control' value='$value->Ciudad' disabled required>
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
                        <div class='mb-3 w-100'>
                                <label class='class-label'>Estado:</label>
                                <select name='idestado' class='form-select' disabled required>";
                                $Query="SELECT * FROM estados";
                                $reg1 = $db->Selects($Query);
                                foreach($reg1 as $value1)
                                {
                                    if($value->Id_Estado == $value1->Id_Estado)
                                    {
                                        echo "      <option value='".$value1->Id_Estado."' selected>".$value1->Estado."</option>";
                                    }
                                    else
                                    {
                                        echo "      <option value='".$value1->Id_Estado."'>".$value1->Estado."</option>";
                                    }
                                }
                echo "      </select>
                        </div>
                        <button type='submit' class='btn btn-outline-danger' href='../Forms/FormCiudades.php'>Eliminar Cíudad</button>
                        <button type='submit' class='btn btn-outline-secondary' href='../Otros/Ciudades.php'>Cancelar</button>
                        <input type='hidden' name='Tipo' value='Eliminar'>
                        <input type='hidden' name='IdCiudad' value='$id_ciudad'>
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
                $query = "  UPDATE ciudades
                        SET
                            Ciudad = '$Ciudad',
                            Id_Estado = $idestado,
                            FUM                 = NOW()
                        WHERE Id_Ciudad = $IdCiudad";
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
                        echo "<script> setTimeout(function() { window.location = '../Otros/Ciudades.php'; }, 100); </script>";
                        break;
                }
            }
            else
            {
                $query = "  DELETE FROM ciudades WHERE Id_Ciudad = $IdCiudad";
                $band= $db2->Insert($query);
                switch($band)
                {
                    case 23000:
                        echo "  <br>
                                <div class='container'>
                                    <div class='alert alert-danger'>
                                    <h3>Error al Eliminar Cíudad</h3>
                                    <p>La Cíudad que quiere eliminar ya tiene relacion con otras tablas, elimine primero esos registros.</p>
                                    </div>
                                </div>";
                        $db2->DesconectarDB();
                        break;
                    default:
                        echo "<br><div class='container'><div class='alert alert-success'>Cíudad Eliminada</div></div>";
                        $db2->DesconectarDB();
                        echo "<script> setTimeout(function() { window.location = '../Otros/Ciudades.php'; }, 100); </script>";
                        break;
                }
            }
            
        }
        ?>
    <?php include('../../Plantillas/Footer/Footer.php')?>
</body>
</html>