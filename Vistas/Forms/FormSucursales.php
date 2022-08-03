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
    <title>Medical Assistent - Sucursales</title>
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
                    <h1>Editar Sucursales</h1>
                    <form method="POST">
                        <div class="mb-3 w-100">
                        <label class='class-label'>Id_Sucursal:</label>
                        <?php
                            extract($_GET);
                            $id_sucursal=$_GET['Sucursal'];
                            $Query="SELECT S.*, edo.Id_Estado, p.Id_Pais, edo.Estado, c.Ciudad FROM sucursales S JOIN empresas E ON S.Id_Empresa = E.Id_Empresa JOIN ciudades c ON S.Id_Ciudad = c.Id_Ciudad JOIN estados edo ON c.Id_Estado = edo.Id_Estado JOIN paises p ON edo.Id_Pais = p.Id_Pais WHERE S.Id_Sucursal = '$id_sucursal'";
                            $reg = $db->Selects($Query);
                            foreach($reg as $valor)
                            {
                                echo "
                                        <input type='text' name='Id_Sucursal' placeholder='Escriba el Nombre Corto de la Sucursal' class='form-control text-uppercase' value='$valor->Id_Sucursal' disabled>
                                    </div>
                                    <div class='mb-3 w-100'>
                                        <label class='class-label'>Nombre:</label>
                                        <input type='text' name='Sucursal' placeholder='Escriba el Nombre Completo de la Sucursal' class='form-control' value='$valor->Sucursal' required>
                                    </div>
                                    <div class='mb-3 w-100'>
                                        <label class='class-label'>Empresa:</label>
                                        <select id='Id_Empresa' name='Id_Empresa' class='form-control mb-4'>";
                                        $db = new database();
                                        $db->ConectarDB();
                                        $Cadena = "SELECT Id_Empresa, Empresa FROM empresas";
                                        $reg = $db->Selects($Cadena);
                                        foreach($reg as $value)
                                        {
                                        if($value->Id_Empresa == $valor->Id_Empresa){
                                            echo    "<option value='".$value->Id_Empresa."' selected>".$value->Empresa."</option>";
                                        }
                                        else
                                        {
                                            echo    "<option value='".$value->Id_Empresa."'>".$value->Empresa."</option>";
                                        }
                                    }
                            echo "  </select>
                                </div>
                                    <div class='mb-3 w-100'>
                                        <label class='class-label'>Estatus:</label>
                                        <select name='Estatus' class='form-select'>";
                                    if($valor->Estatus == 'Activo')
                                    {
                                        echo "  <option value='Activo' Selected>Activo</option>
                                                <option value='Inactivo'>Inactivo</option>";
                                    }
                                    else
                                    {
                                        echo "  <option value='Activo'>Activo</option>
                                                <option value='Inactivo' Selected>Inactivo</option>";
                                    }
                                echo "  </select>
                                    </div>
                                    <div class='mb-3 w-100'>
                                        <label class='class-label'>Calle:</label>
                                        <input type='text' name='Calle' placeholder='Escriba la Calle de la Empresa' class='form-control' value='$valor->Calle' required>
                                    </div>
                                <div class='mb-3 w-100'>
                                    <label class='class-label'>Número Exterior:</label>
                                    <input type='text' name='Numero_Exterior' placeholder='Escriba el Número Exterior' class='form-control w-50' value='$valor->Numero_Exterior'>
                                </div>
                                <div class='mb-3 w-100'>
                                    <label class='class-label'>Número Interior:</label>
                                    <input type='text' name='Numero_Interior' placeholder='Escriba el Número Interior' class='form-control w-50' value='$valor->Numero_Interior'>
                                </div>
                                <div class='mb-3 w-100'>
                                    <label class='class-label'>Colonia:</label>
                                    <input type='text' name='Colonia' placeholder='Escriba la Colonia' class='form-control' value='$valor->Colonia' requiered>
                                </div>
                                <div class='mb-3 w-100'>
                                    <label class='class-label'>Código Postal:</label>
                                    <input type='text' name='CodigoPostal' placeholder='Escriba el Código Postal' class='form-control w-50' value='$valor->CodigoPostal' requiered>
                                </div>
                                <div class='mb-3 w-100'>
                                    <label class='class-label'>País:</label>
                                    <select id='Pais' name='Pais' class='form-control mb-4'>";
                                    $db = new database();
                                    $db->ConectarDB();
                                    $Cadena = "SELECT Id_Pais, Pais FROM paises";
                                    $reg = $db->Selects($Cadena);
                                    foreach($reg as $value)
                                    {
                                        if($value->Id_Pais == $valor->Id_Pais){
                                            echo    "<option value='".$value->Id_Pais."' selected>".$value->Pais."</option>";
                                        }
                                        else
                                        {
                                            echo    "<option value='".$value->Id_Pais."'>".$value->Pais."</option>";
                                        }
                                    }
                            echo "  </select>
                                </div>
                                <div class='mb-3 w-100'>
                                    <label class='class-label'>Estado:</label>
                                    <select id='Estado' name='Estado' class='form-control mb-4'>
                                        <option value='".$valor->Id_Estado."'>".$valor->Estado."</option>
                                    </select>
                                </div>
                                <div class='mb-3 w-100'>
                                    <label class='class-label'>Cíudades:</label>
                                    <select id='Ciudad' name='Ciudad' class='form-control mb-4'>
                                        <option value='".$valor->Id_Ciudad."'>".$valor->Ciudad."</option>
                                    </select>
                                </div>
                                <div class='mb-3 w-100'>
                                    <label class='class-label'>Email:</label>
                                    <input type='text' name='Email' placeholder='Escriba el Email de la empresa' class='form-control' value='$valor->Email'>
                                </div>
                                <div class='mb-3 w-100'>
                                    <label class='class-label'>Email Secundario:</label>
                                    <input type='text' name='EmailSecundario' placeholder='Escriba el Email Secundario de la empresa' class='form-control' value='$valor->EmailSecundario'>
                                </div>
                                <div class='mb-3 w-100'>
                                    <label class='class-label'>Telefono:</label>
                                    <input type='text' name='Telefono' placeholder='Escriba el Telefono de la empresa' class='form-control' value='$valor->Telefono'>
                                </div>
                                <div class='mb-3 w-100'>
                                    <label class='class-label'>Telefono Secundario:</label>
                                    <input type='text' name='TelefonoSecundario' placeholder='Escriba el Telefono Secundario de la empresa' class='form-control'  value='$valor->TelefonoSecundario'>
                                </div>
                                <div class='mb-3 w-100'>
                                    <label class='class-label'>RFC:</label>
                                    <input type='text' name='RFC' placeholder='Escriba el RFC de la empresa' class='form-control' value='$valor->RFC'>
                                </div>
                                <button type='submit' class='btn btn-outline-success' href='../Forms/FormHospitales.php'>Guardar Cambios</button>
                                <button type='submit' class='btn btn-outline-secondary' href='../Empresas/Hospitales.php'>Cancelar</button>
                                <br>
                            </form>
                            <br>
                        </div>";
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
            $query = "  UPDATE sucursales
                        SET
                            Sucursal            = '$Sucursal',
                            Id_Empresa          = '$Id_Empresa',
                            Estatus             = '$Estatus',
                            Calle               = '$Calle',
                            NumeroExterior      = '$Numero_Exterior',
                            NumeroInterior      = '$Numero_Interior',
                            Colonia             = '$Colonia',
                            CodigoPostal        = '$CodigoPostal',
                            Email               = '$Email',
                            EmailSecundario     = '$EmailSecundario',
                            Telefono            = '$Telefono',
                            TelefonoSecundario  = '$TelefonoSecundario',
                            RFC                 = '$RFC',
                            UUM                 = '".$_SESSION["Id_Usuario"]."',
                            FUM                 = NOW()
                        WHERE Id_Sucursal = '".strtoupper($id_sucursal)."'";
                $db2->Insert($query);
                echo "<div class='container'><div class='alert alert-success'>Sucursal Actualizada</div></div>";
                $db2->DesconectarDB();
                echo "<script> setTimeout(function() { window.location = '../Empresas/Sucursales.php'; }, 100); </script>";
            }
        ?>
    <?php include('../../Plantillas/Footer/Footer.php')?>
</body>
</html>