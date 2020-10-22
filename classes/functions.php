<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of functions
 *
 * @author Chris Vaughan
 */
class Functions {

    public static function distance($x, $y, $x2, $y2) {
        $val = ($x - $x2) * ($x - $x2) + ($y - $y2) * ($y - $y2);
        $value = sqrt($val);
        return $value;
    }

    public static function sortOnDistance($array) {

        function cmp($a, $b) {
            if ($a->Distance == $b->Distance) {
                return 0;
            }
            return ($a->Distance < $b->Distance) ? -1 : 1;
        }

        usort($array, "cmp");
        return $array;
    }
     public static function removeCodesOnDistance($codes,$distance){
         foreach ($codes as $key => $code) {
             if ($code->Distance>$distance){
                 unset($codes[$key]);
             }
         }
         return $codes;
    }

}
