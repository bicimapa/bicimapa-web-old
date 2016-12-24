<?php 
$pagina='biciplanes.php';
$top_titulo="Biciplanes";
include_once('top.php');?>

		<div class="row">
			<div class="large-4 columns">
			<h2><?php echo tr("calendario"); ?></h2>
			</div>
			<div class="large-3 columns">
			<a href="<?php echo url_sugerir_evento();?>" class="button"><?php echo tr("sugerir_un_evento"); ?></a>
			</div>
			<div class="large-5 columns">
			<p><img src="https://graph.facebook.com/lagranrodada01/picture"> <?php echo tr("eventos_gestionados_gran_rodada"); ?> <a href="http://about.me/LaGranRodada">La Gran Rodada</a>.</p>
			</div>
		</div>
		
		<div class="row">
			<div class="large-12 columns">
				<iframe src="https://www.google.com/calendar/embed?showPrint=0&amp;showCalendars=0&amp;height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=lagranrodada%40gmail.com&amp;color=%232952A3&amp;ctz=America%2FBogota" class="large-12" style=" border-width:0 " height="600" frameborder="0" scrolling="no"></iframe>
			</div>
		</div>	
  
<?php include_once('pie.php');?>
