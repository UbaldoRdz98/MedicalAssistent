<html>
    <head>
        <meta charset="utf-8">
        <title>Medical Assistent - Recuperar Contraseña</title>
            <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <script src="../../js/bootstrap.min.js"></script>
        <link rel="icon" href="../../Imagenes/Logo.png">
        <link rel="stylesheet" href="../../css/medical.css">
    </head>
<body>
    <?php require '../../Plantillas/Headers/Header.php' ?>
    <div style="padding: 25px;" class="container w-50">
    <?php
        if(isset($_SESSION["Usuario"]))
        {
            echo "  <div class='alert alert-dark'>
                        <h2 align='center'>Ya existe una sesion activa, Usuario: ".$_SESSION["Usuario"]."</h2>
                        <h3 align='center'> <a href='CerrarSesion.php'>[Cerrar Sesión]</a> </h3>";
            echo    "</div>";
        }
        else
        {
    ?>
        <h1>Recuperar Contraseña</h1> <br>
        <form action="RecuperarPassword.php" method="POST">
            <h3>Se enviará un correo con un Código de Seguridad</h3>
            <label for="CorreoElectronico">Correo Electronico:</label> <br>
            <input name="CorreoElectronico" type="text" class="form-control w-75"><br>
            <button type="submit" class="btn btn-primary w-10" href="RecuperarPassword.php" name='RecP'>Recuperar</button>
        </form>
    </div>
    <?php
    }
    ?>
    <?php
        if(isset($_POST['RecP'])){
            include '../../Database/Database.php';
            $db=new Database();
            $db->ConectarDB();
            
            $Cod=$db->ObtenerCodigo();
            extract($_POST);
            
            $consulta="DELETE FROM RecuperarPassword WHERE Usuario = '".$CorreoElectronico."'";
            $db->Insert($consulta);
            $consulta="INSERT INTO RecuperarPassword VALUES('".$CorreoElectronico."', '".$Cod."', NOW())";
            $db->Insert($consulta);

            $db->RecuperarPassword($CorreoElectronico, $Cod);
            
            $db->DesconectarDB($CorreoElectronico, $Cod);
            header("Refresh:0; url=CambiarPassword.php");
        }
    ?>
</body>
</html>