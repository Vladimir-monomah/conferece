<?php

/**
 *  Используется при редактировании списка объектов на форме,
 *  для списков объектов, у которых есть поле состояния (state),
 *  для случая, когда удаленные на форме объекты удаляются
 *  фактически при успешном сохранении.
 * 
 *  The class is used when updating a list of similar objects
 *  where an attribute 'state' is defined. It works in case when
 *  removed objects as being removed actually after saving transaction
 *  successfully completed.
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class UpdatedListUtility {

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
    protected $all = array();
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
            foreach ($this->updatedList as $i => $updated_obj) {
                $obj = NULL;
                $updated_obj_id = $updated_obj['id'];
                if ($updated_obj['state'] == 'new') {
                    if ('EmptyId' != $updated_obj_id) {
                        $obj = new $class();
                        $obj->state = 'new';
                        array_push($this->new, $obj);
                        array_push($this->all, $obj);
                    }
                } else {
                    foreach ($this->list as &$old_obj) {
                        if ($old_obj->id == $updated_obj_id) {
                            $obj = $old_obj;
                        }
                    }
                    if ($obj) {
                        if ($updated_obj['state'] == 'deleted') {
                            array_push($this->deleted, $obj);
                            array_push($this->all, $obj);
                        } else {
                            array_push($this->updated, $obj);
                            array_push($this->all, $obj);
                        }
                    }
                }
                if ($obj && ($updated_obj['state'] != 'deleted')) {
                    $obj->scenario = $this->scenario;
                    $obj->attributes = $updated_obj;
                    $this->valid = $obj->validate() && $this->valid;
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

    public function getAll() {
        $this->process();
        return $this->all;
    }

    public function getValid() {
        $this->process();
        return $this->valid;
    }

}

?>
