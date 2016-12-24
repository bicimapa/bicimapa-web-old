<?php 
include_once('funciones.php');
$pagina='usuario.php';
$id=(int)$_GET['id'];
$usuario=darUsuario($id);


if($usuario!=null){
	if(!empty($usuario['nombre'])) $top_titulo="Perfil de ".$usuario['nombre']." en el Bicimapa";
	else $top_titulo="Perfil de usuario en el Bicimapa";
	$top_descripcion=$top_titulo.". Los aportes que ha hecho en el bicimapa.";
}



include_once('top.php');
if($usuario!=null){
	
	$calificaciones=darCalificacionesUsuario($usuario['id']);
?>

 		<div class="row">
			<div class="large-3 columns">
				<img src="<?php if(!empty($usuario['imagen'])){
					if(startsWith($usuario['imagen'],'https://graph.facebook.com/')) echo $usuario['imagen'].'?width=200&height=200';
					else echo $usuario['imagen']; 
				}
				else echo $url.'img/bicigente.png';?>">
			</div>
			<div class="large-5 columns">
				<h2><?php if(!empty($usuario['nombre'])) echo $usuario['nombre']; else echo'Biciusuario '.$usuario['id'];?></h2>
				<p>
				<strong>Bicusuario desde:</strong><?php echo date('d-m-Y',strtotime($usuario['fecha']));?><br/>
				<strong>Ciudad:</strong><br/>
				</p>
			</div>
			<div class="large-4 columns">
				
				<div class="row">
					<div class="large-8 columns"><h3>Nivel</h3></div>
					<div class="large-4 columns"><h3>0</h3></div>
				</div>

				<div class="row">
					<div class="large-8 columns"><h3>Sitios agregados</h3></div>
					<div class="large-4 columns"><h3>0</h3></div>
				</div>
				
				<div class="row">
					<div class="large-8 columns"><h3>Calificaciones</h3></div>
					<div class="large-4 columns"><h3><?php echo count($calificaciones);?></h3></div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="large-12 columns">
				<h2>L&iacute;nea del Tiempo</h2>
			</div>
			<?php 
			$eventos=array();
			
			//Calificaciones
			if($calificaciones!=null)
				foreach($calificaciones as $calificacion) 
					$eventos[]=array('fecha'=>date('d-m-Y',strtotime($calificacion['fecha'])),
							'accion'=>'Calificaci&oacute;n en el sitio '.$calificacion['sitio'].'.');
			
			
			//Registro
			$eventos[]=array('fecha'=>date('d-m-Y',strtotime($usuario['fecha'])),'accion'=>'Registro en el bicimapa.');
			?>
			<table class="large-12 columns">
				<tr>
					<th>Fecha</th>
					<th>Acci&oacute;n</th>
				</tr>
				<?php 
				foreach ($eventos as $evento){
					?>
					<tr>
						<td><?php echo $evento['fecha'];?></td>
						<td><?php echo $evento['accion'];?></td>
					</tr>
					<?php 
				}
				?>
				
			</table>
		</div>
	
<?php 	
}
else{
	imprimir_error("No se encontr&oacute; el usuario.");
}

include_once('pie.php');?>
