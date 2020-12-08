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
class Guestbook extends ActiveRecord {

    public $id;
    public $conf_id;
    public $date;
    public $ip;
    public $name;
    public $email;
    public $message;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{guestbook}}';
    }

    public function behaviors() {
        return array(
            'XssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('message'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => XssFilter::$ALLOWED_TAGS
            ),
        );
    }

    public function attributeLabels() {
        return array(
            'message' => Yii::t('confs', 'Message'),
        );
    }

    public function rules() {
        return array(
            //  unsafe
            array('id', 'unsafe'),
            
            //  save scenario
            array('message', 'safe', 'on' => 'save'));
    }

    public function findAllByConf($conf) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'conf_id=:conf_id';
        $criteria->order = 'date desc';
        $criteria->params = array(':conf_id' => $conf->id);
        return $this->findAll($criteria);
    }

}

?>
