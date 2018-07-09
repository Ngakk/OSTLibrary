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


if(isset($_POST["id"]) && isset($_POST['name']) && isset($_POST["date"]) && isset($_POST["imageurl"]) && isset($_POST["source"]) && isset($_POST["tags"]) && isset($_POST["tagcount"])){
	$id = $_POST["id"];
	$name = $_POST['name'];
	$date = $_POST["date"];
	$imageurl = $_POST["imageurl"];
	$source = $_POST["source"];
	$tags = $_POST["tags"];
	$tagcount = $_POST["tagcount"];
}
else{
	$jsondata["success"] = false;
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
	$conn->close();
}

if(isset($_GET["id"]) && isset($_GET['name']) && isset($_GET["date"]) && isset($_GET["imageurl"]) && isset($_GET["source"]) && isset($_GET["tags"]) && isset($_GET["tagcount"])){
	$id = $_GET["id"];
	$name = $_GET['name'];
	$date = $_GET["date"];
	$imageurl = $_GET["imageurl"];
	$source = $_GET["source"];
	$tags = $_GET["tags"];
	$tagcount = $_GET["tagcount"];
}

$sql = "UPDATE `album` SET `name` = '". $name ."', `date` = '". $date ."', `imageurl` = '". $imageurl ."', `sourceid` = '". $source ."' WHERE id = ". $id;

//echo $sql;


if($conn->query($sql) == TRUE){
	$sqlTag = "DELETE FROM link_album_tag WHERE albumid = ". $id;
	if($conn->query($sqlTag) == TRUE){
		$success = true;
		for($i = 0; $i < $tagcount; $i++){
			$sqlTemp = "INSERT INTO `link_album_tag` (`id`, `albumid`, `tagid`) VALUES (NULL, '". $id ."', '". $tags[$i] ."')";
			if($conn->query($sqlTemp) == FALSE)
				$success = false;
		}
		if($success){
			$jsondata["success"] = true;
		}else{
			$jasondata["success"] = false;
			$jsondata["data"] = array(
				'message' => 'Se actualizo el album y se borraron las relaciones con los tags previos, preo no se pudo hacer la relacion con tags nueva.'
			);	
		}
	}
	else{
		$jasondata["success"] = false;
		$jsondata["data"] = array(
			'message' => 'Se edito el album pero no se actualizaron las relaciones con los tags'
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