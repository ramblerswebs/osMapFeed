<?php

// options
// index.php?easting=394120&northing=806540&dist=1&maxpoints=1000
//  where 
//      easting and northing is the location
//      dist is distance from location in Km
//      maxpoints is the maximum number for points to return
// index.php?postcode=de221jt
//  where 
//      postcode is the postcode!
// task.php scheduled task to update postcodes from OS datasets


error_reporting(-1);
ini_set('display_errors', 'On');
if (file_exists("config.php")) {
    require_once 'config.php';
} else {
    require_once 'configtest.php';
}

require_once 'classes/autoload.php';
spl_autoload_register('autoload');
$config = new Config();
$db = new OsmapsDatabase($config->database);
$db->connect();
if (!$db->connected()) {
    OsmapEmail::send("OS Map: Unable to connect to database", $db->error());
}
$opts = new Options();

$easting = $opts->gets("easting");
$northing = $opts->gets("northing");
$mapscale = $opts->gets("mapscale");



$exit = false;
if ($easting === null) {
    $exit = true;
}
if ($northing === null) {
    $exit = true;
}


if ($exit) {
    $maps = [];
    if ($mapscale !== null) {
        $maps = $db->getMapsScale($mapscale);
    }

    header("Access-Control-Allow-Origin: *");
    header("Content-type: application/json");
    echo json_encode($maps);

    $db->closeConnection();

    exit;
}
$east = intval($easting);
$north = intval($northing);
$maps = $db->getMapIds($east, $north);
//   $postcodes = $pcs->getCodes($easting, $northing, $distance * 1000, $maxpoints);
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");
echo json_encode($maps);

$db->closeConnection();
