<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ostlibrary";

if(isset($_POST['username']) && isset($_POST['password'])){
	$user = $_POST['username'];
	$pass = $_POST['password'];
}
else{
	$user = "";
	$pass = "";
}

if(isset($_GET["username"]) && isset($_GET["password"]))
{
	$user = $_GET["username"];
	$pass = $_GET["password"];
}

$conn = new mysqli($servername, $username, $password, $dbname);
//Check connection
if($conn->connect_error){
	die("Conecction failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM usuario WHERE name='". $user ."' AND pass='". $pass."'";

//echo $sql;
$result = $conn->query($sql);

if($result->num_rows>0){
	$jsondata["success"]["message"] = SPRINTF("Se han encontrado %d datos", $result->num_rows);
	$jsondata["data"]["datos"] = array();
	$jsondata["username"] = $user;
	while( $row = $result->fetch_object() ) {
		$jsondata["data"]["datos"][] = $row;	
	}
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