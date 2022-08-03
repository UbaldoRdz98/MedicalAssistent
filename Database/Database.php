<?php
class Database{
    private $PDOLocal;
    private $server = 'mysql:host=3.83.80.171:3306; dbname=medicalassistent; charset=utf8';
    private $username = 'Integradora';
    private $password = 'Integradora123';
    
    function ConectarDB(){
        try {
            $this->PDOLocal = new PDO($this->server, $this->username, $this->password);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function DesconectarDB(){
        try {
            $this->PDOLocal = null;   
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function Selects($consulta){
        try {
            $resultado = $this->PDOLocal->query($consulta);
            $fila = $resultado->fetchAll(PDO::FETCH_OBJ);
            return $fila;
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    function Insert($consulta){
        try{
            $this->PDOLocal->query($consulta);
            return 0;
        }
        catch(PDOException $e){
            $err=0;
            $err= $e->getCode();
            return $err;
        }
    }

    function VerificarLogin($Usuario, $Password)
    {
        try{
            $Bandera=0;
            $id='';
            $emp='';
            $est='';
            $fec=getdate();
            $Query="SELECT * FROM usuarios WHERE Usuario = '$Usuario'";
            
            $Consulta=$this->PDOLocal->query($Query);
            while($renglon = $Consulta->fetch(PDO::FETCH_ASSOC))
            {
                if(password_verify($Password,$renglon['Password']))
                {
                    $Bandera=1;
                    $Usuario=$renglon['Usuario'];
                    $id=$renglon['Id_Usuario'];
                    $CorreoElectronico=$renglon['CorreoElectronico'];
                    $emp=$renglon['Id_Empresa'];
                    $fec=$renglon['FechaActivo'];
                    $TipoUsuario=$renglon['TipoUsuario'];
                    $est=$renglon['Estatus'];
                }
            }
            if($Bandera>0){
                $_SESSION['Usuario']=$Usuario;
                $_SESSION['Id_Usuario'] = $id;
                $_SESSION['CorreoElectronico'] = $CorreoElectronico;
                $_SESSION['Id_Empresa'] = $emp;
                $_SESSION['FechaActivo'] = $fec;
                $_SESSION['TipoUsuario'] = $TipoUsuario;
                $_SESSION['Estatus'] = $est;
                header("refresh:0; ../../index.php");
            }
            else{
                echo "<div class='container'><div class='alert alert-danger'> <h2 align='center'> Contraseña o Usuario incorrecto.</h2> </div></div>";
                header("refresh:6; FormLogin.php");
            }
        }
        catch(PDOException $ex){
            echo $ex;
        }
    }

    function CerrarSesion()
    {
        session_start();
        session_destroy();
        header("Location: ../index.php");
    }

    function ObtenerCodigo(){
        $Codigo = rand(100000,999999);
        return $Codigo;
    }

    function RecuperarPassword($Correo, $Codigo)
    {
        require("PHPMailer.php");
        require("SMTP.php");
        require("Exception.php");
        
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->IsSMTP();

        $mail->CharSet="UTF-8";
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPDebug = 1; 
        $mail->Port = 465; //465 or 587

        $mail->SMTPSecure = 'ssl';  
        $mail->SMTPAuth = true; 
        $mail->IsHTML(true);

        $emprin="assistentmedical@gmail.com";
        //Authentication
        $mail->Username = $emprin;
        $mail->Password = "SOYUNDIOS123";

        //Set Params
        $mail->SetFrom($emprin);
        $mail->AddAddress($Correo);
        $mail->Subject = "Recuperar Contraseña";
        $mail->Body = "Hola, vimos que intentas recuperar tu contraseña. <br>
                        Usa el siguiente código para reestablecerla: <br>
                        <b><u>$Codigo</u></b>";

        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message has been sent";
        }
    }
}
?>