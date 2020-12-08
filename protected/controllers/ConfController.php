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
class ConfController extends BaseConfController {

    public function actionIndex() {
        throw new CHttpException(400, Yii::t('confs', 'Forbidden.'));
    }

    public function actionInfo($id) {
        $confView = $this->findConf($id);
        $this->render('info', array('conf' => $confView));
    }

    public function actionPage($id, $conf_page_id) {
        $confView = $this->findConf($id);
        $confPage = ConfPage::model()->findByPk($conf_page_id);
        if (!ConfMenu::isVisibleMenuItem($confView, 'confPage', $confPage)) {
            throw new CHttpException(404, Yii::t('site', 'Page not found.'));
        }
        $this->render('page', array('conf' => $confView, 'confPage' => $confPage));
    }

    public function actionCommittee($id) {
        $confView = $this->findConf($id);
        if (!ConfMenu::isVisibleMenuItem($confView, 'committee')) {
            throw new CHttpException(404, Yii::t('site', 'Page not found.'));
        }
        $this->render('committee', array('conf' => $confView));
    }

    public function actionProgram($id) {
        $confView = $this->findConf($id);
        if (!ConfMenu::isVisibleMenuItem($confView, 'program')) {
            throw new CHttpException(404, Yii::t('site', 'Page not found.'));
        }
        $this->render('program', array('conf' => $confView));
    }

    public function actionContacts($id) {
        $confView = $this->findConf($id);
        if (!ConfMenu::isVisibleMenuItem($confView, 'contacts')) {
            throw new CHttpException(404, Yii::t('site', 'Page not found.'));
        }
        $this->render('contacts', array('conf' => $confView));
    }

    public function actionReport($id) {
        $confView = $this->findConf($id);
        if (!ConfMenu::isVisibleMenuItem($confView, 'report')) {
            throw new CHttpException(404, Yii::t('site', 'Page not found.'));
        }
        $this->render('report', array('conf' => $confView));
    }

    public function actionProceedings($id) {
        $confView = $this->findConf($id);
        if (!ConfMenu::isVisibleMenuItem($confView, 'proceedings')) {
            throw new CHttpException(404, Yii::t('site', 'Page not found.'));
        }
        $this->render('proceedings', array('conf' => $confView));
    }

    public function actionView($id) {
        return $this->actionInfo($id);
    }

    public function actionGuestbook($id) {
        $confView = $this->findConf($id);
        if (!$confView->is_guestbook_enabled) {
            throw new CHttpException(404, Yii::t('site', 'Page not found.'));
        };
        $guestbooks = Guestbook::model()->findAllByConf($confView);
        $this->render('guestbook', array('conf' => $confView, 'guestbooks' => $guestbooks));
    }

    public function actionPostGuestbook($id) {
        $conf = $this->findConf($id);
        $guestbook = new Guestbook('save');
        if ($_POST['Guestbook']) {
            $guestbook->attributes = $_POST['Guestbook'];
            $guestbook->conf_id = $id;
            $guestbook->date = time();
            $guestbook->ip = CHttpRequest::getUserHostAddress();
            $user = User::model()->findByPk(Yii::app()->user->id);
            $guestbook->name = $user->fullName();
            $guestbook->email = $user->email;
            $transaction = $this->beginTransaction();
            try {
                $guestbook->save();
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::log("Error occured when adding a message to the guestbook.", 'error', 'ConfController.actionPostGuestbook');
                throw new CHttpException(400, 'System error.');
            }
        }
        $this->redirect(array('guestbook', 'urn' => $conf->urn()));
    }

    public function actionDeleteGuestbook($id, $guestbook_id) {
        $conf = $this->findConf($id);
        if (Yii::app()->request->isPostRequest) {
            $guestbook = Guestbook::model()->findByPk($guestbook_id);
            if ($guestbook != NULL) {
                $transaction = $this->beginTransaction();
                try {
                    $guestbook->delete();
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when deleting a message from the guestbook.", 'error', 'ConfController.actionDeleteGuestbook');
                    throw new CHttpException(400, 'System error.');
                }
            }
        };
        $this->redirect(array('guestbook', 'urn' => $conf->urn()));
    }
    
    public function actionLetter($id) {
        $confView = $this->findConf($id);
        $language = Yii::app()->language;
        $infoLetter = $confView->getFile('info_letter');
        if( ($infoLetter != NULL) && !$infoLetter->isEmpty()) {
            $fileName = $infoLetter->name($language);     
            $filePath = $infoLetter->path($language);
            $this->render('file', array('fileName' => $fileName, 'filePath' => $filePath));
        }
        Yii::app()->end();      
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
                'actions' => array('info', 'view', 'report', 'contacts', 'program', 'committee', 'page', 'proceedings','letter'),
                'expression' => 'Yii::app()->user->checkAccess("viewConf",' . $params . ')'
            ),
            array('allow',
                'actions' => array('guestbook'),
                'expression' => 'Yii::app()->user->checkAccess("viewGuestbook",' . $params . ')'
            ),
            array('allow',
                'actions' => array('guestbook', 'postGuestbook'),
                'expression' => 'Yii::app()->user->checkAccess("postGuestbook",' . $params . ')'
            ),
            array('allow',
                'actions' => array('deleteGuestbook'),
                'expression' => 'Yii::app()->user->checkAccess("editGuestbook",' . $params . ')'
            ),
            array('deny',
                'users' => array('*')   //  any user
            )
        );
    }

}

?>
