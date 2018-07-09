<?php
$isLoggedIn = "false";
if(isset($_SESSION["loggedin"]))
	$isLoggedIn = $_SESSION["loggedin"];

?>
<!doctype html>
<html>
<head>
<title>OST Guess</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/animate.css">

</head>

<?php
/*
require 'vendor/autoload.php';

$pusher = new Pusher\Pusher("242c1ebc2f45447381e3", "14a36ffce25dde568753", "553238", array('cluster' => 'mt1'));

$pusher->trigger('private-guess-channel', 'client-guess', array('message' => 'hello world'));
*/
?>
<body>

<div style="background-color: #F2F4F3; height:100%">
<nav class="navbar navbar-default menu">
	<div class="col-sm-2"></div>
    <div class="col-md-8" id="navBardiv">
        <div class="navbar-header">
        	<a class="navbar-brand" href="#">OST Library</a>
        </div>
    </div>
	<div class ="col-sm-2"></div>
</nav>
<!-- Game -->
<div class="ostguessblock blocktopleft ">
    
</div>
<!-- Chat -->
<div class="ostguessblock blocktopright">
    <div class="form-control guessChat" id="guessChat"></div>
</div>
<!-- Game score-->
<div class="ostguessblock blockbottomleft">
    
</div>
<!-- Chat Input -->
<div class="ostguessblock blockbottomright">
    <form id="">
    	<div class="form-group insideblock">
    		<label for="guessInput">Make a guess: </label>
        	<input type="text" class="form-control" id="guessInput">
            <div id="guessesDropdown" class="dropdown-content">
              <div class="guessSource"><a href="#home">Home</a></div>
              <div class="guessSource"><a href="#about">About</a></div>
              <div class="guessSource"><a href="#contact">Contact</a></div>
              <div class="guessSource"><a href="#1">Killer Instinct</a></div>
              <div class="guessSource"><a href="#2">Donkey Kong Country</a></div>
              <div class="guessSource"><a href="#3">Celeste</a></div>
              <div class="guessSource"><a href="#4">My Hero Academia</a></div>
              <div class="guessSource"><a href="#5">Cowboy Bebop</a></div>
            </div>
        </div>
    </form>
</div>

</div>


<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<script>

	Pusher.logToConsole = true;	//Solo mantener en debugeo
	//Creacion de conexion con pusher
	var pusher = new Pusher('242c1ebc2f45447381e3', {
	  wsHost: 'ws.pusherapp.com',
	  httpHost: 'sockjs.pusher.com',
	  encrypted: true,
	  authEndpoint: 'pusher/pusher_auth.php'//Lugar donde va a autenticar a los usuarios
	});
	//Se subscrive al canal de guesses y hago una funcion para responder
	var channel = pusher.subscribe('private-guess-channel');
	channel.bind('pusher:subscription_succeeded', function() {
	  var data = {"message" : "hello"}
	  var triggered = channel.trigger('client-guess', data);
	});
	//Aqui responde a la respuesta de ostguessmanager que le da atodos en la sala
	channel.bind('client-globalresponse', function(data) {
	  alert(JSON.stringify(data));
	}); 
	
	$(document).ready(function(event){
		$("#guessInput").on("keyup", function(){
			if($(this).val().length >= 3){
				$("#guessesDropdown").addClass("show");
				guessFilterFunction();
			}
			else{
				$("#guessesDropdown").removeClass("show");
			}
		});
	});
	
	$("#guessForm").submit(function(event) {
    	event.preventDefault();
		makeAGuess(1);
	});
	
	function makeAGuess(id){//Recive el id de el source que va a adivinar
		//TODO: manda un ajax a un php que checa si la respuesta es correcta y les responde a todos en la sala
	}
	
	function guessFilterFunction() {
		/*var input, filter, ul, li, a, i;
		input = document.getElementById("guessInput");
		filter = input.value.toUpperCase();
		div = document.getElementById("guessesDropdown");
		a = div.getElementsByTagName("a");
		for (i = 0; i < a.length; i++) {
			if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
				a[i].style.display = "";
			} else {
				a[i].style.display = "none";
			}
		}*/
		
		var input, filter, ul, li, a, i;
		input = document.getElementById("guessInput");
		filter = input.value.toUpperCase();
		div = document.getElementById("guessesDropdown");
		source = div.getElementsByClassName("guessSource");
		//TODO: acomodar a que jale con los divs de source
		for (i = 0; i < a.length; i++) {
			if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
				a[i].style.display = "";
			} else {
				a[i].style.display = "none";
			}
		}
		
	}
</script>
</body>

</html>