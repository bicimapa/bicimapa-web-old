<?php 
include_once('funciones.php');
$pagina='sitio.php';
$id=(int)$_GET['id'];
$sitios=darSitio($id);


if($sitios!=null){
	$sitio=$sitios[0];
	$top_titulo="".$sitio['nombre']."";
	$top_descripcion="Informaci&oacute;n sobre ".$sitio['nombre'].". Calificaciones, comentarios, tel&eacute;fono, direcci&oacute;n y ubicaci&oacute;n.";
}



include_once('top.php');?>

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=404487242984142";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

	$(window).resize(function(){
		 $(".fb-comments").attr("data-width", $(".comentariosfb").width());
		 FB.XFBML.parse($(".comentariosfb")[0]);
	});
	 $(document).ready(function(){
		 $(".fb-comments").attr("data-width", $(".comentariosfb").width());
		 FB.XFBML.parse($(".comentariosfb")[0]);
	});
	</script>

	
	
		
	<?php 
	
	
	if(count($sitios)==1){
		foreach($sitios as $sitio){
			$tipo=$sitio['tipo'];
			
			if(isset($sitio['quien'])&&!empty($sitio['quien'])&&isset($sitio['email'])&&!empty($sitio['email'])) $quien=$sitio['quien'].' ('.$sitio['email'].')';
			else if(isset($sitio['quien'])&&!empty($sitio['quien'])) $quien=$sitio['quien'];
			else if(isset($sitio['email'])&&!empty($sitio['email'])) $quien=$sitio['email'];
			else $quien='An&oacute;nimo';
			
			?>
			<div class="row">
				<div class="large-6 columns">
						<h3><?php echo $sitio['nombre'];if(isset($tiposSitio2[$tipo])) echo' <img src="'.url().$tiposSitio2[$tipo]['img'].'" title="'.$tiposSitio2[$tipo]['nombre'].'" alt="'.$tiposSitio2[$tipo]['nombre'].'"/>'?></h3>
						<p><?php echo $sitio['descripcion'];?></p>
						<p><?php echo '<a href="'.url_sugerir().'?id='.$sitio['id'].'&campo=s">'.tr("sugerir_cambio").'</a>';?></p>
						<p>
						<strong><?php echo tr("direccion"); ?>:</strong> <?php if(!empty($sitio['direccion'])) echo $sitio['direccion']; else echo '<a href="'.url_sugerir().'?id='.$sitio['id'].'&campo=d">'.tr("sugerir_direccion").'</a>';?><br/>
						<strong><?php echo tr("telefono"); ?>:</strong> <?php if(!empty($sitio['telefono'])) echo $sitio['telefono']; else echo '<a href="'.url_sugerir().'?id='.$sitio['id'].'&campo=t">'.tr("sugerir_telefono").'</a>';?><br/>
						<strong><?php echo tr("horario_b"); ?>:</strong> <?php if(!empty($sitio['horario'])) echo $sitio['horario']; else echo '<a href="'.url_sugerir().'?id='.$sitio['id'].'&campo=h">'.tr("sugerir_horario").'</a>';?><br/>
						<?php if($sitio['candado']>0) echo '<strong>'.tr("candado?").'</strong>: '.respuesta_radio_button($sitio['candado']).'</br>';?>
						<?php if($sitio['cubierto']>0) echo '<strong>'.tr("cubierto?").'</strong>: '.respuesta_radio_button($sitio['cubierto']).'</br>';?>
						<?php if(!empty($sitio['tarifa'])) echo '<strong>'.tr("tarifa").'</strong>: '.$sitio['tarifa'].'</br>';?>
						<?php if(!empty($sitio['cupos'])) echo '<strong>'.tr("cupos").'</strong>: '.$sitio['cupos'].'</br>';?>
						<strong><?php echo tr("tipo"); ?></strong>: <?php echo $tiposSitio2[$tipo]['nombre'];?><br/>
						<?php if(isset($sitio['email'])&&$sitio['email']=='colectivosiclas@gmail.com')
							echo'
							<p><a href="http://siclas.blogspot.com/"><img src="'.url().'img/siclas.png"></a></p>'; ?>
					
						<div class="row calificaciones">
							<div class="large-6 columns">
							<p><strong><?php echo tr("calificacion_promedio"); ?>:</strong></p>
								<?php 
								$calificacion=darCalificacionSitio($sitio['id']);
								$numero=darNumCalificacionesSitio($sitio['id']);
								if($numero>0){ echo '('.round($calificacion,2).') ';?>
								<div class="rateit" data-rateit-value="<?php echo $calificacion;?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
								<p><?php  if($numero<=1) echo $numero.' calificaci&oacute;n.'; else echo $numero.' calificaciones.';?></p>
								<?php 
								}
								else echo tr("sin_calificaciones");?>
							</div>
							<div class="large-6 columns">
							<p><strong><?php echo tr("tu_calificacion"); ?>:</strong></p>
								<form method="post" action="<?php echo url();?>calificar.php" id="calificar">
									<input type="range" min="0" max="5" value="0" step="0.5" name="calificacion" id="calificacion">
									<div class="rateit" data-rateit-backingfld="#calificacion"></div>
									<input type="hidden" name="id" value="<?php echo $sitio['id'];?>">
								</form>
								<script type ="text/javascript">
								     $('#calificar .rateit').bind('rated', function (e) {
								    	 $('#calificar').submit();
								     });
								</script>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns compartir">
							<p><strong><?php echo tr("compartir"); ?>:</strong>
								<?php 
								$url=url_sitio().$sitio['id'];
								echo'
								    <a href="http://api.addthis.com/oexchange/0.8/forward/facebook/offer?url='.$url.'&amp;title='.$top_titulo.'&amp;username=bitajor&amp;lng=es"><img src="'.url().'img/socialmedia/facebook.png" alt="facebook" title="facebook"></a>
								    <a href="http://api.addthis.com/oexchange/0.8/forward/twitter/offer?url='.$url.'&amp;title='.$top_titulo.'&amp;username=bitajor&amp;lng=es"><img src="'.url().'img/socialmedia/twitter.png" alt="twitter" title="twitter"></a>
								    <a href="http://api.addthis.com/oexchange/0.8/forward/googleplus/offer?url='.$url.'&amp;title='.$top_titulo.'&amp;username=bitajor&amp;lng=es"><img src="'.url().'img/socialmedia/gplus.png" alt="googleplus" title="googleplus"></a>
								    <a href="http://api.addthis.com/oexchange/0.8/forward/tumblr/offer?url='.$url.'&amp;title='.$top_titulo.'&amp;username=bitajor&amp;lng=es"><img src="'.url().'img/socialmedia/tumblr.png" alt="tumblr" title="tumblr"></a>
									<a href="http://api.addthis.com/oexchange/0.8/forward/email/offer?url='.$url.'&amp;title='.$top_titulo.'&amp;username=bitajor&amp;lng=es"><img src="'.url().'img/socialmedia/email.png" alt="email" title="email"></a>
								    ';
								?></p>
							</div>
						</div>
				</div>
										
				<div class="large-6 columns">
						<?php 
						if($tipo==tipo_ruta()){
						?>
						
							<div id="googlemaps" class="sitio" height="600"></div>
							
							<script>
							function zoomToObject(obj,map){
							    var bounds = new google.maps.LatLngBounds();
							    var points = obj.getPath().getArray();
							    for (var n = 0; n < points.length ; n++){
							        bounds.extend(points[n]);
							    }
							    map.fitBounds(bounds);
							}
							
							function dibujarSitio(mapsitio,icono){
							    var marker = new google.maps.Marker({
							    	position: new google.maps.LatLng(<?php echo $sitio['longitud'].','.$sitio['latitud'];?>),
									map: mapsitio,
									icon: icono
								});
								mapsitio.setCenter(new google.maps.LatLng(<?php echo $sitio['longitud'].','.$sitio['latitud'];?>));

								<?php 
								$puntosruta=json_decode($sitio['ruta'],true);
								if( isset($puntosruta['b']) && count($puntosruta['b'])>0 ) {

									$puntos=array();

									foreach($puntosruta['b'] as $punto){
										$puntos[]="new google.maps.LatLng(".$punto['lat'].", ".$punto['lon'].")";
									}
									
									echo'
								var puntosrutas = [
								    '.implode(",\n",$puntos).'
								];
		  							';
									
								}
								?>

								var rutasitio = new google.maps.Polyline({
									path: puntosrutas,
								    strokeColor: '#000000',
								    strokeOpacity: 1.0,
								    strokeWeight: 4
								  });
								rutasitio.setMap(mapsitio);
								zoomToObject(rutasitio,mapsitio);
							}
							</script>
						
						<?php 
						}
						else{
						?>
							
							<div id="googlemaps" class="sitio" height="600"></div>
							
							<script>
							function zoomToObject(obj,map){
							    var bounds = new google.maps.LatLngBounds();
							    var points = obj.getPath().getArray();
							    for (var n = 0; n < points.length ; n++){
							        bounds.extend(points[n]);
							    }
							    map.fitBounds(bounds);
							}
							
							function dibujarSitio(mapsitio,icono){
							    var marker = new google.maps.Marker({
							    	position: new google.maps.LatLng(<?php echo $sitio['longitud'].','.$sitio['latitud'];?>),
									map: mapsitio,
									icon: '<?php $t=$sitio['tipo'];if(isset($tiposSitio2[$t])){echo url().$tiposSitio2[$t]['img'];}else echo url().$tiposSitio2[0]['img'];?>'
								});
								mapsitio.setCenter(new google.maps.LatLng(<?php echo $sitio['longitud'].','.$sitio['latitud'];?>));
								mapsitio.setZoom(16);
							}
							</script>
						
						<?php 
						}
						?>
							<a href="<?php echo url().'#t=&s='.$sitio['id'];?>" title="Ver el sitio en el mapa" class="button"><?php echo tr("ver_en_el_mapa"); ?></a>
				</div>
			</div>
			
			<div class="row">
				<div class="large-12 columns">
				<h3><?php echo tr("comentarios"); ?></h3>
				<p><?php echo tr("puedes_comentar"); ?></p>
				</div>
			</div>
										
			<div class="row">
				<div class="large-12 columns comentariosfb">
					<div class="fb-comments" data-href="<?php echo url_sitio().''.$sitio['id'];?>" ></div>
				</div>
			</div>
			
			<div class="row">
				<div class="large-12 columns">
				    <div id="disqus_thread"></div>
				    <script type="text/javascript">
				        var disqus_shortname = 'bicimapa';
				        var disqus_identifier = 'sitio<?php echo $sitio['id'];?>';
				        (function() {
				            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
				            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
				            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
				        })();
				    </script>
				    <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
				    <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
			    </div>
			</div>
    
			<?php 

		}
					
	}
	else{
		imprimir_error(tr("no_se_encontro_lugar"));
	}
	?>
	
	</div>
	
	
<?php include_once('pie.php');?>
