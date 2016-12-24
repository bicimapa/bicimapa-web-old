<?php 
$pagina='biciplanes_sugerir.php';
$top_titulo="Sugerir Biciplanes";
$datepicker=true;
include_once('top.php');


if(
		isset($_POST['nombre']) && !empty($_POST['nombre']) &&
		isset($_POST['correo']) && !empty($_POST['correo']) &&
		isset($_POST['nombreevento']) && !empty($_POST['nombreevento']) 
){
	
	$nombre=$_POST['nombre'];
	$correo=$_POST['correo'];
	$nombreevento=$_POST['nombreevento'];
	$colectivo=$_POST['colectivo'];
	$fecha=$_POST['fecha'];
	$horainicio=$_POST['horainicio'];
	$fechafinal=$_POST['fechafinal'];
	$horafinal=$_POST['horafinal'];
	$descripcion=$_POST['descripcion'];
	$ciudad=$_POST['ciudad'];
	$lugar=$_POST['lugar'];
	$web=$_POST['web'];
	$ip=$_SERVER['REMOTE_ADDR'];
	$useragent=$_SERVER['HTTP_USER_AGENT'];
	
	agregarEvento($nombre,$correo,$nombreevento,$colectivo,$fecha,$horainicio,$fechafinal,$horafinal,$descripcion,$ciudad,$lugar,$web,$ip,$useragent);

	$msg = "Nuevo evento sugerido desde el formulario del bicimapa\n";
	$msg .= "---------------------------------------------\n";
	$msg .= "Nombre: ".$nombre."\n";
	$msg .= "Correo: ".$correo."\n";
	$msg .= "Nombre del evento: ".$nombreevento."\n";
	$msg .= "Colectivo que organiza: ".$colectivo."\n";
	$msg .= "Fecha de inicio: ".$fecha."\n";
	$msg .= "Hora de inicio: ".$horainicio."\n";
	$msg .= "Fecha final: ".$fechafinal."\n";
	$msg .= "Hora final: ".$horafinal."\n";
	$msg .= "Descripcion: ".$descripcion."\n";
	$msg .= "Ciudad: ".$ciudad."\n";
	$msg .= "Lugar: ".$lugar."\n";
	$msg .= "Web: ".$web."\n";
	$msg .= "---------------------------------------------\n";
	$msg .= "TIME: ".date(DATE_RFC822)."\n";
	$msg .= "IP: ".$ip."\n";
	$msg .= "USER AGENT: ".$useragent."\n";
	
	$headers = 'From: ' . $correo . "\r\n" .
			'Reply-To: ' . $correo . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
	
	$admin=email_admin().", lagranrodada@gmail.com";
	
	$mail_sent = @mail($admin,'[Bicimapa] Nuevo evento sugerido',$msg,$headers);
	
	if($mail_sent) imprimir_ok('Gracias por tu sugerencia. Nos estaremos comunicando muy pronto.');
	else imprimir_error('Ocurri&oacute; un error. :( &#191;Pordr&iacute;as intentar enviar el evento de nuevo?');

	
} else {
	
	if(
			(isset($_POST['nombre']) && !empty($_POST['nombre'])) ||
			(isset($_POST['correo']) && !empty($_POST['correo'])) ||
			(isset($_POST['nombreevento']) && !empty($_POST['nombreevento']))
	)
		imprimir_error('Debes llenar el nombre del evento, tu nombre y tu correo.');
	
}
?>

		<div class="row">
			<div class="large-12 columns">
				<h3 class="seccion">Sugerir un biciplan</h3>
			</div>
		</div>
		


		<form action="<?php echo url();?>biciplanes_sugerir.php" method="post">
			<div class="row">
			      <div class="large-6 columns">
				        <label>Tu Nombre*</label>
				        <input type="text" name="nombre">
			      </div>
				  <div class="large-6 columns">
				        <label>Tu correo electr&oacute;nico*</label>
				        <input type="text" name="correo">
			      </div>
		    </div>
			<div class="row">
			      <div class="large-6 columns">
				        <label>Nombre del evento</label>
				        <input type="text" name="nombreevento">
			      </div>
				  <div class="large-6 columns">
				        <label>Colectivo que organiza</label>
				        <input type="text" name="colectivo">
			      </div>
		    </div>
			<div class="row">
			      <div class="large-3 columns">
				        <label>Fecha de inicio</label>
				        <input type="text" name="fecha" class="datepickers">
			      </div>
				  <div class="large-3 columns">
				        <label>Hora de inicio</label>
				        <input type="text" name="horainicio">
			      </div>
				  <div class="large-3 columns">
				        <label>Fecha final</label>
				        <input type="text" name="fechafinal" class="datepickers">
			      </div>
				  <div class="large-3 columns">
				        <label>Hora final</label>
				        <input type="text" name="horafinal">
			      </div>
		    </div>
		    <div class="row">
			      <div class="large-12 columns">
				        <label>Descripci&oacute;n del evento</label>
				        <textarea name="descripcion"></textarea>
			      </div>
		    </div>
			<div class="row">
			      <div class="large-6 columns">
				        <label>Ciudad</label>
				        <input type="text" name="ciudad">
			      </div>
				  <div class="large-6 columns">
				        <label>Lugar del evento con direcci&oacute;n</label>
				        <input type="text" name="lugar">
			      </div>
		    </div>
			<div class="row">
			      <div class="large-12 columns">
				        <label>P&aacute;gina web del evento o donde se pueda encontrar m&aacute;s informaci&oacute;n</label>
				        <input type="text" name="web">
			      </div>
		    </div>
		    <div class="row">
			      <div class="large-12 columns">
				        <input type="Submit" class="button" value="Enviar sugerencia">
			      </div>
		    </div>
	    </form>
  
<?php include_once('pie.php');?>