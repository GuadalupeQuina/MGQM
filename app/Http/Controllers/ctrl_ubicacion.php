<?php
include_once('clsUbicacion.php');

if (isset($_POST['boton']) && $_POST['boton']=="GUARDAR") {
	
	set_ubicacion();
}

function set_ubicacion(){
	$longitud=$_POST['txtLongitud'];
	$latitud=$_POST['txtLatitud'];
	$referencia=$_POST['txtRefencia'];
	
	$obj=new clsUbicacion();
		if ($obj->set_ubicacion($longitud,$latitud,$referencia)) {
		echo "<script> alert('SE REGISTRO CON EXITO'); </script>";	
		}
		else {
		echo "<script> alert('ERROR'); </script>";	
		}


}



?>