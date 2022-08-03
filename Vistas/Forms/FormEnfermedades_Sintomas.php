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
    <title>Medical Assistent - Relación Enfermedades-Síntomas</title>
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
                            <label class='class-label'>Enfermedad:</label>
                        <?php
                            extract($_GET);
                            $id_sintoma=$_GET['Id_Sintoma'];
                            $id_enfermedad=$_GET['Id_Enfermedad'];
                            $Query="SELECT E.Id_Enfermedad, E.Enfermedad, S.Id_Sintoma, S.Sintoma FROM enfermedades_sintomas ES JOIN enfermedades E ON ES.Id_Enfermedad = E.Id_Enfermedad JOIN sintomas S ON ES.Id_Sintoma = S.Id_Sintoma WHERE ES.Id_Enfermedad = '$id_enfermedad' AND ES.Id_Sintoma = '$id_sintoma'";
                            $reg = $db->Selects($Query);
                            foreach($reg as $valor)
                            {
            echo "          <select name='idenf' class='form-select' required>
                                <option value='$valor->Id_Enfermedad'>$valor->Enfermedad</option>
                            </select>
                        </div>
                        <div class='mb-3 w-100'>
                            <label class='class-label'>Síntoma:</label>
                            <select name='idsin' class='form-select' required>
                                <option value='$valor->Id_Sintoma'>$valor->Sintoma</option>
                            </select>
                        </div>";
                            }
                        ?>
                        <button type='submit' class='btn btn-outline-success' href='FormEnfermedades_Sintomas.php'>Guardar Cambios</button>
                        <button type='submit' class='btn btn-outline-secondary' href='../Otros/Enfermedades_Sintomas.php'>Cancelar</button>
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
            $query = "  DELETE FROM enfermedades_sintomas WHERE Id_Enfermedad = '$idenf' AND Id_Sintoma = '$idsin'";
            $db2->Insert($query);
            echo "<div class='container'><div class='alert alert-success'>Relación Eliminada</div></div>";
            $db2->DesconectarDB();
            echo "<script> setTimeout(function() { window.location = '../Otros/Enfermedades_Sintomas.php'; }, 10); </script>";
        }
        ?>
    <?php include('../../Plantillas/Footer/Footer.php')?>
</body>
</html>