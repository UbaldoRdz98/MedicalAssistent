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
    <title>Medical Assistent - Empleados</title>
    <script language="javascript">
        $(document).ready(function(){
            $("#Pais").change(function () {
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

    <script language="javascript">
        $(document).ready(function(){
            $("#PaisDom").change(function () {
					$("#PaisDom option:selected").each(function () {
						Id_PaisDom = $(this).val();
						$.post("../Otros/EstadosDatos.php", { Id_Pais: Id_PaisDom }, function(data){
							$("#EstadoDom").html(data);
						});            
					});
				})
			});
			
			$(document).ready(function(){
				$("#EstadoDom").change(function () {
					$("#EstadoDom option:selected").each(function () {
						Id_EstadoDom = $(this).val();
						$.post("../Otros/CiudadesDatos.php", { Id_Estado: Id_EstadoDom }, function(data){
							$("#CiudadDom").html(data);
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
                        <h1>Editar Empleado</h1>
                        <form method="POST">
                            <div class='mb-3 w-100'>
                                <label class='class-label'>Departamento:</label>
                                <select name='Departamento' class='form-select'>
                            <?php
                                extract($_GET);
                                $id_empleado=$_GET['Id_Empleado'];
                                $Query="CALL BuscaEmpleado($id_empleado)";
                                $reg = $db->Selects($Query);
                                foreach($reg as $valor)
                                {
                                    $db = new database();
                                    $db->ConectarDB();
                                    $Cadena = "SELECT Id_Departamento, Departamento FROM departamentos";
                                    $reg = $db->Selects($Cadena);
                                    foreach($reg as $value)
                                    {
                                        if($valor->Departamento == $value->Departamento)
                                        {
                                            echo    "<option value='".$value->Id_Departamento."' selected>".$value->Departamento."</option>";
                                        }
                                        else
                                        {
                                            echo    "<option value='".$value->Id_Departamento."'>".$value->Departamento."</option>";
                                        }
                                    }
                        echo "  </select>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>Puesto:</label>
                                <select name='Puesto' class='form-select'>";
                                    $db = new database();
                                    $db->ConectarDB();
                                    $Cadena = "SELECT Id_Puesto, Puesto FROM puestos";
                                    $reg = $db->Selects($Cadena);
                                    foreach($reg as $value)
                                    {
                                        if($valor->Puesto == $value->Puesto)
                                        {
                            echo "  <option value='".$value->Id_Puesto."' selected>".$value->Puesto."</option>";
                                        }
                                        else
                                        {
                            echo "  <option value='".$value->Id_Puesto."'>".$value->Puesto."</option>";
                                        }
                                    }
                        echo "  </select>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>Nombre:</label>
                                <input type='text' name='Nombre' placeholder='Escriba el Nombre Completo del Empleado' class='form-control' value='$valor->Nombre' required>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>Apellido Paterno:</label>
                                <input type='text' name='ApellidoPaterno' placeholder='Escriba el Apellido Paterno del Empleado' class='form-control' value='$valor->ApellidoPaterno' required>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>Apellido Materno:</label>
                                <input type='text' name='ApellidoMaterno' placeholder='Escriba el Apellido Materno del Empleado' class='form-control' value='$valor->ApellidoMaterno' required>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>Fecha de Nacimiento:</label>
                                <input type='date' name='FechaNacimiento'
                                    value='$valor->FechaNacimiento' max='"; echo date('Y-m-d'); echo "' class='form-control w-50' required>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>CURP:</label>
                                <input type='text' name='CURP' placeholder='Escriba la CURP del Empleado' class='form-control' value='$valor->CURP'>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>RFC:</label>
                                <input type='text' name='RFC' placeholder='Escriba el RFC del Empleado' class='form-control' value='$valor->RFC'>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>N??mero de Seguro Social:</label>
                                <input type='text' name='NoSeguroSocial' placeholder='Escriba el N??mero de Seguro Social del Empleado' class='form-control' value='$valor->NoSeguroSocial'>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>Estado Civil:</label>
                                <select name='EstadoCivil' class='form-select'>";
                                    switch($valor->EstadoCivil)
                                    {
                                        case 'Soltero':
                                            echo "  <option value='Soltero' selected>Soltero(a)</option>
                                                    <option value='Casado'>Casado(a)</option>
                                                    <option value='Divorciado'>Divorciado(a)</option>
                                                    <option value='Viudo'>Viudo(a)</option>
                                                    <option value='UnionLibre'>Uni??n Libre</option>";
                                            break;
                                        case 'Casado':
                                            echo "  <option value='Soltero'>Soltero(a)</option>
                                                    <option value='Casado' selected>Casado(a)</option>
                                                    <option value='Divorciado'>Divorciado(a)</option>
                                                    <option value='Viudo'>Viudo(a)</option>
                                                    <option value='UnionLibre'>Uni??n Libre</option>";
                                            break;
                                        case 'Divorciado':
                                            echo "  <option value='Soltero'>Soltero(a)</option>
                                                    <option value='Casado'>Casado(a)</option>
                                                    <option value='Divorciado' selected>Divorciado(a)</option>
                                                    <option value='Viudo'>Viudo(a)</option>
                                                    <option value='UnionLibre'>Uni??n Libre</option>";
                                            break;
                                        case 'Viudo':
                                            echo "  <option value='Soltero'>Soltero(a)</option>
                                                    <option value='Casado'>Casado(a)</option>
                                                    <option value='Divorciado'>Divorciado(a)</option>
                                                    <option value='Viudo' selected>Viudo(a)</option>
                                                    <option value='UnionLibre'>Uni??n Libre</option>";
                                            break;
                                        default:
                                            echo "  <option value='Soltero'>Soltero(a)</option>
                                                    <option value='Casado'>Casado(a)</option>
                                                    <option value='Divorciado'>Divorciado(a)</option>
                                                    <option value='Viudo'>Viudo(a)</option>
                                                    <option value='UnionLibre' selected>Uni??n Libre</option>";
                                            break;
                                    }
                        echo "  </select>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>Sexo:</label>
                                <select name='Sexo' class='form-select'>";
                                    switch($valor->Sexo)
                                    {
                                        case 'Masculino':
                                            echo "  <option value='Masculino' Selected>Masculino</option>
                                                    <option value='Femenino'>Femenino</option>
                                                    <option value='Otro'>Otro</option>";
                                            break;
                                        case 'Femenino':
                                            echo "  <option value='Masculino'>Masculino</option>
                                                    <option value='Femenino' Selected>Femenino</option>
                                                    <option value='Otro'>Otro</option>";
                                            break;
                                        default:
                                            echo "  <option value='Masculino'>Masculino</option>
                                                    <option value='Femenino'>Femenino</option>
                                                    <option value='Otro' Selected>Otro</option>";
                                            break;
                                    }
                        echo "  </select>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>Tel??fono:</label>
                                <input type='text' name='Telefono1' placeholder='Escriba el Tel??fono del Empleado' class='form-control' value='$valor->Telefono1' required>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>Tel??fono Secundario:</label>
                                <input type='text' name='Telefono2' placeholder='Escriba el Tel??fono Secundario del Empleado' class='form-control' value='$valor->Telefono2'>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>Pa??s de Nacimiento:</label>
                                <select id='Pais' name='Pais' class='form-control mb-4'>";
                                    $db = new database();
                                    $db->ConectarDB();
                                    $Cadena = "SELECT Id_Pais, Pais FROM paises";
                                    $reg = $db->Selects($Cadena);
                                    foreach($reg as $value)
                                    {
                                        if($valor->PaisNacimiento == $value->Pais)
                                        {
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
                                <label class='class-label'>Estado de Nacimiento:</label>
                                <select id='Estado' name='Estado' class='form-control mb-4'>
                                    <option value='".$valor->Id_EstadoNac."' selected>".$valor->EstadoNacimiento."</option>
                                </select>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>C??udad de Nacimiento:</label>
                                <select id='Ciudad' name='CiudadNacimiento' class='form-control mb-4'>
                                    <option value='".$valor->Id_CiudadNac."' selected>".$valor->CiudadNacimiento."</option>
                                </select>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>Calle:</label>
                                <input type='text' name='Calle' placeholder='Escriba la Calle del Empleado' class='form-control' value='$valor->Calle' required>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>N??mero Interior:</label>
                                <input type='text' name='NumInterior' placeholder='Escriba el N??mero Interior del Domicilio del Empleado' class='form-control' value='$valor->NumInterior' required>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>N??mero Exterior:</label>
                                <input type='text' name='NumExterior' placeholder='Escriba el N??mero Exterior del Domicilio del Empleado' class='form-control' value='$valor->NumExterior'>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>Colonia:</label>
                                <input type='text' name='Colonia' placeholder='Escriba la Colonia del Domicilio del Empleado' class='form-control' value='$valor->Colonia' required>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>C??digo Postal:</label>
                                <input type='text' name='CodigoPostal' placeholder='Escriba el C??digo Postal del Domicilio del Empleado' class='form-control' value='$valor->CodigoPostal' required>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>Pa??s de Domicilio:</label>
                                <select id='PaisDom' name='PaisDom' class='form-control mb-4'>";
                                    $db = new database();
                                    $db->ConectarDB();
                                    $Cadena = "SELECT Id_Pais, Pais FROM paises";
                                    $reg = $db->Selects($Cadena);
                                    foreach($reg as $value)
                                    {
                                        if($valor->PaisDomicilio == $value->Pais)
                                        {
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
                                <label class='class-label'>Estado de Domicilio:</label>
                                <select id='EstadoDom' name='EstadoDom' class='form-control mb-4'>
                                    <option value='".$valor->Id_EstadoDom."' selected>".$valor->EstadoDomicilio."</option>
                                </select>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>C??udad de Domicilio:</label>
                                <select id='CiudadDom' name='CiudadDomicilio' class='form-control mb-4'>
                                    <option value='".$valor->Id_CiudadDom."' selected>".$valor->CiudadDomicilio."</option>
                                </select>
                            </div>
                            <div class='mb-3 w-100'>
                                <label class='class-label'>Tipo de Sangre:</label>
                                <input type='text' name='TipoSangre' placeholder='Escriba el Tipo de Sangre del Empleado' class='form-control' value='$valor->TipoSangre'>
                            </div>";
                }
                    ?>
                        <button type="submit" class='btn btn-outline-success' href='FormEnfermedades_Sintomas.php'>Guardar Cambios</button>
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
            $query = "  UPDATE empleados
                        SET
                            Id_Departamento = '$Departamento', Id_Puesto =  $Puesto, Nombre = '$Nombre',
                            ApellidoPaterno = '$ApellidoPaterno', ApellidoMaterno = '$ApellidoMaterno', FechaNacimiento = '$FechaNacimiento',
                            CURP = '$CURP', RFC = '$RFC', NoSeguroSocial = '$NoSeguroSocial', EstadoCivil = '$EstadoCivil',
                            Sexo = '$Sexo', Telefono1 = '$Telefono1', Telefono2 = '$Telefono2',
                            CiudadNacimiento =  $CiudadNacimiento, Calle = '$Calle', NumInterior = '$NumInterior',
                            NumExterior = '$NumExterior', Colonia = '$Colonia', CodigoPostal = '$CodigoPostal',
                            CiudadDomicilio = $CiudadDomicilio, TipoSangre = '$TipoSangre', FUM = NOW(),
                            UUM                 = ".$_SESSION['Id_Usuario']."
                        WHERE Id_Empleado = $id_empleado";
            $band = $db2->Insert($query);
            if($band==0)
            {
                echo "<div class='container'><div class='alert alert-success'>Empleado Actualizado</div></div>";
                $db2->DesconectarDB();
                echo "<script> setTimeout(function() { window.location = '../Empresas/Empleados.php'; }, 10); </script>";
            }
            else
            {
                echo "<div class='container'>
                        <div class='alert alert-success'>
                            <h3>Error al Actualizar Empleado</h3>
                        </div>
                    </div>";
                $db2->DesconectarDB();
            }
        }
        ?>
    <?php include('../../Plantillas/Footer/Footer.php')?>
</body>
</html>