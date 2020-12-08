<?php

/**
 *  Используется для хранения элемента списка
 *  дополнительных полей автора и заявки на участие.
 * 
 *  ListItem stores an item of an additional list field
 *  in Author and Participant classes.
 * 
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class ListItem extends ActiveRecord {

    //  число элементов списка
    //  list amount
    const COUNT = 15;

 
    public $id;
    public $num;
    // string value id
    public $list_id; 
    
    //  многоязычное поле
    //  multilingual field
    public $item_value = array();

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{list_item}}';
    }

    public function rules() {
        return array(
            array('id', 'unsafe'),
            array('list_id', 'unsafe'),
            array('num', 'unsafe'),
            array('item_value', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
        );
    }

    public function behaviors() {
        return array(
            'MultilingualBehavior' => array(
                'class' => 'application.behaviors.MultilingualBehavior',
                'table' => 'multilingual_list_item',
                'table_fk' => 'item_id',
                'language_column' => 'language',
                'columns' => array('item_value'),
                'languages' => Yii::app()->params['languages'],
            ),
            'FullXssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('item_value'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => array()
            )
        );
    }

    public function itemValue($language = NULL) {
        return $this->value('item_value', $language);
    }

    public function findAllByListId($list_id) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'list_id=:list_id';
        $criteria->params = array(':list_id' => $list_id);
        $criteria->order = 'num asc';
        return $this->findAll($criteria);
    }
                
    public function deleteAllByListId($list_id) {
        $condition = 'list_id=:list_id';
        $params = array(':list_id' => $list_id);
        $this->deleteAll($condition, $params);
    }

    public function isEmpty() {
        $value = $this->itemValue();
        return empty($value);
    }

}

?>
