<?php
function url(){return"http://www.bicimapa.com/";}

function email_admin(){return 'info@bicimapa.com';}

function db_url(){return"localhost";}
function db_user(){return"bicimapa";}
function db_pass(){return"bicimapa";}
function db_db(){return"bicimapa";}

function pass_api(){return sha1( 'bicimapaWeb'.date('Ymd') );}
function pass_api_mobil(){return sha1('bicimapaApp'.date('Ymd'));}
?>
