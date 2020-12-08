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
class BaseConfController extends BaseController {

    public function getLayout() {
        return '//layouts/conf-layout';
    }

    protected function setActiveMenuItem(CAction $action) {
        $activeUrn = $action->id;
        if ($activeUrn == 'view') {
            $activeUrn = 'info';
        }
        if ($activeUrn == 'page') {
            $params = $this->getActionParams();
            $confPage = ConfPage::model()->findByPk($params['conf_page_id']);
            if ($confPage) {
                $activeUrn = $confPage->urn;
            }
        }
        $searchItem = $this->id . '/' . $activeUrn;
        foreach ($this->confMenu as $i => &$menuItem) {
            if ($menuItem['url'][0] == $searchItem) {
                $menuItem['active'] = true;
                break;
            }
        }
        //  регистрация на сайте
        //  website registration
        $this->userMenu[8]['visible'] = false;
    }

    public function init() {
        parent::init();

        $params = $this->getActionParams();
        //  captcha action
        if (empty($params['id'])) {
            return;
        }
        $confView = $this->findConf($params['id']);
        $this->confMenuTitle = $confView->menuTitle();
        $this->confTitle = StringUtils::prepareHtml($confView->title());
        $this->confSubject = StringUtils::prepareHtml($confView->subject());
        $showEmpty = false;
        if (Yii::app()->user->checkAccess('modifyConf', array('conf_id' => $confView->id))) {
            $showEmpty = true;
        }
        $menuItems = ConfMenu::allMenuItems($confView, false, $showEmpty);
        foreach ($menuItems as $menuItem) {
            $url = 'conf/' . $menuItem['urn'];
            if ($menuItem['urn'] == 'participants') {
                $url = 'participant/list';
            }
            if ($menuItem['urn'] == 'application') {
                $url = 'participant/application';
            }
            if ($menuItem['urn'] == 'myApplication') {
                $url = 'participant/myApplication';
            }
            array_push(
                    $this->confMenu, array('label' => $menuItem['title'], 'url' => array($url, 'urn' => $confView->urn()))
            );
        }

        $this->adminMenu = NULL;
        if (Yii::app()->user->checkAccess('modifyConf', array('conf_id' => $confView->id))) {
            $this->adminMenu = array(
                array('label' => Yii::t('admin', 'Settings'), 'url' => array('admin/settings', 'urn' => $confView->urn())),
                array('label' => Yii::t('admin', 'Pages'), 'url' => array('admin/pages', 'urn' => $confView->urn())),
                array('label' => Yii::t('admin', 'Administrators'), 'url' => array('admin/admins', 'urn' => $confView->urn())),
                array('label' => Yii::t('admin', 'Application Form'), 'url' => array('admin/form', 'urn' => $confView->urn())),
                array('label' => Yii::t('admin', 'Topics and Sessions'), 'url' => array('admin/topics', 'urn' => $confView->urn())),
                //array('label'=>Yii::t('admin','Reviewing'), 'url'=>array('admin/reviewing','urn'=>$conf->urn())),
                array('label' => Yii::t('admin', 'Mailing'), 'url' => array('admin/mailing', 'urn' => $confView->urn()))
            );
        }
    }

    protected $confView = NULL;

    protected function findConf($id) {
        if ($this->confView == NULL) {
            $this->confView = ConfView::model()->findByPk($id);
            if (is_null($this->confView)) {
                throw new CHttpException(404, Yii::t('confs', 'Conference not found.'));
            }
        }
        return $this->confView;
    }

    public function getCurrentLanguages() {
        $confView = $this->findConf(NULL);
        return $confView->getLanguages();
    }

}

?>
