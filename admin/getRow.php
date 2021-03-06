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


if(isset($_POST['id']) && isset($_POST["table"])){
	$id = $_POST['id'];
	$table = $_POST["table"];
}
/*else{
	$jasondata["success"] = false;
	$jsondata["data"] = array(
		'message' => 'No se encontro ningun resultado.'
	);	
}*/

if(isset($_GET["id"]) && isset($_GET["table"]))
{
	$id = $_GET["id"];
	$table = $_GET["table"];
}

if($table == "contenido"){
	$sql = "SELECT contenido.*, seccion.name AS 'sectName' FROM contenido LEFT JOIN seccion ON (contenido.sectid = seccion.id) WHERE contenido.id = ". $id;
}
else if($table == "soundtrack"){
	$sql = "SELECT soundtrack.*, album.name AS albumName FROM `soundtrack` LEFT JOIN album ON (soundtrack.albumid = album.id) WHERE soundtrack.id = ". $id;
}
else if($table == "album"){
	$sql = "SELECT album.*, source.name AS sourceName, tag.name AS tagName, tag.id AS tagid FROM album LEFT JOIN source ON source.id = album.sourceid LEFT JOIN(link_album_tag LEFT JOIN tag ON tag.id = link_album_tag.tagid)ON link_album_tag.albumid = album.id WHERE album.id = ". $id;
}
else{
	$sql = "SELECT * FROM ". $table ." WHERE id = ". $id;
}
$result = $conn->query($sql);

if($result->num_rows>0){
	$jsondata["success"] = true;
	$jsondata["data"]["datos"] = array();
	while( $row = $result->fetch_assoc() ) {
		if($table == "contenido"){
			if($row["type"] == 'artista')
			{
				$sqlType = "SELECT * FROM ". $row['type'] ." WHERE id = ". $row['typeid'];
				$resultType = $conn->query($sqlType);
				$data = $resultType->fetch_assoc();
				$row["typeName"] = $data["name"] ." ". $data["apellidop"];
				
			} 
			else if($row["type"] != "0")
			{
				$sqlType = "SELECT name FROM ". $row['type'] ." WHERE id = ". $row['typeid'];
				$resultType = $conn->query($sqlType);
				$data = $resultType->fetch_assoc();
				$row["typeName"] = $data["name"];
			}
		}
		else if($table == "soundtrack"){
			$sqlArt = "SELECT DISTINCT link_soundtrack_artista.artistaid, artista.fullname
			FROM ((link_soundtrack_artista INNER JOIN soundtrack ON link_soundtrack_artista.soundtrackid = soundtrack.id) 
				INNER JOIN artista 
				ON link_soundtrack_artista.artistaid = artista.id) 
			WHERE soundtrack.id = ". $id;
			$resultArt = $conn->query($sqlArt);
			while($artRow = $resultArt->fetch_assoc()){
				$row["artista"][] = $artRow;
			}
			
			$sqlTag = "SELECT DISTINCT link_soundtrack_tag.tagid, tag.name
			FROM ((link_soundtrack_tag INNER JOIN soundtrack ON link_soundtrack_tag.soundtrackid = soundtrack.id) 
				INNER JOIN tag 
				ON link_soundtrack_tag.tagid = tag.id) 
			WHERE soundtrack.id = ". $id;
			$resultTag = $conn->query($sqlTag);
			while($tagRow = $resultTag->fetch_assoc()){
				$row["tags"][] = $tagRow;
			}
			
		}
		$jsondata["data"]["datos"][] = $row;
	}
	$sqlcount = "SELECT COUNT(*) AS count FROM ". $table;
	$countResult = $conn->query($sqlcount);
	$count = $countResult->fetch_assoc();
	$jsondata["data"]["datos"]["count"] = $count["count"];
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