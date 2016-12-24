<?php 
$pagina='widgets.php';
include_once('autorizar.php');
include_once('top.php');
?>


<div class="row">
      <div class="large-12 columns">
        <h2>Widgets</h2>
	  	<hr/>
	  </div>
</div>
<div class="row">
	  <div class="large-12 columns">
        	<h3>Iframe</h3>
      </div>
</div>
<div class="row">
	  <div class="large-6 columns">
		<h3>Personalizar</h3>
		<label>Permalink</label><input type="text" name="permalink" id="permalink" value="http://www.bicimapa.com/#lat=4.7043213327177105&lon=-74.10278346594237&z=11&t=2,6">
		<div class="row">
			<div class="large-4 columns">
				<label>Ancho (Ej: 500px)</label><input type="text" name="permalink" id="ancho" value="500px">
			</div>
			<div class="large-4 columns">
				<label>Alto (Ej: 400px)</label><input type="text" name="permalink" id="alto" value="400px">
			</div>
			<div class="large-4 columns">
				<input type="button" id="generar" class="button small" value="Generar c&oacute;digo">
			</div>
		</div>
		<h3>Código</h3>
		<textarea id="codigo" style="height:200px;" rows="5"></textarea>
		<p><small>Copie el código html del campo anterior y p&eacute;guelo en donde quiera que aparezca.</small></p>
	  </div>
	  <div class="large-6 columns">
		<h3>Vista Previa</h3>
		<div id="preview"></div>
	  </div>
</div>

<?php include_once('pie.php');?>