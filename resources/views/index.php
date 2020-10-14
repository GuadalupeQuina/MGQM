<?php
include_once('ctrl_ubicacion.php');

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>GOOGLE MAPS</title>	


    <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body>
	<!-- INI FORMULARIO ------------------------------ -->
		   	  <div class="container">
      <h1>GOOGLE MAPS</h1>
      <label>obtener ubicacion con gps</label>

 
 	<form class="well form-search" action="index.php" method="post">


		LONGITUD: <input type="text" name="txtLongitud" id="txtLongitud" ><br><br>
		LATITUD: <input type="text" name="txtLatitud" id="txtLatitud" ><br><br>
		REFERENCIA: <input type="text" name="txtRefencia" id="txtRefencia"><br><br>
		<input type="submit" name="boton" class="btn btn-primary" value="GUARDAR"  >
	</form>
 
 <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#maps">VER MAPA</button>

      <h2>Results</h2>
 
   Tabla de link de ubicaciones 
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Título</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Lorem ipsum dolor sit amet</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Consetetur sadipscing elitr</td>
          </tr>
          <tr>
            <td>3</td>
            <td>At vero eos et accusam</td>
          </tr>
        </tbody>
      </table>
    
    </div>
	<!-- FIN FORMULARIO ------------------------------ -->	   



<script>
	function addUbicacion(longitud,latitud,txtDir){
		txtLongitud.value=longitud;
		txtLatitud.value=latitud;
	}

</script>
   

 <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<?php
include_once('modal_ubicacion.php');
?>


</body>
</html>