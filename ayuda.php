<?php 
$pagina='ayuda.php';
$top_titulo="Ayuda";
include_once('top.php');?>
		
		<div class="row">
			<div class="large-12 columns">
				<h3 id="ayuda" class="seccion">Ayuda</h3>
			</div>
		</div>
		
		<div class="row">
			<div class="large-12 columns">
				<h4>&#191;C&oacute;mo busco un sitio?</h4>
				<p>Puedes buscar sitios cerca a tu ubicaci&oacute;n nevagenado por el mapa. Si quieres buscar por el nombre o descripci&oacute;n puede hacerlo desde el formulario de b&uacute;squeda en la barra de navegaci&oacute;n de la parte superior.</p>
				<h4>&#191;C&oacute;mo sugiero un sitio?</h4>
				<p>Para sugerir un nuevo sitio al bicimapa se debe ir la secci&oacute;n "<a href="<?php echo url_agregar();?>" title="Agregar sitio">Agregar sitio</a>" disponible en la barra de navegaci&oacute;n de la parte superior. All&iacute; se le pedir&aacute;n los datos del sitio y opcionalmente unos datos de identidad para notificarle del estado del sitio que sugiera. Cuando env&iacute;e la informaci&oacute;n uno de nuestros administradores la revisar&aacute; y si cumple con los requisitos de calidad ser&aacute; publicado en el bicimapa,</p>
				<h4>&#191;Porqu&eacute; no se ha publicado mi sugerencia?</h4>
				<p>Ponemos todo nuestro esfuerzo para revisar los sitios que nos sugieren. A veces el tiempo no nos alcanza para hacerlo r&aacute;pidamente. Si quieres presionarnos un poco puede hacerlo en el <a href="<?php echo url().'sugerir.php';?>" title="Sugerencias">formulario de sugerencias</a>.</p>
			</div>
		</div>
		
  
<?php include_once('pie.php');?>