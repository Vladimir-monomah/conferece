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
class RFilemanagerBehavior extends CActiveRecordBehavior {

    public $attributes = array();
    protected $_temp_id = NULL;

    public function getTemp_id() {
        if ($this->_temp_id == NULL) {
            $this->_temp_id = uniqid('temp');
        }
        return $this->_temp_id;
    }

    public function setTemp_id($temp_id) {
        $this->_temp_id = $temp_id;
    }

    public function subfolder($id = NULL) {
        $owner = $this->getOwner();
        $id = $this->subfolder_id($id);
        $subfolder = mb_substr(strtolower(get_class($owner)),0,4) . '_' . $id;
        return $subfolder;
    }
    
    public function subfolder_id($id = NULL) {
        $owner = $this->getOwner();
        if ($id == NULL) {
            if ($owner->isNewRecord) {
                $id = $owner->temp_id;
            } else {
                $id = $owner->id;
            }
        }
        return $id;
    }
    
    protected function fixSubfolderPath($str){
        $owner = $this->getOwner();
        $temp_id = $owner->temp_id;
        $id = $owner->id;        
        $old = $owner->subfolder($temp_id);
        $new = $owner->subfolder($id);
        $pattern = "${old}";
        $str = mb_ereg_replace($pattern, $new, $str);
        return $str;
    }

    public function afterSave($event) {
        $owner = $this->getOwner();
        if ($owner->isNewRecord) {
            RFilemanagerUtils::saveSubfolder($owner);
            foreach($this->attributes as $attribute){
                $values = $owner->{$attribute};
                if(is_array($values)){
                    foreach($values as $lang => $value){
                        $value = $this->fixSubfolderPath($value);
                        $owner->{$attribute}[$lang] = $value;
                    }
                } else {
                   $value = $this->fixSubfolderPath($values); 
                   $owner->{$attribute} = $value;
                }
            }
        }
    }

    public function afterDelete($event) {
         $owner = $this->getOwner();
        RFilemanagerUtils::deleteSubfolder($owner);
    }

}
