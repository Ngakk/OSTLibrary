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


if(isset($_POST["id"]) && isset($_POST['name']) && isset($_POST['apellidop']) && isset($_POST['date']) && isset($_POST['pais']) && isset($_POST['imageurl'])){
	$id = $_POST["id"];
	$name = $_POST['name'];
	$apellidop = $_POST['apellidop'];
	$date = $_POST['date'];
	$pais = $_POST['pais'];
	$imageurl = $_POST["imageurl"];
}
else{
	$jsondata["success"] = false;
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
	$conn->close();
}

$sql = "UPDATE `artista` SET `name` = '". $name ."', `apellidop` = '". $apellidop ."', `date` = '". $date ."', `pais` = '". $pais ."', `imageurl` = '". $imageurl ."' WHERE id = ". $id;

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