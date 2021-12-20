<?PHP 
$hostname_localhost ="localhost";
$database_localhost ="bddatos";
$username_localhost ="root";
$password_localhost ="";
$wsdl = "http://localhost:8080/WSDatosBD/WSDDatosSOAP?wsdl";
$cliente = new SoapClient($wsdl);
print_r($cliente->__getFunctions());


//ESTA FUNCION ACTUALIZA LOS DATOS DE UN REGISRO DENTRO DE LA BD, CONJUNTA LOS ATRIBUTOS EN LA VARIABLE $DATOS PARA POSTERIOR FORMATEAR LA INFORMACIÓN
//EN UN ARREGLO JSON


//FIN DE LA FUNCION ACTUALIZAR
/*

//PRINCIPIA CONSULTAR

try {
                        $client = new SoapClient("http://10.154.85.145:8080/WSDatosBD/WSDDatosSOAP?wsdl");
                        print_r($client->consulta()->return);                        
                        $dato = $client->consulta()->return;
                        $json_decode = json_decode($dato);
                        $index = 0;
                        
                        while ($index < count($json_decode)) {
                            $obj_dato = $json_decode[$index];
                            
                            $index++;
                            
                            if(isset($_GET['dat'])){
                                $d2 = json_encode([$obj_dato]);
                                
                               if(strnatcasecmp($_GET['dat'], $d2) == 0){
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
                                    echo "<p>Esto no ha valido verga</p>";
                               }else{
                                echo "jeje";
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
                                   echo "<p>Esto ya valió verga</p>";
                            }
                                
                            }
                            else{
                                echo "jeje";
                                echo "<form action=modificar.php>";
                                echo  "<tr>";
                                echo  "<td>$obj_dato->id</td>";
                                echo  "<td>$obj_dato->nombre</td>";
                                echo  "<td>$obj_dato->monto</td>";
                                echo  "<td>$obj_dato->estado</td>"; 
                                $json = json_encode([$obj_dato]); 
                                echo "<input type=hidden name=dat value=$json>";
                                echo "<td><input type=submit id=boton value=Modificar>Modificar </td>";            
                                echo "</tr>";
                                echo "</form>";
                            }

                        }
}  catch (Exception $exc) {
                        $error = true;
                        $msg_error = 'Ha ocurrido un error al comunicar con el web service.';
                        print_r("Valió verga");
                    }
*/
if($conexion = mysqli_connect($hostname_localhost,$username_localhost,$password_localhost,$database_localhost)){
		mysqli_set_charset( $conexion, 'utf8' );
		$json=array();
		$consulta="SELECT * from tbusuarios where id = 8";
		$resultado=mysqli_query($conexion,$consulta);
		while($registro = mysqli_fetch_array($resultado)){
			$json[]=$registro;
		}
		echo json_encode($json);
		mysqli_close($conexion);
		
	}	
	else{
		$resultar["success"]=0;
		$resultar["message"]='No retorna';
		$json['lista'][]=$resultar;
		echo json_encode($json);
	}
    
?>