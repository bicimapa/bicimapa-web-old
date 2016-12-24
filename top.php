<?php include_once('funciones.php');

include_once('api.php');
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

<head>
	<!-- <?php echo "Locale:".$_SESSION["locale"].",".$_SESSION["country"]; ?> -->

	<!-- 
	
	========================= BICIMAPA =========================
	
	                                           $"   *.      
	               d$$$$$$$P"                  $    J
	                   ^$.                     4r  "
	                   d"b                    .db
	                  P   $                  e" $
	         ..ec.. ."     *.              zP   $.zec..
	     .^        3*b.     *.           .P" .@"4F      "4
	   ."         d"  ^b.    *c        .$"  d"   $         %
	  /          P      $.    "c      d"   @     3r         3
	 4        .eE........$r===e$$$$eeP    J       *..        b
	 $       $$$$$       $   4$$$$$$$     F       d$$$.      4
	 $       $$$$$       $   4$$$$$$$     L       *$$$"      4
	 4         "      ""3P ===$$$$$$"     3                  P
	  *                 $       """        b                J
	   ".             .P                    %.             @
	     %.         z*"                      ^%.        .r"
	        "*==*""                             ^"*==*""   
	
	 -->


	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<title><?php if (isset($top_titulo)) echo $top_titulo.' - Bicimapa.com'; else echo'Bicimapa - '.tr("titulo");?></title>

  	<link href="<?php echo url();?>img/avatar_16.png" rel="shortcut icon" />
	
	<meta name="robots" content="index, follow" />
	<meta name="keywords" content="bicicleta,colombia,cicla,mapa,tienda,taller,parqueadero,ciclista" />
	<meta name="description" content="<?php if(isset($top_descripcion)) echo $top_descripcion; else echo'El mapa de los ciclistas en la ciudad. &Uacute;salo, mej&oacute;ralo y comp&aacute;rtelo.';?>" />
	<meta name="Revisit-After" content="3 Days" />
	<meta property="og:title" content="<?php if (isset($top_titulo)) echo $top_titulo.' - Bicimapa.com'; else echo'Bicimapa - El mapa de los ciclistas en la ciudad';?>" />
	<meta property="og:description" content="<?php if(isset($top_descripcion)) echo $top_descripcion; else echo'El mapa de los ciclistas en la ciudad. &Uacute;salo, mej&oacute;ralo y comp&aacute;rtelo.';?>" />
	<meta property="og:image" content="<?php echo url();?>img/avatar_128.png" />
	
	<meta property="fb:app_id" content="404487242984142"/>
	
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/foundation/4.3.1/css/foundation.min.css">
	<link rel="stylesheet" href="<?php echo url();?>css/rateit.css">	
	<link rel="stylesheet" href="<?php echo url();?>css/estilo.css">
	<link rel="stylesheet" href="<?php echo url();?>css/jquery.powertip.min.css">
	<?php if(isset($datepicker) && $datepicker==true){?><link rel="stylesheet" href="<?php echo url();?>css/foundation-datepicker.css"><?php }?>
	

  	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/foundation/4.3.2/js/vendor/custom.modernizr.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	<script src="<?php echo url();?>js/jquery.rateit.min.js"></script>
	<script src="<?php echo url();?>js/jquery.powertip.min.js"></script>
	<?php if(isset($datepicker) && $datepicker==true){?>
	<script src="<?php echo url();?>js/foundation-datepicker.min.js"></script>
	<script>
	$(document).ready(function() {
		$('.datepickers').fdatepicker({
			format: 'dd-mm-yyyy',
			language: 'es'
		});
	});
	</script>
	<?php }	
	
	$parametros=array();
	if(isset($pagina)&&!empty($pagina))$parametros[]='p='.md5($pagina);
	if(isset($lat)&&!empty($lat))$parametros[]='lat='.$lat;
	if(isset($lon)&&!empty($lon))$parametros[]='lon='.$lon;
	if(isset($_GET['lang'])&&!empty($_GET['lang']))$parametros[]='lang='.$_GET['lang'];
	if(isset($_GET['country'])&&!empty($_GET['country']))$parametros[]='country='.$_GET['country'];
	?>
	
	<script src="<?php echo url();?>js/bicimapa.js<?php if(count($parametros)>0)echo '?'.implode('&',$parametros); ?>"></script>

	<script src="/js/cookies.min.js"></script>
	<script type="text/javascript">
		
<?php 

$id=(int)$_GET['id'];
	$id_beta  = idBeta($id)
?>

<?php if ($id_beta == NULL) { ?>
			location.href = "http://beta.bicimapa.com";
<?php } else { ?>
			location.href = "http://beta.bicimapa.com/en/sites/<?php echo $id_beta; ?>";
<?php } ?>	

	</script>

</head>
<body>

<nav class="top-bar <?php if(isset($_GET['t'])&&$_GET['t']=='iframe') echo'iframe';?>" id="top-bar">
  <ul class="title-area">
    <!-- Title Area -->
    <li class="name">
      <h1><a href="<?php echo url();?>"><img src="<?php echo url();?>img/bicimapa_top.png" alt="Bicimapa"></a></h1>
    </li>
    <?php if(isset($_GET['t'])&&$_GET['t']=='iframe'){}else{?>
    <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
    <li class="toggle-topbar menu-icon"><a href="#"><span><?php echo tr("menu"); ?></span></a></li>
    <?php }?>
  </ul>

  <?php if(isset($_GET['t'])&&$_GET['t']=='iframe'){}else{?>
  <section class="top-bar-section">
    <!-- Left Nav Section -->
    <ul class="left">
    <?php if($pagina=='index.php'){?>
    	<li class="has-form">
   			<form id="ciudades">
	          <div class="row collapse">
	            <div class="small-10 columns">
		    <input type="text" name="ciudad" placeholder="<?php echo tr("ciudad"); ?>" id="ciudad">
	            </div>
	            <div class="small-2 columns">
		    <input type="submit" value="<?php echo tr("ir"); ?>" id="buscarCiudad" class="button">
	            </div>
	          </div>
	        </form>
      </li>
	<?php }?>
	      <li class="divider"></li>
	      <li><a href="<?php echo url_agregar();?>" class="top-bar-item" title="<?php tr("agregar_sitio"); ?>"><img src="<?php echo url();?>img/add.png"> <span><?php echo tr("agregar_sitio"); ?></span></a></li>
	      <li class="divider"></li>
	      
	      
	      <li class="has-dropdown"><a href="#" class="top-bar-item" title="<?php echo tr("que_mas_hay") ?>"><img src="<?php echo url();?>img/menu.png"> <span><?php echo tr("que_mas_hay"); ?></span></a>
	      <ul class="dropdown">
	      <li class="has-dropdown"><a href="<?php echo url().'bicimapa.php';?>"><img src="<?php echo url();?>img/acerca.png"> <?php echo tr('sobre_el_bicimapa'); ?></a>
			        <ul class="dropdown">
				<li><a href="<?php echo url().'bicimapa.php#que-es';?>"><img src="<?php echo url();?>img/exclamation.png"> <?php echo tr("que_es"); ?></a></li>
				<li><a href="<?php echo url().'ayuda.php';?>"><img src="<?php echo url();?>img/acerca.png"> <?php echo tr("ayuda"); ?></a></li>
				<li><a href="<?php echo url().'terminos-y-condiciones/';?>"><img src="<?php echo url();?>img/exclamation.png"> <?php echo tr("terminos_y_condiciones"); ?></a></li>
				<li><a href="<?php echo url_sugerir();?>"><img src="<?php echo url();?>img/chat.png"> <?php echo tr("sugerencias"); ?></a></li>
						<li class="divider"></li>
			        </ul>
			    </li>
			    <li><a href="<?php echo url_directorio();?>"><img src="<?php echo url();?>img/list.png"> <?php echo tr("bicigente"); ?></a></li>
			    <li><a href="<?php echo url_calendario();?>"><img src="<?php echo url();?>img/calendar.png"> <?php echo tr("biciplanes"); ?></a></li>
			    <li><a href="<?php echo url_blog();?>"><img src="<?php echo url();?>img/chat.png"> <?php echo tr("biciblog"); ?></a></li>
	      </ul>
	      </li>
	      
		  <li class="divider"></li>

	      <li><a class="redessociales" href="https://www.facebook.com/BiciMapa<?php if ($_SESSION["locale"] == "FR") echo "FR"; ?>"><img src="<?php echo url();?>img/facebook.png"><span> Fbk/Bicimapa</span></a></li>
	      <li><a class="redessociales" href="https://twitter.com/bicimapa<?php if ($_SESSION["locale"] == "FR") echo "FR"; ?>"><img src="<?php echo url();?>img/twitter.png"><span> @Bicimapa</span></a></li>
	      
	      <li class="divider"></li>
	      <li><a class="redessociales" href="http://bit.ly/bicimapaApp"><img src="<?php echo url();?>img/android.png"><span> Bicimapa para Android</span></a></li>
	      <li><a class="redessociales" href="<?php echo url();?>ios/"><img src="<?php echo url();?>img/apple.png"><span> Bicimapa para iOS</span></a></li>
	</ul>

    <!-- Right Nav Section -->
    <ul class="right">
      <?php if(isset($_GET['t'])&&$_GET['t']=='iframe'){}else{?>
	  <?php if($pagina=='index.php'){?>
      <li class="has-dropdown">
      	  <a href="#" class="redessociales" id="permalink"><img src="<?php echo url();?>img/enlace.png"><span> <?php echo tr("permalink"); ?></span></a>
	      <ul class="dropdown">
	      		 <li><a><?php echo tr("permalink"); ?>: <input type="text" id="campopermalink" style="width:300px;"/></a></li>
	      		 <li class="divider"></li>
		  </ul>
	  </li>
      <li class="divider"></li>
	  <?php }?>
      <li class="has-form">
        <form method="get" action="<?php echo url_buscar();?>">
          <div class="row collapse">
            <div class="small-8 columns">
              <input type="text" name="nombre">
            </div>
            <div class="small-4 columns">
	    <input type="submit" value="<?php echo tr("buscar"); ?>" class="button">
            </div>
          </div>
        </form>
      </li>
      <?php }?>
    </ul>
  </section>
  <?php }?>
</nav>

<!-- <?php echo print_r($_SESSION['ciudadguardada']).' *** '.print_r($_COOKIE['ciudadguardada']); ?>-->

<?php
//Mostrar aviso para descargar aplicación en Android
require_once 'Mobile_Detect.php';
$detect = new Mobile_Detect;
if ( (!isset($_COOKIE['barra_android']) && !isset($_SESSION['barra_android'])) && $detect->isMobile() && $detect->isAndroidOS()) {
	echo '<div id="barra_android"><a href="http://bit.ly/bicimapaApp"><img src="'.url().'img/android.png"> Descarga el Bicimapa para Android</a><a href="#" class="cerrar"><img src="'.url().'img/close.png" alt="X"/></a></div>';
}
?>
