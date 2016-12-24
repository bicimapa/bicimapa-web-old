<?php
include_once('../funciones.php');

header("content-type: application/x-javascript");
$pagina="";
if(isset($_GET['p'])&&!empty($_GET['p'])) $pagina=$_GET['p'];
if(isset($_GET['lat'])&&$_GET['lat'])$latitud=(double)$_GET['lat'];
if(isset($_GET['lon'])&&$_GET['lon'])$longitud=(double)$_GET['lon'];
?>

<!-- <?php echo "Locale:".$_SESSION["locale"].",".$_SESSION["country"]; ?> -->

$(document).ready(function() {


	<?php
	if($pagina==md5('bicigente.php')){?>

	$('div.bicigente_bloque_categoria').hide();

	$('div.bicigente_categoria a').click(function(){
		if($(this).parent().parent().next('div.bicigente_bloque_categoria').is(':visible')){
			$('div.bicigente_bloque_categoria').hide();
		}
		else{
			$('div.bicigente_bloque_categoria').hide();
			$(this).parent().parent().next('div.bicigente_bloque_categoria').show();
		}
		
	});

	<?php }?>
	
	var hash_global="";
	//Google Maps
	var map,map2;
	var marker;
	var markerimage = [<?php $imgs=array(); foreach($tiposSitio2 as $imgtipos){$imgs[]="'".url().$imgtipos['img']."'";} echo implode(',',$imgs);?>];

	
	<?php
	if($pagina==md5('index.php')){
	?>			
	
		
	
		$('a.todos').click(function(e){
			e.preventDefault();
			$(this).closest('form').find(':checkbox').prop('checked', 'checked');	
			if (typeof(calcularHash) != "undefined") calcularHash();
		});
	
		$('a.ninguno').click(function(e){
			e.preventDefault();
			$(this).closest('form').find(':checkbox').prop('checked', '');
			if (typeof(calcularHash) != "undefined") calcularHash();
		});
		
		$('#barra_android a.cerrar').click(function(){
			$(this).parent().toggle();
			$.post("<? echo url_api();?>", { api: "barraandroid" } );
		});

		//Mapa en la pagina inicial
		function redimensionarMapa() {
			var altura=document.documentElement.clientHeight-50;
			$('#mapaindex').height(altura);
			if (typeof(map) != "undefined") google.maps.event.trigger(map, "resize")
		}
		redimensionarMapa();
		$(window).resize(function() {
			redimensionarMapa();
		});
	
		var markersArray = [];
		var ciclorrutas = [];
		var ciclovias = [];
		var marcadores= new Array();

		var infowindow = new google.maps.InfoWindow({ content: 'Bicimapa',maxWidth:300 });


		function quitarMarcadores() {
			if (markersArray) {
				for (i in markersArray) {
					markersArray[i].setMap(null);
				}
			}
			markersArray = [];
		}

		function quitarCiclorrutas() {
			if (ciclorrutas) {
				for (i in ciclorrutas) {
					ciclorrutas[i].setMap(null);
				}
			}
			markersArray = [];
		}
		
		function quitarCiclovias() {
			if (ciclovias) {
				for (i in ciclovias) {
					ciclovias[i].setMap(null);
				}
			}
			markersArray = [];
		}

		function dibujarMarcadores(){
			if (markersArray) {
				for (i in markersArray) {
					markersArray[i].setMap(map2);
				}
			}
		}

		$('#borrar').click(function(){
			quitarMarcadores();
		});
		
		
		function pintarMarcador(sitio,desplegar){
		
			if (!markersArray) markersArray = [];
			
			var tipo=sitio['tipo'];
			var nuevomarcador = new google.maps.Marker({
				position: new google.maps.LatLng(sitio['longitud'],sitio['latitud']),
				map: map2,
				title: sitio['nombrelimpio']+" ("+sitio['id']+")",
				icon: markerimage[tipo]
			});
			markersArray.push(nuevomarcador);
			
			//Infowindow
			google.maps.event.addListener(nuevomarcador, "click", (function(nuevomarcador) {
						return function() {
							
							var strinfowindow="<a href=\'<?php echo url_sitio();?>"+sitio['id']+"\' class=\'link_sitio\'><h4>"+sitio['nombre']+"</h4></a><p>"+sitio['descripcion']+"</p><p><a href=\'<?php echo url_sitio();?>"+sitio['id']+"\' class=\'button small\'><?php tr("comentar_y_calificar"); ?></a>";
							if(sitio['tipo']==<?php echo tipo_ruta();?>)strinfowindow=strinfowindow+" <input type=\'button\' class=\'button small ruta-"+sitio['id']+"\' value=\'Ver ruta\'/>";
							strinfowindow=strinfowindow+"</p>";

							infowindow.setContent(strinfowindow);
							infowindow.open(map2,nuevomarcador);
							
							document.location.hash = hash_global;
							
							if(sitio['tipo']==<?php echo tipo_ruta();?>){
							
								function verRuta2(event){
									infowindow.close();
									var puntosruta=JSON.parse(event.data.laruta);
									var rutapath = new Array();
									for (var k in puntosruta['b']) { 
										rutapath.push(new google.maps.LatLng(puntosruta['b'][k]['lat'],puntosruta['b'][k]['lon']));
									}                         									
									var ruta = new google.maps.Polyline({
										path: rutapath,
										strokeColor: '#000000',
										strokeOpacity: 1.0,
										strokeWeight: 5
									  });
									ruta.setMap(map2);
									ciclorrutas.push(ruta);//Para borrar al actualizar
									
									google.maps.event.addListener(ruta, "click", (function(event) {
									
										strinfowindow="<a class='button borrarruta'><?php echo tr("ocultar_ruta"); ?></a>";
										infowindow.setContent(strinfowindow);
										infowindow.open(map2);
										infowindow.setPosition(event.latLng);
										
										$('a.borrarruta').click(function(){
											infowindow.close();
											ruta.setMap(null);
										});
										
									}));
								}
							
								$('input.ruta-'+sitio['id']).click({laruta: sitio['ruta']}, verRuta2);
	
							}
							
							
						}
					})(nuevomarcador));
					
					
					if(desplegar){
					google.maps.event.trigger(nuevomarcador, 'click',{laruta: sitio['ruta']});
					}
					
		}
		

		$('#actualizar').click(function(e){
		
			e.preventDefault();

			$('#loader').show();
			
			quitarMarcadores();
			quitarCiclorrutas();
			quitarCiclovias();
			
			var cargarmarcadores=false;
			var cargarciclorrutas=false;
			var cargarciclovias=false;

			$.post("<? echo url_api();?>", $("#formactualizar").serialize() )
			.done(function(data) {
			
				cargarmarcadores=true;
				
				function infowindowCiclorruta(cicloruta,titulo){
					google.maps.event.addListener(cicloruta, 'click',function(event) {
							infowindow.setContent(titulo);
							infowindow.open(map2);
							infowindow.setPosition(event.latLng);
					});
				}
				
				//Definir transparencia si se despliegan ciclorrutas y ciclovías al tiempo
				if($('#ciclorrutas').is(':checked') && $('#ciclovias').is(':checked')) var opacityruta=0.7;
				else var opacityruta=1.0;
				
				//Ciclorrutas
				if($('#ciclorrutas').is(':checked')){
					$.post("<? echo url_api();?>", { api: "ciclorrutas", pass: "<?php echo pass_api();?>" } )
					.done(function(data2) {		

						cargarciclorrutas=true;
						
						var cicloruta=new Array();
					
						var dataciclo = $.parseJSON(data2);
						
						for(var i in dataciclo) {
							var ruta=dataciclo[i]['ruta'];
							var puntosruta = ruta.split(";");
							var rutacicloruta = new Array();
							for(var j in puntosruta) {
								var elpuntoruta=puntosruta[j];
								var coord=elpuntoruta.split(",");
								if(coord[1]!=0 && coord[0]!=0) rutacicloruta.push(new google.maps.LatLng(coord[0],coord[1]));								
							}
							cicloruta[i]=	new google.maps.Polyline({
									path: rutacicloruta,
									strokeColor: '#2DBB28',
									strokeOpacity: opacityruta,
									strokeWeight: 5,
									map:map2,
								});
							
							infowindowCiclorruta( cicloruta[i],dataciclo[i]['id']+'. '+dataciclo[i]['nombre'] );
							
							ciclorrutas.push(cicloruta[i]);
						}
						
						if(cargarmarcadores && cargarciclorrutas && cargarciclovias)$('#loader').hide();
						
					});
				}
				else cargarciclorrutas=true;
				
				//Ciclovias
				if($('#ciclovias').is(':checked')){
					$.post("<? echo url_api();?>", { api: "ciclovias", pass: "<?php echo pass_api();?>" } )
					.done(function(data2) {		

						cargarciclovias=true;
						
						var cicloruta=new Array();
					
						var dataciclo = $.parseJSON(data2);
						
						for(var i in dataciclo) {
							var ruta=dataciclo[i]['ruta'];
							var puntosruta = ruta.split(";");
							var rutacicloruta = new Array();
							for(var j in puntosruta) {
								var elpuntoruta=puntosruta[j];
								var coord=elpuntoruta.split(",");
								if(coord[1]!=0 && coord[0]!=0) rutacicloruta.push(new google.maps.LatLng(coord[0],coord[1]));								
							}
							cicloruta[i]=	new google.maps.Polyline({
									path: rutacicloruta,
									strokeColor: '#cc0066',
									strokeOpacity: opacityruta,
									strokeWeight: 5,
									map:map2,
								});
							
							infowindowCiclorruta( cicloruta[i],dataciclo[i]['id']+'. '+dataciclo[i]['nombre'] );
							
							ciclovias.push(cicloruta[i]);
						}
						
						if(cargarmarcadores && cargarciclorrutas && cargarciclovias)$('#loader').hide();
						
					});
				}
				else cargarciclovias=true;
				
				

				data = $.parseJSON(data);
				marcadores=new Array();
				var ii=0;
				
				for(var i in data) {
					var tipo=data[i]['tipo'];
					marcadores[ii] = new google.maps.Marker({
						position: new google.maps.LatLng(data[i]['longitud'],data[i]['latitud']),
						map: map2,
						title: data[i]['nombrelimpio']+" ("+data[i]['id']+")",
						icon: markerimage[tipo]
					});
					markersArray.push(marcadores[ii]);
					
					google.maps.event.addListener(marcadores[ii], "click", (function(ii,i) {
						return function() {
							
							var strinfowindow="<a href=\'<?php echo url_sitio();?>"+data[i]['id']+"\' class=\'link_sitio\'><h4>"+data[i]['nombre']+"</h4></a><p>"+data[i]['descripcion']+"</p><p><a href=\'<?php echo url_sitio();?>"+data[i]['id']+"\' class=\'button small\'><?php echo tr("comentar_y_calificar"); ?></a>";
							if(data[i]['tipo']==<?php echo tipo_ruta();?>)strinfowindow=strinfowindow+" <input type=\'button\' class=\'button small ruta-"+data[i]['id']+"\' value=\'<?php echo tr("ver_ruta"); ?>\'/>";
							strinfowindow=strinfowindow+"</p>";

							infowindow.setContent(strinfowindow);
							infowindow.open(map2,marcadores[ii]);
							
							document.location.hash = hash_global;

							$('input.ruta-'+data[i]['id']).click({laruta: data[i]['ruta']}, verRuta);

							function verRuta(event){
								infowindow.close();
								
								var puntosruta=JSON.parse(event.data.laruta);
								var rutapath = new Array();
								for (var k in puntosruta['b']) { 
									rutapath.push(new google.maps.LatLng(puntosruta['b'][k]['lat'],puntosruta['b'][k]['lon']));
								}                         									
								var ruta = new google.maps.Polyline({
									path: rutapath,
									strokeColor: '#000000',
									strokeOpacity: 1.0,
									strokeWeight: 5
								  });
								ruta.setMap(map2);
								ciclorrutas.push(ruta);//Para borrar al actualizar
								
								google.maps.event.addListener(ruta, "click", (function(event) {
								
									strinfowindow="<a class='button borrarruta'><?php echo tr("ocultar_ruta"); ?></a>";
									infowindow.setContent(strinfowindow);
									infowindow.open(map2);
									infowindow.setPosition(event.latLng);
									
									$('a.borrarruta').click(function(){
										infowindow.close();
										ruta.setMap(null);
									});
									
								}));
								
								
							}
							
							
						}
					})(ii,i));
					ii=ii+1;
				}

				if(cargarmarcadores && cargarciclorrutas && cargarciclovias)$('#loader').hide();
				
			});

		});

		
		
	<?php
	}
	?>
	
	function getUrlVars(laurl)
	{
		//http://jquery-howto.blogspot.com/2009/09/get-url-parameters-values-with-jquery.html
	    var vars = [], hash;
	    var hashes = laurl.split('&');
	    for(var i = 0; i < hashes.length; i++)
	    {
	        hash = hashes[i].split('=');
	        vars.push(hash[0]);
	        vars[hash[0]] = hash[1];
	    }
	    return vars;
	}
	
	function procesarHash(){
		var elhash=window.location.hash.substring(1);//Remove #
		if(hash_global!=elhash){

			//Nuevo Hash
			var urlVars=getUrlVars(elhash);
			
			//Centro
			if(typeof urlVars["lat"] !== 'undefined' && typeof urlVars["lon"] !== 'undefined')
				map2.setCenter( new google.maps.LatLng(parseFloat(urlVars["lat"]),parseFloat(urlVars["lon"])) );
				
			//Zoom	
			if(typeof urlVars["z"] !== 'undefined')
				map2.setZoom(parseInt(urlVars["z"]));	
			
			//Categorias
			if(typeof urlVars["t"] !== 'undefined'){
				var partesfiltros = urlVars["t"].split(",");
				$("#formactualizar input").prop("checked", false); //Desmarcar todas desde el principio
				for(var j in partesfiltros) {
					$("#formactualizar input[name='"+partesfiltros[j]+"']").prop("checked", true);
				}
				$('#actualizar').click(); //Enviar los cambios
			}
			

			//sitios
			if(typeof urlVars["s"] !== 'undefined'){
				$.post("<? echo url_api();?>", { api: "lugar", id: parseInt(urlVars["s"]), pass: "<?php echo pass_api();?>" } )
					.done(function(datasitio) {		
						datasitio = $.parseJSON(datasitio);
						pintarMarcador(datasitio[0],true);
						
						if(typeof urlVars["lat"] === 'undefined' || typeof urlVars["lon"] === 'undefined')
							map2.setCenter( new google.maps.LatLng(datasitio[0]['longitud'],datasitio[0]['latitud']) ); 
						if(typeof urlVars["z"] === 'undefined')
							map2.setZoom(15);
						
					});
			}


			hash_global=elhash;
		}		
	}
	
	//Permalink
	$('#campopermalink').val('<?php echo url()?>#'+hash_global);
	$('#campopermalink').click(function() {$(this).select();}); 
	
	$('#permalink').mouseover(function() {
   		$('#campopermalink').val('<?php echo url()?>#'+hash_global);
	});
	$('#permalink').click(function(e) {
   		e.preventDefault();
	});
	
	function serializeFiltros(){
		var str="";
		<?php 
		foreach($tiposSitio2 as $key=>$categoria){				
			if($categoria['visible'])echo'
			if($("#formactualizar input[name='.$key.']").is(":checked")) str=str+"'.$key.',";
			';
		}
		?>
		
		if($("#formactualizar input[name='ciclorrutas']").is(':checked')) str=str+"ciclorrutas,";
		if($("#formactualizar input[name='ciclovias']").is(':checked')) str=str+"ciclovias,";
		str = str.replace(/,$/, "");
		return str;
	}
	
	function calcularHash(){
		var centroactual=map2.getCenter();
		var hashactualizado="lat="+centroactual.lat()+"&lon="+centroactual.lng()+"&z="+map2.getZoom()+"&t="+serializeFiltros();
		//document.location.hash = hashactualizado; 
		hash_global = hashactualizado;
		$('#campopermalink').val('<?php echo url()?>#'+hash_global);
		
	}

	function initializeGMap() {

		var mapOptions = {
		  <?php 
		  /*
		  if($_SESSION["country"]=='CO') echo'zoom: 6,center: new google.maps.LatLng(4.3786211,-73.5453711),';
		  else if($_SESSION["country"]=='FR') echo'zoom: 6,center: new google.maps.LatLng(46.71109,1.7191036),';
		  else echo'zoom: 3,center: new google.maps.LatLng(28.505725,-34.8567554),';
		  */
		  $infoLatLong=countryLatLongZoom($_SESSION["country"]);
		  echo'zoom: '.$infoLatLong[2].',center: new google.maps.LatLng('.$infoLatLong[0].','.$infoLatLong[1].'),';?>mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		
		
		
		<?php 
		  if(isset($_COOKIE['ciudadguardada']) && !empty($_COOKIE['ciudadguardada']) ){
			$laciudadguardada=(int)$_COOKIE['ciudadguardada'];
			if(isset($ciudades[$laciudadguardada])) echo "
				$('a.ciudadactual').html('".$ciudades[$laciudadguardada][0]."');
				$('#ciudad').val('".$ciudades[$laciudadguardada][1]."');";
			
		  }
		  else if(isset($_SESSION['ciudadguardada']) && !empty($_SESSION['ciudadguardada'])){
			$laciudadguardada=(int)$_SESSION['ciudadguardada'];
			if(isset($ciudades[$laciudadguardada])) echo "
				$('a.ciudadactual').html('".$ciudades[$laciudadguardada][0]."');
				$('#ciudad').val('".$ciudades[$laciudadguardada][1]."');";
		  }
		 ?>


					
		<?php
		if($pagina==md5('index.php')){
		?>	

			map2 = new google.maps.Map(document.getElementById('mapaindex'),mapOptions);
			
			procesarHash();
			$(window).on('hashchange', procesarHash);
			
			window.onbeforeunload = function() { document.location.hash = hash_global;};
			
			var infowindowagregar = new google.maps.InfoWindow({ content:'',position:new google.maps.LatLng(0,0) });
			
			google.maps.event.addListener(map2, "rightclick", function(event) {
			
					var lat = event.latLng.lat();
					var lng = event.latLng.lng();
					
					var contentString ='<a href="<?php echo url_agregar().'?lat=';?>'+lat+'<?php echo'&lon=';?>'+lng+'" class="button"><?php echo tr("agregar_sitio_en_esta_ubicacion"); ?></a>';
					
					document.location.hash = hash_global;
					
					infowindowagregar.setContent(contentString);
					infowindowagregar.setPosition(event.latLng);
					infowindowagregar.open(map2);
				
			});
			
			google.maps.event.addListener(map2, 'click', calcularHash);
			google.maps.event.addListener(map2, 'dblclick', calcularHash);
			google.maps.event.addListener(map2, 'dragend', calcularHash);
			google.maps.event.addListener(map2, 'zoom_changed', calcularHash);		
			
			$("#formactualizar input[type=checkbox]").change(function(){ calcularHash(); });	


			/*==========GEOLOCALIZACION==============*/
			function getLocation() {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(showCurrentPosition);
				}
			}
			function showCurrentPosition(position) {
				var lat = position.coords.latitude;
				var lng = position.coords.longitude;
				map2.setCenter(new google.maps.LatLng(lat, lng));
				map2.setZoom(15);
				
				var markerImage = new google.maps.MarkerImage('<?php echo url();?>img/currentPosition.gif',
															new google.maps.Size(32, 32),
															new google.maps.Point(0, 0),
															new google.maps.Point(16, 16));

				marker = new google.maps.Marker({
					position: new google.maps.LatLng(lat, lng),
					map: map2,
					icon: markerImage,
					optimized: false
				});

				google.maps.event.addListener(marker, "click", function() {
					infowindow.setContent("<h4><?php echo tr("posicion_actual"); ?></h4>");
					infowindow.open(map2,marker);
				});

				
			}
			if(!window.location.hash) getLocation();


			$('#actualizar').click(); //Cargar sitios
			
			
			//Buscar ciudad
			$('#listaciudades').hide();
			
			$('#ciudades').submit(function(e){
			
				e.preventDefault();
				
				var geocoder = new google.maps.Geocoder();
			    var address = $('#ciudad').val();

			    geocoder.geocode( { 'address': address}, function(results, status) {
			      	if (status == google.maps.GeocoderStatus.OK) {
			      		
			      		if(results.length==1){
			      			map2.setCenter(results[0].geometry.location);
			      			if (results[0].geometry.viewport) map2.fitBounds(results[0].geometry.viewport);
			      			$('#listaciudades').hide();
			      		}
			      		else{
			      			var opciones = '<div class="row"><div class="large-9 columns"><h2><?php echo tr("ciudades"); ?>:</h2></div><div class="large-3 columns"><a class="cerrar button alert small">X</a></div></div>';
			      			$('#listaciudades').html(opciones);
			      			$('#listaciudades').append('<table class="large-12 columns" id="tablaciudades"></table>');
			      			
					      	jQuery.each(results, function(indice, item) {
					      	
					      		var idciudad='resultado-'+indice;
					      		
								$('#tablaciudades').append( '<tr><td><a id="'+idciudad+'">'+item.formatted_address+'</a></td></tr>' );
								
								$('#'+idciudad).click(function(){
									map2.setCenter(item.geometry.location);
									if (item.geometry.viewport) map2.fitBounds(item.geometry.viewport);
									$('#listaciudades').hide();
								});
								
							});
							
			      			$('#listaciudades').show();
			      			$('#listaciudades .cerrar').click(function(){$('#listaciudades').hide();});
						}
						
						
			      
			      	} else {
			        	var opciones = "<div class='row'><div class='large-9 columns'><h2><?php echo tr("no_se_encontro_ciudad"); ?></h2></div><div class='large-3 columns'><a class='cerrar button alert small'>X</a></div></div>";
			        	$('#listaciudades').html(opciones);
			      		$('#listaciudades').show();
			      		$('#listaciudades .cerrar').click(function(){$('#listaciudades').hide();});
			      	}
			      	
			    });
			    
			    
			});
			
			
		<?php
		}
		else if($pagina==md5('agregar.php')){
		?>

			var geocoder = new google.maps.Geocoder();	
			var puntosRuta = [];	
			
			var mapOptionsagregar = {
				  zoom: 15,
				  center: <?php if(isset($latitud)&&isset($longitud))echo"new google.maps.LatLng(".$latitud.", ".$longitud.")";else echo "new google.maps.LatLng(4.65385,-74.058409)";?>,
				  mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				
			map = new google.maps.Map(document.getElementById('googlemaps'),mapOptionsagregar);
			
			<?php if(isset($latitud)&&isset($longitud)){ ?>
			$('#latlongmapa').val(<?php echo '"'.$latitud.",".$longitud.'"'; ?>);
			darDireccion(new google.maps.LatLng(<?php echo $latitud.",".$longitud; ?>));
			<?php } ?>
		
			marker = new google.maps.Marker({
			  position: map.getCenter(),
			  map: map,
			  draggable: true, 
			  animation: google.maps.Animation.DROP,
			  title: 'Sitio'
			});

			var ruta = new google.maps.Polyline({
				strokeColor: '#000000',
				strokeOpacity: 1.0,
				strokeWeight: 4
			  });
			ruta.setMap(map);
			
			function darDireccion(punto){
				geocoder.geocode({'latLng': punto}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK && results[0]) $('#direccion').val(results[0].formatted_address);
				});
			}

			function ubicarMarcador(event) {
				var lat = event.latLng.lat();
				var lng = event.latLng.lng();
				var punto=new google.maps.LatLng(lat,lng);
				marker.setPosition( punto );
				marker.setMap(map);
				$('#latlongmapa').val(punto.lat()+","+punto.lng());
				
				darDireccion(punto);
			}

			function actualizarCampoRuta(){
				var data=ruta.getPath().getArray();	
				var newData = [];
			    for(var i = 0; i < data.length; i++) {
			        var obj = new Object();
			        obj['lat'] = data[i].lat();
			        obj['lon'] = data[i].lng();
			        newData.push(obj);
			    }	
			    var obj2 = new Object();
			    obj2['b'] = newData;		    
				$('#rutamapa').val( JSON.stringify( obj2 ) );
			}

			google.maps.event.addListener(map, "click", function(event) {

				if($('#tipo').val()==<?php echo tipo_ruta();?>){
					// Because path is an MVCArray, we can simply append a new coordinate
					// and it will automatically appear.
					var path = ruta.getPath();
					path.push(event.latLng);														

					if(path.getLength()==1){
						/*
						var lat = event.latLng.lat();
						var lng = event.latLng.lng();
						var punto=new google.maps.LatLng(lat,lng);
						marker.setMap(map);
						marker.setPosition( punto );
						$('#latlongmapa').val(punto.lat()+","+punto.lng());
						*/
						ubicarMarcador(event)
					}
					
					
					actualizarCampoRuta();										
				}
				else{
					ubicarMarcador(event);
				}
				
			});			
			
			google.maps.event.addListener(map, "rightclick", ubicarMarcador);
			google.maps.event.addListener(map, "dblclick", ubicarMarcador);		
			google.maps.event.addListener(marker, "dragend", ubicarMarcador);	

			//ocultar campos exclusivos de parqueadero
			$('#parqueadero').hide();

			$('#tipo').on('change', function() {

				if($('#tipo').val()==<?php echo tipo_ruta();?>){
					marker.setIcon(markerimage[this.value]);
					marker.setMap(null);
					$('#instrucciones').html("<?php echo tr("explicaciones_navegacion_ruta"); ?>. <a href=\"#\" id=\"borrarruta\" class=\"button small\"><?php echo tr("borrar_ruta"); ?></a> <a href=\"#\" id=\"borrarpunto\" class=\"button small\"><?php echo tr("borrar_ultimo_punto"); ?></a>");
					$('#borrarruta').click(function(e){
						e.preventDefault();
						marker.setMap(null);
						var path = ruta.getPath();
						while(path.getLength() > 0) path.pop(); 
						actualizarCampoRuta();
					});
					$('#borrarpunto').click(function(e){
						e.preventDefault();
						var path = ruta.getPath();
						path.pop(); 
						if(path.getLength()>0){
							var iultimo=path.getLength()-1;
							var ultimo=path.getAt(iultimo);
							//var ultimopunto=new google.maps.LatLng(ultimo.lat(),ultimo.lng());
							//marker.setPosition( ultimopunto );	
							//$('#latlongmapa').val(ultimo.lat()+","+ultimo.lng());
							actualizarCampoRuta();
						}
						else{ 
							marker.setMap(null);
						}
					});
				}
				else{
					var path = ruta.getPath();
					if ( path.getLength()>0 && !confirm("<?php echo tr("advertencia_ruta_borrar"); ?>") ) return false;
					else{
						marker.setIcon(markerimage[this.value]);
						marker.setMap(map);
						$('#instrucciones').html("<?php echo tr("explicaciones_navegacion"); ?>");
						while(path.getLength() > 0) path.pop(); 
					}					
				}
				
				
				if($('#tipo').val()==<?php echo tipo_parqueadero();?>) $('#parqueadero').show();
				else $('#parqueadero').hide();
			});
			
			//Buscar ciudad
			$('#listaciudadesagregar').hide();
			
			$('#buscarCiudad').click(function(e){
				
				var geocoder = new google.maps.Geocoder();
			    var address = $('#ciudad').val();

			    geocoder.geocode( { 'address': address}, function(results, status) {
			      	if (status == google.maps.GeocoderStatus.OK) {
			      		
			      		if(results.length==1){
			      			map.setCenter(results[0].geometry.location);
			      			if (results[0].geometry.viewport) map.fitBounds(results[0].geometry.viewport);
			      			$('#listaciudadesagregar').hide();
			      		}
			      		else{
			      			var opciones = '<div class="row"><div class="large-12 columns text-right"><a class="cerrar button alert small">X</a></div></div>';
			      			$('#listaciudadesagregar').html(opciones);
			      			$('#listaciudadesagregar').append('<table class="large-12 columns" id="tablaciudades"></table>');
			      			
					      	jQuery.each(results, function(indice, item) {
					      	
					      		var idciudad='resultado-'+indice;
					      		
								$('#tablaciudades').append( '<tr><td><a id="'+idciudad+'">'+item.formatted_address+'</a></td></tr>' );
								
								$('#'+idciudad).click(function(){
									map.setCenter(item.geometry.location);
									if (item.geometry.viewport) map.fitBounds(item.geometry.viewport);
									$('#listaciudadesagregar').hide();
								});
								
							});
							
			      			$('#listaciudadesagregar').show();
			      			$('#listaciudadesagregar .cerrar').click(function(){$('#listaciudadesagregar').hide();});
						}
						
						
			      
			      	} else {
			        	var opciones = "<div class='row'><div class='large-9 columns'><h2><?php echo tr("no_se_encontro_ciudad"); ?></h2></div><div class='large-3 columns'><a class='cerrar button alert small'>X</a></div></div>";
			        	$('#listaciudades').html(opciones);
			      		$('#listaciudades').show();
			      		$('#listaciudades .cerrar').click(function(){$('#listaciudades').hide();});
			      	}
			      	
			    });
			    
			    
			});
			
			var tamanooriginal=$('#googlemaps').height();
			
			$('#togglemap').click(function(){
			
				if($('#googlemaps').height()==tamanooriginal){
					$('#googlemaps').height('600px');
					$('#togglemap span').html("<?php echo tr("reducir_mapa"); ?>");
				}
				else{
					$('#googlemaps').height(tamanooriginal);
					$('#togglemap span').html("<?php echo tr("aumentar_mapa"); ?>");
				}
				
				google.maps.event.trigger(map, 'resize');
			});
			
			
		<?php
		}
		else if($pagina==md5('sitio.php')){
		?>

		var mapsitio = new google.maps.Map(document.getElementById("googlemaps"), mapOptions);

		dibujarSitio(mapsitio,markerimage[4]);
		
		<?php 
		}
		?>
	}
	
	initializeGMap();


	<?php
	if($pagina==md5('agregar.php')){
	?>
	
	$('#formulario_agregar').submit(function(){

		$('.alert-box').remove();

		var enviar=true;
		var mapalleno=true;

		if( !$('#latlongmapa').val() ){
			mapalleno=false;
			$('#googlemaps').css('border','2px solid #F00');
		}
		if( !$('#nombre').val() ){
			enviar=false;
			$('#nombre').css('border','2px solid #F00');
		}
		if( !$('#descripcion').val() ){
			enviar=false;
			$('#descripcion').css('border','2px solid #F00');
		}

		if(!enviar){
			$('h2').parent().append('<div data-alert class="alert-box alert"><?php echo tr("campos_obligatorios"); ?></div>');
			$('html,body').animate({scrollTop: $('h2').parent().offset().top},'fast');
			return false;
		}
		if(!mapalleno){
			$('h2').parent().append('<div data-alert class="alert-box alert"><?php echo tr("ubicar_sitio"); ?></div>');
			$('html,body').animate({scrollTop: $('#googlemaps').offset().top},'fast');
			return false;
		}
		
	});	

	<?php
	} ?>
	
	
});
