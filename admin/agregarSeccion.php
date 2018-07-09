<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ostlibrary";

if(isset($_POST['name']) && isset($_POST['level'])){
	$name = $_POST['name'];
	$level = $_POST['level'];
}
else{
	$jsondata["success"] = false;
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
	$conn->close();
}

if(isset($_GET['name']) && isset($_GET['level'])){
	$name = $_GET['name'];
	$level = $_GET['level'];
}

$conn = new mysqli($servername, $username, $password, $dbname);
//Check connection
if($conn->connect_error){
	die("Conecction failed: " . $conn->connect_error);
}

$sql = "INSERT INTO `seccion` (`id`, `name`, `nivel`) VALUES (NULL, '". $name ."', '". $level ."')";

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