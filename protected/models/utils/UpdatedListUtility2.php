<?php

/**
 *  Используется при редактировании списка объектов на форме,
 *  для случая, когда объекты имеют файловые поля.
 *  Например: список авторов в заявке на участие.
 * 
 *  The class is used when editing a list of objects when objects
 *  have file attributes, e. g. liat of authors in a application. 
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class UpdatedListUtility2 {

    protected $class;
    //  array of ActiveRecord
    protected $list;
    //  array of associative arrays
    protected $updatedList;
    protected $scenario;
    protected $processed = false;
    protected $new = array();
    protected $deleted = array();
    protected $updated = array();
    protected $allUpdated = array();
    protected $valid = true;

    public function __construct($class, $list, $updatedList, $scenario) {
        $this->class = $class;
        $this->list = $list;
        $this->updatedList = $updatedList;
        $this->scenario = $scenario;
    }

    protected function process() {
        if (!$this->processed) {
            $this->processed = true;
            $class = $this->class;
            $i = 0;
            foreach ($this->updatedList as $i => &$updated_obj) {
                if (!is_array($updated_obj)) {
                    continue;
                };
                if (!is_int($i)) {
                    continue;
                };
                $obj = NULL;
                $updated_obj_id = $updated_obj['id'];
                if (empty($updated_obj_id) || ($updated_obj_id == 'new')) {
                    $obj = new $class();
                    array_push($this->new, $obj);
                    array_push($this->allUpdated, $obj);
                } else {
                    foreach ($this->list as &$old_obj) {
                        if ($old_obj->id == $updated_obj_id) {
                            $obj = $old_obj;
                            array_push($this->updated, $obj);
                            array_push($this->allUpdated, $obj);
                            break;
                        }
                    }
                }
                if ($obj) {
                    $obj->scenario = $this->scenario;
                    $obj->attributes = $updated_obj;
                    $obj->ownerIdx = $i;
                    $this->valid = $obj->validate() && $this->valid;
                }
            }
            foreach ($this->list as &$old_obj) {
                $found = false;
                foreach ($this->allUpdated as &$updated_obj) {
                    if ($old_obj->id == $updated_obj->id) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    array_push($this->deleted, $old_obj);
                }
            }
        }
    }

    public function getNew() {
        $this->process();
        return $this->new;
    }

    public function getDeleted() {
        $this->process();
        return $this->deleted;
    }

    public function getUpdated() {
        $this->process();
        return $this->updated;
    }

    public function getAllUpdated() {
        $this->process();
        return $this->allUpdated;
    }

    public function getValid() {
        $this->process();
        return $this->valid;
    }

}

?>