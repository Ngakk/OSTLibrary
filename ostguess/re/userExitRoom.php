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

if(isset($_GET["userid"]) && isset($_GET["roomid"])){
	$userid = $_GET["userid"];
	$roomid = $_GET["roomid"];
}

if(isset($_GET["userid"]) && isset($_GET["roomid"])){
	$userid = $_GET["userid"];
	$roomid = $_GET["roomid"];
}

require '../vendor/autoload.php';

$sqluser "UPDATE userdetails SET `guessroomid` = 0 WHERE `userid` = ". $userid;
if($conn->query($sqluser)){
	$sqlplayers = "SELECT usuario.*, userdetails.profileimage FROM guessroom 
	LEFT JOIN userdetails ON userdetails.guessroomid = guessroom.id 
	LEFT JOIN usuario ON usuario.id = userdetails.userid WHERE guessroom.id = ". $roomid;
	$result = $conn->query($sqlplayers);
	if($result->num_rows > 0){
		$pusher = new Pusher\Pusher("242c1ebc2f45447381e3", "14a36ffce25dde568753", "553238", array('cluster' => 'mt1'));
		while($row = $result->fetch_assoc()){
			$data[] = $row;
		}
		$pusher->trigger('guess-channel-'. $roomid, 'client-global-updateplayers', $data);
	}
	else{
		$sqlroom = "SELECT * FROM guessroom WHERE id = ". $roomid;
		$result = $conn->query($sqlroom);
		$room = $result->fetch_assoc();
		
		$deleteroom = "DELETE FROM `guessroom` WHERE id = ". $roomid;
		$deletelist = "DELETE FROM `stlist` WHERE id = ". $room["stlistid"];
		$deletelink = "DELETE FROM `link_soundtrack_list` WHERE stlistid = ". $room["stlistid"];
		
		$conn->query($deleteroom)
		$conn->query($deletelist)
		$conn->query($deletelink)
	}
}

?>