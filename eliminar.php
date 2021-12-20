<?php
     try {
            if(isset($_GET['al'])){
            $datos = $_GET['al'];
            echo $datos;
            $client = new SoapClient("http://localhost:8080/WSDatosBD/WSDDatosSOAP?wsdl");
            $client->__soapCall("borrar", array(["json" => $datos]));
            }
            
        } catch (Exception $exc) {
            $error = true;
            $msg_error = 'Ha ocurrido un error al comunicar con el web service.';
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
       <!-- <nav>
            <div class="nav-wrapper  light-blue darken-4">
                <a>WEB SERVICE</a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li></li>
                </ul>
            </div>
        </nav> -
        <h1 class="brand-logo center">Eliminar registro</h1>-->
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
                        //print_r($json_decode);
                        while ($index < count($json_decode)) {
                            $obj_dato = $json_decode[$index];
                            $index++;
                    
                           echo "<form method='get'>";
                           echo  "<tr>";
                           echo  "<td>$obj_dato->id</td>";
                           echo  "<td>$obj_dato->nombre</td>";
                           echo  "<td>$obj_dato->monto</td>";
                           echo  "<td>$obj_dato->estado</td>"; 
                                
                            $json = json_encode([$obj_dato]); 
                            echo "<input type=hidden name=al value=$json>";
                            echo "<td><input type=submit id=boton value=Eliminar> </td>";            
                            echo "</tr>";
                            echo "</form>";
                    ?>

                            <?php
                        }

                    } catch (Exception $exc) {
                        $error = true;
                        $msg_error = 'Ha ocurrido un error al comunicar con el web service.';
                    }
                    ?>
                </tbody>

                </form>
            </table>
    </div>
</body>
</html>