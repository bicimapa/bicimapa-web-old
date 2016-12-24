<?php 
session_start();

include_once('i18n_init.php');
include_once('i18n.php');


date_default_timezone_set('America/Bogota');// HORA DE BOGOT¡
error_reporting(0); //ELIMINA WARNINGS!

include_once('config.php');

function url_sitio(){return url().'sitio/';}
function url_administrador(){return url().'administrador/';}
function url_blog(){return url().'blog/';}
function url_directorio(){return url().'bicigente/';}
function url_calendario(){return url().'biciplanes/';}
function url_agregar(){return url().'agregar/';}
function url_buscar(){return url().'buscar/';}
function url_sugerir(){return url().'sugerir/';}
function url_sugerir_evento(){return url().'biciplanes_sugerir/';}
function url_api(){return url().'api/';}
function url_short(){return url().'s/';}
function url_iframe(){return url().'?t=iframe';}

//Lista de tipo de sitio o categorÌas
$tiposSitio2=array(
		'0'=>array(
				'nombre'=> tr('sin_definir'),
				'img'=>'img/marcador.png',
				'visible'=>false,
				'marcado'=>false,
				'agregable'=>true
		),
		'1'=>array(
				'nombre'=> tr('tienda'),
				'img'=>'img/tienda.png',
				'visible'=>true,
				'marcado'=>true,
				'agregable'=>true
		),
		'2'=>array(
				'nombre'=> tr('parqueadero'),
				'img'=>'img/parqueadero.png',
				'visible'=>true,
				'marcado'=>true,
				'agregable'=>true
		),
		'3'=>array(
				'nombre'=> tr('taller'),
				'img'=>'img/taller.png',
				'visible'=>true,
				'marcado'=>false,
				'agregable'=>true
		),
		'4'=>array(
				'nombre'=> tr('ruta'),
				'img'=>'img/ruta.png',
				'visible'=>true,
				'marcado'=>false,
				'agregable'=>true
		),
		'5'=>array(
				'nombre'=> tr('advertencia'),
				'img'=>'img/atencion.png',
				'visible'=>true,
				'marcado'=>false,
				'agregable'=>true
		),
		'6'=>array(
				'nombre'=> tr('el_bicitante'),
				'img'=>'img/elbicitante.png',
				'visible'=>true,
				'marcado'=>false,
				'agregable'=>false
		),
		'7'=>array(
				'nombre'=> tr('biciamigo'),
				'img'=>'img/biciamigo.png',
				'visible'=>true,
				'marcado'=>true,
				'agregable'=>true
		),
		'8'=>array(
				'nombre'=>'Otro',
				'img'=>'img/marcador.png',
				'visible'=>false,
				'marcado'=>false,
				'agregable'=>false
		),
		'9'=>array(
				'nombre'=>'Puntos Hidrataci&oacute;n D&iacute;a Sin Carro',
				'img'=>'img/punto_hidratacion.png',
				'visible'=>false,
				'marcado'=>false,
				'agregable'=>false
		),
		'10'=>array(
				'nombre'=>tr('alquiler'),
				'img'=>'img/alquiler.png',
				'visible'=>true,
				'marcado'=>false,
				'agregable'=>false
		)
		
);

/**
 * Retorna un tipo de sitio con id pasado como par·metro
 * @param int $tipo
 * @return array el tipo de sitio
 */
function darTipoSitio($tipo){
	global $tiposSitio2;
	$tipo=(int)$tipo;
	if(isset($tiposSitio2[$tipo])) return $tiposSitio2[$tipo];
	else return null;
}

//Tipo de sitio que es una ruta
function tipo_ruta(){return 4;}

//Tipo de sitio que es un parqueadero
function tipo_parqueadero(){return 2;}

//Lista de ciudades
$ciudades=array(
		array('Bogot&aacute;','bogota',4.65385,-74.058409,12),
		array('Medell&iacute;n','medellin',6.23749,-75.569458,13),
		array('Cali','cali',3.420551,-76.522007,13),
		array('Bucaramanga','bucaramanga',7.113839,-73.119164,13),
		array('Barranquilla','barranquilla',10.963775,-74.797325,13),
		array('Villavicencio','villavicencio',4.137558,-73.623848,14),
		array('Pasto','pasto',1.20772,-77.277145,14),
		array('Pereira','pereira',4.812779,-75.694685,14),
		array('Santa Marta','santa-marta',11.245082,-74.205694,14),
		array('Popay&aacute;n','popayan',2.450062,-76.616592,14),
		array('Zipaquir&aacute;','zipaquira',5.027762,-74.002104,14),
		array('Quibd&oacute;','quibdo',5.69226,-76.651697,14),
		array('Girardot','girardot',4.301992,-74.807024,14)
		
);
/**
 * N˙mero de resultados que se muestran por p·gina
 * @return number
 */
function resultados_por_pagina(){return 10;}

/**
 * Retorna un string con la respuesta del radio button
 * @return string
 */
function respuesta_radio_button($numero){
	$numero=(int)$numero;
	if($numero==1) return "S&iacute;";
	else if($numero==2) return "No";
	else return "No s&eacute;";
}

/**
 * Conectarse a la base de datos
 */
function Conectarse()
{
	//if (!($link=mysql_connect("localhost","root","")))
	if (!($link=mysql_connect(db_url(),db_user(),db_pass())))
	{
		imprimir_error("Error conectando a la base de datos.*".mysql_error());
		die();
	}
	if (!mysql_select_db(db_db(),$link))
	{
		imprimir_error("Error seleccionando la base de datos.");
		die();
	}
	return $link;
}

/**
 * limpia el cÛdigo de cosas maliciosas
 */
function cleanInput($input) {

	$search = array(
			'@<script[^>]*?>.*?</script>@siu',   // Strip out javascript
			'@<[\/\!]*?[^<>]*?>@siu',            // Strip out HTML tags
			'@<style[^>]*?>.*?</style>@siUu',    // Strip style tags properly
			'@<![\s\S]*?--[ \t\n\r]*>@u'         // Strip multi-line comments
	);

	$output = preg_replace($search, '', $input);
	return $output;
}

/**
 *  sanitizar
 */
function sanitize($input,$link=null) {
	if (is_array($input)) {
		foreach($input as $var=>$val) {
			$output[$var] = sanitize($val);
		}
	}
	else {
		if (get_magic_quotes_gpc()) {
			$input = stripslashes($input);
		}
		$input  = cleanInput($input);
		if($link!=null)$output = mysql_real_escape_string($input,$link);
		else $output = mysql_real_escape_string($input);
	}
	return $output;
}

/**
 * Convierte saltos de lÌnea unix a html
 */
function nl2br2($string) {
	$string = str_replace(array("\r\n", "\r", "\n"), "<br />", $string);
	return $string;
}

/**
 *  Comprobar email
 */
function comprobar_email($email){
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Removee caracteres extraÒos
 * @param string
 * @return string
 */
function limpiar_texto($s) {
	$result = preg_replace("/[^\p{L}\s\p{N}]/u", "", html_entity_decode($s, ENT_QUOTES));
	return $result;
}

/**
 * Convierte a formato UTF-8
 */
function sinTildesConMayusculas($texto){
	$l_match = array('/[‡‚‰Â„·¬ƒ¿≈√¡Ê∆]/','/[ﬂ]/','/[Á«]/','/[–]/','/[ÈËÍÎ… À»]/','/[ÔÓÏÌœŒÃÕ]/','/[Ò—]/','/[ˆÙÛÚı”‘÷“’]/','/[__]/','/[˘˚¸˙‹€Ÿ⁄]/','/[•_›_˝ˇ]/','/[__]/');
	$l_replace = array('a', 'b', 'c', 'd', 'e', 'i', 'n', 'o', 's', 'u', 'y', 'z');
	return preg_replace($l_match, $l_replace, $texto);
}

/**
 * Starts With
 * @param unknown $haystack
 * @param unknown $needle
 * @return boolean
 */
function startsWith($haystack, $needle)
{
	return $needle === "" || strpos($haystack, $needle) === 0;
}

/**
 * Ends With
 * @param unknown $haystack
 * @param unknown $needle
 * @return boolean
 */
function endsWith($haystack, $needle)
{
	return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}

/**
 * Imprimir un mensaje de Èxito
 * @param unknown $mensaje
 */
function imprimir_ok($mensaje){
	echo'
	<div class="row">
		<div class="large-12 columns">
			<div data-alert class="alert-box success">'.$mensaje.'</div>
		</div>
	</div>';
}

/**
 * Imprimir un mensaje de error
 * @param unknown $mensaje
 */
function imprimir_error($mensaje){
	echo'
	<div class="row">
		<div class="large-12 columns">
			<div data-alert class="alert-box alert">'.$mensaje.'</div>
		</div>
	</div>';
}

/**
 * Imprimir un mensaje genÈrico
 * @param unknown $mensaje
 */
function imprimir_mensaje($mensaje){
	echo'
	<div class="row">
		<div class="large-12 columns">
			<div data-alert class="alert-box">'.$mensaje.'</div>
		</div>
	</div>';
}

/**
 * Convertir fecha a texto amigable
 * @paramstring $fecha
 * @return string Texto amigable
 */
function fecha_a_texto($fecha){
	$fecha=strtotime($fecha);
	if(time()-$fecha<2*60*60) $fecha_text='Hace '.(int)((time()-$fecha)/(60)).' minutos';
	else if(time()-$fecha<=2*24*60*60) $fecha_text='Hace '.(int)((time()-$fecha)/(60*60)).' horas';
	else if(time()-$fecha<=2*30*24*60*60) $fecha_text='Hace '.(int)((time()-$fecha)/(60*60*24)).' d&iacute;as';
	else $fecha_text='Hace '.(int)((time()-$fecha)/(60*60*24*30)).' meses';
	
	return $fecha_text;
}


function idBeta($id) {
	$link=Conectarse();

	$id=(int)$id;

	$sql="SELECT id_beta FROM lugares WHERE id = $id LIMIT 1";

	$result=mysql_query($sql,$link);

	$row = mysql_fetch_row($result);

	if ($row) {
		return $row[0];
	}
	else {
		return NULL;
	}
}


/**
 * Retorna una lista de sitios
 * @param number $num, n˙mero de resultados por request
 * @param number $pagina, n˙mero de p·gina
 * @param number $id, id del sitio
 * @param string $nombre, nombre del sitio
 * @param string $quien. nombre o correo
 * @param unknown $aprobado, 1 si se quieren sÛlo sitios aprobados, 0 si se quieren solo sitios sin aprobar, -1 si se quieren todos los sitios
 * @return array Lista de sitios
 */
function darSitios($num=0,$pagina=0,$id=0,$nombre=null,$quien=null,$aprobado=-1){
	$num=(int)$num;
	if($num==0)$num=999999;
	
	$pagina=(int)$pagina;
	$id=(int)$id;
	
	$link=Conectarse();
	$sitios=array();
	
	if($pagina>0)$offset=($num*$pagina).",";
	else $offset="";
	
	$param=array();
	
	if($id>0)$param[]="id='".$id."' ";
	if($nombre!=null)$param[]="nombre LIKE '%".$nombre."%' ";
	if($quien!=null)$param[]="(quien LIKE '%".$quien."%' OR email LIKE '%".$quien."%') ";
	if($aprobado>=0)$param[]="aprobado='".$aprobado."' ";
	
	if(count($param)<1)$param[]="1=1 ";
	
	$sql="SELECT * FROM lugares WHERE ".implode('AND ',$param)." ORDER BY fecha DESC LIMIT ".$offset.$num."";
	
	$result=mysql_query($sql,$link);
	if(mysql_num_rows($result)<=0) $sitios=null;
	else{
		while($row = mysql_fetch_assoc($result)){
			$sitios[]=$row;
		}
	}
	mysql_free_result($result);
	mysql_close($link);

	return $sitios;
}

/**
 * Dar los $num sitios m·s cercanos a una ubicaciÛn especÌfica
 * @param $num numero de sitios a retornar
 * @param $lat
 * @param $long
 * @return Lista de Sitios
 */
function darSitiosCercanos($num=0,$lat,$long){
	
	$maxDistancia=0.02;//Distancia en grados. 1 grado=110km. 0.02=2.2km
	
	$num=(int)$num;
	if($num==0)$num=10;

	$link=Conectarse();
	$sitios=array();

	if($pagina>0)$offset=($num*$pagina).",";
	else $offset="";

	$sql="SELECT *, ( POW(latitud-(".$lat."),2) + POW(longitud-(".$long."),2) ) as distancia FROM lugares WHERE (latitud-(".$lat."))<".$maxDistancia." AND (longitud-(".$long."))<".$maxDistancia." ORDER BY distancia ASC LIMIT ".$num."";
	
	//echo'<!-- '.$sql.' -->';

	$result=mysql_query($sql,$link);
	if(mysql_num_rows($result)<=0) $sitios=null;
	else{
		while($row = mysql_fetch_assoc($result)){
			$sitios[]=$row;
		}
	}
	mysql_free_result($result);
	mysql_close($link);

	return $sitios;
}

/**
 * Retorna una lista de sistios aprobados
 * @param number $num
 * @param unknown $tipo, array con la lista de tipos de sistios deseados
 * @param number $api, 1 si es un llamado desde el api
 * @return Ambigous <NULL, multitype:multitype: >
 */
function darSitiosAprobados($num=0,$tipo=-1,$api=0){
	if($num==0)$num=999999;
	$link=Conectarse();
	$num=(int)$num;
	$sitios=array();
	
	if( is_array($tipo) ){
		$sqltipo="AND (";
		for($i=0;$i<count($tipo);$i++){
			if( $i<(count($tipo)-1) ) $sqltipo.="tipo='".$tipo[$i]."' OR ";
			else $sqltipo.="tipo='".$tipo[$i]."'";
		}
		$sqltipo.=")";
	}
	else if( $tipo>=0 ) $sqltipo="AND tipo='$tipo'";
	else $sqltipo="";
	
	if($api==1) $campos="`id`, `nombre`, `descripcion`, `direccion`, `telefono`, `horario`, `latitud`, `longitud`, `tipo`, `ruta`, `candado`,`cubierto`,`tarifa`,`cupos`,`fecha_inicio`,`fecha_fin`, `fecha_modificacion`";
	else $campos="*";

	$sql="SELECT ".$campos." FROM lugares WHERE aprobado='1' AND fecha_inicio < CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-05:00') AND fecha_fin > CONVERT_TZ(UTC_TIMESTAMP(),'+00:00','-05:00') ".$sqltipo." LIMIT $num";
	$result=mysql_query($sql,$link);
	if(mysql_num_rows($result)<=0) $sitios=null;
	else{
		while($row = mysql_fetch_assoc($result)){
			$sitios[]=$row;
		}
	}
	mysql_free_result($result);
	mysql_close($link);

	return $sitios;
}

/**
 * Retorna una lista de sistios aprobados
 * @param int $fecha timestamp
 * @return Ambigous <NULL, multitype:multitype: >
 */
function darSitiosAprobadosCambios($fecha){
	$link=Conectarse();
	$sitios=array();
	
	$fecha=(int)$fecha;
	
	$sqlfecha = date("Y-m-d H:i:s",$fecha);

	$campos="`id`, `nombre`, `descripcion`, `direccion`, `telefono`, `horario`, `latitud`, `longitud`, `tipo`, `ruta`, `candado`,`cubierto`,`tarifa`,`cupos`,`fecha_inicio`,`fecha_fin`, `fecha_modificacion`";

	$sql="SELECT ".$campos." FROM lugares WHERE aprobado='1' AND fecha_modificacion > CONVERT_TZ('".$sqlfecha."','+00:00','-05:00')";
	$result=mysql_query($sql,$link);
	if(mysql_num_rows($result)<=0) $sitios=null;
	else{
		while($row = mysql_fetch_assoc($result)){
			$sitios[]=$row;
		}
	}
	mysql_free_result($result);
	mysql_close($link);

	return $sitios;
}


/**
 * Retorna u sitio
 * @param unknown $id del sitio
 * @param number $api, 1 si es un llamado desde el api
 * @return array
 */
function darSitio($id,$api=0){

	$link=Conectarse();
	$id=(int)$id;
	
	if($api==1) $campos="`id`, `nombre`, `descripcion`, `direccion`, `telefono`, `horario`, `latitud`, `longitud`, `tipo`, `ruta`, `candado`,`cubierto`,`tarifa`,`cupos`";
	else $campos="*";

	$sql="SELECT ".$campos." FROM lugares WHERE aprobado=1 AND id='$id' LIMIT 1";
	$result=mysql_query($sql,$link);
	if(mysql_num_rows($result)<=0) $sitios=null;
	else{
		while($row = mysql_fetch_assoc($result)){
			$sitios[]=$row;
		}
	}
	mysql_free_result($result);
	mysql_close($link);

	return $sitios;
}



/**
 * Retorna una lista de ciclorrutas
 * @return array
 */
function darCiclorrutas(){

	$link=Conectarse();

	$sitios=array();

	$sql="SELECT * FROM ciclorrutas";

	$result=mysql_query($sql,$link);
	if(mysql_num_rows($result)<=0) $sitios=null;
	else{
		while($row = mysql_fetch_assoc($result)){
			$sitios[]=$row;
		}
	}
	mysql_free_result($result);
	mysql_close($link);

	return $sitios;
}

/**
 * Retorna una ciclorrut seg˙n su id
 * @param $id
 * @return array la ciclorruta
 */
function darCiclorruta($id){

	$link=Conectarse();
	$id=(int)$id;

	$sql="SELECT * FROM ciclorrutas WHERE id='$id' LIMIT 1";
	$result=mysql_query($sql,$link);
	while($row = mysql_fetch_assoc($result)){
		mysql_free_result($result);
		mysql_close($link);
		return $row;
	}
	mysql_free_result($result);
	mysql_close($link);

	return null;
}

/**
 * Retorna una lista de ciclovias
 * @return array
 */
function darCiclovias(){

	$link=Conectarse();

	$sitios=array();

	$sql="SELECT * FROM ciclovias";

	$result=mysql_query($sql,$link);
	if(mysql_num_rows($result)<=0) $sitios=null;
	else{
		while($row = mysql_fetch_assoc($result)){
			$sitios[]=$row;
		}
	}
	mysql_free_result($result);
	mysql_close($link);

	return $sitios;
}

/**
 * Retorna una lista de ciclovias del dÌa sin carro 2014
 * @return array
 */
function darCicloviasDSC2014(){

	$link=Conectarse();

	$sitios=array();

	$sql="SELECT * FROM cicloviasDSC2014";

	$result=mysql_query($sql,$link);
	if(mysql_num_rows($result)<=0) $sitios=null;
	else{
		while($row = mysql_fetch_assoc($result)){
			$sitios[]=$row;
		}
	}
	mysql_free_result($result);
	mysql_close($link);

	return $sitios;
}

/**
 * Retorna una ciclovia seg˙n su id
 * @param $id
 * @return array la ciclovia
 */
function darCiclovia($id){

	$link=Conectarse();
	$id=(int)$id;

	$sql="SELECT * FROM ciclovias WHERE id='$id' LIMIT 1";
	$result=mysql_query($sql,$link);
	while($row = mysql_fetch_assoc($result)){
		mysql_free_result($result);
		mysql_close($link);
		return $row;
	}
	mysql_free_result($result);
	mysql_close($link);

	return null;
}

/**
 * Retorna la bicigente
 * @param: $order 0=categoria,1=ciudad
 */
function darBicigente($orden=0){

	$link=Conectarse();

	$sitios=array();

	if($orden<=0)$sql="SELECT * FROM bicigente ORDER BY tipo ASC,ciudad ASC";
	else $sql="SELECT * FROM bicigente ORDER BY ciudad ASC,tipo ASC";

	$result=mysql_query($sql,$link);
	if(mysql_num_rows($result)<=0) $sitios=null;
	else{
		while($row = mysql_fetch_assoc($result)){
			$sitios[]=$row;
		}
	}
	mysql_free_result($result);
	mysql_close($link);

	return $sitios;
}


/**
 * Agregar un sitio
 * @param string $nombre
 * @param string $direccion
 * @param string $telefono
 * @param string $horario
 * @param string $descripcion
 * @param double $latitud
 * @param double $longitud
 * @param integer $tipo
 * @param string $quien
 * @param string $email
 * @param integer $autorizacion
 * @param string $ruta
 * @param integer $candado
 * @param integer $cubierto
 * @param string $tarifa
 * @param string $cupos
 * @return boolean
 */
function agregar($nombre,$direccion,$telefono,$horario,$descripcion,$latitud,$longitud,$tipo,$quien,$email,$autorizacion,$ruta="",$candado=0,$cubierto=0,$tarifa="",$cupos=""){
	$link=Conectarse();

	$info=$_SERVER['REMOTE_ADDR']." - ".$_SERVER['HTTP_USER_AGENT'];
	
	$sql="INSERT INTO lugares (`id`, `nombre`, `descripcion`, `direccion`, `telefono`, `horario`, `latitud`, `longitud`, `tipo`, `quien`, `email`, `autorizacion`, `info`, `fecha_modificacion`, `ruta`,`candado`,`cubierto`,`tarifa`,`cupos`) 
			VALUES (NULL, '".sanitize(($nombre))."', '".sanitize(($descripcion))."', '".sanitize(($direccion))."', '".sanitize(($telefono))."', '".sanitize(($horario))."', '".sanitize($latitud)."', '".sanitize($longitud)."', '$tipo', '".sanitize(($quien))."', '".sanitize(($email))."', '".$autorizacion."', '".$info."', CURRENT_TIMESTAMP, '".sanitize(($ruta))."','".((int)$candado)."','".((int)$cubierto)."','".sanitize(($tarifa))."','".sanitize(($cupos))."')";
	
	
	if(mysql_query($sql,$link)){
		$id=mysql_insert_id();
		email_nuevaSugerencia($nombre,$id);
		mysql_close($link);
		return true;
	}
	else{
		mysql_close($link);
		return false;
	}
	
	
}

/**
 * Agregar una ciclorruta
 * @param unknown $nombre
 * @param unknown $descripcion
 * @param string $ruta
 * @return boolean
 */
function agregarCiclorruta($nombre,$descripcion,$ruta=""){
	$link=Conectarse();

	$sql="INSERT INTO ciclorrutas (`id`, `nombre`, `descripcion`, `fecha_modificacion`, `ruta`)
			VALUES (NULL, '".sanitize(($nombre))."', '".sanitize(($descripcion))."', CURRENT_TIMESTAMP, '".sanitize(($ruta))."')";

	if(mysql_query($sql,$link)){
		$id=mysql_insert_id();
		mysql_close($link);
		return true;
	}
	else{
		mysql_close($link);
		return false;
	}


}

/**
 * Correo de notificaciÛn de nueva sugerencia
 */
function CorreoNotificacion(){
	$msg = "Alguien sugiriÛ un nuevo sitio para el bicimapa."."\n";
	$msg .= "----------------------------------------------\n";
	$msg .= url_administrador()."\n";
	$msg .= "----------------------------------------------\n";
	$msg .= "Fecha: ".date(DATE_RFC822)."\n";
	$msg .= "IP: ".$_SERVER['REMOTE_ADDR']." - http://www.geoiptool.com/es/?IP=".$_SERVER['REMOTE_ADDR']."\n";
	$msg .= "USER AGENT: ".$_SERVER['HTTP_USER_AGENT']."\n";
	
	$headers = 'From: ' . email_admin() . "\r\n" .
			'Reply-To: ' . email_admin() . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
	
	$mail_sent = @mail(email_admin(),'[Bicimapa] Nueva Sitio Sugerido',$msg,$headers);
}

/**
 * Calificar un sitio
 * @param unknown $usuario
 * @param unknown $id
 * @param unknown $calificacion
 * @return boolean
 */
function calificar($usuario,$id,$calificacion){
	$link=Conectarse();

	$id=(int)$id;
	$usuario=(int)$usuario;
	$calificacion=(double)$calificacion;
	
	$info=$_SERVER['REMOTE_ADDR']." - ".$_SERVER['HTTP_USER_AGENT'];

	$sql="INSERT INTO calificaciones (`id`, `usuario`, `sitio`, `calificacion`, `fecha`, `info`) VALUES (NULL, '$usuario', '$id', '$calificacion', CURRENT_TIMESTAMP, '$info')";

	if(mysql_query($sql,$link)){
		mysql_close($link);
		return true;
	}
	else{
		mysql_close($link);
		return false;
	}
}

/**
 * Retorna la calificaciÛn de un sitio
 * @param unknown $id
 * @return number
 */
function darCalificacionSitio($id){

	$link=Conectarse();
	$id=(int)$id;
	$calificacion=0;

	$sql="SELECT AVG(`calificacion`) as calificacion FROM `calificaciones` WHERE sitio='$id'";
	$result=mysql_query($sql,$link);
	while($row = mysql_fetch_assoc($result)){
		$calificacion=$row['calificacion'];
	}
	mysql_free_result($result);
	mysql_close($link);

	return $calificacion;
}

/**
 * Retorna las calificaciones de un usuario
 * @param unknown $id
 * @return number
 */
function darCalificacionesUsuario($id){

	$link=Conectarse();
	$id=(int)$id;
	
	$calificaciones=null;

	$sql="SELECT * FROM `calificaciones` WHERE usuario='$id' ORDER BY fecha DESC";
	$result=mysql_query($sql,$link);
	while($row = mysql_fetch_assoc($result)){
		$calificaciones[]=$row;
	}
	mysql_free_result($result);
	mysql_close($link);

	return $calificaciones;
}

/**
 * Retorna true si existe una calificaciÛn del usuario en un sitio
 * @param unknown $sitio
 * @param unknown $usuario
 * @return boolean
 */
function yaCalifico($sitio,$usuario){

	$link=Conectarse();
	$id=(int)$id;
	$usuario=(int)$usuario;
	$respuesta=false;

	$sql="SELECT * FROM `calificaciones` WHERE sitio='$sitio' AND usuario='$usuario' LIMIT 1";
	$result=mysql_query($sql,$link);
	if(mysql_num_rows($result)<=0) $respuesta=false;
	else $respuesta=true;
	
	mysql_free_result($result);
	mysql_close($link);

	return $respuesta;
}

/**
 * Retorna el n˙mero de calificaciones registradas en un sitio
 * @param unknown $id
 * @return number
 */
function darNumCalificacionesSitio($id){

	$link=Conectarse();
	$id=(int)$id;
	$calificacion=0;

	$sql="SELECT COUNT(*) as numero FROM `calificaciones` WHERE sitio='$id'";
	$result=mysql_query($sql,$link);
	while($row = mysql_fetch_assoc($result)){
		$calificacion=$row['numero'];
	}
	mysql_free_result($result);
	mysql_close($link);

	return $calificacion;
}

/**
 * Dar el usuario
 * @param $id
 * @return NULL o el usuario
 */
function darUsuario($id){

	$link=Conectarse();
	$id=(int)$id;

	$usuario=null;

	$sql="SELECT * FROM usuarios WHERE id='$id' LIMIT 1";
	$result=mysql_query($sql,$link);
	while($row = mysql_fetch_assoc($result)){
		$usuario=$row;
	}
	mysql_free_result($result);
	mysql_close($link);

	return $usuario;

}

/**
 * Dar el usuario
 * @param $email
 * @return NULL o el usuario
 */
function darUsuarioEmail($email){

	$link=Conectarse();

	$usuario=null;

	$sql="SELECT * FROM usuarios WHERE correo='".sanitize($email)."' LIMIT 1";
	$result=mysql_query($sql,$link);
	while($row = mysql_fetch_assoc($result)){
		$usuario=$row;
	}
	mysql_free_result($result);
	mysql_close($link);

	return $usuario;

}

/**
 * Retorna el id de un usuario a partir del Id de facebook. Si no existe lo guarda como usuario
 * @param unknown $id
 * @return boolean|NULL
 */
function darUsuarioFB($id){
	
	$link=Conectarse();
	$id=(int)$id;
	
	
	$usuario=null;
	
	$sql="SELECT * FROM usuarios WHERE fbid='$id' LIMIT 1";
	$result=mysql_query($sql,$link);
	if(mysql_num_rows($result)<=0){
		//No existe en la bd	
		agregarUsuario("", $id, "", "");
		$usuario=darUsuarioFB($id);
	}
	else{
		while($row = mysql_fetch_assoc($result)){
			$usuario=$row['id'];
		}
	}
	mysql_free_result($result);
	mysql_close($link);
	
	return $usuario;
	
}

/**
 * Agregar un usuario
 * @param unknown $nombre
 * @param unknown $fbid
 * @param unknown $correo
 * @param unknown $imagen
 * @return boolean
 */
function agregarUsuario($nombre, $fbid, $correo, $imagen){

	$link=Conectarse();
	
	$fbid=(int)$fbid;
	$info=$_SERVER['REMOTE_ADDR']." - ".$_SERVER['HTTP_USER_AGENT'];

	if($fbid>0 && empty($nombre)){
		if($graphapi=json_decode( file_get_contents("https://graph.facebook.com/".$id."/") )){
			if(isset($graphapi["name"]) && !empty($graphapi["name"])) $nombre=$graphapi["name"];
		}
	}
	
	if($fbid>0 && empty($imagen)){
		$imagen="https://graph.facebook.com/".$id."/picture";
	}
	
	$sql="INSERT INTO usuarios (`id`, `nombre`, `fbid`, `correo`, `imagen`, `fecha`, `info`) VALUES (NULL, '".sanitize($nombre)."', '".$fbid."', '".sanitize($correo)."', '".sanitize($imagen)."', CURRENT_TIMESTAMP, '".$info."');";
	
	if(mysql_query($sql,$link)){
		mysql_close($link);
		return true;
	}
	else{
		mysql_close($link);
		return false;
	}
}

/**
 * EnvÌar una notificaciÛn de email cuando se aprueba un sitio
 * @param unknown $correo
 * @param unknown $nombre
 * @param unknown $nombresitio
 * @param unknown $id
 */
function email_aprobado($correo,$nombre,$nombresitio,$id){
	
	if(empty($nombre)) $nombre="Hola";

	$uri = 'https://mandrillapp.com/api/1.0/messages/send-template.json';

	$postString = '{
    "key": "oC8pt8gB1DxrS9bSAMLJxg",
    "template_name": "aprobado",
    "template_content": [
        {
            "name": "example name",
            "content": "example content"
        }
    ],
    "message": {
        "subject": "Sugerencia aprobada en el Bicimapa",
        "to": [
            {
                "email": "'.$correo.'",
                "name": "Administrador"
            }
        ],
        "headers": {
            "Reply-To": "'.email_admin().'"
        },
        "global_merge_vars": [
            {
                "name": "NOMBRESITIO",
                "content": "'.$nombresitio.'"
            },
            {
                "name": "URLSITIO",
                "content": "'.url_sitio().$id.'"
            },
            {
                "name": "NOMBRE",
                "content": "'.$nombre.'"
            }
        ],
        "important": false,
        "track_opens": null,
        "track_clicks": null,
        "auto_text": null,
        "auto_html": null,
        "inline_css": null,
        "url_strip_qs": null,
        "preserve_recipients": null,
        "view_content_link": null,
        "tracking_domain": null,
        "signing_domain": null,
        "return_path_domain": null
    }
}';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $uri);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);

	$result = curl_exec($ch);

	//echo $result;
}

/**
 * EnvÌa una notificaciÛn de email cuando se sugiere un nuevo sitio
 * @param unknown $nombre
 * @param unknown $id
 */
function email_nuevaSugerencia($nombre,$id){
	
	$uri = 'https://mandrillapp.com/api/1.0/messages/send-template.json';
	
	$postString = '{
    "key": "oC8pt8gB1DxrS9bSAMLJxg",
    "template_name": "nueva-sugerencia",
	"template_content": [
        {
            "name": "example name",
            "content": "example content"
        }
    ],
    "message": {
        "subject": "Nueva Sugerencia en el Bicimapa",
        "to": [
            {
                "email": "'.email_admin().'",
                "name": "Administrador"
            }
        ],
        "headers": {
            "Reply-To": "'.email_admin().'"
        },
        "global_merge_vars": [
            {
                "name": "NOMBRESITIO",
                "content": "'.$nombre.'"
            },
            {
                "name": "URLSITIO",
                "content": "'.url_administrador().$id.'"
            }
        ],
        "important": false,
        "track_opens": null,
        "track_clicks": null,
        "auto_text": null,
        "auto_html": null,
        "inline_css": null,
        "url_strip_qs": null,
        "preserve_recipients": null,
        "view_content_link": null,
        "tracking_domain": null,
        "signing_domain": null,
        "return_path_domain": null
    }
}';
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $uri);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
	
	$result = curl_exec($ch);
	
	//echo $result;
}


/**
 * Obtener el Facebook Id desde la URL
 * @param $url
 * @return The ID
 */
function darFacebookId($url){
	$subpartes=explode('?',$url);
	$url = str_replace("?directed_target_id=0", "", $subpartes[0]);
	$partes=explode('/',$url);
	$num=count($partes);
	if($num>=1) return $partes[$num-1];
	else return "";
}

/**
 * Agregar un Evento
 * @param unknown $nombre
 * @param unknown $correo
 * @param unknown $nombreevento
 * @param unknown $colectivo
 * @param unknown $fecha
 * @param unknown $horainicio
 * @param unknown $fechafinal
 * @param unknown $horafinal
 * @param unknown $descripcion
 * @param unknown $ciudad
 * @param unknown $lugar
 * @param unknown $web
 * @param unknown $ip
 * @param unknown $useragent
 * @return boolean
 */
function agregarEvento($nombre,$correo,$nombreevento,$colectivo,$fecha,$horainicio,$fechafinal,$horafinal,$descripcion,$ciudad,$lugar,$web,$ip,$useragent){
	$link=Conectarse();

	$sql="INSERT INTO eventos
	(`id`, `nombre`, `correo`, `nombrevento`, `colectivo`, `fecha`, `horainicio`, `fechafinal`, `horafinal`, `descripcion`, `ciudad`, `lugar`, `web`, `fechasugerencia`, `ip`, `useragent`)
	VALUES (NULL, '".sanitize(($nombre))."', '".sanitize(($correo))."', '".sanitize(($nombreevento))."', '".sanitize(($colectivo))."', '".sanitize(($fecha))."', '".sanitize(($horainicio))."', '".sanitize(($fechafinal))."', '".sanitize(($horafinal))."', '".sanitize(($descripcion))."', '".sanitize(($ciudad))."', '".sanitize(($lugar))."', '".sanitize(($web))."', CURRENT_TIMESTAMP, '".sanitize(($ip))."', '".sanitize(($useragent))."')";
	if(mysql_query($sql,$link)){
		$id=mysql_insert_id();
		mysql_close($link);
		return true;
	}
	else{
		mysql_close($link);
		return false;
	}


}


/**
 * Retorna la direcciÛn larga de una short url
 * @param $short url
 * @return url
 */
function darLongUrl($short){

	$link=Conectarse();

	$sql="SELECT url FROM short_url WHERE short='".sanitize($short,$link)."' LIMIT 1";
	$result=mysql_query($sql,$link);
	while($row = mysql_fetch_assoc($result)){
		mysql_free_result($result);
		mysql_close($link);
		return $row['url'];
	}
	mysql_free_result($result);
	mysql_close($link);

	return null;
}


/**
 * Return the Latitude, longitude and zoom for a country code
 * @param unknown $country_code
 * @return Ambigous <multitype:string >|multitype:string
 */
function countryLatLongZoom($country_code){
	$countries=array(
			"AD"=>array("42.5000","1.5000","6"),
			"AE"=>array("24.0000","54.0000","6"),
			"AF"=>array("33.0000","65.0000","6"),
			"AG"=>array("17.0500","-61.8000","6"),
			"AI"=>array("18.2500","-63.1667","6"),
			"AL"=>array("41.0000","20.0000","6"),
			"AM"=>array("40.0000","45.0000","6"),
			"AN"=>array("12.2500","-68.7500","6"),
			"AO"=>array("-12.5000","18.5000","6"),
			"AP"=>array("35.0000","105.0000","6"),
			"AQ"=>array("-90.0000","0.0000","6"),
			"AR"=>array("-34.0000","-64.0000","6"),
			"AS"=>array("-14.3333","-170.0000","6"),
			"AT"=>array("47.3333","13.3333","6"),
			"AU"=>array("-27.0000","133.0000","6"),
			"AW"=>array("12.5000","-69.9667","6"),
			"AZ"=>array("40.5000","47.5000","6"),
			"BA"=>array("44.0000","18.0000","6"),
			"BB"=>array("13.1667","-59.5333","6"),
			"BD"=>array("24.0000","90.0000","6"),
			"BE"=>array("50.8333","4.0000","6"),
			"BF"=>array("13.0000","-2.0000","6"),
			"BG"=>array("43.0000","25.0000","6"),
			"BH"=>array("26.0000","50.5500","6"),
			"BI"=>array("-3.5000","30.0000","6"),
			"BJ"=>array("9.5000","2.2500","6"),
			"BM"=>array("32.3333","-64.7500","6"),
			"BN"=>array("4.5000","114.6667","6"),
			"BO"=>array("-17.0000","-65.0000","6"),
			"BR"=>array("-10.0000","-55.0000","6"),
			"BS"=>array("24.2500","-76.0000","6"),
			"BT"=>array("27.5000","90.5000","6"),
			"BV"=>array("-54.4333","3.4000","6"),
			"BW"=>array("-22.0000","24.0000","6"),
			"BY"=>array("53.0000","28.0000","6"),
			"BZ"=>array("17.2500","-88.7500","6"),
			"CA"=>array("60.0000","-95.0000","4"),
			"CC"=>array("-12.5000","96.8333","6"),
			"CD"=>array("0.0000","25.0000","6"),
			"CF"=>array("7.0000","21.0000","6"),
			"CG"=>array("-1.0000","15.0000","6"),
			"CH"=>array("47.0000","8.0000","6"),
			"CI"=>array("8.0000","-5.0000","6"),
			"CK"=>array("-21.2333","-159.7667","6"),
			"CL"=>array("-30.0000","-71.0000","5"),
			"CM"=>array("6.0000","12.0000","6"),
			"CN"=>array("35.0000","105.0000","4"),
			"CO"=>array("4.0000","-72.0000","6"),
			"CR"=>array("10.0000","-84.0000","8"),
			"CU"=>array("21.5000","-80.0000","7"),
			"CV"=>array("16.0000","-24.0000","6"),
			"CX"=>array("-10.5000","105.6667","6"),
			"CY"=>array("35.0000","33.0000","6"),
			"CZ"=>array("49.7500","15.5000","6"),
			"DE"=>array("51.0000","9.0000","6"),
			"DJ"=>array("11.5000","43.0000","6"),
			"DK"=>array("56.0000","10.0000","6"),
			"DM"=>array("15.4167","-61.3333","6"),
			"DO"=>array("19.0000","-70.6667","8"),
			"DZ"=>array("28.0000","3.0000","6"),
			"EC"=>array("-2.0000","-77.5000","7"),
			"EE"=>array("59.0000","26.0000","6"),
			"EG"=>array("27.0000","30.0000","6"),
			"EH"=>array("24.5000","-13.0000","6"),
			"ER"=>array("15.0000","39.0000","6"),
			"ES"=>array("40.0000","-4.0000","6"),
			"ET"=>array("8.0000","38.0000","6"),
			"EU"=>array("47.0000","8.0000","6"),
			"FI"=>array("64.0000","26.0000","6"),
			"FJ"=>array("-18.0000","175.0000","6"),
			"FK"=>array("-51.7500","-59.0000","6"),
			"FM"=>array("6.9167","158.2500","6"),
			"FO"=>array("62.0000","-7.0000","6"),
			"FR"=>array("46.0000","2.0000","6"),
			"GA"=>array("-1.0000","11.7500","6"),
			"GB"=>array("54.0000","-2.0000","6"),
			"GD"=>array("12.1167","-61.6667","6"),
			"GE"=>array("42.0000","43.5000","6"),
			"GF"=>array("4.0000","-53.0000","6"),
			"GH"=>array("8.0000","-2.0000","6"),
			"GI"=>array("36.1833","-5.3667","6"),
			"GL"=>array("72.0000","-40.0000","6"),
			"GM"=>array("13.4667","-16.5667","6"),
			"GN"=>array("11.0000","-10.0000","6"),
			"GP"=>array("16.2500","-61.5833","6"),
			"GQ"=>array("2.0000","10.0000","6"),
			"GR"=>array("39.0000","22.0000","6"),
			"GS"=>array("-54.5000","-37.0000","6"),
			"GT"=>array("15.5000","-90.2500","8"),
			"GU"=>array("13.4667","144.7833","6"),
			"GW"=>array("12.0000","-15.0000","6"),
			"GY"=>array("5.0000","-59.0000","6"),
			"HK"=>array("22.2500","114.1667","6"),
			"HM"=>array("-53.1000","72.5167","6"),
			"HN"=>array("15.0000","-86.5000","7"),
			"HR"=>array("45.1667","15.5000","6"),
			"HT"=>array("19.0000","-72.4167","6"),
			"HU"=>array("47.0000","20.0000","6"),
			"ID"=>array("-5.0000","120.0000","6"),
			"IE"=>array("53.0000","-8.0000","6"),
			"IL"=>array("31.5000","34.7500","6"),
			"IN"=>array("20.0000","77.0000","5"),
			"IO"=>array("-6.0000","71.5000","6"),
			"IQ"=>array("33.0000","44.0000","6"),
			"IR"=>array("32.0000","53.0000","6"),
			"IS"=>array("65.0000","-18.0000","6"),
			"IT"=>array("42.8333","12.8333","6"),
			"JM"=>array("18.2500","-77.5000","6"),
			"JO"=>array("31.0000","36.0000","6"),
			"JP"=>array("36.0000","138.0000","6"),
			"KE"=>array("1.0000","38.0000","6"),
			"KG"=>array("41.0000","75.0000","6"),
			"KH"=>array("13.0000","105.0000","6"),
			"KI"=>array("1.4167","173.0000","6"),
			"KM"=>array("-12.1667","44.2500","6"),
			"KN"=>array("17.3333","-62.7500","6"),
			"KP"=>array("40.0000","127.0000","6"),
			"KR"=>array("37.0000","127.5000","6"),
			"KW"=>array("29.3375","47.6581","6"),
			"KY"=>array("19.5000","-80.5000","6"),
			"KZ"=>array("48.0000","68.0000","6"),
			"LA"=>array("18.0000","105.0000","6"),
			"LB"=>array("33.8333","35.8333","6"),
			"LC"=>array("13.8833","-61.1333","6"),
			"LI"=>array("47.1667","9.5333","6"),
			"LK"=>array("7.0000","81.0000","6"),
			"LR"=>array("6.5000","-9.5000","6"),
			"LS"=>array("-29.5000","28.5000","6"),
			"LT"=>array("56.0000","24.0000","6"),
			"LU"=>array("49.7500","6.1667","6"),
			"LV"=>array("57.0000","25.0000","6"),
			"LY"=>array("25.0000","17.0000","6"),
			"MA"=>array("32.0000","-5.0000","6"),
			"MC"=>array("43.7333","7.4000","6"),
			"MD"=>array("47.0000","29.0000","6"),
			"ME"=>array("42.0000","19.0000","6"),
			"MG"=>array("-20.0000","47.0000","6"),
			"MH"=>array("9.0000","168.0000","6"),
			"MK"=>array("41.8333","22.0000","6"),
			"ML"=>array("17.0000","-4.0000","6"),
			"MM"=>array("22.0000","98.0000","6"),
			"MN"=>array("46.0000","105.0000","6"),
			"MO"=>array("22.1667","113.5500","6"),
			"MP"=>array("15.2000","145.7500","6"),
			"MQ"=>array("14.6667","-61.0000","6"),
			"MR"=>array("20.0000","-12.0000","6"),
			"MS"=>array("16.7500","-62.2000","6"),
			"MT"=>array("35.8333","14.5833","6"),
			"MU"=>array("-20.2833","57.5500","6"),
			"MV"=>array("3.2500","73.0000","6"),
			"MW"=>array("-13.5000","34.0000","6"),
			"MX"=>array("23.0000","-102.0000","6"),
			"MY"=>array("2.5000","112.5000","6"),
			"MZ"=>array("-18.2500","35.0000","6"),
			"NA"=>array("-22.0000","17.0000","6"),
			"NC"=>array("-21.5000","165.5000","6"),
			"NE"=>array("16.0000","8.0000","6"),
			"NF"=>array("-29.0333","167.9500","6"),
			"NG"=>array("10.0000","8.0000","6"),
			"NI"=>array("13.0000","-85.0000","7"),
			"NL"=>array("52.5000","5.7500","6"),
			"NO"=>array("62.0000","10.0000","6"),
			"NP"=>array("28.0000","84.0000","6"),
			"NR"=>array("-0.5333","166.9167","6"),
			"NU"=>array("-19.0333","-169.8667","6"),
			"NZ"=>array("-41.0000","174.0000","6"),
			"OM"=>array("21.0000","57.0000","6"),
			"PA"=>array("9.0000","-80.0000","8"),
			"PE"=>array("-10.0000","-76.0000","6"),
			"PF"=>array("-15.0000","-140.0000","6"),
			"PG"=>array("-6.0000","147.0000","6"),
			"PH"=>array("13.0000","122.0000","6"),
			"PK"=>array("30.0000","70.0000","6"),
			"PL"=>array("52.0000","20.0000","6"),
			"PM"=>array("46.8333","-56.3333","6"),
			"PR"=>array("18.2500","-66.5000","9"),
			"PS"=>array("32.0000","35.2500","6"),
			"PT"=>array("39.5000","-8.0000","6"),
			"PW"=>array("7.5000","134.5000","6"),
			"PY"=>array("-23.0000","-58.0000","6"),
			"QA"=>array("25.5000","51.2500","6"),
			"RE"=>array("-21.1000","55.6000","6"),
			"RO"=>array("46.0000","25.0000","6"),
			"RS"=>array("44.0000","21.0000","6"),
			"RU"=>array("60.0000","100.0000","3"),
			"RW"=>array("-2.0000","30.0000","6"),
			"SA"=>array("25.0000","45.0000","6"),
			"SB"=>array("-8.0000","159.0000","6"),
			"SC"=>array("-4.5833","55.6667","6"),
			"SD"=>array("15.0000","30.0000","6"),
			"SE"=>array("62.0000","15.0000","6"),
			"SG"=>array("1.3667","103.8000","6"),
			"SH"=>array("-15.9333","-5.7000","6"),
			"SI"=>array("46.0000","15.0000","6"),
			"SJ"=>array("78.0000","20.0000","6"),
			"SK"=>array("48.6667","19.5000","6"),
			"SL"=>array("8.5000","-11.5000","6"),
			"SM"=>array("43.7667","12.4167","6"),
			"SN"=>array("14.0000","-14.0000","6"),
			"SO"=>array("10.0000","49.0000","6"),
			"SR"=>array("4.0000","-56.0000","6"),
			"ST"=>array("1.0000","7.0000","6"),
			"SV"=>array("13.8333","-88.9167","9"),
			"SY"=>array("35.0000","38.0000","6"),
			"SZ"=>array("-26.5000","31.5000","6"),
			"TC"=>array("21.7500","-71.5833","6"),
			"TD"=>array("15.0000","19.0000","6"),
			"TF"=>array("-43.0000","67.0000","6"),
			"TG"=>array("8.0000","1.1667","6"),
			"TH"=>array("15.0000","100.0000","6"),
			"TJ"=>array("39.0000","71.0000","6"),
			"TK"=>array("-9.0000","-172.0000","6"),
			"TM"=>array("40.0000","60.0000","6"),
			"TN"=>array("34.0000","9.0000","6"),
			"TO"=>array("-20.0000","-175.0000","6"),
			"TR"=>array("39.0000","35.0000","6"),
			"TT"=>array("11.0000","-61.0000","6"),
			"TV"=>array("-8.0000","178.0000","6"),
			"TW"=>array("23.5000","121.0000","6"),
			"TZ"=>array("-6.0000","35.0000","6"),
			"UA"=>array("49.0000","32.0000","6"),
			"UG"=>array("1.0000","32.0000","6"),
			"UM"=>array("19.2833","166.6000","6"),
			"US"=>array("38.0000","-97.0000","4"),
			"UY"=>array("-33.0000","-56.0000","7"),
			"UZ"=>array("41.0000","64.0000","6"),
			"VA"=>array("41.9000","12.4500","6"),
			"VC"=>array("13.2500","-61.2000","6"),
			"VE"=>array("8.0000","-66.0000","6"),
			"VG"=>array("18.5000","-64.5000","6"),
			"VI"=>array("18.3333","-64.8333","6"),
			"VN"=>array("16.0000","106.0000","6"),
			"VU"=>array("-16.0000","167.0000","6"),
			"WF"=>array("-13.3000","-176.2000","6"),
			"WS"=>array("-13.5833","-172.3333","6"),
			"YE"=>array("15.0000","48.0000","6"),
			"YT"=>array("-12.8333","45.1667","6"),
			"ZA"=>array("-29.0000","24.0000","6"),
			"ZM"=>array("-15.0000","30.0000","6"),
			"ZW"=>array("-20.0000","30.0000")
	);
	
	
	if(isset($countries[$country_code])) return $countries[$country_code];
	else return array("28.505725","-34.8567554","3");
}






?>
