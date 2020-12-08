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
class ConfView extends BaseConfView {

    public $id;
    public $website;
    public $last_update_date;
    //  многоязычные поля
    //  multilingual fields
    public $title;
    public $subject;
    public $committee;
    public $program;
    public $address;
    public $report;
    public $place;
    public $description;
    public $fee;
    public $accommodation;
    public $contacts;
    public $menu_title;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{conf}}';
    }

    public function place($language = NULL) {
        return $this->value('place', $language);
    }

    public function description($language = NULL) {
        return $this->value('description', $language);
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

    public function subject($language = NULL) {
        return $this->value('subject', $language);
    }

    public function title($language = NULL) {
        return $this->value('title', $language);
    }

    public function menuTitle($language = NULL) {
        return $this->value('menu_title', $language);
    }
    
    public function website() {
        if (strpos($this->website, 'http') == 0) {
            return $this->website;
        }
        return 'http://' . $this->website;
    }

    protected $_orgs;

    public function getOrgs() {
        if (!$this->_orgs) {
            $this->_orgs = ConfOrgView::model()->findAllByConf($this);
        }
        return $this->_orgs;
    }

    public function defaultLanguage() {
        $languages = $this->getLanguages();
        foreach ($languages as $language => $name) {
            return $language;
        }
        return '';
    }

    public function currentLanguage() {
        $languages = $this->getLanguages();
        foreach ($languages as $language => $name) {
            if (Yii::app()->language == $language) {
                return $language;
            };
        }
        return $this->defaultLanguage();
    }

    public $participation_paper_types = array();
    public $participation_wo_paper_types = array();

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
    }

    protected function beforeSave() {
        if (!parent::beforeSave()) {
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

    public function allowPapers() {
        return !empty($this->participation_paper_types);
    }

    public function allowWoPapers() {
        return !empty($this->participation_wo_paper_types);
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

    public function isInOneLanguage() {
        return count($this->conf_languages) == 1;
    }

    public function getLanguages() {
        $languages = array();
        $appLanguages = Yii::app()->params['languages'];
        if (!empty($this->conf_languages)) {
            foreach ($appLanguages as $language => $name) {
                if (in_array($language, $this->conf_languages)) {
                    $languages[$language] = $name;
                }
            }
        }
        return $languages;
    }

    public function behaviors() {
        return array(
            'MultilingualBehavior' => array(
                'class' => 'application.behaviors.MultilingualBehavior',
                'table' => 'multilingual_conf',
                'table_fk' => 'conf_id',
                'language_column' => 'language',
                'columns' => array('title', 'subject', 'place', 'description', 'fee',
                    'accommodation', 'committee', 'program', 'address', 'report', 'contacts','menu_title'),
                'languages' => Yii::app()->params['languages'],
            ),
            'FilesBehavior' => array(
                'class' => 'application.behaviors.FilesBehavior',
                'fileAttrs' => array(
                    'logo' => FileType::LOGO,
                    'info_letter' => FileType::INFO_LETTER,
                    'proceedings' => FileType::PROCEEDINGS),
                '_owner_class' => 'Conf'
            ),
            'RFilemanagerBehavior' => array(
                'class' => 'application.behaviors.RFilemanagerBehavior'
            )
        );
    }

    public function rules() {
        return array(
            array('proceedings', 'FilesValidator', 'on' => 'proceedings', 'size' => Yii::app()->params['userFileSize'], 'exts' => Yii::app()->params['fileExts']),
        );
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

}

?>
