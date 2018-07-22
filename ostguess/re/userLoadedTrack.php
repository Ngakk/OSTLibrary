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

if(isset($_POST["roomid"]) && isset($_POST["userid"])){
	$roomid = $_POST["roomid"];
	$userid = $_POST["userid"];
}

if(isset($_GET["roomid"]) && isset($_GET["userid"])){
	$roomid = $_GET["roomid"];
	$userid = $_GET["userid"];
}

require '../../vendor/autoload.php';

$sqlupdateuser = "UPDATE userdetails SET trackready = 1 WHERE userid = ". $userid;
if($conn->query($sqlupdateuser)){
	$sqlroom = "SELECT userdetails.*, guessroom.size FROM userdetails LEFT JOIN guessroom ON userdetails.guessroomid = guessroom.id WHERE guessroomid = ". $roomid;
	$roomresult = $conn->query($sqlroom);
	$allready = true;
	$count = 0;
	while($row = $roomresult->fetch_assoc()){
		$count++;
		if($row["trackready"] == 0){
			$allready = false;
			break;
		}
		$roomsize = $row["size"];
	}
	if($allready && $count == $roomsize)
	{
		$pusher = new Pusher\Pusher("242c1ebc2f45447381e3", "14a36ffce25dde568753", "553238", array('cluster' => 'mt1'));
		$pusher->trigger('guess-channel-'.$roomid, 'global-alltracksready', true);
	}
}

?>