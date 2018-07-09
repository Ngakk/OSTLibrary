<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ostlibrary";

if(isset($_POST['table']) && isset($_POST['id'])){
	$table = $_POST['table'];
	$id = $_POST['id'];
}
else{
	$table = "";
	$id = "0";
}

if(isset($_GET['table']) && isset($_GET['id']))
{
	$table = $_GET["table"];
	$id=$_GET["id"];
}

$conn = new mysqli($servername, $username, $password, $dbname);
//Check connection
if($conn->connect_error){
	die("Conecction failed: " . $conn->connect_error);
}

$sql = "DELETE FROM ". $table ." WHERE id = ". $id;

//echo $sql;
if($table == "soundtrack"){
	$sqlArt = "DELETE FROM link_soundtrack_artista WHERE soundtrackid = ". $id;
	$sqlTags = "DELETE FROM link_soundtrack_tag WHERE soundtrackid = ". $id;
	if(!$conn->query($sqlArt) || !$conn->query($sqlTags)){
		$jasondata["success"] = false;
		$jsondata["data"] = array(
			'message' => 'No se encontro ningun resultado.'
		);	
		header('Content-type: application/json; charset=utf-8');
		echo json_encode($jsondata, JSON_FORCE_OBJECT);

		$conn->close();
	}
}
if($conn->query($sql) == TRUE){
	$jsondata["success"] = true;
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