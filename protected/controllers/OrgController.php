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
class OrgController extends BaseController {

    protected function setActiveMenuItem(CAction $action) {
        $activeUrn = $action->id;
        if (in_array($activeUrn, array('view', 'edit', 'list'))) {
            //  organizations
            $this->userMenu[6]['active'] = true;
        }
    }

    public function actionIndex() {
        $this->actionList();
    }

    public function actionList($sort = 'default') {
        $orgs = array();
        if ($sort == 'namea') {
            $orgs = Org::model()->findAllNameAsc();
        } else
        if ($sort == 'named') {
            $orgs = Org::model()->findAllNameDesc();
        } else
        if ($sort == 'enableda') {
            $orgs = Org::model()->findAllEnabledAsc();
        } else
        if ($sort == 'enabledd') {
            $orgs = Org::model()->findAllEnabledDesc();
        } else
        if ($sort == 'numbera') {
            $orgs = Org::model()->findAllConfCountAsc();
        } else
        if ($sort == 'numberd') {
            $orgs = Org::model()->findAllConfCountDesc();
        } else {
            $orgs = Org::model()->findAll();
        }
        $this->render('list', array('orgs' => $orgs, 'sort' => $sort));
    }

    public function actionView($id) {
        $id = (int) $id;
        $org = Org::model()->findByPk($id);
        if (!$org) {
            throw new CHttpException(404, 'Organization not found.');
        }
        $this->render('view', array('org' => $org));
    }

    public function actionEdit($id) {
        $id = (int) $id;
        $org = Org::model()->findByPk($id);
        if (!$org) {
            throw new CHttpException(404, 'Organization not found.');
        }
        $name = $org->name();
        $this->render('edit', array('org' => $org, 'name' => $name));
    }

    public function actionDelete($id) {
        $id = (int) $id;
        $org = Org::model()->findByPk($id);
        if (!$org) {
            throw new CHttpException(404, 'Organization not found.');
        }
        if (Yii::app()->request->isPostRequest) {
            if (!$org->confCount > 0) {
                $transaction = $this->beginTransaction();
                try {
                    $org->delete();
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when deleting organization with id = {$id}.", 'error', 'OrgController.actionDelete');
                    throw new CHttpException(400, 'System error.');
                }
            }
        };
        $this->redirect(array('list'));
    }

    public function actionSave($id) {
        $id = (int) $id;
        $org = Org::model()->findByPk($id);
        if (!$org) {
            throw new CHttpException(404, 'Organization not found.');
        }
        $name = $org->name();
        $org->scenario = 'save';
        if (isset($_POST['Org'])) {
            $org->attributes = $_POST['Org'];
            if ($org->validate()) {
                $transaction = $this->beginTransaction();
                try {
                    //  method 'afterSave' executes withing transaction (см. MultilingualBehavior)
                    $org->save(false);        
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when updating organization with с id = {$id}.", 'error', 'OrgController.actionSave');
                    throw new CHttpException(400, 'System error.');
                }
                Yii::app()->user->setFlash('saved', Yii::t('confs', 'Information has been saved.'));
                $this->redirect(array('view', 'urn' => $org->urn()));
            }
        };
        $this->render('edit', array('org' => $org, 'name' => $name));
    }

    public function filters() {
        return array_merge(
                parent::filters(), 
                array('accessControl',)
        );
    }

    public function accessRules() {
        $params = 'array(
            "user_id"=>Yii::app()->user->id
        )';
        return array(
            array('allow',
                'actions' => array('index', 'list'),
                'expression' => 'Yii::app()->user->checkAccess("listOrgs",' . $params . ')'
            ),
            array('allow',
                'actions' => array('view'),
                'expression' => 'Yii::app()->user->checkAccess("viewOrg",' . $params . ')'
            ),
            array('allow',
                'actions' => array('edit', 'save', 'delete'),
                'expression' => 'Yii::app()->user->checkAccess("modifyOrg",' . $params . ')',
            ),
            array('deny',
                'users' => array('*')   //  any user
            )
        );
    }

}

?>
