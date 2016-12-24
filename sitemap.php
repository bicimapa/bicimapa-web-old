<?php
$isoLastModifiedSite = "";
$newLine = "\n";
$indent = " ";
$rootUrl = "http://www.bicimapa.com";

$xmlHeader = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>$newLine";


$urlsetOpen = "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.9\"
xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"
xsi:schemaLocation=\"http://www.google.com/schemas/sitemap/0.9
http://www.google.com/schemas/sitemap/0.9/sitemap.xsd\">$newLine";
$urlsetValue = "";
$urlsetClose = "</urlset>$newLine";

function makeUrlString ($urlString) {
    return htmlentities($urlString, ENT_QUOTES, 'UTF-8');
}

function makeIso8601TimeStamp ($dateTime) {
    if (!$dateTime) {
        $dateTime = date('Y-m-d H:i:s');
    }
    return $dateTime;
}

function makeUrlTag ($url, $modifiedDateTime, $changeFrequency, $priority) {
    GLOBAL $newLine;
    GLOBAL $indent;
    GLOBAL $isoLastModifiedSite;
    $urlOpen = "$indent<url>$newLine";
    $urlValue = "";
    $urlClose = "$indent</url>$newLine";
    $locOpen = "$indent$indent<loc>";
    $locValue = "";
    $locClose = "</loc>$newLine";
    $lastmodOpen = "$indent$indent<lastmod>";
    $lastmodValue = "";
    $lastmodClose = "</lastmod>$newLine";
    $changefreqOpen = "$indent$indent<changefreq>";
    $changefreqValue = "";
    $changefreqClose = "</changefreq>$newLine";
    $priorityOpen = "$indent$indent<priority>";
    $priorityValue = "";
    $priorityClose = "</priority>$newLine";

    $urlTag = $urlOpen;
    $urlValue     = $locOpen .makeUrlString($url) .$locClose;
    if ($modifiedDateTime) {
     $urlValue .= $lastmodOpen .makeIso8601TimeStamp($modifiedDateTime) .$lastmodClose;
     if (!$isoLastModifiedSite) { // last modification of web site
         $isoLastModifiedSite = makeIso8601TimeStamp($modifiedDateTime);
     }
    }
    if ($changeFrequency) {
     $urlValue .= $changefreqOpen .$changeFrequency .$changefreqClose;
    }
    if ($priority) {
     $urlValue .= $priorityOpen .$priority .$priorityClose;
    }
    $urlTag .= $urlValue;
    
    $urlTag .= $urlClose;
    return $urlTag;
}




if (!$isoLastModifiedSite) { // last modification of web site
    $isoLastModifiedSite = makeIso8601TimeStamp(date('Y-m-d'));
}





include_once('funciones.php');

//------------------------------------------------------------------------------

$urlsetValue .= makeUrlTag ("$rootUrl/", $isoLastModifiedSite, "Weekly", "1");
$urlsetValue .= makeUrlTag ("$rootUrl/bicigente/", $isoLastModifiedSite, "Weekly", "0.8");
$urlsetValue .= makeUrlTag ("$rootUrl/biciplanes/", $isoLastModifiedSite, "Weekly", "0.8");
$urlsetValue .= makeUrlTag ("$rootUrl/blog/", $isoLastModifiedSite, "Weekly", "0.8");
$urlsetValue .= makeUrlTag ("$rootUrl/bicimapa.php", $isoLastModifiedSite, "Weekly", "0.5");
$urlsetValue .= makeUrlTag ("$rootUrl/terminos-y-condiciones/", $isoLastModifiedSite, "Weekly", "0.5");
$urlsetValue .= makeUrlTag ("$rootUrl/sugerencias/", $isoLastModifiedSite, "Weekly", "0.5");


//------------------------------------------------------------------------------

$sitios=darSitiosAprobados();
foreach($sitios as $sitio){
	$urlsetValue .= makeUrlTag (url_sitio().$sitio['id'], $isoLastModifiedSite, "Weekly", "0.5");
}

//------------------------------------------------------------------------------

header('Content-type: application/xml; charset="utf-8"',true);
print "$xmlHeader
$urlsetOpen
$urlsetValue
$urlsetClose
";


?>