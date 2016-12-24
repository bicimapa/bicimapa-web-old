<?php 
include_once('../funciones.php');
$pagina='micuenta.php';

$id=(int)$_GET['id'];
$usuario=darUsuario($id);


if($usuario!=null){
	if(!empty($usuario['nombre'])) $top_titulo="Perfil de ".$usuario['nombre']." en el Bicimapa";
	else $top_titulo="Perfil de usuario en el Bicimapa";
	$top_descripcion=$top_titulo.". Los sitios que ha agregado y las calificaciones que ha hecho.";
}



include_once('../top.php');
if($usuario!=null){
	
	$calificaciones=darCalificacionesUsuario($usuario['id']);
?>

		<div class="row">
			<div class="large-12 columns">
				<h3>Im&aacute;genes</h3>
			</div>
		</div>
		
 		<div class="row">
			<div class="large-3 columns">
				<h4>Foto de perfil</h4>
				<img src="<?php if(!empty($usuario['imagen'])){
					if(startsWith($usuario['imagen'],'https://graph.facebook.com/')) echo $usuario['imagen'].'?width=200&height=200';
					else echo $usuario['imagen']; 
				}
				else echo $url.'img/bicigente.png';?>">
			</div>
			<div class="large-3 columns">
				<a href="#" class="button">Cambiar la foto</a>
			</div>
			<div class="large-3 columns">
				<h4>Encabezado</h4>
				<img src="">
			</div>
			<div class="large-3 columns">
				<a href="#" class="button">Cambiar imagen</a>
			</div>
		</div>
		
		<div class="row">
			<div class="large-12 columns">
				<h3>Informaci&oacute;n</h3>
			</div>
		</div>
		
		<div class="row">
			<div class="large-6 columns">
				<label>Nombre</label>
				<input type="text" name="nombre" value="">
			</div>
			<div class="large-6 columns">
				<label>Correo Electronico</label>
				<input type="text" name="ciudad" value="">
			</div>
		</div>
		
		<div class="row">
			<div class="large-6 columns">
				<label>Bio</label>
				<textarea name="nombre" ></textarea>
			</div>
			<div class="large-6 columns">
				<label>Ciudad</label>
				<input type="text" name="ciudad" value="">
			</div>
		</div>
		
		<div class="row">
			<div class="large-12 columns">
				<h3>Privacidad</h3>
			</div>
		</div>
		
		<div class="row">
			<div class="large-6 columns">
				<label for="mostrar_actividad"><input type="checkbox" name="mostrar_actividad"> Publicar actividad en el Bicimapa</label>
			</div>
			<div class="large-6 columns">
				<p>Si la opci&oacute;n est&aacute; marcada se mostrar&aacute; tu actividad en el bicimapa: calificaciones, sugerencias, etc.</p>
			</div>
		</div>
		
		<div class="row">
			<div class="large-6 columns">
				<label for="autorizacion_correo"><input type="checkbox" name="autorizacion_correo"> Recibir correso del Bicimapa y/o sus asociados</label>
			</div>
			<div class="large-6 columns">
				<p>Si la opci&oacute;n est&aacute; marcada aceptas que te enviemos correos sobre actualizaciones o promociones.</p>
			</div>
		</div>


<?php 	
}
else{
	imprimir_error("No se encontr&oacute; el usuario.");
}

include_once('../pie.php');?>
