<?php 
include_once('../funciones.php');

function url_administrador_sitios(){return url_administrador().'sitios.php';}
function url_administrador_bicigente(){return url_administrador().'gente.php';}
function url_administrador_ciclorrutas(){return url_administrador().'ciclorrutas.php';}
function url_administrador_ciclovias(){return url_administrador().'ciclovias.php';}
function url_administrador_short(){return url_administrador().'short.php';}
function url_administrador_widgets(){return url_administrador().'widgets.php';}

function aprobar($id){
	$link=Conectarse();

	$id=(int)$id;

	$sql="UPDATE lugares SET aprobado = '1', fecha_modificacion = CURRENT_TIMESTAMP WHERE id = $id LIMIT 1";

	if(mysql_query($sql,$link)){

		//Notificar
		$sql="SELECT email,quien,nombre FROM `lugares` WHERE id='$id' AND email_aprobado<1 LIMIT 1";
		$result=mysql_query($sql,$link);
		while($row = mysql_fetch_array($result)){
			if(!empty($row[0])){
				email_aprobado($row[0],$row[1],$row[2],$id);
				mysql_query("UPDATE lugares SET email_aprobado = '1' WHERE id ='$id'",$link);
			}
		}
		mysql_free_result($result);
		mysql_close($link);

		return true;
	}
	else{
		mysql_close($link);
		return false;
	}
}

function desaprobar($id){
	$link=Conectarse();

	$id=(int)$id;

	$sql="UPDATE lugares SET aprobado = '0', fecha_modificacion = CURRENT_TIMESTAMP WHERE id = $id LIMIT 1";

	if(mysql_query($sql,$link)){
		mysql_close($link);
		return true;
	}
	else{
		mysql_close($link);
		return false;
	}
}

function borrar($id){
	$link=Conectarse();

	$id=(int)$id;

	$respuesta=false;

	if(mysql_query("INSERT INTO lugares_borrados SELECT * FROM lugares WHERE id='".$id."'",$link)){
		if(mysql_query("DELETE FROM lugares WHERE id = '".$id."' LIMIT 1",$link)) $respuesta=true;
	}

	mysql_close($link);
	return $respuesta;
}

function editar($id,$nombre,$direccion,$telefono,$horario,$descripcion,$latitud,$longitud,$tipo,$quien,$email,$candado,$cubierto,$tarifa,$cupos,$fecha_inicio,$fecha_fin){
	$link=Conectarse();

	$id=(int)$id;

	//Dejar registro del cambio
	mysql_query("INSERT INTO lugares_cambios SELECT * FROM lugares WHERE id='".$id."'",$link);

	$sql="UPDATE lugares SET `nombre`='".sanitize($nombre)."', `descripcion`='".$descripcion."', `direccion`='".sanitize($direccion)."', `telefono`='".sanitize($telefono)."', `horario`='".sanitize($horario)."',
			`latitud`='".sanitize($latitud)."', `longitud`='".sanitize($longitud)."', `tipo`='$tipo', `quien`='".sanitize($quien)."', `email`='".sanitize($email)."',`fecha_modificacion`= CURRENT_TIMESTAMP,
			`candado`='".sanitize($candado)."',`cubierto`='".sanitize($cubierto)."',`tarifa`='".sanitize($tarifa)."',`cupos`='".sanitize($cupos)."',`fecha_inicio`='".sanitize($fecha_inicio)."',
			`fecha_fin`='".sanitize($fecha_fin)."' WHERE `id` ='".$id."' LIMIT 1";


	if(mysql_query($sql,$link)){
		mysql_close($link);
		return true;
	}
	else{
		//echo $sql.'***'.mysql_error($link);
		mysql_close($link);
		return false;
	}


}

function borrar_contacto($id){
	$link=Conectarse();
	
	$id=(int)$id;
	
	$respuesta=false;
	
	if(mysql_query("INSERT INTO bicigente_borrados SELECT * FROM bicigente WHERE id='".$id."'",$link)){
		if(mysql_query("DELETE FROM bicigente WHERE id = '".$id."' LIMIT 1",$link)) $respuesta=true;
	}
	
	mysql_close($link);
	return $respuesta;
}


function editar_contacto($id,$nombre,$ciudad,$tipo,$facebook,$twitter,$web,$imagen="",$descripcion=""){
	$link=Conectarse();
	
	$id=(int)$id;
	
	//Dejar registro del cambio
	mysql_query("INSERT INTO bicigente_cambios SELECT * FROM bicigente WHERE id='".$id."'",$link);
	
	$sql="UPDATE bicigente SET `nombre`='".sanitize($nombre)."', `ciudad`='".sanitize($ciudad)."', `tipo`='".sanitize($tipo)."', `facebook`='".sanitize($facebook)."', `twitter`='".sanitize($twitter)."', `web`='".sanitize($web)."', `imagen`='".sanitize($imagen)."', `descripcion`='".sanitize($descripcion)."', `fecha_modificacion`= CURRENT_TIMESTAMP WHERE `id` ='".$id."' LIMIT 1";
	
	
	if(mysql_query($sql,$link)){
		mysql_close($link);
		return true;
	}
	else{
		//echo $sql.'***'.mysql_error($link);
		mysql_close($link);
		return false;
	}
}

function agregar_contacto($nombre,$ciudad,$tipo,$facebook,$twitter,$web,$imagen="",$descripcion=""){
	$link=Conectarse();

	$sql="INSERT INTO bicigente (`id`, `ciudad`, `tipo`, `nombre`, `facebook`, `twitter`, `web`, `imagen`, `descripcion`, `fecha_modificacion`) 
			VALUES (null, '".sanitize($ciudad)."', '".sanitize($tipo)."', '".sanitize($nombre)."', '".sanitize($facebook)."', '".sanitize($twitter)."', '".sanitize($web)."', '".sanitize($imagen)."', '".sanitize($descripcion)."', CURRENT_TIMESTAMP )";


	if(mysql_query($sql,$link)){
		mysql_close($link);
		return true;
	}
	else{
		//echo $sql.'***'.mysql_error($link);
		mysql_close($link);
		return false;
	}
}

/**
 * Agregar una ciclorruta
 * @param string $nombre
 * @param string $descripcion
 * @param string $ruta
 * @return boolean
 */
function agregar_ciclorruta($nombre,$descripcion,$ruta){
	$link=Conectarse();

	$sql="INSERT INTO ciclorrutas (`id`, `nombre`, `descripcion`, `ruta`, `fecha_modificacion`)
			VALUES (null, '".sanitize($nombre)."', '".sanitize($descripcion)."', '".sanitize($ruta)."', CURRENT_TIMESTAMP )";


	if(mysql_query($sql,$link)){
		mysql_close($link);
		return true;
	}
	else{
		//echo $sql.'***'.mysql_error($link);
		mysql_close($link);
		return false;
	}
}

/**
 * Editar una ciclorruta
 * @param int $id
 * @param string $nombre
 * @param string $descripcion
 * @param string $ruta
 * @return boolean
 */
function editar_ciclorruta($id,$nombre,$descripcion,$ruta){
	$link=Conectarse();
	
	//Dejar registro del cambio
	mysql_query("INSERT INTO ciclorrutas_cambios SELECT * FROM ciclorrutas WHERE id='".$id."'",$link);

	$sql="UPDATE ciclorrutas SET `nombre`='".sanitize($nombre)."', `descripcion`='".sanitize($descripcion)."', `ruta`='".sanitize($ruta)."', `fecha_modificacion`=CURRENT_TIMESTAMP WHERE `id` ='".$id."' LIMIT 1";


	if(mysql_query($sql,$link)){
		mysql_close($link);
		return true;
	}
	else{
		//echo $sql.'***'.mysql_error($link);
		mysql_close($link);
		return false;
	}
}

/**
 * Borrarr una ciclorruta
 * @param int $id
 * @return boolean
 */
function borrar_ciclorruta($id){
	$link=Conectarse();

	$id=(int)$id;

	$respuesta=false;

	if(mysql_query("INSERT INTO ciclorrutas_borrados SELECT * FROM ciclorrutas WHERE id='".$id."'",$link)){
		if(mysql_query("DELETE FROM ciclorrutas WHERE id = '".$id."' LIMIT 1",$link)) $respuesta=true;
	}

	mysql_close($link);
	return $respuesta;
}

/**
 * Retorna el número de ciclorrutas
 * @return array
 */
function darNumeroCiclorrutas(){

	$link=Conectarse();
	$sql="SELECT COUNT(*) FROM ciclorrutas";
	$result=mysql_query($sql,$link);
	while($row = mysql_fetch_array($result)){
		$num=$row[0];
		mysql_free_result($result);
		mysql_close($link);
		return $num;
	}
	mysql_free_result($result);
	mysql_close($link);
	return 0;
}

/**
 * Agregar una ciclovia
 * @param string $nombre
 * @param string $descripcion
 * @param string $ruta
 * @return boolean
 */
function agregar_ciclovia($nombre,$descripcion,$ruta){
	$link=Conectarse();

	$sql="INSERT INTO ciclovias (`id`, `nombre`, `descripcion`, `ruta`, `fecha_modificacion`)
			VALUES (null, '".sanitize($nombre)."', '".sanitize($descripcion)."', '".sanitize($ruta)."', CURRENT_TIMESTAMP )";


	if(mysql_query($sql,$link)){
		mysql_close($link);
		return true;
	}
	else{
		//echo $sql.'***'.mysql_error($link);
		mysql_close($link);
		return false;
	}
}

/**
 * Editar una ciclovia
 * @param int $id
 * @param string $nombre
 * @param string $descripcion
 * @param string $ruta
 * @return boolean
 */
function editar_ciclovia($id,$nombre,$descripcion,$ruta){
	$link=Conectarse();

	//Dejar registro del cambio
	mysql_query("INSERT INTO ciclovias_cambios SELECT * FROM ciclovias WHERE id='".$id."'",$link);

	$sql="UPDATE ciclovias SET `nombre`='".sanitize($nombre)."', `descripcion`='".sanitize($descripcion)."', `ruta`='".sanitize($ruta)."', `fecha_modificacion`=CURRENT_TIMESTAMP WHERE `id` ='".$id."' LIMIT 1";


	if(mysql_query($sql,$link)){
		mysql_close($link);
		return true;
	}
	else{
		//echo $sql.'***'.mysql_error($link);
		mysql_close($link);
		return false;
	}
}

/**
 * Borrarr una ciclovia
 * @param int $id
 * @return boolean
 */
function borrar_ciclovia($id){
	$link=Conectarse();

	$id=(int)$id;

	$respuesta=false;

	if(mysql_query("INSERT INTO ciclovias_borrados SELECT * FROM ciclovias WHERE id='".$id."'",$link)){
		if(mysql_query("DELETE FROM ciclovias WHERE id = '".$id."' LIMIT 1",$link)) $respuesta=true;
	}

	mysql_close($link);
	return $respuesta;
}

/**
 * Retorna el número de ciclovias
 * @return array
 */
function darNumeroCiclovias(){

	$link=Conectarse();
	$sql="SELECT COUNT(*) FROM ciclovias";
	$result=mysql_query($sql,$link);
	while($row = mysql_fetch_array($result)){
		$num=$row[0];
		mysql_free_result($result);
		mysql_close($link);
		return $num;
	}
	mysql_free_result($result);
	mysql_close($link);
	return 0;
}

/**
 * Retorna el número de calificaciones
 * @return int
 */
function darNumeroCalificaciones(){

	$link=Conectarse();
	$sql="SELECT COUNT(*) FROM calificaciones";
	$result=mysql_query($sql,$link);
	while($row = mysql_fetch_array($result)){
		$num=$row[0];
		mysql_free_result($result);
		mysql_close($link);
		return $num;
	}
	mysql_free_result($result);
	mysql_close($link);
	return 0;
}

function darNumeroUsuarios(){

	$link=Conectarse();
	$sql="SELECT COUNT(*) FROM usuarios";
	$result=mysql_query($sql,$link);
	while($row = mysql_fetch_array($result)){
		$num=$row[0];
		mysql_free_result($result);
		mysql_close($link);
		return $num;
	}
	mysql_free_result($result);
	mysql_close($link);
	return 0;
}

function darNumeroSitios(){

	$link=Conectarse();
	$sql="SELECT COUNT(*) FROM lugares";
	$result=mysql_query($sql,$link);
	while($row = mysql_fetch_array($result)){
		$num=$row[0];
		mysql_free_result($result);
		mysql_close($link);
		return $num;
	}
	mysql_free_result($result);
	mysql_close($link);
	return 0;
}

function darUltimasCalificaciones($numero){
	$numero=(int)$numero;
	$link=Conectarse();
	$ultimos=array();
	$sql="SELECT c.*,l.nombre as nombre FROM calificaciones c JOIN lugares l on c.sitio=l.id ORDER BY fecha DESC LIMIT ".$numero;
	$result=mysql_query($sql,$link);
	while($row = mysql_fetch_assoc($result)){
		$ultimos[]=$row;
	}
	mysql_free_result($result);
	mysql_close($link);
	return $ultimos;
}

function darUltimosSitios($numero){
	$numero=(int)$numero;
	$link=Conectarse();
	$ultimos=array();
	$sql="SELECT * FROM lugares ORDER BY fecha DESC LIMIT ".$numero;
	$result=mysql_query($sql,$link);
	while($row = mysql_fetch_assoc($result)){
		$ultimos[]=$row;
	}
	mysql_free_result($result);
	mysql_close($link);
	return $ultimos;
}

/**
 * Retorna la gráfica de la distribución de tipos de sitios
 * @return string
 */
function darGraficaTipoSitios(){
	$datos=array();
	$datos[]="['Tipo','numero']";
	$link=Conectarse();
	$sql="SELECT tipo,count(*) as num FROM `lugares` group by `tipo`";
	$result=mysql_query($sql,$link);
	while($row = mysql_fetch_assoc($result)){
		$tipo=darTipoSitio($row['tipo']);
		if($tipo!=null) $eltipo=$tipo['nombre'];
		else $eltipo="Otro";
		$datos[]="['".$eltipo."',".$row['num']."]";
	}
	mysql_free_result($result);
	mysql_close($link);
	
	$grafica="
	google.setOnLoadCallback(graficaTipoSitios);
	function graficaTipoSitios() {
        var data = google.visualization.arrayToDataTable([
          ".implode(",\n          ",$datos)."
        ]);

        var options = {
          title: 'Tipo de sitios',
          legend: 'none'
        };

        var chart = new google.visualization.PieChart(document.getElementById('graficaTipoSitios'));
        chart.draw(data, options);
    }
	";
	return $grafica;
}

/**
 * Retorna la gráfica de eventos de los últimos días
 * @return string
 */
function darGraficaEventos($dias){
	$dias=(int)$dias;
	if($dias<=0)$dias=10;
	
	
	//Inicializar los días incluidos
	$arraydias=array();
	for($j=$dias;$j>=0;$j--){
		$fecha=date('d/m',strtotime( '-'.$j.' day' ));
		$arraydias[$fecha]=array('sitios'=>0,'calificaciones'=>0);
	}
	
	
	//Encabezado
	$datos=array();
	$datos[]="['Dia','Nuevos Sitios','Nuevas Calificaciones']";
	
	
	//Actualizar el número de sitios por día
	$link=Conectarse();
	$sql="SELECT date(fecha) as fecha,count(*) as num FROM `lugares` WHERE fecha >= ( CURDATE() - INTERVAL ".($dias)." DAY ) group by date(fecha)";
	$result=mysql_query($sql,$link);
	while($row = mysql_fetch_assoc($result)){
		
		$fecha=date('d/m', strtotime( $row['fecha'] ) );
		$arraydias[$fecha]['sitios']=$row['num'];

	}
	mysql_free_result($result);

	
	//Actualizar el número de sitios por día
	$sql="SELECT date(fecha) as fecha,count(*) as num FROM `calificaciones` WHERE fecha >= ( CURDATE() - INTERVAL ".($dias)." DAY ) group by date(fecha)";
	$result=mysql_query($sql,$link);
	while($row = mysql_fetch_assoc($result)){
	
		$fecha=date('d/m', strtotime( $row['fecha'] ) );
		$arraydias[$fecha]['calificaciones']=$row['num'];
	
	}
	mysql_free_result($result);
	mysql_close($link);
	
	
	
	//Convertir días en tablas
	foreach ($arraydias as $k=>$arraydia) $datos[]="['".$k."',".$arraydia['sitios'].",".$arraydia['calificaciones']."]";
	

	$grafica="
	google.setOnLoadCallback(graficaEventos);
	function graficaEventos() {
        var data = google.visualization.arrayToDataTable([
          ".implode(",\n          ",$datos)."
        ]);

        var options = {
          title: 'Eventos',
          legend: { position: 'right' }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('graficaEventos'));          		
        chart.draw(data, options);
    }
	";
	return $grafica;
}

/**
 * Retorna las direcciones larga de una short url
 * @param $short url
 * @return url
 */
function darLongUrls(){
	$link=Conectarse();
	$ultimos=array();
	$sql="SELECT * FROM short_url ORDER BY fecha DESC";
	$result=mysql_query($sql,$link);
	while($row = mysql_fetch_assoc($result)){
		$ultimos[]=$row;
	}
	mysql_free_result($result);
	mysql_close($link);
	return $ultimos;
}

function agregar_short_url($short,$url){
	$link=Conectarse();

	$sql="INSERT INTO short_url (`id`, `short`, `url`, `fecha`) VALUES (NULL, '".sanitize($short)."', '".sanitize($url)."', CURRENT_TIMESTAMP)";


	if(mysql_query($sql,$link)){
		mysql_close($link);
		return true;
	}
	else{
		//echo $sql.'***'.mysql_error($link);
		mysql_close($link);
		return false;
	}
}

function borrar_short_url($id){
	$link=Conectarse();

	$id=(int)$id;

	$respuesta=false;

	if(mysql_query("INSERT INTO short_url_borrados SELECT * FROM short_url WHERE id='".$id."'",$link)){
		if(mysql_query("DELETE FROM short_url WHERE id = '".$id."' LIMIT 1",$link)) $respuesta=true;
	}

	mysql_close($link);
	return $respuesta;
}

function editar_short_url($id,$short,$url){
	$link=Conectarse();
	
	$id=(int)$id;

	//Dejar registro del cambio
	mysql_query("INSERT INTO short_url_cambios SELECT * FROM short_url WHERE id='".$id."'",$link);

	$sql="UPDATE short_url SET `short`='".sanitize($short)."', `url`='".sanitize($url)."', `fecha`=CURRENT_TIMESTAMP WHERE `id` ='".$id."' LIMIT 1";


	if(mysql_query($sql,$link)){
		mysql_close($link);
		return true;
	}
	else{
		//echo $sql.'***'.mysql_error($link);
		mysql_close($link);
		return false;
	}
}
?>