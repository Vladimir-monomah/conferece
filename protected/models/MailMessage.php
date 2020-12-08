<?php

/**
 *  Пример использования (usage example):
 *      $mail = new MailMessage();
 *      //$mail->clear();
 *      $mail->language = $admin->locale();
 *      $mail->emailTo = $admin->email();
 *      $mail->subject = 'A new report has arrived.';
 *      $mail->fileName = 'report_added.php';
 *      $mail->params = array('{confAdmin}' => $admin->fullName($mail->language));;
 *      $mail->conf = $conf;
 *      $mail->participant = $participant;
 *      $mail->send();
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class MailMessage {

    public $emailTo;
    public $subject;
    //  заполняется либо body либо остальные параметры,
    //  на основании которых из файла подгружается body
    //  
    //  body attribute is specified or other attributes based on which
    //  the body is loaded from file
    public $body;
    protected $_language;
    public $fileName;
    public $params = array();
    public $conf;
    public $participant;

    //  следующие атрибуты выставляются автоматически в большинстве случаев
    //  the following attributes are assigned automatically in most of cases
    public $nameFrom;
    public $emailFrom;

    public function setLanguage($language) {
        $this->_language = $language;
    }

    public function getLanguage() {
        if (empty($this->_language)) {
            $this->_language = 'ru';
        }
        return $this->_language;
    }

    public function clear() {
        $this->emailTo = '';
        $this->subject = '';
        $this->body = '';
        $this->conf = NULL;
        $this->participant = NULL;
        $this->params = array();
        $this->fileName = '';
        $this->_language = '';
        $this->emailFrom = '';
    }

    protected function loadBody() {
        $localizedFileName = Yii::app()->findLocalizedFile('protected/messages/mail/' . $this->fileName, NULL, $this->language);
        if (!empty($localizedFileName) && file_exists($localizedFileName)) {
            $msg = file_get_contents($localizedFileName);
            //  Yii::t используется только для того, чтобы подставить параметры
            //  Yii::t is used to substitute parameters
            $this->body = Yii::t('fake', $msg, $this->params);
        }
    }

    protected function setDefaults() {
        if ($this->conf != NULL) {
            $confLink = Yii::app()->createAbsoluteUrl('conf/view', array('urn' => $this->conf->urn()));
            $this->params['{confLink}'] = $confLink;
            $confTitle = $this->conf->title($this->language);
            $confTitle = Trim($confTitle);
            $this->params['{confTitle}'] = StringUtils::prepareHtml($confTitle);
            if ($this->participant != NULL) {
                $participantLink = Yii::app()->createAbsoluteUrl('participant/view', array('urn' => $this->conf->urn(), 'participant_urn' => $this->participant->urn()));
                $this->params['{participantLink}'] = $participantLink;
                $participantTitle = $this->participant->title($this->language);
                if (empty($participantTitle)) {
                    $participantTitle = Yii::t('participants', 'Untitled');
                }
                $this->params['{participantTitle}'] = StringUtils::prepareHtml($participantTitle);
            }
        }
        $this->params['{website}'] = StringUtils::prepareHtml(Yii::t('site', Yii::app()->name, array(), NULL, $this->language));
        $this->params['{websiteLink}'] = Yii::app()->getBaseUrl(true);

        $this->nameFrom = StringUtils::prepareHtml(Yii::t('site', Yii::app()->name, array(), NULL, $this->language));
        if (empty($this->emailFrom)) {
            $this->emailFrom = Yii::app()->params['adminEmail'];
        };
    }

    public function send($setDefaults = true) {
        if ($setDefaults) {
            $this->setDefaults();
            if (empty($this->body)) {
                $this->loadBody();
            }
        }
        //  если тема или текст сообщения отсутсвуют, то не отсылаем
        //  if ther is no topic nor message text then do not send
        if (empty($this->subject) || empty($this->body)) {
            return false;
        }
        $name = '=?UTF-8?B?' . base64_encode($this->nameFrom) . '?=';
        $subject = $this->subject;
        if ($setDefaults) {
            //  в subject добавляется начало - название сайта
            //  website name is prepended to subject
            $subject = Yii::t('site', Yii::app()->name, array(), NULL, $this->language) . '. ';
            $subject.=Yii::t('mail', $this->subject, array(), NULL, $this->language);
        }
        $_subject = $subject;
        $subject = '=?UTF-8?B?' . base64_encode($subject) . '?=';
        $headers = "From: $name <{$this->emailFrom}>\r\n" .
                "Reply-To: {$this->emailFrom}\r\n" .
                "MIME-Version: 1.0\r\n" .
                "Content-type: text/html; charset=UTF-8";
        $emailTo = $this->emailTo;
        if (!empty(Yii::app()->params['testMailTo'])) {
            $emailTo = Yii::app()->params['testMailTo'];
        }
        //$emailTo = '=?UTF-8?B?' . base64_encode($emailTo) . '?=';;
        $res = mail($emailTo, $subject, $this->body, $headers);
        // временная дублирующая отсылка писем
        $conf = $this->conf;
        if ($conf != NULL) {
            if ($conf->id == 975) { //isuf2018
                $subject = '=?UTF-8?B?' . base64_encode('Копия письма. ISUF 2018. ' . $_subject) . '?=';
                $emailTo = 'Ольга Михайловна Чередниченко <ocherednichenko@sfu-kras.ru>';
                //$emailTo = '=?UTF-8?B?' . base64_encode($emailTo) . '?=';
                $res2 = mail($emailTo, $subject, $this->body, $headers);
            };
            /*if ($conf->id == 737) { //test2
                $subject = '=?UTF-8?B?' . base64_encode('Копия письма. ISUF 2018. ' . $_subject) . '?=';
                $emailTo = 'Ольга Михайловна Чередниченко <ocherednichenko@sfu-kras.ru>, Ольга Николаевна Чередниченко <olyacher@inbox.ru>';
                //$emailTo = '=?UTF-8?B?' . base64_encode($emailTo) . '?=';
                $res2 = mail($emailTo, $subject, $this->body, $headers);
            };*/
        };
        // конец временная дублирующая отсылка писем
        return $res;
    }

}

?>
