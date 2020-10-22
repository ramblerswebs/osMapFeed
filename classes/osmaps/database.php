<?php

/**
 * Description of database
 *
 * Table maps and mapbounds
 * @author Chris Vaughan
 */
class OsmapsDatabase extends Database {

//    private $tables = ["postcodes"];
//    private $sql = ["CREATE TABLE `postcodes` (
//  `postcode` varchar(8) NOT NULL,
//  `quality` tinyint(4) NOT NULL,
//  `easting` mediumint(9) NOT NULL,
//  `northing` mediumint(9) NOT NULL,
//  `updated` date DEFAULT NULL
//) ENGINE=InnoDB DEFAULT CHARSET=utf8; ",
//        "ALTER TABLE `postcodes`
//  ADD UNIQUE KEY `postcode` (`postcode`);"];

    public function __construct($dbconfig) {
        parent::__construct($dbconfig);
    }

    public function getMapIds($east, $north) {
        $allMaps = $this->getAllMaps();
        $where = " WHERE eastingmin<=" . $east . " AND eastingmax>=" . $east . " AND northingmin<=" . $north . " AND northingmax>=" . $north;
        $ok = parent::runQuery("SELECT * FROM mapbounds " . $where);
        if ($ok === false) {
            Logfile::writeError($this->db->ErrorMsg());
            return false;
        }
        $ids = parent::getResult();

        $maps = [];
        foreach ($ids as $key => $value) {
            $mapid = $value['mapid'];
            if (array_key_exists($mapid, $allMaps)) {
                $maps[] = $allMaps[$mapid];
            }
        }

        return $maps;
    }

    public function getAllMaps() {
        $ok = parent::runQuery("SELECT * FROM maps INNER JOIN mapbounds ON maps.id=mapbounds.mapid");
        if ($ok === false) {
            Logfile::writeError($this->db->ErrorMsg());
            return false;
        }
        $ids = parent::getResult();
        $maps = new maps;
        foreach ($ids as $key => $value) {
            $maps->addMap($value);
        }
        return $maps->maps;
    }

    public function connect() {
        parent::connect();
        //   parent::createTables($this->sql);
    }

    public function closeConnection() {
        parent::closeConnection();
    }

}
