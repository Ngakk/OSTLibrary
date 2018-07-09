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

if(isset($_POST["table"]) && isset($_POST["column"]) && isset($_POST["input"])){
	$table = $_POST["table"];
	$column = $_POST["column"];
	$input = $_POST["input"];	
}
/*else{
	$jsondata["success"] = false;
	header('Content-type: application/json; charset=utf-8');
	echo json_encode($jsondata, JSON_FORCE_OBJECT);
	$conn->close();
}*/

if(isset($_GET["table"]) && isset($_GET["column"]) && isset($_GET["input"])){
	$table = $_GET["table"];
	$column = $_GET["column"];
	$input = $_GET["input"];	
}



$sql = "SELECT * FROM ". $table ." WHERE ". $column ." LIKE '". $input ."%' LIMIT 10";
$sql2 = "SELECT * FROM ". $table ." WHERE ". $column ." LIKE '%". $input ."' OR '%". $input ."%' LIMIT 10";


//echo $sql;
//echo $sql2;

$result = $conn->query($sql);
$result2 = $conn->query($sql2);

if($result->num_rows>0 || $result2->num_rows>0){
	$jsondata["success"] = true;
	$jsondata["data"]["datos"] = array();
	while($row = $result->fetch_assoc() ) {
		$jsondata["data"]["datos"][] = $row;
	}
	while($row2 = $result2->fetch_assoc()){
		$duplicated = false;
		foreach($jsondata["data"]["datos"] as $d){
			if($d == $row2)
				$duplicated = true;
		}
		if(!$duplicated)
			$jsondata["data"]["datos"][] = $row2;
		
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