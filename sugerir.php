<?php 
$pagina='sugerir.php';
$top_titulo="Sugerir";
include_once('top.php');


if(
		isset($_POST['nombre']) && !empty($_POST['nombre']) &&
		isset($_POST['correo']) && !empty($_POST['correo']) &&
		isset($_POST['mensaje']) && !empty($_POST['mensaje']) 
){
	

	$msg = $_POST['nombre']." (".$_POST['correo'].") dijo:\n";
	$msg .= "----------------------------------------------\n";
	$msg .=$_POST['mensaje']."\n";
	$msg .= "----------------------------------------------\n";
	$msg .= "TIME: ".date(DATE_RFC822)."\n";
	$msg .= "IP: ".$_SERVER['REMOTE_ADDR']."\n";
	$msg .= "USER AGENT: ".$_SERVER['HTTP_USER_AGENT']."\n";
	
	$headers = 'From: ' . $_POST['correo'] . "\r\n" .
			'Reply-To: ' . $_POST['correo'] . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
	
	$admin=email_admin();
	
	$mail_sent = @mail($admin,'[Bicimapa] Nueva sugerencia',$msg,$headers);
	
	if($mail_sent) imprimir_ok('Gracias por tu sugerencia. Estaremos mir&aacute;ndola lo m&aacute;s pronto posible');
	else imprimir_error('Ocurri&oacute; un error. :( &#191;Pordr&iacute;as intentar enviar la sugerencia de nuevo?');

	
} else {
	
	if(
			(isset($_POST['nombre']) && !empty($_POST['nombre'])) ||
			(isset($_POST['correo']) && !empty($_POST['correo'])) ||
			(isset($_POST['mensaje']) && !empty($_POST['mensaje']))
	)
		imprimir_error('Debes llenar el nombre, correo y mensaje.');
	
}
?>

		<div class="row">
			<div class="large-12 columns">
				<h3 class="seccion">Sugerir</h3>
			</div>
		</div>
		


		<form action="<?php echo url();?>sugerir.php" method="post">
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
			      <div class="large-12 columns">
				        <label>Mensaje</label>
				        <textarea name="mensaje" id="mensaje"><?php 
				        if( isset($_GET['id']) && $_GET['id']>0 ){
							$sitios=darSitio($_GET['id']);
							if(count($sitios)>0){
								if( isset($_GET['campo']) && $_GET['campo']=='t' ) echo" Sugiero el siguiente tel&eacute;fono";
								if( isset($_GET['campo']) && $_GET['campo']=='d' ) echo" Sugiero la siguiente direcci&oacute;n";
								if( isset($_GET['campo']) && $_GET['campo']=='h' ) echo" Sugiero el siguiente horario";
								if( isset($_GET['campo']) && $_GET['campo']=='s' ) echo" Sugiero el siguiente cambio ";
								
								echo " para el sitio \"".$sitios[0]['nombre']."\" (id ".((int)$_GET['id'])."): \n";
							}
							else{
							}
						}
						if( isset($_GET['evento']) && $_GET['evento']=='nuevo' ){
							echo "Hola, \nMe gustar&iacute;a que agregaran el siguiente evento al calendario de biciplanes:\n";
						}
				        ?></textarea>
			      </div>
		    </div>
		    <div class="row">
			      <div class="large-12 columns">
				        <input type="Submit" class="button" value="Enviar sugerencia">
			      </div>
		    </div>
	    </form>
  
<?php include_once('pie.php');?>
