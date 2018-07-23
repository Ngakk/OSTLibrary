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

if(isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"])){
	$name = $_POST["username"];
	$mail = $_POST["email"];
	$password = $_POST["password"];
}

$sql = "INSERT INTO `usuario`(`id`, `name`, `pass`, `mail`, `clearance`) VALUES (NULL, '". $name ."', '". $password ."' , '". $mail ."', 0)";
if($conn->query($sql)){
	$last_id = $conn->insert_id;
	$sqldetails = "INSERT INTO `userdetails`(`id`, `userid`, `profileimage`, `guessroomid`, `trackready`, `gamescore`) 
	VALUES (NULL,". $last_id .", '', 0, 0, 0)";
	$last_id = $conn->insert_id;
	if($conn->query($sqldetails)){
		header("Location: ostguess/index.php");
		die();
	}
}
else{
	echo $sql;
}

$conn->close();

?>