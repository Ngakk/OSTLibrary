<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ostlibrary";

//Check connection
$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
	die("Conecction failed: " . $conn->connect_error);
}

if(isset($_POST["name"]) && isset($_POST["number"]) && isset($_POST["file"]) && isset($_POST["albumid"]) && isset($_POST["disc"])){
	$name = $_POST["name"];
	$number = $_POST["number"];
	$disc = $_POST["disc"];
	$file = $_POST["file"];
	$albumid = $_POST["albumid"];
	if(isset($_POST["artistas"]))
		$artistas = $_POST["artistas"];
	else
		$artistas = array();
	if(isset($_POST["tags"]))
		$tags = $_POST["tags"];
	else
		$tags = array();
}
else{
	echo "MAl POST";
	$jsondata["success"] = false;
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
	$conn->close();
}
/*
if(isset($_GET["number"]) && isset($_GET['name']) && isset($_GET['file']) && isset($_GET["albumid"]) && isset($_GET["disc"])){
	$number = $_GET["number"];
	$disc = $_GET["disc"];
	$name = $_GET['name'];
	$file = $_GET['file'];
	$albumid = $_GET["albumid"];
	$artistas = array();
	$tags = array();
}*/

$name = str_replace("'", "''", $name);
$file = str_replace("'", "''", $file);

$sql = "INSERT INTO `soundtrack` (`id`, `disc`, `number`, `name`, `file`, `albumid`, `rating`) VALUES (NULL, '". $disc ."', '". $number ."', '". $name ."', '". $file ."', '". $albumid ."', '0')";
if($conn->query($sql)){
	$sqlid = "SELECT LAST_INSERT_ID() AS id";
	$idresult = $conn->query($sqlid);
	$id = $idresult->fetch_assoc();
	$success = true;
	for($i = 0; $i < count($artistas); $i++){
		$sqlTemp = "INSERT INTO `link_soundtrack_artista` (`id`, `soundtrackid`, `artistaid`, `role`) VALUES (NULL, '". $id["id"] ."', '". $artistas[$i] ."', 'Composer')";
		if(!$conn->query($sqlTemp))
			$success = false;
	}
	for($i = 0; $i < count($tags); $i++){
		$sqlTemp = "INSERT INTO `link_soundtrack_tag` (`id`, `soundtrackid`, `tagid`, `repetitions`) VALUES (NULL, '". $id["id"] ."', '". $tags[$i] ."', '1')";
		if(!$conn->query($sqlTemp))
			$success = false;
	}
	if($success){
		$jsondata["success"] = true;
	}else{
		$jasondata["success"] = false;
		$jsondata["data"] = array(
			'message' => 'Se agrego el soundtrack pero no se pudo hacer la relacion con artista o el tag.'
		);	
	}
} else {
	$jasondata["success"] = false;
	$jsondata["data"] = array(
		'message' => 'No se encontro ningun resultado.'
	);	
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

$conn->close();

?>