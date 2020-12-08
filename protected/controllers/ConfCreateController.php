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
class ConfCreateController extends BaseController {
    
     protected function setActiveMenuItem(CAction $action) {
        $activeUrn = $action->id;
        if (in_array($activeUrn, array('create'))) {
            //  all conferences
            $this->userMenu[3]['active'] = true;
        }
    }

    public function actionIndex() {
        throw new CHttpException(400, Yii::t('confs', 'Forbidden.'));
    }

    public function actionCreate() {
        $conf = Conf::newConf();
        if (isset($_POST['Conf'])) {
            Yii::log("Conference creation.\nreturnUrl = " . Yii::app()->user->returnUrl . "\nPOST array: " . print_r($_POST, true), 'info', 'ConfController.actionAdd');
            $conf->scenario = 'create';
            $conf->attributes = $_POST['Conf'];
            if ($conf->validate()) {
                $transaction = $this->beginTransaction();
                try {
                    //  в транзакцию попадает метод afterSave (см. MultilingualBehavior)
                    //  method 'afterSave' executes within transaction
                    $conf->save(false);
                    
                    
                    //  добавляем текущего пользователя в администраторы конференции
                    //  assign current user conference administrator
                    $user = User::model()->findByPk(Yii::app()->user->id);
                    if ($user) {
                        $admin = new ConfAdmin();
                        $admin->user_id = $user->id;
                        $admin->conf_id = $conf->id;
                        $admin->save();
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when creating new conference.", 'error', 'ConfController.actionAdd');
                    throw new CHttpException(400, 'System error.');
                }
                Yii::log("Conference created succesfully, id = " . $conf->id . ", urn = " . $conf->urn . ".", 'info', 'ConfController.actionAdd');
                $this->redirect(array('conf/view', 'urn' => $conf->urn()));
            } else {
                Yii::log("Conference was not created. Validation has not passed.", 'info', 'ConfController.actionAdd');
            }
        }
        $this->render('create', array('conf' => $conf));
    }

    public function filters() {
        return array_merge(
                parent::filters(), 
                array('accessControl',)
        );
    }

    public function accessRules() {
        $params = 'array(
               "user_id" => Yii::app()->user->id
        )';
        return array(
            array('allow',
                'actions' => array('create'),
                'expression' => 'Yii::app()->user->checkAccess("createConf",' . $params . ')'
            ),
            array('deny',
                'users' => array('*')   //  any user
            )
        );
    }

}

?>
