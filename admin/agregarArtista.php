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


if(isset($_POST['fullname']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['date']) 
	&& isset($_POST['pais']) && isset($_POST['imageurl'])){
	$fullname = $_POST['fullname'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$date = $_POST['date'];
	$pais = $_POST['pais'];
	$imageurl = $_POST["imageurl"];
}
else{
	$jsondata["success"] = false;
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
	$conn->close();
}

$sql = "INSERT INTO `artista` (`id`, `fullname`, `firstname`, `lastname`, `date`, `pais`, `imageurl`, `rating`, `description`, `threadid`)
 VALUES (NULL, '". $fullname."', '". $firstname ."', '". $lastname ."', '". $date ."', '". $pais ."', '". $imageurl ."', '0', '', 0)";

//echo $sql;

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