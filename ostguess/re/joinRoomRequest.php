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

if(isset($_POST["userid"]) && isset($_POST["roomid"]) && isset($_POST["pass"])){
	$userid = $_POST["userid"];
	$roomid = $_POST["roomid"];
	$pass = $_POST["pass"];
}

if(isset($_GET["userid"]) && isset($_GET["roomid"]) && isset($_GET["pass"])){
	$userid = $_GET["userid"];
	$roomid = $_GET["roomid"];
	$pass = $_GET["pass"];
}

$sqlroom = 	"SELECT guessroom.* FROM guessroom LEFT JOIN (usuario LEFT JOIN userdetails ON usuario.id = userdetails.userid) ON guessroom.id = userdetails.guessroomid WHERE guessroom.id = ". $roomid;
$resultroom = $conn->query($sqlroom);


if($row = $resultroom->fetch_assoc()){
	if($row["id"] != ""){
		if($pass != $row["pass"]){
			$jsondata["success"] = false;
			$jsondata["message"] = "Wrong password";	
			$jsondata["reload"] = false;
		}
		else if($resultroom->num_rows >= $row["size"]){
			$jsondata["success"] = false;
			$jsondata["message"] = "Room is full";	
			$jsondata["reload"] = true;
		}
		else if($row["waiting"] == 0){
			$jsondata["success"] = false;
			$jsondata["message"] = "Game already started";
			$jsondata["reload"] = true;
		}
		else{
			$jsondata["success"] = true;
			$jsondata["message"] = "";
			
			$sqljoin = "UPDATE userdetails SET guessroomid = ". $roomid ." WHERE userid = ". $userid;
		}
	}
}
else{
	$jsondata["success"] = false;
	$jsondata["message"] = "Room doesn't exist anymore";
	$jsondata["reload"] = true;
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

$conn->close();
?>