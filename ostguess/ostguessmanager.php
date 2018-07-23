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

if(isset($_POST["userid"]) && isset($_POST["guessid"]) && isset($_POST["guessroomid"])){
	$guessid = $_POST["guessid"];
	$userid = $_POST["userid"];
	$guessroomid = $_POST["guessroomid"];
}

if(isset($_GET["userid"]) && isset($_GET["guessid"]) && isset($_GET["guessroomid"])){
	$guessid = $_GET["guessid"];
	$userid = $_GET["userid"];
	$guessroomid = $_GET["guessroomid"];
}

require '../vendor/autoload.php';
$pusher = new Pusher\Pusher("242c1ebc2f45447381e3", "14a36ffce25dde568753", "553238", array('cluster' => 'mt1'));

$sqluser = "SELECT usuario.name, userdetails.gamescore FROM usuario LEFT JOIN userdetails ON userdetails.userid = usuario.id WHERE usuario.id = ". $userid;
$resultuser = $conn->query($sqluser);
$user = $resultuser->fetch_assoc();

$sqlroom = "SELECT link_soundtrack_list.soundtrackid, guessroom.songinlist, guessroom.gamelength FROM guessroom LEFT JOIN link_soundtrack_list ON guessroom.stlistid = link_soundtrack_list.stlistid WHERE guessroom.id = ". $guessroomid ." ORDER BY link_soundtrack_list.id";
$resultroom = $conn->query($sqlroom);
$i = 0;
while($row = $resultroom->fetch_assoc()){
	if($i >= $row["songinlist"])
		break;
	$i++;
}

$sqlsong = "SELECT `soundtrack`.*, `source`.`id` AS sourceid, `source`.`name` AS sourcename, `album`.`name` AS albumname, `album`.`date` AS albumdate, `album`.`imageurl` AS albumimg, `album`.`rating` AS albumrating 
FROM `soundtrack` 
LEFT JOIN `album` 
ON `album`.id = `soundtrack`.`albumid` 
LEFT JOIN `source` 
ON `album`.`sourceid` = `source`.`id` 
WHERE `soundtrack`.id = ". $row["soundtrackid"];
$resultsong = $conn->query($sqlsong);
$song = $resultsong->fetch_assoc();

if($song["sourceid"] == $guessid){
	//correct answer
	$sqlupdateusr = "UPDATE userdetails SET gamescore = ". ($user["gamescore"]+1) ." WHERE userid = ". $userid;
	$conn->query($sqlupdateusr);
	
	$sqlallusers = "UPDATE userdetails SET trackready = 0 WHERE guessroomid = ". $guessroomid;
	$conn->query($sqlallusers);
	
	$sqlupdateroom = "UPDATE guessroom SET songinlist = ". ($row["songinlist"]+1) ." WHERE id = ". $guessroomid;
	$conn->query($sqlupdateroom);
	
	$sqlupdateroom = "UPDATE guessroom SET songinlist = ". ($row["songinlist"]+1) ." WHERE id = ". $guessroomid;
	$conn->query($sqlupdateroom);
	
	$finished = false;
	if($row["gamelength"] <= ($user["gamescore"]+1))
		$finished = true;
	
	$message = array('message' => "", 'username' => $user["name"], 'userid' => $userid, 'newscore' => ($user["gamescore"]+1), 'isright' => true, 'finished' => $finished);
	$pusher->trigger('guess-channel-'.$guessroomid, 'global-response', $message);
}
else{
	//bad answer
	$sqlguess = "SELECT name FROM source WHERE id = ". $guessid;
	$guessresponse = $conn->query($sqlguess);
	$source = $guessresponse->fetch_assoc();
	$message = array('message' => $source["name"], 'username' => $user["name"], 'userid' => $userid, 'newscore' => ($user["gamescore"]), 'isright' => false, 'finished' => false);
	$pusher->trigger('guess-channel-'.$guessroomid, 'global-response', $message);
}

?>