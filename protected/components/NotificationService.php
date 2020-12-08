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
class NotificationService extends CComponent {

    protected static $_instance = NULL;

    public static function getInstance() {
        if (NotificationService::$_instance == NULL) {
            NotificationService::$_instance = new NotificationService();
        }
        return NotificationService::$_instance;
    }

    protected $_mailMessage = NULL;

    protected function getMailMessage() {
        if ($this->_mailMessage == NULL) {
            $this->_mailMessage = new MailMessage();
        }
        $this->_mailMessage->clear();
        return $this->_mailMessage;
    }

    public function notifyConfCreated($event) {
        $conf = $event->params["conf"];
        //  уведомление администраторам сайта о добавлении новой конференции
        //  notification for the website administratior about creation of new conference 
        $admins = User::model()->findAllAdmins();
        $confLink = Yii::app()->createAbsoluteUrl('conf/view', array('urn' => $conf->urn()));
        $mail = $this->mailMessage;
        foreach ($admins as $user) {
            $mail->clear();
            $mail->language = $user->locale;
            $mail->emailTo = $user->email;
            $mail->subject = 'A new conference has been created';
            $mail->fileName = 'conf_added.php';
            $mail->params = array('{admin}' => $user->fullName($mail->language));
            $mail->conf = $conf;
            $mail->send();
        }
    }

    public function notifyNewPassword($event) {
        //  уведомление пользователю о генерации нового пароля
        //  notification for the user about new password generation
        $user = $event->params["user"];
        $password = $event->params["password"];
        //  высылаем новый пароль
        //  sending new password
        $mail = $this->mailMessage;
        $mail->language = $user->locale;
        $mail->emailTo = $user->email;
        $mail->subject = 'Password recovery';
        $mail->fileName = 'lostpassword.php';
        $mail->params['{user}'] = $user->fullName($mail->language);
        $mail->params['{password}'] = CHtml::encode("{$password}");
        $mail->send();
    }

    public function nofityParticipantDeleted($event) {
        $participant = $event->params["participant"];
        //  уведомление создателя об удалении доклада
        //  notification for the owner about applicaion removal
        $user = $participant->user();
        if ($user) {
            $conf = $participant->conf();
            $mail = $this->mailMessage;
            $mail->language = $user->locale;
            $mail->emailTo = $user->email;
            $mail->subject = 'Your application for participation has been deleted';
            $mail->fileName = 'participant_deleted.php';
            $mail->params = array('{user}' => $user->fullName($mail->language));
            $mail->conf = $conf;
            $mail->participant = $participant;
            $mail->emailFrom = $conf->email;
            $mail->send();
        }
    }

    public function nofityConfAdminAssigned($event) {
        $user = $event->params["user"];
        $conf = $event->params["conf"];
        //  уведомление пользователя о назначении администратором конференции
        //  notification for the user of the appointment by the board administrator
        $mail = $this->mailMessage;
        $mail->language = $user->locale;
        $mail->emailTo = $user->email;
        $mail->subject = 'You are assigned to be conference administrator';
        $mail->fileName = 'conf_admin_assigned.php';
        $mail->params = array('{confAdmin}' => $user->fullName($mail->language));
        $mail->conf = $conf;
        $mail->emailFrom = $conf->email;
        $mail->send();
    }
    
    protected function composeEmail($users, $locale) {
        $emails = array();
        foreach ($users as $user) {
            $email = $user->fullEmail($locale);
            if (!empty($email)) {
                $emails[] = $email;
            }
        }
        return join(', ', $emails);
    }

    public function nofityParticipantStatusChanged($event) {
        //  уведомляем создателя и авторов об изменении статуса доклада
        //  notification for the creator and authors about changing of 
        //  the application status
        $participant = $event->params["participant"];

        $mail = $this->mailMessage;
        $user = $participant->user();
        $conf = $participant->conf();
        $authors = array();
        /* $authors = $participant->authors;
        if ($user != NULL) {
            //  если есть в списке авторов с таким же адресом, то не добавлять
            //  if users' email is already in list then skip
            $found = false;
            foreach ($authors as $author) {
                if ($author->email == $user->email) {
                    $found = true;
                }
            }
            if (!$found) {
                array_push($authors, $user);
            }
        }*/
        array_push($authors, $user);
        $locale = $authors[0]->locale;
        $email = $this->composeEmail($authors, $locale);

        if (!empty($email)) {
            $mail->clear();
            $mail->language = $locale;
            $mail->emailTo = $email;
            $mail->subject = 'The status of your application for participation has changed';
            $mail->fileName = 'participant_status_changed.php';
            //$mail->params['{user}'] = $user->fullName($mail->language);
            $statusStr = 'new';
            if ($participant->status == Participant::STATUS_APPROVED) {
                $statusStr = 'approved';
            };
            if ($participant->status == Participant::STATUS_DISCARDED) {
                $statusStr = 'discarded';
            };
            $status_reason = $participant->status_reason($locale);
            if (!empty($status_reason)) {
                $status_reason = preg_replace("/\n/", "<br />", $status_reason); 
                $status_reason = "<br /><br />" . $status_reason . "<br /><br />";
            };
            $mail->params['{status_reason}'] = $status_reason;

            $mail->params['{status}'] = Yii::t('participants', $statusStr, array(), NULL, $locale);

            $mail->conf = $conf;
            $mail->participant = $participant;
            $mail->emailFrom = $conf->email;
            $mail->send();
        }
    }

    public function nofityUserCreated($event) {
        $user = $event->params["user"];
        //  уведомление пользователя о его регистрации
        //  notification for the user of registration completed
        $mail = $this->mailMessage;
        $mail->language = $user->locale;
        $mail->emailTo = $user->email;
        $mail->subject = 'You have successfully registered';
        $mail->fileName = 'registration.php';
        $mail->params['{user}'] = $user->fullName($mail->language);
        $mail->params['{email}'] = $user->email;
        $mail->params['{password}'] = $user->password1;
        $mail->send();
    }

    public function nofityParticipantCreated($event) {
        $participant = $event->params["participant"];

        $conf = $participant->conf();
        $user = $participant->user();
        $authors = array();
        $authors[] = $user;
        //$authors = Author::model()->findByParticipant($participant);
        $mail = $this->mailMessage;
        foreach ($authors as $author) {
            //  уведомление автору доклада о том, что он подан
            //  notification for the author of application that is it
            //  accepted for consideration
            if (!empty($author->email)) {
                $mail->clear();
                $mail->language = $author->locale;
                $mail->emailTo = $author->email;
                $mail->subject = 'Your application for participation accepted for consideration';
                $mail->fileName = 'participant_recieved.php';
                $mail->params['{author}'] = $author->fullName($mail->language);
                $mail->conf = $conf;
                $mail->participant = $participant;
                $mail->emailFrom = $conf->email;
                $mail->send();
            }
        }
        //  уведомление администраторам конференции о поступлении заявки
        //  notification for the conference administrator about new application arrived
        $admins = ConfAdmin::model()->findByConf($conf);
        foreach ($admins as $admin) {
            $mail->clear();
            $mail->language = $admin->locale();
            $mail->emailTo = $admin->email();
            $mail->subject = 'A new application for participation has arrived';
            $mail->fileName = 'participant_added.php';
            $mail->params = array('{confAdmin}' => $admin->fullName($mail->language));
            $mail->conf = $conf;
            $mail->participant = $participant;
            $mail->emailFrom = $conf->email;
            $mail->send();
        }
    }

    public function notifyComment($event) {
        $participant = $event->params["participant"];
        $comment = $event->params["comment"];
        $oldComment = $event->params["oldComment"];
        $action = $event->params["action"];

        $conf = $participant->conf();
        $authors = Author::model()->findByParticipant($participant);
        $mail = $this->mailMessage;
        foreach ($authors as $author) {
            if (!empty($author->email)) {
                $mail->clear();
                $mail->language = $author->locale;
                $mail->emailTo = $author->email;
                $mail->params = array('{author}' => $author->fullName($mail->language));
                $mail->params['{text}'] = StringUtils::prepareHtml($comment->text);
                if ($oldComment != NULL) {
                    $mail->params['{old_text}'] = StringUtils::prepareHtml($oldComment->text);
                }
                $mail->conf = $conf;
                $mail->participant = $participant;
                $mail->emailFrom = $conf->email;

                if ($action == 'add') {
                    $mail->subject = 'A new comment has been posted';
                    $mail->fileName = 'comment_added.php';
                }

                if ($action == 'delete') {
                    $mail->subject = 'A comment has been deleted';
                    $mail->fileName = 'comment_deleted.php';
                }

                if ($action == 'update') {
                    $mail->subject = 'A comment has been updated';
                    $mail->fileName = 'comment_updated.php';
                }

                $mail->send();
            }
        }
    }

}

?>
