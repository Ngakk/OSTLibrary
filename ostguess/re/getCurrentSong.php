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

if(isset($_POST["roomid"])){
	$roomid = $_POST["roomid"];
}

if(isset($_GET["roomid"])){
	$roomid = $_GET["roomid"];
}

$sqlroom = "SELECT link_soundtrack_list.soundtrackid, guessroom.songinlist FROM guessroom LEFT JOIN link_soundtrack_list ON guessroom.stlistid = link_soundtrack_list.stlistid WHERE guessroom.id = ". $roomid ." ORDER BY link_soundtrack_list.id";
$resultroom = $conn->query($sqlroom);
$i = 0;

while($row = $resultroom->fetch_assoc()){
	if($i >= $row["songinlist"])
		break;
	$i++;
}
$sqlsong = "SELECT soundtrack.*, album.name AS albumname , album.date, `source`.name AS sourcename FROM soundtrack LEFT JOIN album ON album.id = soundtrack.albumid LEFT JOIN `source` ON album.sourceid = `source`.id WHERE soundtrack.id = ". $row["soundtrackid"];
$result = $conn->query($sqlsong);
if($song = $result->fetch_assoc()){
	$jsondata["success"] = true;
	$jsondata["song"] = $song;
}
else{
	$jsondata["success"] = false;
	$jsondata["song"] = $sqlsong;
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

$conn->close();

?>