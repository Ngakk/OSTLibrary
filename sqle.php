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

//$sql = "SELECT * FROM soundtrack";
$result = $conn->query($sql);
$number = 1;
while($row = $result->fetch_assoc()){
	/*$name = $row["name"];
	$name = str_replace(" ", "_", $name);
	$name = str_replace("'", "", $name);
	$name = str_replace(".", "", $name);
	$name = str_replace(",", "", $name);
	$name = str_replace("!", "", $name);
	$sql2 = "UPDATE soundtrack SET `file` = 'music/M/My_Hero_Academia_S1_OST/". $name .".mp3' WHERE id = ". $row["id"];*/
	
	//$sql2 = "INSERT INTO `link_soundtrack_tag` (`id`, `soundtrackid`, `tagid`, `repetitions`) VALUES (NULL, '". $row["id"] ."', '2', '1')";
	
	/*$sql2 = "UPDATE soundtrack SET `number` = ". $number." WHERE id = ". $row["id"];
	$number++;*/
	
	$sql2 = "UPDATE soundtrack SET `disc` = '1'";
	echo '<div>'. $sql2 .'</div>';
	
	$conn->query($sql2);
}

$conn->close();
?>