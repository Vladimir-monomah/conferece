<?php

/**
 *  Страница сайта, например, «О сайте».
 * 
 *  Website page, e.g. "About site". 
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class SitePage extends ActiveRecord {

    public $id;
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
        return '{{site_page}}';
    }

    public function behaviors() {
        return array(
            'MultilingualBehavior' => array(
                'class' => 'application.behaviors.MultilingualBehavior',
                'table' => 'multilingual_site_page',
                'table_fk' => 'page_id',
                'language_column' => 'language',
                'columns' => array('title', 'content'),
                'languages' => Yii::app()->params['languages'],
            ),
            'XssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('content'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => CMap::mergeArray(XssFilter::$ALLOWED_TAGS, array('h1', 'h2'))
            ),
            'StrictXssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('title'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => XssFilter::$STRICTED_ALLOWED_TAGS
            ),
        );
    }

    public function rules() {
        return array(
            //  unsafe
            array('id', 'unsafe'),
            
            //  save scenario
            array('title', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('title', 'RequiredEachValidator', 'on' => 'save', 'languages' => Yii::app()->params['languages']),
            array('content', 'safe', 'on' => 'save')
        );
    }

    public function findByUrn($urn) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'urn=:urn';
        $criteria->params = array(':urn' => $urn);
        return $this->find($criteria);
    }

    public function title($language = NULL) {
        return $this->value('title', $language);
    }

    public function content($language = NULL) {
        return $this->value('content', $language);
    }

}
