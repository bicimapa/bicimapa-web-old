<?php 
$pagina='administrador.php';
include_once('autorizar.php');

if(isset($_GET['accion']) && $_GET['accion']=='salir'){
	session_destroy();
	include_once('../top.php');
	echo'
        <div class="row">
			<div class="large-12 columns">
				<h2>Adi&oacute;s. Vuelve pronto!.</h2>
				<p><a href="'.url_administrador().'">Regresar</a></p>
			</div>
		</div>
        ';
	include_once('../pie.php');
	exit();
}

include_once('top.php');
?>

<?php 
if(isset($_GET['accion']) && isset($_GET['id']) && $_GET['accion']=='aprobar'){
	if(aprobar($_GET['id'])) imprimir_ok('Se aprob&oacute; el sitio con id '.$_GET['id']);
	else imprimir_error('No se pudo aprobar el sitio con id '.$_GET['id']);
	$_GET['id']=0;
}
else if(isset($_GET['accion']) && isset($_GET['id']) && $_GET['accion']=='desaprobar'){
	if(desaprobar($_GET['id'])) imprimir_ok('Se desaprob&oacute; el sitio con id '.$_GET['id']);
	else imprimir_error('No se pudo desaprobar el sitio con id '.$_GET['id']);
	$_GET['id']=0;
}
else if(isset($_GET['accion']) && isset($_GET['id']) && $_GET['accion']=='borrar'){
	if(borrar($_GET['id'])) imprimir_ok('Se borr&oacute; el sitio con id '.$_GET['id']);
	else imprimir_error('No se pudo borrar el sitio con id '.$_GET['id']);
	$_GET['id']=0;
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
			$id=(int)$_POST['id'];
			$respuesta=editar($id,$_POST['nombre'],$_POST['direccion'],$_POST['telefono'],$_POST['horario'],$_POST['descripcion'],$latitud,$longitud,$_POST['tipo'],$_POST['quien'],$_POST['email'],$_POST['candado'],$_POST['cubierto'],$_POST['tarifa'],$_POST['cupos'],$_POST['fechainicio'],$_POST['fechafin'] );
			if($respuesta) imprimir_ok('Se edit&oacute; correctamente el sitio con id '.$id.'.');
			else imprimir_error('Ocurri&oacute; un error al guardar el sitio :(');
		}
		else  imprimir_error('Las coordenadas no eran corectas :(');
	}
	else imprimir_error('Al menos debes escribir el nombre del sitio, una descripci&oacute;n y seleccionar su ubicaci&oacute;n.');
	
}



$id=(int)$_GET['id'];
if(isset($_GET['aprobados']))$aprobadosbuscar=(int)$_GET['aprobados'];
else $aprobadosbuscar=-1;

$link=Conectarse();
$nombrebuscar=sanitize($_GET['nombre'],$link);
$quienbuscar=sanitize($_GET['quien'],$link);
$aprobadosbuscar=sanitize($aprobadosbuscar,$link);
mysql_close($link);

$pagina=(int)$_GET['pagina'];
if(isset($_POST['pagina']))$pagina=(int)$_POST['pagina'];



function url_pagina_siguiente(){
	
	global $pagina,$id,$nombrebuscar,$quienbuscar,$aprobadosbuscar;
	
	$param=array();

	$param[]='pagina='.($pagina+1);
	if($id>0)$param[]='id='.$id;
	if($nombrebuscar!=null)$param[]='nombre='.$nombrebuscar;
	if($quienbuscar!=null)$param[]='quien='.$quienbuscar;
	if($aprobadosbuscar>=0)$param[]='aprobados='.$aprobadosbuscar;

	return url_administrador_sitios().'?'.implode('&',$param);
}

function url_pagina_anterior(){
	
	global $pagina,$id,$nombrebuscar,$quienbuscar,$aprobadosbuscar;

	$param=array();

	$param[]='pagina='.($pagina-1);
	if($id>0)$param[]='id='.$id;
	if($nombrebuscar!=null)$param[]='nombre='.$nombrebuscar;
	if($quienbuscar!=null)$param[]='quien='.$quienbuscar;
	if($aprobadosbuscar>=0)$param[]='aprobados='.$aprobadosbuscar;

	return url_administrador_sitios().'?'.implode('&',$param);
}





$sitios=darSitios(resultados_por_pagina(),$pagina,$id,$nombrebuscar,$quienbuscar,$aprobadosbuscar);
?>

	<div class="row">
		<div class="large-5 columns">
			<h2>Hola Administrador!</h2>
		</div>
		<div class="large-7 columns text-right">
			<?php 
			if($pagina>0) echo'<a href="'.url_pagina_anterior().'" class="button">< Anterior</a>';
			if(count($sitios)==resultados_por_pagina()) echo'<a href="'.url_pagina_siguiente().'" class="button">Siguiente ></a>';
			?>
			<a href="#" class="button" id="buscaradmin"><img src="<?php echo url().'img/searchblanco.png';?>"/></a>
		</div>
	</div>
	
	<div class="row">
		<div class="large-12 columns">
			<div class="row buscaradmin">
				
				<div class="large-3 columns">
					<form method="get">
					<label>Id:</label> <input type="text" name="id" size="4" <?php if($id>0)echo 'value="'.$id.'"'?>>
				</div>
				<div class="large-3 columns">
					<label>Nombre:</label> <input type="text" name="nombre" size="4" <?php if($nombrebuscar!=null)echo 'value="'.$nombrebuscar.'"'?>>
				</div>
				<div class="large-3 columns">
					<label>Qui&eacute;n:</label> <input type="text" name="quien" size="4" <?php if($quienbuscar!=null)echo 'value="'.$quienbuscar.'"'?>>
				</div>
				<div class="large-3 columns">
					<label>Estado:</label>
					<select name="aprobados">
						<option value="-1" <?php if($aprobadosbuscar==-1)echo 'selected';?>>Cualquiera</option>
						<option value="1" <?php if($aprobadosbuscar==1)echo 'selected';?>>Aprobados</option>
						<option value="0" <?php if($aprobadosbuscar==0)echo 'selected';?>>No Aprobados</option>
					</select>
					<input type="submit" value="Buscar" class="button">
					</form>
				</div>
				
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="large-12 columns">
	<?php 
	$param=array();
	if($pagina>0)$param[]='pagina='.($pagina+1);
	if($id>0)$param[]='id='.$id;
	if($nombrebuscar!=null)$param[]='nombre='.$nombrebuscar;
	if($quienbuscar!=null)$param[]='quien='.$quienbuscar;
	if($aprobadosbuscar!=null)$param[]='aprobados='.$aprobadosbuscar;
	$linkpagina='&'.implode('&',$param);
	
	if(count($sitios)>0){
		echo '<table class="large-12 columns">';
		foreach($sitios as $sitio){
			$tipo=$sitio['tipo'];
			
			if($sitio['aprobado']<1) 
				$boton='<a href="'.url_administrador_sitios().'?accion=aprobar&id='.$sitio['id'].$linkpagina.'" class="button success">Aprobar</a>
				<a href="'.url_administrador_sitios().'?accion=borrar&id='.$sitio['id'].$linkpagina.'" class="button alert eliminar" title="'.$sitio['id'].'">Eliminar</a>
				<a href="#" class="editar button" href="#">Editar</a>';
			else 
				$boton='<a href="'.url_administrador_sitios().'?accion=desaprobar&id='.$sitio['id'].$linkpagina.'" class="button">Desaprobar</a>
						<a href="'.url_administrador_sitios().'?accion=borrar&id='.$sitio['id'].$linkpagina.'" class="button alert eliminar" title="'.$sitio['id'].'">Eliminar</a>
						<input type="button" class="editar button" value="Editar"/>';
			
			if(isset($sitio['quien'])&&!empty($sitio['quien'])&&isset($sitio['email'])&&!empty($sitio['email'])) $quien=$sitio['quien'].' ('.$sitio['email'].')';
			else if(isset($sitio['quien'])&&!empty($sitio['quien'])) $quien=$sitio['quien'];
			else if(isset($sitio['email'])&&!empty($sitio['email'])) $quien=$sitio['email'];
			else $quien='An&oacute;nimo';
			
			//Si es parqueadero
			if($tipo==tipo_parqueadero()) $parqueadero='
					<strong>Candado:</strong> '.respuesta_radio_button($sitio['candado']).'<br/>
					<strong>Cubierto:</strong> '.respuesta_radio_button($sitio['cubierto']).'<br/>
					<strong>Tarifa:</strong> '.$sitio['tarifa'].'<br/>
					<strong>Cupos:</strong> '.$sitio['cupos'].'<br/>';
			else $parqueadero="";
			
			//Incluir sitios cercanos
			$sitioscercanos="";
			$markersitioscercanos=array();
			$scercanos=darSitiosCercanos(10,$sitio['latitud'],$sitio['longitud']);
			foreach ($scercanos as $scercano){
				if($scercano['id']!=$sitio['id']){
					
					$tiposc=$scercano['tipo'];
					
					$aprobadosc="";
					if($scercano['aprobado']<1)$aprobadosc='style="text-decoration:line-through;"';
					
					$sitioscercanos.='
						<a href="'.url_administrador_sitios().'?id='.$scercano['id'].'&nombre=&quien=&aprobados=-1#" title="Sitio '.$scercano['id'].($scercano['aprobado']>0?"":" No aprobado").'" '.$aprobadosc.'>
							<img src="'.url().$tiposSitio2[$tiposc]['img'].'" title="'.$tiposSitio2[$tiposc]['nombre'].'" alt="'.$tiposSitio2[$tiposc]['nombre'].'" width="19" height="22"/> '.$scercano['nombre'].'
						</a>';
					
					$markersitioscercanos[]=$scercano['longitud'].','.$scercano['latitud'];
				}
			}
			
			//Imprimir el sitio
			
			echo '
			<tr>
				<td>
					<h3><a href="'.url_sitio().$sitio['id'].'">'.$sitio['id'].'. '.$sitio['nombre'].'</a> <a href="'.url().'#/'.$sitio['longitud'].'/'.$sitio['latitud'].'/17/'.$sitio['tipo'].'"><small>Ver en el mapa</small></a></h3>
					<p>'.$sitio['descripcion'].'</p>
					<p>
					<strong>Direcci&oacute;n:</strong> '.$sitio['direccion'].'<br/>
					<strong>Tel&eacute;fono:</strong> '.$sitio['telefono'].'<br/>
					<strong>Horario:</strong> '.$sitio['horario'].'<br/>
					<strong>Tipo</strong>: '.$tiposSitio2[$tipo]['nombre'].'<br/>
					'.$parqueadero.'
					<strong>Qui&eacute;n:</strong> '.$quien.'<br/>
					<strong>Validez:</strong> '.$sitio['fecha_inicio'].' a '.$sitio['fecha_fin'].'<br/>
					<strong>Fecha Creaci&oacute;n:</strong> '.$sitio['fecha'].'
					</p>
					<p><strong>Sitios Cercanos:</strong><br/>'.$sitioscercanos.'</p>
					<p>'.$boton.'</p>
					
					<div id="modal'.$sitio['id'].'" class="modal">
						<div class="modal2">
						<form method="POST" action="'.url_administrador_sitios().'?1=1'.$linkpagina.'">
							<input type="submit" value="Editar" class="button"/> <a href="#" class="button alert cancelar">Cancelar</a>
							<h3>Id '.$sitio['id'].'</h3>
							<strong>Titulo:</strong> <input type="text" name="nombre" value="'.$sitio['nombre'].'"><br/>
							<strong>Ubicaci&oacute;n:</strong>
							<div id="googlemaps"></div>
	    					<input type="text" name="latlong" id="latlongmapa" value="'.$sitio['longitud'].','.$sitio['latitud'].'"/>
							<strong>Descripci&oacute;n:</strong> <textarea name="descripcion" rows="5" style="height:100px;" class="descadmin">'.$sitio['descripcion'].'</textarea><br/>
							<strong>Direcci&oacute;n:</strong> <input type="text" name="direccion"  value="'.$sitio['direccion'].'"><br/>
							<strong>Tel&eacute;fono:</strong> <input type="text" name="telefono"  value="'.$sitio['telefono'].'"><br/>
							<strong>Horario:</strong> <input type="text" name="horario"  value="'.$sitio['horario'].'"><br/>
							<strong>Tipo</strong>
							<select name="tipo">';

							foreach($tiposSitio2 as $key=>$categoria){
								if($key==$sitio['tipo']) $selected='selected="selected"';
								else $selected="";

								echo'
								<option value="'.$key.'" '.$selected.'>'.$categoria['nombre'].'</option>';
							}
									
							echo'
							</select><br/>
							';
							if($sitio['tipo']==tipo_parqueadero()) echo'
							<strong>Candado:</strong>
							<input type="radio" name="candado" value="1" '.($sitio['candado']==1?'checked':'').'/> S&iacute; 
							<input type="radio" name="candado" value="2" '.($sitio['candado']==2?'checked':'').'/> No 
							<input type="radio" name="candado" value="0" '.($sitio['candado']==0?'checked':'').'/> No S&eacute; <br/>
							<strong>Cubierto:</strong> 
							<input type="radio" name="cubierto" value="1" '.($sitio['cubierto']==1?'checked':'').'/> S&iacute; 
							<input type="radio" name="cubierto" value="2" '.($sitio['cubierto']==2?'checked':'').'/> No 
							<input type="radio" name="cubierto" value="0" '.($sitio['cubierto']==0?'checked':'').'/> No S&eacute; <br/>
							<strong>Tarifa:</strong> <input type="text" name="tarifa"  value="'.$sitio['tarifa'].'"/><br/>
							<strong>Cupos:</strong> <input type="text" name="cupos"  value="'.$sitio['cupos'].'"/><br/>';
							
							echo'
							<strong>Qui&eacute;n:</strong> <input type="text" name="quien"  value="'.$sitio['quien'].'"><br/>
							<strong>Email:</strong> <input type="text" name="email"  value="'.$sitio['email'].'"><br/>
							<strong>Inicio Validez <small>(YYYY-MM-DD HH:MM:SS)</small>:</strong> <input type="text" name="fechainicio"  value="'.$sitio['fecha_inicio'].'"><br/>
							<strong>Fin Validez <small>(YYYY-MM-DD HH:MM:SS)</small>:</strong> <input type="text" name="fechafin"  value="'.$sitio['fecha_fin'].'"><br/></p>

							<input type="hidden" name="id" value="'.$sitio['id'].'">
							<input type="hidden" name="accion" value="editar">
							<input type="hidden" name="pagina" value="'.$pagina.'">
							<input type="submit" value="Editar" class="button"/> <a href="#" class="button alert cancelar">Cancelar</a>
						</form>
						</div>
					</div>
							
				</td>
				<td>';
							

			if($tipo==tipo_ruta()){
				$puntosruta=json_decode($sitio['ruta'],true);
				$puntos=array();
				if( isset($puntosruta['b']) && count($puntosruta['b'])>0 ) {
					foreach($puntosruta['b'] as $punto){
						if(isset($punto['lat'])&&isset($punto['lon']))$puntos[]=$punto['lat'].", ".$punto['lon'];
					}
				}
				
				echo'
					<a href="'.url_sitio().$sitio['id'].'"><img src="http://maps.googleapis.com/maps/api/staticmap?size=400x300&maptype=roadmap
					&path=color:0x000000ff|weight:5|'.implode('|',$puntos).'&markers=size:tiny%7Ccolor:0xFF0000%7C'.implode('%7C',$markersitioscercanos).'&sensor=false"></a>';
			}
			else{
				echo'
					<a href="'.url_sitio().$sitio['id'].'"><img src="http://maps.googleapis.com/maps/api/staticmap?center='.$sitio['longitud'].','.$sitio['latitud'].'&zoom=14&size=400x300&maptype=roadmap
					&markers=color:black%7Clabel:%7C'.$sitio['longitud'].','.$sitio['latitud'].'&markers=size:tiny%7Ccolor:0xFF0000%7C'.implode('%7C',$markersitioscercanos).'&sensor=false"></a>';
			}
				
			
			echo'		
				</td>
			</tr>
			';
			
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
