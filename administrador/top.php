<?php
include_once('../funciones.php');
include_once('funciones_admin.php');
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

<head>

	<!-- 
	
	========================= BICIMAPA =========================
	
	                                           $"   *.      
	               d$$$$$$$P"                  $    J
	                   ^$.                     4r  "
	                   d"b                    .db
	                  P   $                  e" $
	         ..ec.. ."     *.              zP   $.zec..
	     .^        3*b.     *.           .P" .@"4F      "4
	   ."         d"  ^b.    *c        .$"  d"   $         %
	  /          P      $.    "c      d"   @     3r         3
	 4        .eE........$r===e$$$$eeP    J       *..        b
	 $       $$$$$       $   4$$$$$$$     F       d$$$.      4
	 $       $$$$$       $   4$$$$$$$     L       *$$$"      4
	 4         "      ""3P ===$$$$$$"     3                  P
	  *                 $       """        b                J
	   ".             .P                    %.             @
	     %.         z*"                      ^%.        .r"
	        "*==*""                             ^"*==*""   
	
	 -->


	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title><?php if (isset($top_titulo)) echo $top_titulo.' - Bicimapa.com'; else echo'Bicimapa - El mapa de los ciclistas en la ciudad';?></title>

  	<link href="<?php echo url();?>img/avatar_128.png" rel="shortcut icon" />
	
	<meta name="robots" content="index, follow" />
	<meta name="keywords" content="bicicleta,colombia,cicla,mapa,tienda,taller,parqueadero,ciclista" />
	<meta name="description" content="El mapa de los ciclistas en la ciudad. &Uacute;salo, mej&oacute;ralo y comp&aacute;rtelo." />
	<meta name="Revisit-After" content="3 Days" />
	<meta property="og:title" content="<?php if (isset($top_titulo)) echo $top_titulo.' - Bicimapa.com'; else echo'Bicimapa - El mapa de los ciclistas en la ciudad';?>" />
	<meta property="og:description" content="El mapa de los ciclistas en la ciudad. &Uacute;salo, mej&oacute;ralo y comp&aacute;rtelo." />
	<meta property="og:image" content="<?php echo url();?>img/avatar_128.png" />
	
	<link rel="stylesheet" href="<?php echo url();?>css/foundation.css">
	<link rel="stylesheet" href="<?php echo url();?>css/rateit.css">	
	<link rel="stylesheet" href="<?php echo url();?>css/estilo.css">
	
	<style>
	#mapaciclorrutas{height:500px;}
	#mapaciclovias{height:500px;}
	</style>

  	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script src="<?php echo url();?>js/vendor/custom.modernizr.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	<script src="<?php echo url();?>js/jquery.rateit.min.js"></script>
	<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
	
	<script>
    $(document).ready(function() {

    	<?php if($pagina=='administrador.php'){?>
    	
    	$('#buscaradmin').click(function(){
    		$('div.buscaradmin').toggle();
    	});

    	tinymce.init({
		    selector: "textarea",
		    theme: "modern",
		    plugins: [
		              "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
		              "searchreplace visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
		              "table directionality emoticons template paste textcolor"
		     ],
		     menubar: false,
		     statusbar : false,
		     toolbar_items_size: 'small'
		     
		 });
    			
    	$('.editar').click(function(){
			$(this).parent().parent().find('div.modal').toggle();
							
			
				var latlong=$(this).parent().parent().find('#latlongmapa').val();
				var partes=latlong.split(',');

				var mapOptions = {
					  zoom: 15,
					  center: new google.maps.LatLng(partes[0], partes[1]),
					  mapTypeId: google.maps.MapTypeId.ROADMAP
					};

				map = new google.maps.Map($(this).parent().parent().find('#googlemaps')[0],mapOptions);
				
				marker = new google.maps.Marker({
				  position: map.getCenter(),
				  map: map,
				  draggable: true, 
				  animation: google.maps.Animation.DROP,
				  title: 'Nuevo sitio'
				});

				function ubicarMarcador(event){
					var lat = event.latLng.lat();
					var lng = event.latLng.lng();
					var punto=new google.maps.LatLng(lat,lng);
					marker.setPosition( punto );
					map.setCenter( punto );
					$('#latlongmapa').val(punto.lat()+","+punto.lng());
				}
				
				google.maps.event.addListener(map, "rightclick", ubicarMarcador);
				google.maps.event.addListener(map, "dblclick", ubicarMarcador);		
				google.maps.event.addListener(marker, "dragend", ubicarMarcador);	
			
			
		});

    	$('a.cancelar').click(function(){$(this).parent().parent().parent().parent().find('div.modal').toggle();});

    	$('a.eliminar').click(function(){
			if (!confirm("¿Está seguro de borrar el sitio de id "+$(this).attr("title")+"?")) return false;
        });
        
		//Google Maps
		var map,map2;
		var marker;
		var markerimage = ['<?php echo url();?>img/marcador.png','<?php echo url();?>img/tienda.png','<?php echo url();?>img/parqueadero.png','<?php echo url();?>img/taller.png','<?php echo url();?>img/ruta.png','<?php echo url();?>img/atencion.png'];


		function initializeGMap() {

			var centromapa=new google.maps.LatLng(4.65385,-74.058409);
			var zoommapa=12;

			var mapOptions = {
			  zoom: zoommapa,
			  center: centromapa,
			  mapTypeId: google.maps.MapTypeId.ROADMAP
			};
		}
		
		initializeGMap();  
		
		<?php } else if($pagina=='gente.php'){?>  	

		$('a.editar').click(function(){
			$(this).parent().parent().find('div.modal').toggle();			
		});

		$('a.agregar').click(function(){
			$('#modalagregar').toggle();
    	});

    	$('a.cancelar').click(function(){$(this).parent().parent().parent().parent().find('div.modal').toggle();});

    	$('a.eliminar').click(function(){
			if (!confirm("¿Está seguro de borrar el sitio de id "+$(this).attr("title")+"?")) return false;
        });

		<?php } ?> 
		<?php if($pagina=='short.php'){?>  	

    	$('a.eliminar').click(function(){
			if (!confirm("¿Está seguro de borrar la short url "+$(this).attr("title")+"?")) return false;
        });

		<?php } ?> 
		<?php if($pagina=='widgets.php'){?>  	

    	$('#generar').click(function(){
			var params=$('#permalink').val().split("#");
			var p="";
			if(params.length==2){
				p=params[1];
				var url="<?php echo url_iframe();?>#"+p;
				var codigo="<iframe src=\""+url+"\" width=\""+$('#ancho').val()+"\" height=\""+$('#alto').val()+"\" style=\"border:0px;\"></iframe>";
				$('#codigo').val(codigo);
				$('#preview').html(codigo);
			}
			else alert('Permalink no es valido.');
        });

		<?php } ?> 
		<?php if($pagina=='ciclorrutas.php'){?> 

		var map;
		var marker;
		var ruta;
		var cicloruta;
		
		function initializeGMap() {
			
			var mapOptions = {
					  zoom: 15,
					  center: new google.maps.LatLng(4.65385,-74.058409),
					  mapTypeId: google.maps.MapTypeId.ROADMAP
					};
			map = new google.maps.Map(document.getElementById('mapaciclorrutas'),mapOptions);
			ruta = new google.maps.Polyline({
				strokeColor: '#000000',
				strokeOpacity: 1.0,
				strokeWeight: 4
			  });
			
			ruta.setMap(map);
			
			marker = new google.maps.Marker({
				  position: map.getCenter(),
				  draggable: true, 
				  animation: google.maps.Animation.DROP,
				  title: 'Sitio'
			});
			
			function ubicarMarcador(event) {
				var lat = event.latLng.lat();
				var lng = event.latLng.lng();
				var punto=new google.maps.LatLng(lat,lng);
				marker.setPosition( punto );
				marker.setMap(map);

				var path = ruta.getPath();
				path.push(event.latLng);

				actualizarCampoRuta();
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
				$('#ruta').val( JSON.stringify( obj2 ) );
			}
			
			google.maps.event.addListener(map, "rightclick", ubicarMarcador);
			google.maps.event.addListener(map, "dblclick", ubicarMarcador);		
			google.maps.event.addListener(marker, "dragend", ubicarMarcador);
			google.maps.event.addListener(map, "click", ubicarMarcador);
			
			$('#borrarruta').click(function(){
				marker.setMap(null);
				var path = ruta.getPath();
				while(path.getLength() > 0) path.pop(); 
				actualizarCampoRuta();
			});
			
			$('#borrarpunto').click(function(){
				var path = ruta.getPath();
				path.pop(); 
				if(path.getLength()>0){
					var iultimo=path.getLength()-1;
					var ultimo=path.getAt(iultimo);
					var ultimopunto=new google.maps.LatLng(ultimo.lat(),ultimo.lng());
					marker.setPosition( ultimopunto );	
					actualizarCampoRuta();
				}
			});

			$('#cambiarextremo').click(function(){
				
				var path2 = new Array();
				var path = ruta.getPath();
				for(var j=0;j<path.getLength();j=j+1) path2.push( new google.maps.LatLng(path.getAt(j).lat(),path.getAt(j).lng()) );
				while(path.getLength() > 0) path.pop();
				for(var k=(path2.length-1);k>=0;k=k-1) path.push(path2[k]);
						
				if(path.getLength()>0){
					var iultimo=path.getLength()-1;
					var ultimo=path.getAt(iultimo);
					var ultimopunto=new google.maps.LatLng(ultimo.lat(),ultimo.lng());
					marker.setPosition( ultimopunto );	
					actualizarCampoRuta();
				}
				
			});

			
			
		}

		initializeGMap();
		
		$('#eliminar').submit(function(){
			return confirm("borrar la ciclorruta?");
		});

		$('#ciclorruta').change(function(){

				if($('#ciclorruta').val()==0){
					
					$('.idciclorruta').val(0);
					
					var answer = confirm("¿Desea basarse en la ciclorruta cargada?")
					if (answer){
						
					}
					else{
						$('#nombre').val('');
						$('#descripcion').val('');
						
						var path = ruta.getPath();
						while (path.length > 0) {path.pop();}
					}
					
				}
				else{

					
					$.post("<? echo url_api();?>", { api: "ciclorruta", id:$('#ciclorruta').val() , pass: "<?php echo pass_api();?>" } )
					.done(function(data) {		

						cargarciclorrutas=true;
					
						var dataciclo = $.parseJSON(data);

						$('.idciclorruta').val(dataciclo['id']);
						$('#nombre').val(dataciclo['nombre']);
						$('#descripcion').val(dataciclo['descripcion']);
						
						//Borrar la ruta anterior
						var path = ruta.getPath();
						while (path.length > 0) {path.pop();}
						
						var rutaciclo=dataciclo['ruta'];
						var puntosruta = rutaciclo.split(";");
						var bounds = new google.maps.LatLngBounds();
						for(var j in puntosruta) {
							var elpuntoruta=puntosruta[j];
							var coord=elpuntoruta.split(",");
							if(coord[1]!=0 && coord[0]!=0){
								path.push(new google.maps.LatLng(coord[0],coord[1]));
								bounds.extend(new google.maps.LatLng(coord[0],coord[1]));

								marker.setPosition( new google.maps.LatLng(coord[0],coord[1]) );
								marker.setMap(map);	
							}							
						}
						map.fitBounds(bounds);
						
					});
					
					
					
				}
			
		});

		
		<?php } 
		
    	if($pagina=='ciclovias.php'){?> 

		var map;
		var marker;
		var ruta;
		var cicloruta;
		
		function initializeGMap() {
			
			var mapOptions = {
					  zoom: 15,
					  center: new google.maps.LatLng(4.65385,-74.058409),
					  mapTypeId: google.maps.MapTypeId.ROADMAP
					};
			map = new google.maps.Map(document.getElementById('mapaciclovias'),mapOptions);

			//Si estás acá buscando porque no de despliega el mapa puede ser que no le hayas definido la altura al div (Sí, jorge, ya te había pasado)
			
			ruta = new google.maps.Polyline({
				strokeColor: '#000000',
				strokeOpacity: 1.0,
				strokeWeight: 4
			  });
			
			ruta.setMap(map);

			marker = new google.maps.Marker({
				  position: map.getCenter(),
				  draggable: true, 
				  animation: google.maps.Animation.DROP,
				  title: 'Sitio'
			});
			
			function ubicarMarcador(event) {
				var lat = event.latLng.lat();
				var lng = event.latLng.lng();
				var punto=new google.maps.LatLng(lat,lng);
				marker.setPosition( punto );
				marker.setMap(map);

				var path = ruta.getPath();
				path.push(event.latLng);

				actualizarCampoRuta();
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
				$('#ruta').val( JSON.stringify( obj2 ) );
			}
			
			google.maps.event.addListener(map, "rightclick", ubicarMarcador);
			google.maps.event.addListener(map, "dblclick", ubicarMarcador);		
			google.maps.event.addListener(marker, "dragend", ubicarMarcador);
			google.maps.event.addListener(map, "click", ubicarMarcador);

			$('#borrarruta').click(function(){
				marker.setMap(null);
				var path = ruta.getPath();
				while(path.getLength() > 0) path.pop(); 
				actualizarCampoRuta();
			});
			
			$('#borrarpunto').click(function(){
				var path = ruta.getPath();
				path.pop(); 
				if(path.getLength()>0){
					var iultimo=path.getLength()-1;
					var ultimo=path.getAt(iultimo);
					var ultimopunto=new google.maps.LatLng(ultimo.lat(),ultimo.lng());
					marker.setPosition( ultimopunto );	
					actualizarCampoRuta();
				}
			});

			$('#cambiarextremo').click(function(){
				
				var path2 = new Array();
				var path = ruta.getPath();
				for(var j=0;j<path.getLength();j=j+1) path2.push( new google.maps.LatLng(path.getAt(j).lat(),path.getAt(j).lng()) );
				while(path.getLength() > 0) path.pop();
				for(var k=(path2.length-1);k>=0;k=k-1) path.push(path2[k]);
						
				if(path.getLength()>0){
					var iultimo=path.getLength()-1;
					var ultimo=path.getAt(iultimo);
					var ultimopunto=new google.maps.LatLng(ultimo.lat(),ultimo.lng());
					marker.setPosition( ultimopunto );	
					actualizarCampoRuta();
				}
				
			});
			
			
		}

		initializeGMap();

		$('#eliminar').submit(function(){
			return confirm("borrar la ciclovia?");
		});

		$('#ciclovia').change(function(){

				if($('#ciclovia').val()==0){
					
					$('.idciclovia').val(0);
					
					var answer = confirm("¿Desea basarse en la ciclovia cargada?")
					if (answer){
						
					}
					else{
						$('#nombre').val('');
						$('#descripcion').val('');
						
						var path = ruta.getPath();
						while (path.length > 0) {path.pop();}
					}
					
				}
				else{

					
					$.post("<? echo url_api();?>", { api: "ciclovia", id:$('#ciclovia').val() , pass: "<?php echo pass_api();?>" } )
					.done(function(data) {		

						cargarciclovias=true;
					
						var dataciclo = $.parseJSON(data);

						$('.idciclovia').val(dataciclo['id']);
						$('#nombre').val(dataciclo['nombre']);
						$('#descripcion').val(dataciclo['descripcion']);
						
						//Borrar la ruta anterior
						var path = ruta.getPath();
						while (path.length > 0) {path.pop();}
						
						var rutaciclo=dataciclo['ruta'];
						var puntosruta = rutaciclo.split(";");
						var bounds = new google.maps.LatLngBounds();
						for(var j in puntosruta) {
							var elpuntoruta=puntosruta[j];
							var coord=elpuntoruta.split(",");
							if(coord[1]!=0 && coord[0]!=0){
								path.push(new google.maps.LatLng(coord[0],coord[1]));
								bounds.extend(new google.maps.LatLng(coord[0],coord[1]));

								marker.setPosition( new google.maps.LatLng(coord[0],coord[1]) );
								marker.setMap(map);	
							}							
						}
						map.fitBounds(bounds);
						
					});
					
					
					
				}
			
		});
		
		<?php } ?> 	


		
		
    });
    </script>
    
    <?php if($pagina=='dashboard.php'){?>
    
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
		google.load("visualization", "1", {packages:["corechart"]});
		<?php echo darGraficaTipoSitios();?>
		<?php echo darGraficaEventos(15);?>

	</script>
	<?php } ?> 

    

</head>
<body>

<nav class="top-bar" id="top-bar">
  <ul class="title-area">
    <!-- Title Area -->
    <li class="name">
      <h1><a href="<?php echo url();?>"><img src="<?php echo url();?>img/bicimapa_top.png" alt="Bicimapa"></a></h1>
    </li>
    <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
  </ul>

  <section class="top-bar-section">
    <!-- Left Nav Section -->
    <ul class="left">
    		<li><a href="<?php echo url_administrador();?>">Inicio</a></li>
	      	<li class="divider"></li>
    		<li><a href="<?php echo url_administrador_sitios();?>">Sitios</a></li>
	      	<li class="divider"></li>
	      	<li><a href="<?php echo url_administrador_ciclorrutas();?>">Ciclorrutas</a></li>
	      	<li class="divider"></li>
	      	<li><a href="<?php echo url_administrador_ciclovias();?>">Ciclov&iacute;as</a></li>
	      	<li class="divider"></li>
	      	<li><a href="<?php echo url_administrador_bicigente();?>">Bicigente</a></li>
	      	<li class="divider"></li>
			<li><a href="<?php echo url_administrador_short();?>">ShortURL</a></li>
	      	<li class="divider"></li>
			<li><a href="<?php echo url_administrador_widgets();?>">Widgets</a></li>
	      	<li class="divider"></li>
	      	<li><a href="<?php echo url_administrador().'api_doc.php';?>">API Doc</a></li>
	      	<li class="divider"></li>
	      	<li><a href="<?php echo url_administrador();?>?accion=salir" class="button secondary">Cerrar Sesi&oacute;n</a> </li>
	</ul>
  </section>
</nav>