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
class Org extends ActiveRecord {

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
    //  вспомогательное поле
    //  старый адрес
    //  
    //  auxiliary attribute
    //  old urn
    public $_oldurn; 

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{org}}';
    }

    public function rules() {
        return array(
            array('id', 'unsafe'),
            
            //  save scenario
            array('is_enabled', 'boolean', 'on' => 'save'),
            array('urn', 'length', 'on' => 'save', 'max' => 30),
            array('urn', 'SiteUrnValidator', 'on' => 'save', 'oldurn' => $this->_oldurn),
            array('name', 'RequiredOneValidator', 'on' => 'save'),
            array('name', 'LengthEachValidator', 'on' => 'save', 'max' => 400),
            array('shortname', 'LengthEachValidator', 'on' => 'save', 'max' => 40),
            array('address', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('email', 'email', 'on' => 'save'),
            array('website,email,phone,fax', 'length', 'on' => 'save', 'max' => 100),
            array('logo', 'FilesValidator', 'on' => 'save', 'size' => Yii::app()->params['userFileSize'], 'exts' => Yii::app()->params['logoExts']),
        );
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
            ),
            'FilesBehavior' => array(
                'class' => 'application.behaviors.FilesBehavior',
                'fileAttrs' => array('logo' => FileType::LOGO)
            ),
            'FullXssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('urn', 'website', 'email', 'phone', 'fax'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => array()
            ),
            'StrictXssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('name', 'shortname', 'address'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => XssFilter::$STRICTED_ALLOWED_TAGS
            ),
        );
    }

    public function name($language = NULL) {
        return $this->value('name', $language);
    }

    public function isEnabledStr() {
        return $this->is_enabled ? Yii::t('site', 'Yes') : Yii::t('site', 'No');
    }

    public function shortName($language = NULL) {
        return $this->value('shortname', $language);
    }

    public function address($language = NULL) {
        return $this->value('address', $language);
    }

    public function findByUrn($urn) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'urn=:urn or id=:id';
        $criteria->params = array(':urn' => $urn, ':id' => $urn);
        return $this->find($criteria);
    }

    public function testExistsByUrn($urn) {
        $sql = "select count(*) from {{org}} where (urn=:urn) or (id=:id)";
        $command = $this->dbConnection->createCommand($sql);
        $command->bindValue(':urn', $urn);
        $command->bindValue(':id', $urn);
        $count = $command->queryScalar();
        return $count > 0;
    }

    public function urn() {
        $urn = $this->urn;
        if ($urn != $this->_oldurn) {
            $urn = $this->_oldurn;
        }
        return $urn ? $urn : $this->id;
    }

    public function scopes() {
        return array(
            'enabled' => array(
                'condition' => 'is_enabled=1'
            ),
            'new' => array(
                'condition' => 'is_enabled=0',
            )
        );
    }

    public function findAllEnabledAsc() {
        $criteria = new CDbCriteria;
        $criteria->order = 'is_enabled asc';
        $orgs = $this->with('confCount')->findAll($criteria);
        return $orgs;
    }

    public function findAllEnabledDesc() {
        $criteria = new CDbCriteria;
        $criteria->order = 'is_enabled desc';
        $orgs = $this->with('confCount')->findAll($criteria);
        return $orgs;
    }

    public function SortByNameAsc($org1, $org2) {
        $value1 = $org1->name();
        $value2 = $org2->name();
        return strcmp($value1, $value2);
    }

    public function SortByNameDesc($org1, $org2) {
        $value1 = $org1->name();
        $value2 = $org2->name();
        return strcmp($value2, $value1);
    }

    public function SortByConfCountAsc($org1, $org2) {
        $value1 = $org1->confCount;
        $value2 = $org2->confCount;
        if ($value1 == $value2) {
            return 0;
        }
        return ($value1 < $value2) ? -1 : 1;
    }

    public function SortByConfCountDesc($org1, $org2) {
        $value1 = $org1->confCount;
        $value2 = $org2->confCount;
        if ($value1 == $value2) {
            return 0;
        }
        return ($value1 > $value2) ? -1 : 1;
    }

    public function findAllNameAsc() {
        $orgs = $this->with('confCount')->findAll();
        usort($orgs, array("Org", "SortByNameAsc"));
        return $orgs;
    }

    public function findEnabledNameAsc() {
        $orgs = $this->enabled()->findAll();
        usort($orgs, array("Org", "SortByNameAsc"));
        return $orgs;
    }

    public function findAllNameDesc() {
        $orgs = $this->with('confCount')->findAll();
        usort($orgs, array("Org", "SortByNameDesc"));
        return $orgs;
    }

    public function findAllConfCountAsc() {
        $orgs = $this->with('confCount')->findAll();
        usort($orgs, array("Org", "SortByConfCountAsc"));
        return $orgs;
    }

    public function findAllConfCountDesc() {
        $orgs = $this->with('confCount')->findAll();
        usort($orgs, array("Org", "SortByConfCountDesc"));
        return $orgs;
    }

    protected $_currentConfs;

    public function getCurrentConfs() {
        if (!$this->_currentConfs) {
            $this->_currentConfs = Conf::model()->findCurrentByOrg($this);
        }
        return $this->_currentConfs;
    }

    protected $_recentConfs;

    public function getRecentConfs() {
        if (!$this->_recentConfs) {
            $this->_recentConfs = Conf::model()->findRecentByOrg($this);
        }
        return $this->_recentConfs;
    }

    public function relations() {
        return array(
            'confCount' => array(self::STAT, 'ConfOrg', 'org_id'),
        );
    }

    protected function beforeValidate() {
        if (parent::beforeValidate()) {
            $this->email = trim($this->email);
            $this->urn = trim($this->urn);
            return true;
        }
        return false;
    }

    protected function afterFind() {
        parent::afterFind();
        $this->_oldurn = $this->urn;
    }

    protected function afterSave() {
        parent::afterSave();
        if ($this->isNewRecord) {
            //  добавляем urn в таблицу
            //  adding urn to the table
            SiteUrn::model()->addUrn($this->urn);
        } else {
            //  обновить адрес в базе
            //  updating urn in the database
            if ($this->_oldurn != $this->urn) {
                SiteUrn::model()->replace($this->_oldurn, $this->urn);
            };
        };
        //  обновить адрес в объекте
        //  updating urn in the object
        $this->_oldurn = $this->urn;
    }

}

?>
