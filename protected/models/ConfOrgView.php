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
class ConfOrgView extends ActiveRecord {

    public $id;
    public $conf_id;
    public $org_id;
    //  многоязычные поля
    //  multilingual fields
    public $sub_org;

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
            'sub_org' => Yii::t('orgs', 'Sub-organization')
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
            )
        );
    }

    public function sub_org($language = NULL) {
        return $this->value('sub_org', $language);
    }

    public function isEnabled() {
        if ($this->org == NULL) {
            return false;
        }
        $org = $this->org;
        return $org->is_enabled;
    }

    public function urn() {
        if ($this->org == NULL) {
            return '';
        }
        return $this->org->urn ? $this->org->urn : $this->org->id;
    }

    public function name($language = NULL) {
        if ($this->org == NULL) {
            return '';
        }
        return $this->org->name($language);
    }

    public function shortName($language = NULL) {
        if ($this->org == NULL) {
            return '';
        }
        return $this->org->shortName($language);
    }

    public function relations() {
        return array(
            'org' => array(self::HAS_ONE, 'OrgView', array('id' => 'org_id'))
        );
    }

    public function findAllByConf($conf) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'conf_id=:conf_id';
        $criteria->params = array(':conf_id' => $conf->id);
        return $this->with('org')->findAll($criteria);
    }

}

?>
