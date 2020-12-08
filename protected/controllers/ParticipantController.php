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
class ParticipantController extends BaseConfController {

    const MAX_REPORTS_COUNT = 30;

    protected function setActiveMenuItem(CAction $action) {
        $url = 'participant/list';
        if (in_array($action->id, array('create', 'application', 'submitReport', 'submitApplication'))) {
            $url = 'participant/application';
        };
        if ($action->id == 'myApplication') {
            $url = 'participant/myApplication';
        };
        $conf_id = $_GET['conf_id'];
        $participant_id = isset($_GET['participant_id'])?$_GET['participant_id']:'';
        if (in_array($action->id, array('view', 'edit', 'save')) && Yii::app()->authManager->isOwner('Participant', $participant_id) && !Yii::app()->authManager->isConfAdmin($conf_id) && !Yii::app()->authManager->isAdmin()) {
            $url = 'participant/myApplication';
        };
        foreach ($this->confMenu as $i => &$menuItem) {
            if ($menuItem['url'][0] == $url) {
                $menuItem['active'] = true;
                break;
            }
        }
        //  registration on the website disabled
        $this->userMenu[8]['visible'] = false;
    }

    public function actionIndex() {
        throw new CHttpException(400, Yii::t('participants', 'Forbidden.'));
    }

    /**
     * Просмотр списка участников простым пользователем.
     * 
     * Если пользователь - админ, 
     *   то перенаправляем его на админскую страницу (action adminAll).
     * Если загружены труды конференции, 
     *   то перенаправляем на страницу трудов конференции.
     * Если нет секций, 
     *        то выводим простой список (actionAll).
     * Если доклады не опубликованы, 
     *    то если по причине, что не наступила дата, 
     *      то выводим сообщение, когда информация будет доступна ($msg + list.php),
     *    если вообще не публикуются, 
     *      то выводим соответсвующее сообщение ($msg + list.php).
     * Если опубликованы, но не найден ни один участник (см. Настройки, Настройка списка публикации),
     *    то выводим соответсвующее сообщение  ($msg + list.php).    
     * Если найдены, 
     *    то если режим публикации = Показывать количество,
     *      то выводим сообщение о количестве участников,
     *    если режим публикации = Показывать список, 
     *        то выводим список с секциями ($topicGroups + $participantCount + list.php),
     *        но без ссылок на страницы докладов,
     *    если режим публикации = Показывать список и полные тексты,
     *        то выводим список с секциями и ссылками на страницы докладов.
     * 
     * Viewing list of participants by a user (not administrator).
     * 
     * If a user is an administrator then
     *      redirecting him to admin page (action adminAll).
     * If the conference proceedings uploaded then
     *      redirecting a user to the proceedings page.
     * If there is no topic in a conference then
     *      show simple list (actionAll).
     * If reports are not published
     *      then if publication date has not came,
     *          then show message when the information will be available ($msg + list.php), 
     *      if publication is not allowed
     *          then show an appropriate message ($msg + list.php).
     * If published but there is not any participant (see Settings, Participants publishing mode),
     *      then show an appropriate message ($msg + list.php).
     * If some participants exist
     *      then if 'Participants publishing mode' = 'Show amount only' 
     *          then show a message with participants amount,
     *      if 'Participants publishing mode' = 'Show list without full texts'
     *          then show a list with topics ($topicGroups + $participantCount + list.php) 
     *          but without links to reports pages,
     *      if 'Participants publishing mode' = 'Show list with full texts'
     *          then show list with tipics and link to reports pages.   
     */
    public function actionList($id) {
        //  если пользователь - админ, то перенаправляем его на админскую страницу
        //  if a user is an administrator then redirecting him to admin page
        $params = array('conf_id' => $id, 'user_id' => Yii::app()->user->id);
        if (Yii::app()->user->checkAccess("viewAllParticipants", $params)) {
            return $this->actionAdminList($id);
        }
        $conf = $this->findConf($id);
        if ($conf->hasProceedings()) {
            $this->redirect(array('conf/proceedings', 'urn' => $conf->urn()));
        };
        //  если нет секций, то выводим простой список
        //  if there is no topic then show simple list
        if ($conf->topicCount == 0) {
            return $this->actionAll($id);
        }
        $msg = '';
        $published = $conf->is_enabled && ($conf->participant_publishing_option != ParticipantPublishingOption::HIDDEN);
        $publishedDateOK = true;
        $now = DateUtils::today();
        $date = $conf->getPublicationDate();
        if (empty($date) || ($date > $now)) {
            $publishedDateOK = false;
        }
        //  если доклады не опубликованы из-за того, что не наступила дата
        //  if reports are not published because publication date has not came yet
        if ($published && !$publishedDateOK) {
            $msg = Yii::t('participants', 'Information about participants will be published on {publication_date}.', array('{publication_date}' => $conf->getPublicationDateStr()));
        }
        //  если доклады вообще не публикуются
        //  if reports are not published anyway
        if (!$published) {
            $msg = Yii::t('participants', 'Information about participants is not available.');
        }
        $topicGroups = array();
        $participantCount = 0;
        $showLinks = false;
        $showSpeaker = false;
        if (empty($msg)) {
            $userView = true;
            $topicGroups = ConfTopic::model()->getTopicGroups($conf, $userView, $participantCount);
            if ($conf->show_images) {
                $settings = AppFormSettings::model()->findByConf($conf);
                $showSpeaker = $settings->isAttributePublished('image' , 'ANY');
            };
            //  если найдены и режим публикации = Показывать количество,
            //  то выводим сообщение о количестве участников
            //  
            //  if there are some participants and 'Participants publishing mode' = 'Show amount only' 
            //  then show an appropriate message  
            if ($conf->participant_publishing_option == ParticipantPublishingOption::AMOUNT) {
                $msg = Yii::t('participants', 'In conference participate {count} people.', array('{count}' => $participantCount));
            };
            //  не найден ни один участник
            //  is there not any participant found
            if ($participantCount == 0) {
                $msg = Yii::t('participants', 'Not found any participant.');
            };
            if ($conf->participant_publishing_option == ParticipantPublishingOption::FULL_LIST) {
                $showLinks = true;
            }
        }
        $this->render('list', array('conf' => $conf, 'msg' => $msg, 'topicGroups' => $topicGroups, 'participantCount' => $participantCount, 'showLinks' => $showLinks, 'showSpeaker' => $showSpeaker));
    }

    /**
     * Просмотр списка участников выбранной секции простым пользователем.
     * 
     * Если пользователь - админ, 
     *   то перенаправляем его на админскую страницу (action adminTopicList).
     * Если загружены труды конференции, 
     *   то перенаправляем на страницу с Трудами.
     * Если не указана секция или "без секции",
     *   то перенаправляем на страницу участников.
     * Если доклады не опубликованы, 
     *    то если по причине, что не наступила дата, 
     *      то выводим сообщение, когда информация будет доступна ($msg + topicList.php),
     *    если вообще не публикуются, 
     *      то выводим соответсвующее сообщение ($msg + topicList.php).
     * Если опубликованы, но не найден ни один участник (см. Настройки, Настройка списка публикации),
     *    то выводим соответсвующее сообщение  ($msg + topicList.php).    
     * Если найдены, 
     *    то если режим публикации = Показывать количество,
     *      то выводим сообщение о количестве участников,
     *    если режим публикации = Показывать список, 
     *        то выводим список без ссылок на страницы докладов,
     *    если режим публикации = Показывать список и полные тексты,
     *        то выводим список со ссылками на страницы докладов.
     * 
     * Viewing list of participants of selected topic by a user (not an administrator).
     * If a user is not an administrator
     *      then redirecting him to admin page (action adminTopicList).
     * If the conference proceeding are uploaded 
     *      then redirecting to the proceedings page.
     * If the topic is not specified or if it equals "without topic"
     *      then redirecting to the whole list page.
     * If reports are not published
     *      then if because publication date has not came yet
     *          then showing a message when the information will be available ($msg + topicList.php),
     *      if publication is not allowed
     *          then show an appropriate message ($msg + list.php).
     * If participants are published but there is no one participant (see Settings, Participants publishing mode)
     *      then show an appropriate message ($msg + list.php)
     * If there some participants exists
     *      then if 'Participants publishing mode' = 'Show amount only' 
     *          then show a message with participants amount,
     *      if 'Participants publishing mode' = 'Show list without full texts'
     *          then show a list with topics ($topicGroups + $participantCount + list.php) 
     *          but without links to reports pages,
     *      if 'Participants publishing mode' = 'Show list with full texts'
     *          then show list with tipics and link to reports pages.   
     */
    public function actionTopicList($id, $topic_id) {
        $params = array('conf_id' => $id, 'user_id' => Yii::app()->user->id);
        if (Yii::app()->user->checkAccess("viewAllParticipants", $params)) {
            return $this->actionAdminTopicList($id, $topic_id);
        };
        $conf = $this->findConf($id);
        if ($conf->hasProceedings()) {
            $this->redirect(array('conf/proceedings', 'urn' => $conf->urn()));
        };
        //  если без секции, то редирект
        //  if no topic is specified then redirecting
        if (empty($topic_id)) {
            $this->redirect(array('participant/list', 'urn' => $conf->urn()));
        }
        $msg = '';
        $published = $conf->is_enabled && ($conf->participant_publishing_option != ParticipantPublishingOption::HIDDEN);
        $publishedDateOK = true;
        $now = DateUtils::today();
        $date = $conf->getPublicationDate();
        if (empty($date) || ($date > $now)) {
            $publishedDateOK = false;
        }
        //  если доклады не опубликованы из-за того, что не наступила дата
        //  if resports are not published because publication date has not came yet
        if ($published && !$publishedDateOK) {
            $msg = Yii::t('participants', 'Information about participants will be published on {publication_date}.', array('{publication_date}' => $conf->getPublicationDateStr()));
        }
        //  если доклады вообще не публикуются (в т.ч. без секции)
        //  if publication of reports is disabled
        if (!$published) {
            $msg = Yii::t('participants', 'Information about participants is not available.');
        }
        $topic = ConfTopic::model()->findByPk($topic_id);
        $participants = array();
        $showLinks = false;
        $showSpeaker = false;
        if (empty($msg)) {
            if ($conf->participant_publishing_option == ParticipantPublishingOption::FULL_LIST) {
                $showLinks = true;
            }
            if ($conf->show_images) {
                $settings = AppFormSettings::model()->findByConf($conf);
                $showSpeaker = $settings->isAttributePublished('image', 'ANY');
            };
            //  для пользователя показываем только одобренные
            //  for a simple user show approved participants only
            if ($conf->show_all_participants) {
                //  показываем всех участников
                //  show all participants
                $participants = Participant::model()->approved()->findByTopic($conf, $topic);
            } else {
                //  показываем только доклады
                //  show reports only
                $participants = Participant::model()->approved()->reports()->findByTopic($conf, $topic);
            }
            //  если найдены и режим публикации = Показывать количество,
            //  то выводим сообщение о количестве участников
            //  
            //  if there are some participants and 'Participants publishing mode' = 'Show amount only'
            //  then show a message about amount of participants
            if ($conf->participant_publishing_option == ParticipantPublishingOption::AMOUNT) {
                $msg = Yii::t('participants', 'In topic participate {count} people.', array('{count}' => count($participants)));
            };
            //  не найден ни один участник
            //  no one participant found
            if (count($participants) == 0) {
                $msg = Yii::t('participants', 'Not found any participant.');
            };
        };
        $this->render('topicList', array('conf' => $conf, 'msg' => $msg, 'topic' => $topic, 'participants' => $participants, 'showLinks' => $showLinks, 'showSpeaker' => $showSpeaker));
    }

    /**
     * Просмотр простого списка всех участников простым пользователем.
     * 
     * Если пользователь - админ, 
     *   то перенаправляем его на админскую страницу (action adminAll).
     * Если загружены труды конференции,
     *   то перенаправляем на страницу трудов конференции.
     * Если доклады не опубликованы, 
     *    то если по причине, что не наступила дата, 
     *      то выводим сообщение, когда информация будет доступна ($msg + topicList.php),
     *    если вообще не публикуются, 
     *      то выводим соответсвующее сообщение ($msg + topicList.php).
     * Если опубликованы, но не найден ни один участник (см. Настройки, Настройка списка публикации),
     *    то выводим соответсвующее сообщение  ($msg + topicList.php).    
     * Если найдены, 
     *    то если режим публикации = Показывать количество,
     *      то выводим сообщение о количестве участников,
     *    если режим публикации = Показывать список, 
     *        то выводим список без ссылок на страницы докладов,
     *    если режим публикации = Показывать список и полные тексты,
     *        то выводим список со ссылками на страницы докладов.
     * 
     * Viewing a simple list of all participants by a simple user (not an administrator).
     * 
     * If a user is an administrator,
     *      then redirecting him to the admin page (action adminAll).
     * If the conference proceedings are uploaded
     *      then redirecting to the proceedings page.
     * If reports are not published
     *      then if because publication date has not came yet
     *          then showing a message when the information will be available ($msg + topicList.php),
     *      if publication is not allowed
     *          then show an appropriate message ($msg + list.php).
     * If particippants are published but there is no one participant (see Settings, Participants publishing mode)
     *      then show an appropriate message ($msg + list.php)
     * If there some participants exists
     *      then if 'Participants publishing mode' = 'Show amount only' 
     *          then show a message with amount of participants,
     *      if 'Participants publishing mode' = 'Show list without full texts'
     *          then show a list with topics ($topicGroups + $participantCount + list.php) 
     *          but without links to reports pages,
     *      if 'Participants publishing mode' = 'Show list with full texts'
     *          then show list with tipics and link to reports pages.   
     */
    public function actionAll($id) {
        $params = array('conf_id' => $id, 'user_id' => Yii::app()->user->id);
        if (Yii::app()->user->checkAccess("viewAllParticipants", $params)) {
            return $this->actionAdminAll($id);
        }
        $conf = $this->findConf($id);
        if ($conf->hasProceedings()) {
            $this->redirect(array('conf/proceedings', 'urn' => $conf->urn()));
        };
        $msg = '';
        $published = $conf->is_enabled && ($conf->participant_publishing_option != ParticipantPublishingOption::HIDDEN);
        $publishedDateOK = true;
        $now = DateUtils::today();
        $date = $conf->getPublicationDate();
        if (empty($date) || ($date > $now)) {
            $publishedDateOK = false;
        }
        //  если доклады не опубликованы из-за того, что не наступила дата
        //  if reports are not published because publication date has not came yet
        if ($published && !$publishedDateOK) {
            $msg = Yii::t('participants', 'Reports will be published on {publication_date}.', array('{publication_date}' => $conf->getPublicationDateStr()));
        }
        //  если доклады вообще не публикуются
        //  if publication of reports is disabled
        if (!$published) {
            $msg = Yii::t('participants', 'Information about participants is not available.');
        }
        $participants = array();
        $showLinks = false;
        $showSpeaker = false;
        if (empty($msg)) {
            if ($conf->participant_publishing_option == ParticipantPublishingOption::FULL_LIST) {
                $showLinks = true;
            };
            if ($conf->show_images) {
                $settings = AppFormSettings::model()->findByConf($conf);
                $showSpeaker = $settings->isAttributePublished('image', 'ANY');
            };
            //  для пользователя показываем только одобренные
            //  for a user only approved participants show
            if ($conf->topicCount == 0) {
                //  если нет секций, то все одобренные доклады   
                //  if there is not any topic then show all approved reports
                if ($conf->show_all_participants) {
                    //  показываем всех участников
                    //  show all participants
                    $participants = ParticipantView::model()->findApprovedByConf($conf, $showSpeaker);
                } else {
                    //  показываем только доклады
                    //  show reports only
                    $participants = ParticipantView::model()->findApprovedReportsByConf($conf, $showSpeaker);
                }
            } else {
                //  если есть секции, то все одобренные доклады с секциями
                if ($conf->show_all_participants) {
                    //  показываем всех участников
                    $participants = ParticipantView::model()->findApprovedWithTopicByConf($conf, $showSpeaker);
                } else {
                    //  показываем только доклады
                    $participants = ParticipantView::model()->findApprovedReportsWithTopicByConf($conf, $showSpeaker);
                }
            };
            //  если найдены и режим публикации = Показывать количество,
            //  то выводим сообщение о количестве участников
            //  
            //  if some participants exist and 'Participants publishing mode' = 'Show amount only'
            //  then show a message with amount of participants
            if ($conf->participant_publishing_option == ParticipantPublishingOption::AMOUNT) {
                $msg = Yii::t('participants', 'In conference participate {count} people.', array('{count}' => count($participants)));
            };
            //  не найден ни один участник
            //  no one participant found
            if (count($participants) == 0) {
                $msg = Yii::t('participants', 'Not found any participant.');
            };
        };
        $this->render('all', array('conf' => $conf, 'msg' => $msg, 'participants' => $participants, 'showLinks' => $showLinks, 'showSpeaker' => $showSpeaker));
    }

    public function actionAdminList($id) {
        $conf = $this->findConf($id);
        if ($conf->topicCount == 0) {
            return $this->actionAdminAll($id);
        }
        $participantCount = 0;
        $topicGroups = ConfTopic::model()->getTopicGroups($conf, false, $participantCount);

        $publishedHint = '';
        $showPublished = true;
        $this->publishedHint($conf, $publishedHint, $showPublished);

        $this->render('adminList', array('conf' => $conf, 'topicGroups' => $topicGroups, 'publishedHint' => $publishedHint, 'showPublished' => $showPublished));
    }

    public function actionAdminAll($id) {
        $conf = $this->findConf($id);
        $showSpeaker = false;
        if ($conf->show_images) {
            $settings = AppFormSettings::model()->findByConf($conf);
            $showSpeaker = $settings->isAttributeEnabled('image', 'ANY');
        };
        $participants = ParticipantView::model()->findByConf($conf, $showSpeaker);
        if (isset($_POST['delete']) && (!empty($_POST['delete']))) {
            $newTopicId = $_POST['new_topic_id'];
            $moved = $_POST['moved'];
            if (!empty($moved)) {
                $transaction = $this->beginTransaction();
                try {
                    foreach ($moved as $movedId => $value) {
                        $participant = Participant::model()->findByPk($movedId);
                        if ($participant != NULL) {
                            $participant->delete();
                        }
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when deleting applications.", 'error', 'ParticipantController.actionAdminTopicList');
                    throw new CHttpException(400, 'System error.');
                }
            }
            Yii::app()->user->setFlash('success', Yii::t('participants', 'Reports deleted.'));
            $this->redirect(array('all', 'urn' => $conf->urn()));
        };
        if (isset($_POST['save']) && (!empty($_POST['save']))) {
            $transaction = $this->beginTransaction();
            try {
                $_participants = $_POST['ParticipantView'];
                if (!empty($_participants)) {
                    foreach ($_participants as $_participant) {
                        foreach ($participants as &$participant) {
                            if ($participant->id == $_participant['id']) {
                                $participant->scenario = 'datetime';
                                $participant->attributes = $_participant;
                                $participant->saveStartDateTime();
                                break;
                            }
                        }
                    };
                };
                //  в транзакцию попадает метод afterSave (см. MultilingualBehavior)
                //  method 'afterSave' executes within transaction
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::log("Error occured when updating participant's date and time.", 'error', 'ParticipantController.actionAdminAll');
                throw new CHttpException(400, 'System error.');
            };

            Yii::app()->user->setFlash('success', Yii::t('participants', 'Information successfully saved.'));
            $this->redirect(array('list', 'urn' => $conf->urn()));
        };

        $publishedHint = '';
        $showPublished = true;
        $this->publishedHint($conf, $publishedHint, $showPublished);

        $this->render('adminAll', array('conf' => $conf, 'participants' => $participants, 'showSpeaker' => $showSpeaker, 'publishedHint' => $publishedHint, 'showPublished' => $showPublished));
    }

    protected function publishedHint($conf, &$publishedHint, &$showPublished) {
        $showPublished = true;
        $publishedHint = Yii::t('participants', 'Published means approved reports with specified topic.');
        if (($conf->topicCount == 0) && ($conf->show_all_participants == 1)) {
            $publishedHint = Yii::t('participants', 'Published means all approved applications for participation.');
            $showPublished = false;
        };
        if (($conf->topicCount == 0) && ($conf->show_all_participants == 0)) {
            $publishedHint = Yii::t('participants', 'Published means approved reports.');
        };
        if (($conf->topicCount > 0) && ($conf->show_all_participants == 1)) {
            $publishedHint = Yii::t('participants', 'Published means approved applications for participation with specified topic.');
        };
    }

    protected function publishedTopicHint($conf, $topic, &$publishedHint, &$showPublished) {
        $showPublished = false;
        if ($topic->id > 0) {
            if (($conf->topicCount > 0) && ($conf->show_all_participants == 0)) {
                $publishedHint = Yii::t('participants', 'Published means approved reports.');
                $showPublished = true;
            };
        };
    }

    public function actionAdminTopicList($id, $topic_id) {
        $conf = $this->findConf($id);
        $topic = ConfTopic::model()->findByPk($topic_id);
        if ($topic == NULL) {
            $topic = ConfTopic::noTopic();
        };
        $participants = Participant::model()->findByTopic($conf, $topic);
        if (isset($_POST['move'])) {
            $newTopicId = isset($_POST['new_topic_id'])?$_POST['new_topic_id']:'';
            $moved = $_POST['moved'];
            if (!empty($moved)) {
                $transaction = $this->beginTransaction();
                try {
                    foreach ($moved as $movedId => $value) {
                        $participant = Participant::model()->findByPk($movedId);
                        if ($participant != NULL) {
                            $participant->topic_id = $newTopicId;
                            $participant->save();
                        }
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when moving participants to the other topic.", 'error', 'ParticipantController.actionAdminTopicList');
                    throw new CHttpException(400, 'System error.');
                }
            }
            Yii::app()->user->setFlash('success', Yii::t('participants', 'Reports moved.'));
            $this->redirect(array('topicList', 'urn' => $conf->urn(), 'topic_urn' => $topic->urn()));
        }
        if (isset($_POST['delete'])) {
            $newTopicId = isset($_POST['new_topic_id'])?$_POST['new_topic_id']:'';
            $moved = $_POST['moved'];
            if (!empty($moved)) {
                $transaction = $this->beginTransaction();
                try {
                    foreach ($moved as $movedId => $value) {
                        $participant = Participant::model()->findByPk($movedId);
                        if ($participant != NULL) {
                            $participant->delete();
                        }
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when deleting participants.", 'error', 'ParticipantController.actionAdminTopicList');
                    throw new CHttpException(400, 'System error.');
                }
            }
            Yii::app()->user->setFlash('success', Yii::t('participants', 'Reports deleted.'));
            $this->redirect(array('topicList', 'urn' => $conf->urn(), 'topic_urn' => $topic->urn()));
        }
        if (isset($_POST['save'])) {
            if ($topic->id != 0) {
                $topic->scenario = 'topic';
                if (isset($_POST['ConfTopic'])) {
                    $topic->attributes = $_POST['ConfTopic'];
                }
                $valid = $topic->validate();
                if ($valid) {
                    $transaction = $this->beginTransaction();
                    try {
                        $topic->save(false);

                        $_participants = $_POST['Participant'];
                        foreach ($_participants as $_participant) {
                            foreach ($participants as &$participant) {
                                if ($participant->id == $_participant['id']) {
                                    $participant->scenario = 'topic';
                                    $participant->attributes = $_participant;
                                    $participant->save(false);
                                    break;
                                }
                            }
                        };

                        //  в транзакцию попадает метод afterSave (см. MultilingualBehavior)
                        //  method 'afterSave' executes within transaction
                        $transaction->commit();
                    } catch (Exception $e) {
                        $transaction->rollback();
                        Yii::log("Error occured when updating topic with id = {$id}.", 'error', 'ParticipantController.actionAdminTopicList');
                        throw new CHttpException(400, 'System error.');
                    }
                };

                Yii::app()->user->setFlash('success', Yii::t('participants', 'Topic successfully saved.'));
                $this->redirect(array('topicList', 'urn' => $conf->urn(), 'topic_urn' => $topic->urn()));
            }
        };
        $topics = ConfTopic::model()->findByConfNameAsc($conf);
        array_unshift($topics, ConfTopic::noTopic());

        $showSpeaker = false;
        if ($conf->show_images) {
            $settings = AppFormSettings::model()->findByConf($conf);
            $showSpeaker = $settings->isAttributeEnabled('image', 'ANY');
        };

        $publishedHint = '';
        $showPublished = false;
        if ($topic->id > 0) {
            $this->publishedTopicHint($conf, $topic, $publishedHint, $showPublished);
        };

        $this->render('adminTopicList', array('conf' => $conf, 'topic' => $topic, 'participants' => $participants, 'topics' => $topics, 'showSpeaker' => $showSpeaker, 'publishedHint' => $publishedHint, 'showPublished' => $showPublished));
    }

    protected function mailTextPreview($conf, $participant, $preferredLanguage) {
        $mailText = '';
        $params = array();
        $confLink = Yii::app()->createAbsoluteUrl('conf/view', array('urn' => $conf->urn()));
        $params['{confLink}'] = $confLink;
        $confTitle = $conf->title($preferredLanguage);
        $confTitle = Trim($confTitle);
        $params['{confTitle}'] = StringUtils::prepareHtml($confTitle);
        $participantLink = Yii::app()->createAbsoluteUrl('participant/view', array('urn' => $conf->urn(), 'participant_urn' => $participant->urn()));
        $params['{participantLink}'] = $participantLink;
        $participantTitle = $participant->title($preferredLanguage);
        if (empty($participantTitle)) {
            $participantTitle = Yii::t('participants', 'Untitled');
        }
        $params['{participantTitle}'] = StringUtils::prepareHtml($participantTitle);
        $params['{status}'] = '<span id = "mail-status-id"></span>';
        $params['{status_reason}'] = '<br /><br /><span id = "mail-status-reason-id"></span>';
        $localizedFileName = Yii::app()->findLocalizedFile('protected/messages/mail/participant_status_changed.php', NULL, $preferredLanguage);
        $msg = file_get_contents($localizedFileName);
        $mailText = Yii::t('fake', $msg, $params);
        return $mailText;
    }
    
    public function actionView($id, $participant_id) {
        $conf = $this->findConf($id);
        $settings = AppFormSettings::model()->findByConf($conf);
        $participant = Participant::model()->findByPk($participant_id);
        $topic = ConfTopic::model()->findByPk($participant->topic_id);
        $topics = array();
        if (Yii::app()->user->checkAccess('enableParticipant', array('conf_id' => $conf->id))) {
            $topics = ConfTopic::model()->findByConfNameAsc($conf);
            array_unshift($topics, ConfTopic::noTopic());
            if ($topic == NULL) {
                $topic = ConfTopic::noTopic();
            };
        };
        $params = array(
            'conf_id' => $conf->id,
            'participant_id' => $participant_id,
            'class' => 'Participant',
            'owner_attr' => 'user_id',
            'id' => $participant_id,
            'user_id' => Yii::app()->user->id);
        $viewUnpublished = Yii::app()->user->checkAccess('modifyParticipant', $params) || Yii::app()->user->checkAccess('owner', $params);
        $authors = $participant->authors;
        $participant->appFormSettings = $settings;
        $preferredLanguage = $authors[0]->locale;
        foreach ($authors as &$author) {
            $author->appFormSettings = $settings;
        };
        $mailTextPreview = $this->mailTextPreview($conf, $participant, $preferredLanguage);
        $this->render('view', array('conf' => $conf, 'topic' => $topic, 'topics' => $topics, 'participant' => $participant, 'authors' => $authors, 
            'settings' => $settings, 'viewUnpublished' => $viewUnpublished, 
            'preferredLanguage' => $preferredLanguage, 'mailTextPreview' => $mailTextPreview));
    }

    public function actionEdit($id, $participant_id) {
        $conf = $this->findConf($id);
        $settings = AppFormSettings::model()->findByConf($conf);
        $participant = Participant::model()->findByPk($participant_id);
        $topic = ConfTopic::model()->findByPk($participant->topic_id);
        if ($topic == NULL) {
            $topic = ConfTopic::noTopic();
        };
        $topics = ConfTopic::model()->findByConfNameAsc($conf);
        array_unshift($topics, ConfTopic::noTopic());
        $authors = $participant->authors;
        $participant->appFormSettings = $settings;
        foreach ($authors as $author) {
            $author->appFormSettings = $settings;
        };
        $captcha = new Captcha();
        $view = 'editReport';
        if ($participant->isApplication()) {
            $view = 'editApplication';
        }
        $this->render($view, array('conf' => $conf, 'topic' => $topic, 'topics' => $topics, 'participant' => $participant, 'authors' => $authors, 'settings' => $settings, 'submitAction' => 'save', 'captcha' => $captcha));
    }

    public function actionApplication($id) {
        $conf = $this->findConf($id);    
        //  если регистрация закончилась
        $registrationFinished = false;
        $params = array('conf_id' => $id, 'user_id' => Yii::app()->user->id);
        if (!Yii::app()->user->checkAccess("createParticipant", $params)) {
            $registrationFinished = true;
        };
        //  если уже есть заявки
        //  if there are some applications exist 
        $userApplications = array();
        if (!Yii::app()->user->isGuest) {
            $userApplications = ParticipantView::model()->findByConfUser($conf, Yii::app()->user);
        };
        $showWithPaperLink = $conf->allowPapers();
        $showWOPaperLink = $conf->allowWoPapers();       
        if (($showWithPaperLink && $showWOPaperLink) || !empty($userApplications) || $registrationFinished) {
            $this->render('application', array('conf' => $conf, 'showWithPaperLink' => $showWithPaperLink, 'showWOPaperLink' => $showWOPaperLink, 'userApplications' => $userApplications, 'registrationFinished' => $registrationFinished));
        } else {
            if ($conf->allowWoPapers()) {
                return $this->actionSubmitApplication($id);
            }
            return $this->actionSubmitReport($id);
        };
    }

    public function actionMyApplication($id) {
        $conf = $this->findConf($id);
        $count = ParticipantView::model()->countByAttributes(array('user_id' => Yii::app()->user->id, 'conf_id' => $id));
        if ($count == 1) {
            $participant = ParticipantView::model()->findByAttributes(array('user_id' => Yii::app()->user->id, 'conf_id' => $id));
            $this->redirect(array('view', 'urn' => $conf->urn(), 'participant_urn' => $participant->urn()));
        };
        $userApplications = ParticipantView::model()->findByConfUser($conf, Yii::app()->user);
        $this->render('myApplications', array('conf' => $conf, 'count' => $count, 'userApplications' => $userApplications));
    }

    /**
     *  Заявка с докладом.
     * 
     *  An application with paper. 
     */
    public function actionSubmitReport($id) {
        $conf = $this->findConf($id);
        $settings = AppFormSettings::model()->findByConf($conf);
        $participant = new Participant();
        $topic = ConfTopic::noTopic();
        $participant->topic_id = $topic->id;
        $participant->appFormSettings = $settings;
        $types = $conf->participation_types_names(ParticipationType::TYPE_PAPER);
        if (!empty($types)) {
            reset($types);
            $first_key = key($types);
            $participant->participation_type = $first_key;
        }
        $topics = ConfTopic::model()->findByConfNameAsc($conf);
        array_unshift($topics, ConfTopic::noTopic());
        $authors = array();
        if (!Yii::app()->user->isGuest) {
            $user = User::model()->findByPk(Yii::app()->user->id);
            $defaultAuthor = Author::createFromUser($user);
            $defaultAuthor->appFormSettings = $settings;
            $authors = array($defaultAuthor);
        }
        $captcha = new Captcha();
        $this->render('editReport', 
                array(  'conf' => $conf, 
                        'topic' => $topic, 
                        'topics' => $topics, 
                        'participant' => $participant, 
                        'authors' => $authors, 
                        'settings' => $settings, 
                        'submitAction' => 'create', 
                        'create_author_account' => false,
                        'captcha' => $captcha)
                );
    }

    /**
     *  Заявка без доклада.
     * 
     *  An application without paper. 
     */
    public function actionSubmitApplication($id) {
        $conf = $this->findConf($id);
        $settings = AppFormSettings::model()->findByConf($conf);
        $participant = Participant::application();
        $topic = ConfTopic::noTopic();
        $participant->topic_id = $topic->id;
        $participant->appFormSettings = $settings;
        $types = $conf->participation_types_names(ParticipationType::TYPE_WO_PAPER);
        if (!empty($types)) {
            reset($types);
            $first_key = key($types);
            $participant->participation_type = $first_key;
        }
        $topics = ConfTopic::model()->findByConfNameAsc($conf);
        array_unshift($topics, ConfTopic::noTopic());
        $authors = array();
        if (!Yii::app()->user->isGuest) {
            $user = User::model()->findByPk(Yii::app()->user->id);
            $defaultAuthor = Author::createFromUser($user);
            $defaultAuthor->appFormSettings = $settings;
            $authors = array($defaultAuthor);
        };
        $captcha = new Captcha();
        $this->render('editApplication', 
                array(  'conf' => $conf, 
                        'topic' => $topic, 
                        'topics' => $topics, 
                        'participant' => $participant, 
                        'authors' => $authors, 
                        'settings' => $settings, 
                        'submitAction' => 'create',
                        'create_author_account' => false,
                        'captcha' => $captcha)
                );
    }

    public function actionCreate($id) {
        $conf = $this->findConf($id);
        $participant = new Participant();
        $participant->registration_date = time();
        $participant->conf_id = $id;
        if (!Yii::app()->user->isGuest) {
            $participant->user_id = Yii::app()->user->id;
        }
        $participant->status = Participant::STATUS_NEW;
        return $this->doSave($conf, $participant, 'create');
    }

    public function actionSave($id, $participant_id) {
        $conf = $this->findConf($id);
        $participant = Participant::model()->findByPk($participant_id);
        return $this->doSave($conf, $participant, 'save');
    }

    protected function doSave($conf, $participant, $submitAction) {
        $settings = AppFormSettings::model()->findByConf($conf);
        $captcha = new Captcha();
        $authors = array();
        $create_author_account = false;
        if (isset($_POST['Participant'])) {
            $participant->setConf($conf); //это нужно для валидации //for validation
            $participant->scenario = 'save';
            $participant->attributes = $_POST['Participant'];
            $participant->last_update_date = time();
            $authors = $participant->authors;
            $participant->appFormSettings = $settings;
            $listUtility = new UpdatedListUtility2('Author', $authors, $_POST['Author'], 'save');
            $new = $listUtility->getNew();
            $updated = $listUtility->getUpdated();
            $deleted = $listUtility->getDeleted();
            $valid = $listUtility->getValid();
            $allUpdated = $listUtility->getAllUpdated();

            $validateCaptcha = false;

            // option if we are to create an account for the author
            // нужно ли создавать аккаунт для автора
            $create_author_account = isset($_POST['create_author_account'])?true:false;
                 
            //  создателем считаем текущего пользователя (пока храним NULL), либо
            //  первого автора, если текщий пользователь - гость
            //  
            //  appoint current user a creator (NULL at start) or
            //  the first author if current user is a guest
            $creator = NULL;
            $creator_exists = false; // by default
            
            // владелец заявки (в чьему аккаунту привязана заявка)
            // owner of the application (to whos account it belongs)
            $owner = NULL;
            $owner_exists = false; // by default
            
            // случай, когда заявка на участие подается за другого автора
            if (    !Yii::app()->user->isGuest // пользователь залогинен
                    && $create_author_account // нужно создавать аккаунт
                    && ($submitAction == 'create') // на этапе создания заявки
                    && (Yii::app()->authManager ->isConfAdmin($conf->id, Yii::app()->user->id) || Yii::app()->authManager ->isAdmin()) // админ конфы или сайта
            ) {
                $creator = User::model()->findByPk(Yii::app()->user->id);
                $creator_exists = true;
                
                $owner = $allUpdated[0];
                $owner->email = trim($owner->email);
                $user = User::model()->findByEmail($owner->email);
                if (!empty($user)) {
                    $owner = $user;
                    $owner_exists = true;                
                }
            } // случай, когда пользователь залогинен и подает от своего имени 
            else if (!Yii::app()->user->isGuest) {
                $creator = User::model()->findByPk(Yii::app()->user->id);
                $creator_exists = true;
                
                $owner = $creator; 
                $owner_exists = true;
            }; 
                       
            $userIdentity = NULL;
            //  если гость, то, если пользователь (первый автор) с таким email
            //  зарегистрирован, то проверяем пароль
            //  
            //  if current user is a guest then if the first author's email
            //  is already registered on the website then validate password
            if (Yii::app()->user->isGuest) {
                $creator = $allUpdated[0];
                $creator->email = trim($creator->email);
                $creator->password = trim($creator->password);
                $user = User::model()->findByEmail($creator->email);
                $userIdentity = new UserIdentity($creator->email, $creator->password);
                if (!empty($user)) {
                    $authUser = $userIdentity->findUser();
                    // если гость авторизовался
                    if (!empty($authUser)) {
                        $creator = $user;
                        $creator_exists = true;
                        $owner = $user;
                        $owner_exists = true;
                    } else {
                        //  добавляем автору ошибку, что пароль не верный
                        //  add error to the author that password is not correct
                        $valid = false;
                        $allUpdated[0]->addError('password', Yii::t('validators', 'Password is invalid.'));
                    };
                } else {
                    $validateCaptcha = true;
                    $owner = $creator;
                };
            };
            
            $wi_paper_mode = $participant->isReport();

            //  валидация авторов по настройкам   
            //  validating authors
            $requiredValidator = new CRequiredValidator();
            $requiredOneValidator = new RequiredOneValidator();
            $requiredCurrentValidator = new RequiredOneValidator();
            $requiredCurrentValidator->requiredLang = $participant->editLanguage;
            $requiredEachValidator = new RequiredEachValidator();
            $requiredFileValidator = new RequiredFileValidator();
            $requiredEachValidator->languages = $conf->getLanguages();
            $requiredOneAttributes = array();
            $requiredCurrentAttributes = array();
            $requiredAttributes = array();
            $requiredEachAttributes = array();
            foreach ($allUpdated as $i => &$obj) {
                $obj->appFormSettings = $settings;
                $requiredOneAttributes = array();
                $requiredAttributes = array();
                $requiredEachAttributes = array();
                if ($settings->isAttributeEnabled('lastname', $wi_paper_mode)) {
                    if ($settings->getAttributeMode('lastname', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ONE) {
                        $requiredOneAttributes[] = 'lastname';
                    }
                    if ($settings->getAttributeMode('lastname', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                        $requiredCurrentAttributes[] = 'lastname';
                    }
                    if ($settings->getAttributeMode('lastname', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                        $requiredEachAttributes[] = 'lastname';
                    }
                }
                if ($settings->isAttributeEnabled('firstname', $wi_paper_mode)) {
                    if ($settings->getAttributeMode('firstname', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ONE) {
                        $requiredOneAttributes[] = 'firstname';
                    }
                    if ($settings->getAttributeMode('firstname', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                        $requiredCurrentAttributes[] = 'firstname';
                    }
                    if ($settings->getAttributeMode('firstname', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                        $requiredEachAttributes[] = 'firstname';
                    }
                }
                if ($settings->isAttributeEnabled('middlename', $wi_paper_mode)) {
                    if ($settings->getAttributeMode('middlename', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ONE) {
                        $requiredOneAttributes[] = 'middlename';
                    }
                    if ($settings->getAttributeMode('middlename', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                        $requiredCurrentAttributes[] = 'middlename';
                    }
                    if ($settings->getAttributeMode('middlename', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                        $requiredEachAttributes[] = 'middlename';
                    }
                }
                if ($settings->isAttributeEnabled('org', $wi_paper_mode)) {
                    if ($settings->getAttributeMode('org', $wi_paper_mode ) == AppFormSettings::MODE_MANDATORY_ONE) {
                        $requiredOneAttributes[] = 'institution';
                    }
                    if ($settings->getAttributeMode('org', $wi_paper_mode ) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                        $requiredCurrentAttributes[] = 'institution';
                    }
                    if ($settings->getAttributeMode('org', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                        $requiredEachAttributes[] = 'institution';
                    }
                }
                if ($settings->isAttributeEnabled('org_address', $wi_paper_mode)) {
                    if ($settings->getAttributeMode('org_address', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ONE) {
                        $requiredOneAttributes[] = 'institution_address';
                    }
                    if ($settings->getAttributeMode('org_address', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                        $requiredCurrentAttributes[] = 'institution_address';
                    }
                    if ($settings->getAttributeMode('org_address', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                        $requiredEachAttributes[] = 'institution_address';
                    }
                }
                if ($settings->isAttributeEnabled('position', $wi_paper_mode)) {
                    if ($settings->getAttributeMode('position', $wi_paper_mode ) == AppFormSettings::MODE_MANDATORY_ONE) {
                        $requiredOneAttributes[] = 'position';
                    }
                    if ($settings->getAttributeMode('position', $wi_paper_mode ) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                        $requiredCurrentAttributes[] = 'position';
                    }
                    if ($settings->getAttributeMode('position', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                        $requiredEachAttributes[] = 'position';
                    }
                }
                if ($settings->isAttributeEnabled('academic_degree', $wi_paper_mode)) {
                    if ($settings->getAttributeMode('academic_degree', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ONE) {
                        $requiredOneAttributes[] = 'academic_degree';
                    }
                    if ($settings->getAttributeMode('academic_degree', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                        $requiredCurrentAttributes[] = 'academic_degree';
                    }
                    if ($settings->getAttributeMode('academic_degree', $wi_paper_mode ) == AppFormSettings::MODE_MANDATORY_ALL) {
                        $requiredEachAttributes[] = 'academic_degree';
                    }
                }
                if ($settings->isAttributeEnabled('academic_title', $wi_paper_mode )) {
                    if ($settings->getAttributeMode('academic_title', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ONE) {
                        $requiredOneAttributes[] = 'academic_title';
                    }
                    if ($settings->getAttributeMode('academic_title', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                        $requiredCurrentAttributes[] = 'academic_title';
                    }
                    if ($settings->getAttributeMode('academic_title', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                        $requiredEachAttributes[] = 'academic_title';
                    }
                }
                if ($settings->isAttributeEnabled('supervisor', $wi_paper_mode)) {
                    if ($settings->getAttributeMode('supervisor', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ONE) {
                        $requiredOneAttributes[] = 'supervisor';
                    }
                    if ($settings->getAttributeMode('supervisor', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                        $requiredCurrentAttributes[] = 'supervisor';
                    }
                    if ($settings->getAttributeMode('supervisor', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                        $requiredEachAttributes[] = 'supervisor';
                    }
                }
                if ($settings->isAttributeEnabled('country', $wi_paper_mode)) {
                    if ($settings->getAttributeMode('country', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ONE) {
                        $requiredOneAttributes[] = 'country';
                    }
                    if ($settings->getAttributeMode('country', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                        $requiredCurrentAttributes[] = 'country';
                    }
                    if ($settings->getAttributeMode('country', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                        $requiredEachAttributes[] = 'country';
                    }
                }
                if ($settings->isAttributeEnabled('city', $wi_paper_mode)) {
                    if ($settings->getAttributeMode('city', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ONE) {
                        $requiredOneAttributes[] = 'city';
                    }
                    if ($settings->getAttributeMode('city', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                        $requiredCurrentAttributes[] = 'city';
                    }
                    if ($settings->getAttributeMode('city', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                        $requiredEachAttributes[] = 'city';
                    }
                }
                if ($settings->isAttributeEnabled('address', $wi_paper_mode)) {
                    if ($settings->getAttributeMode('address', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ONE) {
                        $requiredOneAttributes[] = 'home_address';
                    }
                    if ($settings->getAttributeMode('address', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                        $requiredCurrentAttributes[] = 'home_address';
                    }
                    if ($settings->getAttributeMode('address', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                        $requiredEachAttributes[] = 'home_address';
                    }
                }
                if ($settings->isAttributeEnabled('phone', $wi_paper_mode)) {
                    if ($settings->getAttributeMode('phone', $wi_paper_mode) != AppFormSettings::MODE_ENABLED) {
                        $requiredAttributes[] = 'phone';
                    }
                }
                if ($settings->isAttributeEnabled('fax', $wi_paper_mode)) {
                    if ($settings->getAttributeMode('fax', $wi_paper_mode) != AppFormSettings::MODE_ENABLED) {
                        $requiredAttributes[] = 'fax';
                    }
                }
                //  для первого автора email обязательный всегда
                //  email is mandatory for the first author
                if ($i == 0) {
                    $requiredAttributes[] = 'email';
                } else
                if ($settings->isAttributeEnabled('email', $wi_paper_mode)) {
                    if ($settings->getAttributeMode('email', $wi_paper_mode) != AppFormSettings::MODE_ENABLED) {
                        $requiredAttributes[] = 'email';
                    }
                }
                if ($settings->isAttributeEnabled('membership', $wi_paper_mode)) {
                    if ($settings->getAttributeMode('membership', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ONE) {
                        $requiredOneAttributes[] = 'membership';
                    }
                    if ($settings->getAttributeMode('membership', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                        $requiredCurrentAttributes[] = 'membership';
                    }
                    if ($settings->getAttributeMode('membership', $wi_paper_mode ) == AppFormSettings::MODE_MANDATORY_ALL) {
                        $requiredEachAttributes[] = 'membership';
                    }
                }
                //  строковые дополнительные поля автора
                //  additional string fields for author
                $scount = $settings->a_field_count(FieldType::STRING);
                for ($j = 1; $j <= $scount; $j++) {
                    $attribute = "as_field{$j}";
                    if ($settings->isAttributeEnabled($attribute, $wi_paper_mode)) {
                        if ($settings->getAttributeMode($attribute, $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ONE) {
                            $requiredOneAttributes[] = "{$attribute}_value";
                        }
                        if ($settings->getAttributeMode($attribute, $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                            $requiredCurrentAttributes[] = "{$attribute}_value";
                        }
                        if ($settings->getAttributeMode($attribute, $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                            $requiredEachAttributes[] = "{$attribute}_value";
                        }
                    }
                }
                //  конец строковые дополнительные поля автора
                //  end of additional string fields for author
                
                //  текстовые дополнительные поля автора
                //  additional text fields for author
                $scount = $settings->a_field_count(FieldType::TEXT);
                for ($j = 1; $j <= $scount; $j++) {
                    $attribute = "at_field{$j}";
                    if ($settings->isAttributeEnabled($attribute, $wi_paper_mode)) {
                        if ($settings->getAttributeMode($attribute, $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ONE) {
                            $requiredOneAttributes[] = "{$attribute}_value";
                        }
                        if ($settings->getAttributeMode($attribute, $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                            $requiredCurrentAttributes[] = "{$attribute}_value";
                        }
                        if ($settings->getAttributeMode($attribute, $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                            $requiredEachAttributes[] = "{$attribute}_value";
                        }
                    }
                }
                //  конец текстовые дополнительные поля автора
                //  end of additional text fields for author
                
                //  дополнительные поля-флажки автора
                //  additional checkbox fields for author
                $scount = $settings->a_field_count(FieldType::CHECKBOX);
                for ($j = 1; $j <= $scount; $j++) {
                    $attribute = "ac_field{$j}";
                    if ($settings->isAttributeEnabled($attribute, $wi_paper_mode)) {
                        if ($settings->getAttributeMode($attribute, $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                            $objAttribute = "{$attribute}_value";
                            $value = $obj->{$objAttribute};
                            $message = Yii::t('yii', '{attribute} cannot be blank.', array('{attribute}' => $settings->{$attribute . '_name'}[Yii::app()->language]));
                            if (empty($value) || $value == "0") {
                                $obj->addError($objAttribute, $message);
                            };
                        }
                    };
                };
                //  конец дополнительные поля-флажки автора
                //  end of additional checkbox fields for author
                
                //  дополнительные поля-списки автора
                //  additional list fields for author
                $scount = $settings->a_field_count(FieldType::SELECT);
                for ($j = 1; $j <= $scount; $j++) {
                    $attribute = "al_field{$j}";
                    if ($settings->isAttributeEnabled($attribute, $wi_paper_mode)) {
                        if ($settings->getAttributeMode($attribute, $wi_paper_mode) == AppFormSettings::MODE_MANDATORY) {
                            $objAttribute = "{$attribute}_value";
                            $value = $obj->{$objAttribute};
                            $message = Yii::t('yii', '{attribute} cannot be blank.', array('{attribute}' => $settings->{$attribute . '_name'}[Yii::app()->language]));
                            if (empty($value) || $value == "0") {
                                $obj->addError($objAttribute, $message);
                            };
                        }
                    };
                };
                //  конец дополнительные поля-списки автора
                //  end of additional list fields for author
                
                $requiredValidator->attributes = $requiredAttributes;
                $requiredValidator->validate($obj, NULL);
                $requiredOneValidator->attributes = $requiredOneAttributes;
                $requiredOneValidator->validate($obj, NULL);
                $requiredCurrentValidator->attributes = $requiredCurrentAttributes;
                $requiredCurrentValidator->validate($obj, NULL);
                $requiredEachValidator->attributes = $requiredEachAttributes;
                $requiredEachValidator->validate($obj, NULL);
                
                //  изображение автора
                //  author's image
                if ($settings->isAttributeEnabled('image', $wi_paper_mode)) {
                    $requiredFileValidator->required = $settings->getAttributeMode('image', $wi_paper_mode);
                    $requiredFileValidator->attributes = array('image');
                    $requiredFileValidator->validate($obj, NULL);
                }
                
                // валидация файлов автора
                // author files validation
                $fcount = $settings->p_field_count(FieldType::FILE);
                for ($j = 1; $j <= $fcount; $j++) {
                    $attribute = "af_field{$j}";
                    if ($settings->isAttributeEnabled($attribute, $wi_paper_mode)) {
                        $requiredFileValidator->required = $settings->getAttributeMode($attribute, $wi_paper_mode);
                        $requiredFileValidator->required_language = $participant->editLanguage;
                        $requiredFileValidator->required_languages = $conf->getLanguages();
                        $requiredFileValidator->attributes = array("${attribute}_files");
                        $requiredFileValidator->validate($obj, NULL);
                    }
                }
                
                $valid = $valid && !$obj->hasErrors();
            };
            //  валидация остальных полей доклада по настройкам
            //  validating other fields
            $requiredOneAttributes = array();
            $requiredCurrentAttributes = array();
            $requiredAttributes = array();
            $requiredEachAttributes = array();

            if ($participant->isReport()) {

                if ($settings->isAttributeEnabled('annotation', $wi_paper_mode )) {
                    if ($settings->getAttributeMode('annotation', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ONE) {
                        $requiredOneAttributes[] = 'annotation';
                    }
                    if ($settings->getAttributeMode('annotation', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                        $requiredCurrentAttributes[] = 'annotation';
                    }
                    if ($settings->getAttributeMode('annotation', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                        $requiredEachAttributes[] = 'annotation';
                    }
                }
                if ($settings->isAttributeEnabled('report_title', $wi_paper_mode)) {
                    if ($settings->getAttributeMode('report_title', $wi_paper_mode ) == AppFormSettings::MODE_MANDATORY_ONE) {
                        $requiredOneAttributes[] = 'title';
                    }
                    if ($settings->getAttributeMode('report_title', $wi_paper_mode ) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                        $requiredCurrentAttributes[] = 'title';
                    }
                    if ($settings->getAttributeMode('report_title', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                        $requiredEachAttributes[] = 'title';
                    }
                }
                if ($settings->isAttributeEnabled('classification', $wi_paper_mode)) {
                    if ($settings->getAttributeMode('classification', $wi_paper_mode) != AppFormSettings::MODE_ENABLED) {
                        $requiredAttributes[] = 'classification_code';
                    }
                }
                if ($settings->isAttributeEnabled('report_text', $wi_paper_mode)) {
                    if ($settings->getAttributeMode('report_text', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ONE) {
                        $requiredOneAttributes[] = 'content';
                    }
                    if ($settings->getAttributeMode('report_text', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                        $requiredCurrentAttributes[] = 'content';
                    }
                    if ($settings->getAttributeMode('report_text', $wi_paper_mode ) == AppFormSettings::MODE_MANDATORY_ALL) {
                        $requiredEachAttributes[] = 'content';
                    }
                }
            }
            if ($settings->isAttributeEnabled('more_info', $wi_paper_mode)) {
                if ($settings->getAttributeMode('more_info', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ONE) {
                    $requiredOneAttributes[] = 'information';
                }
                if ($settings->getAttributeMode('more_info', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                    $requiredCurrentAttributes[] = 'information';
                }
                if ($settings->getAttributeMode('more_info', $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                    $requiredEachAttributes[] = 'information';
                }
            }
            //  строковые дополнительные поля
            //  additional string fields
            $scount = $settings->p_field_count(FieldType::STRING);
            for ($j = 1; $j <= $scount; $j++) {
                $attribute = "ps_field{$j}";
                if ($settings->isAttributeEnabled($attribute, $wi_paper_mode)) {
                    if ($settings->getAttributeMode($attribute, $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ONE) {
                        $requiredOneAttributes[] = "{$attribute}_value";
                    }
                    if ($settings->getAttributeMode($attribute, $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                        $requiredCurrentAttributes[] = "{$attribute}_value";
                    }
                    if ($settings->getAttributeMode($attribute, $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                        $requiredEachAttributes[] = "{$attribute}_value";
                    }
                }
            }
            //  конец строковые дополнительные поля
            //  end of additional string fields
            
            //  текстовые дополнительные поля
            //  additional text fields
            $scount = $settings->p_field_count(FieldType::TEXT);
            for ($j = 1; $j <= $scount; $j++) {
                $attribute = "pt_field{$j}";
                if ($settings->isAttributeEnabled($attribute, $wi_paper_mode)) {
                    if ($settings->getAttributeMode($attribute, $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ONE) {
                        $requiredOneAttributes[] = "{$attribute}_value";
                    }
                    if ($settings->getAttributeMode($attribute, $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_CURRENT) {
                        $requiredCurrentAttributes[] = "{$attribute}_value";
                    }
                    if ($settings->getAttributeMode($attribute, $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                        $requiredEachAttributes[] = "{$attribute}_value";
                    }
                }
            }
            //  конец текстовые дополнительные поля
            //  end of additional text fields
            
            //  !!!порядок важен!!!
            //  вызов validate затирает старые ошибки
            //  
            //  !!!the order of operators is important!!!
            //  because executing of 'validate' method clears and overwrites list of errors 
            $participant->validate();

            if ( ($settings->getAttributeMode('report_topic', $wi_paper_mode) != AppFormSettings::MODE_ENABLED) 
                    && ($settings->getAttributeMode('report_topic', $wi_paper_mode) != AppFormSettings::MODE_DISABLED) 
                    && ($conf->topicCount > 0) ) {
                $objAttribute = "topic";
                $value = $participant->topic_id;
                $message = Yii::t('yii', '{attribute} cannot be blank.', array('{attribute}' => $participant->getAttributeLabel('topic')));
                if (empty($value) || $value == "0") {
                    $participant->addError($objAttribute, $message);
                };
            };
            
            $attribute = 'accommodation';
            if ($settings->isAttributeEnabled($attribute, $wi_paper_mode)) {
                    if ($settings->getAttributeMode($attribute, $wi_paper_mode) == AppFormSettings::MODE_MANDATORY) {
                        $objAttribute = "is_{$attribute}_required";
                        $value = $participant->{$objAttribute};
                        $message = Yii::t('yii', '{attribute} cannot be blank.', array('{attribute}' => $participant->getAttributeLabel($objAttribute)));
                        if (empty($value) || $value == "0") {
                            $participant->addError($objAttribute, $message);
                        };
                    }
            }
            
            //  дополнительные поля-флажки
            //  additional checkbox fields
            $scount = $settings->p_field_count(FieldType::CHECKBOX);
            for ($j = 1; $j <= $scount; $j++) {
                $attribute = "pc_field{$j}";
                if ($settings->isAttributeEnabled($attribute, $wi_paper_mode)) {
                    if ($settings->getAttributeMode($attribute, $wi_paper_mode) == AppFormSettings::MODE_MANDATORY) {
                        $objAttribute = "{$attribute}_value";
                        $value = $participant->{$objAttribute};
                        $message = Yii::t('yii', '{attribute} cannot be blank.', array('{attribute}' => $settings->{$attribute . '_name'}[Yii::app()->language]));
                        if (empty($value) || $value == "0") {
                            $participant->addError($objAttribute, $message);
                        };
                    }
                }
            }
            //  конец дополнительные поля-флажки
            //  end of additional checkbox fields
            
            //  дополнительные поля-списки
            //  additional list fields
            $scount = $settings->p_field_count(FieldType::SELECT);
            for ($j = 1; $j <= $scount; $j++) {
                $attribute = "pl_field{$j}";
                if ($settings->isAttributeEnabled($attribute, $wi_paper_mode)) {
                    if ($settings->getAttributeMode($attribute, $wi_paper_mode) == AppFormSettings::MODE_MANDATORY_ALL) {
                        $objAttribute = "{$attribute}_value";
                        $value = $participant->{$objAttribute};
                        $message = Yii::t('yii', '{attribute} cannot be blank.', array('{attribute}' => $settings->{$attribute . '_name'}[Yii::app()->language]));
                        if (empty($value) || $value == "0") {
                            $participant->addError($objAttribute, $message);
                        };
                    }
                }
            }
            //  конец дополнительные поля-списки
            //  endof additional list fields
            
            $requiredValidator->attributes = $requiredAttributes;
            $requiredValidator->validate($participant, NULL);
            $requiredOneValidator->attributes = $requiredOneAttributes;
            $requiredOneValidator->validate($participant, NULL);
            $requiredCurrentValidator->attributes = $requiredCurrentAttributes;
            $requiredCurrentValidator->validate($participant, NULL);
            $requiredEachValidator->attributes = $requiredEachAttributes;
            $requiredEachValidator->validate($participant, NULL);


            $authorsValid = $valid;
            $valid = $valid && !$participant->hasErrors();

            //  если есть ошибки в авторах
            //  if there are some errors in authors
            if (!$authorsValid) {
                $participant->addError('authors', '');
            };

            //  должен быть как миниум один автор
            //  at least one author must be
            if (count($new) + count($updated) == 0) {
                $valid = false;
                $participant->addError('authors', Yii::t('validators', 'At least one author is required.')
                );
            }

            //  капча
            //  captcha
            if ($validateCaptcha) {
                $captcha->scenario = 'captcha';
                $captcha->attributes = $_POST['Captcha'];
                $captcha->validate();
                $valid = $valid && !$captcha->hasErrors();
            }

            //  валидация файлов и видео доклада
            //  report files validation
            if ($participant->isReport()) {
                if ($settings->isAttributeEnabled('report_file', $wi_paper_mode)) {
                    $requiredFileValidator->required = $settings->getAttributeMode('report_file', $wi_paper_mode);
                    $requiredFileValidator->required_language = $participant->editLanguage;
                    $requiredFileValidator->required_languages = $conf->getLanguages();
                    $requiredFileValidator->attributes = array('content_files');
                    $requiredFileValidator->validate($participant, NULL);
                    $valid = $valid && !$participant->hasErrors();
                };                
            };

            // валидация файлов доклада
            // report files validation
            $fcount = $settings->p_field_count(FieldType::FILE);
            for ($j = 1; $j <= $fcount; $j++) {
                $attribute = "pf_field{$j}";
                if ($settings->isAttributeEnabled($attribute, $wi_paper_mode)) {
                    $requiredFileValidator->required = $settings->getAttributeMode($attribute, $wi_paper_mode);
                    $requiredFileValidator->required_language = $participant->editLanguage;
                    $requiredFileValidator->required_languages = $conf->getLanguages();
                    $requiredFileValidator->attributes = array("${attribute}_files");
                    $requiredFileValidator->validate($participant, NULL);
                    $valid = $valid && !$participant->hasErrors();           
                }
            }
            
            if ($valid) {
                $ownerCreated = false;
                $creator_user = $creator;
                $owner_user = $owner;
                $transaction = $this->beginTransaction();
                try {
                    if ($participant->isNewRecord) {
                        
                        if (!$owner_exists) {
                            $owner_user = User::createFromAuthor($owner);
                            $owner_user->scenario = 'register';
                            $userIdentity->password = $owner_user->generateNewPassword();
                            //  чтобы сработал afterValidate и присвоился пароль
                            //  call 'validate' to invoke 'afterValidate' to assing password
                            $owner_user->validate(); 
                            $owner_user->insert();
                            $ownerCreated = true;             
                        }
                        
                        if (!$creator_exists) {
                            $creator_user = $owner_user;
                        }
                        
                        $participant->user_id = $owner_user->id;                        
                        $participant->creator_id = $creator_user->id;
                        
                        $participant->insert();
                    } else {
                        $participant->save(false);
                    };

                    foreach ($updated as $i => $author) {
                        if ($author) {
                            $author->save(false);
                        }
                    };

                    foreach ($new as $author) {
                        if ($author) {
                            $author->participant_id = $participant->id;
                            $author->save(false);
                        }
                    };

                    foreach ($deleted as $author) {
                        if ($author) {
                            $author->delete();
                        }
                    };

                    if ($ownerCreated) {
                        //  чтобы обновить загруженный файл image
                        //  to upload image file
                        $owner = $allUpdated[0]; 
                        $owner_user->refresh();
                        $owner_user->copyAuthorImage($owner);
                        $owner_user->scenario = 'save';
                        $owner_user->save(false);
                    };
                    
                    //  в транзакцию попадает метод afterSave (см. MultilingualBehavior)
                    //  method 'afterSave' executes within transaction (see MultilingualBehavior)
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when updating participant.", 'error', 'ParticipantController.doSave');
                    throw new CHttpException(400, 'System error.');
                };

                $userLoggedIn = false;
                if (Yii::app()->user->isGuest) {
                    //  зайти пользователем в систему
                    //  login
                    $loginForm = new LoginForm();
                    $loginForm->email = $userIdentity->username;
                    $loginForm->password = $userIdentity->password;
                    $loginForm->login();
                    $userLoggedIn = true;
                };

                if ($submitAction == 'create') {
                    $participant->onCreate = array(NotificationService::getInstance(), "nofityParticipantCreated");
                    $participant->onCreate(new CEvent($this, array("participant" => $participant)));
                    if ($ownerCreated && $userLoggedIn) { // из-под незарегистрированного гостя - from guest for new author
                        $flash =  Yii::t('participants', 'Application is submitted for consideration by Scientific Committee.');
                        $flash .= '<br />' . Yii::t('participants', 'A password has been emailed to {email} for You to access the website further.', array('{email}' => Yii::app()->user->name));
                        $flash .= '&nbsp;<a href="' . $this->createUrl('site/logout') . '" class="link" >' . Yii::t('actions','Logout') . '</a>';                  
                        Yii::app()->user->setFlash('userCreated', $flash);
                    } else if ($ownerCreated) { // из-под админа за нового автора - from admin for new author
                        $flash =  Yii::t('participants', 'Application is submitted for consideration by Scientific Committee.');
                        $flash .= '<br />' . Yii::t('participants', 'An email has been sent to {email} with futher instructions how to access the application.', array('{email}' => $owner_user->email));             
                        Yii::app()->user->setFlash('userCreated', $flash);     
                    } else if ((Yii::app()->authManager ->isConfAdmin($conf->id, $creator->id) || Yii::app()->authManager ->isAdmin()) && !$ownerCreated) { // из-под админа за зарегистрированного автора - from admin for existed author
                        $flash =  Yii::t('participants', 'Application is submitted for consideration by Scientific Committee.');
                        $flash .= '<br />' . Yii::t('participants', 'An email has been sent to {email} with futher instructions how to access the application.', array('{email}' => $owner_user->email));                                    
                        Yii::app()->user->setFlash('created', $flash);
                    } else { // остальные случаи - other cases
                        Yii::app()->user->setFlash('created', Yii::t('participants', 'Application is submitted for consideration by Scientific Committee.'));
                    };
                } else {
                    Yii::app()->user->setFlash('saved', Yii::t('confs', 'Information has been saved.'));
                };
                $this->redirect(array('view', 'urn' => $conf->urn(), 'participant_urn' => $participant->urn()));
            }
            $authors = $listUtility->getAllUpdated();
        }

        $topic = ConfTopic::model()->findByPk($participant->topic_id);
        if ($topic == NULL) {
            $topic = ConfTopic::noTopic();
        };
        $topics = ConfTopic::model()->findByConfNameAsc($conf);
        array_unshift($topics, ConfTopic::noTopic());
        $view = 'editReport';
        if ($participant->isApplication()) {
            $view = 'editApplication';
        }
        $this->render($view, 
                array(  'conf' => $conf, 
                        'topic' => $topic, 
                        'topics' => $topics, 
                        'participant' => $participant, 
                        'authors' => $authors, 
                        'settings' => $settings, 
                        'submitAction' => $submitAction, 
                        'create_author_account' => $create_author_account,
                        'captcha' => $captcha)
                );
    }

    public function actionEnable($id, $participant_id) {
        $conf = $this->findConf($id);
        $participant = Participant::model()->findByPk($participant_id);
        if (isset($_POST['Participant'])) {
            $oldStatus = $participant->status;
            $participant->scenario = 'enable';
            $participant->attributes = $_POST['Participant'];
            /*if ($participant->status != Participant::STATUS_DISCARDED) {
                $participant->clear_status_reason();
            }*/
            if ($participant->validate()) {
                $transaction = $this->beginTransaction();
                try {
                    $participant->save(false);
                    //  в транзакцию попадает метод afterSave (см. MultilingualBehavior)
                    //  method 'afterSave' executes within transaction
                    $transaction->commit();
                    //  если статус заявки изменился
                    //  то уведомляем создателя и авторов об этом
                    //  
                    //  if participant's status changed
                    //  then notify creator and authors about it
                    if ($oldStatus != $participant->status) {
                        //  уведомление об изменении статуса доклада
                        //  привязываем обработчик события
                        //  
                        //  notification about changing of participants' status
                        //  attaching event handler
                        $participant->onStatusChanged = array(NotificationService::getInstance(), "nofityParticipantStatusChanged");
                        //  инициируем то событие
                        //  initializing an event
                        $participant->onStatusChanged(new CEvent($this, array("participant" => $participant)));
                        Yii::app()->user->setFlash('status_notification', Yii::t('participants', 'Notification on changing the status has been sent.'));
                    }
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when updating participant.", 'error', 'ParticipantController.actionEnable');
                    throw new CHttpException(400, 'System error.');
                }
            }
        }
        Yii::app()->user->setFlash('success', Yii::t('participants', 'Information successfully saved.'));
        $this->redirect(array('view', 'urn' => $conf->urn(), 'participant_urn' => $participant_id));
    }

    public function actionDeleteTopic($id, $topic_id) {
        if (Yii::app()->request->isPostRequest) {
            $topic = ConfTopic::model()->findByPk($topic_id);
            if ($topic != NULL) {
                $transaction = $this->beginTransaction();
                try {
                    $topic->delete();
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when deleting conference topic.", 'error', 'ParticipantController.actionDeleteTopic');
                    throw new CHttpException(400, 'System error.');
                }
            };
            Yii::app()->user->setFlash('success', Yii::t('participants', 'Topic deleted. Reports moved to "no topic".'));
        }
        $this->redirect(array('list', 'urn' => $id));
    }

    public function filters() {
        return array_merge(
                parent::filters(), 
                array('accessControl',)
        );
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
        );
    }

    public function accessRules() {
        $params = 'array(
            "conf_id" => Yii::app()->getRequest()->getQuery("id"),
            "participant_id" => Yii::app()->getRequest()->getQuery("participant_id"),
            "class" => "Participant",
            "id" => Yii::app()->getRequest()->getQuery("participant_id"),
            "owner_attr" => "user_id",
            "user_id" => Yii::app()->user->id
        )';
        return array(
            array('allow',
                'actions' => array('list', 'topicList', 'All'),
                'expression' => 'Yii::app()->user->checkAccess("viewPublishedParticipants",' . $params . ')'
            ),
            array('allow',
                'actions' => array('adminList', 'adminTopicList', 'deleteTopic', 'adminAll'),
                'expression' => 'Yii::app()->user->checkAccess("viewAllParticipants",' . $params . ')'
            ),
            array('allow',
                'actions' => array('view'),
                'expression' => 'Yii::app()->user->checkAccess("viewPublishedParticipant",' . $params . ')'
            ),
            array('allow',
                'actions' => array('view'),
                'expression' => 'Yii::app()->user->checkAccess("viewParticipant",' . $params . ')'
            ),
            array('allow',
                'actions' => array('application'),
                'expression' => 'Yii::app()->user->checkAccess("accessApplicationPage",' . $params . ')'
            ),
            array('allow',
                'actions' => array('myApplication'),
                'expression' => 'Yii::app()->user->checkAccess("viewMyApplicationPage",' . $params . ')'
            ),
            array('allow',
                'actions' => array('create', 'submitReport', 'submitApplication'),
                'expression' => 'Yii::app()->user->checkAccess("createParticipant",' . $params . ')'
            ),
            array('allow',
                'actions' => array('edit', 'save'),
                'expression' => 'Yii::app()->user->checkAccess("modifyParticipant",' . $params . ')'
            ),
            array('allow',
                'actions' => array('enable'),
                'expression' => 'Yii::app()->user->checkAccess("enableParticipant",' . $params . ')'
            ),
            array('allow',
                'actions' => array('captcha'),
                'users' => array('*'),
            ),
            array('deny',
                'users' => array('*')   //  any user
            )
        );
    }

}

?>
