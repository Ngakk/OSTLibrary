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

if(isset($_POST["id"])){
	$id = $_POST["id"];
}
if(isset($_GET["id"])){
	$id = $_GET["id"];
}

$sql = "SELECT soundtrack.*, album.name AS albumname FROM soundtrack 
LEFT JOIN album ON album.id = soundtrack.albumid WHERE soundtrack.albumid = ". $id;
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
	$sqlar = "SELECT artista.fullname FROM link_soundtrack_artista 
	INNER JOIN artista ON artista.id = link_soundtrack_artista.artistaid WHERE link_soundtrack_artista.soundtrackid = ". $row["id"];
	$resultar = $conn->query($sqlar);
	while($row2 = $resultar->fetch_assoc()){
		$row["artistas"][] = $row2;
	}
	$jsondata[] = $row;
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

$conn->close();

?>