<?php

// options
// index.php?mapscale=50K
// index.php?mapscale=25K
// index.php?easting=9000&northing=5000
//  where 
//      easting and northing is the location in metres


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
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");
if ($exit) {
    $maps = [];
    if ($mapscale !== null) {
        $maps = $db->getMapsScale($mapscale);
    }
} else {
    $east = intval($easting);
    $north = intval($northing);
    $maps = $db->getMapIds($east, $north);
}
//var_dump($maps);
echo json_encode($maps,JSON_PRETTY_PRINT|JSON_INVALID_UTF8_IGNORE);
$okay=json_last_error();
if ($okay!==JSON_ERROR_NONE){
   // var_dump($okay);
}
$db->closeConnection();