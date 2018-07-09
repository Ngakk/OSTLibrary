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


if(isset($_POST['name']) && isset($_POST['apellidop']) && isset($_POST['date']) && isset($_POST['pais']) && isset($_POST['imageurl'])){
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

if(isset($_GET['name']) && isset($_GET['apellidop']) && isset($_GET['date']) && isset($_GET['pais']) && isset($_GET['imageurl'])){
	$name = $_GET['name'];
	$apellidop = $_GET['apellidop'];
	$date = $_GET['date'];
	$pais = $_GET['pais'];
	$imageurl = $_GET["imageurl"];
}

$sql = "INSERT INTO `artista` (`id`, `name`, `apellidop`, `date`, `pais`, `imageurl`, `rating`) VALUES (NULL, '". $name ."', '". $apellidop ."', '". $date ."', '". $pais ."', '". $imageurl ."', '0')";

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