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
if(isset($_GET["id"])){
$sql = "SELECT usuario.*, userdetails.profileimage FROM usuario LEFT JOIN userdetails ON usuario.id = userdetails.userid WHERE usuario.id = ". $_GET["id"];
$result = $conn->query($sql);
$user = $result->fetch_assoc();
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
  <link href="css/dropzone.css" type="text/css" rel="stylesheet" />
</head>
<body>

<div style="background-color: #F2F4F3; height:100%">
<nav class="navbar navbar-default menu">
	<div class="col-sm-2"></div>
    <div class="col-md-8 container-fluid" id="navBardiv">
        <div class="navbar-header">
        	<a class="navbar-brand" href="#">OST Library</a>
        </div>
		<ul class="nav navbar-nav navbar-right">
		  <li id="profileButton" style="display: none;"><a href="#"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
		</ul>
    </div>
	<div class ="col-sm-2"></div>
</nav>
<div class="col-md-2 col-xs-0"></div>
<div class="mainmenu col-md-8 col-xs-12" id="mainmenu">
	<div class="col-md-8">
		<p id="error" style="display:none;"> Data doesn't meet requirements </p>
		<h3>Nombre de usuario:</h3>
		<div id="nameDisplay">
			<p id="namep" style="float:left"><?php echo $user["name"] ?></p>&nbsp;&nbsp;&nbsp;&nbsp;
			<button type="button" id="editName" style="display:none;">editar</button>
		</div>
		<div id="nameEdit" style="display:none;">
			<form>
				<input type="text" id="username">
				<button type="button" id="confirmName">Confirm</button>
				<button type="button" id="cancelName">Cancel</button>
			</form>
			
		</div>
		<h3>Correo electronico:</h3>
		<div id="mailDisplay">
			<p id="mailp" style="float:left"><?php echo $user["mail"] ?></p>&nbsp;&nbsp;&nbsp;&nbsp;
			<button type="button" id="editMail" style="display:none;" >editar</button>
		</div>
		<div id="mailEdit" style="display:none;">
			<form>
				<input type="text" id="mail">
				<button type="button" id="confirmMail">Confirm</button>
				<button type="button" id="cancelMail">Cancel</button>
			</form>
		</div>
	</div>
	<div class="col-md-4" style="text-align:center">
		<img id="profilepic" class="img-responsive" src="<?php echo $user["profileimage"] != "" ? $user["profileimage"] : "img/defaultProfile.png"; ?>">
		<button type="button" id="editImg" style="display:none;">Cambiar imagen</button>
		<form id="imgForm" style="display: none;">
			<input type="text" id="imgSource">
			<button type="button" id="confirm-Img">Confirm</button>
			<button type="button" id="cancel-Img">Cancel</button>
		</form>
	</div>
</div>
<div class="col-md-2 col-xs-0"></div>
</div>


<script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/jquerysession.js"></script>
<script src="js/dropzone.js"></script>
<script>
	var $_GET = {};
	document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
	   function decode(s) {
			return decodeURIComponent(s.split("+").join(" "));
		}
		$_GET[decode(arguments[1])] = decode(arguments[2]);
	});

	var owner = false;
	
	$(document).ready(function(event){
		console.log("redy");
		if($.session.get("userid") == $_GET["id"]){
			$("#editName").show();
			$("#editMail").show();
			$("#editImg").show();
			owner = true;
		}
		
		$("#editName").click(function(){
			if(owner){
				$("#nameDisplay").hide();
				$("#username").val($("#namep").html());
				$("#nameEdit").show();
			}
		});
		
		$("#editMail").click(function(){
			if(owner){
				$("#mailDisplay").hide();
				$("#mail").val($("#mailp").html());
				$("#mailEdit").show();
			}
		});
	
		$("#cancelName").click(function(){
			$("#nameDisplay").show();
			$("#nameEdit").hide();
		});
		
		$("#cancelMail").click(function(){
			$("#mailDisplay").show();
			$("#mailEdit").hide();
		});
		
		$("#confirmName").click(function(){
			if(owner){
				if($("#username").val().length >= 4 && /^[a-zA-Z0-9]*$/.test($("#username").val()) == true){
					$("#error").hide();
					var datos = {
						"userid" : $.session.get("userid"),
						"name": $("#username").val()
					}
					$.ajax({
						data: datos,
						url: "quickEdit/updateName.php",
						type: "post",
						success: function(response){
							if(response.success){
								$("#cancelName").click();
								$("#namep").html(datos["name"]);
							}
							else{
								console.log(datos);
							}
						},
						error: function(a, b, c){
							console.log(a);
							console.log(b);
							console.log(c);
						}
					});
				}
				else{
					$("#error").show();
				}
			}
		});
		
		$("#confirmMail").click(function(){
			if(owner){
				if($("#mail").val().length >= 4 && /^[a-zA-Z0-9@.]*$/.test($("#mail").val()) == true){
					$("#error").hide();
					var datos = {
						"userid" : $.session.get("userid"),
						"mail": $("#mail").val()
					}
					$.ajax({
						data: datos,
						url: "quickEdit/updateMail.php",
						type: "post",
						success: function(response){
							if(response.success){
								$("#cancelMail").click();
								$("#mailp").html(datos["mail"]);
							}
						}
					});
				}
				else{
					$("#error").show();
				}
			}
		});

		$("#editImg").click(function(){
			$(this).hide();
			$("#imgSource").val($("#profilepic").attr("src"));
			$("#imgForm").show();
		});	
		
		$("#confirm-Img").click(function(){
			console.log("img click");
			if(owner){
				if(ValidURL($("#imgSource").val())){
					$("#error").hide();
					console.log("valid url");
					var datos = {
						"userid" : $.session.get("userid"),
						"image": $("#imgSource").val()
					}
					$.ajax({
						data: datos,
						url: "quickEdit/updateImage.php",
						type: "post",
						success: function(response){
							console.log(response);
							if(response.success){
								$("#cancel-Img").click();
								$("#profilepic").attr('src', datos["image"] + '?' + Math.random());
							}
						},
						error: function(a, b, c){
							console.log(a);
							console.log(b);
							console.log(c);
						}
					});
				}
				else if($("#imgSource").val() != 'img/defaultProfile.png'){
					$("#error").show();
				}
			}
		});
		
		$("#cancel-Img").click(function(){
			$("#imgForm").hide();
			$("#editImg").show();
		});
	});
	
	function ValidURL(str) {
	  var pattern = new RegExp(/^(?:(?:https?|ftp):\/\/)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/); // fragment locater
	  if(!pattern.test(str)) {
		return false;
	  } else {
		return true;
	  }
	}
</script>
</body>
</html>
<?php } ?>