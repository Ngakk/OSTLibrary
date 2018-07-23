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

if(isset($_POST["image"]) && isset($_POST["userid"])){
	$userid = $_POST["userid"];
	$image = $_POST["image"];
}
if(isset($_GET["image"]) && isset($_GET["userid"])){
	$userid = $_GET["userid"];
	$image = $_GET["image"];
}

$sql = "UPDATE userdetails SET profileimage = '". $image ."' WHERE userid = ". $userid;
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