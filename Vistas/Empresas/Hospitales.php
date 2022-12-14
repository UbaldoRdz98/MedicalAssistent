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
    <title>Medical Assistent - Hospitales</title>
    <script language="javascript">
        $(document).ready(function(){
            $("#Pais").change(function () {
                $('#Ciudad').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
                $("#Pais option:selected").each(function () {
					Id_Pais = $(this).val();
					$.post("../Otros/EstadosDatos.php", { Id_Pais: Id_Pais }, function(data){
						$("#Estado").html(data);
					});            
				});
			})
		});
			
		$(document).ready(function(){
			$("#Estado").change(function () {
				$("#Estado option:selected").each(function () {
					Id_Estado = $(this).val();
					$.post("../Otros/CiudadesDatos.php", { Id_Estado: Id_Estado }, function(data){
						$("#Ciudad").html(data);
					});            
				});
			})
		});
	</script>
</head>
<body>
<?php
        session_start();
        if(isset($_SESSION["Usuario"]))
        {
            $date= date('Y-m-d');
            if (($_SESSION["FechaActivo"] > $date) && ($_SESSION["Estatus"] == 'Activo'))
            {
    ?>
        <?php
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
        <h1>Hospitales</h1>
        <form action="Hospitales.php" method="GET">
            <?php
                echo "  <div class='row align-items-start'>
                            <div class='col-1'>
                                <label class='class-label'>Filtrar por:</label>
                                <select class='form-select w-100' aria-label='Default select example' name='filtro'>
                                    <option value='10'selected>10</option>
                                    <option value='25'>25</option>
                                    <option value='50'>50</option>
                                    <option value='100'>100</option>
                                    <option value='All'>Todos</option>
                                </select>
                            </div>
                            <div class='col-1'>
                                <br>
                                <button type='submit' class='btn btn-secondary'>Ver</button>
                            </div>
                        </div>";
                ?>
        </form>
        <br>
        <?php
        if($_GET)
        {
            extract($_GET);
            $conexion = new Database();
            $conexion->ConectarDB();
            
            if($filtro == "All")
            {
                $Query = "SELECT Id_Empresa 'Hospital', Empresa 'Nombre', Estatus FROM empresas limit 100000000000000 ";
            }
            else
            {
                $Query = "SELECT Id_Empresa 'Hospital', Empresa 'Nombre', Estatus FROM empresas limit $filtro ";
            }

            $tabla = $conexion->Selects($Query);
            echo "  <table id='TablaCiudades' class='table table-hover text-center'>
                        <thead class='table-dark'>
                            <tr>
                                <th>Hospital</th>
                                <th>Nombre</th>
                                <th>Estatus</th>
                                <th>Acci??n</th>
                            </tr>
                        </thead>
                        <tbody>";
            foreach($tabla as $registro)
            {
                echo "<tr>
                        <form action='../Forms/FormHospitales.php' method='GET'>
                            <td name='MyTable'>
                                <input type='hidden' name='Hospital' value='$registro->Hospital'>$registro->Hospital</td>
                            </td>
                            <td class='col'>$registro->Nombre</td>
                            <td>$registro->Estatus</td>
                            <td class='col'>
                                <button type='submit' class='btn btn-outline-warning' href='../Forms/FormHospitales.php'>Editar</button>
                            </td>
                            </form>
                        </tr>";
            }
                    echo "</tbody>
                        </table>";
            $conexion->DesconectarDB();
        }   
        ?>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#Nuevo">Nuevo Hospital</button>
        </div>
        <br>
    </div>
    <?php include('../../Plantillas/Footer/Footer.php')?>
    <!--INSERT-->
    <div class="modal fade" id="Nuevo" tabindex="-1" aria-labelledby="NuevoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="NuevoLabel">Nuevo Hospital</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="Hospitales.php" id="modal-hospitales">
                        <div class="mb-3 w-100">
                            <label class='class-label'>Empresa:</label>
                            <input type="text" name="Id_Empresa" placeholder="Escriba el Nombre Corto de la Empresa" class="form-control text-uppercase" required>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Nombre:</label>
                            <input type="text" name="Empresa" placeholder="Escriba el Nombre Completo de la Empresa" class="form-control" required>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Estatus:</label>
                            <select name="Estatus" class="form-select">
                                <option value="Activo" Selected>Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Calle:</label>
                            <input type="text" name="Calle" placeholder="Escriba la Calle de la Empresa" class="form-control" required>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>N??mero Exterior:</label>
                            <input type="text" name="Numero_Exterior" placeholder="Escriba el N??mero Exterior" class="form-control w-50" required>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>N??mero Interior:</label>
                            <input type="text" name="Numero_Interior" placeholder="Escriba el N??mero Interior" class="form-control w-50" requiered>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Colonia:</label>
                            <input type="text" name="Colonia" placeholder="Escriba la Colonia" class="form-control" requiered>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>C??digo Postal:</label>
                            <input type="text" name="CodigoPostal" placeholder="Escriba el C??digo Postal" class="form-control w-50" requiered>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Pa??s:</label>
                            <select id='Pais' name='Pais' class='form-control mb-4'>
                                <?php
                                    $db = new database();
                                    $db->ConectarDB();
                                    $Cadena = "SELECT Id_Pais, Pais FROM paises";
                                    $reg = $db->Selects($Cadena);
                                    foreach($reg as $value)
                                    {
                                        echo    "<option value='".$value->Id_Pais."'>".$value->Pais."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Estado:</label>
                            <select id='Estado' name='Estado' class='form-control mb-4'></select>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>C??udades:</label>
                            <select id='Ciudad' name='Ciudad' class='form-control mb-4'></select>
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Email:</label>
                            <input type="text" name="Email" placeholder="Escriba el Email de la empresa" class="form-control">
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Email Secundario:</label>
                            <input type="text" name="EmailSecundario" placeholder="Escriba el Email Secundario de la empresa" class="form-control">
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Telefono:</label>
                            <input type="text" name="Telefono" placeholder="Escriba el Telefono de la empresa" class="form-control">
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>Telefono Secundario:</label>
                            <input type="text" name="TelefonoSecundario" placeholder="Escriba el Telefono Secundario de la empresa" class="form-control">
                        </div>
                        <div class="mb-3 w-100">
                            <label class='class-label'>RFC:</label>
                            <input type="text" name="RFC" placeholder="Escriba el RFC de la empresa" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" form="modal-hospitales">Guardar</button>
                </div>
                <?php
                    if($_POST)
                    {
                        session_start();
                        $db2 = new Database();
                        $db2->ConectarDB();
                        extract($_POST);
                        $query = "INSERT INTO empresas( Id_Empresa, Empresa, Estatus, Calle,
                                                        Numero_Exterior, Numero_Interior, Colonia, CodigoPostal,
                                                        Id_Ciudad, Email, EmailSecundario, Telefono,
                                                        TelefonoSecundario, RFC, UsuarioCreacion, FechaCreacion,
                                                        UUM, FUM)
                                    VALUES( UPPER('$Id_Empresa'), '$Empresa', '$Estatus', '$Calle',
                                            '$Numero_Exterior', '$Numero_Interior', '$Colonia', '$CodigoPostal',
                                            $Ciudad, '$Email', '$EmailSecundario', '$Telefono',
                                            '$TelefonoSecundario', '$RFC', '".$_SESSION["Id_Usuario"]."', NOW(),
                                            '".$_SESSION["Id_Usuario"]."', NOW())";
                        $db2->Insert($query);
                        echo "<div class='alert alert-success'>Hospital Registrada</div>";
                        header("refresh:1; Hospitales.php");
                        $db2->DesconectarDB();
                    }
                ?>
            </div>
        </div>
    </div>
    <?php
                    break;
                    default:
                        echo "<script> setTimeout(function() { window.location = '../NoAutorizado.php'; }, 10); </script>";
                    break;
                }
            }
        ?>
    <?php
        }
        else
        {
            ?>
            <?php echo "<script> setTimeout(function() { window.location = '../FechaNoValida.php'; }, 0); </script>";
            
        }}
        else
        {
            ?>
            <?php require '../Plantillas/Headers/HeaderIndexLogin.php' ?>
            <?php
        }
    ?>    
</body>
</html>