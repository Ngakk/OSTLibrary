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

if(isset($_POST["name"]) && isset($_POST["pass"]) && isset($_POST["size"]) && isset($_POST["creatorid"]) && isset($_POST["gamelength"])){
	$name = $_POST["name"];
	$pass = $_POST["pass"];
	$size = $_POST["size"];
	$creatorid = $_POST["creatorid"];
	$gamelength = $_POST["gamelength"];
}
if(isset($_GET["name"]) && isset($_GET["pass"]) && isset($_GET["size"]) && isset($_GET["creatorid"]) && isset($_GET["gamelength"])){
	$name = $_GET["name"];
	$pass = $_GET["pass"];
	$size = $_GET["size"];
	$creatorid = $_GET["creatorid"];
	$gamelength = $_GET["gamelength"];
}

$hoy = getdate();
$date = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"];

$sqlInsertRoom = "INSERT INTO `guessroom`(`id`, `name`, `pass`, `size`, `gamelength`, `stlistid`, `songinlist`, `creatorid`)
	VALUES (NULL, '". $name ."', '". $pass ."' , ". $size ." , ". $gamelength ." ,0, 0, ". $creatorid .")";
	
if($conn->query($sqlInsertRoom)){
	$sqllast = "SELECT LAST_INSERT_ID() AS lastid";
	$lastresult = $conn->query($sqllast);
	$lastid = $lastresult->fetch_assoc();
	$roomid = $lastid["lastid"];
	$sqlInsertList = "INSERT INTO `stlist`(`id`, `name`, `creatorid`, `creationdate`, `isprivate`) 
		VALUES (NULL, 'guessroom-". $roomid ."-list', ". $creatorid ." , '".$date."', 1)";
	if($conn->query($sqlInsertList)){
		$lastresult = $conn->query($sqllast);
		$lastid = $lastresult->fetch_assoc();
		$stlistid = $lastid["lastid"];
		$sqltracks = "SELECT * FROM soundtrack  ORDER BY RAND() LIMIT ". $gamelength;
		$resulttracks = $conn->query($sqltracks);
		$everythingright = true;
		while($rowtrack = $resulttracks->fetch_assoc()){
			$sqllistlink = "INSERT INTO `link_soundtrack_list`(`id`, `soundtrackid`, `stlistid`, `adderid`, `addeddate`) 
				VALUES (NULL,". $rowtrack["id"] .",". $stlistid .", ". $creatorid .",'". $date ."')";
			if(!$conn->query($sqllistlink))
				$everythingright = false;
		}
		if($everythingright){
			$jsondata["success"] = true;
			$jsondata["roomid"] = $roomid;
		}
		else{
			$jsondata["success"] = false;
			$jsondata["message"] = "failed to link soundtrack to list";
		}
	}
	else{
		$jsondata["success"] = false;
		$jsondata["message"] = "failed to insert soundtrack list";
	}
}
else{
	$jsondata["success"] = false;
	$jsondata["message"] = "failed to insert guessroom";
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

$conn->close();

?>