<?php 
    include '../../Database/Database.php';
    $db = new database();
    $db->ConectarDB();
	
	$Id_Pais = $_POST['Id_Pais'];
	
	$Cadena = "SELECT Id_Estado, Estado FROM estados WHERE Id_Pais = $Id_Pais";
    $regEdo = $db->Selects($Cadena);
    
    foreach($regEdo as $valueEdo)
    {
        echo                    "<option value='".$valueEdo->Id_Estado."'>".$valueEdo->Estado."</option>";
    }
	
?>