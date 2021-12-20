<?php
$error = false;
$msg_error = '';
//$parametros=array();
ini_set("soap.wsdl_cache_enabled", "0");
  if(isset($_POST['nombre']) && !empty($_POST['nombre']) && isset($_POST['estado']) && !empty($_POST['estado'] && isset($_POST['monto']) ) ){
    $mont = $_POST['monto'];
    if (!is_numeric($mont)) {
        $error = true;
        $msg_error = "El valor del monto debe ser numerio";
    }
    else{
      try {
            $client = new SoapClient("http://localhost:8080/WSDatosBD/WSDDatosSOAP?wsdl");
            $datos = new stdClass();
            $datos->nombre = $_POST['nombre'];
            $datos->monto = floatval($_POST['monto']);
            $datos->estado = $_POST['estado'];
            $json = json_encode([$datos]);
            $client->__soapCall("insertar", array(["json"=>$json]));
            
        } catch (Exception $exc) {
            $error = true;
            $msg_error = 'Ha ocurrido un error al comunicar con el web service.';
        }
    }
  }else{
    $error = true;
    $msg_error = 'Debe llenar todos los campos.';
  }
?>

<html>
	<head>
        <title>WEB SERVICE</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="css/materialize.min.css">
    </head>

    <body class="grey lighten-2">
    	<nav>
  			<div class="nav-wrapper  light-blue darken-4">
    			<a>WEB SERVICE</a>
    			<ul id="nav-mobile" class="right hide-on-med-and-down">
      				<li></li>
    			</ul>
  			</div>
		</nav>
		<br><br><br>
		<div class="container">
		<div class="row">
        <div class="col s3 m6" >
          <div class="card">
          <div class="card-content">
          <form method="post">
            <label for="first_name">Nombre</label> 
            <input id="first_name" type="text" class="validate" name="nombre"  required>

            <label for="first_name">Estado</label> 
            <input id="first_name" type="text" class="validate" name="estado"  required>

             <label for="first_name">Monto</label> 
            <input id="first_name" type="text" class="validate" name="monto"  required>

            <button class="btn waves-effect light-blue accent-4" type="submit" name="action">Enviar
            </button>
          </form>
          </div>
          </div>
        </div>

        <div class="col s3 m6">
          <div class="card">
            <div class="card-image">
              <img src="images/dictamen.jpg">
              <span class="card-title  light-blue darken-4">Registros</span>
            </div>
            <div class="card-content">
              <p></p>
            </div>
            <div class="card-action">
              <a href="eliminar.php">Eliminar</a>
              <a href="modificar.php">Modificar</a>
              <a href="pagar.php">Pagar</a>
            </div>
          </div>
        </div>

        <?php
                if ($error) {
                    ?>
                    <div class="error">
                        <?php echo $msg_error; ?>
                    </div>
                    <?php
                }
                ?>

       </div>
      </div>
    </body>
</html>