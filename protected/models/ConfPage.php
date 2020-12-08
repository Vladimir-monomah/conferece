<?php

/**
 *  Страница конференции (нестандартный пункт меню).
 * 
 *  A conference additional page.
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class ConfPage extends ActiveRecord {

    //  вспомогательное поле state, не хранимое в базе
    //  new, removed, updated, пусто по умолчанию
    //  auxiliary field not saved to database
    //  new, removed, updated, empty by default
    public $state = ''; 
    public $id;
    public $conf_id;
    public $urn;
    public $next_urn;
    //  многоязычные поля
    //  multilingual fields
    public $title;
    public $content;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{conf_page}}';
    }

    public function behaviors() {
        return array(
            'MultilingualBehavior' => array(
                'class' => 'application.behaviors.MultilingualBehavior',
                'table' => 'multilingual_conf_page',
                'table_fk' => 'conf_page_id',
                'language_column' => 'language',
                'columns' => array('title', 'content'),
                'languages' => Yii::app()->params['languages'],
            ),
            'XssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('content'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => XssFilter::$ALLOWED_TAGS
            ),
            'FullXssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('title'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => array()
            ),
        );
    }

    public function rules() {
        return array(
            array('id', 'unsafe'),
            
            //  pages scenario
            array('title', 'RequiredOneValidator', 'on' => 'pages'),
            array('title', 'LengthEachValidator', 'on' => 'pages', 'max' => 100),
            array('urn', 'required', 'on' => 'pages'),
            array('urn', 'length', 'on' => 'pages', 'max' => 20),
            array('urn', 'ConfUrnValidator', 'on' => 'pages', 'conf_id' => $this->conf_id),
            array('next_urn', 'safe', 'on' => 'pages'),
            
            //  content scenario
            array('content', 'safe', 'on' => 'content'),
        );
    }

    public function attributeLabels() {
        return array(
            'title' => Yii::t('confs', 'Page Title'),
            'urn' => Yii::t('confs', 'Web Address'),
            'next_urn' => Yii::t('confs', 'Add Before Page'),
        );
    }

    public function title($language = NULL) {
        return $this->value('title', $language);
    }

    public function content($language = NULL) {
        return $this->value('content', $language);
    }

    public function urn() {
        return $this->urn;
    }

    public function findByConf($conf) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'conf_id=:conf_id';
        $criteria->params = array(':conf_id' => $conf->id);
        $criteria->order = 'id asc';
        return $this->findAll($criteria);
    }

    public function findByUrnConf($conf_id, $urn) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'conf_id=:conf_id and urn=:urn';
        $criteria->params = array(':conf_id' => $conf_id, 'urn' => $urn);
        $criteria->order = 'id asc';
        return $this->find($criteria);
    }

    public function getOldstate() {
        return $this->state;
    }

}

?>
