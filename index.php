<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
    <link rel="icon" href="Imagenes/Logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">    
    <link rel="stylesheet" href="css/medical.css">
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
                    require 'Plantillas/Headers/Admins/HeaderAdmins.php';
                break;
                case 'Doctor':
                    require 'Plantillas/Headers/Empleados/HeaderEmpleadosIndex.php';
                break;
                case 'Analista':
                    require 'Plantillas/Headers/Empleados/HeaderEmpleadosIndex.php';
                break;
                case 'Paciente':
                    require 'Plantillas/Headers/Pacientes/HeaderPacientesIndex.php';
                break;
                default:
                    require 'Plantillas/Headers/HeaderIndex.php';
                break;
            }
        ?>
    <?php
        }
        else
        {
            ?>
            <?php require 'Plantillas/Headers/HeaderIndexLogin.php' ?>
            <?php
        }
    ?>
    <br>
    <div class="row mb-2" style="width: 90%; margin-left: 7%">
        <h1>¿Que es Medical Assistent?</h1>
    </div>
    <div class="row mb-2" style="width: 90%; margin: auto;">
        <div class="col-md-6">
            <div class="container" style="width: 100%; margin: 2%;">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="Imagenes/Clinica.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="Imagenes/Clinica2.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="Imagenes/Clinica3.jpg" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="container" style="width: 100%;"></div>
                <div class="card text-white bg-dark mb-3 w-100" style="margin: 4%;">
                    <div class="card-header"><h5>Soluciones para Consultorios u Hospitales</h5></div>
                    <div class="card-body">
                        <h6>
                        Médical Asistent es una plataforma pensada para agilizar la respuesta a las enfermedades de pacientes canalizándo la información en citas agendadas en el horario disponible de un doctor especializado en el campo dependiendo de los síntomas que sean indicados por el paciente.
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('Plantillas/Footer/Footer.php') ?>
</body>
</html>