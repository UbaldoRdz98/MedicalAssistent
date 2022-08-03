<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <script src="../../js/bootstrap.min.js"></script>
    <link rel="icon" href="../../Imagenes/Logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">    
    <link rel="stylesheet" href="../../css/medical.css">
    <title>Medical Assistent</title>
</head>
<body>
    <?php
        session_start();
        if(isset($_SESSION["Usuario"]))
        {
    ?>
        <?php
            switch($_SESSION["TipoUsuario"])
            {
                case 'Admin':
                    require '../../Plantillas/Headers/Admins/HeaderAdmins.php';
                break;
                case 'Doctor':
                    require '../../Plantillas/Headers/Empleados/HeaderEmpleadosIndex.php';
                break;
                case 'Analista':
                    require '../../Plantillas/Headers/Empleados/HeaderEmpleadosIndex.php';
                break;
                case 'Paciente':
                    require '../../Plantillas/Headers/Pacientes/HeaderPacientesIndex.php';
                break;
                default:
                    require '../../Plantillas/HeaderPresentacion.php';
                break;
            }
        ?>
    <?php
        }
        else
        {
            ?>
            <?php require '../../Plantillas/Headers/HeaderPresentacion.php' ?>
            <?php
        }
    ?>
    <br>
    
    <?php include('../../Plantillas/Footer/Footer.php') ?>
</body>
</html>