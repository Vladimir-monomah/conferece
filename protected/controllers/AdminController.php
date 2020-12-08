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
class AdminController extends BaseConfController {

    protected function setActiveMenuItem(CAction $action) {
        $activeUrn = $action->id;
        if ($activeUrn == 'fieldList') {
            $activeUrn = 'form';
        };
        if ($activeUrn == 'recipients') {
            $activeUrn = 'mailing';
        };
        $searchItem = $this->id . '/' . $activeUrn;
        foreach ($this->adminMenu as $i => &$menuItem) {
            if ($menuItem['url'][0] == $searchItem) {
                $menuItem['active'] = true;
                break;
            }
        }
    }

    public function actionIndex() {
        throw new CHttpException(400, Yii::t('admin', 'Forbidden.'));
    }

    protected $conf = NULL;

    protected function findConf($id) {
        if ($this->conf == NULL) {
            $this->conf = Conf::model()->findByUrn($id);
            if (is_null($this->conf)) {
                throw new CHttpException(404, Yii::t('admin', 'Conference not found.'));
            }
        }
        return $this->conf;
    }

    public function actionSettings($id) {
        $id = (int) $id;
        $conf = $this->findConf($id);
        if (isset($_POST['Conf'])) {
            $conf->scenario = 'settings';
            $conf->attributes = $_POST['Conf'];
            if (Yii::app()->user->checkAccess("enableConf")) {
                $conf->is_enabled = $_POST['Conf']['is_enabled'];
            }
            if ($conf->validate()) {
                $transaction = $this->beginTransaction();
                try {
                    $conf->save(false);
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when saving conference settings.", 'error', 'AdminController.actionSettings');
                    throw new CHttpException(400, 'System error.');
                }
                Yii::app()->user->setFlash('success', Yii::t('admin', 'Settings successfully saved.'));
                $this->redirect(array('settings', 'urn' => $conf->urn()));
            }
        }
        $this->render('settings', array('conf' => $conf));
    }

    public function actionDelete($id) {
        $id = (int) $id;
        $conf = $this->findConf($id);
        $urn = $conf->urn();
        if ($conf->hasApprovedParticipants()) {
            $this->redirect(array('settings', 'urn' => $conf->urn()));
        }
        if (Yii::app()->request->isPostRequest) {
            $transaction = $this->beginTransaction();
            try {
                $conf->delete();
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::log("Error occured when deleting conference.", 'error', 'AdminController.actionDelete');
                throw new CHttpException(400, 'System error.');
            }
            Yii::log("Conference deleted, id = {$id}, urn = {$urn}.", 'info', 'AdminController.actionDelete');
        }
        if (Yii::app()->user->checkAccess('admin')) {
            $this->redirect(array('confs/new'));
        }
        $this->redirect(array(Yii::app()->homeUrl));
    }

    public function actionPages($id) {
        $conf = parent::findConf($id);
        $conf_pages = ConfPage::model()->findByConf($conf);
        $menu_items = ConfMenu::defaultMenuItems($conf);
        $emptyConfPage = new ConfPage();
        $emptyConfPage->id = 'EmptyId';
        $emptyConfPage->state = 'new';
        array_push($conf_pages, $emptyConfPage);
        if (isset($_POST['ConfPage'])) {
            $conf_id = $conf->id;
            $listUtility = new UpdatedListUtility('ConfPage', $conf_pages, $_POST['ConfPage'], 'pages');
            $new = $listUtility->getNew();
            $updated = $listUtility->getUpdated();
            $deleted = $listUtility->getDeleted();
            $valid = $listUtility->getValid();
            $valid = $valid && ConfMenu::validateUniqueUrns(array_merge($new, $updated));
            if ($valid) {
                $transaction = $this->beginTransaction();
                try {
                    foreach ($updated as $conf_page) {
                        $conf_page->save();
                    }
                    foreach ($new as $conf_page) {
                        $conf_page->conf_id = $conf_id;
                        $conf_page->save();
                    }
                    foreach ($deleted as $conf_page) {
                        $conf_page->delete();
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when updating conference pages list.", 'error', 'AdminController.actionPages');
                    throw new CHttpException(400, 'System error.');
                }
                Yii::app()->user->setFlash('success', Yii::t('admin', 'List saved successfully.'));
                $this->redirect(array('pages', 'urn' => $conf->urn()));
            } else {
                $conf_pages = $listUtility->getAll();
                foreach ($conf_pages as $i => &$conf_page) {
                    if ($conf_page->state == 'new') {
                        $conf_page->conf_id = $conf_id;
                        $conf_page->id = 'new' . $i;
                    };
                };
                array_push($conf_pages, $emptyConfPage);
            }
        }
        $this->render('pages', array('conf' => $conf, 'conf_pages' => $conf_pages, 'menu_items' => $menu_items));
    }

    public function actionAdmins($id) {
        $conf = parent::findConf($id);
        if (isset($_POST['add'])) {
            $email = isset($_POST['email'])?$_POST['email']:'';
            $user = User::model()->findByEmail($email);
            if ($user) {
                $transaction = $this->beginTransaction();
                try {
                    $admin = new ConfAdmin();
                    $admin->user_id = $user->id;
                    $admin->conf_id = $conf->id;
                    $admin->save();
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when adding conference administrator.", 'error', 'AdminController.actionAdmins');
                    throw new CHttpException(400, 'System error.');
                }
            }
        }
        if (isset($_POST['delete'])) {
            $admins = ConfAdmin::model()->findByConf($conf);
            $transaction = $this->beginTransaction();
            try {
                foreach ($admins as $admin) {
                    $deleted = $_POST['admin'];
                    if ($deleted[$admin->id]) {
                        $admin->delete();
                    }
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::log("Error occured when deleting conference administrator.", 'error', 'AdminController.actionAdmins');
                throw new CHttpException(400, 'System error.');
            }
        }
        $admins = ConfAdmin::model()->findByConf($conf);
        $searchUser = new User();
        $users = array();
        if (isset($_POST['User'])) {
            $searchUser->scenario = 'search';
            $searchUser->attributes = $_POST['User'];
            $users = User::model()->searchAdmins($searchUser);
            if ($users === true) {
                Yii::app()->user->setFlash('searchResult', Yii::t('admin', 'Fill in any search field, please.'));
                $users = array();
            } else if (count($users) == 0) {
                Yii::app()->user->setFlash('searchResult', Yii::t('admin', 'No users found.'));
            }
        }
        $this->render('admins', array('conf' => $conf, 'admins' => $admins, 'searchUser' => $searchUser, 'users' => $users));
    }

    
    public function actionForm($id) {
        $conf = parent::findConf($id);
        $appForm = AppFormSettings::model()->findByConf($conf);
        if (isset($_POST['AppFormSettings'])) {
            $appForm->scenario = 'save';
            $appForm->resetBooleanAttributes();
            $appForm->attributes = $_POST['AppFormSettings'];
            $field = '';
            $fieldName = '';
            $attributes = array('pl_field', 'al_field');
            foreach ($attributes as $attribute) {
                for ($i = 1; $i <= 5; $i++) {
                    $_field = $attribute . $i;
                    if (isset($_POST[$_field])) {
                        $field = $_field;
                        $fieldName = $appForm->value($field . '_name');
                    }
                }
            };
            
            // set order for fields
            $appForm->resetOrders();
            $form_order = 1;
            $author_order = 1;
            $_appForm = $_POST['AppFormSettings'];
            foreach($_appForm as $form_attr => $value){
                $pos = strpos($form_attr,'_enabled');
                if ( ($pos !== FALSE) && !empty($_appForm[$form_attr]) ) {
                    $attr_order = mb_substr($form_attr, 3, $pos - 3, 'UTF-8') . '_order';
                    $appForm->{$attr_order} = $appForm->isAAttribute($attr_order)?$author_order++:$form_order++;
                }; 
                if ($form_attr == 'authors_order') {
                    $appForm->authors_order = $form_order++;
                };
            };             
            
            // add new field if any specified
            // 'addAttribute' new_attribute
            if (isset($_POST['addAttribute'])) {
                $new_attribute = $_appForm['new_pattribute'];
                if (empty($new_attribute)) {
                    $new_attribute = $_appForm['new_aattribute'];    
                }
                if (!empty($new_attribute)) {
                   $appForm->enableAttribute($new_attribute); 
                   $appForm->{$new_attribute . '_order'} = $appForm->isAAttribute($new_attribute)?$author_order++:$form_order++;
                }
            }; 
            
            if ($appForm->validate()) {
                $transaction = $this->beginTransaction();
                try {
                    //  в транзакцию попадает метод afterSave (см. MultilingualBehavior)
                    //  method 'afterSave' executes within transaction
                    $appForm->save(false);
                    
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when updating application form with id={$id}.", 'error', 'Admin.actionForm');
                    throw new CHttpException(400, 'System error.');
                }
                if (!empty($fieldName)) {
                    $this->redirect(array('fieldList', 'urn' => $conf->urn(), 'field' => $field));
                } else {
                    if (empty($field)) {
                        Yii::app()->user->setFlash('success', Yii::t('admin', 'Application form saved successfully.'));
                        if (!empty($new_attribute)) {
                            Yii::app()->user->setFlash('NewFieldAdded', Yii::t('admin', 'New field added.'));
                        }
                    } else {
                        Yii::app()->user->setFlash('EmptyFieldName', Yii::t('admin', 'Input the list name, please.'));
                    }
                    $this->redirect(array('form', 'urn' => $conf->urn()));
                }
            }
        }
        $this->render('form', array('conf' => $conf, 'appForm' => $appForm));
    }

    /**  
     *  $id — идентификатор конференции
     *  $field — идентификатор дополнительного поля-списка
     *  $id — conference identifier
     *  $field — additional field identifier  
     */   
    public function actionFieldList($id, $field) {
        $conf = parent::findConf($id);
        $appForm = AppFormSettings::model()->findByConf($conf);
        $list_id = $appForm->{$field . '_list_id'}; //$id.'_'.$field;
        if (empty($list_id)) {
            $list_id = uniqid("{$id}_");
            $appForm->{$field . '_list_id'} = $list_id;
            $appForm->save(false);
        }
        $list = ListItem::model()->findAllByListId($list_id);
        $count = count($list);
        for ($i = $count; $i < ListItem::COUNT; $i++) {
            $list[] = new ListItem();
        }
        if (isset($_POST['ListItem'])) {
            $valid = true;
            foreach ($_POST['ListItem'] as $i => $ListItem) {
                $list[$i]->scenario = 'save';
                $list[$i]->attributes = $ListItem;
                $list[$i]->num = $i;
                $list[$i]->list_id = $list_id;
                $valid = $list[$i]->validate() && $valid;
            }
            if ($valid) {
                $transaction = $this->beginTransaction();
                try {
                    foreach ($list as $item) {
                        $item->save();
                    };
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when updating list with list_id = {$list_id}.", 'error', 'AdminController.actionFieldList');
                    throw new CHttpException(400, 'System error.');
                }
                Yii::app()->user->setFlash('success', Yii::t('admin', 'The list has been saved.'));
                $this->redirect(array('fieldList', 'urn' => $conf->urn(), 'field' => $field));
            }
        }
        $this->render('fieldList', array('conf' => $conf, 'appForm' => $appForm, 'field' => $field, 'list' => $list));
    }

    public function actionReviewing($id) {
        $conf = $this->findConf($id);
        $this->render('reviewing', array('conf' => $conf));
    }

    public function actionTopics($id) {
        $conf = parent::findConf($id);
        $topics = ConfTopic::model()->findByConf($conf);
        $emptyTopic = new ConfTopic();
        $emptyTopic->id = 'EmptyId';
        $emptyTopic->state = 'new';
        array_push($topics, $emptyTopic);
        if (isset($_POST['ConfTopic'])) {
            $new = array();
            $updated = array();
            $deleted = array();
            $valid = true;
            $number = 1;
            foreach ($_POST['ConfTopic'] as $i => $ConfTopic) {
                $topic = NULL;
                if ($ConfTopic['state'] == 'new') {
                    $topic_id = $ConfTopic['id'];
                    //  пропускаем шаблонный объект
                    //  skip template object
                    if ('EmptyId' != $topic_id) {
                        $topic = new ConfTopic();
                        $topic->conf_id = $conf->id;
                        $topic->state = $ConfTopic['state'];
                        array_push($new, $topic);
                    }
                } else {
                    $topic_id = $ConfTopic['id'];
                    foreach ($topics as &$conf_topic) {
                        if ($conf_topic->id == $topic_id) {
                            $topic = $conf_topic;
                        }
                    }
                    if ($topic) {
                        if ($ConfTopic['state'] == 'deleted') {
                            array_push($deleted, $topic);
                        } else {
                            array_push($updated, $topic);
                        }
                    }
                }
                if ($topic) {
                    $topic->scenario = 'topics';
                    $topic->attributes = $ConfTopic;
                    $topic->number = $number++;
                    $valid = $topic->validate() && $valid;
                }
            }
            $transaction = $this->beginTransaction();
            try {
                foreach ($deleted as $topic) {
                    $topic->delete();
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::log("Error occured when deleting conference topics, conference id = {$id}.", 'error', 'AdminController.actionTopics');
                throw new CHttpException(400, 'System error.');
            }
            if ($valid) {
                $transaction = $this->beginTransaction();
                try {
                    foreach ($updated as $topic) {
                        $topic->save();
                    }
                    foreach ($new as $topic) {
                        $topic->save();
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occurend when updating conference topics, conference id = {$id}.", 'error', 'AdminController.actionTopics');
                    throw new CHttpException(400, 'System error.');
                }
                Yii::app()->user->setFlash('success', Yii::t('admin', 'List of topics successfully saved.'));
                $this->redirect(array('topics', 'urn' => $conf->urn()));
            } else {
                $topics = $updated;
                foreach ($new as $i => &$topic) {
                    $topic->id = 'new' . $i;
                    array_push($topics, $topic);
                }
                array_push($topics, $emptyTopic);
            }
        }
        $this->render('topics', array('conf' => $conf, 'topics' => $topics));
    }

    public function actionMailing($id, $participant_id = NULL) {
        $conf = parent::findConf($id);
        $participant = Participant::model()->findByPk($participant_id);
        $mailing = new MailingForm();
        if (isset($_POST['send']) && !empty($_POST['send'])) {
            if (isset($_POST['MailingForm'])) {
                $mailing->attributes = $_POST['MailingForm'];
                if ($mailing->validate()) {
                    $task = new MailTask();
                    $task->conf_id = $conf->id;
                    $task->status = MailTask::STATUS_NEW;
                    $task->subject = $mailing->subject;
                    $task->body = $mailing->message;
                    $task->nameFrom = StringUtils::stripTags($mailing->getNameFrom($conf));
                    $task->creation_date = time();
                    if ($mailing->recipients == MailingForm::RECIPIENTS_ALL) {
                        $task->recipients = MailTask::RECIPIENTS_ALL;
                    }
                    if ($mailing->recipients == MailingForm::RECIPIENTS_APPROVED) {
                        $task->recipients = MailTask::RECIPIENTS_APPROVED;
                    }
                    if ($mailing->recipients == MailingForm::RECIPIENTS_SELECTIVE) {
                        $templateMailTask = MailTask::model()->findTemplate();
                        $task->recipients = MailTask::RECIPIENTS_SELECTIVE;
                        if ($templateMailTask) {
                            $task->participants = $templateMailTask->participants;
                        }
                    }
                    if ($mailing->recipients == MailingForm::RECIPIENTS_ONE) {
                        $task->recipients = MailTask::RECIPIENTS_ONE;
                        $task->participant_id = $participant->id;
                    }
                    $me = User::model()->findByPk(Yii::app()->user->id);
                    /*if ($mailing->me) {
                        $task->recipients .= ',' . $me->email;
                    }*/
                    $emailFrom = $conf->email;
                    if (empty($emailFrom)) {
                        $emailFrom = $me->email;
                    }
                    $task->emailFrom = $emailFrom;
                    $task->prepareParticipants($conf);
                    $transaction = $this->beginTransaction();
                    try {
                        $task->save();
                        $transaction->commit();
                    } catch (Exception $e) {
                        $transaction->rollback();
                        Yii::log("Error occured when adding new mailing to the conference with id = {$id}.", 'error', 'AdminController.actionMailing');
                        throw new CHttpException(400, 'System error.');
                    }
                    if ($participant == NULL) {
                        $this->redirect(array('mailing', 'urn' => $conf->urn()));
                    } else {
                        $this->redirect(array('mailing', 'urn' => $conf->urn(), 'participant_id' => $participant->id));
                    }
                    
                }
            }
        };
        if (isset($_POST['delete']) && !empty($_POST['delete'])) {
            $task_id = $_POST['MailTask']['id'];
            $task = MailTask::model()->findByPk($task_id);
            if (($task != NULL) && ($task->status == MailTask::STATUS_NEW)) {
                $transaction = $this->beginTransaction();
                try {
                    $task->delete();
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when deleting a mailing from the conference with id = {$id}.", 'error', 'AdminController.actionMailing');
                    throw new CHttpException(400, 'System error.');
                }
                if ($participant == NULL) {
                    $this->redirect(array('mailing', 'urn' => $conf->urn()));
                } else {
                    $this->redirect(array('mailing', 'urn' => $conf->urn(), 'participant_id' => $participant->id));
                }
            };
        };
        if (strpos(Yii::app()->request->urlReferrer, 'recipients')) {
            $mailing->setDefaults($conf, $participant, MailingForm::RECIPIENTS_SELECTIVE);
        } else {
            $mailing->setDefaults($conf, $participant);
        }
        $emailFrom = $conf->email;
        if (empty($emailFrom)) {
            $me = User::model()->findByPk(Yii::app()->user->id);
            $emailFrom = $me->email;
        }
        $mailing->emailFrom = $emailFrom;
        $tasks = array();
        if ($participant == NULL) {
            $tasks = MailTask::model()->findAllByConf($conf);
        } else {
            $tasks = MailTask::model()->findAllByParticipant($participant);
        }
        $this->render('mailing', array('conf' => $conf, 'mailing' => $mailing, 'tasks' => $tasks));
    }

    public function actionRecipients($id) {
        $conf = parent::findConf($id);
        $recipientsForm = new RecipientsForm();       
        if (isset($_POST['RecipientsForm'])) { 
            $recipientsForm->attributes = $_POST['RecipientsForm'];
            $mailTask = MailTask::model()->findTemplate();
            if ($mailTask == NULL){
                $mailTask = new MailTask();
                $mailTask->conf_id = $conf->id;
                $mailTask->status = MailTask::STATUS_TEMPLATE;
            }
            $recipientsForm->transferDataTo($mailTask);
            $transaction = $this->beginTransaction();
            try {
                $mailTask->save();
                $transaction->commit();
            } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when saving recipients for the conference with id = {$id}.", 'error', 'AdminController.actionRecipients');
                    throw new CHttpException(400, 'System error.');
            }
             Yii::app()->user->setFlash('success', Yii::t('admin', 'List of recipients saved successfully.'));
            $this->redirect(array('recipients', 'urn' => $conf->urn()));
        } else {
            $participants = ParticipantView::model()->findByConfSortedByTitle($conf);
            $mailTask = MailTask::model()->findTemplate();
            $recipientsForm->init($conf, $participants, $mailTask);
        }
        $this->render('recipients', array('conf' => $conf, 'recipientsForm' => $recipientsForm));
    }    
        
    public function filters() {
        return array_merge(parent::filters(), array(
            'accessControl',
                )
        );
    }

    public function accessRules() {
        $params = 'array(
            "conf_id"=>Yii::app()->getRequest()->getQuery("id"),
            "user_id"=>Yii::app()->user->id
        )';
        return array(
            array('allow',
                'actions' => array('admins', 'form', 'fieldList', 'mailing', 'recipients' ,'reviewing', 'settings', 'topics', 'delete', 'pages'),
                'expression' => 'Yii::app()->user->checkAccess("modifyConf",' . $params . ')'
            ),
            array('deny',
                'users' => array('*')   // any user
            )
        );
    }

}

?>
