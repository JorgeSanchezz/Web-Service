<?php
     $error = false;
     $msg_error = '';
    // $parametros=array();
     ini_set("soap.wsdl_cache_enabled", "0");
        if(isset($_GET['nombre']) && !empty($_GET['nombre']) && isset($_GET['estado']) && !empty($_GET['estado'] && isset($_GET['monto']) ) ){
            $mont = $_GET['monto'];
                if (!is_numeric($mont)) {
                    $error = true;
                    $msg_error = "El valor del monto debe ser numerico";
                }
                else{
                    try {
                        $client = new SoapClient("http://localhost:8080/WSDatosBD/WSDDatosSOAP?wsdl");
                        $datos = new stdClass();
                        $datos->id = $_GET['id'];
                        $datos->nombre = $_GET['nombre'];
                        $datos->monto = floatval($_GET['monto']);
                        $datos->estado = $_GET['estado'];
                        $json = json_encode([$datos]);
                        //echo $json;
                        $client->__soapCall("actualizar", array(["json"=>$json]));
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
        <h1 class="brand-logo center">Modificar registro</h1>
        <div class="container">
            <table class="bordered hoverable centered">
            <form method='get'>
                <thead>
                    <tr>
                        <th colspan=6>Personas</th>
                    </tr>
                    <tr>
                        <td>Id</td>
                        <td>Nombre</td>
                        <td>Monto</td>
                        <td>Estado</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        $client = new SoapClient("http://localhost:8080/WSDatosBD/WSDDatosSOAP?wsdl");
                        $dato = $client->consulta()->return;
                        $json_decode = json_decode($dato);
                        $index = 0;
                        
                        while ($index < count($json_decode)) {
                            $obj_dato = $json_decode[$index];
                            $index++;
                            
                            if(isset($_GET['dat'])){
                                $d2 = json_encode([$obj_dato]);
                                
                               if(strnatcasecmp($_GET['dat'], $d2) == 0){
                                   //Caso cuando ocurren modificaciones
                                    echo "<form method='get'>";
                                    echo  "<tr>";
                                    echo  "<td><input id=texto name=id type='text' readonly=readonly value=$obj_dato->id></td>";
                                    echo  "<td><input id=texto name=nombre type='text' value=$obj_dato->nombre></td>";
                                    echo  "<td><input id=texto name=monto type='text' value=$obj_dato->monto></td>";
                                    echo  "<td><input id=texto name=estado type='text' value=$obj_dato->estado></td>"; 
                                    $json = json_encode([$obj_dato]);
                                    echo "<input type=hidden name=al value=$json>";
                                    echo "<td><input type=submit id=boton value=Guardar> </td>";            
                                    echo "</tr>";
                                    echo "</form>";
                               }else{
                                echo "<form action=modificar.php>";
                                echo  "<tr>";
                                echo  "<td>$obj_dato->id</td>";
                                echo  "<td>$obj_dato->nombre</td>";
                                echo  "<td>$obj_dato->monto</td>";
                                echo  "<td>$obj_dato->estado</td>"; 
                                $json = json_encode([$obj_dato]); 
                                echo "<input type=hidden name=dat value=$json>";
                                echo "<td><input type=submit id=boton value=Modificar> </td>";            
                                echo "</tr>";
                                echo "</form>";
                            }
                                
                            }
                            else{
                                //Por defecto
                                echo "<form action=modificar.php>";
                                echo  "<tr>";
                                echo  "<td>$obj_dato->id</td>";
                                echo  "<td>$obj_dato->nombre</td>";
                                echo  "<td>$obj_dato->monto</td>";
                                echo  "<td>$obj_dato->estado</td>"; 
                                $json = json_encode([$obj_dato]); 
                                echo "<input type=hidden name=dat value=$json>";
                                echo "<td><input type=submit id=boton value=Modificar> </td>";            
                                echo "</tr>";
                                echo "</form>";
                            }

                            
                           
                    ?>

                            <?php
                        }

                    } catch (Exception $exc) {
                        $error = true;
                        $msg_error = 'Ha ocurrido un error al comunicar con el web service.\n';
                    }
                    ?>
                </tbody>
                </form>
            </table>
        </div>
</body>
</html>