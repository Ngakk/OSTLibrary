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

if(isset($_POST["mail"]) && isset($_POST["userid"])){
	$userid = $_POST["userid"];
	$mail = $_POST["mail"];
}
if(isset($_GET["mail"]) && isset($_GET["userid"])){
	$userid = $_GET["userid"];
	$mail = $_GET["mail"];
}

$sql = "UPDATE usuario SET mail = '". $mail ."' WHERE id = ". $userid;
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