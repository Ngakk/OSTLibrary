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

if(isset($_POST["name"]) && isset($_POST["userid"])){
	$userid = $_POST["userid"];
	$name = $_POST["name"];
}
if(isset($_GET["name"]) && isset($_GET["userid"])){
	$userid = $_GET["userid"];
	$name = $_GET["name"];
}

$sql = "UPDATE usuario SET name = '". $name ."' WHERE id = ". $userid;
if($conn->query($sql)){
	$jsondata["success"] = true;
}
else{
	$jsondata["success"] = false;
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

$conn->close();
?>