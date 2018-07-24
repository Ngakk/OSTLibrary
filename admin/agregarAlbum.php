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
if(isset($_POST['name']) && isset($_POST["date"]) && isset($_POST["imageurl"]) && isset($_POST["source"]) && isset($_POST["tags"])){
	$name = $_POST['name'];
	$date = $_POST["date"];
	$imageurl = $_POST["imageurl"];
	$source = $_POST["source"];
	$tags = $_POST["tags"];
}
else{
	$jsondata["success"] = false;
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
	$conn->close();
}

if(isset($_GET['name']) && isset($_GET["date"]) && isset($_GET["imageurl"]) && isset($_GET["source"]) && isset($_GET["tags"])){
	$name = $_GET['name'];
	$date = $_GET["date"];
	$imageurl = $_GET["imageurl"];
	$source = $_GET["source"];
	$tags = $_GET["tags"];
}

$name = str_replace("'", "''", $name);
$sql = "INSERT INTO `album` (`id`, `name`, `date`, `imageurl`, `smallimgurl`, `backimgurl`, `sourceid`, `rating`, `threadid`) VALUES (NULL, '". $name ."', '". $date ."', '". $imageurl ." ', '', '', '". $source ."', '0', '0')";

//echo $sql;

if($conn->query($sql) == TRUE){
	$sqlid = "SELECT LAST_INSERT_ID() AS id";
	$idresult = $conn->query($sqlid);
	$id = $idresult->fetch_assoc();
	$success = true;
	for($i = 0; $i < count($tags); $i++){
		$sqlTemp = "INSERT INTO `link_album_tag` (`id`, `albumid`, `tagid`, `repetitions`) VALUES (NULL, '". $id["id"] ."', '". $tags[$i] ."', 1)";
		if(!$conn->query($sqlTemp) == TRUE)
			$success = false;
	}
	if($success){
		$jsondata["success"] = true;
	}else{
		$jsondata["success"] = false;
		$jsondata["data"] = array(
			'message' => 'Se agrego el album pero no se pudo hacer la relacion con artista.'
		);	
	}
} else {
	$jsondata["success"] = false;
	$jsondata["data"] = array(
		'message' => 'No se encontro ningun resultado.'
	);	
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

$conn->close();

?>