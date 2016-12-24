<?php 
$pagina='administrador.php';
include_once('top.php');?>

<?php include_once('autorizar.php');?>

<?php 
if(isset($_GET['accion']) && isset($_GET['id']) && $_GET['accion']=='aprobar'){
	if(aprobar($_GET['id'])) imprimir_ok('Se aprob&oacute; el sitio con id '.$_GET['id']);
	else imprimir_error('No se pudo aprobar el sitio con id '.$_GET['id']);
}
else if(isset($_GET['accion']) && isset($_GET['id']) && $_GET['accion']=='desaprobar'){
	if(desaprobar($_GET['id'])) imprimir_ok('Se desaprob&oacute; el sitio con id '.$_GET['id']);
	else imprimir_error('No se pudo desaprobar el sitio con id '.$_GET['id']);
}
else if(isset($_GET['accion']) && isset($_GET['id']) && $_GET['accion']=='borrar'){
	if(borrar($_GET['id'])) imprimir_ok('Se borr&oacute; el sitio con id '.$_GET['id']);
	else imprimir_error('No se pudo borrar el sitio con id '.$_GET['id']);
}
else if(isset($_GET['accion']) && $_GET['accion']=='salir'){
	setcookie('bicimapareyes', md5('salir'), 1);
	echo'
        <div class="row">
			<div class="large-12 columns">
				<form method="POST" action="'.url_administrador().'">
					<input type="password" name="lacontrasena"><br/>
					<input type="submit" class="button" value="Entrar">
				</form>		
			</div>
		</div>	
        ';
        exit();
}
else if(isset($_POST['accion']) && $_POST['accion']='editar'){
	
	if(
		isset($_POST['nombre']) && !empty($_POST['nombre']) &&
		isset($_POST['descripcion']) && !empty($_POST['descripcion']) &&
		isset($_POST['latlong']) && !empty($_POST['latlong'])
	){
		$parteslatlong=explode(',',$_POST['latlong']);
		if(count($parteslatlong)==2){
			$latitud=$parteslatlong[1];
			$longitud=$parteslatlong[0];
			$respuesta=editar($_POST['id'],$_POST['nombre'],$_POST['direccion'],$_POST['telefono'],$_POST['descripcion'],$latitud,$longitud,$_POST['tipo'],$_POST['quien'],$_POST['email']);
			if($respuesta) imprimir_ok('Se edit&oacute; correctamente.');
			else imprimir_error('Ocurri&oacute; un error al guardar el sitio :(');
		}
		else  imprimir_error('Las coordenadas no eran corectas :(');
	}
	else imprimir_error('Al menos debes escribir el nombre del sitio, una descripci&oacute;n y seleccionar su ubicaci&oacute;n.');
	
}

$pagina=(int)$_GET['pagina'];
if($pagina==0&&isset($_POST['pagina']))$pagina=(int)$_POST['pagina'];
?>

	<div class="row">
		<div class="large-6 columns">
			<h2>Hola Administrador!</h2>
		</div>
		<div class="large-6 columns">
			<?php 
			if($pagina>0) echo'<a href="'.url_administrador().'?pagina='.($pagina-1).'" class="button">< Anterior</a>';
			echo'<a href="'.url_administrador().'?pagina='.($pagina+1).'" class="button">Siguiente ></a>';
			?>
			<a href="<?php echo url_administrador();?>?accion=salir" class="button secondary">Cerrar Sesi&oacute;n</a>
		</div>
	</div>
	
	<div class="row">
		<div class="large-12 columns">
	<?php 
	$sitios=darSitios(10,$pagina);
	if(count($sitios)>0){
		echo '<table class="large-12 columns">';
		foreach($sitios as $sitio){
			$tipo=$sitio['tipo'];
			
			if($sitio['aprobado']<1) 
				$boton='<a href="'.url_administrador().'?accion=aprobar&id='.$sitio['id'].'" class="button success">Aprobar</a>
				<a href="'.url_administrador().'?accion=borrar&id='.$sitio['id'].'" class="button alert eliminar" title="'.$sitio['id'].'">Eliminar</a>
				<a href="#" class="editar button" href="#">Editar</a>';
			else 
				$boton='<a href="'.url_administrador().'?accion=desaprobar&id='.$sitio['id'].'" class="button">Desaprobar</a>
						<a href="'.url_administrador().'?accion=borrar&id='.$sitio['id'].'" class="button alert eliminar" title="'.$sitio['id'].'">Eliminar</a>
						<a href="#" class="editar button" href="#">Editar</a>';
			
			if(isset($sitio['quien'])&&!empty($sitio['quien'])&&isset($sitio['email'])&&!empty($sitio['email'])) $quien=$sitio['quien'].' ('.$sitio['email'].')';
			else if(isset($sitio['quien'])&&!empty($sitio['quien'])) $quien=$sitio['quien'];
			else if(isset($sitio['email'])&&!empty($sitio['email'])) $quien=$sitio['email'];
			else $quien='An&oacute;nimo';
			
			echo '
			<tr>
				<td>
					<h3>'.$sitio['id'].'. '.$sitio['nombre'].'</h3>
					<p>'.$sitio['descripcion'].'</p>
					<p>
					<strong>Direcci&oacute;n:</strong> '.$sitio['direccion'].'<br/>
					<strong>Tel&eacute;fono:</strong> '.$sitio['telefono'].'<br/>
					<strong>Tipo</strong>: '.$tiposSitio[$tipo]['nombre'].'<br/>
					<strong>Qui&eacute;n:</strong> '.$quien.'</p>
					<p>'.$boton.'</p>
					
					<div id="modal'.$sitio['id'].'" class="modal">
						<div class="modal2">
						<h3>Id '.$sitio['id'].'</h3>
						<form method="POST" action="'.url_administrador().'">
							<strong>Titulo:</strong> <input type="text" name="nombre" value="'.$sitio['nombre'].'"><br/>
							<strong>Ubicaci&oacute;n:</strong>
							<div id="googlemaps"></div>
	    					<input type="text" name="latlong" id="latlongmapa" value="'.$sitio['longitud'].','.$sitio['latitud'].'"/>
							<strong>Descripci&oacute;n:</strong> <textarea name="descripcion" rows="5" style="height:100px;">'.$sitio['descripcion'].'</textarea><br/>
							<strong>Direcci&oacute;n:</strong> <input type="text" name="direccion"  value="'.$sitio['direccion'].'"><br/>
							<strong>Tel&eacute;fono:</strong> <input type="text" name="telefono"  value="'.$sitio['telefono'].'"><br/>
							<strong>Tipo</strong>
							<select name="tipo">';
							
							foreach($tiposSitio2 as $key=>$categoria){
								if($key==$sitio['tipo']) $selected='selected="selected"';
								else $selected="";
								if($categoria['agregable']) echo'
								<option value="'.$key.'"  '.$selected.'>'.$categoria['nombre'].'</option>';
							}
									
							echo'
							</select><br/>
							<strong>Qui&eacute;n:</strong> <input type="text" name="direccion"  value="'.$sitio['quien'].'"><br/>
							<strong>Email:</strong> <input type="text" name="telefono"  value="'.$sitio['email'].'"><br/></p>
							<input type="hidden" name="id" value="'.$sitio['id'].'">
							<input type="hidden" name="accion" value="editar">
							<input type="hidden" name="pagina" value="'.$pagina.'">
							<input type="submit" value="Editar" class="button"/> <a href="#" class="button alert cancelar">Cancelar</a>
						</form>
						</div>
					</div>
							
				</td>
				<td>
					<img src="http://maps.googleapis.com/maps/api/staticmap?center='.$sitio['longitud'].','.$sitio['latitud'].'&zoom=14&size=400x300&maptype=roadmap
					&markers=color:red%7Ccolor:red%7Clabel:A%7C'.$sitio['longitud'].','.$sitio['latitud'].'&sensor=false">
			
					
				</td>
			</tr>
			';
			
			//echo'<iframe width="400" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/?ie=UTF8&amp;t=m&amp;ll='.$sitio['longitud'].','.$sitio['latitud'].'&amp;z=14&amp;output=embed&amp;saddr='.$sitio['longitud'].','.$sitio['latitud'].'"></iframe>';
		}
		echo '</table>
		';
		if($pagina>0) echo'<a href="'.url_administrador().'?pagina='.($pagina-1).'" class="button">< Anterior</a>';
		echo'<a href="'.url_administrador().'?pagina='.($pagina+1).'" class="button">Siguiente ></a>';
					
	}
	else{
		imprimir_error("No hay más lugares.");
	}
	?>
	</div>
	</div>
	
	
<?php include_once('pie.php');?>
