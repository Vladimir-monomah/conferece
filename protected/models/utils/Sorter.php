<?php

/**
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class Sorter {

    //  устойчивая сортировка по возрастанию
    //  stable sorting ascending
    public static function sort(&$arr,$class, $method){
        $comparator=new $class;
        $count=count($arr);
        for($i=0; $i<$count; $i++){
            for($j=$i+1; $j<$count; $j++){
                if($comparator->$method($arr[$i],$arr[$j]) == 1){
                    $tmp=$arr[$i];
                    $arr[$i]=$arr[$j];
                    $arr[$j]=$tmp;
                }
            }
        }
        return $arr;
    }
}
?>
