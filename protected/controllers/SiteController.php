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
class SiteController extends BaseController {
    
    protected function setActiveMenuItem(CAction $action) {
        $activeUrn = $action->id;
        if (in_array($activeUrn, array('about'))) {
            //  all conferences
            $this->userMenu[2]['active'] = true;
        }
        if (in_array($activeUrn, array('login'))) {
            //  all conferences
            $this->userMenu[9]['active'] = true;
        }
    }

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'testLimit' => 2,
                'maxLength' => 9,
                'minLength' => 8,
                'offset' => -4
            ),
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function actionIndex() {
        $this->redirect(array(Yii::app()->homeUrl));
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        } else {
            $this->redirect(array(Yii::app()->homeUrl));
        }
    }

    public function actionLogin() {
        $model = new LoginForm;
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()) {
                $returnUrl = Yii::app()->user->getReturnUrl('login');
                if ($returnUrl === 'login') {
                    $this->redirect(array('user/view', 'id' => Yii::app()->user->id));
                } else {
                    $this->redirect(Yii::app()->user->returnUrl);
                }
            }
        };
        $this->render('login', array('model' => $model));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(array(Yii::app()->homeUrl));
    }

    public function actionLanguage($language) {
        if (!isset(Yii::app()->params['languages'][$language])) {
            throw new CHttpException(400, 'Language is not supported.');
        }
        if (isset(Yii::app()->request->urlReferrer)) {
            $this->redirect(Yii::app()->request->urlReferrer);
        } else {
            $this->redirect(array(Yii::app()->homeUrl));
        }
    }

    public function actionAbout($edit = false) {
        $page = SitePage::model()->findByUrn('about');
        if ($edit && Yii::app()->user->checkAccess("admin")) {
            if (isset($_POST['SitePage'])) {
                $page->scenario = 'save';
                $page->attributes = $_POST['SitePage'];
                $page->title = array();
                $languages = Yii::app()->params['languages'];
                foreach ($languages as $language => $name) {
                    $page->title[$language] = Yii::t('site', 'About', array(), NULL, $language);
                };
                $page->validate();
                $page->save(false);
                Yii::app()->user->setFlash('saved', Yii::t('confs', 'Information has been saved.'));
                $this->redirect(array('site/about'));
            } else {
                $this->render('editAbout', array('page' => $page));
                return;
            }
        }
        $this->render('about', array('page' => $page));
    }
    
    public function actionMaintenance() {
        $this->render('maintenance');
    }

}
