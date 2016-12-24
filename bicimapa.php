<?php 
$pagina='bicimapa.php';
$top_titulo="Sobre Bicimapa";
include_once('top.php');?>

		<div class="row">
			<div class="large-12 columns">
			<h2><?php echo tr("sobre_bicimapa"); ?></h2>
			</div>
		</div>
		
		<div class="row">
			<div class="large-12 columns">
			<h3 id="que-es" class="seccion"><?php echo tr("que_es"); ?></h3>
			</div>
		</div>
		
		<div class="row">
			<div class="large-12 columns">
				<center><img src="<?php echo url().'img/bicimapa.png';?>" class="logobicimapa"></center>
								
				<?php echo tr("que_es_bicimapa"); ?>

				<h4><?php echo tr("descripcion"); ?></h4>
				
				<?php echo tr("descripcon_bicimapa"); ?>


			</div>
		</div>
		
  
<?php include_once('pie.php');?>
