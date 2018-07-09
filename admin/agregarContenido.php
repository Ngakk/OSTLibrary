<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ostlibrary";

if(isset($_POST['titulo']) && isset($_POST["texto"]) && isset($_POST["tipo"]) && isset($_POST["tipoId"]) && isset($_POST["seccionId"])){
	$titulo = $_POST['titulo'];
	$texto = $_POST["texto"];
	$tipo = $_POST["tipo"];
	$tipoId = $_POST["tipoId"];
	$seccionId = $_POST["seccionId"];
}
else{
	$jsondata["success"] = false;
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
	$conn->close();
}

if(isset($_GET['titulo']) && isset($_GET["texto"]) && isset($_GET["tipo"]) && isset($_GET["tipoId"]) && isset($_GET["seccionId"])){
	$titulo = $_GET['titulo'];
	$texto = $_GET["texto"];
	$tipo = $_GET["tipo"];
	$tipoId = $_GET["tipoId"];
	$seccionId = $_GET["seccionId"];
}

$conn = new mysqli($servername, $username, $password, $dbname);
//Check connection
if($conn->connect_error){
	die("Conecction failed: " . $conn->connect_error);
}

$sql = "INSERT INTO `contenido` (`id`, `title`, `texto`, `type`, `typeid`, `sectid`) VALUES (NULL, '". $titulo ."', '". $texto ."', '". $tipo. "', '". $tipoId ."', '". $seccionId ."')";

//echo $sql;


if($conn->query($sql) == TRUE){
	$jsondata["success"] = true;
} else {
	$jasondata["success"] = false;
	$jsondata["data"] = array(
		'message' => 'No se encontro ningun resultado.'
	);	
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

$conn->close();

?>