<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of maps
 *
 * @author Chris Vaughan
 */
class maps {

    public $maps = [];

    public function addMap($values) {
        $no = $values['mapid'];
        $type = $values['type'];
        $scale = $values['scale'];
        $number = $values['mapnumber'];
        $title = $values['title'];

        $map = $this->setMap($no, $type, $scale, $number, $title);
        $eastingmin = $values['eastingmin'];
        $northingmin = $values['northingmin'];
        $eastingmax = $values['eastingmax'];
        $northingmax = $values['northingmax'];
        $bounds = new bounds($eastingmin, $northingmin, $eastingmax, $northingmax);
        $map->addBounds($bounds);
    }

    private function setMap($no, $type, $scale, $number, $title) {
        $exists = array_key_exists($no, $this->maps);
        if ($exists) {
            return $this->maps[$no];
        } else {
            $map = new map($type, $scale, $number, $title);
            $this->maps[$no] = $map;
        }
        return $map;
    }

}
