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
class ConfAdmin extends ActiveRecord {

    public $id;
    public $conf_id;
    public $user_id;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{conf_admin}}';
    }

    protected $_user = NULL;
    protected $_conf = NULL;

    public function afterFind() {
        parent::afterFind();
        $this->_user = User::model()->findByPk($this->user_id);
        $this->_conf = Conf::model()->findByPk($this->conf_id);
    }

    public function fullName($language = NULL) {
        return $this->_user->fullName();
    }

    public function email() {
        return $this->_user->email;
    }

    public function locale() {
        return $this->_user->locale;
    }

    public function urn() {
        return $this->_user->id;
    }

    public function conf() {
        if ($this->_conf == NULL) {
            $this->_conf = Conf::model()->findByPk($this->conf_id);
        }
        return $this->_conf;
    }

    public function user() {
        if ($this->_user == NULL) {
            $this->_user = User::model()->findByPk($this->user_id);
        }
        return $this->_user;
    }

    public function findByConf($conf) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'conf_id=:conf_id';
        $criteria->params = array(':conf_id' => $conf->id);
        $admins = $this->findAll($criteria);
        foreach ($admins as $i => $admin) {
            if (empty($admin->_user)) {
                unset($admins[$i]);
            };
        };
        return $admins;
    }

    public function findByAdmin($user_id) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'user_id=:user_id';
        $criteria->params = array(':user_id' => $user_d);
        return $this->findAll($criteria);
    }

    public function onCreate($event) {
        $this->raiseEvent("onCreate", $event);
    }

    public function afterSave() {
        parent::afterSave();
        if ($this->isNewRecord) {
            //  привязываем обработчик события
            //  attaching handler for the event
            $this->onCreate = array(NotificationService::getInstance(), "nofityConfAdminAssigned");
            //  инициируем то событие
            //  initializing the event
            $this->onCreate(new CEvent($this, array("user" => $this->user(), "conf" => $this->conf())));
        }
    }

}

?>
