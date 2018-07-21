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

if(isset($_POST["size"]))
	$size = $_POST["size"];

$sql = "SELECT id FROM soundtrack";
if($result = $conn->query($sql)){
	$jsondata["success"] = true;
	$maxLength = (($result->num_rows -1)/$size) +1;
	$jsondata["maxLength"] = $maxLength;
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

?>