<?php 
$pagina='ciclovias.php';
include_once('autorizar.php');
include_once('top.php');
?>


<?php 
if(isset($_POST['ruta']) && !empty($_POST['ruta']) && isset($_POST['id']) && $_POST['id']==0){
	
	$ruta="";
	if($rutajson=json_decode($_POST['ruta'],true)){
		
		//print_r($rutajson);
		
		$puntosruta=array();
		if(isset($rutajson['b'])) foreach($rutajson['b'] as $punto)$puntosruta[]=$punto['lat'].",".$punto['lon'];
		$ruta=implode(";",$puntosruta);
		
		if( agregar_ciclovia($_POST['nombre'],$_POST['descripcion'],$ruta) )
			imprimir_ok("Se agreg&oacute; la ciclovia");
		else imprimir_error("Ocurri&oacute; un error al agregar la ciclovia");
	}
	else imprimir_error("Error al decodificar la ruta.");
	
}
else if(isset($_POST['ruta']) && !empty($_POST['ruta']) && isset($_POST['id']) && $_POST['id']>0){

	$ruta="";
	if($rutajson=json_decode($_POST['ruta'],true)){
	
		$puntosruta=array();
		if(isset($rutajson['b'])) foreach($rutajson['b'] as $punto)$puntosruta[]=$punto['lat'].",".$punto['lon'];
		$ruta=implode(";",$puntosruta);
	
		if( editar_ciclovia($_POST['id'],$_POST['nombre'],$_POST['descripcion'],$ruta) )
			imprimir_ok("Se edit&oacute; la ciclovia");
		else imprimir_error("Ocurri&oacute; un error al editar la ciclovia");
	}
	else imprimir_error("Error al decodificar la ruta.");
}
else if(isset($_GET['accion']) && $_GET['accion']=='eliminar' && isset($_GET['id']) && $_GET['id']>0){
	if( borrar_ciclovia($_GET['id']) )
		imprimir_ok("Se borr&oacute; la ciclovia");
	else imprimir_error("Ocurri&oacute; un error al borrar la ciclovia");
}
else if(isset($_POST['ruta'])&&empty($_POST['ruta'])) imprimir_error("La ruta est&aacute; vac&iacute;a");
?>

<div class="row">
      <div class="large-6 columns">
        <h2>Ciclov&iacute;as</h2>
	  	
	  </div>
      <div class="large-6 columns">
      		<select name="ciclovia" id="ciclovia">
      			<option value="0">Nueva Ciclov&iacute;a</option>
			<?php 
			$ciclo=darCiclovias();
			foreach($ciclo as $c){
			?>
				<option value="<?php echo $c['id'];?>"><?php echo $c['id'];?>. <?php echo $c['nombre'];?></option>
			<?php 
			}
			?>
 			</select>
	  </div>
	  <hr/>
</div>

<div class="row">
	  <div class="large-12 columns">
	  		
	  			<div class="row">
      				<div class="large-4 columns">
      					<form method="post">
     					<label>Nombre:</label> <input type="text" name="nombre" id="nombre"/>
     				</div>
      				<div class="large-4 columns">
     					<label>Descripci&oacute;n:</label> <input type="text" name="descripcion" id="descripcion"/>
     				</div>
     				<div class="large-2 columns">
     					<input type="hidden" name="id" class="idciclovia"/>
     					<input type="hidden" name="ruta" id="ruta"/>
     					<input type="submit" value="Guardar" class="button"/>
     					</form>
     				</div>
     				<div class="large-2 columns">
     					<form method="get" id="eliminar">
     					<input type="hidden" name="id" class="idciclovia"/>
     					<input type="hidden" name="accion" value="eliminar"/>
     					<input type="submit" class="button alert" value="Eliminar"/>
     					</form>
     				</div>
     			</div>
	  		
	  </div>
</div>

<div class="row">
	<div class="large-12 columns">
		<input type="button" value="Borrar &uacute;ltimo Punto" id="borrarpunto" class="button small"/>
		<input type="button" value="Borrar todos los puntos" id="borrarruta"  class="button small"/>
		<input type="button" value="Editar el otro extremo" id="cambiarextremo"  class="button small"/>
	</div>
	<div class="large-12 columns" id="mapaciclovias"></div>
</div>

<?php include_once('pie.php');?>
