<?php 
include_once('funciones.php');

if(isset($_GET['s'])&&!empty($_GET['s'])){
	$short=$_GET['s'];
	$url=darLongUrl($short);
	if($url!=null){
		header("Location: ".$url);
		die();
	}
	else{
		$_GET['m']=404;
		include_once('404.php');
		die();
	}
}
else{
	$_GET['m']=404;
	include_once('404.php');
	die();
}
?>