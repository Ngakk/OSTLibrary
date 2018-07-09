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

if($conn->connect_error){
	die("Conecction failed: " . $conn->connect_error);
}

if(isset($_POST["id"]) $$ isset($_POST["disc"]) && isset($_POST["number"]) && isset($_POST['name']) && isset($_POST['file']) && isset($_POST["albumid"]) && isset($_POST["artistas"]) && isset($_POST["artistcount"]) && isset($_POST["tags"]) && isset($_POST["tagcount"])){
	$id = $_POST["id"];
	$number = $_POST["number"];
	$disc = $_POST["disc"];
	$name = $_POST['name'];
	$file = $_POST['file'];
	$albumid = $_POST["albumid"];
	$artistas = $_POST["artistas"];
	$artistcount = $_POST["artistcount"];
	$tags = $_POST["tags"];
	$tagcount = $_POST["tagcount"];
}
else{
	echo 'no complete post ----------------------------';
	$jsondata["success"] = false;
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
	$conn->close();
}

if(isset($_GET["id"]) && isset($_GET['name']) && isset($_GET['file']) && isset($_GET["albumid"])){
	$id = $_GET["id"];
	$name = $_GET['name'];
	$file = $_GET['file'];
	$albumid = $_GET["albumid"];
	$artistcount = 0;
	$artistas = array();
	$tags = array();
	$tagcount = 0;
}
$name = str_replace("'", "''", $name);
$file = str_replace("'", "''", $file);
$sql = "UPDATE `soundtrack` SET `number` = '". $number ."',`name` = '". $name ."', `file` = '". $file ."', `albumid` = '". $albumid ."', `disc`= '". $disc ."' WHERE id = ". $id;

if($conn->query($sql)){
	$sqlArt = "DELETE FROM link_soundtrack_artista WHERE soundtrackid = ". $id;
	$sqlTag = "DELETE FROM link_soundtrack_tag WHERE soundtrackid = ". $id;
	if($conn->query($sqlArt) && $conn->query($sqlTag)){
		$success = true;
		for($i = 0; $i < $artistcount; $i++){
			$sqlTemp = "INSERT INTO `link_soundtrack_artista` (`id`, `soundtrackid`, `artistaid`, `role`) VALUES (NULL, '". $id ."', '". $artistas[$i] ."', 'Composer')";
			if($conn->query($sqlTemp) == FALSE)
				$success = false;
		}
		for($i = 0; $i < $tagcount; $i++){
			$sqlTemp = "INSERT INTO `link_soundtrack_tag` (`id`, `soundtrackid`, `tagid`, `repetitions`) VALUES (NULL, '". $id ."', '". $tags[$i] ."', '1')";
			if($conn->query($sqlTemp) == FALSE)
				$success = false;
		}
		if($success){
			$jsondata["success"] = true;
		}else{
			$jasondata["success"] = false;
			$jsondata["data"] = array(
				'message' => 'Se actualizo el soundtrack y se borraron las relaciones con los artistas previos, preo no se pudo hacer la relacion con artistas nueva.',
				'artistas' => $artistas,
				'tags' => $tags
			);	
		}
	}
	else{
		$jasondata["success"] = false;
		$jsondata["data"] = array(
			'message' => 'Se edito el soundtrack pero no se actualizaron las relaciones con los artistas ni con los tags'
		);	
	}
} else {
	$jasondata["success"] = false;
	$jsondata["data"] = array(
		'message' => 'No se encontro ningun resultado.',
		'sql' => $sql
	);	
}

header('Content-type: application/json; charset=utf-8');
echo json_encode($jsondata, JSON_FORCE_OBJECT);

$conn->close();

?>