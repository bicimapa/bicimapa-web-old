<?php

$locale = "ES"; // por defecto es espanol

$languages=array("ES","FR","EN");


function langByCountry($country_code){
	//Paises que hablan inglés
	$en_countries=array("AD","AE","AF","AG","AI","AL","AM","AO","AP","AQ","AS","AT","AU","AW","AX","AZ","BA","BB","BD","BE","BF","BG","BH","BI","BJ","BL","BM","BN","BQ","BS","BT","BV","BW","BY","BZ","CA","CC","CD","CF","CG","CH","CI","CK","CM","CN","CV","CW","CX","CY","CZ","DE","DJ","DK","DM","DZ","EE","EG","EH","ER","ET","EU","FI","FJ","FK","FM","FO","GA","GB","GD","GE","GG","GH","GI","GL","GM","GN","GP","GQ","GR","GS","GU","GW","GY","HK","HM","HR","HT","HU","ID","IE","IL","IM","IN","IO","IQ","IR","IS","IT","JE","JM","JO","JP","KE","KG","KH","KI","KM","KN","KP","KR","KW","KY","KZ","LA","LB","LC","LI","LK","LR","LS","LT","LU","LV","LY","MA","MC","MD","ME","MF","MG","MH","MK","ML","MM","MN","MO","MP","MQ","MR","MS","MT","MU","MV","MW","MY","MZ","NA","NC","NE","NF","NG","NL","NO","NP","NR","NU","NZ","OM","PF","PG","PH","PK","PL","PM","PN","PS","PT","PW","QA","RE","RO","RS","RU","RW","SA","SB","SC","SD","SE","SG","SH","SI","SJ","SK","SL","SM","SN","SO","SR","SS","ST","SX","SY","SZ","TC","TD","TG","TH","TJ","TK","TL","TM","TN","TO","TR","TT","TV","TW","TZ","UA","UG","UM","US","UZ","VA","VC","VG","VI","VN","VU","WF","WS","YE","YT","ZA","ZM","ZW");
	//Paises que hablan francés
	$fr_countries=array("FR","GF","TF");
	
	if ( in_array($country_code,$fr_countries) ) $_SESSION["locale"] = "FR";
	else if ( in_array($country_code,$en_countries) ) $_SESSION["locale"] = "EN";
	else $_SESSION["locale"] = "ES";
}


if (empty($_SESSION["locale"])) {


	if(isset($_GET['country']) && !empty($_GET['country']) && strlen($_GET['country'])==2){
		$country_code=preg_replace('/\PL/u', '', $_GET['country']);	
		$_SESSION["country"] = $country_code;
	}
	else {

		include_once('geoip.inc');
		
		$gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);
		$ip = $_SERVER['REMOTE_ADDR'];
		
		$country_code = geoip_country_code_by_addr($gi, $ip);
		geoip_close($gi);
		//País
		$_SESSION["country"] = $country_code;
	}
	
	
	if( isset($_GET['lang']) && in_array($_GET['lang'], $languages)){
	
		if(strtolower($_GET['lang'])=="fr") $_SESSION["locale"]="FR";
		if(strtolower($_GET['lang'])=="es") $_SESSION["locale"]="ES";
		if(strtolower($_GET['lang'])=="en") $_SESSION["locale"]="EN";
	
	}
	else langByCountry($country_code);
	
}
else {
	
	if(isset($_GET['country']) && !empty($_GET['country']) && strlen($_GET['country'])==2){
		$country_code=preg_replace('/\PL/u', '', $_GET['country']);
		$_SESSION["country"] = $country_code;
		langByCountry($country_code);
	}
	
	if( isset($_GET['lang']) ){
	
		if(strtolower($_GET['lang'])=="fr") $_SESSION["locale"]="FR";
		if(strtolower($_GET['lang'])=="es") $_SESSION["locale"]="ES";
		if(strtolower($_GET['lang'])=="en") $_SESSION["locale"]="EN";
	
	}

	$locale = $_SESSION["locale"];
	

}

?>
