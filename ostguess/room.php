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
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/animate.css">

</head>
<body>

<div id="theBidD" style="background-color: #F2F4F3; height:100%; display: none" >
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
<!-- Chat Input V1-->
<div class="ostguessblock blockbottomright">
    <form id="guessForm">
    	<div class="form-group insideblock" id="guessInputDiv">
        	<p>Make a guess:</p>
    		<div class="ui fluid search selection dropdown">
              <input type="hidden" id="hiddenGuessInput">
              <i class="dropdown icon"></i>
              <div class="default text">Select a source</div>
              <div class="menu" id="guessSelectMenu">
                  <?php
				  	$sql = "SELECT * FROM source ORDER BY name";
					$result = $conn->query($sql);
					while($row = $result->fetch_assoc()){
						echo '<div class="item" data-value="'. $row["id"] .'"><i></i>'. $row["name"] .'</div>';
					}
				  ?>
              </div>
           </div>
		   <button type="submit" class="btn btn-primary" id="guessSubmit">Guess</button>
        </div>
    </form>
</div>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>
<link rel="stylesheet" type="text/css" href="../css/Semantic-UI-CSS-master/semantic.min.css">
<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
<script src="../css/Semantic-UI-CSS-master/semantic.min.js"></script>
<script src="../js/jquerysession.js"></script>
<script>

	Pusher.logToConsole = true;	//Solo mantener en debugeo
	//Creacion de conexion con pusher
	var pusher = new Pusher('242c1ebc2f45447381e3', {
	  wsHost: 'ws.pusherapp.com',
	  httpHost: 'sockjs.pusher.com',
	  encrypted: true,
	  authEndpoint: '../pusher/pusher_auth.php'//Lugar donde va a autenticar a los usuarios
	});
	//Se subscrive al canal de guesses y hago una funcion para responder
	var channel = pusher.subscribe('guess-channel-' + $.session.get("roomid"));
	channel.bind('pusher:subscription_succeeded', function() {
		if(typeof $.session.get("roomid") != 'undefined'){
			$("#theBidD").show();
			console.log($.session.get("userid"));
			console.log($.session.get("roomid"));
			connectToRoom($.session.get("userid"), $.session.get("roomid"));
		}
		else{
			window.location.replace("index.php");	
		}
	});
	
	channel.bind('pusher:subscription_failed', function(){
			window.location.replace("index.php");
	});
	//Aqui responde a la respuesta de ostguessmanager que le da atodos en la sala
	channel.bind('client-global-response', function(data) {
		var html = "<p>";
		if(!data["isright"]){
			html += data["username"] + ": " + data["message"];
		} else {
			html += data["username"] + " got the correct answer.";
		}
		html += "</p>";
		$(".guessChat").append(html);
		$('.guessChat').scrollTop($('.guessChat')[0].scrollHeight);
	}); 
	
	channel.bind('client-global-updateplayers', function(data){
		console.log("other players:");
		console.log(data);
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
	
	function connectToRoom(userid, roomid){
		var datos = {
			"userid" : userid,
			"roomid" : roomid	
		}
		$.ajax({
			data: datos,
			url: "re/userJoinsRoom.php",
			type: "post",
			success: function(response){
				console.log("connectToRoom success");
			},
			error: function(event, xhr, options, exc){
				console.log("ajax_error_can't_join_room");
				console.log(event);
				console.log(xhr);
				console.log(options);
				console.log(exc);
			}	
		});
	}
	
	$("#guessForm").submit(function(event) {
    	event.preventDefault();
		makeAGuess();
	});
	
	function makeAGuess(){//Recive el id de el source que va a adivinar
		//TODO: manda un ajax a un php que checa si la respuesta es correcta y les responde a todos en la sala
		//va a medias
		console.log("guess try");
		var id = $(".item.active.selected").attr("data-value");
		var datos = {
			"userid" : 4, ///TODO: usar la id del usuario conectado
			"guessid" : id,
			"guessroomid" : 1 //Cambiar por el id del cuarto
		}
		$.ajax({
			data: datos,
			url: "../ostguess/ostguessmanager.php",
			type: "post",
			success: function (response){
				console.log("guess success");
			},
			error: function(event,xhr,options,exc){
				console.log("ajax_error_can't_send_guess");
				console.log(event);
				console.log(xhr);
				console.log(options);
				console.log(exc);
			}
		});
	}
	
	$(function() {
    	$('.ui.dropdown').dropdown();
	});
</script>
</body>

</html>