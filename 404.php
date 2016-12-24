<?php
include_once('top.php');
?>

<div class="row">
			<div class="large-12 columns">
<h2>ERROR</h2>
<p><?php
    if($_GET['m']==401){
        echo 'Error 401';
    }
    else if($_GET['m']==403){
        echo 'Error 403';
    }
    else if($_GET['m']==404){
        echo '<p>Sufrimos una ca&iacute;da y no pudimos encontrar la p&aacute;gina que buscabas.</p><p><center><img src="https://googledrive.com/host/0B5FEo4LJMoL4aUFIeDMtRFNwS28/bicimapa404.gif"></center></p>';
    }
    else if($_GET['m']==500){
        echo 'Error del servidor';
    }
    else if($_GET['m']==502){
        echo 'Error 502';
    }
    else{
        echo 'Error desconocido';
    }
?></p>
			</div>
		</div>
		
<?php
include_once('pie.php');
?>