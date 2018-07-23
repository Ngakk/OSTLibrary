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

if(isset($_POST["userid"])){
	$userid = $_POST["userid"];
}

if(isset($_GET["userid"])){
	$userid = $_GET["userid"];
}

$sql = "SELECT usuario.*, usuario.profileimage FROM usuario LEFT JOIN userdetails ON usuario.id = userdetails.userid WHERE usuario.id = ". $userid;
if($result = $conn->query($sql)){
	$jsondata["success"] = true;
	$jsondata["data"] = $result->fetch_assoc();
}
else{
	$jsondata["success"] = false;
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

$conn->close();
?>