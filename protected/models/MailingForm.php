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
class MailingForm extends CFormModel {

    const RECIPIENTS_ALL = 1;
    const RECIPIENTS_APPROVED = 2;
    const RECIPIENTS_ONE = 3;
    const RECIPIENTS_SELECTIVE = 4;

    public $recipients = MailingForm::RECIPIENTS_ALL;
    public $subject;
    public $message;
    public $me;
    public $emailFrom = '';
    public $participant = NULL;

    public function getNameFrom($conf, $language = NULL) {
        $confLink = Yii::app()->createAbsoluteUrl('conf/view', array('urn' => $conf->urn()));
        $params = array();
        $params['{confLink}'] = $confLink;
        $confTitle = $conf->title();
        if ($language) {
            $confTitle = $conf->title($language);
        };
        $confTitle = Trim($confTitle);
        $params['{confTitle}'] = $confTitle;
        return Yii::t('admin', 'Organizing committee of the conference <a href="{confLink}">"{confTitle}"</a>.', $params);
    }
    
    public function getGreeting($conf, $participant = NULL) {
        if ($participant != NULL) {
            $confLink = Yii::app()->createAbsoluteUrl('conf/view', array('urn' => $conf->urn()));
            $participantLink = Yii::app()->createAbsoluteUrl('participant/view', array('urn' => $conf->urn(), 'participant_urn' => $participant->urn()));
            $params = array();
            $params['{confLink}'] = $confLink;
            $params['{confTitle}'] = $conf->title();
            $params['{participantLink}'] = $participantLink;
            $params['{participantTitle}'] = $participant->shownTitle();
            return Yii::t('admin', 'Dear authors of the application for participation <a href="{participantLink}">"{participantTitle}"</a> at the conference <a href="{confLink}">"{confTitle}"</a>,', $params);
        }
        return '';
    }

    public function setDefaults($conf, $participant = NULL, $recipients = MailingForm::RECIPIENTS_ALL) {
        $this->subject = Yii::t('site', Yii::app()->name) . '. ';
        $this->message = $this->getGreeting($conf, $participant) . '<br><br><br>' . $this->getNameFrom($conf);
        $this->recipients = $recipients;
        if ($participant != NULL) {
            $this->recipients = MailingForm::RECIPIENTS_ONE;
            $this->participant = $participant;
        }
  
    }
    
    public function rules() {
        return array(
            array('recipients, subject, message', 'required'),
            array('me, participant_id', 'safe')
        );
    }

    public function attributeLabels() {
        return array(
            'recipients' => Yii::t('admin', 'Recipients'),
            'subject' => Yii::t('admin', 'Subject'),
            'message' => Yii::t('admin', 'Message'),
            'me' => Yii::t('admin', 'Send the letter to me'),
            'emailFrom' => Yii::t('admin', 'From'),
        );
    }

    public function countAllRecipients($conf) {
        $count = Author::model()->countAllByConf($conf);
        return $count;
    }

    public function countApprovedRecipients($conf) {
        $count = Author::model()->countApprovedByConf($conf);
        return $count;
    }
      
    public function getParticipantRecipients() {
        $authors = Author::model()->findByParticipant($this->participant);
        $emails = array();
        foreach($authors as $author) {
            $email = $author->email;
            $name = $author->authorNameForEmail();
            $emails[] = CHtml::encode($name . (empty($email)?'':' <' . $email . '>'));          
        }
        $emails = array_unique($emails);
        $emails = join(',<br />', $emails);
        return $emails;
    }

}

?>
