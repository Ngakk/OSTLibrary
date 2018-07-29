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

$sql = "SELECT album.*, `source`.name AS sourcename FROM album LEFT JOIN `source` ON `source`.id = album.sourceid ORDER BY RAND() LIMIT 3";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
	$jsondata[] = $row;
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

$conn->close();

?>