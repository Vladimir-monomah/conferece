<?php

/**  
 *  Это базовый класс контроллера, все остальные контроллеры должны
 *  наследоваться от него. 
 * 
 *  Controller is the customized base controller class.
 *  All controller classes for this application should extend from this base class. 
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class BaseController extends CController {

    public $headTitle = NULL;
    public $confTitle = NULL;
    public $confSubject = NULL;

    public function getLayout() {
        return '//layouts/column1';
    }

    public $confMenuTitle = '';
    public $confMenu = array();
    public $adminMenu = array();
    public $userMenu = array();

    public function init() {
        parent::init();
        //  устанавливаем язык
        //  set language
        $language = isset($_GET['language'])?$_GET['language']:'';
        if (!empty($language)) {
            $this->setLanguage($language);
        };
        //  устанавливаем шаблон
        //  set layout
        $this->layout = $this->getLayout();
        //  виден ли пункт меню "О сайте"
        //  set visibility for 'About' menu item
        $isAboutVisible = true;
        $page = SitePage::model()->findByUrn('about');
        if ($page != NULL) {
            $content = $page->content();
            $isAboutVisible = !empty($content) || Yii::app()->user->checkAccess('admin');
        };
        $this->userMenu = array(
            array('label' => Yii::t('site', 'Home'), 'url' => array('/' . Yii::app()->homeUrl)),
            array('label' => Yii::t('users', 'Conferences with open registration'), 'url' => array('/confs/registration'), 'visible' => false),
            array('label' => Yii::t('site', 'About'), 'url' => array('/site/about'), 'visible' => $isAboutVisible),
            array('label' => Yii::t('confs', 'Add Conference'), 'url' => array('/confCreate/create'), 'visible' => !Yii::app()->user->isGuest && Yii::app()->user->checkAccess('createConf')),
            array('label' => Yii::t('confs', 'New Conferences'), 'url' => array('/confs/new'), 'visible' => !Yii::app()->user->isGuest && Yii::app()->user->checkAccess('admin')),
            array('label' => Yii::t('users', 'Users'), 'url' => array('/user/list'), 'visible' => !Yii::app()->user->isGuest && Yii::app()->user->checkAccess('listUsers')),
            array('label' => Yii::t('orgs', 'Organizations'), 'url' => array('/org/list'), 'visible' => !Yii::app()->user->isGuest && Yii::app()->user->checkAccess('listOrgs')),
            array('label' => Yii::t('users', 'My page'), 'url' => array('/user/view', 'id' => Yii::app()->user->id), 'visible' => !Yii::app()->user->isGuest),
            array('label' => Yii::t('users', 'Register on&nbsp;the&nbsp;site'), 'url' => array('/user/register'), 'visible' => Yii::app()->user->isGuest),
            array('label' => Yii::t('users', 'Login'), 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
            array('label' => Yii::t('users', 'Logout'), 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
        );
    }

    protected function beforeAction(CAction $action) {
        if (!parent::beforeAction($action)) {
            return false;
        };
        $this->setActiveMenuItem($action);
        return true;
    }

    protected function setActiveMenuItem(CAction $action) {
        
    }

    public $breadcrumbs = array();

    public function getCurrentLanguages() {
        return Yii::app()->params['languages'];
    }

    public function setLanguage($language) {
        if (isset(Yii::app()->params['languages'][$language])) {
            Yii::app()->session['language'] = $language;
            Yii::app()->language = $language;
        };
    }

    public function beginTransaction() {
        return Yii::app()->db->beginTransaction();
    }
    
}
