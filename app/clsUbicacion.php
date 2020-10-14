<?php


class clsUbicacion extends Conexion{
	
	public function clsUbicacion(){
	
	}

public function set_ubicacion($longitud,$latitud,$referencia){
$link="http://localhost/u/google/mapa.php?long=".$longitud."&lant=".$latitud;

	$sql="INSERT INTO `ubicacion`( `longitud`, `latitud`, `referencia`, `link`) VALUES ('$longitud','$latitud','$referencia','$link');";

if (parent::ejecutar($sql)) {
	return true;
}
else 
return false;

}

}


?>
