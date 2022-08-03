<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../index.php">Medical Assistent</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php
                    session_start();
                    if(isset($_SESSION["Usuario"]))
                    {
                        echo "  <ul class='navbar-nav ms-auto mb-2 mb-lg-0'>
                                    <li class='nav-item'>
                                        <a class='nav-link' href='../../Vistas/CerrarSesion.php'>Cerrar Sesión</a>
                                    </li>
                                </ul>";
                    }
                    else
                    {
                        echo "  <ul class='navbar-nav ms-auto mb-2 mb-lg-0'>
                                    <li class='nav-item'>
                                        <a class='nav-link' href='../../Vistas/Usuarios/Login.php'>Iniciar Sesión</a>
                                    </li>
                                    <li class='nav-item'>
                                        <a class='nav-link' href='../../Vistas/Usuarios/Registro.php'>Registrarse</a>
                                    </li>
                                </ul>";
                    }
                    ?>
            </div>
        </div>
    </nav>
</header>