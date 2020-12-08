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
class Captcha extends CFormModel {

    public $verifyCode;

    function rules() {
        return array(
            array(
                'verifyCode',
                'captcha',
                //  авторизованным пользователям код можно не вводить
                //  authorized user should not enter captcha text
                'allowEmpty' => !Yii::app()->user->isGuest || !CCaptcha::checkRequirements(),
                'message'=> Yii::t('users', 'Spam protection code is incorrect.')
            ),
        );
    }

    function attributeLabels() {
        return array(
            'verifyCode' => Yii::t('users', 'Spam Protection Code'),
        );
    }

}

?>
