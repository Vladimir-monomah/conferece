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
class OrgView extends ActiveRecord {

    public $id;
    public $is_enabled = false;
    public $urn;
    public $website;
    public $email;
    public $phone;
    public $fax;
    //  многоязычные поля
    //  multilingual fields
    public $name;
    public $shortname;
    public $address;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{org}}';
    }

    public function attributeLabels() {
        return array(
            'name' => Yii::t('orgs', 'Name'),
            'shortname' => Yii::t('orgs', 'Short Name'),
            'is_enabled' => Yii::t('orgs', 'Enabled'),
            'urn' => Yii::t('orgs', 'Web Page Address'),
            'website' => Yii::t('orgs', 'Website'),
            'email' => Yii::t('orgs', 'E-mail'),
            'address' => Yii::t('orgs', 'Address'),
            'phone' => Yii::t('orgs', 'Telephone'),
            'fax' => Yii::t('orgs', 'Fax'),
            'logo' => Yii::t('orgs', 'Logo'),
            'currentConfs' => Yii::t('orgs', 'Current Conferences'),
            'recentConfs' => Yii::t('orgs', 'Recent Conferences')
        );
    }

    public function behaviors() {
        return array(
            'MultilingualBehavior' => array(
                'class' => 'application.behaviors.MultilingualBehavior',
                'table' => 'multilingual_org',
                'table_fk' => 'org_id',
                'language_column' => 'language',
                'columns' => array('name', 'shortname', 'address'),
                'languages' => Yii::app()->params['languages'],
            )
        );
    }

    public function name($language = NULL) {
        return $this->value('name', $language);
    }

    public function isEnabled() {
        return $this->is_enabled;
    }

    public function sub_org($language = NULL) {
        return $this->subOrg->sub_org($language);
    }

    public function isEnabledStr() {
        return $this->is_enabled ? Yii::t('site', 'Yes') : Yii::t('site', 'No');
    }

    public function shortName($language = NULL) {
        return $this->value('shortname', $language);
    }

    public function urn() {
        return $this->urn ? $this->urn : $this->id;
    }

    protected $_currentConfs;

    public function getCurrentConfs() {
        if (!$this->_currentConfs) {
            $this->_currentConfs = ConfView::model()->findCurrentByOrg($this);
        }
        return $this->_currentConfs;
    }

    protected $_recentConfs;

    public function getRecentConfs() {
        if (!$this->_recentConfs) {
            $this->_recentConfs = ConfView::model()->findRecentByOrg($this);
        }
        return $this->_recentConfs;
    }

}

?>
