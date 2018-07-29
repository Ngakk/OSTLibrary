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

$sql = "SELECT * FROM album ORDER BY date LIMIT 6";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
	$jsondata["data"] = $row;
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

$conn->close();

?>