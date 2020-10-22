<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of map
 *
 * @author Chris Vaughan
 */
class map {
    public $type;
    public $scale;
    public $number;
    public $title;
    public $bounds=[];
    public function __construct($type, $scale, $number, $title) {
        $this->type=$type;
        $this->scale=$scale;
        $this->number=$number;
        $this->title=$title;
    }
    public function addBounds($bounds){
        $this->bounds[]=$bounds;
    }
}
