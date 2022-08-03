<html>
  <head>
    <meta charset="utf-8">
    <title>Inicia Sesión</title>
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
      <div class='text-center'>
        <h1>Inicio de Sesión</h1> <br>
        <form action="Login.php" method="POST">
          <label for="CorreoElectronico">Correo Electronico:</label> <br>
          <input name="CorreoElectronico" type="text" class="form-control w-75" style="display: block; margin-right: auto; margin-left: auto;"><br>
          <label for="Password">Contraseña:</label> <br>
          <input name="Password" type="password" class="form-control w-75" style="display: block; margin-right: auto; margin-left: auto;"><br>
          <button type="submit" class="btn btn-primary w-10" href="Login.php" name='Login'>Iniciar Sesión</button>
        </form>
        <div>
          <button type="button" class="btn btn-secondary w-10" onclick="location.href='RecuperarPassword.php'">Recuperar Contraseña</button>
        </div>
    </div>
    <?php
    }
    ?>
    <?php
      if(isset($_POST['Login'])){
        include '../../Database/Database.php';
        $db=new Database();
        $db->ConectarDB();

        extract($_POST);

        $findme = '@';
        $pos = strpos($CorreoElectronico, $findme);
        $rest = substr($CorreoElectronico, 0, $pos - 0);
        
        $db->Verificarlogin("$rest","$Password");
        $db->DesconectarDB();
      }
    ?>
  </body>
</html>