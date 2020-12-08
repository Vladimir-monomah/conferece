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
class MailTask extends ActiveRecord {

    // максимальное количество писем, высылаемое за один запуск планировщика задач
    // maximum number of emails being sent at one launch of the cron scheduler
    const MAX_MSGS_COUNT = 50;

    // идентификатор почтовой задачи
    public $id;
    // идентификатор конференции, для которой высылается письмо 
    // (выполняется массовая рассылка)
    public $conf_id;
    // статус почтовой рассылки
    public $status = MailTask::STATUS_NEW;

    // шаблонная заготовка почтовой задачи, не должна рассылаться
    // используется для запоминания и хранения адресатов выборочной рассылки
    // template mail task, must not be sent
    // used to store recipients of selective mailing
    const STATUS_TEMPLATE = 'template';
    // готовая к рассылке задача
    // new and ready for being sent mail task
    const STATUS_NEW = 'new';
    const STATUS_STARTED = 'started';
    const STATUS_COMPLETED = 'completed';

    //  получатели письма (одна из констант, перечисленных ниже) 
    public $recipients;

    // все заявки на участие
    const RECIPIENTS_ALL = 'all';
    // одобренные заявки на участие
    const RECIPIENTS_APPROVED = 'approved';
    // выборочная рассылка
    const RECIPIENTS_SELECTIVE = 'selective';
    // письмо для одной заявки
    const RECIPIENTS_ONE = 'one';

    // список заявок на участие и электронных адресов, для которых запланирована рассылка
    public $participants = 0;
    // если письмо предназначено для одной заявки на участие, то тут хранится ее идентификатор
    public $participant_id = 0;
    // устарело, замененно на participants
    // хранит данные в старых рассылках, данные не отображаются
    // @deprecated
    public $emails;
    // статистика участников и адресов, для которых письма ушли
    public $success_statistics;
    // статистика участников и адресов, для которых письма НЕ ушли
    public $error_statistics;
    // устарело, переименовано и заменено на error_statistics 
    // адреса, на которые почта не ушла
    // public $error_emails; 
    // общее ожидаемое число разосланных писем
    // (равно числу заявок на участие)
    public $total_count;
    // количество обработанных заявок на участие
    public $skip_count;
    // дата создания почтовой рассылки
    public $creation_date;
    // дата завершения почтовой рассылки
    public $completion_date;
    // тема письма
    public $subject;
    // текст письма
    public $body;
    // адрес электронной почты отправителя 
    // (email конференции)
    public $email_from;
    // имя отправителя
    public $name_from;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{mail_task}}';
    }

    public function getEmailFrom() {
        return $this->email_from;
    }

    public function setEmailFrom($value) {
        $this->email_from = $value;
    }

    public function getNameFrom() {
        return $this->name_from;
    }

    public function setNameFrom($value) {
        $this->name_from = $value;
    }

    public function behaviors() {
        return array(
            'XssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('body'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => XssFilter::$ALLOWED_TAGS
            ),
            'FullXssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('subject'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => array()
        ));
    }

    protected $_conf = NULL;

    public function conf() {
        if ($this->_conf == NULL) {
            $this->_conf = Conf::model()->findByPk($this->conf_id);
        }
        return $this->_conf;
    }

    protected $_participant = NULL;

    public function participant() {
        if (($this->_participant == NULL) && (!empty($this->participant_id))) {
            $this->_participant = Participant::model()->findByPk($this->participant_id);
        }
        return $this->_participant;
    }

    public function prepareParticipants($conf) {
        if ($this->recipients == MailTask::RECIPIENTS_ALL) {
            $participants = ParticipantView::model()->findByConfSortedByTitle($conf);
            $this->participants = $this->packParticipantViews($participants);
        };

        if ($this->recipients == MailTask::RECIPIENTS_APPROVED) {
            $participants = ParticipantView::model()->findByConfSortedByTitle($conf, TRUE);
            $this->participants = $this->packParticipantViews($participants);
        };

        if ($this->recipients == MailTask::RECIPIENTS_ONE) {
            // only single participant_id value is stored now
            $ids = array($this->participant_id);
            $this->participants = $this->loadAndPackParticipants($conf, $ids);
        };

        // field participants already stores selected values
        //if ($this->recipients == MailTask::RECIPIENTS_SELECTIVE){};
    }

    public function generateNameFrom($conf, $language = NULL) {
        /* $confLink = Yii::app()->createAbsoluteUrl('conf/view', array('urn' => $conf->urn()));
          $params = array();
          $params['{confLink}'] = $confLink; */
        $params = array();
        $confTitle = $conf->title();
        if ($language) {
            $confTitle = $conf->title($language);
        };
        $confTitle = Trim($confTitle);
        $params['{confTitle}'] = $confTitle;
        return Yii::t('admin', 'Organizing committee of the conference "{confTitle}"', $params, null, $language);
    }

    public function perform($max_msgs_count = 0) {
        if ($max_msgs_count == 0) {
            $max_msgs_count = MailTask::MAX_MSGS_COUNT;
        };
        if ($this->status == MailTask::STATUS_NEW) {
            $conf = $this->conf();
            $this->status = MailTask::STATUS_STARTED;

            $participants = $this->unpackParticipants($this->participants);
            $this->total_count = count($participants);

            $this->skip_count = 0;

            $this->save();
            return 0;
        };
        $sentMessagesCount = 0;
        if ($this->status == MailTask::STATUS_STARTED) {
            $mail = new MailMessage();
            $mail->subject = $this->subject;
            $mail->body = str_replace('href="/', 'href="http://' . $_SERVER['HTTP_HOST'] . '/', $this->body);
            $mail->emailFrom = $this->emailFrom;
            $participants = $this->participants;
            $participants = $this->unpackParticipants($participants);

            $validator = new CEmailValidator();
            $validator->allowEmpty = FALSE;
            $validator->allowName = TRUE;

            $count = 0;
            $conf = $this->conf();
            $i = 0;
            foreach ($participants as $participant_id => $participant) {
                $i++;
                if ($i <= $this->skip_count) {
                    //  исключаем заявки для которых письма уже разосланы
                    //  remove participants to which emails are already sent
                    continue;
                };
                $authors = $participant['authors'];
                // using locale of the first author
                $locale = $participant['locale'];
                $mail->nameFrom = $this->generateNameFrom($conf, $locale);
                $emailTo = array();
                $invalidEmails = array();
                foreach ($authors as $email) {
                    // пустые электронные адреса пропускаем
                    if (empty($email)) {
                        continue;
                    }
                    // остальные проверяем на соответствие стандарту электронного адреса
                    if ($validator->validateValue($email)) {
                        $emailTo[] = $email;
                    } else {
                        $invalidEmails[] = $email;
                    }
                };

                $mail->emailTo = join(', ', $emailTo);
                $count++;

                if ($mail->send(false)) {
                    $sentMessagesCount += 1;
                } else {
                    $invalidEmails = array_merge($invalidEmails, $emailTo);
                    $emailTo = '';
                };

                if (!empty($invalidEmails)) {
                    $invalidEmails = join(',', $invalidEmails);
                    $stat = "${participant_id}:${locale}:" . $invalidEmails;
                    $len = mb_strlen($stat, 'UTF-8');
                    $this->error_statistics .= "${len}:${stat}";
                };

                if (!empty($emailTo)) {
                    $emailTo = join(',', $emailTo);
                    $stat = "${participant_id}:${locale}:" . $emailTo;
                    $len = mb_strlen($stat, 'UTF-8');
                    $this->success_statistics .= "${len}:${stat}";
                };

                if ($sentMessagesCount == $max_msgs_count) {
                    break;
                };
            };

            $this->skip_count += $count;
            if ($this->skip_count >= $this->total_count) {
                $this->status = MailTask::STATUS_COMPLETED;
                $this->completion_date = time();
            };

            $this->save();
        } // status started
        return $sentMessagesCount;
    }

    /*
     *    Возвращает строку вида:
     *    len:participant_id:locale: Author Name 1 <author1@email.example>, Author Name 2 <author2@email.example>
     * 
     */

    public function loadAndPackParticipant($conf, $participant_id) {
        mb_regex_encoding("UTF-8");
        $authors = Author::model()->findByParticipantId($participant_id, $conf);
        // using locale of the first author
        $locale = $authors[0]->locale;
        $str = "${participant_id}:${locale}:";
        foreach ($authors as $n => $author) {
            $name = $author->authorNameForEmail($locale);
            $email = trim($author->email);
            // remove forbidden characters (brackets and comma)
            $name = mb_ereg_replace('[<>,]', '', $name);
            $email = mb_ereg_replace('[<>,]', '', $email);
            $email = (empty($email) ? $name : "${name} <${email}>");
            $str .= ($n > 0 ? ', ' : ' ') . $email;
        }
        $len = mb_strlen($str, 'UTF-8');
        $str = "${len}:" . $str;
        return $str;
    }

    public function loadAndPackParticipants($conf, $participant_ids) {
        $str = '';
        foreach ($participant_ids as $participant_id) {
            $str .= $this->loadAndPackParticipant($conf, $participant_id);
        }
        return $str;
    }

    public function packParticipantView($participantView) {
        mb_regex_encoding("UTF-8");
        $participant_id = $participantView->id;
        $authors = $participantView->authors; 
        $locale = ''; 
        $n = -1;      
        foreach ($authors as $author_id => $author) {
            $n++;
            if ($n == 0) {
                $locale = $author->locale;
                $str = "${participant_id}:${locale}:";
            };
            $name = $author->authorNameForEmail($locale);
            $email = trim($author->email);
            // remove forbidden characters (brackets and comma)
            $name = mb_ereg_replace('[<>,]', '', $name);
            $email = mb_ereg_replace('[<>,]', '', $email);
            $email = (empty($email) ? $name : "${name} <${email}>");
            $str .= ($n > 0 ? ', ' : ' ') . $email;
        }
        $len = mb_strlen($str, 'UTF-8');
        $str = "${len}:" . $str;
        return $str;
    }

    public function packParticipantViews($participants) {
        $str = '';
        foreach ($participants as $participantView) {
            $str .= $this->packParticipantView($participantView);
        }
        return $str;
    }

    /*
     * Парсит строку вида:
     *     len:participant_id:locale: Author Name 1 <author1@email.example>, Author Name 2 <author2@email.example>len2:participant_id:locale....
     *  
     * Возвращает массив вида:
     *     p[participant_id]['authors'][author_num] = 'Author Name <author@email.example>';
     *     ...
     *     p[participant_id][locale] = 'en';
     * */

    public function unpackParticipants($s) {
        $p = array();
        $arr = explode(":", $s, 2);
        $len = intval($arr[0]);
        while ($len > 0) {
            $s = $arr[1];
            $str = mb_substr($s, 0, $len, 'UTF-8');
            $s = mb_substr($s, $len, mb_strlen($s, 'UTF-8') - $len, 'UTF-8');
            $arr = explode(":", $str, 3);
            $participant_id = intval($arr[0]);
            $locale = $arr[1];
            // let us suppose that author names do not contain commas, they should not
            $arr = explode(',', $arr[2]);
            $p[$participant_id] = array();
            $p[$participant_id]['locale'] = $locale;
            foreach ($arr as $i => $author) {
                $p[$participant_id]['authors'][$i] = trim($author);
            };
            // continue parsing the incoming string
            $arr = explode(":", $s, 2);
            $len = intval($arr[0]);
        };
        return $p;
    }

    /*
     *  Возвращает строку, выполняет обратное действие к unpackParticipants.
     * */

    public function packParticipants($p) {
        mb_regex_encoding("UTF-8");
        $s = '';
        foreach ($p as $participant_id => $participant) {
            $locale = $participant['locale'];
            $str = "${participant_id}:${locale}:";
            $authors = $participant['authors'];
            foreach ($authors as $n => $email) {
                // remove forbidden characters (comma)
                $email = mb_ereg_replace('[,]', '', $email);
                $str .= ($n > 0 ? ', ' : ' ') . $email;
            }
            $len = mb_strlen($str, 'UTF-8');
            $str = "${len}:" . $str;
            $s .= $str;
        }
        return $s;
    }

    protected function detailedStr($str) {
        if (empty($str)) {
            return '';
        };
        $links = '';
        $conf = $this->conf();
        $participants = $this->unpackParticipants($str);
        foreach ($participants as $participant_id => $participant) {
            $title = join(', ', $participant['authors']);
            if (empty($title)) {
                $title = Yii::t('admin', 'none');
            }
            $link = CHtml::encode($title) . '&nbsp;&nbsp;' . CHtml::link(Yii::t('admin', 'application for participation'), Yii::app()->createUrl('participant/view', array('urn' => $conf->urn(), 'participant_urn' => $participant_id)), array('class' => 'action'));
            $links[] = $link;
        }
        $links = join('</li><li>', $links);
        return '<ol><li>' . $links . '</li></ol>';
    }

    public function recipientsStr() {
        $arr = explode(',', $this->recipients);
        $str = '';
        if ($arr[0] == MailTask::RECIPIENTS_ALL) {
            $str = Yii::t('admin', 'all authors');
        };
        if ($arr[0] == MailTask::RECIPIENTS_APPROVED) {
            $str = Yii::t('admin', 'authors of the approved applications for participation');
        };
        if ($arr[0] == MailTask::RECIPIENTS_SELECTIVE) {
            $str = Yii::t('admin', 'selective mailing');
        };
        if ($arr[0] == MailTask::RECIPIENTS_ONE) {
            $str = Yii::t('admin', 'authors of the application for participation');
        };
        if (isset($arr[1])) {
            $str .= ' + ' . $arr[1];
        };
        return $str;
    }

    public function recipientsDetailedStr() {
        return $this->detailedStr($this->participants);
    }

    public function recipientsSuccessStr() {
        return $this->detailedStr($this->success_statistics);
    }

    public function recipientsErrorStr() {
        return $this->detailedStr($this->error_statistics);
    }
    
    public function recipientsResultStatisticsHtml() {
        if (empty($this->participants)) {
            return '';
        }
        $items = '';
        $conf = $this->conf();
        $all = $this->unpackParticipants($this->participants);
        $success = $this->unpackParticipants($this->success_statistics);
        $error = $this->unpackParticipants($this->error_statistics);
        foreach ($all as $participant_id => $participant) {
            $item = '';
            if (isset($success[$participant_id])) {
                $emails = CHtml::encode(join(', ', $success[$participant_id]['authors'])); 
                $item = '<strong>' . Yii::t('admin', 'Sent') . ':</strong>&nbsp;' . (empty($emails)?Yii::t('admin', 'none'):$emails);
            }
            if (isset($error[$participant_id])) {
                $emails = CHtml::encode(join(', ', $error[$participant_id]['authors'])); 
                $item .= (empty($item)?'':'&nbsp;&nbsp;') .'<strong>' . Yii::t('admin', 'Not sent') . ':</strong>&nbsp;' . (empty($emails)?Yii::t('admin', 'none'):$emails);
            }
            
            $item .= '&nbsp;&nbsp;' . CHtml::link(Yii::t('admin', 'application for participation'), Yii::app()->createUrl('participant/view', array('urn' => $conf->urn(), 'participant_urn' => $participant_id)), array('class' => 'action'));
            $items[] = $item;
        }
        $items = join('</li><li>', $items);
        return '<ol><li>' . $items . '</li></ol>';     
    }

    public function scopes() {
        return array(
            'new' => array(
                'condition' => "status='new'"
            ),
            'started' => array(
                'condition' => "status='started'"
            ),
            'template' => array(
                'condition' => "status='template'"
            ),
        );
    }

    public function findAllNew() {
        return $this->new()->findAll();
    }

    public function findAllStarted() {
        return $this->started()->findAll();
    }

    public function findTemplate() {
        return $this->template()->find();
    }

    //только массовые рассылки конференции
    public function findAllByConf($conf) {
        $criteria = new CDbCriteria;
        $criteria->condition = "conf_id=:conf_id and recipients != 'one' and status != 'template'";
        $criteria->params = array(':conf_id' => $conf->id);
        $criteria->order = 'id desc';
        return $this->findAll($criteria);
    }

    // только для одной заявки на участие
    public function findAllByParticipant($participant) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'participant_id=:participant_id';
        $criteria->params = array(':participant_id' => $participant->id);
        $criteria->order = 'id desc';
        return $this->findAll($criteria);
    }

    public function findAllHanging() {
        $twoDays = 2 * 24 * 60 * 60; //  2 дня, 2 days
        $date = time() - $twoDays;
        $criteria = new CDbCriteria;
        $criteria->condition = 'creation_date < :date and completion_date is null ';
        $criteria->params = array(':date' => $date);
        $criteria->order = 'id desc';
        return $this->findAll($criteria);
    }

}

?>
