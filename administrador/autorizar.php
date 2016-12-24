<?php
include_once('../funciones.php');

if(isset($_SESSION['bicimapa2013contador']) && ((int)$_SESSION['bicimapa2013contador'])>5 && $_SESSION['tiempo']>time() ){
	echo'
        <div class="row">
			<div class="large-12 columns">
				<h2>Demasiados intentos</h2>
			</div>
		</div>
        ';
	exit();
}
else{
	$inOneHour = 60*60 + time(); //una hora
	if( !isset($_SESSION['bicimapa2013contador']) ) $siguiente=1;
	else $siguiente=(((int)$_SESSION['bicimapa2013contador'])+1);
	$_SESSION['bicimapa2013contador']=$siguiente;
	$_SESSION['tiempo']=$inOneHour;
}
		
if( isset($_SESSION['bicimapareyes']) && $_SESSION['bicimapareyes']==md5('Super%Tesla&Fue#UnGran$Inventor') ){
	$_SESSION['bicimapa2013contador']=0;
	$_SESSION['tiempo']=time();
    //OK
}
else{
    if(isset($_POST['lacontrasena'])&&$_POST['lacontrasena']=='bicimapa'){
        $inTwoMonths = 60 * 60 * 24 * 60 + time(); 
        $_SESSION['bicimapareyes']=md5('Super%Tesla&Fue#UnGran$Inventor');
    }
    else{
    	include_once('../top.php');
        echo'
        <div class="row">
			<div class="large-12 columns">
				<form method="POST">
					<input type="password" name="lacontrasena"><br/>
					<input type="submit" class="button" value="Entrar">
				</form>		
			</div>
		</div>	
        ';
        include_once('../pie.php');
        exit();
    }
}
?>
