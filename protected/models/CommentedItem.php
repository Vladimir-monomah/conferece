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
class CommentedItem extends ActiveRecord {

    public $item_id;
    public $sub_item_id;
    public $commented;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{commented_item}}';
    }

    public function rules() {
        return array(
            //
            array('commented', 'unsafe'),
            array('item_id', 'unsafe'),
            array('sub_item_id', 'unsafe'));
    }

    public function findByItemSubItem($item_id, $sub_item_id = NULL) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'item_id=:item_id';
        $criteria->params = array(':item_id' => $item_id);
        if ($sub_item_id != NULL) {
            $criteria->condition = 'sub_item_id=:sub_item_id';
            $criteria->params['sub_item_id'] = $sub_item_id;
        }
        return $this->findAll($criteria);
    }

    public function findAllUncommented($item_id) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'item_id=:item_id';
        $criteria->condition = "commented='N'";
        $criteria->params = array(':item_id' => $item_id);
        return $this->findAll($criteria);
    }

}

?>
