<?php 
    include '../../Database/Database.php';
    $db = new database();
    $db->ConectarDB();
	
	$Id_Empresa = $_POST['Id_Empresa'];
	
	$Cadena = "SELECT Id_Sucursal, Sucursal FROM sucursales WHERE Id_Empresa = '$Id_Empresa'";
    echo $Cadena;
    $regSuc = $db->Selects($Cadena);
    
    foreach($regSuc as $valueSuc)
    {
        echo                    "<option value='".$valueSuc->Id_Sucursal."'>".$valueSuc->Sucursal."</option>";
    }
	
?>