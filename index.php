<?php 
$pagina='index.php';
include_once('top.php');
?>





		<div id="mapaindex"></div>
		
		<div id="flotante">
		<a href="#deslizar" id="deslizar"><?php echo tr("filtros"); ?></a>
			<img src="<?php echo url();?>img/loader.gif" alt="Cargando..." id="loader"/>
			<form id="formactualizar" method="post">
			<p><a href="#flotante" class="todos"><?php echo tr("todos"); ?></a> | <a href="#flotante" class="ninguno"><?php echo tr("ninguno"); ?></a></p>
				<?php 
				foreach($tiposSitio2 as $key=>$categoria){
					$checked="";
					if($categoria['marcado'])$checked="checked";
					
					if($categoria['visible'])echo'
					<p class="flotante_opcion"><input type="checkbox" name="'.$key.'"  '.$checked.'/> '.$categoria['nombre'].' <img src="'.url().$categoria['img'].'" style="width:20px;height:23px;" title="'.$categoria['nombre'].'"></p>';
				}
				?>
					<p class="flotante_opcion"><input type="checkbox" name="ciclorrutas"  id="ciclorrutas" /> <?php echo tr("ciclorrutas"); ?> <img src="<?php echo url().'img/ciclorrutas.png'?>" title="<?php echo tr("ciclorrutas"); ?>"/></p>
					<p class="flotante_opcion"><input type="checkbox" name="ciclovias"  id="ciclovias"/> <?php echo tr("ciclovias"); ?> <img src="<?php echo url().'img/ciclovias.png'?>" title="<?php echo tr("ciclovias"); ?>"/></p>
					
				<input type="hidden" id="ciudad" name="ciudad" value="bogota"/>
				<input type="hidden" name="api" value="lugares"/>
				<input type="hidden" name="pass" value="<?php echo pass_api();?>"/>
			</form>
			<a href="#" id="actualizar" class="button"><?php echo tr("actualizar"); ?></a><br/>
			<a href="#top-bar" id="deslizartop"><img src="<?php echo url();?>img/top.png"/> <?php echo tr("inicio"); ?></a> 
		</div>
		
		
		<div id="listaciudades">
		</div>
		
<?php include_once('pie.php');?>
