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
class ConfOrg extends ActiveRecord {

    //  вспомогательное поле state, не хранимое в базе
    //  new, removed, updated, пусто по умолчанию
    //  auxiliary field not saved to the database
    //  new, removed, updates, empty by default
    public $state = ''; 
    
    public $id;
    public $conf_id;
    public $org_id;
    //  многоязычные поля
    //  multilingual fields
    public $sub_org;
    protected $_org;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{conf_org}}';
    }

    public function attributeLabels() {
        return array(
            'name' => Yii::t('orgs', 'Organization'),
            'is_enabled' => Yii::t('orgs', 'Enabled'),
            'urn' => Yii::t('orgs', 'Web Page Address'),
            'sub_org' => Yii::t('orgs', 'Sub-organization'),
        );
    }

    public function behaviors() {
        return array(
            'MultilingualBehavior' => array(
                'class' => 'application.behaviors.MultilingualBehavior',
                'table' => 'multilingual_conf_org',
                'table_fk' => 'conf_org_id',
                'language_column' => 'language',
                'columns' => array('sub_org'),
                'languages' => Yii::app()->params['languages'],
            ),
            'StrictXssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('sub_org'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => XssFilter::$STRICTED_ALLOWED_TAGS
            ),
        );
    }

    public function rules() {
        return array(
            array('id', 'unsafe'),
            
            //  info scenario
            array('name', 'RequiredOneValidator', 'on' => 'info'),
            array('org_id', 'safe', 'on' => 'info'),
            array('sub_org', 'LengthEachValidator', 'on' => 'info', 'max' => 150),
        );
    }

    protected function getOrg() {
        if ($this->org_id != $this->_org->id) {
            $this->_org = Org::model()->findByPk($this->org_id);
            if ($this->_org == NULL) {
                $this->_org = new Org();
            }
        }
        return $this->_org;
    }

    public function getName() {
        return $this->getOrg()->name;
    }

    public function setName($name) {
        if ($this->getOrg()->isNewRecord || !$this->getOrg()->is_enabled) {
            $this->getOrg()->name = $name;
        }
    }

    public function name($language = NULL) {
        return $this->getOrg()->value('name', $language);
    }

    public function shortName($language = NULL) {
        return $this->getOrg()->value('shortname', $language);
    }

    public function urn() {
        return $this->getOrg()->urn();
    }

    public function isEnabled() {
        return $this->getOrg()->is_enabled;
    }

    public function sub_org($language = NULL) {
        return $this->value('sub_org', $language);
    }

    public function findByConf($conf) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'conf_id=:conf_id';
        $criteria->params = array(':conf_id' => $conf->id);
        return $this->findAll($criteria);
    }

    public function getOldstate() {
        return $this->state;
    }

    protected function afterFind() {
        parent::afterFind();
        $this->_org = Org::model()->findByPk($this->org_id);
    }

    protected function afterConstruct() {
        parent::afterConstruct();
        $this->_org = new Org();
    }

    protected function beforeSave() {
        parent::beforeSave();
        if ($this->_org->isNewRecord || !$this->_org->is_enabled) {
            $this->_org->save();
            $this->org_id = $this->_org->id;
        }
        return true;
    }

    protected function afterDelete() {
        parent::afterDelete();
        if ($this->getOrg()) {
            if (!$this->getOrg()->isNewRecord && !$this->getOrg()->is_enabled) {
                $this->getOrg()->delete();
            }
        }
        return true;
    }

}

?>
