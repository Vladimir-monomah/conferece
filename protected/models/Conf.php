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
class Conf extends ActiveRecord {

    //  сохраняемые поля
    //  permanent fields
    public $id;
    public $is_enabled = 0;
    public $urn;
    public $start_date;
    public $end_date;
    public $registration_end_date;
    public $submission_end_date;
    public $publication_date;
    public $website;
    public $email;
    public $phone;
    public $fax;
    public $creation_date;
    public $last_update_date;
    public $is_registration_enabled;
    public $is_guestbook_enabled;
    public $is_reviewing_enabled;
    public $is_commenting_enabled;
    public $file_exts = '';
    public $conf_languages = array();
    public $participation_types = array(ParticipationType::REPORT);
    public $participant_editing_option = ParticipantEditingOption::DATE;
    public $participant_publishing_option = ParticipantPublishingOption::SHORT_LIST;
    //  0 — только доклады, 1 — всех
    //  0 — reports only, 1 — all participants
    public $show_all_participants = 0;
    //  1 — показывать изображения при просмотре списка, 0 — не показывать
    //  1 — show images when viewing list of participans, 0 — do not show
    public $show_images = 0;
    //  вспомогательные поля
    //  auxiliary fields
    public $participation_paper_types = array(ParticipationType::REPORT);
    public $participation_wo_paper_types = array();
    //  старый адрес
    //  old urn
    public $_oldurn;
    //  многоязычные поля
    //  multilingual fields
    public $title;
    public $subject;
    public $place;
    public $description;
    public $fee;
    public $accommodation;
    public $committee;
    public $program;
    public $address;
    public $report;
    public $contacts;
    // "About Conference" menu translation
    public $menu_title;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{conf}}';
    }

    public function rules() {
        return array(
            array('id', 'unsafe'),
            
            //  create scenario
            array('urn', 'length', 'on' => 'create', 'max' => 30),
            array('urn', 'SiteUrnValidator', 'on' => 'create', 'oldurn' => $this->_oldurn),
            array('conf_languages', 'ConfLanguagesValidator', 'on' => 'create'),
            array('start_date', 'required', 'on' => 'create'),
            array('startDateStr', 'safe', 'on' => 'create'),
            array('end_date', 'required', 'on' => 'create'),
            array('endDateStr', 'safe', 'on' => 'create'),
            array('subject', 'LengthEachValidator', 'on' => 'create', 'max' => 300),
            array('title', 'LengthEachValidator', 'on' => 'create', 'max' => 300),
            array('title', 'RequiredEachValidator', 'on' => 'create', 'languages' => $this->getLanguages()),
            array('creation_date', 'default', 'on' => 'create', 'value' => time()),
            array('last_update_date', 'default', 'on' => 'create', 'value' => time()),
            
            //  info scenario
            array('subject', 'LengthEachValidator', 'on' => 'info', 'max' => 300),
            array('title', 'LengthEachValidator', 'on' => 'info', 'max' => 300),
            array('title', 'RequiredEachValidator', 'on' => 'info', 'languages' => $this->getLanguages()),
            array('urn', 'length', 'on' => 'info', 'max' => 30),
            array('urn', 'SiteUrnValidator', 'on' => 'info', 'oldurn' => $this->_oldurn),
            array('start_date', 'required', 'on' => 'info'),
            array('startDateStr', 'safe', 'on' => 'info'),
            array('end_date', 'required', 'on' => 'info'),
            array('endDateStr', 'safe', 'on' => 'info'),
            array('registrationEndDateStr', 'safe', 'on' => 'info'),
            array('submissionEndDateStr', 'safe', 'on' => 'info'),
            array('place', 'LengthEachValidator', 'on' => 'info', 'max' => 150),
            array('website', 'length', 'on' => 'info', 'max' => 100),
            array('email', 'length', 'on' => 'info', 'max' => 100),
            array('email', 'email', 'on' => 'info'),
            array('phone', 'length', 'on' => 'info', 'max' => 100),
            array('info_letter', 'FilesValidator', 'on' => 'info', 'size' => Yii::app()->params['userFileSize'], 'exts' => Yii::app()->params['fileExts']),
            array('logo', 'FilesValidator', 'on' => 'info', 'size' => Yii::app()->params['userFileSize'], 'exts' => Yii::app()->params['logoExts']),
            
            //  orgs scenario
            array('description', 'safe', 'on' => 'info'),
            array('fee', 'safe', 'on' => 'info'),
            array('accommodation', 'safe', 'on' => 'info'),
            
            //  program scenario
            array('program', 'safe', 'on' => 'program'),
            
            //  committee scenario
            array('committee', 'safe', 'on' => 'committee'),
            
            //  report scenario
            array('report', 'safe', 'on' => 'report'),
            
            //  contacts scenario
            array('address', 'LengthEachValidator', 'on' => 'contacts', 'max' => 150),
            array('phone', 'length', 'on' => 'contacts', 'max' => 100),
            array('fax', 'length', 'on' => 'contacts', 'max' => 100),
            array('email', 'length', 'on' => 'contacts', 'max' => 100),
            array('email', 'email', 'on' => 'contacts'),
            array('contacts', 'safe', 'on' => 'contacts'),
            
            //  settings scenario
            array('is_registration_enabled', 'boolean', 'on' => 'settings'),
            array('conf_languages', 'ConfLanguagesValidator', 'on' => 'settings'),
            array('participant_editing_option', 'safe', 'on' => 'settings'),
            array('participant_publishing_option', 'safe', 'on' => 'settings'),
            array('show_all_participants', 'safe', 'on' => 'settings'),
            array('show_images', 'safe', 'on' => 'settings'),
            array('publicationDateStr', 'safe', 'on' => 'settings'),
            array('participation_paper_types', 'safe', 'on' => 'settings'),
            array('participation_wo_paper_types', 'safe', 'on' => 'settings'),
            array('is_guestbook_enabled', 'boolean', 'on' => 'settings'),
            array('is_commenting_enabled', 'boolean', 'on' => 'settings'),
            array('file_exts', 'ExtListValidator', 'on' => 'settings', 'exts' => Yii::app()->params['fileExts']),
            array('menu_title', 'length', 'on' => 'settings', 'max' => 100),
              
            //  proceedings scenario
            array('proceedings', 'FilesValidator', 'on' => 'proceedings', 'size' => Yii::app()->params['userFileSize'], 'exts' => Yii::app()->params['fileExts']),
            
        );
    }

    public static function newConf() {
        $conf = new Conf();
        $conf->conf_languages = array(Yii::app()->language);
        return $conf;
    }

    protected function beforeSave() {
        if (!parent::beforeSave()){
            return false;
        };
        $this->last_update_date = time();
        //  языки конференции
        //  conference languages
        if (is_array($this->conf_languages)) {
            $conf_languages = '';
            foreach ($this->conf_languages as $value) {
                $conf_languages.=($value . ';');
            }
            $this->conf_languages = $conf_languages;
        }
        //  формы участия
        //  participation types
        if (!is_array($this->participation_paper_types)) {
            $this->participation_paper_types = array();
        }
        if (!is_array($this->participation_wo_paper_types)) {
            $this->participation_wo_paper_types = array();
        }
        $this->participation_types = array_merge(
                $this->participation_paper_types, $this->participation_wo_paper_types
        );
        $types = '';
        foreach ($this->participation_types as $value) {
            $types.=($value . ';');
        }
        $this->participation_types = $types;
        return true;
    }

    public function onCreate($event) {
        $this->raiseEvent("onCreate", $event);
    }

    protected function afterSave() {
        parent::afterSave();
        if ($this->isNewRecord) {
            //  привязываем обработчик события onCreate
            //  attaching a handler for onCreate event
            $this->onCreate = array(NotificationService::getInstance(), "notifyConfCreated");
            //  инициируем это событие
            //  initiating the event
            $this->onCreate(new CEvent($this, array("conf" => $this)));
            //  добавляем urn в таблицу
            //  adding urn to the database
            SiteUrn::model()->addUrn($this->urn);
        } else {
            //  обновляем адрес в базе
            //  updating urn in the database
            if ($this->_oldurn != $this->urn) {
                SiteUrn::model()->replace($this->_oldurn, $this->urn);
            };
        };
        //  обновляем адрес в объекте
        //  updating urn in the object    
        $this->_oldurn = $this->urn;
    }

    /**
     *  После удаления конференции, удаляем связанные объекты.
     * 
     *  Delete linked objects after the conference is deleted.
     */
    protected function afterDelete() {
        parent::afterDelete();
        //  удалем администраторов конференции
        //  deleting conference administrators
        $admins = ConfAdmin::model()->findByConf($this);
        foreach ($admins as $admin) {
            $admin->delete();
        }
        //  удаляем неопубликованные организации конференции
        //  deleting conference organizations that are not enabled for website
        $orgs = ConfOrg::model()->findByConf($this);
        foreach ($orgs as $org) {
            if (!$org->isEnabled()) {
                $org->delete();
            }
        }
        //  удаляем разделы конференции
        //  deleting conference pages
        $conf_pages = ConfPage::model()->findByConf($this);
        foreach ($conf_pages as $conf_page) {
            $conf_page->delete();
        }
        //  удаляем сообщения гостевой книги
        //  deleting guestbook messages
        $guestbooks = Guestbook::model()->findAllByConf($this);
        foreach ($guestbooks as $guestbook) {
            $guestbook->delete();
        }
        //  удаляем доклады
        //  deleting partiaipants
        $participants = Participant::model()->findByConf($this, false);
        foreach ($participants as $participant) {
            $participant->delete();
        }
        //  удаляем секции
        //  deleting topics
        $topics = ConfTopic::model()->findByConf($this);
        foreach ($topics as $topic) {
            $topic->delete();
        }
        //  удаляем настройки формы заявки
        //  deleting application form settings
        $settings = AppFormSettings::model()->findByConf($this);
        $settings->delete();
        //  рассылку
        //  deleting mailing messages
        $tasks = MailTask::model()->findAllByConf($this);
        foreach ($tasks as $task) {
            $task->delete();
        };
        //  освобождаем адрес
        //  releasing urn
        SiteUrn::model()->deleteUrn($this->urn);
    }

    public function participation_types_names($type = ParticipationType::TYPE_ANY) {
        $all = ParticipationType::participation_types($type);
        $res = array();
        foreach ($this->participation_types as $type) {
            if (array_key_exists($type, $all)) {
                $res[$type] = $all[$type];
            }
        }
        return $res;
    }

    protected function beforeValidate() {
        if (parent::beforeValidate()) {
            if (trim($this->website) == "http://") {
                $this->website = '';
            };
            $this->urn = trim($this->urn);
            $this->email = trim($this->email);
            return true;
        }
        return false;
    }

    protected function afterFind() {
        parent::afterFind();
        //  языки конференции
        //  conference languages
        if (!is_array($this->conf_languages)) {
            $this->conf_languages = explode(';', $this->conf_languages);
            $tmp = array();
            foreach ($this->conf_languages as $lang) {
                if (!empty($lang)) {
                    $tmp[] = $lang;
                };
            }
            $this->conf_languages = $tmp;
        }
        //  формы участия
        //  participation types
        $this->participation_types = explode(';', $this->participation_types);
        $this->participation_paper_types = array();
        $this->participation_wo_paper_types = array();
        $tmp = array();
        foreach ($this->participation_types as $participation) {
            if (!empty($participation)) {
                $tmp[] = $participation;
                if (ParticipationType::isOfType($participation, ParticipationType::TYPE_PAPER)) {
                    $this->participation_paper_types[] = $participation;
                }
                if (ParticipationType::isOfType($participation, ParticipationType::TYPE_WO_PAPER)) {
                    $this->participation_wo_paper_types[] = $participation;
                }
            }
        }
        $this->participation_types = $tmp;
        //  адрес
        //  urn
        $this->_oldurn = $this->urn;
        //  значения по умолчанию
        //  defult values
        if (empty($this->participant_publishing_option)) {
            $this->participant_publishing_option = ParticipantPublishingOption::SHORT_LIST;
        };
        if (empty($this->show_all_participants)) {
            $this->show_all_participants = 0;
        };
        if (empty($this->show_images)) {
            $this->show_images = 0;
        };        
    }

    public function allowPapers() {
        return !empty($this->participation_paper_types);
    }

    public function allowWoPapers() {
        return !empty($this->participation_wo_paper_types);
    }

    public function isConfLanguage($language) {
        if (in_array($language, $this->conf_languages)) {
            return true;
        }
        return false;
    }

    public function isInOneLanguage() {
        return count($this->conf_languages) == 1;
    }

    public function getLanguages() {
        $languages = array();
        $appLanguages = Yii::app()->params['languages'];
        if (empty($this->conf_languages)) {
            $this->conf_languages = array(Yii::app()->language);
        }
        foreach ($appLanguages as $language => $name) {
            if (in_array($language, $this->conf_languages)) {
                $languages[$language] = $name;
            }
        }
        return $languages;
    }

    public function defaultLanguage() {
        $languages = $this->getLanguages();
        foreach ($languages as $language => $name) {
            return $language;
        }
        return '';
    }
    
    public function currentLanguage(){
        $languages = $this->getLanguages();
        foreach ($languages as $language => $name) {
            if (Yii::app()->language == $language) {
                return $language;
            };
        }
        return $this->defaultLanguage();    
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
            'contacts' => Yii::t('confs', 'Contacts Text'),
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
            'participant_editing_option' => Yii::t('participants', 'Allow participants to edit their applications'),
            'participant_publishing_option' => Yii::t('participants', 'Participants publishing mode'),
            'show_all_participants' => Yii::t('participants', 'Published list'),
            'show_images' => Yii::t('participants', 'Show speaker`s images in participants list'),
            'menu_title' => Yii::t('confs', '"About Conference" replacement')
        );
    }

    public function behaviors() {
        return array(
            'MultilingualBehavior' => array(
                'class' => 'application.behaviors.MultilingualBehavior',
                'table' => 'multilingual_conf',
                'table_fk' => 'conf_id',
                'language_column' => 'language',
                'columns' => array('title', 'subject', 'place', 'description', 'fee',
                    'accommodation', 'committee', 'program', 'address', 'report', 'contacts', 'menu_title'),
                'languages' => Yii::app()->params['languages'],
            ),
            'FilesBehavior' => array(
                'class' => 'application.behaviors.FilesBehavior',
                'fileAttrs' => array(
                    'logo' => FileType::LOGO,
                    'info_letter' => FileType::INFO_LETTER,
                    'proceedings' => FileType::PROCEEDINGS)
            ),
            'XssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('description',
                    'fee', 'accommodation', 'committee', 'program', 'address',
                    'report', 'contacts'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => XssFilter::$ALLOWED_TAGS
            ),
            'StrictXssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('title', 'subject', 'place'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => XssFilter::$STRICTED_ALLOWED_TAGS
            ),
            'FullXssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('urn', 'website', 'email', 'phone', 'fax', 'menu_title'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => array()
            ),
            'RFilemanagerBehavior' => array(
                'class' => 'application.behaviors.RFilemanagerBehavior'
            )
        );
    }

    public function title($language = NULL) {
        return $this->value('title', $language);
    }

    public function strictTitle($language) {
        return $this->strictValue('title', $language);
    }

    public function subject($language = NULL) {
        return $this->value('subject', $language);
    }

    public function strictSubject($language) {
        return $this->strictValue('subject', $language);
    }

    public function place($language = NULL) {
        return $this->value('place', $language);
    }

    public function description($language = NULL) {
        return $this->value('description', $language);
    }

    public function committee($language = NULL) {
        return $this->value('committee', $language);
    }

    public function contacts($language = NULL) {
        return $this->value('contacts', $language);
    }

    public function program($language = NULL) {
        return $this->value('program', $language);
    }

    public function report($language = NULL) {
        return $this->value('report', $language);
    }

    public function address($language = NULL) {
        return $this->value('address', $language);
    }

    public function fee($language = NULL) {
        return $this->value('fee', $language);
    }

    public function accommodation($language = NULL) {
        return $this->value('accommodation', $language);
    }
    
    public function menuTitle($language = NULL) {
        return $this->value('menu_title', $language);
    }

    public function startYear() {
        $sql = 'select min(start_date) from {{conf}} where start_date>0 and is_enabled=1';
        $cmd = $this->dbConnection->createCommand($sql);
        $date = $cmd->queryScalar();
        if (empty($date)) {
            $date = time();
        }
        return (int) date('Y', $date);
    }

    public function website() {
        if (strpos($this->website, 'http') == 0) {
            return $this->website;
        }
        return 'http://' . $this->website;
    }

    public function findCurrentByOrg($org) {
        $criteria = new CDbCriteria;
        $criteria->alias = 'conf';
        $criteria->distinct = true;
        $criteria->join = 'left join {{conf_org}} ON `conf`.`id` = `{{conf_org}}`.`conf_id`';
        $criteria->condition = '`conf`.`is_enabled`=1 and `{{conf_org}}`.org_id = :org_id and end_date > :end_date';
        $criteria->order = 'start_date desc';
        $criteria->params = array(':org_id' => $org->id, ':end_date' => DateUtils::today());
        return $this->findAll($criteria);
    }

    public function findRecentByOrg($org) {
        $criteria = new CDbCriteria;
        $criteria->alias = 'conf';
        $criteria->distinct = true;
        $criteria->join = 'left join {{conf_org}} ON `conf`.`id` = `{{conf_org}}`.`conf_id`';
        $criteria->condition = '`conf`.`is_enabled`=1 and `{{conf_org}}`.org_id = :org_id and end_date <= :end_date';
        $criteria->order = 'start_date desc';
        $criteria->params = array(':org_id' => $org->id, ':end_date' => DateUtils::today());
        return $this->findAll($criteria);
    }

    public function findAllWithOpenRegistration() {
        $criteria = new CDbCriteria;
        $criteria->condition = ' is_enabled=1 and is_registration_enabled=1';
        $criteria->condition.=' and DATE(NOW()) < DATE(FROM_UNIXTIME(if(registration_end_date,registration_end_date,start_date)))';
        return $this->findAll($criteria);
    }

    public function findByConfAdmin($user) {
        $criteria = new CDbCriteria;
        $criteria->alias = 'conf';
        $criteria->distinct = true;
        $criteria->join = 'left join {{conf_admin}} ON `conf`.`id` = `{{conf_admin}}`.`conf_id`';
        $criteria->condition = '`{{conf_admin}}`.user_id = :user_id';
        $criteria->order = '`conf`.start_date asc';
        $criteria->params = array(':user_id' => $user->id);
        return $this->findAll($criteria);
    }

    public function findByUrn($urn) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'urn=:urn or id=:id';
        $criteria->params = array(':urn' => $urn, ':id' => $urn);
        return $this->find($criteria);
    }

    public function testExistsByUrn($urn) {
        $sql = "select count(*) from {{conf}} where (urn=:urn) or (id=:id)";
        $command = $this->dbConnection->createCommand($sql);
        $command->bindValue(':urn', $urn);
        $command->bindValue(':id', $urn);
        $count = $command->queryScalar();
        return $count > 0;
    }

    public function findIdByUrn($urn) {
        $sql = "select id from {{conf}} where (urn=:urn) or (id=:id)";
        $command = $this->dbConnection->createCommand($sql);
        $command->bindValue(':urn', $urn);
        $command->bindValue(':id', $urn);
        return $command->queryScalar();
    }

    public function urn() {
        $urn = $this->urn;
        if ($urn != $this->_oldurn) {
            $urn = $this->_oldurn;
        }
        return $urn ? $urn : $this->id;
    }

    public function scopes() {
        return array(
            'enabled' => array(
                'condition' => 'is_enabled=1',
                'order' => 'start_date desc'
            ),
            'new' => array(
                'condition' => 'is_enabled=0',
                'order' => 'start_date desc'
            )
        );
    }

    public function propagateScenario($scenario) {
        parent::setScenario($scenario);
        $orgs = $this->orgs;
        if ($orgs) {
            foreach ($orgs as &$org) {
                $org->propagateScenario($scenario);
            }
        }
    }

    protected $_orgs;

    public function getOrgs() {
        if (!$this->_orgs) {
            $this->_orgs = ConfOrg::model()->findByConf($this);
        }
        return $this->_orgs;
    }

    public function getStartDateStr() {
        return DateUtils::getDateStr($this->start_date);
    }

    public function setStartDateStr($dateStr) {
        $this->start_date = DateUtils::parseDate($dateStr);
    }

    public function getEndDateStr() {
        return DateUtils::getDateStr($this->end_date);
    }

    public function setEndDateStr($dateStr) {
        $this->end_date = DateUtils::parseDate($dateStr);
    }

    public function getRegistrationEndDateStr() {
        return DateUtils::getDateStr($this->registration_end_date);
    }

    public function setRegistrationEndDateStr($dateStr) {
        $this->registration_end_date = DateUtils::parseDate($dateStr);
    }

    public function getSubmissionEndDateStr() {
        return DateUtils::getDateStr($this->submission_end_date);
    }

    public function setSubmissionEndDateStr($dateStr) {
        $this->submission_end_date = DateUtils::parseDate($dateStr);
    }

    public function getPublicationDateStr() {
        return DateUtils::getDateStr($this->getPublicationDate());       
    }

    public function setPublicationDateStr($dateStr) {
        $this->publication_date = DateUtils::parseDate($dateStr);
    }

    /**
     *  Возвращает реальную дату окончания регистрации:
     *      1) если установлена дата окончания регистрации, то ее,
     *      2) иначе возвращает дату начала конференции.
     * 
     *  Returns a real end registration date:
     *      1) if end registration date is set then it is returned,
     *      2) otherwise a start conference date is returned. 
     */
    public function getRegistrationEndDate() {
        return DateUtils::endDay(empty($this->registration_end_date) ? DateUtils::yesterday($this->start_date) : $this->registration_end_date);
    }

    /**
     *  Возвращает реальную дате окончания принятия докладов:
     *      1) если установлена дата окончания принятия докладов, то ее
     *      2) иначе, реальную дату окончания регистрации.
     * 
     *  Returns a real end submission date:
     *      1) if end submission date is set then it is returned,
     *      2) otherwise a real en registration date is returned.
     */
    public function getSubmissionEndDate() {
        return empty($this->submission_end_date) ? $this->getRegistrationEndDate() : DateUtils::endDay($this->submission_end_date);
    }

    public function getPublicationDate() {
        return DateUtils::startDay(empty($this->publication_date) ? DateUtils::tomorrow($this->end_date) : $this->publication_date);
    }

    
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

    public function hasApprovedParticipants() {
        $count = Participant::model()->countApprovedParticipants($this);
        return $count > 0;
    }

    public function approvedParticipants() {
        return Participant::model()->approved()->findByConf($this, false);
    }

    public function newParticipants() {
        return Participant::model()->new()->findByConf($this, false);
    }

    function countParticipants() {
        $sql = "select count(*) from {{participant}} where conf_id=:conf_id";
        $command = $this->dbConnection->createCommand($sql);
        $command->bindValue(":conf_id", $this->id);
        return $command->queryScalar();
    }

    function countApprovedParticipants() {
        $sql = "select count(*) from {{participant}} where conf_id=:conf_id and status=:status";
        $command = $this->dbConnection->createCommand($sql);
        $command->bindValue(":conf_id", $this->id);
        $command->bindValue(":status", Participant::STATUS_APPROVED);
        return $command->queryScalar();
    }

    public function relations() {
        return array(
            'topicCount' => array(self::STAT, 'ConfTopic', 'conf_id'),
            'newParticipants' => array(self::STAT, 'Participant', 'conf_id',
                'condition' => 'status=' . Participant::STATUS_NEW),
            'approvedParticipants' => array(self::STAT, 'Participant', 'conf_id',
                'condition' => 'status=' . Participant::STATUS_APPROVED)
        );
    }

    public function getFileExts() {
        if (empty($this->file_exts)) {
            return Yii::app()->params['fileExts'];
        }
        return $this->file_exts;
    }

    public function hasProceedings() {
        $file = $this->getFile('proceedings');
        return (($file != NULL) && !$file->isEmpty());
    }

}

?>
