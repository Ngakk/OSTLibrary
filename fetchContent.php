<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ostlibrary";

$conn = new mysqli($servername, $username, $password, $dbname);
//Check connection
if($conn->connect_error){
	die("Conecction failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM seccion";

$result = $conn->query($sql);

if($result->num_rows>0){
	$jsondata["success"] = true;
	$jsondata["message"] = SPRINTF("Se han encontrado %d datos", $result->num_rows);
	$jsondata["data"]["datos"] = array();
	while( $row = $result->fetch_assoc() ) {
		$sqlContenido = "SELECT * FROM contenido WHERE sectid = ". $row["id"];
		$resultContenido = $conn->query($sqlContenido);
		while($rowContenido = $resultContenido->fetch_assoc())
		{
			if($rowContenido["type"] != '0'){
				$sqlType = 'SELECT * FROM '. $rowContenido["type"] .' WHERE id = '. $rowContenido["typeid"];
				$typeResult = $conn->query($sqlType);
				
				while( $rowType = $typeResult->fetch_object()){
					$rowContenido["typeData"] = $rowType;
				}
			}
			$row["contenido"][] = $rowContenido;
		}
		$jsondata["data"]["datos"][] = $row;	
	}
} else {
	$jsondata["success"] = false;
	$jsondata["data"] = array(
		'message' => 'No se encontro ningun resultado.'
	);	
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

$conn->close();

?>