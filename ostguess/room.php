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

<div id="theBidD" class="container" style="background-color: #F2F4F3; height:100%; display: none" >
	<nav class="navbar navbar-default menu">
		<div class="col-sm-2"></div>
		<div class="col-md-8" id="navBardiv">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">OST Library</a>
			</div>
		</div>
		<div class="col-sm-2"></div>
	</nav>
	<div class="col-sm-2"></div>
	<div class="col-md-8" style="height: 100%;">
		<!-- Game -->
		<div class="blocktrack row ostguessblock">
			<button type="button" class="btn" id="testload">Load</button>
			<button type="button" class="btn" id="testplay">Play</button>
		</div>
		<!-- Chat -->
		<div class="row ostguessblock">
			<div class="form-control guessChat" id="guessChat"></div>
		</div>
		<!-- Game score-->
		<div class="row ostguessblock">
			
		</div>
		<!-- Chat Input V1-->
		<div class="row ostguessblock">
			<form id="guessForm">
				<div class="form-group insideblock" id="guessInputDiv">
					<p>Make a guess:</p>
					<div class="ui fluid search selection dropdown">
					  <input type="hidden" id="hiddenGuessInput">
					  <i class="dropdown icon"></i>
					  <div class="default text">Select a source</div>
					  <div class="menu" id="guessSelectMenu">
						  <div class="item" data-value="2"><i></i>Doki Doki Literature Club!</div><div class="item" data-value="3"><i></i>Donkey Kong Country</div><div class="item" data-value="1"><i></i>Killer Instinct</div><div class="item" data-value="5"><i></i>Megalo Box</div><div class="item" data-value="6"><i></i>My Hero Academia (Season 1)</div><div class="item" data-value="4"><i></i>Outwitters</div>					  </div>
				   </div>
				   <button type="submit" class="btn btn-primary" id="guessSubmit">Guess</button>
				</div>
			</form>
		</div>
	</div>
	<div class="col-sm-2"></div>
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
<script src="../howler/dist/howler.js"></script>
<script>

	//Audio
	var sound = new Howl({
		src: [''],
		autoplay: false,
		preload: false
	});
	var connected = false;
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
			connectToRoom($.session.get("userid"), $.session.get("roomid"));
		}
		else{
			console.log("no room id");
			window.location.replace("index.php");	
		}
	});
	//Si falla la subsripción, lo regresa a el index
	channel.bind('pusher:subscription_failed', function(){
			console.log("connection fail");
			window.location.replace("index.php");
	});
	//Aqui responde a la respuesta de ostguessmanager que le da atodos en la sala
	channel.bind('client-global-response', function(data) {
		var html = "<p>";
		if(!data["isright"]){
			html += data["username"] + ": " + data["message"];
		} else {
			//Aqui te notifica cuando alguien ya le atinó, muestra los datos de la cancion y deja al jugador detenerla, mutearla, etc. mientras se carga la siguiente cancion
			html += data["username"] + " got the correct answer.";
		}
		html += "</p>";
		$(".guessChat").append(html);
		$('.guessChat').scrollTop($('.guessChat')[0].scrollHeight);
	}); 
	//Aqui se actualizan los jugadores en la sala
	channel.bind('client-global-updateplayers', function(data){
		console.log("other players:");
		console.log(data);
	});
	
	//El servidor le avisa al cliente que ya todos los usuarios cargaron y que ya va a empezar a tocar, se baja el audio de la cancion anterior y, despues de un corto delay, comienza la siguiente
	channel.bind('client-global-trackready', function(data){
		
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
		
		$("#guessForm").submit(function(event) {
			event.preventDefault();
			makeAGuess();
		});
		//testing
		$("#testload").click(function(){
			sound.unload();
			sound = new Howl({
				src: ['../music/k/killer_cuts/Yo_Check_This_Out!.mp3'],
				volume: 1.0,
				loop: false,
				autoplay: false,
				html5: true,
				onload: function(){
				  console.log("track loaded");
				},
				onend: function(){
				  console.log("track finished");	
				}
			});
			sound.load();
			console.log("load start");
		});
		
		$("#testplay").click(function(){
			sound.play();
		});
		
	});
	
	window.onbeforeunload = confirmExit;
	function confirmExit()
	{	
		if(connected)
			return "You have attempted to leave this page.  If you leave the page you will leave the current game and won't be able to join back.  Are you sure you want to exit this page?";
	}
	
	window.addEventListener('unload', function(event) {
		console.log("onunload");
        if(connected)
		{
			var datos = {
				"userid": $.session.get("userid"),
				"roomid": $.session.get("roomid")
			}	
			$.ajax({
				data: datos,
				url: "re/userExitRoom.php",
				type: "post",
				beforeSend: function(){
					console.log("before send");
				},
				success: function(response){
					$.session.remove("roomid");
				}
			});
		}
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
				connected = true;
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