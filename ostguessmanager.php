<?php
$isLoggedIn = "false";
if(isset($_SESSION["loggedin"]))
	$isLoggedIn = $_SESSION["loggedin"];

?>
<!doctype html>
<html>
<head>
<title>OST Guess Manager</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/animate.css">

</head>

<body>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script>
	Pusher.logToConsole = true; //Solo mantener en debugeo
	//Creacion de conexion con pusher
	var pusher = new Pusher('242c1ebc2f45447381e3', {
	  wsHost: 'ws.pusherapp.com',
	  httpHost: 'sockjs.pusher.com',
	  encrypted: true,
	  authEndpoint: 'pusher/pusher_auth.php' //Lugar donde va a autenticar a los usuarios
	});

	//Se subscrive al canal de guesses y hago una funcion para responder
	var channel = pusher.subscribe('private-guess-channel');
	channel.bind('client-guess', function(data) {
	  alert(JSON.stringify(data));
	  channel.trigger('client-globalresponse', "yes");
	}); 
</script>
</body>

</html>