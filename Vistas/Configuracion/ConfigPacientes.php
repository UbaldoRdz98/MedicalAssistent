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
    <title>Medical Assistent - Configuración de Usuario</title>
</head>
<body>
    <?php
        session_start();
        if(isset($_SESSION["Usuario"]))
        {
            if(($_SESSION["Estatus"] == 'Activo') && ($_SESSION["FechaActivo"] > date('Y-m-d')))
            {
                if($_SESSION["TipoUsuario"] == 'Paciente')
                {
                    require '../../Plantillas/Headers/Pacientes/HeaderPacientes.php';
        ?>
        <div class='container'>
            <h1>Configuración del Empleado</h1>
            <form method='POST'>
                <div class='mb-3 w-100'>
                    <label class='class-label'>Id_Usuario:</label>
                    <?php
                echo "
                    <input type='text' name='Id_Usuario' class='form-control text-uppercase' value='".$_SESSION["Id_Usuario"]."' disabled>
                </div>
                <div class='mb-3 w-100'>
                    <label class='class-label'>Usuario:</label>
                    <input type='text' name='Usuario' class='form-control' value='".$_SESSION["Usuario"]."' disabled>
                </div>
                <div class='mb-3 w-100'>
                    <label class='class-label'>Correo Electronico:</label>
                    <input type='text' name='CorreoElectronico' class='form-control' value='".$_SESSION["CorreoElectronico"]."'>
                </div>
                <div class='mb-3 w-100'>
                    <label class='class-label'>Password:</label>
                    <input type='Password' name='Password' class='form-control text-uppercase'>
                </div>
                <button type='submit' class='btn btn-outline-success' href='ConfigEmpleados.php'>Guardar Cambios</button>
                <button type='button' class='btn btn-outline-secondary' onclick='window.history.back();'>Cancelar</button>
            </form>
                ";
                ?>
                </div>
                

            
        <?php
                }
                else
                {
                    echo "<script> setTimeout(function() { window.location = '../NoAutorizado.php'; }, 10); </script>";
                }
            }
            else
            {
                echo "<script> setTimeout(function() { window.location = '../FechaNoValida.php'; }, 10); </script>";
            }
        }
    ?>
    <?php include('../../Plantillas/Footer/Footer.php')?>
    <?php
        if($_POST)
        {
            include '../../Database/Database.php';
            $db = new Database();
            $db->ConectarDB();
            extract($_POST);
            $mystring = $CorreoElectronico;
            $findme   = '@';
            $pos = strpos($mystring, $findme);
            $rest = substr($CorreoElectronico, 0, $pos - 0);
            
            if($Password != '')
            {
                $hash = password_hash($Password, PASSWORD_DEFAULT);
                $Cadena="UPDATE usuarios SET Usuario = '$rest', CorreoElectronico = '$CorreoElectronico', Password = '$hash' WHERE Id_Usuario = ".$_SESSION["Id_Usuario"]."";
            }
            else
            {
                $Cadena="UPDATE usuarios SET Usuario = '$rest', CorreoElectronico = '$CorreoElectronico' WHERE Id_Usuario = ".$_SESSION["Id_Usuario"]."";
            }
            
            $band = $db->Insert($Cadena);
            $db->DesconectarDB();
            
            if($band == 0)
            {
                echo "<script type='text/javascript'>
                        alert('Usuario Actualizado, necesita Iniciar Sesión de nuevo para aplicar los cambios.');
                        window.location.href='../CerrarSesion.php';
                    </script>";
            }
            else
            {
                echo "<div class='alert alert-danger' role='alert'> Algo Fallo, Intente de nuevo. </div>";
            }
        }
    ?>
    </div>
</body>
</html>