<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Medical Assistent - Registrate</title>
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <script src="../../js/bootstrap.min.js"></script>
        <link rel="icon" href="../../Imagenes/Logo.png">
        <link rel="stylesheet" href="../../css/medical.css">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

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
    </head>
<body>
    <?php require '../../Plantillas/Headers/Header.php' ?>
    
    <div style="padding: 25px;" class="container w-50">
        <h1>Registrate</h1> <br>
        <?php
            if($_POST)
            {
                include '../../Database/Database.php';
                extract($_POST);

                if($Password == $confirm_password)
                {
                    $db=new Database();
                    $db->ConectarDB();            
                    $hash = password_hash($Password, PASSWORD_DEFAULT);
            
                    $mystring = $CorreoElec;
                    $findme   = '@';
                    $pos = strpos($mystring, $findme);
                    $rest = substr($CorreoElec, 0, $pos - 0);
                    $Cadena=" CALL CreaPaciente ('$rest', '$CorreoElec', '$Empresa', '$Sucursal', '$hash', '$Nombre', '$ApPaterno', '$ApMaterno')";

                    $band = $db->Insert($Cadena);
                    $db->DesconectarDB();
                    if($band == 0)
                    {
                        echo "<div class='alert alert-success' role='alert'> Usuario Creado </div>";
                        header("refresh:0; Login.php");
                    }
                    else
                    {
                        echo "<div class='alert alert-danger' role='alert'> Algo Fallo, Intente de nuevo. </div>";
                    }
                    
                }
                else
                {
                    echo "<div class='alert alert-danger' role='alert'> Las contraseñas ingresadas no coinciden.</div>";
                }
            }
        ?>

        <form action="Registro.php" method="POST">
            <label for="Nombre">Nombre(s):</label>
            <input name="Nombre" id="Nombre" type="text" class="form-control" onkeyup="checkCampos();" required autofocus>
            <span id='message1'></span> 
            <label for="ApPaterno">Apellido Paterno:</label> <br>
            <input name="ApPaterno" id="ApPaterno" type="text" class="form-control" onkeyup="checkCampos();" required autofocus>
            <label for="ApMaterno">Apellido Materno:</label> <br>
            <input name="ApMaterno" id= "ApMaterno" type="text" class="form-control" onkeyup="checkCampos();" required autofocus>
            <label for="Empresa">Hospital:</label>
            <select id='Empresa' name='Empresa' class='form-control' required autofocus>
                <?php
                    include '../../Database/Database.php';
                    $db = new database();
                    $db->ConectarDB();
                    $Cadena = "SELECT Id_Empresa, Empresa FROM empresas";
                    $reg = $db->Selects($Cadena);
                    foreach($reg as $value)
                    {
                        echo    "<option value='".$value->Id_Empresa."'>".$value->Empresa."</option>";
                    }
                ?>
            </select>
            <label for="Sucursal">Sucursal:</label>
            <select id='Sucursal' name='Sucursal' class='form-control' required autofocus></select>
            <label for="CorreoElec">Correo Electronico:</label> <br>
            <input name="CorreoElec" id="CorreoElec" type="text" class="form-control" onkeyup="checkCampos();" required autofocus>
            <label for="Password">Contraseña:</label> <br>
            <input name="Password" id="Password" type="password" onkeyup="checkCampos();" class="form-control" placeholder="" required autofocus>
            <label for="Confirm_Password">Confirme su Contraseña:</label> <br>
            <input type="password" name="confirm_password" id="confirm_password" onkeyup="checkCampos();" class="form-control" required autofocus>
            <br>
            <div class="text-center">
                <span id='message'></span>
            </div>
            <br>
            <div class="text-center">
                <input id="Button" type="submit" value="Registrar" class="btn btn-primary w-25" disabled>
            </div>
            
        </form>
    </div>
    <script type="text/javascript">
        var checkCampos = function()
        {
            if((document.getElementById('Nombre').value == "") || (document.getElementById('ApPaterno').value == "") || (document.getElementById('ApMaterno').value == "") || (document.getElementById('CorreoElec').value == "") || (document.getElementById('Password').value == "") || (document.getElementById('confirm_password').value == ""))
            {
                document.getElementById("Button").disabled = true;
            }
            else
            {
                if(document.getElementById('Password').value == document.getElementById('confirm_password').value)
                {
                    var correo = document.getElementById('CorreoElec').value.includes('@');
                    let termino = ".com";
                    let posicion = document.getElementById('CorreoElec').value.indexOf(termino);
                    if(correo && posicion !== -1)
                    {
                        document.getElementById('message').innerHTML = '';
                        document.getElementById("Button").disabled = false;
                    }
                    else
                    {
                        document.getElementById("Button").disabled = true;
                        document.getElementById('message').innerHTML = 'Ingrese un Correo Electronico admitido.';
                    }                
                }
                else
                {
                    document.getElementById("Button").disabled = true;
                    document.getElementById('message').style.color = 'red';
                    document.getElementById('message').innerHTML = 'Las contraseñas no coinciden';
                }
            }
        }
    </script>
</body>
</html>