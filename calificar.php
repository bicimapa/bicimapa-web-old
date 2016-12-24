<?php 
$pagina='calificar.php';
$top_titulo="Calificar un sitio";
include_once('top.php');


if(isset($_POST['usuario']) && !empty($_POST['usuario']) && $_POST['usuario']>0 &&  isset($_POST['token']) && $_POST['token']==md5('bicimapa'.date('d')) ){
	
	$idFB=(int)$_POST['usuario'];
	$usuario=darUsuarioFB($idFB);
	$id=(int)$_POST['id'];
	$puntaje=(double)$_POST['calificacion'];
	
	
	
	
	if(!yaCalifico($id,$usuario)){
		if( calificar($usuario,$id,$puntaje) ){
			
			$sitios=darSitio($id);
			if(count($sitios)>0){
				$sitio=$sitios[0];
				$top_titulo="Acabo de calificar el sitio ".$sitio['nombre']." en el Bicimapa.";
			}
			else $top_titulo="Acabo de calificar un sitio en el Bicimapa.";
			
			$url=url_sitio().$id;
			$compartir='
		    <a href="http://api.addthis.com/oexchange/0.8/forward/facebook/offer?url='.$url.'&amp;title='.$top_titulo.'&amp;username=bitajor&amp;lng=es"><img src="'.url().'img/socialmedia/facebook.png" alt="facebook" title="facebook"></a>
		    <a href="http://api.addthis.com/oexchange/0.8/forward/twitter/offer?url='.$url.'&amp;title='.$top_titulo.'&amp;username=bitajor&amp;lng=es"><img src="'.url().'img/socialmedia/twitter.png" alt="twitter" title="twitter"></a>
		    <a href="http://api.addthis.com/oexchange/0.8/forward/googleplus/offer?url='.$url.'&amp;title='.$top_titulo.'&amp;username=bitajor&amp;lng=es"><img src="'.url().'img/socialmedia/gplus.png" alt="googleplus" title="googleplus"></a>
		    <a href="http://api.addthis.com/oexchange/0.8/forward/tumblr/offer?url='.$url.'&amp;title='.$top_titulo.'&amp;username=bitajor&amp;lng=es"><img src="'.url().'img/socialmedia/tumblr.png" alt="tumblr" title="tumblr"></a>
		    ';
			imprimir_ok('<p>Gracias por la calificaci&oacute;n :).</p><p>Compartir: '.$compartir.'</p>');
		}
		else imprimir_error('No se pudo ingresar la calificaci&oacute;n :(.');
	}
	else imprimir_error('Ya hab&iacute;as calificado este sitio.');
	
	echo'
		<div class="row">
			<div class="large-12 columns">
				<a href="'.url_sitio().$id.'" class="button">Regresar</a>
			</div>
		</div>
		';
	
	include_once('pie.php');
	exit();
}
else if( isset($_POST['usuario']) ){
	imprimir_error('Ocurri&oacute; un error. Intenta de nuevo.');
}

$id=(int)$_POST['id'];
$puntaje=(double)$_POST['calificacion'];
$sitios=darSitio($id);
if(count($sitios)==1){
	foreach($sitios as $sitio){
		?>
		
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
	  FB.init({
	    appId      : '404487242984142', // App ID
	    channelUrl : '<?php echo url();?>/channel.html', // Channel File
	    status     : true, // check login status
	    cookie     : true, // enable cookies to allow the server to access the session
	    xfbml      : true  // parse XFBML
	  });
	
	
	  FB.Event.subscribe('auth.authResponseChange', function(response) {
	    if (response.status === 'connected') {
	      testAPI();
	    } else if (response.status === 'not_authorized') {
	      // logeado en faceook pero no en la app
	      FB.login();
	    } else {
	      // No loggeado
	      FB.login();
	    }
	  });
  };

  // Load the SDK asynchronously
  (function(d){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   ref.parentNode.insertBefore(js, ref);
  }(document));

  // Here we run a very simple test of the Graph API after login is successful. 
  // This testAPI() function is only called in those cases. 
  function testAPI() {
    FB.api('/me', function(response) {
    	$('#facebook').html('<p><img src="https://graph.facebook.com/'+response.id+'/picture"> '+ response.name +'</p><p><a href="#" onclick="FB.logout()">&#191;Esta no es tu cuenta?</a></p><p><a id="botoncalificar" class="button">Calificar</a> <a class="button alert" href="<?php echo url_sitio().$sitio['id'];?>">Cancelar</a></p>' );
    	$('#usuario').val(response.id);
    	$('#botoncalificar').click(function(){
    		$('#calificar').submit();
        });
    	
    	
    });
  }
</script>

<div class="row">
	<div id="class="large-12 columns">		
	<p><?php 
	$nombre=$sitio['nombre'];
	echo '&#191;Calificar a <strong>'.$nombre.'</strong> con un puntaje de <strong>'.$puntaje.'</strong>?';
	?></p>
	</div>
</div>

<div class="row">
	<div id="facebook" class="large-12 columns">
		<center>
			<p><a href="#" class="facebooklogin" onclick="FB.login();">Calificar con facebook</a></p>
		</center>
		<div class="row">
			<div class="large-12 columns">		
			<h3>&#191;Por qu&eacute; tengo que iniciar sesi&oacute;n en facebook?</h3>
			<ul>
				<li>No queremos que tengas que memorizar m&aacute;s contrase&#241;as.</li>
				<li>Identificando a los usuarios evitamos a los trolls (Odiamos a los <a href="http://es.wikipedia.org/wiki/Troll_%28Internet%29">trolls</a>).</li>
				<li>No vamos a publicar nada sin permiso ni a compartir informaci&oacute;n.</li>
			</ul>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="large-12 columns">
		<form id="calificar" method="post">
			<input type="hidden" name="id" value="<?php echo $id;?>"/>
			<input type="hidden" name="usuario" id="usuario" value="0"/>
			<input type="hidden" name="calificacion" value="<?php echo $puntaje;?>"/>
			<input type="hidden" name="token" value="<?php echo md5('bicimapa'.date('d'));?>"/>
		</form>
	</div>
</div>



<?php 
	}
				
}
else{
	imprimir_error("No se encontr&oacute; el lugar.");
}
?>


	
	
<?php include_once('pie.php');?>
