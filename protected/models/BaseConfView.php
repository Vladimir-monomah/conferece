<?php

/**
 *  Класс используется для отображения меню конференции.
 *  
 *  The class is used to render conference menu.
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class BaseConfView extends ActiveRecord {

    public $id;
    public $is_enabled;
    public $urn;
    public $email;
    public $phone;
    public $fax;
    public $is_guestbook_enabled;
    public $is_registration_enabled;
    public $start_date;
    public $end_date;
    public $registration_end_date;
    public $publication_date;
    public $submission_end_date;
    public $participant_editing_option = ParticipantEditingOption::ANY;
    public $participant_publishing_option = ParticipantPublishingOption::SHORT_LIST;
    //  0 — только доклады, 1 — всех
    //  0 — reports only, 1 — all participants
    public $show_all_participants = 0; 

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{conf}}';
    }

    public function attributeLabels() {
        return array(
            'title' => Yii::t('confs', 'Title'),
            'subject' => Yii::t('confs', 'Subject'),
            'urn' => Yii::t('confs', 'Conference Site Address'),
            'creation_date' => Yii::t('confs', 'Creation Date'),
            'last_update_date' => Yii::t('confs', 'Last Update Date'),
            'start_date' => Yii::t('confs', 'Start Date'),
            'end_date' => Yii::t('confs', 'End Date'),
            'registration_end_date' => Yii::t('confs', 'Registration Due Date'),
            'submission_end_date' => Yii::t('confs', 'Paper Submission Due Date'),
            'publication_date' => Yii::t('confs', 'Publication Date'),
            'place' => Yii::t('confs', 'Place'),
            'website' => Yii::t('confs', 'Website'),
            'fax' => Yii::t('confs', 'Fax'),
            'email' => Yii::t('confs', 'E-mail'),
            'phone' => Yii::t('confs', 'Telephone'),
            'logo' => Yii::t('confs', 'Logo'),
            'infoLetter' => Yii::t('confs', 'Information Letter'),
            'info_letter' => Yii::t('confs', 'Information Letter'),
            'description' => Yii::t('confs', 'Description'),
            'fee' => Yii::t('confs', 'Conference Fee'),
            'accommodation' => Yii::t('confs', 'Accommodation'),
            'committee' => Yii::t('confs', 'Organizing Committee'),
            'program' => Yii::t('confs', 'Conference Program'),
            'address' => Yii::t('confs', 'Organizing Committee Address'),
            'report' => Yii::t('confs', 'Conference Report'),
            'orgs' => Yii::t('confs', 'Organizations'),
            'is_enabled' => Yii::t('confs', 'Conference Enabled'),
            'is_registration_enabled' => Yii::t('admin', 'Оnline Registration Enabled'),
            'conf_languages' => Yii::t('confs', 'Conference Languages'),
            'is_guestbook_enabled' => Yii::t('admin', 'Guestbook Enabled'),
            'is_commenting_enabled' => Yii::t('admin', 'Commenting Enabled'),
            'file_exts' => Yii::t('confs', 'User File Types'),
            'proceedings' => Yii::t('participants', 'Conference proceedings'),
            'menu_title' => Yii::t('confs', '"About Conference" replacement')
        );
    }
   
    /*
     * Возвращает конец даты регистрации, либо дату начала конференции.
     * 
     * Returns the end of the registration date, or the start of the conference start date.
     */
    public function getRegistrationEndDate() {
        return DateUtils::endDay(empty($this->registration_end_date) ? DateUtils::yesterday($this->start_date) : $this->registration_end_date);
    }

    public function getEndDate() {
        return DateUtils::endDay($this->end_date);
    }
    
    /*
     * Возвращает конец даты окончания отправки докладов, либо дату окончания регистрации.
     * 
     * Returns the end of the submission end date or the end of the registration end date. 
     */
    public function getSubmissionEndDate() {
        return empty($this->submission_end_date) ? $this->getRegistrationEndDate() : DateUtils::endDay($this->submission_end_date);
    }

    public function urn() {
        return $this->urn ? $this->urn : $this->id;
    }

    function countParticipants() {
        $sql = "select count(*) from {{participant}} where conf_id=:conf_id";
        $command = $this->dbConnection->createCommand($sql);
        $command->bindValue(":conf_id", $this->id);
        return $command->queryScalar();
    }

    function countApprovedParticipants() {
        $sql = "select count(*) from {{participant}}
             where (conf_id=:conf_id) and (status=" . Participant::STATUS_APPROVED . ")";
        $command = $this->dbConnection->createCommand($sql);
        $command->bindValue(":conf_id", $this->id);
        return $command->queryScalar();
    }

    /**
     *  Участники опубликованы, если:
     *  1) конференция опубликована,
     *  2) режим публикации с настройках конференциии позволяет это делать,
     *  3) не загружены труды конференции,
     *  4) наступила дата публикации.
     * 
     *  Participants are published if:
     *  1) the conference is enabled,
     *  2) participants publishing mode allows doing it,
     *  3) conference proceedings are not uploaded,
     *  4) publication date has come. 
     */
    public function isParticipantsPublished() {
        if (!$this->is_enabled) {
            return false;
        }
        if ($this->participant_publishing_option == ParticipantPublishingOption::HIDDEN) {
            return false;
        }
        if ($this->hasProceedings()) {
            return false;
        }
        $now = DateUtils::today();
        $date = $this->getPublicationDate();
        if (empty($date)) {
            return false;
        }
        if ($date > $now) {
            return false;
        }
        return true;
    }

    public function getPublicationDate() {
        return DateUtils::startDay(empty($this->publication_date) ? DateUtils::tomorrow($this->end_date) : $this->publication_date);
    }
    
    
    public function getPublicationDateStr() {
        return DateUtils::getDateStr($this->getPublicationDate());       
    }
 
    public function hasProceedings() {
        //  по умолчанию накладываем более строгое условие 
        //  default case
        return true;
    }

}

?>
