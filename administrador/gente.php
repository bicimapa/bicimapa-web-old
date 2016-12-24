<?php 
$pagina='gente.php';
include_once('autorizar.php');
include_once('top.php');






if(isset($_GET['accion']) && isset($_GET['id']) && $_GET['accion']=='borrar'){
	if(borrar_contacto($_GET['id'])) imprimir_ok('Se borr&oacute; el contacto con id '.$_GET['id']);
	else imprimir_error('No se pudo borrar el contacto con id '.$_GET['id']);
	$_GET['id']=0;
}
else if(isset($_POST['accion']) && $_POST['accion']=='editar'){

	if(
			isset($_POST['nombre']) && !empty($_POST['nombre'])
	){
			$id=(int)$_POST['id'];
			$respuesta=editar_contacto($id,$_POST['nombre'],$_POST['ciudad'],$_POST['tipo'],$_POST['facebook'],$_POST['twitter'],$_POST['web'],$_POST['imagen'],$_POST['descripcion']);
			if($respuesta) imprimir_ok('Se edit&oacute; correctamente el contacto con id '.$id.'.');
			else imprimir_error('Ocurri&oacute; un error al guardar el contacto :(');
	}
	else imprimir_error('Al menos debes escribir el nombre del contacto.');

}
else if(isset($_POST['accion']) && $_POST['accion']=='agregar'){

	if(
			isset($_POST['nombre']) && !empty($_POST['nombre'])
	){
		$respuesta=agregar_contacto($_POST['nombre'],$_POST['ciudad'],$_POST['tipo'],$_POST['facebook'],$_POST['twitter'],$_POST['web'],$_POST['imagen'],$_POST['descripcion']);
		if($respuesta) imprimir_ok('Se agreg&oacute; correctamente el contacto.');
		else imprimir_error('Ocurri&oacute; un error al guardar el contacto :(');
	}
	else imprimir_error('Al menos debes escribir el nombre del contacto.');

}



?>

		<div class="row">
			<div class="large-6 columns">
				<h2>Directorio</h2>
			</div>
			<div class="large-6 columns">
				<a href="#" class="agregar button">Agregar Contacto</a>
			</div>
		</div>
		
		<div id="modalagregar" class="modal">
						<div class="modal2">
						<h2>Agregar Contacto</h2>
						<form method="POST" action="<?php echo url_administrador_bicigente();?>">
							<strong>Nombre:</strong> <input type="text" name="nombre" value=""><br/>
							<strong>Ciudad:</strong> <input type="text" name="ciudad" value=""><br/>
							<strong>Categoria:</strong> <input type="text" name="tipo" value=""><br/>
							<strong>Facebook:</strong> <input type="text" name="facebook" value=""><br/>
							<strong>Twitter:</strong> <input type="text" name="twitter" value=""><br/>
							<strong>Web:</strong> <input type="text" name="web" value=""><br/>
							<strong>Imagen:</strong> <input type="text" name="imagen" value=""><br/>
							<strong>Descripci&oacute;n:</strong> <textarea name="descripcion"></textarea><br/>
							<input type="hidden" name="accion" value="agregar">
							<input type="submit" value="Agregar" class="button"/> <a href="#" class="button alert cancelar">Cancelar</a>
						</form>
						</div>
		</div>
		
		<?php 
		$gente=darBicigente();
		
		$tipo="";
		$ciudad="";
		$genteciudad=array();
		
		foreach($gente as $i){
			$eltipo=$i['tipo'];
			if($tipo!=$eltipo){
				$tipo=$eltipo;
				?>
					<div class="bicigente_bloque_categoria">
						<?php foreach($genteciudad as $gc) echo $gc;?>
					</div>
					
					<div class="row">
						<div class="large-12 columns bicigente_categoria">
							<a href="#"><h3><?php echo $tipo;?></h3></a>
						</div>
					</div>	
				<?php 
				
				$genteciudad=array();
				$ciudad="";
			}
			
			$laciudad=$i['ciudad'];
			if($ciudad!=$laciudad){
				$ciudad=$laciudad;
				$genteciudad[]='
					<div class="row">
						<div class="large-12 columns bicigente_ciudad">
							<h3>'.$ciudad.'</h3>
						</div>
					</div>';
			}
			
			$gentei="";
			
			if(!empty($i['imagen'])) $pic=$i['imagen'];
			else{
				if(!empty($i['facebook'])) $pic="https://graph.facebook.com/".darFacebookId($i['facebook'])."/picture";
				else $pic=url()."img/bicigente.png";
			}
			
			$gentei.='
			<div class="row  bicigente_nombre">
				<div class="large-5 columns">
					<h3><img src="'.$pic.'"/> ('.$i['id'].') '.$i['nombre'].'</h3>
				</div>
				<div class="large-4 columns">';
			
			if(!empty($i['facebook'])){$gentei.='<a href="'.$i['facebook'].'"><img src="'.url().'img/facebook.png"> Facebook</a> '; }
			if(!empty($i['twitter'])){$gentei.='<a href="'.$i['twitter'].'"><img src="'.url().'img/twitter.png"> Twitter</a> '; }
			if(!empty($i['web'])){
				/*
				$laweb = str_replace("http://", "", $i['web']);
				$laweb = str_replace("https://", "", $laweb);
				$laweb = str_replace("www.", "", $laweb);
				if(strlen($laweb)>50) 
				*/
				$laweb="Web";
				$gentei.='<a href="'.$i['web'].'"><img src="'. url().'img/enlace.png"> '.$laweb.'</a> ';
			}
			
			$gentei.='
				</div>
				
				<div class="large-3 columns">
					<a href="#" class="editar button">Editar</a>
					<a href="'.url_administrador_bicigente().'?accion=borrar&id='.$i['id'].'" title="'.$i['id'].'" class="eliminar button alert">Borrar</a>
				</div>
				
				<div class="large-12 columns">
					<p>'.$i['descripcion'].'</p>
				</div>
							
				<div id="modal'.$i['id'].'" class="modal">
						<div class="modal2">
						<h2>'.$i['nombre'].'</h2>
						<form method="POST" action="'.url_administrador_bicigente().'">
							<strong>Nombre:</strong> <input type="text" name="nombre" value="'.$i['nombre'].'"><br/>
							<strong>Ciudad:</strong> <input type="text" name="ciudad" value="'.$i['ciudad'].'"><br/>
							<strong>Categoria:</strong> <input type="text" name="tipo" value="'.$i['tipo'].'"><br/>
							<strong>Facebook:</strong> <input type="text" name="facebook" value="'.$i['facebook'].'"><br/>
							<strong>Twitter:</strong> <input type="text" name="twitter" value="'.$i['twitter'].'"><br/>
							<strong>Web:</strong> <input type="text" name="web" value="'.$i['web'].'"><br/>
							<strong>Imagen:</strong> <input type="text" name="imagen" value="'.$i['imagen'].'"><br/>
							<strong>Descripci&oacute;n:</strong> <textarea name="descripcion">'.$i['descripcion'].'</textarea><br/>
							<input type="hidden" name="id" value="'.$i['id'].'">
							<input type="hidden" name="accion" value="editar">
							<input type="submit" value="Editar" class="button"/> <a href="#" class="button alert cancelar">Cancelar</a>
						</form>
						</div>
				</div>
			</div>
						
			';
			/*
			$gentei.='
				</div>
				<div class="large-12 columns">
					<p><strong>'.$i['ciudad'].'</strong> - Descripcion</p>
				</div>
			</div>
			
			';
			*/
			$genteciudad[]=$gentei;
		}
		?>

		<div class="bicigente_bloque_categoria">
			<?php foreach($genteciudad as $gc) echo $gc;?>
		</div>
  
<?php include_once('pie.php');?>
