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

<!-- Modales -->

<div id="modalJoinRoom" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="roomPass"> Contraseña: </label>
            <input type="text" class="form-control" id="roomPass">
          </div>
        </form>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-default" id="joinRoomBtn">Join</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<input type="text" id="tempPass">
<!-- contenido -->

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
<div class="col-sm-2"></div>
<div class="mainmenu col-md-8" id="mainmenu">
<div class="col-sm-2"></div>

  <div id="login" class="animated" style="display: none;">
	<h3> Inicia sesion para poder jugar </h3>
	<form id="loginForm">
	  <label for="username">Nombre de usuario:</label>
	  <input type="text" id="username" class="form-control">
	  <label for="password">Contraseña:</label>
	  <input type="password" id="password" class="form-control">
	  <button style="margin-top:5px" type="submit" class="btn btn-default">Login</button>
	</form>
  </div>
  
  <div id="loginerror"  class="animated" style="display: none;">
    <p> Usuario o contraseña no correctos</p>
  </div>
  
  <div id="menuoptions"  class="animated" style="display: none;">
	<h3>Escoge una opcion </h3>
	<button type="button" class="btn btn-default" id="newRoom">Crear sala nueva</button>
	<button type="button" class="btn btn-default" id="oldRoom">Unirse a una sala existente</button>
  </div>
  
  <div id="createRoom" class="animated" style="display: none;">
    <div style="width:100%">
	  <h3> Crea nueva sala </h3>
	  <button  type="button" class="btn btn-default" id="backbtn1">Regresar</button>
	</div>
	<form id="newRoomForm">
	  <label for="roomName">Nombre de la sala:</label>
	  <input type="text" id="roomName" class="form-control">
	  <label for="roomPassword">Contraseña:</label>
	  <input type="roomPassword" id="password" class="form-control">
	  <button style="margin-top:5px" type="submit" class="btn btn-default">Crear</button>
	</form>
  </div>
  
  <div id="joinRoom" class="animated" style="display: none;">
    <div style="width:100%">
	  <h3> Unirse a una sala </h3>
	  <button type="button" class="btn btn-default" id="backbtn2">Regresar</button>
	  <button type="button" data-toggle="modal" data-target="#modalJoinRoom">Open Modal</button>
	  </div>
	<div id="roomDisplay">
	
	</div>
  </div>
</div>
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

	$(document).ready(function(event){
		if(typeof $.session.get('loggedin') == 'undefined'){
			$.sesion.set('loggedin', "false");
		}
		else{
			console.log($.session.get('loggedin'));
		}
		if($.session.get('loggedin') == "false"){
			$("#login").show();
			$("#login").animateCss('fadeIn');
		}
		else{
			$("#menuoptions").show();
			$("#menuoptions").animateCss('fadeIn');
		}
		
		$("#newRoom").click(function(){
			$("#menuoptions").animateCss('fadeOut', function(){
				$("#menuoptions").hide();
				$("#createRoom").show();
				$("#createRoom").animateCss('fadeIn');
			});
		});
		
		$("#oldRoom").click(function(){
			$("#menuoptions").animateCss('fadeOut', function(){
				$("#menuoptions").hide();
				$("#joinRoom").show();
				$("#joinRoom").animateCss('fadeIn');
			});
			
			loadRooms();
		});
		
		$("#backbtn1").click(function(){
			$("#createRoom").animateCss('fadeOut', function(){
				$("#createRoom").hide();
				$("#menuoptions").show();
				$("#menuoptions").animateCss('fadeIn');
			});
		});
		
		$("#backbtn2").click(function(){
			$("#joinRoom").animateCss('fadeOut', function(){
				$("#joinRoom").hide();
				$("#menuoptions").show();
				$("#menuoptions").animateCss('fadeIn');
			});
		});
		
		$(document).on("click", ".joinRoom", function(){
			$("#joinRoomBtn").attr("roomId", $(this).attr("roomId"));
			$('#modalJoinRoom').modal('show');
		});
		
		$("#joinRoomBtn").click(function(){
			joinRoom($("#joinRoomBtn").attr("roomId"));
		});
	});
	
	$("#loginForm").submit(function(event) {
    	event.preventDefault();
		var credenciales = {
			"username" : $("#username").val(),
			"password" : $("#password").val()
		};
		$.ajax({
			data: credenciales,
			url: "../login.php",
			type: "post",
			success: function (response){
				var json = response;
				//var obj = JSON.parse(json);
				if(json.success)
				{
					console.log(json);
					$.session.set('loggedin', 'true');
					$.session.set('username', json.data["user"]["name"]);
					$.session.set('userid', json.data["user"]["id"]);
					$("#login").animateCss("fadeOut", function(){
						$("#login").hide();
						$("#menuoptions").show();
						$("#menuoptions").animateCss('fadeIn');
					});
					
					$("#loginerror").animateCss("fadeOut", function(){
						$("#loginerror").hide();
					});
				}
				else
				{
					$("#loginerror").show();
					$("#loginerror").animateCss("fadeIn");
				}
			},
			error: function(){
				console.log("ajax_error");
			}
		});
	});
	
	function loadRooms(){
		$("#roomDisplay").html("");
		fetchRooms().then(function(data){
			var html = "";
			var datos = data.data;
			console.log(datos);
			var i = 0;
			while(typeof datos[i] != "undefined"){
				html +=
				"<div class='roomItemview'>"+
					"<div style='background-color:#F2F4F3;' class='roomItemleft'>"+
						"<h4 style='width:100%; display:table-cell; vertical-align:middle;'>"+ datos[i]['name'] +"</h4>"+
						"<p> de: "+ datos[i]["username"] +" </p>"+
					"</div>"+
					"<div style='background-color:#F2F4F3;' class='roomItemright'>"+
						"<button type='button' class='btn joinRoom' style='display:table-cell; vertical-align:middle;' data-toggle='modal' data-target='#modalJoinRoom' roomId='"+ datos[i]["id"] +"'> Join </button>"+
					"</div>"+
				"</div>";
				i++;
			}
			$("#roomDisplay").append(html);
		});
	}
	
	function fetchRooms(){
		return Promise.resolve($.ajax({
			url: "fetchRooms.php",
			type: "post",
			success: function (response){
				var json = response;
				//var obj = JSON.parse(json);
				if(json.success)
				{
					console.log(json.success);	
				}
				else
				{
					console.log("failure");
				}
			},
			error: function(){
				console.log("ajax_errorxxx");
				console.log(table + " " * page);
			}
		}));
	}
	
	function joinRoom(id){
		var datos = {
			"userid" : $.session.get("userid"),
			"roomid" : id,
			"pass" : $("#tempPass").val()
		}
		console.log("joinRoom try " + datos);
		$.ajax({
			data: datos,
			url: "re/joinRoomRequest.php",
			type: "post",
			success: function(response){
				if(response.success){
					
				}
				else{
					alert(response.message);
				}
			},
			error: function(p1, p2, p3){
				console.log(p1);
				console.log(p2);
				console.log(p3);
			}
		})
		///TODO: hacer que el usuario se redireccione a room.php si un ajax regresa succes
	}
	
	$.fn.extend({
	  animateCss: function(animationName, callback) {
		var animationEnd = (function(el) {
		  var animations = {
			animation: 'animationend',
			OAnimation: 'oAnimationEnd',
			MozAnimation: 'mozAnimationEnd',
			WebkitAnimation: 'webkitAnimationEnd',
		  };

		  for (var t in animations) {
			if (el.style[t] !== undefined) {
			  return animations[t];
			}
		  }
		})(document.createElement('div'));

		this.addClass('animated ' + animationName).one(animationEnd, function() {
		  $(this).removeClass('animated ' + animationName);

		  if (typeof callback === 'function') callback();
		});

		return this;
	  },
	});

</script>
</body>

</html>