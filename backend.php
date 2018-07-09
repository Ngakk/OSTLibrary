<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title> Backend </title>
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
        
        <ul class="nav navbar-nav" id="usuario" page="1">
        	<li class="navButton"><a href="#" style="color:#50F5FF"> Usuarios </a></li>
        </ul>
        
        <ul class="nav navbar-nav" id="seccion" page="1">
        	<li class="navButton"><a href="#" style="color:#50F5FF"> Secciones </a></li>
        </ul>
        
        <ul class="nav navbar-nav" id="contenido" page="1">
        	<li class="navButton"><a href="#" style="color:#50F5FF"> Contenido </a></li>
        </ul>
        
        <ul class="nav navbar-nav" id="album" page="1">
        	<li class="navButton"><a href="#" style="color:#50F5FF"> Albumes </a></li>
        </ul>
        
        <ul class="nav navbar-nav" id="artista" page="1">
        	<li class="navButton"><a href="#" style="color:#50F5FF"> Artistas </a></li>
        </ul>
        
        <ul class="nav navbar-nav" id="soundtrack" page="1">
        	<li class="navButton"><a href="#" style="color:#50F5FF"> Soundtracks </a></li>
        </ul>
    </div>
	<div class ="col-sm-2"></div>
</nav>


<!-- Inicio -->
<div class="container">
	<div>
		<input class="form-control" id="tableFilterInput" type="text" placeholder="Search..">
	</div>
    <div class="row usuario displayer">
      <h2> Usuarios: </h2>
      <button type="button" class="btn btn-primary" data-toggle='modal' data-target='#modalAgregarUsuario' tabla='tablaUsuario' userId=''>Agregar usuario</button>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Contraseña</th>
            <th>Correo</th>
            <th>Fecha de nacimiento</th>
            <th>Imagen</th>
            <th>Nivel administrativo</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody id="tablaUsuario">
        </tbody>
      </table>
      <ul class="pagination" id="paginationUsuario">

	  </ul>
      
    </div>
    <div class="row seccion displayer">
      <h2> Secciones: </h2>
      <button type="button" class="btn btn-primary" data-toggle='modal' data-target='#modalAgregarSeccion' tabla='tablaSeccion' userId=''>Agregar secciones</button>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Nivel</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody id="tablaSeccion">
        </tbody>
      </table>
      <ul class="pagination" id="paginationSeccion">

	  </ul>
      
    </div>
    <div class="row contenido displayer">
      <h2> Contenido: </h2>
      <button type="button" class="btn btn-primary" data-toggle='modal' data-target='#modalAgregarContenido' tabla='tablaContenido' userId='' id="addContenidoButton">Agregar contenido</button>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Titulo</th>
            <th>Texto</th>
            <th>Tipo de contenido</th>
            <th>Contenido</th>
            <th>Seccion padre</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody id="tablaContenido">
        </tbody>
      </table>
      <ul class="pagination" id="paginationContenido">

	  </ul>
    </div>
    <div class="row artista displayer">
      <h2> Artista: </h2>
      <button type="button" class="btn btn-primary" data-toggle='modal' data-target='#modalAgregarArtista' tabla='tablaArtista' userId='' id="addArtistaButton">Agregar artista</button>
	  <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Fecha de nacimiento</th>
            <th>Pais de origen</th>
			<th>URL de imagen</th>
			<th>Rating</th> 
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody id="tablaArtista">
        </tbody>
      </table>
      <ul class="pagination" id="paginationArtista">

	  </ul>
    </div>
    <div class="row album displayer">
      <h2> Album: </h2>
      <button type="button" class="btn btn-primary" data-toggle='modal' data-target='#modalAgregarAlbum' tabla='tablaAlbum' userId='' id="addAlbumButton">Agregar album</button>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Titulo</th>
            <th>Fecha de lanzamiento</th>
            <th>URL de imagen frontal</th>
			<th>URL de imagen frontal pequeña</th>
			<th>URL de imagen trasera</th>
            <th>Fuente</th>
            <th>Rating</th>
			<th>Tags</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody id="tablaAlbum">
        </tbody>
      </table>
      <ul class="pagination" id="paginationAlbum">

	  </ul>
    </div>
    <div class="row soundtrack displayer">
      <h2> Soundtrack: </h2>
      <button type="button" class="btn btn-primary" id="addSoundtrackButton" data-toggle='modal' data-target='#modalAgregarSoundtrack' tabla='tablaSoundtrack' userId=''>Agregar soundtracks</button>
	   <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
			<th>Disc</th>
			<th>#</th>
            <th>Nombre</th>
            <th>Archivo</th>
			<th>Album</th>
			<th>Interprete(s)</th>
			<th>Tags</th>
			<th>Rating</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody id="tablaSoundtrack">
		
        </tbody>
      </table>
      <ul class="pagination" id="paginationSoundtrack">

	  </ul>
    </div>
</div>

<?php
include("admin/modales.html");
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/validate.min.js"></script>
<script src="js/jquerysession.js"></script>
<script src="js/backend.js"></script>
<script>
var currentSection = "";
	$(document).ready(function(e) {
		if(typeof $.session.get("seccion") == 'undefined'){
			$.session.set("seccion", "usuario");
			currentSection = "usuario";
		}
		else{
			currentSection = $.session.get("seccion");
		}
		
		if($.session.get("page") == "undefined"){
			console.log("page was undefined");
			$.session.set("page", "1");	
		}
		else{
			console.log($.session.get("page"));
		}
		
		cambiarSeccion(currentSection);
		
		$("#" + currentSection).children().addClass("active");
		$(".row").hide();
		$("."+currentSection).show();
		
		$(".navbar-nav").click(function(){
			$(".active").removeClass("active");
			$(this).children().addClass("active");
			cambiarSeccion($(this).attr("id"));
		});
		
		//Botones de cambio de pag
		$(document.body).on("click", ".pages", function(){
			var page = $(this).attr("page");
			var table = $(this).attr("table");
			$.session.set("page", page);
			switch(table){
				case "tablaUsuario":
					cambiarSeccion("usuario");
					break;
				case "tablaArtista":
					cambiarSeccion("artista");
					break;
				case "tablaAlbum":
					cambiarSeccion("album");
					break;
				case "tablaContenido":
					cambiarSeccion("contenido");
					break;
				case "tablaSeccion":
					cambiarSeccion("seccion");
					break;
				case "tablaSoundtrack":
					cambiarSeccion("soundtrack");
					break;
				default:
					break;
			}
		});
		
		//Modales
		$(document.body).on("click", ".btn-eliminar", function(){
			var table = $(this).attr("tabla");
			switch(table){
				case "tablaUsuario":
					$("#siEliminar").attr("onClick", "remove('usuario', '"+ $(this).attr('userId')+ "');return false;");
					break;
				case "tablaSeccion":
					$("#siEliminar").attr("onClick", "remove('seccion', '"+ $(this).attr('userId')+ "');return false;");
					break;
				case "tablaContenido":
					$("#siEliminar").attr("onClick", "remove('contenido', '"+ $(this).attr('userId')+ "');return false;");
					break;	
				case "tablaAlbum":
					$("#siEliminar").attr("onClick", "remove('album', '"+ $(this).attr('userId')+ "');return false;");
					break;	
				case "tablaSoundtrack":
					$("#siEliminar").attr("onClick", "remove('soundtrack', '"+ $(this).attr('userId')+ "');return false;");
					break;
				case "tablaArtista":
					$("#siEliminar").attr("onClick", "remove('artista', '"+ $(this).attr('userId')+ "');return false;");
					break;
				default:
					break;
			}
		});
		
		$("#tableFilterInput").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			var table = "";
			switch($.session.get("seccion")){
				case 'usuario':
					table = "tablaUsuario";
					break;	
				case 'seccion':
					table = "tablaSeccion";
					break;
				case 'contenido':
					table = "tablaContenido";
					break;
				case 'album':
					table = "tablaAlbum";
					break;
				case 'soundtrack':
					table = "tablaSoundtrack";
					break;
				case 'artista':
					table = "tablaArtista";
					break;
				default:
					break;
			}
			$("#"+ table +" tr").filter(function() {
			  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
		
		//botones de cada seccion
		//Album
		$("#addAlbumButton").click(function(){
			addAlbumClick();	
		});
		
		//Artista
		$("#addArtistaButton").click(function(){
			addArtistaClick();
		});
		
		//Contenido
		$("#addContenidoButton").click(function(){
			addContenidoClick();
		});
		
		$("#addContentSeccion").change(function(){
			$(this).attr("selectedId", $(this).find(":selected").attr("seccionId"));
		});
		
		$("#addContentType").change(function(){
			if($("#addContentType").val() != "Ninguno"){
				$("#addContentFilterDiv").show();
			}
			else{
				$("#addContentFilterDiv").hide();
			}
			$("#addContentFilterInput").val("");
			$("#addConterFilteredResults").html("");
			$("#addConterFilteredResults").attr("selectedId", "");
		});
		
		$("#addContentFilterSearch").click(function(){
			filterFunction($("#addContentType").val().toLowerCase(), "name", "addConterFilteredResults", $("#addContentFilterInput").val(), false)
		});
		
		//Soundtrack
		$("#addSoundtrackButton").click(function(){
			addSoundtrackClick();
		});
		
		$("#addStAlbumFilterSearch").click(function(){
			filterFunction('album', "name", "addStAlbumFilteredResults", $("#addStAlbumFilterInput").val(), false)
		});
		
		$("#addStArtistFilterSearch").click(function(){
			filterFunction('artista', "fullname", "addStArtistFilteredResults", $("#addStArtistFilterInput").val(), true)
		});
		
		$("#addStTagFilterSearch").click(function(){
			filterFunction('tag', "name", "addStTagFilteredResults", $("#addStTagFilterInput").val(), true)
		});
		
		//Album
		$("#addAlbSourceFilterSearch").click(function(){
			filterFunction('source', "name", "addAlbSourceFilteredResults", $("#addAlbSourceFilterInput").val(), false)
		});
		
		$("#addAlbTagFilterSearch").click(function(){
			filterFunction('tag', "name", "addAlbTagFilteredResults", $("#addAlbTagFilterInput").val(), true)
		});
		
		
		//de todos
		$(document.body).on("click", ".filterSearchResult", function(){
			if($(this).hasClass("filterSearchSelected"))
				return;
			if($(this).attr("additive") == "no"){
				console.log("not additive");
				$(this).addClass("filterSearchSelected");
				var html = $(this).get();
				$(this).parent().attr("selectedId", $(this).attr("dataId"));
				$(this).parent().html(html);
			}
			else{
				$(this).addClass("filterSearchSelected");
				var html = $(this).get();
				var x = $("#"+$(this).parent().attr("id") + "Selected");
				$(this).parent().html("");
				x.append(html);
			}
		});
		
		$(document.body).on("click", ".filterSearchSelected", function(){
			$(this).parent().attr("selectedId", "");
			$(this).remove();
		});
   });


</script>
</body>
</html>