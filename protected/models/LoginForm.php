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
class LoginForm extends CFormModel {

    public $email;
    public $password;
    private $_identity;
    
    // honeypot
    public $ukazhite_e_mail;

    public function rules() {
        return array(
            array('ukazhite_e_mail', 'HoneypotValidator'),
            array('email, password', 'required'),
            array('password', 'authenticate'),
        );
    }

    public function attributeLabels() {
        return array(
            'ukazhite_e_mail' => Yii::t('validators', 'Enter E-mail'),
            'email' => Yii::t('users', 'E-mail'),
            'password' => Yii::t('users', 'Password'),
        );
    }

    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->_identity = new UserIdentity($this->email, $this->password);
            if (!$this->_identity->authenticate())
                $this->addError('password', Yii::t('users', 'Either E-mail or Password is wrong.'));
        }
    }

    protected function beforeValidate() {
        if (parent::beforeValidate()) {
            $this->email = trim($this->email);
            $this->password = trim($this->password);
            return true;
        }
        return false;
    }

    public function login() {
        if ($this->_identity === NULL) {
            $this->_identity = new UserIdentity($this->email, $this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
            Yii::app()->user->login($this->_identity);

            $id = $this->_identity->getId();
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $user = User::model()->findByPk($id);
                $user->last_date = time();
                $user->last_ip = Yii::app()->request->userHostAddress;
                $user->save(false);
                Yii::app()->controller->setLanguage($user->locale);
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::log("Error occured when authenticating user with id = {$id}.", 'error', 'LoginForm.login');
                throw new CHttpException(400, 'System error.');
            }
            return true;
        } else
            return false;
    }

}
