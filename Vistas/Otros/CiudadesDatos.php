<?php 
    include '../../Database/Database.php';
    $db = new database();
    $db->ConectarDB();
	
	$Id_Estado = $_POST['Id_Estado'];
	
	$Cadena = "SELECT Id_Ciudad, Ciudad FROM ciudades WHERE Id_Estado = $Id_Estado";
    $reg = $db->Selects($Cadena);
    
    foreach($reg as $value)
    {
        echo                    "<option value='".$value->Id_Ciudad."'>".$value->Ciudad."</option>";
    }
	
?>