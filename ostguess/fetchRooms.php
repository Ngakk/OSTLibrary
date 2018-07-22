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

$sql = "SELECT guessroom.*, usuario.name AS username FROM guessroom LEFT JOIN usuario ON guessroom.creatorid = usuario.id";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
	if($row["waiting"] == 1)
		$jsondata["data"][] = $row;
}

$jsondata["success"] = true;

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

$conn->close();
