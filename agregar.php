<?php 
$pagina='agregar.php';
$top_titulo="Agregar un Sitio";
if(isset($_GET['lat'])&&$_GET['lat'])$latitud=(double)$_GET['lat'];
if(isset($_GET['lon'])&&$_GET['lon'])$longitud=(double)$_GET['lon'];
if(isset($_POST['lat'])&&$_POST['lat'])$latitud=(double)$_POST['lat'];
if(isset($_POST['lon'])&&$_POST['lon'])$longitud=(double)$_POST['lon'];
include_once('top.php');?>

<?php 
if(isset($_POST['nombre']) && !empty($_POST['nombre'])){
	
	if(
			isset($_POST['nombre']) && !empty($_POST['nombre']) &&
			isset($_POST['descripcion']) && !empty($_POST['descripcion']) &&
			isset($_POST['latlong']) && !empty($_POST['latlong'])
	){
		$parteslatlong=explode(',',$_POST['latlong']);
		if(count($parteslatlong)==2){
			$latitud=$parteslatlong[1];
			$longitud=$parteslatlong[0];
			if(isset($_POST['autorizacion'])&&$_POST['autorizacion']=='on')$autorizacion=1;
			else $autorizacion=0;
			$respuesta=agregar($_POST['nombre'],$_POST['direccion'],$_POST['telefono'],$_POST['horario'],$_POST['descripcion'],$latitud,$longitud,$_POST['tipo'],$_POST['quien'],$_POST['email'],$autorizacion,$_POST['ruta'],$_POST['candado'],$_POST['cubierto'],$_POST['tarifa'],$_POST['cupos']);
			if($respuesta){
				
				$top_titulo=sprintf(tr("share_string"), $_POST['nombre']);
				$url=url();
				$compartir='
								    <a href="http://api.addthis.com/oexchange/0.8/forward/facebook/offer?url='.$url.'&amp;title='.$top_titulo.'&amp;username=bitajor&amp;lng=es"><img src="'.url().'img/socialmedia/facebook.png" alt="facebook" title="facebook"></a>
								    <a href="http://api.addthis.com/oexchange/0.8/forward/twitter/offer?url='.$url.'&amp;title='.$top_titulo.'&amp;username=bitajor&amp;lng=es"><img src="'.url().'img/socialmedia/twitter.png" alt="twitter" title="twitter"></a>
								    <a href="http://api.addthis.com/oexchange/0.8/forward/googleplus/offer?url='.$url.'&amp;title='.$top_titulo.'&amp;username=bitajor&amp;lng=es"><img src="'.url().'img/socialmedia/gplus.png" alt="googleplus" title="googleplus"></a>
								    <a href="http://api.addthis.com/oexchange/0.8/forward/tumblr/offer?url='.$url.'&amp;title='.$top_titulo.'&amp;username=bitajor&amp;lng=es"><img src="'.url().'img/socialmedia/tumblr.png" alt="tumblr" title="tumblr"></a>
								    ';
				
				imprimir_ok(tr("gracias_sugerencia").$compartir.'</p>');
			}
			else imprimir_error(tr("error_sugerencia"));
		}
		else  imprimir_error(tr("coordenadas_error_sugerencia"));
	}
	else imprimir_error(tr("campos_error_sugerencia"));
	
}
?>

	<div class="row">
		<div class="large-12 columns">
		<h2><?php echo tr("sugerir_un_sitio_en_el_bicimapa"); ?></h2>
		</div>
	</div>
	
	<form action="<?php echo url_agregar();?>" method="POST"  id="formulario_agregar" class="custom">
	
	<div class="row">
      <div class="large-9 columns">
      <label><?php echo tr("nombre_del_sitio"); ?></label>
        <input type="text" name="nombre" id="nombre">
      </div>
      
	  <div class="large-3 columns">
	  <label><?php echo tr("tipo_de_sitio"); ?></label>
        <select name="tipo" id="tipo" class="medium">
			<?php 
			foreach($tiposSitio2 as $key=>$categoria){
				if($categoria['agregable'])echo'
				<option value="'.$key.'">'.$categoria['nombre'].'</option>';
			}
			?>
		</select>
      </div>
    </div>
    
    <div class="row">
      <div class="large-12 columns">
      <label><?php echo tr("descripcion"); ?></label>
        <textarea name="descripcion" id="descripcion"></textarea>
      </div>
    </div>
    
    <div class="row">
      <div class="large-12 columns">
      		<label><?php echo tr("ciudad"); ?></label>
      		<div class="row">
      			<div class="large-6 columns"><input type="text" name="ciudad" id="ciudad"></div>
      			<div class="large-6 columns"><input type="button" id="buscarCiudad" value="<?php echo tr("ir"); ?>" class="button small"></div>
      		</div>
      </div>
    </div>
    
    <div class="row">
	    <div id="listaciudadesagregar" class="large-12 columns">
		</div>
	</div>
    
    <div class="row">
    	<div class="large-12 columns">
		<span id="instrucciones"><?php echo tr("explicaciones_navegacion"); ?></span> <a href="#" id="togglemap" class="button tiny secondary"><img src="<?php echo url().'img/resize.png';?>"> <span><?php echo tr("aumentar_mapa"); ?></span></a>
		</div>

	    <div class="large-12 columns">
		    <div id="googlemaps"></div>
		    <input type="hidden" name="latlong" id="latlongmapa" value=""/>
		    <input type="hidden" name="ruta" id="rutamapa" value=""/>
	    </div>
    </div>
    
    <div class="row">
	      <div class="large-6 columns">
	      <label><?php echo tr("dirrecion_o_indicaciones"); ?></label>
	        <input type="text" id="direccion" name="direccion">
	      </div>
		  <div class="large-6 columns">
	  <label><?php echo tr("telefono_o_celular"); ?></label>
	        <input type="text" name="telefono">
	      </div>
    </div>
    
    <div class="row">
	      <div class="large-12 columns">
	      <label><?php echo tr("horario"); ?></label>
	        <input type="text" id="horario" name="horario">
	      </div>
    </div>
	
	<div class="row" id="parqueadero">
	      <div class="large-6 columns">
	      <label><?php echo tr("candado?"); ?></label>
	        <p><div class="row">
		<div class="large-4 columns"><input type="radio" name="candado" value="1"/> <?php echo tr("si"); ?></div>
		<div class="large-4 columns"><input type="radio" name="candado" value="2"/> <?php echo tr("no"); ?></div>
		<div class="large-4 columns"><input type="radio" name="candado" value="0" checked/> <?php echo tr("no_se"); ?></div>
			</div></p>
	      </div>
		  <div class="large-6 columns">
		  <label><?php echo tr("cubierto?"); ?></label>
	        <p><div class="row">
		<div class="large-4 columns"><input type="radio" name="cubierto" value="1"/> <?php echo tr("si"); ?></div> 
		<div class="large-4 columns"><input type="radio" name="cubierto" value="2"/> <?php echo tr("no"); ?></div> 
		<div class="large-4 columns"><input type="radio" name="cubierto" value="0" checked/> <?php echo tr("no_se"); ?></div>
			</div></p>
	      </div>
		  <div class="large-6 columns">
		  <label><?php echo tr("tarifa"); ?></label>
	        <input type="text" name="tarifa"/>
	      </div>
		  <div class="large-6 columns">
		  <label><?php echo tr("cupos"); ?></label>
	        <input type="text" name="cupos"/>
	      </div>
    </div>
	
	<div class="row">
      <div class="large-6 columns">
      <label><?php echo tr("tu_nombre"); ?></label>
        <input type="text" name="quien">
      </div>
	  <div class="large-6 columns">
	  <label><?php echo tr("tu_email"); ?></label>
        <input type="text" name="email">
      </div>
    </div>
    
    <div class="row">
      <div class="large-12 columns">
      <p><input type="checkbox" name="autorizacion"> <?php echo tr("recibir_noticias?"); ?></p>
      </div>
    </div>
	
	<div class="row">
      <div class="large-12 columns">
      <input type="submit" value="<?php echo tr("enviar"); ?>" class="button">
      </div>
    </div>
    
    </form>
	

<?php include_once('pie.php');?>
