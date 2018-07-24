	//Artista
	function loadArtista(datos){
		console.log("loadartists");
		var i = 0;
		var html= "";
		while(typeof datos[i] != "undefined"){
			html += "<tr><td>"+ datos[i]['id'] +"</td> <td>"+ datos[i]['firstname'] +"</td><td>"+ datos[i]['lastname'] +"</td><td>"+ datos[i]['date'] +"</td> <td>"+ datos[i]['pais'] +"</td><td>"+ datos[i]['imageurl'] +"</td><td>"+ datos[i]['rating'] +"</td> <td><button type='button' class='btn btn-primary btn-editar' href='Javascript:;' onClick='editArtistaClick("+ datos[i]["id"] +"); return false;' data-toggle='modal' data-target='#modalAgregarArtista' tabla='tablaArtista'>Editar</button></td> <td><button type='button' class='btn btn-primary btn-eliminar' data-toggle='modal' data-target='#modalEliminar' tabla='tablaArtista' userId='"+ datos[i]["id"] +"'>Eliminar</button></td></tr>";
			i++;
		}
		
		$("#tablaArtista").html(html);
		
		for(var j = 0; j < datos["count"]/50; j++)
		{
			$("#paginationArtista").append("<li class='pages' table='tablaArtista' page='" + (j+1) + "'><a href='#'>" + (j+1) +"</a></li>");
		}
		var value = $("#tableFilterInput").val().toLowerCase();
		$("#tablaArtista tr").filter(function() {
		  $("#tableFilterInput").toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});	
	}
	
	function addArtistaClick(){
		$("#modalArtistaTitulo").html("Agregar");
		$("#siAgregarArtista").html("Agregar");
		
		$("#addArtistaName").val("");
		$("#addArtistaApellido").val("");
		$("#addArtistaFecha").val("");
		$("#addArtistaPais").val("");
		$("#addArtistaImage").val("");
		
		$("#siAgregarArtista").attr("onClick", "sendAddArtista(); return false;");
	}
	
	function sendAddArtista(){
		var datos = {
			"fullname": $("#addArtistaName").val(),
			"firstname" : $("#addArtistaFirstname").val(),
			"lastname" : $("#addArtistaApellido").val(),
			"date" : $("#addArtistaFecha").val(),
			"pais" : $("#addArtistaPais").val(),
			"imageurl" : $("#addArtistaImage").val()
		}
		console.log(datos);
		$.ajax({
			data: datos,
			url: "admin/agregarArtista.php",
			type: "post",
			success: function (response){
				var json = response;
				//var obj = JSON.parse(json);
				if(json.success)
				{
					cambiarSeccion('artista');
				}
				else
				{
					console.log("failure adding artist");
					console.log(datos);
				}
			},
			error: function(event,xhr,options,exc){
				console.log("ajax_error_can't_add_artist");
				console.log(event);
				console.log(xhr);
				console.log(options);
				console.log(exc);
			}
		});
	}
	
	function editArtistaClick(id){
		$("#modalArtistaTitulo").html("Editar");
		$("#siAgregarArtista").html("Editar");
		getRow("artista", id).then(function(data){
			var datos = data.data;
			
			$("#addArtistaName").val(datos["name"]);
			$("#addArtistaApellido").val(datos["apellidop"]);
			$("#addArtistaFecha").val(datos["date"]);
			$("#addArtistaPais").val(datos["pais"]);
			$("#addArtistaImage").val(datos["imageurl"]);
			
			$("#siAgregarArtista").attr("onClick", "sendEditArtista("+ id +"); return false;");
		});
	}
	
	function sendEditArtista(id){
		var datos = {
			"id" : id,
			"name" : $("#addArtistaName").val(),
			"apellidop" : $("#addArtistaApellido").val(),
			"date" : $("#addArtistaFecha").val(),
			"pais" : $("#addArtistaPais").val(),
			"imageurl" : $("#addArtistaImage").val()
		}
		$.ajax({
			data: datos,
			url: "admin/editarArtista.php",
			type: "post",
			success: function (response){
				var json = response;
				//var obj = JSON.parse(json);
				if(json.success)
				{
					cambiarSeccion('artista');
				}
				else
				{
					console.log("failure adding artist");
					console.log(datos);
				}
			},
			error: function(event,xhr,options,exc){
				console.log("ajax_error_can't_add_artist");
				console.log(event);
				console.log(xhr);
				console.log(options);
				console.log(exc);
			}
		});
	}
	
	//Soundtrack
	function loadSoundtrack(datos){
		var i = 0;
		var html = "";
		console.log(datos);
		while(typeof datos[i] != "undefined")
		{
			var interpretes = "";
			var j = 0;
			if(typeof datos[i]["artista"] != "undefined")
			{
				while(typeof datos[i]["artista"][j] != "undefined"){
					if(j != 0)
						interpretes += ", ";
					interpretes += datos[i]["artista"][j]["fullname"];
					j++;
				}
			}
			if(j != 0)
				interpretes += ".";
					
			var tags = "";
			j = 0;
			if(typeof datos[i]["tags"] != "undefined")
			{
				while(typeof datos[i]["tags"][j] != "undefined"){
					if(j != 0)
						tags += ", ";
					tags += datos[i]["tags"][j]["name"];
					j++;
				}
			}
			if(j != 0)
				tags += ".";
					
			html += "<tr><td>"+ datos[i]['id'] +"</td><td>"+ datos[i]['disc'] +"</td><td>"+ datos[i]['number'] +"</td><td>"+ datos[i]['name'] +"</td><td><a href='"+ datos[i]['file'] +"'>"+ datos[i]['file'] +"</a></td><td>"+ datos[i]['albumName'] +"</td><td>"+ interpretes +"</td><td>"+ tags +"</td><td>"+ datos[i]['rating'] +"</td><td><button type='button' class='btn btn-primary btn-editar' href='Javascript:;' onClick='editSoundtrackClick("+ datos[i]['id'] +"); return false;' data-toggle='modal' data-target='#modalAgregarSoundtrack' tabla='tablaSoundtrack'>Editar</button></td><td><button type='button' class='btn btn-primary btn-eliminar' data-toggle='modal' data-target='#modalEliminar' tabla='tablaSoundtrack' userId='"+ datos[i]['id'] +"'>Eliminar</button></td> </tr>";
			i++;
		}
		
		$("#tablaSoundtrack").append(html);
		
		for(var j = 0; j < datos["count"]/50; j++)
		{
			$("#paginationSoundtrack").append("<li class='pages' table='tablaSoundtrack' page='" + (j+1) + "'><a href='#'>" + (j+1) +"</a></li>");
		}	
		var value = $("#tableFilterInput").val().toLowerCase();
		$("#tablaSoundtrack tr").filter(function() {
		  $("#tableFilterInput").toggle($("#tableFilterInput").text().toLowerCase().indexOf(value) > -1)
		});	
	}
	
	function addSoundtrackClick(){
		$("#modalSoundtrackTitulo").html("Agregar");
		$("#siAgregarSoundtrack").html("Agregar");
		/*
		$("#addSoundtrackNumber").val("");
		$("#addSoundtrackDisc").val("");
		$("#addSoundtrackName").val("");
		$("#addSoundtrackFile").val("");
		$("#addStAlbumFilterInput").val("");
		$("#addStAlbumFilteredResults").html("");
		$("#addStAlbumFilteredResults").attr("selectedId", "");
		$("#addStArtistFilterInput").val("");
		$("#addStArtistFilteredResultsSelected").html("");
		$("#addStArtistFilteredResults").html("");
		*/
		$("#siAgregarSoundtrack").attr("onClick", "sendAddSoundtrack(); return false;");
	}
	
	function sendAddSoundtrack(){
		var x = $("#addStArtistFilteredResultsSelected").find("p");
		var artistas = [];				
		for(var j = 0; j < x.length; j++){
			artistas.push(x[j].getAttribute("dataId"));
		}
		var t = $("#addStTagFilteredResultsSelected").find("p");
		var tags = [];				
		for(var j = 0; j < t.length; j++){
			tags.push(t[j].getAttribute("dataId"));
		}
		var datos = {
			"name" : $("#addSoundtrackName").val(),
			"disc" : $("#addSoundtrackDisc").val(),
			"number" : $("#addSoundtrackNumber").val(),
			"file" : $("#addSoundtrackFile").val(),
			"albumid" : $("#addStAlbumFilteredResults").attr("selectedId"),
			"artistas" : artistas,
			"tags" : tags
		}
		console.log("Add soundtrack:");
		console.log(datos);
		$.ajax({
			data: datos,
			url: "admin/agregarSoundtrack.php",
			type: "post",
			success: function (response){
				var json = response;
				//var obj = JSON.parse(json);
				if(json.success)
				{
					cambiarSeccion('soundtrack');
				}
				else
				{
					console.log("failure adding soundtrack");
					console.log(json);
				}
			},
			error: function(event,xhr,options,exc){
				console.log("ajax_error_can't_add_soundtrack");
				console.log(event);
				console.log(xhr);
				console.log(options);
				console.log(exc);
			}
		});
	}
	
	function editSoundtrackClick(id){
		$("#modalSoundtrackTitulo").html("Editar");
		$("#siAgregarSoundtrack").html("Editar");
		
		getRow("soundtrack", id).then(function(data){
			
			var datos = data.data.datos[0];
			
			$("#addSoundtrackNumber").val(datos["number"]);
			$("#addSoundtrackDisc").val(datos["disc"]);
			$("#addSoundtrackName").val(datos["name"]);
			$("#addSoundtrackFile").val(datos["file"]);
			$("#addStAlbumFilterInput").val("");
			var html = "<p class='filterSearchResult filterSearchSelected' additive='no' dataId='"+ datos["albumid"] +"'>"+ datos["albumName"] +"</p>";
			$("#addStAlbumFilteredResults").html(html);
			$("#addStAlbumFilteredResults").attr("selectedId", datos["albumid"]);
			$("#addStArtistFilterInput").val("");
			html = "";
			var i = 0;
			if(typeof datos["artista"] != "undefined"){
				while(typeof datos["artista"][i] != "undefined"){
					html += "<p class='filterSearchResult filterSearchSelected' additive='si' dataId='"+ datos["artista"][i]["artistaid"] +"'>"+ datos["artista"][i]["fullname"] +"</p>";
					i++;
				}
			}
			$("#addStArtistFilteredResultsSelected").html(html);
			$("#addStArtistFilteredResults").html("");
			
			$("#addStTagFilterInput").val("");
			html = "";
			i = 0;
			if(typeof datos["tags"] != "undefined"){
				while(typeof datos["tags"][i] != "undefined"){
					html += "<p class='filterSearchResult filterSearchSelected' additive='si' dataId='"+ datos["tags"][i]["tagid"] +"'>"+ datos["tags"][i]["name"] +"</p>";
					i++;
				}
			}
			$("#addStTagFilteredResultsSelected").html(html);
			$("#addStTagFilteredResults").html("");
			
			$("#siAgregarSoundtrack").attr("onClick", "sendEditSoundtrack("+ datos["id"] +"); return false;");
		});
	}
	
	function sendEditSoundtrack(id){
		var x = $("#addStArtistFilteredResultsSelected").find("p");
		var artistas = [];				
		for(var j = 0; j < x.length; j++){
			artistas.push(x[j].getAttribute("dataId"));
		}
		var t = $("#addStTagFilteredResultsSelected").find("p");
		var tags = [];				
		for(var j = 0; j < t.length; j++){
			tags.push(t[j].getAttribute("dataId"));
		}
		var datos = {
			"id" : id,
			"disc" : $("#addSoundtrackDisc").val(),
			"number" : $("#addSoundtrackNumber").val(),
			"name" : $("#addSoundtrackName").val(),
			"file" : $("#addSoundtrackFile").val(),
			"albumid" : $("#addStAlbumFilteredResults").attr("selectedId"),
			"artistas" : artistas,
			"artistcount" : artistas.length,
			"tags" : tags,
			"tagcount" : tags.length
		}
		console.log("Datos para editar st");
		console.log(datos);
		$.ajax({
			data: datos,
			url: "admin/editarSoundtrack.php",
			type: "post",
			success: function (response){
				var json = response;
				//var obj = JSON.parse(json);
				if(json.success)
				{
					cambiarSeccion('soundtrack');
				}
				else
				{
					console.log("failure editing soundtrack");
					console.log(json);
				}
			},
			error: function(event,xhr,options,exc){
				console.log("ajax_error_can't_edit_soundtrack");
				console.log(datos);
				console.log(event);
				console.log(xhr);
				console.log(options);
				console.log(exc);
			}
		});
	}

	//Album
	function loadAlbum(datos){
		var i = 0;
		while(typeof datos[i] != "undefined")
		{
			var prevId = datos[i]["id"];
			var tags = "";
			var j = 0;
			var id = datos[i]["id"];
			var name = datos[i]["name"];
			var date = datos[i]["date"];
			var imageurl = datos[i]["imageurl"];
			var smallimg = datos[i]["smallimgurl"];
			var backimg = datos[i]["backimgurl"];
			var sourceName = datos[i]["sourceName"];
			var rating = datos[i]["rating"];
			while(datos[i]["id"] == prevId){
				if(j != 0)
					tags += ", ";
				tags += datos[i]["tagName"];
				i++;
				j++;
				if(typeof datos[i] == "undefined")
					break;
			}
			tags += ".";
			var html = "<tr><td>"+ id +"</td><td>"+ name +"</td><td>"+ date +"</td><td>"+ imageurl +"</td><td>"+ smallimg +"</td><td>"+ backimg +"</td><td>"+ sourceName +"</td><td>"+ rating +"</td><td>"+ tags +"</td><td><button type='button' class='btn btn-primary btn-editar' href='Javascript:;' onClick='editAlbumClick("+ id +"); return false;' data-toggle='modal' data-target='#modalAgregarAlbum' tabla='tablaAlbum'>Editar album</button></td><td><button type='button' class='btn btn-primary btn-eliminar' data-toggle='modal' data-target='#modalEliminar' tabla='tablaAlbum' userId='"+ id +"'>Eliminar album</button></td></tr>";
			
			$("#tablaAlbum").append(html);
		}
		for(var j = 0; j < datos["count"]/50; j++)
		{
			$("#paginationAlbum").append("<li class='pages' table='tablaAlbum' page='" + (j+1) + "'><a href='#'>" + (j+1) +"</a></li>");
		}
		var value = $("#tableFilterInput").val().toLowerCase();
		$("#tablaAlbum tr").filter(function() {
		  $("#tableFilterInput").toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});		
	}
	
	function addAlbumClick(){
		$("#modalAlbumTitulo").text("Agregar");
		$("#siAgregarAlbum").text("Agregar");
		
		$("#addAlbumName").val("");
		$("#addAlbumDate").val("");
		$("#addAlbumImage").val("");
		$("#addAlbSourceFilterInput").val("");
		$("#addAlbSourceFilteredResults").html("");
		$("#addAlbSourceFilteredResults").attr("selectedId", "");
		$("#addAlbTagFilterInput").val("");
		$("#addAlbTagFilteredResultsSelected").html("");
		$("#addAlbTagFilteredResults").html("");
		
		$("#siAgregarAlbum").attr("onClick", "sendAddAlbum(); return false;");
		
	}
	
	function sendAddAlbum(){
		var x = $("#addAlbTagFilteredResultsSelected").find("p");
		var tags = [];				
		for(var j = 0; j < x.length; j++){
			tags.push(x[j].getAttribute("dataId"));
		}
		var datos = {
			"name" : $("#addAlbumName").val(),
			"date" : $("#addAlbumDate").val(),
			"imageurl" : $("#addAlbumImage").val(),
			"source" : $("#addAlbSourceFilteredResults").attr("selectedId"),
			"tags" : tags,
		}
		console.log(datos);
		$.ajax({
			data: datos,
			url: "admin/agregarAlbum.php",
			type: "post",
			success: function (response){
				var json = response;
				//var obj = JSON.parse(json);
				if(json.success)
				{
					cambiarSeccion('album');
				}
				else
				{
					console.log("failure adding album");
				}
			},
			error: function(event,xhr,options,exc){
				console.log("ajax_error_can't_add_album");
				console.log(event);
				console.log(xhr);
				console.log(options);
				console.log(exc);
			}
		});
		
	}
	
	function editAlbumClick(id){
		$("#modalAlbumTitulo").text("Editar");
		$("#siAgregarAlbum").text("Editar");
		getRow('album', id).then(function(datos){
			console.log(datos);
			var data = datos.data.datos[0];
			$("#addAlbumName").val(data["name"]);
			$("#addAlbumDate").val(data["date"]);
			$("#addAlbumImage").val(data["imageurl"]);
			$("#addAlbSourceFilterInput").val("");
			var html = "<p class='filterSearchResult filterSearchSelected' additive='no' dataId='"+ data["sourceid"] +"'>"+ data["sourceName"] +"</p>";
			$("#addAlbSourceFilteredResults").html(html);
			$("#addAlbSourceFilteredResults").attr("selectedid", data["sourceid"]);
			
			$("#addAlbTagFilterInput").val("");
			html = "";
			var i= 0;
			while(typeof datos.data.datos[i] != "undefined"){
				html += "<p class='filterSearchResult filterSearchSelected' additive='si' dataId='"+ datos.data.datos[i]["tagid"] +"'>"+ datos.data.datos[i]["tagName"] +"</p>";
				i++;
			}
			$("#addAlbTagFilteredResultsSelected").html(html);
			$("#addAlbTagFilteredResults").html("");

			$("#siAgregarAlbum").attr("onClick", "sendEditAlbum("+ data['id'] +"); return false;");
		});
	}
	
	function sendEditAlbum(id){
		var x = $("#addAlbTagFilteredResultsSelected").find("p");
		var tags = [];				
		for(var j = 0; j < x.length; j++){
			tags.push(x[j].getAttribute("dataId"));
		}
		var datos = {
			"id" : id,
			"name" : $("#addAlbumName").val(),
			"date" : $("#addAlbumDate").val(),
			"imageurl" : $("#addAlbumImage").val(),
			"source" : $("#addAlbSourceFilteredResults").attr("selectedId"),
			"tags" : tags,
			"tagcount" : tags.length
		}
		
		$.ajax({
			data: datos,
			url: "admin/editarAlbum.php",
			type: "post",
			success: function (response){
				var json = response;
				//var obj = JSON.parse(json);
				if(json.success)
				{
					cambiarSeccion('album');
				}
				else
				{
					console.log("failure editing album");
					console.log(json.data["message"]);
				}
			},
			error: function(event,xhr,options,exc){
				console.log("ajax_error_can't_edit_album");
				console.log(event);
				console.log(xhr);
				console.log(options);
				console.log(exc);
			}
		});
	}
	
	//Contenido
	function fillSectionSelect(){
		FetchTable('seccion', 1).then(function(data){
			var i = 0;
			var html = "";
			while(typeof data.data.datos[i] != "undefined"){
				html+= "<option seccionId='"+ data.data.datos[i]["id"] +"'>"+ data.data.datos[i]["name"] +"</option>";
				i++;
			}
			$("#addContentSeccion").html(html);
		});
	}
	
	function loadContenido(datos){
		var i = 0;
		while(typeof datos[i] != "undefined")
		{
			if(datos[i]["nivel"] == "1")
				{var nivel = "Normal";}
			else
				{var nivel = "Admin"}
				
			var stringerino = "";
			if(datos[i]["texto"].length > 400)
			{
				for(var j = 0; j < 397; j++)
					stringerino += datos[i]["texto"][j];
				stringerino += "...";
			}
			else{ stringerino = datos[i]["texto"]; }
			
			if(datos[i]["type"] != 0)
			{
				var typeName = datos[i]["typeName"];
				var type = datos[i]["type"];	
			}
			else{ 
				var typeName = "-";
				var	type = "Ninguno";
			}
			
			var html = "<tr><td>"+ datos[i]["id"] +"</td><td>"+ datos[i]["title"] +"</td> <td>"+ stringerino +"</th><td>"+ type +"</td><td>"+ typeName +"</td><td>"+ datos[i]["sectName"] +"</td><td> <button type='button' class='btn btn-primary btn-editar' data-toggle='modal' data-target='#modalAgregarContenido' tabla='tablaContenido'>Editar contenido</button> </td><td><button type='button' class='btn btn-primary btn-eliminar' data-toggle='modal' data-target='#modalEliminar' tabla='tablaContenido' userId='"+ datos[i]["id"] +"' href='Javascript:;' onClick='editContenidoClick("+ datos[i]["id"] +"); return false;'>Eliminar contenido</button>  </td></tr>";	
			$("#tablaContenido").append(html);
			i++;
		}
		
		for(var j = 0; j < datos["count"]/50; j++)
		{
			$("#paginationContenido").append("<li class='pages' table='tablaContenido' page='" + (j+1) + "'><a href='#'>" + (j+1) +"</a></li>");
		}	
		var value = $("#tableFilterInput").val().toLowerCase();
		$("#tablaContenido tr").filter(function() {
		  $("#tableFilterInput").toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	}
	
	function addContenidoClick(){
		$("#modalContenidoTitulo").text("Agregar");
		$("#siAgregarContenido").text("Agregar");
		
		$("#addContentName").val("");
		$("#addContentText").val("");
		$("#addContentSeccion").val("");
		$("#addContentSeccion").attr("selectedId", "");
		$("#addContentType").val('');
		$("#addContentFilterDiv").hide();
		$("#addContentFilterInput").val("");
		$("#addConterFilteredResults").html("");
		$("#addConterFilteredResults").attr("selectedId", "");
		
		$("#siAgregarContenido").attr("onClick", "sendAddContenido(); return false;");
	}
	
	function sendAddContenido(){
		switch ($("#addContentType").val()){
			case "Artista":
				var tipo = "artista";
				var tipoId = $("#addConterFilteredResults").attr("selectedId");
				break;
			case "Album":
				var tipo = "album";
				var tipoId = $("#addConterFilteredResults").attr("selectedId");
				break;
			default:
				var tipo = "0";
				break;
		}
		
		var datos = {
			"titulo" : $("#addContentName").val(),
			"texto" : $("#addContentText").val(),
			"tipo" : tipo,
			"tipoId" : tipoId,
			"seccionId" : $("#addContentSeccion").attr("selectedId")
		}
		$.ajax({
			data: datos,
			url: "admin/agregarContenido.php",
			type: "post",
			success: function (response){
				var json = response;
				//var obj = JSON.parse(json);
				if(json.success)
				{
					cambiarSeccion('contenido');
				}
				else
				{
					console.log("failure adding content");
					console.log(datos);
				}
			},
			error: function(event,xhr,options,exc){
				console.log("ajax_error_can't_add_content");
				console.log(event);
				console.log(xhr);
				console.log(options);
				console.log(exc);
			}
		});
	}
	
	function editContenidoClick(id){
		$("#modalContenidoTitulo").text("Editar");
		$("#siAgregarContenido").text("Editar");
		getRow("contenido", id).then(function(data){
			
			var datos = data.data;
			
			$("#addContentName").val(datos["title"]);
			$("#addContentText").val(datos["texto"]);
			$("#addContentSeccion").val(datos["sectName"]);
			$("#addContentSeccion").attr("selectedId", datos["sectid"]);
			var type = "";
			switch(datos["type"]){
				case "artista":
					type = "Artista";
					break;
				case "album":
					type = "Album";
					break;
				case "0":
					type = "Ninguno";
					break;
				default:
					type = "Ninguno";
					break;
			}
			$("#addContentType").val(type);
			$("#addContentFilterDiv").show();
			$("#addContentFilterInput").val("");
			if(datos["type"] == "artista"){
				var name = datos["typedata"]["name"] + " " + datos["typedata"]["apellidop"];
			}else {
				var name = datos["typedata"]["name"];
			}
			$("#addConterFilteredResults").html("<p class='filterSearchResult filterSearchSelected' dataId='"+ datos["typedata"]["id"] +"'>"+ name +"</p>");
			$("#addConterFilteredResults").attr("selectedId", datos["typeid"]);
			
			$("#siAgregarContenido").attr("onClick", "sendEditContenido(); return false;");
		});
	}
	
	
	//Secciones
	function loadSecciones(datos){
		var i = 0;
		while(typeof datos[i] != "undefined")
		{
			if(datos[i]["nivel"] == "1")
				{var nivel = "Normal";}
			else
				{var nivel = "Admin"}
				
			var html = "<tr><td> "+ datos[i]["id"] +" </td><td> "+ datos[i]["name"] +" </td><td> "+ nivel +" </td><td> <button type='button' class='btn btn-primary btn-editar' href='Javascript:;' onClick='editSeccion("+ datos[i]["id"] +"); return false;' data-toggle='modal' data-target='#modalEditarSeccion' tabla='tablaSeccion'>Editar seccion</button> </td><td><button type='button' class='btn btn-primary btn-eliminar' data-toggle='modal' data-target='#modalEliminar' tabla='tablaSeccion' userId='"+ datos[i]["id"] +"'>Eliminar seccion</button>  </td></tr>";
			$("#tablaSeccion").append(html);
			i++;
		}
		
		for(var j = 0; j < datos["count"]/50; j++)
		{
			$("#paginationSeccion").append("<li class='pages' table='tablaSeccion' page='" + (j+1) + "'><a href='#'>" + (j+1) +"</a></li>");
		}
		var value = $("#tableFilterInput").val().toLowerCase();
		$("#tablaSeccion tr").filter(function() {
		  $("#tableFilterInput").toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	}
	
	function sendEditSection(id, name, level){
		if(level == "Administrador")
			var realLevel = "2";
		else
			var realLevel = "1";	
			
		var datos = {
			"id" : id,
			"name" : name,
			"level" : realLevel
		};
		$.ajax({
			data: datos,
			url: "admin/editarSeccion.php",
			type: "post",
			success: function (response){
				var json = response;
				//var obj = JSON.parse(json);
				if(json.success)
				{
					cambiarSeccion('seccion');
				}
				else
				{
					console.log("failure");
				}
			},
			error: function(event,xhr,options,exc){
				console.log("ajax_error_can't_edit_section");
				console.log(event);
				console.log(xhr);
				console.log(options);
				console.log(exc);
			}
		});
	}
	
	function editSeccion(id){
		getRow('seccion', id).then(function (data){
			if(data.data["nivel"] == 0)
				var level = "Usuario Comun";
			else if(data.data["nivel"] == 1)
				var level = "Administrador";
			else
				var level = "nose";
			
			$("#editSectionName").attr("value", data.data["name"]);
			$("#editSectionLevel").attr("value", level);
			$("#siEditarUsuario").attr("sectID", id);
		});
	}
	
	function addSection(name, level){
		if(level == "Administrador")
			var realLevel = "2";
		else
			var realLevel = "1";	
			
		var datos = {
			"name" : name,
			"level" : realLevel
		};
		$.ajax({
			data: datos,
			url: "admin/agregarSeccion.php",
			type: "post",
			success: function (response){
				var json = response;
				//var obj = JSON.parse(json);
				if(json.success)
				{
					cambiarSeccion('seccion');
				}
				else
				{
					console.log("failure");
				}
			},
			error: function(event,xhr,options,exc){
				console.log("ajax_error_can't_add_section");
				console.log(event);
				console.log(xhr);
				console.log(options);
				console.log(exc);
			}
		});
	}
	
	//Usuarios
	function sendEditUser(id, name, pass, mail, date, image, level){
		if(level == "Administrador")
			var realLevel = "2";
		else
			var realLevel = "1";	
			
		if(image == "")
			image = "0";
			
		var datos = {
			"id" : id,
			"name" : name,
			"pass" : pass,
			"mail" : mail,
			"date" : date,
			"image" : image,
			"level" : realLevel
		};
		$.ajax({
			data: datos,
			url: "admin/editarUsuario.php",
			type: "post",
			success: function (response){
				var json = response;
				//var obj = JSON.parse(json);
				if(json.success)
				{
					cambiarSeccion('usuario');
				}
				else
				{
					console.log("failure");
				}
			},
			error: function(event,xhr,options,exc){
				console.log("ajax_error_can't_edit_user");
				console.log(event);
				console.log(xhr);
				console.log(options);
				console.log(exc);
			}
		});
		
	}
	
	function editUser(id){
		getRow('usuario', id).then(function (data){
			if(data.data["clearance"] == 0)
				var level = "Usuario Comun";
			else if(data.data["clearance"] == 1)
				var level = "Administrador";
			else
				var level = "nose";
			
			$("#editUserName").val(data.data["name"]);
			$("#editUserPass").val(data.data["pass"]);
			$("#editUserMail").val(data.data["mail"]);
			$("#editUserDate").val(data.data["age"]);
			$("#editUserLevel").val(level);
			$("#editUserImgurl").val(data.data["img"]);
			$("#siEditarUsuario").attr("userID", id);
		});
	}
	
	function addUser(name, pass, mail, date, image, level){
		if(level == "Administrador")
			var realLevel = "2";
		else
			var realLevel = "1";	
			
		if(image == "")
			image = "0";
			
		var datos = {
			"name" : name,
			"pass" : pass,
			"mail" : mail,
			"date" : date,
			"image" : image,
			"level" : realLevel
		};
		console.log(datos);
		$.ajax({
			data: datos,
			url: "admin/agregarUsuario.php",
			type: "post",
			beforeSend: function(){
				
			},
			success: function (response){
				var json = response;
				//var obj = JSON.parse(json);
				if(json.success)
				{
		
		console.log(json.success);	
					cambiarSeccion('usuario');
				}
				else
				{
					console.log("failure");
				}
			},
			error: function(event,xhr,options,exc){
				console.log("ajax_error_can't_add_user");
				console.log(event);
				console.log(xhr);
				console.log(options);
				console.log(exc);
			}
		});
	}
	
	function loadUsuarios(datos){
		var i = 0;
		while(typeof datos[i] != "undefined")
		{
			if(datos[i]["clearance"] == "1")
				{var nivel = "Normal";}
			else
				{var nivel = "Admin"}
				
			var html = "<tr><td>" + datos[i]["id"] + " </td><td>" + datos[i]["name"] + " </td><td>" + datos[i]["pass"] + " </td><td>" + datos[i]["mail"] + " </td><td>" + datos[i]["age"] + " </td><td>" + datos[i]["img"] + " </td><td>" + nivel + " </td><td><button type='button' class='btn btn-primary btn-editar' href='Javascript:;' onClick='editUser("+ datos[i]["id"] +"); return false;' data-toggle='modal' data-target='#modalEditarUsuario' tabla='tablaUsuario'>Editar usuario</button></td><td><button type='button' class='btn btn-primary btn-eliminar' data-toggle='modal' data-target='#modalEliminar' tabla='tablaUsuario' userId='"+ datos[i]["id"] +"'>Eliminar usuario</button></td></tr>";
			$("#tablaUsuario").append(html);
			i++;
		}
		
		for(var j = 0; j < datos["count"]/50; j++)
		{
			$("#paginationUsuario").append("<li class='pages' table='tablaUsuario' page='" + (j+1) + "'><a href='#'>" + (j+1) +"</a></li>");
		}
		var value = $("#tableFilterInput").val().toLowerCase();
		$("#tablaUsuario tr").filter(function() {
		  $("#tableFilterInput").toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	}
	
	//Todas las secciones
	function getRow(table, id){
		var datos = {
			"table" : table,
			"id" : id
		};
		return Promise.resolve($.ajax({
			data: datos,
			url: "admin/getRow.php",
			type: "post",
			success: function(response){
				var json = response;
				if(json.success){	}
				else
				{
					console.log("rowGetter failure " + table + " " + id);
				}
			},
			error: function (){
				console.log("error getting row");
			}
		}));
	}
	
	function remove(table, id){
		var datos = {
			"table" : table,
			"id" : id
		};
		$.ajax({
			data: datos,
			url: "admin/eliminar.php",
			type: "post",
			success: function (response){
				var json = response;
				//var obj = JSON.parse(json);
				if(json.success)
				{
					console.log(json);
					location.reload();
				}
				else
				{
					console.log("failure");
				}
			},
			error: function(){
				console.log("ajax_errorxxx");
			}
		});
	}
	
	function cleanTable(table){
		$("#"+table).html("");
	}
	
	function cambiarSeccion(id){
		FetchTable(id, $.session.get("page")).then(function(data){
			$(".row").hide("fast", function(){
				$("." + id).show();	
				$("#tableFilterInput").show();
			});
			if($.session.get("seccion") != id)
				$.session.set("page", "1");
			$.session.set("seccion", id);
			currentSection = id;
			$(".pagination").html("");
			switch(id){
				case 'usuario':
					cleanTable("tablaUsuario");
					loadUsuarios(data.data.datos);
					break;	
				case 'seccion':
					cleanTable("tablaSeccion");
					loadSecciones(data.data.datos);
					break;
				case 'contenido':
					cleanTable("tablaContenido");
					loadContenido(data.data.datos);
					fillSectionSelect();
					break;
				case 'album':
					cleanTable("tablaAlbum");
					loadAlbum(data.data.datos);	
					break;
				case 'soundtrack':
					cleanTable("tablaSoundtrack");
					loadSoundtrack(data.data.datos);
				case 'artista':
					cleanTable("tablaArtista");
					loadArtista(data.data.datos);
					break;
				default:
					break;
			}
		});
	}
	
	function FetchTable(table, page){
		var datos = {
			"page" : page,
			"table" : table
		};
		return Promise.resolve($.ajax({
			data: datos,
			url: "admin/fetchTable.php",
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
	
	function filterFunction(table, column, elDiv, elInput, isAdditive) {
		var datos = {
			"table" : table,
			"column" : column,
			"input" : elInput
		};
		return Promise.resolve($.ajax({
			data: datos,
			url: "admin/tableSearch.php",
			type: "post",
			success: function (response){
				var json = response;
				//var obj = JSON.parse(json);
				if(json.success)
				{
					console.log(json);	
					var datos = json.data.datos;
					var i = 0;
					var html = "";
					while(typeof datos[i] != "undefined"){
						if(table == "artista")
							var name = datos[i]["fullname"];
						else
							var name = datos[i]["name"];
						var duplicate = false;
						if(isAdditive){
							var additive ="si";
							var x = document.getElementsByClassName("filterSearchSelected");
							
							for(var j = 0; j < x.length; j++){
								if(name == x[j].innerHTML)
									duplicate = true;
							}
						}
						else{
							var additive = "no";
						}
						if(!duplicate)
							html += "<p class='filterSearchResult' additive='"+ additive +"' dataId='"+ datos[i]["id"] +"'>"+ name +"</p>";
						i++;
					}
					$("#"+elDiv).html(html);
				}
				else
				{
					console.log("failure searching");
				}
			},
			error: function(){
				console.log("ajax_error_can't_search");
				console.log(xhr);
				console.log(options);
				console.log(exc);

			}
		}));
	}
	