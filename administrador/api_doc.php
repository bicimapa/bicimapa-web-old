<?php 
include_once('autorizar.php');
include_once('top.php');
?>


<div class="row">
      <div class="large-12 columns">
        <h2>Documentaci&oacute;n API</h2>
	  	<hr/>
	  </div>
</div>
<div class="row">
	  <div class="large-12 columns">
        	<h3>URL</h3>
      </div>
      <div class="large-12 columns">
        	<?php echo url_api();?> (<a href="http://requestmaker.com/">Make request</a>)
      </div>
</div>
<div class="row">
	  <div class="large-12 columns">
	  	<hr/>
	  </div>
</div>
<div class="row">
	  <div class="large-12 columns">
        	<h3>Lugares</h3>
      </div>
	  <div class="large-6 columns">
        	<h4>Par&aacute;metros</h4>
        	<table width="100%">
        		<tr>
        			<th>Par&aacute;metro</th>
        			<th>Descripci&oacute;n</th>
        		</tr>
        		<tr>
        			<td>pass</td>
        			<td>Contrase&ntilde;a</td>
        		</tr>
        		<tr>
        			<td>api</td>
        			<td>lugares</td>
        		</tr>
        		<tr>
        			<td>tipo</td>
        			<td>(Opcional) Integer con la categor&iacute;a.<br/>
        '0'=>'Sin Definir',<br/>
		'1'=>'Tienda',<br/>
		'2'=>'Parqueadero',<br/>
		'3'=>'Taller',<br/>
		'4'=>'Ruta',<br/>
		'5'=>'Atenci&oacute;n',<br/>
		'6'=>'El Bicitante'</td>
        		</tr>
        	</table>
      </div>
	  <div class="large-6 columns">
        	<h4>Respuesta</h4>
        	<script src="https://gist.github.com/jorpcolombia/beead33a6be5f3382936.js"></script>
      </div>
</div>
<div class="row">
	  <div class="large-12 columns">
	  	<hr/>
	  </div>
</div>
<div class="row">
	  <div class="large-12 columns">
        	<h3>Lugares Modificados desde un fecha</h3>
      </div>
	  <div class="large-6 columns">
        	<h4>Par&aacute;metros</h4>
        	<table width="100%">
        		<tr>
        			<th>Par&aacute;metro</th>
        			<th>Descripci&oacute;n</th>
        		</tr>
        		<tr>
        			<td>pass</td>
        			<td>Contrase&ntilde;a</td>
        		</tr>
        		<tr>
        			<td>api</td>
        			<td>lugaresmodificados</td>
        		</tr>
        		<tr>
        			<td>fecha</td>
        			<td>Unix Time Stamp (<a href="http://en.wikipedia.org/wiki/Unix_time">wiki</a>,<a href="http://www.unixtimestamp.com/index.php">converter</a>)</td>
        		</tr>
        	</table>
      </div>
	  <div class="large-6 columns">
        	<h4>Respuesta</h4>
        	<script src="https://gist.github.com/jorpcolombia/beead33a6be5f3382936.js"></script>
      </div>
</div>
<div class="row">
	  <div class="large-12 columns">
	  	<hr/>
	  </div>
</div>
<div class="row">
	  <div class="large-12 columns">
        	<h3>Ciclorrutas</h3>
      </div>
	  <div class="large-6 columns">
        	<h4>Par&aacute;metros</h4>
        	<table width="100%">
        		<tr>
        			<th>Par&aacute;metro</th>
        			<th>Descripci&oacute;n</th>
        		</tr>
        		<tr>
        			<td>pass</td>
        			<td>Contrase&ntilde;a</td>
        		</tr>
        		<tr>
        			<td>api</td>
        			<td>ciclorrutas</td>
        		</tr>
        	</table>
      </div>
	  <div class="large-6 columns">
        	<h4>Respuesta</h4>
        	<script src="https://gist.github.com/anonymous/f836ac482f62d4a35e48.js"></script>
      </div>
</div>
<div class="row">
	  <div class="large-12 columns">
	  	<hr/>
	  </div>
</div>
<div class="row">
	  <div class="large-12 columns">
        	<h3>Lugar</h3>
      </div>
	  <div class="large-6 columns">
        	<h4>Par&aacute;metros</h4>
        	<table width="100%">
        		<tr>
        			<th>Par&aacute;metro</th>
        			<th>Descripci&oacute;n</th>
        		</tr>
        		<tr>
        			<td>pass</td>
        			<td>Contrase&ntilde;a</td>
        		</tr>
        		<tr>
        			<td>api</td>
        			<td>lugar</td>
        		</tr>
        		<tr>
        			<td>id</td>
        			<td>Id del sitio</td>
        		</tr>
        	</table>
      </div>
	  <div class="large-6 columns">
        	<h4>Respuesta</h4>
        	<script src="https://gist.github.com/anonymous/2475baeb10d8d1bff4ef.js"></script>
      </div>
</div>
<div class="row">
	  <div class="large-12 columns">
	  	<hr/>
	  </div>
</div>
<div class="row">
	  <div class="large-12 columns">
        	<h3>Calificacion</h3>
      </div>
	  <div class="large-6 columns">
        	<h4>Par&aacute;metros</h4>
        	<table width="100%">
        		<tr>
        			<th>Par&aacute;metro</th>
        			<th>Descripci&oacute;n</th>
        		</tr>
        		<tr>
        			<td>pass</td>
        			<td>Contrase&ntilde;a</td>
        		</tr>
        		<tr>
        			<td>api</td>
        			<td>calificacion</td>
        		</tr>
        		<tr>
        			<td>id</td>
        			<td>Id del sitio</td>
        		</tr>
        	</table>
      </div>
	  <div class="large-6 columns">
        	<h4>Respuesta</h4>
        	<script src="https://gist.github.com/anonymous/89e5a9b464ee62b6f133.js"></script>
      </div>
</div>
<div class="row">
	  <div class="large-12 columns">
        	<h3>Calificar</h3>
      </div>
	  <div class="large-6 columns">
        	<h4>Par&aacute;metros</h4>
        	<table width="100%">
        		<tr>
        			<th>Par&aacute;metro</th>
        			<th>Descripci&oacute;n</th>
        		</tr>
        		<tr>
        			<td>pass</td>
        			<td>Contrase&ntilde;a</td>
        		</tr>
        		<tr>
        			<td>api</td>
        			<td>calificacion</td>
        		</tr>
        		<tr>
        			<td>id</td>
        			<td>Id del sitio</td>
        		</tr>
				<tr>
        			<td>idFB</td>
        			<td>Id de facebook del usuario</td>
        		</tr>
				<tr>
        			<td>calificacion</td>
        			<td>La calificaci&oacute;n de 1 a 5, m&uacute;ltiplos de 0.5 (0, 0.5, 1, 1.5, ...)</td>
        		</tr>
        	</table>
      </div>
	  <div class="large-6 columns">
        	<h4>Respuesta</h4>
        	<script src="https://gist.github.com/jorpcolombia/8a193151be9cfd8262ab.js"></script>
      </div>
</div>

<?php include_once('pie.php');?>