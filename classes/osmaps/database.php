<?php

/**
 * Description of database
 *
 * Table maps and mapbounds
 * @author Chris Vaughan
 */
class OsmapsDatabase extends Database {

    // bounds are stored in units of 100m

    public function __construct($dbconfig) {
        parent::__construct($dbconfig);
    }

    public function getMapIds($east, $north) {
        // bounds are stored in units of 100m
        $allMaps = $this->getAllMaps();
        $where = " WHERE eastingmin<=" . $this->changeTo100m($east) . " AND eastingmax>=" . $this->changeTo100m($east) . " AND northingmin<=" . $this->changeTo100m($north) . " AND northingmax>=" . $this->changeTo100m($north) . "";
        $ok = parent::runQuery("SELECT * FROM mapbounds " . $where);
        if ($ok === false) {
            //Logfile::writeError($this->db->ErrorMsg());
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
        // remove duplicate values
       return array_unique($maps,SORT_REGULAR );

        
    }
    private function changeTo100m($value){
        return substr($value, 0, strlen($value)-2);
    }

    public function getMapsScale($scale) {
        $allMaps = $this->getAllMaps();
        $maps = [];
        foreach ($allMaps as $key => $value) {
            $mapscale = $value->scale;
            if ($mapscale === '25000' AND $scale === '25K') {
                $maps[] = $allMaps[$key];
            }
            if ($mapscale === '50000' AND $scale === '50K') {
                $maps[] = $allMaps[$key];
            }
        }

        return $maps;
    }

    public function getAllMaps() {
        $ok = parent::runQuery("SELECT * FROM maps INNER JOIN mapbounds ON maps.id=mapbounds.mapid");
        if ($ok === false) {
            //Logfile::writeError($this->db->ErrorMsg());
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
