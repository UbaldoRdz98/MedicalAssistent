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
    <script language="javascript">
        $(document).ready(function(){
            $("#Empresa").change(function () {
				$("#Empresa option:selected").each(function () {
					Id_Empresa = $(this).val();
					$.post("../Otros/SucursalesDatos.php", { Id_Empresa: Id_Empresa }, function(data){
						$("#Sucursal").html(data);
					});            
				});
			})
		});
	</script>
    <title>Medical Assistent - Usuarios</title>
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
                    <h1>Editar Usuario</h1>
                    <form method="POST">
                        <div class="mb-3 w-100">
                            <label class='class-label'>Id_Usuario:</label>
                        <?php
                            extract($_GET);
                            $id_usuario=$_GET['Usuario'];
                            $Query="SELECT * FROM usuarios WHERE Id_Usuario = '$id_usuario'";
                            $reg = $db->Selects($Query);
                            foreach($reg as $valor)
                            {
            echo "          <input type='text' name='id_usu' class='form-control' value='$id_usuario' disabled>
                        </div>
                        <div class='mb-3 w-100'>
                            <label class='class-label'>Usuario:</label>
                            <input type='text' name='Usuario' class='form-control' value='$valor->Usuario' disabled>
                        </div>
                        <div class='mb-3 w-100'>
                            <label class='class-label'>Correo Electronico:</label>
                            <input type='text' name='CorreoElectronico' class='form-control' value='$valor->CorreoElectronico' disabled>
                        </div>
                        <div class='mb-3 w-100'>
                            <label class='class-label'>Estatus:</label>
                            <select name='Estatus' class='form-select'>";
                                if($valor->Estatus == 'Activo')
                                {
                            echo "  <option value='Activo' Selected>Activo</option>
                                    <option value='Inactivo'>Inactivo</option>
                                    <option value='Proceso'>En Proceso</option>";
                                }
                                elseif($valor->Estatus == 'Inactivo')
                                {
                            echo "  <option value='Activo'>Activo</option>
                                    <option value='Inactivo' Selected>Inactivo</option>
                                    <option value='Proceso'>En Proceso</option>";
                                }
                                else
                                {
                            echo "  <option value='Activo'>Activo</option>
                                    <option value='Inactivo'>Inactivo</option>
                                    <option value='Proceso' Selected>En Proceso</option>";
                                }
                    echo "  </select>
                        </div>
                        <div class='mb-3 w-100'>
                            <label class='class-label'>Empresa:</label>
                            <select name='Empresa' class='form-select'>";
                                $db = new database();
                                $db->ConectarDB();
                                if($_SESSION["Id_Empresa"] != '')
                                {
                                    $Cadena = "SELECT Id_Empresa, Empresa FROM empresas WHERE Id_Empresa = '".$_SESSION["Id_Empresa"]."'";
                                }
                                else
                                {
                                    $Cadena = "SELECT Id_Empresa, Empresa FROM empresas";
                                }
                                $reg = $db->Selects($Cadena);
                                foreach($reg as $value)
                                {
                                    if($value->Id_Empresa == $valor->Id_Empresa)
                                    {
                                        echo    "<option value='".$value->Id_Empresa."' Selected>".$value->Empresa."</option>";
                                    }
                                    else
                                    {
                                        echo    "<option value='".$value->Id_Empresa."'>".$value->Empresa."</option>";
                                    }
                                    
                                }
                    echo "  </select>
                        </div>
                        <div class='mb-3 w-100'>
                            <label for='Sucursal'>Sucursal:</label>
                            <select id='Sucursal' name='Sucursal' class='form-control' required autofocus>";
                            $db = new database();
                            $db->ConectarDB();
                            if($_SESSION["Id_Sucursal"] != '')
                            {
                                $Cadena = "SELECT Id_Sucursal, Sucursal FROM sucursales WHERE Id_Sucursal = '".$_SESSION['Id_Sucursal']."'";
                            }
                            else
                            {
                                $Cadena = "SELECT Id_Sucursal, Sucursal FROM sucursales";
                            }
                            $reg = $db->Selects($Cadena);
                            foreach($reg as $value)
                            {
                                if($value->Id_Sucursal == $valor->Id_Sucursal)
                                {
                                    echo    "<option value='".$value->Id_Sucursal."' Selected>".$value->Sucursal."</option>";
                                }
                                else
                                {
                                    echo    "<option value='".$value->Id_Sucursal."'>".$value->Sucursal."</option>";
                                }
                                
                            }
                echo "  </select>
                        </div>
                        <div class='mb-3 w-100'>
                            <label for='FechaActivo'>Activo Hasta:</label>
                            <input type='date' name='FechaActivo'
                            value='$valor->FechaActivo' min='".date('Y-m-d')."' max='2030-12-31' class='form-control' required>
                        </div>
                        <div class='mb-3 w-100'>
                            <label for='TipoUsuario'>Tipo de Usuario:</label>
                            <select name='TipoUsuario' class='form-control' required autofocus>";
                            switch($valor->TipoUsuario)
                            {
                                case 'Admin':
                                    echo    "   <option value='Admin' Selected>Administrador</option>
                                            <option value='Doctor'>Doctor</option>
                                            <option value='Analista'>Analista</option>
                                            <option value='Paciente'>Paciente</option>";
                                    break;
                                case 'Doctor':
                                echo    "   <option value='Admin'>Administrador</option>
                                            <option value='Doctor' Selected>Doctor</option>
                                            <option value='Analista'>Analista</option>
                                            <option value='Paciente'>Paciente</option>";
                                    break;
                            case 'Analista':
                                echo    "   <option value='Admin'>Administrador</option>
                                            <option value='Doctor'>Doctor</option>
                                            <option value='Analista' Selected>Analista</option>
                                            <option value='Paciente'>Paciente</option>";
                                    break;
                            default:
                                echo    "   <option value='Admin'>Administrador</option>
                                            <option value='Doctor'>Doctor</option>
                                            <option value='Analista'>Analista</option>
                                            <option value='Paciente' Selected>Paciente</option>";
                                    break;
                            }
                echo "  </select>
                        </div>";
                            }
                        ?>
                        <button type='submit' class='btn btn-outline-success' href='FormUsuariosAdmin.php'>Guardar Cambios</button>
                        <button type='submit' class='btn btn-outline-secondary' href='../Usuarios/Usuarios.php'>Cancelar</button>
                        <br>
                    </form>
                    <br>
                
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
            $query = "  UPDATE usuarios
                        SET
                                Estatus     = '$Estatus',
                                Id_Empresa  = '$Empresa',
                                Id_Sucursal = '$Sucursal',
                                FechaActivo = '$FechaActivo',
                                TipoUsuario = '$TipoUsuario'
                        WHERE Id_Usuario    = $id_usuario";
            $err=$db2->Insert($query);

            if($err == 0)
            {
                echo "<div class='container'><div class='alert alert-success'>Usuario Actualizado</div></div>";
                $db2->DesconectarDB();
                echo "<script> setTimeout(function() { window.location = '../Usuarios/Usuarios.php'; }, 10); </script>";
            }
            else
            {
                switch($err)
                            {
                                case 23000:
                                    echo "  <div class='alert alert-danger'>
                                                <h1>ERROR</h1>
                                                <p>El Correo Electronico ya ha sido Registrado</p>
                                            </div>";
                                    break;
                                case 42000:
                                    echo "  <div class='alert alert-danger'>
                                                <h1>ERROR</h1>
                                                <p>Error de Sintaxis</p>
                                            </div>";
                                        break;
                                default:
                                    echo "  <div class='alert alert-danger'>
                                                <h1>ERROR</h1>
                                                <p>El Correo Electronico ya ha sido Registrado</p>
                                            </div>";
                                    break;
                            }
            }
            
        }
        ?>
    </div>
    <?php include('../../Plantillas/Footer/Footer.php')?>
</body>
</html>