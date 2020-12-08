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
class ConfEditController extends BaseConfController {

    protected $conf = NULL;

    protected function findConf($id) {
        if ($this->conf == NULL) {
            $this->conf = Conf::model()->findByPk($id);
            if (is_null($this->conf)) {
                throw new CHttpException(404, Yii::t('confs', 'Conference not found.'));
            }
        }
        return $this->conf;
    }

    public function init() {
        parent::init();
        $params = $this->getActionParams();
        $conf = $this->findConf($params['id']);
        $this->confMenu = array();
        $menuItems = ConfMenu::allMenuItems($conf, true, true);
        foreach ($menuItems as $menuItem) {
            if (!in_array($menuItem['urn'], array('application', 'participants'))) {
                array_push(
                        $this->confMenu, array('label' => $menuItem['title'], 'url' => array('confEdit/' . $menuItem['urn'], 'urn' => $conf->urn()))
                );
            }
        }
    }

    public function actionIndex() {
        throw new CHttpException(400, Yii::t('confs', 'Forbidden.'));
    }

    public function actionInfo($id) {
        $conf = $this->findConf($id);
        $enabledOrgs = Org::model()->findEnabledNameAsc();
        $confOrgs = $conf->getOrgs();

        if (isset($_POST['Conf'])) {
            Yii::log("Conference update.\nreturnUrl = " . Yii::app()->user->returnUrl . "\nPOST array: " . print_r($_POST, true), 'info', 'ConfEditController.actionInfo');
            $conf->scenario = 'info';
            $conf->attributes = $_POST['Conf'];
            if (isset($_POST['ConfOrg'])) {
                $conf_id = $conf->id;
                $listUtility = new UpdatedListUtility('ConfOrg', $confOrgs, $_POST['ConfOrg'], 'info');
                $new = $listUtility->getNew();
                $updated = $listUtility->getUpdated();
                $deleted = $listUtility->getDeleted();
                $valid = $listUtility->getValid();
                foreach ($new as $obj) {
                    $obj->conf_id = $conf_id;
                };
            }
            if ($conf->validate() && $valid) {
                $transaction = $this->beginTransaction();
                try {
                    foreach ($updated as $obj) {
                        $obj->save(false);
                    }
                    foreach ($new as $obj) {
                        $obj->save(false);
                    }
                    foreach ($deleted as $obj) {
                        $obj->delete();
                    }
                    $conf->save(false);
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when updating conference general info, conference id = {$id}.", 'error', 'ConfEditController.actionInfo');
                    throw new CHttpException(400, 'System error.');
                }
                Yii::log("Conference updated successfully, conference id = " . $conf->id . ", urn = " . $conf->urn . ".", 'info', 'ConfEditController.actionInfo');
                Yii::app()->user->setFlash('confSaved', Yii::t('confs', 'Information has been saved.'));
                $this->redirect(array('conf/info', 'urn' => $conf->urn()));
            } else {
                Yii::log("Conference was not updated. Validation has not passed.", 'info', 'ConfEditController.actionInfo');
            }
            $confOrgs = $listUtility->getAll();
            ;
            foreach ($confOrgs as $i => &$confOrg) {
                if ($confOrg->state == 'new') {
                    $confOrg->conf_id = $conf_id;
                    $confOrg->id = 'new' . $i;
                };
            };
        }
        $this->render('info', array('conf' => $conf, 'confOrgs' => $confOrgs, 'enabledOrgs' => $enabledOrgs));
    }

    public function actionLanguages($id) {
        $conf = $this->findConf($id);
        if (isset($_POST['Conf'])) {
            $conf->scenario = 'languages';
            $conf->attributes = $_POST['Conf'];
            if ($conf->validate()) {
                $transaction = $this->beginTransaction();
                try {
                    $conf->save(false);
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when updating conference languages, conference id = {$id}.", 'error', 'ConfEditController.actionLanguage');
                    throw new CHttpException(400, 'System error.');
                }
                $this->redirect(array('info', 'urn' => $conf->urn()));
            }
        }
        $this->render('info', array('conf' => $conf));
    }

    public function actionCommittee($id) {
        $conf = $this->findConf($id);
        if (isset($_POST['Conf'])) {
            $conf->scenario = 'committee';
            $conf->attributes = $_POST['Conf'];
            if ($conf->validate()) {
                $transaction = $this->beginTransaction();
                try {
                    $conf->save(false);
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when updating conference organizing committee, conference id = {$id}.", 'error', 'ConfEditController.actionCommittee');
                    throw new CHttpException(400, 'System error.');
                }
                Yii::app()->user->setFlash('confSaved', Yii::t('confs', 'Information has been saved.'));
                $this->redirect(array('conf/committee', 'urn' => $conf->urn()));
            }
        }
        $this->render('committee', array('conf' => $conf));
    }

    public function actionProgram($id) {
        $conf = $this->findConf($id);
        if (isset($_POST['Conf'])) {
            $conf->scenario = 'program';
            $conf->attributes = $_POST['Conf'];
            if ($conf->validate()) {
                $transaction = $this->beginTransaction();
                try {
                    $conf->save(false);
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when updating conference program, conference id = {$id}.", 'error', 'ConfEditController.actionProgram');
                    throw new CHttpException(400, 'System error.');
                }
                Yii::app()->user->setFlash('confSaved', Yii::t('confs', 'Information has been saved.'));
                $this->redirect(array('conf/program', 'urn' => $conf->urn()));
            }
        }
        $this->render('program', array('conf' => $conf));
    }

    public function actionPage($id, $conf_page_id) {
        $conf = $this->findConf($id);
        $confPage = ConfPage::model()->findByPk($conf_page_id);
        if (isset($_POST['ConfPage'])) {
            $confPage->scenario = 'content';
            $confPage->attributes = $_POST['ConfPage'];
            if ($confPage->validate()) {
                $transaction = $this->beginTransaction();
                try {
                    $confPage->save(false);
                    $conf->save(false); // last_update_date
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when updating additional conference page, conference id = {$id}.", 'error', 'ConfEditController.actionPage');
                    throw new CHttpException(400, 'System error.');
                }
                Yii::app()->user->setFlash('confSaved', Yii::t('confs', 'Information has been saved.'));
                $this->redirect(array('conf/' . $confPage->urn(), 'urn' => $conf->urn()));
            }
        }
        $this->render('page', array('conf' => $conf, 'confPage' => $confPage));
    }

    public function actionContacts($id) {
        $conf = $this->findConf($id);
        if (isset($_POST['Conf'])) {
            $conf->scenario = 'contacts';
            $conf->attributes = $_POST['Conf'];
            if ($conf->validate()) {
                $transaction = $this->beginTransaction();
                try {
                    $conf->save(false);
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when updating conference contacts, conference id = {$id}.", 'error', 'ConfEditController.actionContacts');
                    throw new CHttpException(400, 'System error.');
                }
                Yii::app()->user->setFlash('confSaved', Yii::t('confs', 'Information has been saved.'));
                $this->redirect(array('conf/contacts', 'urn' => $conf->urn()));
            }
        }
        $this->render('contacts', array('conf' => $conf));
    }

    public function actionProceedings($id) {
        $conf = $this->findConf($id);
        if (isset($_POST['scenario'])) {
            $conf->scenario = 'proceedings';
            $conf->attributes = isset($_POST['Conf'])?$_POST['Conf']:array();
            if ($conf->validate()) {
                $transaction = $this->beginTransaction();
                try {
                    $conf->save(false);
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when updating conference proceedings, conference id = {$id}.", 'error', 'ParticipantController.actionAdminList');
                    throw new CHttpException(400, 'System error.');
                }
                Yii::app()->user->setFlash('confSaved', Yii::t('confs', 'Information has been saved.'));
                $this->redirect(array('conf/proceedings', 'urn' => $conf->urn()));
            }
        }
        $this->render('proceedings', array('conf' => $conf));
    }

    public function actionReport($id) {
        $conf = $this->findConf($id);
        if (isset($_POST['Conf'])) {
            $conf->scenario = 'report';
            $conf->attributes = $_POST['Conf'];
            if ($conf->validate()) {
                $transaction = $this->beginTransaction();
                try {
                    $conf->save(false);
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when updating conference report, conference id = {$id}.", 'error', 'ConfEditController.actionReport');
                    throw new CHttpException(400, 'System error.');
                }
                Yii::app()->user->setFlash('confSaved', Yii::t('confs', 'Information has been saved.'));
                $this->redirect(array('conf/report', 'urn' => $conf->urn()));
            }
        }
        $this->render('report', array('conf' => $conf));
    }

    public function actionView($id) {
        return $this->actionInfo($id);
    }

    public function filters() {
        return array_merge(
                parent::filters(), 
                array('accessControl',)
        );
    }

    public function accessRules() {
        $params = 'array(
            "conf_id" => Yii::app()->getRequest()->getQuery("id"),
            "user_id" => Yii::app()->user->id
        )';
        return array(
            array('allow',
                'actions' => array('languages', 'info', 'view', 'report', 'contacts', 'program', 'committee', 'page', 'proceedings'),
                'expression' => 'Yii::app()->user->checkAccess("modifyConf",' . $params . ')'
            ),
            array('deny',
                'users' => array('*')   //  any user
            )
        );
    }

}

?>