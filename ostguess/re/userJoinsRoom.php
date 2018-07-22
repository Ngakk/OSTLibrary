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
$pusher = new Pusher\Pusher("242c1ebc2f45447381e3", "14a36ffce25dde568753", "553238", array('cluster' => 'mt1'));

$sqljoin = "UPDATE userdetails SET guessroomid = ". $roomid ." WHERE userid = ". $userid;
if($conn->query($sqljoin)){
	$sql = "SELECT usuario.*, userdetails.profileimage FROM guessroom LEFT JOIN userdetails ON userdetails.guessroomid = guessroom.id LEFT JOIN usuario ON usuario.id = userdetails.userid WHERE guessroom.id = ". $roomid;
	$result = $conn->query($sql);
	$username = "User";
	while($row = $result->fetch_assoc()){
		$jsondata["data"]["users"][] = $row;
		if($row["id"] == $userid)
			$username = $row["name"];
	}
	$jsondata["success"] = true;
	$jsondata["data"]["message"] = $username. " has joined the room"; 
	$pusher->trigger('guess-channel-'. $roomid, 'global-updateplayers', $jsondata["data"]);
}
else{
	$jsondata["success"] = false;	
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

$conn->close();
?>