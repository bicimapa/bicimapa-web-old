<?php 
$pagina='dashboard.php';
include_once('autorizar.php');
include_once('top.php');
?>

<div class="row">
      <div class="large-12 columns">
        	<h1>Dashboard</h1>
      </div>
</div>

<div class="row">
	  <div class="large-2 columns text-center">
        	<h4>Sitios</h4>
        	<h2 style="color:#000;"><?php echo darNumeroSitios();?></h2>
      </div>
      <div class="large-2 columns text-center">
        	<h4>Calificaciones</h4>
        	<h2 style="color:#000;"><?php echo darNumeroCalificaciones();?></h2>
      </div>
      <div class="large-2 columns text-center">
        	<h4>Ciclorrutas</h4>
        	<h2 style="color:#000;"><?php echo darNumeroCiclorrutas();?></h2>
      </div>
      <div class="large-2 columns text-center">
        	<h4>Ciclov&iacute;as</h4>
        	<h2 style="color:#000;"><?php echo darNumeroCiclovias();?></h2>
      </div>
      <div class="large-4 columns text-center">
        	<h4>Administrar Comentarios</h4>
        	<div class="row">
        		<div class="large-6 columns text-center">
        			<img src="<?php echo url().'img/facebook.png'?>"/> <a href="https://developers.facebook.com/tools/comments?view=recent_comments">Facebook</a>
        		</div>
        		<div class="large-6 columns text-center">
        			<img src="<?php echo url().'img/disqus.png'?>"/> <a href="http://bicimapa.disqus.com/admin/moderate/#/all">Disqus</a></p>
      			</div>
      		</div>
      </div>
</div>

<div class="row">
	  <div class="large-6 columns">
        	<h2>&Uacute;ltimos sitios</h2>
        	<?php 
        	$calificaciones=darUltimosSitios(20);
        	if(count($calificaciones)>0){
				echo'<table class="large-12 columns">
      					<tr>
	      					<th>Fecha</th>
		  					<th>Sitio</a></th>
	      				</tr>';
				foreach ($calificaciones as $calificacion){
					echo'
      				<tr>
      					<td>'.fecha_a_texto($calificacion['fecha']).'</td>
        				<td><a href="'.url_administrador_sitios().'?id='.$calificacion['id'].'&nombre=&quien=&aprobados=-1#">'.$calificacion['nombre'].'</a></td>
      				</tr>';
				}
				echo'</table>';
			}
        	?>
      </div>
      <div class="large-6 columns">
	      <div id="graficaTipoSitios" class="row  text-center" style="height: 400px;"></div>
			
			
			
			<div class="row">
        	<h2>&Uacute;ltimas calificaciones</h2>
        	<?php 
        	$calificaciones=darUltimasCalificaciones(10);
        	if(count($calificaciones)>0){
				echo'<table class="large-12 columns">
      					<tr>
	      					<th>Fecha</th>
		  					<th>Sitio</a></th>
	        				<th><abbr title="Calificaci&oacute;n">Cal</abbr></th>
	      				</tr>';
				foreach ($calificaciones as $calificacion){
					echo'
      				<tr>
      					<td>'.fecha_a_texto($calificacion['fecha']).'</td>
	  					<td><a href="'.url_sitio().$calificacion['sitio'].'">'.$calificacion['nombre'].'</a></td>
        				<td>'.$calificacion['calificacion'].'</td>
      				</tr>';
				}
				echo'</table>';
			}
        	?>
      		</div>
			
			
      </div>
</div>

<div class="row">
        	<div id="graficaEventos" class="large-12 columns" style="height: 250px;"></div>   
</div>


<?php include_once('pie.php');?>
