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

if(isset($_POST["username"]) && isset($_POST["message"]) && isset($_POST["roomid"])){
	$username = $_POST["username"];
	$message = $_POST["message"];
	$guessroomid = $_POST["roomid"];
}
if(isset($_GET["username"]) && isset($_GET["message"]) && isset($_GET["roomid"])){
	$username = $_GET["username"];
	$message = $_GET["message"];
	$guessroomid = $_GET["roomid"];
}

require '../../vendor/autoload.php';
$pusher = new Pusher\Pusher("242c1ebc2f45447381e3", "14a36ffce25dde568753", "553238", array('cluster' => 'mt1'));

$data = array("username" => $username, "message" => $message);
$pusher->trigger('guess-channel-'.$guessroomid, 'global-chat', $data);

?>
