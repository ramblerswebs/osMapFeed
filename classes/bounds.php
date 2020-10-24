<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bounds
 *
 * @author Chris Vaughan
 */
class bounds {

    public $eastingmin, $northingmin, $eastingmax, $northingmax;

    public function __construct($eastingmin, $northingmin, $eastingmax, $northingmax) {
        $this->eastingmin = $eastingmin."00";
        $this->northingmin = $northingmin."00";
        $this->eastingmax = $eastingmax."00";
        $this->northingmax = $northingmax."00";
    }

}
