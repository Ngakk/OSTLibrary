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

if(isset($_POST["userid"]) && isset($_POST["roomid"])){
	$userid = $_POST["userid"];
	$roomid = $_POST["roomid"];
}

if(isset($_GET["userid"]) && isset($_GET["roomid"])){
	$userid = $_GET["userid"];
	$roomid = $_GET["roomid"];
}

require '../../vendor/autoload.php';

$username = "User";
$sqlusername = "SELECT name FROM usuario WHERE id = ". $userid;
$nameresult = $conn->query($sqlusername);
$username = $nameresult->fetch_assoc()["name"];

$sqluser = "UPDATE userdetails SET `guessroomid` = 0, `trackready` = 0, `gamescore` = 0 WHERE `userid` = ". $userid;
if($conn->query($sqluser)){
	$sqlplayers = "SELECT usuario.*, userdetails.profileimage, userdetails.gamescore FROM guessroom 
	LEFT JOIN userdetails ON userdetails.guessroomid = guessroom.id 
	LEFT JOIN usuario ON usuario.id = userdetails.userid WHERE guessroom.id = ". $roomid ." ORDER BY userdetails.gamescore";
	$result = $conn->query($sqlplayers);
	$count = 0;
	while($row = $result->fetch_assoc()){
		if($row["id"] != ""){
			$count++;
			$data["users"][] = $row;
		}
	}
	if($count > 0){
		$pusher = new Pusher\Pusher("242c1ebc2f45447381e3", "14a36ffce25dde568753", "553238", array('cluster' => 'mt1'));
		$data["message"] = $username. " has left the room";
		$pusher->trigger('guess-channel-'. $roomid, 'global-updateplayers', $data);
	}
	else {
		$sqlroom = "SELECT * FROM guessroom WHERE id = ". $roomid;
		$result = $conn->query($sqlroom);
		$room = $result->fetch_assoc();
		
		$deleteroom = "DELETE FROM `guessroom` WHERE id = ". $roomid;
		$deletelist = "DELETE FROM `stlist` WHERE id = ". $room["stlistid"];
		$deletelink = "DELETE FROM `link_soundtrack_list` WHERE stlistid = ". $room["stlistid"];
		 
		
		$conn->query($deleteroom);
		$conn->query($deletelist);
		$conn->query($deletelink);
	}
}

?>