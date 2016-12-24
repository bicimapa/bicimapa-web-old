<?php 
$pagina='buscar.php';
include_once('top.php');


$id=(int)$_GET['id'];

$link=Conectarse();
$nombrebuscar=sanitize($_GET['nombre'],$link);
$quienbuscar=sanitize($_GET['quien'],$link);
mysql_close($link);

$pagina=(int)$_GET['pagina'];
if($pagina==0&&isset($_POST['pagina']))$pagina=(int)$_POST['pagina'];



function url_pagina_siguiente(){
	
	global $pagina,$id,$nombrebuscar,$quienbuscar;
	
	$param=array();

	$param[]='pagina='.($pagina+1);
	if($id>0)$param[]='id='.$id;
	if($nombrebuscar!=null)$param[]='nombre='.$nombrebuscar;
	if($quienbuscar!=null)$param[]='quien='.$quienbuscar;

	return url_buscar().'?'.implode('&',$param);
}

function url_pagina_anterior(){
	
	global $pagina,$id,$nombrebuscar,$quienbuscar;

	$param=array();

	$param[]='pagina='.($pagina-1);
	if($id>0)$param[]='id='.$id;
	if($nombrebuscar!=null)$param[]='nombre='.$nombrebuscar;
	if($quienbuscar!=null)$param[]='quien='.$quienbuscar;

	return url_buscar().'?'.implode('&',$param);
}



$aprobado=1;
if(!empty($nombrebuscar)) $sitios=darSitios(resultados_por_pagina(),$pagina,$id,$nombrebuscar,$quienbuscar,$aprobado);
else $sitios=array();
?>

	<div class="row">
		<div class="large-6 columns">
					<form method="get">
					<label>Nombre:</label> <input type="text" name="nombre" size="4" <?php if($nombrebuscar!=null)echo 'value="'.$nombrebuscar.'"'?>>
					<input type="submit" value="Buscar" class="button">
					</form>
		</div>
		<div class="large-6 columns text-right">
			<h2>P&aacute;gina <?php echo ($pagina+1);?></h2>
			<?php 
			if($pagina>0) echo'<a href="'.url_pagina_anterior().'" class="button">< Anterior</a>';
			if(count($sitios)==resultados_por_pagina()) echo'<a href="'.url_pagina_siguiente().'" class="button">Siguiente ></a>';
			?>
		</div>
	</div>
	
	<div class="row">
		<div class="large-12 columns">
	<?php 
	
	if(count($sitios)>0){
		echo '<table class="large-12 columns">';
		foreach($sitios as $sitio){
			$tipo=$sitio['tipo'];
			$boton='<a href="'.url_sitio().$sitio['id'].'" class="button">Comentar y Calificar</a>';
			
			if(isset($sitio['quien'])&&!empty($sitio['quien'])) $quien=$sitio['quien'];
			else $quien='An&oacute;nimo';
			
			?>
			<tr>
				<td>
					<div class="row">
						<div class="large-6 columns">
							<?php echo'<h3><a href="'.url_sitio().$sitio['id'].'" title="'.limpiar_texto( $sitio['nombre'] ).'">'.$sitio['nombre'].'</a></h3>
							<p>'.$sitio['descripcion'].'</p>
							<p>';?>
							
							<?php if(!empty($sitio['direccion'])) echo'<strong>Direcci&oacute;n:</strong> '.$sitio['direccion'].'<br/>';?>
							<?php if(!empty($sitio['telefono'])) echo'<strong>Tel&eacute;fono:</strong> '.$sitio['telefono'].'<br/>';?>
							
							<?php echo'<strong>Tipo</strong>: '.$tiposSitio2[$tipo]['nombre'].'<br/>
							<strong>Enviado por:</strong> '.$quien.'<br/>
							<strong>Calificaci&oacute;n promedio:</strong>';
			
								$calificacion=darCalificacionSitio($sitio['id']);
								$numero=darNumCalificacionesSitio($sitio['id']);
								if($numero>0){ echo ''.round($calificacion,2).' ';?>
								<div class="rateit" data-rateit-value="<?php echo $calificacion;?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
								<p><?php  if($numero<=1) echo $numero.' calificaci&oacute;n.'; else echo $numero.' calificaciones.';?></p>
								<?php 
								}
								else echo ' Sin calificaciones';?>
		
							<?php echo'
							</p>
							<p>'.$boton.'</p>							
						</div>
						<div class="large-6 columns">
							<a href="'.url_sitio().$sitio['id'].'" title="'.limpiar_texto( $sitio['nombre'] ).'">
								<img src="http://maps.googleapis.com/maps/api/staticmap?center='.$sitio['longitud'].','.$sitio['latitud'].'&zoom=15&size=400x300&maptype=roadmap
								&markers=color:red%7Ccolor:red%7Clabel:A%7C'.$sitio['longitud'].','.$sitio['latitud'].'&sensor=false" class="maparesultadobusqueda">';?>
							</a>
						</div>
					</div>
				</td>
			</tr>
			<?php 
			
			//echo'<iframe width="400" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/?ie=UTF8&amp;t=m&amp;ll='.$sitio['longitud'].','.$sitio['latitud'].'&amp;z=14&amp;output=embed&amp;saddr='.$sitio['longitud'].','.$sitio['latitud'].'"></iframe>';
		}
		echo '</table>
		';
		if($pagina>0) echo'<a href="'.url_pagina_anterior().'" class="button">< Anterior</a>';
		if(count($sitios)==resultados_por_pagina()) echo'<a href="'.url_pagina_siguiente().'" class="button">Siguiente ></a>';
					
	}
	else{
		imprimir_error("No hay m&aacute;s lugares.");
	}
	?>
	</div>
	</div>
	
	
<?php include_once('pie.php');?>
