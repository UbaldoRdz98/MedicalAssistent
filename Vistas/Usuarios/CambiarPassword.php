<html>
    <head>
        <meta charset="utf-8">
        <title>Medical Assistent - Actualizar Contraseña</title>
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
        <form action="CambiarPassword.php" method="POST">
            <label for="CorreoElectronico">Correo Electronico:</label>
            <input name="CorreoElectronico" type="text" class="form-control w-75"><br>
            <label for="Password">Nuevo Password:</label>
            <input name="Password" type="password" class="form-control w-75"><br>
            <label for="Codigo">Código de Recuperación:</label>
            <input name="Codigo" type="text" class="form-control w-75"><br>
            <button type="submit" class="btn btn-primary w-10" href="CambiarPassword.php" name='RecP'>Actualizar</button>
        </form>
    <?php
    }
    ?>
    <?php
        if(isset($_POST['RecP'])){
            include '../../Database/Database.php';
            $db=new Database();
            $db->ConectarDB();
            extract($_POST);
            
            $tabla = $db->Selects("SELECT * FROM RecuperarPassword WHERE Usuario = '$CorreoElectronico'");
            
            foreach($tabla as $registro)
            {
                if($registro->Codigo == $Codigo)
                {
                    $hash = password_hash($Password, PASSWORD_DEFAULT);
                    $consulta="UPDATE usuarios SET Password = '$hash' WHERE CorreoElectronico = '$CorreoElectronico'";
                    $db->Insert($consulta);
                    $consulta="DELETE FROM RecuperarPassword WHERE Usuario = '$CorreoElectronico'";
                    $db->Insert($consulta);
                    $db->DesconectarDB();
                    echo "<div class='container'><div class='alert alert-success'> <h2 align='center'>Contraseña Actualizada.</h2> </div></div>";
                    header("Refresh:0; url=Login.php");
                }
                else
                {
                    echo "<div class='container'><div class='alert alert-danger'> <h2 align='center'> Los Códigos no son iguales, verifiquelo.</h2> </div></div>";
                }
            }
        }
    ?>
    </div>
</body>
</html>