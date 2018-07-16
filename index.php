<?php
$isLoggedIn = "false";
if(isset($_SESSION["loggedin"]))
	$isLoggedIn = $_SESSION["loggedin"];

?>
<!doctype html>
<html>
<head>
  <title>OST Library</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/animate.css">
  
</head>

<body>

<nav class="navbar navbar-default menu">
	<div class="col-sm-2"></div>
    <div class="col-md-8" id="navBardiv">
        <div class="navbar-header">
        	<a class="navbar-brand" href="#" style="color:#50F5FF">OST Library</a>
        </div>
        
		<ul class="nav navbar-nav navbar-right" id="signup">
			<li class="navButton"><a href="#" style="color:#50F5FF"> Registrarse </a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right" id="login">
        	<li class="navButton"><a href="#" style="color:#50F5FF"> Ingresar </a></li>
        </ul>
		
		<ul class="nav navbar-nav navbar-right" id="exit">
			<li class="navButton"><a href="#" style="color:#50F5FF"> Salir </a></li>
		</ul>
		<ul class="nav navbar-nav navbar-right" id="perfil">
			<li class="navButton"><a href="#" style="color:#50F5FF"> Perfil </a></li>
		</ul>
		
		
        <form class="navbar-form navbar-right" action="/action_page.php" id="search">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Search">
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>
    </div>
	<div class ="col-sm-2"></div>
</nav>

<div class="container-fluid">
	<div class="col-sm-2"></div>
    <div class="col-md-8 main">
    	<!-- Contenido Principal -->
		<div class="row displayer" id="mainContent">
		</div>
		<!-- Log In -->
		<div class="row displayer form-group" id="loginForm">
			<form action="" method="">
				<label for="username">Name:</label>
				<input minlength="3" type="text" class="form-control" id="username" name="username" required>
				<label for="password">Password:</label>
				<input type="password" class="form-control" id="password" name="password">  
				<input type="submit" id="loginBtn">
			</form>
		</div>
		<!-- Registro -->
		<div class="row displayer form-group" id="signupForm">
			<form action="" method="">
				<label for="usernameR">Name:</label>
				<input type="text" class="form-control" id="usernameR" name="usernameR">
				<label for="passwordR">Password:</label>
				<input type="password" class="form-control" id="passwordR" name="passwordR">
				<label for="confirmPass">Confirm password:</label>
				<input type="password" class="form-control" id="confirmPass" name="confirmPass">
				<label for="email"> Email: </label>
				<input type="text" class="form-control" id="email" name="email">
				<input type="submit" id="signupBtn">
			</form>
		</div>
    </div>
    <div class="col-sm-2"></div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/validate.min.js"></script>
<script src="js/jquerysession.js"></script>
<script>
	var currentSection = "secciones";
	//var logged = "<?php echo $isLoggedIn ?>";
	var logged = $.session.get('loggedin');
	
	$(document).ready(function(event){
		
		//Cambios al ingresar
		console.log("user " + username);
		if(logged == "true"){
			console.log("is logged");
			$("#login").hide();
			$("#signup").hide();
		}
		else if (logged = "false"){
			console.log("not logged: " + logged);
			$("#perfil").hide();
			$("#exit").hide();
		}
		
		$("#loginForm").hide();
		$("#signupForm").hide();
		
		//Carga de secciones y contenido
		FetchContent().then(function(data){
			//console.log(data.data.datos);
			var datos = data.data.datos;
			var i = 0;
			while(typeof datos[i] != "undefined"){
				AddSection(datos[i]);
				i++;
			}
			$("#sectid1").children().addClass("active");
			$(".content").hide();
			$(".sectid1").show();
		});
		
		//Funciones en click
		$(document.body).on("click", ".navbar-nav", function(){
			$(".active").removeClass("active");
			$(this).children().addClass("active");
			changeSection($(this).attr("id"));
		});
		
		$("#loginBtn").click(function(){
			LogIn($("#username").val(), $("#password").val());
		});
		
		$("#exit").click(function(){
			LogOut();	
		});
	});
	
	function LogIn(username, password){
		console.log("sent: " + username + " " + password);
		var credenciales = {
			"username" : username,
			"password" : password
		};
		$.ajax({
			data: credenciales,
			url: "login.php",
			type: "post",
			success: function (response){
				var json = response;
				//var obj = JSON.parse(json);
				if(json.success)
				{
					$.session.set('loggedin', 'true');
					$.session.set('username', json["user"]["name"]);
					$.session.set('userid', json["user"]["id"]);
					location.reload();
				}
				else
				{
					console.log("failure");
				}
			},
			error: function(){
				console.log("ajax_error");
			}
		});
	}
	
	function LogOut(){
		$.session.set('loggedin', 'false');
		$.session.remove('username');
		location.reload();
	}
	
	function FetchContent(){
		return Promise.resolve($.ajax({
			url: "fetchContent.php",
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
				console.log("ajax_error");
			}
		}));
	}

	function AddSection(data){
		$("#navBardiv").append('<ul class="nav navbar-nav" id="sectid' + data["id"] +'"><li class="navButton"><a href="#" style="color:#50F5FF" id="' + data["name"] +'">' + data["name"] + '</a></li></ul>');
		AddContent(data.contenido);
	}
	
	function AddContent(data){
		var i = 0;
		while(typeof data[i] != "undefined")
		{
			console.log("sectid: " + data[i].sectid + ", " + data[i].title);
			var content = "";
			content += '<div class="row displayer content sectid' + data[i].sectid + '" id="contenido' + data[i].id +'">';
			content += '<h1>' + data[i].title + '</h1>';
			content += '<p>' + data[i].texto + '</p>';
			switch(data[i].type)
			{
				case "album":
					//imagen
					content += '<div class="col-xs-4"><img class="img-responsive" src="' + data[i].typeData.imageurl + '" id="mImg"></div>';
					//columna de la derecha
					content += '<div class="col-xs-8"><p><strong>Nombre: </strong>' + data[i].typeData.name + '</p><p><strong>Fuente: </strong>'+ data[i].typeData.source +'</p><p><strong> Fecha de lanzamiento: </strong>' + data[i].typeData.date + '</p><p><strong> Interpretes colaboradores: </strong>' + 'temp' + '</div>';
					break;
				case "artista":
					content += '<div class="col-xs-8"><p><strong>Nombre: </strong>' + '' + ' ' + '' + '</p><p><strong> Pais: </strong>' + '' + '</p><p><strong> Fecha de nacimiento: </strong>' + '' + '</div>';
					break;
				default:
				
					break;	
			}
			
			content += '</div>';
			$("#mainContent").append(content);
			
			i++;	
		}
	}
	
	function changeSection(buttonId){
		switch(buttonId)
		{
			case "login":
				if(currentSection == "signup"){
					$("#signupForm").hide("fast", function(){
						$("#loginForm").show("fast");	
					});
				} 
				else if(currentSection == buttonId){
				}
				else{
					$("#mainContent").hide("fast", function(){
						$("#loginForm").show("fast");	
					});
				} 
				break;
			case "signup":
				if(currentSection == "login"){
					$("#loginForm").hide("fast", function(){
						$("#signupForm").show("fast");	
					});
				} 
				else if(currentSection == buttonId){
				}
				else{
					$("#mainContent").hide("fast", function(){
						$("#signupForm").show("fast");	
					});
				} 
				break;
			default:
				console.log("changesection_default");
				if(currentSection == "login"){
					$("#loginForm").hide("fast", function(){
						$("#mainContent").show("fast");
						$(".content").hide();	
						$("." + buttonId).show();
					});
				} 
				else if(currentSection == "signup"){
					$("#signupForm").hide("fast", function(){
						$("#mainContent").show("fast");	
						$(".content").hide();	
						$("." + buttonId).show();
					});
				}
				else if(currentSection == buttonId){
				}
				else{
					$("#mainContent").hide("fast", function(){
						$("#mainContent").show("fast");	
						$(".content").hide();	
						$("." + buttonId).show();
					});
				} 
				break;
		}
		currentSection = buttonId;
		console.log(currentSection);
	}
	
	var form = document.querySelector("#loginForm");
    form.addEventListener("submit", function(ev) {
		ev.preventDefault();
		//handleFormSubmit(form);
    });
	/*
	var form2 = document.querySelector("#signupForm");
    form2.addEventListener("submit", function(ev) {
		ev.preventDefault();
		//handleFormSubmit(form2);
    });*/
	
	var form3 = document.querySelector("#search");
    form3.addEventListener("submit", function(ev) {
		ev.preventDefault();
		//handleFormSubmit(form3);
    });
</script>

</body>
</html>