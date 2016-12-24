<?php 
$pagina='short.php';
include_once('autorizar.php');
include_once('top.php');
?>


<?php 
if(isset($_POST['accion']) && $_POST['accion']=="agregar"){
	if(isset($_POST['short']) && !empty($_POST['short']) && isset($_POST['url']) && !empty($_POST['url'])){
		if(filter_var($url, FILTER_VALIDATE_URL) === FALSE)
			imprimir_error("La Url no es v&aacute;lida. Debe ser de la forma http://www.bicimapa.com/?...");
		else {
			if( agregar_short_url($_POST['short'],$_POST['url']) )
				imprimir_ok("Se agreg&oacute; la short Url");
			else imprimir_error("Ocurri&oacute; un error al agregar la short URL");
		}
	}
	else imprimir_error("Se necesitan todos los campos.");
}
else if(isset($_POST['accion']) && $_POST['accion']=="editar"){
	if(isset($_POST['short']) && !empty($_POST['short']) && isset($_POST['url']) && !empty($_POST['url'])){
		if(filter_var($url, FILTER_VALIDATE_URL) === FALSE)
			imprimir_error("La Url no es v&aacute;lida. Debe ser de la forma http://www.bicimapa.com/?...");
		else {
			if( editar_short_url($_POST['id'],$_POST['short'],$_POST['url']) )
				imprimir_ok("Se edit&oacute; la short Url");
			else imprimir_error("Ocurri&oacute; un error al editar la short URL");
		}
	}
	else imprimir_error("Se necesitan todos los campos.");
}
else if(isset($_GET['accion']) && $_GET['accion']=='borrar' && isset($_GET['id']) && $_GET['id']>0){
	if( borrar_short_url($_GET['id']) )
		imprimir_ok("Se borr&oacute; la Short Url");
	else imprimir_error("Ocurri&oacute; un error al borrar la short URL");
}
?>

<div class="row">
	<form method="post" action="short.php">
		<div class="large-5 columns">
			<label>Short</label>
			<input type="text" name="short" value="<?php echo $u['short'];?>"/>
		</div>
		<div class="large-5 columns">
			<label>URL</label>
			<input type="text" name="url" value="<?php echo $u['url'];?>"/>
		</div>
		<div class="large-2 columns">
			<input type="hidden" name="accion" value="agregar"/>
			<input type="submit" value="Agregar" class="button"/>
		</div>
	</form>
</div>

<div class="row">
	<div class="large-12 columns">
		<table style="width:100%;">
			<?php 
			$urls=darLongUrls();
			foreach($urls as $u){
			?>
				<tr>
					<form method="post" action="short.php" class="editar">
					<td class="large-3 columns">
						<input type="text" name="short" value="<?php echo $u['short'];?>"/>
					</td>
					<td class="large-1 columns">
						<a href="<?php echo url_short().$u['short'];?>"><img src="<?php echo url();?>img/enlace.png" alt="Abrir"></a>
					</td>
					<td class="large-4 columns">
						<input type="text" name="url" value="<?php echo $u['url'];?>"/>
					</td>
					<td class="large-1 columns">
						<a href="<?php echo $u['url'];?>"><img src="<?php echo url();?>img/enlace.png" alt="Abrir"></a>
					</td>
					<td class="large-3 columns">
						<input type="hidden" name="id" value="<?php echo $u['id'];?>"/>
						<input type="hidden" name="accion" value="editar"/>
						<input type="submit" value="Editar" class="button"/>
						<a href="?accion=borrar&id=<?php echo $u['id'];?>" class="button eliminar" title="<?php echo $u['short'];?>">Eliminar</a>
					</td>
					</form>
				</tr>
			<?php 
			}
			?>
 		</table>
	</div>
</div>

<?php include_once('pie.php');?>
