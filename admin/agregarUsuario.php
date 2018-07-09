<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ostlibrary";

if(isset($_POST['name']) && isset($_POST['pass']) && isset($_POST['mail']) && isset($_POST['date']) && isset($_POST['level']) && isset($_POST["image"])){
	$name = $_POST['name'];
	$pass = $_POST['pass'];
	$mail = $_POST['mail'];
	$date = $_POST['date'];
	$level = $_POST['level'];
	$image = $_POST["image"];
}
else{
	$jsondata["success"] = false;
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
	$conn->close();
}

if(isset($_GET['name']) && isset($_GET['pass']) && isset($_GET['mail']) && isset($_GET['date']) && isset($_GET['level']) && isset($_GET["image"])){
	$name = $_GET['name'];
	$pass = $_GET['pass'];
	$mail = $_GET['mail'];
	$date = $_GET['date'];
	$level = $_GET['level'];
	$image = $_GET["image"];
}

$conn = new mysqli($servername, $username, $password, $dbname);
//Check connection
if($conn->connect_error){
	die("Conecction failed: " . $conn->connect_error);
}

$sql = "INSERT INTO `usuario` (`id`, `name`, `pass`, `mail`, `age`, `img`, `clearance`) VALUES (NULL, '". $name ."', '". $pass ."', '". $mail ."', '". $date ."', '". $image ."', '". $level ."')";

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