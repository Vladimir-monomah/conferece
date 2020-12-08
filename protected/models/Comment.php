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
class Comment extends ActiveRecord {

    //  сохраняемые поля
    //  permanent fields
    public $id;
    public $item_id;
    public $sub_item_id;
    public $user_id;
    public $text;
    public $date;
    //  вспомогательное поле
    //  auxiliary fields
    public $username;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{comment}}';
    }

    public function behaviors() {
        return array(
            'XssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('text'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => XssFilter::$ALLOWED_TAGS
            ),
        );
    }

    public function attributeLabels() {
        return array(
            'text' => Yii::t('confs', 'Message')
        );
    }

    public function rules() {
        return array(
            //  unsafe
            array('id', 'unsafe'),
            array('item_id', 'unsafe'),
            array('sub_item_id', 'unsafe'),
            array('user_id', 'unsafe'),
            
            //  save scenario
            array('text', 'safe', 'on' => 'save'),
            array('date', 'safe', 'on' => 'save'));
    }

    public function findAllByItemSubItem($item_id, $sub_item_id = NULL) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'item_id=:item_id';
        $criteria->order = 'date asc';
        $criteria->params = array(':item_id' => $item_id);
        if ($sub_item_id != NULL) {
            $criteria->condition = 'sub_item_id=:sub_item_id';
            $criteria->params['sub_item_id'] = $sub_item_id;
        }
        return $this->findAll($criteria);
    }

    public function countEnabledComments($item_id) {
        $criteria = new CDbCriteria;
        $criteria->alias = 'commented_item';
        $criteria->join = 'LEFT JOIN {{comment}} comment ON commented_item.item_id=comment.item_id and commented_item.sub_item_id=comment.sub_item_id';
        $criteria->condition = "commented_item.commented<>'N' and comment.item_id=:item_id";
        $criteria->params = array(':item_id' => $item_id);
        $items = CommentedItem::model()->findAll($criteria);
        return count($items);
    }

}

?>
