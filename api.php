<?php
include_once('funciones.php');

if(
	isset($_POST['api']) && $_POST['api']=='lugares'&&
	(
			(isset($_POST['pass']) && $_POST['pass']==pass_api())
			||(isset($_POST['pass']) && $_POST['pass']==pass_api_mobil())
			)
	){	

	
	//LUGARES
	if(isset($_POST['tipo']))$sitios=darSitiosAprobados(0,(int)$_POST['tipo']);
	else $sitios=array();
	
	$incluir=array();
	
	foreach($tiposSitio2 as $key=>$categoria){
		//echo $key.'on<br/>';
		if(isset($_POST[$key])&&$_POST[$key]=='on'){
			$incluir[]=$key;
		}
		
	}
	
	$sitios=darSitiosAprobados(0,$incluir,1);
	
	//echo count($sitios).'*';
	
	for($k=0;$k<count($sitios);$k++){
		$sitios[$k]['nombre']=$sitios[$k]['nombre'];
		$sitios[$k]['descripcion']=$sitios[$k]['descripcion'];
		$sitios[$k]['direccion']=$sitios[$k]['direccion'];
		$sitios[$k]['telefono']=$sitios[$k]['telefono'];
		$sitios[$k]['nombrelimpio']=limpiar_texto($sitios[$k]['nombre']);
	}

	echo json_encode($sitios);
	exit();
}
else if(
isset($_POST['api']) && $_POST['api']=='lugaresmodificados'&&
(
		(isset($_POST['pass']) && $_POST['pass']==pass_api())
		||(isset($_POST['pass']) && $_POST['pass']==pass_api_mobil())
)
){

	//LUGARES MODIFICADOS DESPUES De UNA FECHA
	if(isset($_POST['fecha']))$sitios=darSitiosAprobadosCambios($_POST['fecha']);
	else $sitios=array();

	for($k=0;$k<count($sitios);$k++){
		$sitios[$k]['nombre']=$sitios[$k]['nombre'];
		$sitios[$k]['descripcion']=$sitios[$k]['descripcion'];
		$sitios[$k]['direccion']=$sitios[$k]['direccion'];
		$sitios[$k]['telefono']=$sitios[$k]['telefono'];
		$sitios[$k]['nombrelimpio']=limpiar_texto($sitios[$k]['nombre']);
	}
	echo json_encode($sitios);
	exit();
}
else if(
		isset($_POST['api']) && $_POST['api']=='ciclorrutas' &&
		(
			(isset($_POST['pass']) && $_POST['pass']==pass_api())
			||(isset($_POST['pass']) && $_POST['pass']==pass_api_mobil())
			)
		){
	//CICLORRUTAS
	$ciclorrutas=darCiclorrutas();
	for($k=0;$k<count($ciclorrutas);$k++){
		$ciclorrutas[$k]['nombre']=$ciclorrutas[$k]['nombre'];
		$ciclorrutas[$k]['descripcion']=$ciclorrutas[$k]['descripcion'];
	}
	echo json_encode($ciclorrutas);
	exit();
	
}
else if(
		isset($_POST['api']) && $_POST['api']=='ciclorruta' &&
		isset($_POST['id']) && !empty($_POST['id']) &&
(
		(isset($_POST['pass']) && $_POST['pass']==pass_api())
		||(isset($_POST['pass']) && $_POST['pass']==pass_api_mobil())
)
){
	//CICLORRUTA
	$ciclorruta=darCiclorruta($_POST['id']);
	echo json_encode($ciclorruta);
	exit();

}
else if(
isset($_POST['api']) && $_POST['api']=='ciclovias' &&
(
		(isset($_POST['pass']) && $_POST['pass']==pass_api())
		||(isset($_POST['pass']) && $_POST['pass']==pass_api_mobil())
)
){
	//CICLOVIAS
	$ciclovias=darCiclovias();
	for($k=0;$k<count($ciclovias);$k++){
		$ciclovias[$k]['nombre']=$ciclovias[$k]['nombre'];
		$ciclovias[$k]['descripcion']=$ciclovias[$k]['descripcion'];
	}
	echo json_encode($ciclovias);
	exit();

}
else if(
isset($_POST['api']) && $_POST['api']=='cicloviasDSC' &&
(
		(isset($_POST['pass']) && $_POST['pass']==pass_api())
		||(isset($_POST['pass']) && $_POST['pass']==pass_api_mobil())
)
){
	//CICLOVIAS DSC
	$ciclovias=darCicloviasDSC2014();
	echo json_encode($ciclovias);
	exit();

}
else if(
isset($_POST['api']) && $_POST['api']=='ciclovia' &&
isset($_POST['id']) && !empty($_POST['id']) &&
(
		(isset($_POST['pass']) && $_POST['pass']==pass_api())
		||(isset($_POST['pass']) && $_POST['pass']==pass_api_mobil())
)
){
	//CICLOVIA
	$ciclovia=darCiclovia($_POST['id']);
	echo json_encode($ciclovia);
	exit();

}
else if(
		isset($_POST['api']) && $_POST['api']=='lugar' &&
		isset($_POST['id']) && !empty($_POST['id']) &&
		(
			(isset($_POST['pass']) && $_POST['pass']==pass_api())
			||(isset($_POST['pass']) && $_POST['pass']==pass_api_mobil())
			)
		){
	//LUGAR
	$sitio=darSitio($_POST['id'],1);
	$sitio[0]['nombre']=$sitio[0]['nombre'];
	$sitio[0]['descripcion']=$sitio[0]['descripcion'];
	$sitio[0]['direccion']=$sitio[0]['direccion'];
	$sitio[0]['telefono']=$sitio[0]['telefono'];
	$sitio[0]['nombrelimpio']=limpiar_texto($sitio[0]['nombre']);
	echo json_encode($sitio);
	exit();
	
}
else if(
		isset($_POST['api']) && $_POST['api']=='calificacion' &&
		isset($_POST['id']) && !empty($_POST['id']) &&
		(
				(isset($_POST['pass']) && $_POST['pass']==pass_api())
				||(isset($_POST['pass']) && $_POST['pass']==pass_api_mobil())
		)
){
	//CALIFICACIONES
	$calificacion=array("calificacion"=>darCalificacionSitio($_POST['id']),"numero_calificaciones"=>darNumCalificacionesSitio($_POST['id']));
	echo json_encode($calificacion);
	exit();

}
else if(
		isset($_POST['api']) && $_POST['api']=='calificar' &&
		isset($_POST['id']) && !empty($_POST['id']) &&
		(
				(isset($_POST['pass']) && $_POST['pass']==pass_api())
				||(isset($_POST['pass']) && $_POST['pass']==pass_api_mobil())
		)
){
	//CALIFICAR
	
	
	$usuario=darUsuarioFB($_POST['idFB']);
	$id=(int)$_POST['id'];
	$puntaje=(double)$_POST['calificacion'];
	if(!yaCalifico($id,$usuario)){
		if( calificar($usuario,$id,$puntaje) ) echo json_encode(array("mensaje"=>"Ok"));
		else echo json_encode(array("error"=>"Ocurrió un error al calificar"));
	}
	else echo json_encode(array("error"=>"Ya había calificado el sitio"));
	exit();

}
else if(
		isset($_POST['api']) && $_POST['api']=='barraandroid'
){
	setcookie('barra_android',time(),time() + (60*60*24*30*6)); //Expira en 6 meses
	$_SESSION['barra_android']=time();
	exit();

}
else if(
		isset($_POST['api']) && $_POST['api']=='guardarciudad'
		&& isset($_POST['ciudad'])
){
	setcookie('ciudadguardada',((int)$_POST['ciudad']),time() + (60*60*24*30*6)); //Expira en 6 meses
	$_SESSION['ciudadguardada']=((int)$_POST['ciudad']);
	echo $_SESSION['ciudadguardada'];
	exit();

}
else if( isset($_POST['api']) ){
	$error=array("error"=>"Funcion no existe");
	echo json_encode($error);
	exit();
}
else if( isset($_POST['pass']) && $_POST['pass']!=pass_api() ){
	$error=array("error"=>"Error de autenticaci&oacute;n");
	echo json_encode($error);
	exit();
}
/*
else {
	$error=array("error"=>"Error de autenticaci&oacute;n");
	echo json_encode($error);
	exit();
}
*/


?>
