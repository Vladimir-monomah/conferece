<?php

/**
 *  Участник конференции.
 * 
 *  A conference participant (also means one application form).
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class Participant extends ActiveRecord {

    public $id;
    public $conf_id;
    public $topic_id;
    public $user_id; // owner 
    public $creator_id; // creator

    //  новый
    //  new
    const STATUS_NEW = 2;
    //  принят
    //  approved
    const STATUS_APPROVED = 1;
    //  отклонен
    //  discarded
    const STATUS_DISCARDED = 0;

    public $status;
    public $registration_date;
    public $last_update_date;
    public $edit_language;
    
    //  дата выступления
    //  date of report
    public $start_date;
    //  время начала выступления
    //  start time of report
    public $start_time;
    public $participation_type;
    public $is_accommodation_required;
    public $has_content_file;
    public $classification_code;
    //  многоязычные поля
    //  miltilingual fields
    public $title;
    public $content;
    public $annotation;
    public $information;
    public $status_reason = '';
    protected $_isReport = true;
    //  дополнительные строковые поля
    //  additional string fields
    public $ps_field1_value;
    public $ps_field2_value;
    public $ps_field3_value;
    public $ps_field4_value;
    public $ps_field5_value;
    //  дополнительные текстовые поля
    //  additional text fields
    public $pt_field1_value;
    public $pt_field2_value;
    public $pt_field3_value;
    public $pt_field4_value;
    public $pt_field5_value;
    //  дополнительные поля-флажки
    //  additional checkbox fields
    public $pc_field1_value;
    public $pc_field2_value;
    public $pc_field3_value;
    public $pc_field4_value;
    public $pc_field5_value;
    //  дополнительные поля-списки
    //  additional list fields
    public $pl_field1_value;
    public $pl_field2_value;
    public $pl_field3_value;
    public $pl_field4_value;
    public $pl_field5_value;

     // honeypot
    public $ukazhite_e_mail;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{participant}}';
    }

    public static function application() {
        $participant = new Participant();
        $participant->title = array(Yii::app()->language => Yii::t('participants', 'Application for Participation'));
        return $participant;
    }

    public function behaviors() {
        return array(
            // Важно, что RFilemanagerBehavior.AfterSave выполняется перед MultilingualBehavior.AfterSave. 
            'RFilemanagerBehavior' => array(
                'class' => 'application.behaviors.RFilemanagerBehavior',
                'attributes' => array(
                    'title', 'annotation', 'content', 'information',
                    'pt_field1_value',
                    'pt_field2_value',
                    'pt_field3_value',
                    'pt_field4_value',
                    'pt_field5_value'
                )
            ),
            'MultilingualBehavior' => array(
                'class' => 'application.behaviors.MultilingualBehavior',
                'table' => 'multilingual_participant',
                'table_fk' => 'participant_id',
                'language_column' => 'language',
                'columns' => array(
                    'title',
                    'content',
                    'annotation',
                    'information',
                    'status_reason',
                    'ps_field1_value',
                    'ps_field2_value',
                    'ps_field3_value',
                    'ps_field4_value',
                    'ps_field5_value',
                    'pt_field1_value',
                    'pt_field2_value',
                    'pt_field3_value',
                    'pt_field4_value',
                    'pt_field5_value'
                ),
                'languages' => Yii::app()->params['languages'],
            ),
            'FilesBehavior' => array(
                'class' => 'application.behaviors.FilesBehavior',
                'fileAttrs' => array(
                    'content_files[]' => FileType::TEXT,                   
                    // дополнительные файловые поля
                    // additional file fields
                    'pf_field1_files[]' => 'additional1',
                    'pf_field2_files[]' => 'additional2',
                    'pf_field3_files[]' => 'additional3',
                    'pf_field4_files[]' => 'additional4',
                    'pf_field5_files[]' => 'additional5',
                    )
            ),
            'XssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array(
                    'content', 'annotation', 'information',
                    'pt_field1_value',
                    'pt_field2_value',
                    'pt_field3_value',
                    'pt_field4_value',
                    'pt_field5_value'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => XssFilter::$ALLOWED_TAGS
            ),
            'StrictXssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array(
                    'classification_code', 'title',
                    'ps_field1_value',
                    'ps_field2_value',
                    'ps_field3_value',
                    'ps_field4_value',
                    'ps_field5_value'
                ),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => XssFilter::$STRICTED_ALLOWED_TAGS
            ),
            'FullXssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('status_reason'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => array()
            )          
        );
    }

    protected $_appFormSettings = NULL;

    public function setAppFormSettings($settings) {
        $this->_appFormSettings = $settings;
    }

    public function getAppFormSettings($settings) {
        return $this->_appFormSettings;
    }

    protected function getFieldName($field) {
        $name = $field;
        if ($this->_appFormSettings) {
            $name = $this->_appFormSettings->value($field . '_name');
        }
        return $name;
    }

    public function attributeLabels() {
        return array(
            'ukazhite_e_mail' => Yii::t('validators', 'Enter E-mail'),
            'participation_type' => Yii::t('participants', 'Participation Type'),
            'topic' => Yii::t('participants', 'Topic'),
            'title' => Yii::t('participants', 'Title'),
            'annotation' => Yii::t('participants', 'Annotation'),
            'content' => Yii::t('participants', 'Report Text'),
            'content:' => Yii::t('participants', 'Report Text') . ':',
            'content_file' => Yii::t('participants', 'Paper File'),
            'content_files' => Yii::t('participants', 'Paper Files'),
            'information' => Yii::t('participants', 'Additional Information'),
            'status' => Yii::t('participants', 'Status'),
            'status_reason' => Yii::t('participants', 'Comment'),
            'is_accommodation_required' => Yii::t('participants', 'Accommodation Required'),
            'classification_code' => Yii::t('participants', 'Classification Code'),
            'authors' => Yii::t('participants', ($this->isReport() ? 'Authors' : 'Participants')),
            'ps_field1_value' => $this->getFieldName('ps_field1'),
            'ps_field2_value' => $this->getFieldName('ps_field2'),
            'ps_field3_value' => $this->getFieldName('ps_field3'),
            'ps_field4_value' => $this->getFieldName('ps_field4'),
            'ps_field5_value' => $this->getFieldName('ps_field5'),
            'pt_field1_value' => $this->getFieldName('pt_field1'),
            'pt_field2_value' => $this->getFieldName('pt_field2'),
            'pt_field3_value' => $this->getFieldName('pt_field3'),
            'pt_field4_value' => $this->getFieldName('pt_field4'),
            'pt_field5_value' => $this->getFieldName('pt_field5'),
            'pc_field1_value' => $this->getFieldName('pc_field1'),
            'pc_field2_value' => $this->getFieldName('pc_field2'),
            'pc_field3_value' => $this->getFieldName('pc_field3'),
            'pc_field4_value' => $this->getFieldName('pc_field4'),
            'pc_field5_value' => $this->getFieldName('pc_field5'),
            'pl_field1_value' => $this->getFieldName('pl_field1'),
            'pl_field2_value' => $this->getFieldName('pl_field2'),
            'pl_field3_value' => $this->getFieldName('pl_field3'),
            'pl_field4_value' => $this->getFieldName('pl_field4'),
            'pl_field5_value' => $this->getFieldName('pl_field5'),
            'pf_field1_files' => $this->getFieldName('pf_field1'),
            'pf_field2_files' => $this->getFieldName('pf_field2'),
            'pf_field3_files' => $this->getFieldName('pf_field3'),
            'pf_field4_files' => $this->getFieldName('pf_field4'),
            'pf_field5_files' => $this->getFieldName('pf_field5'),            
        );
    }

    public function rules() {
        return array(
            //  unsafe
            array('id', 'unsafe'),
            //  enable scenario
            array('status', 'safe', 'on' => 'enable'),
            array('status_reason', 'safe', 'on' => 'enable'),
            array('topic_id', 'safe', 'on' => 'enable'),
            //  save scenario
            array('ukazhite_e_mail', 'HoneypotValidator', 'on' => 'save'),
            array('temp_id', 'safe', 'on' => 'save'),
            array('participation_type,classification_code,is_accommodation_required', 'safe', 'on' => 'save'),
            array('topic_id', 'safe', 'on' => 'save'),
            array('edit_language', 'safe', 'on' => 'save'),
            array('title,content,annotation,information', 'safe', 'on' => 'save'),
            array('last_update_date', 'default', 'on' => 'save', 'value' => time()),
            array('content_files', 'FilesValidator', 'on' => 'save', 'size' => Yii::app()->params['userFileSize'], 'exts' => $this->conf->fileExts),            
            array('pf_field1_files,pf_field2_files,pf_field3_files,pf_field4_files,pf_field5_files', 'FilesValidator', 'on' => 'save', 'size' => Yii::app()->params['userFileSize'], 'exts' => $this->conf->fileExts),            
            array('ps_field1_value,ps_field2_value,ps_field3_value,ps_field4_value,ps_field5_value', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('pt_field1_value,pt_field2_value,pt_field3_value,pt_field4_value,pt_field5_value', 'safe', 'on' => 'save'),
            array('pc_field1_value,pc_field2_value,pc_field3_value,pc_field4_value,pc_field5_value', 'safe', 'on' => 'save'),
            array('pl_field1_value,pl_field2_value,pl_field3_value,pl_field4_value,pl_field5_value', 'safe', 'on' => 'save'),
            //  topic scenario
            array('startDate', 'safe', 'on' => 'topic'),
            array('startTime', 'safe', 'on' => 'topic'),
        );
    }

    public function title($language = NULL) {
        return $this->value('title', $language);
    }

    public function strictTitle($language) {
        return $this->strictValue('title', $language);
    }

    public function shownTitle($language) {
        $title = $this->title($language);
        if (empty($title)) {
            $title = Yii::t('participants','Untitled');
        };
        return $title;
    }
    
    public function content($language = NULL) {
        return $this->value('content', $language);
    }

    public function annotation($language = NULL) {
        return $this->value('annotation', $language);
    }

    public function strictAnnotation($language) {
        return $this->strictValue('annotation', $language);
    }

    public function information($language = NULL) {
        return $this->value('information', $language);
    }

    public function status_reason($language = NULL) {
        return $this->value('status_reason', $language);
    }

    public function clear_status_reason() {
        foreach (Yii::app()->params['languages'] as $language => $name) {
            $this->status_reason[$language] = '';
        };
    }

    public function getStartTime() {
        return DateUtils::getTimeStr($this->start_time);
    }

    public function setStartTime($timeStr) {
        $this->start_time = DateUtils::parseTime($timeStr);
    }

    public function getStartDate() {
        return DateUtils::getDateStr($this->start_date);
    }

    public function setStartDate($dateStr) {
        $this->start_date = DateUtils::parseDate($dateStr);
    }

    public function statusStr() {
        $str = Yii::t('participants', 'new');
        if ($this->status == Participant::STATUS_DISCARDED) {
            $str = Yii::t('participants', 'discarded');
        }
        if ($this->status == Participant::STATUS_APPROVED) {
            $str = Yii::t('participants', 'approved');
        }
        return $str;
    }

    protected function SortByStartDateTime($participant1, $participant2) {
        $value1 = $participant1->start_date + $participant1->start_time;
        $value2 = $participant2->start_date + $participant2->start_time;
        if ($value1 == $value2) {
            return 0;
        }
        if (empty($value1)) {
            return 1;
        }
        if (empty($value2)) {
            return -1;
        }
        return ($value1 < $value2) ? -1 : 1;
    }

    public function SortByAuthorsTitle($participant1, $participant2) {
        $s = $this->SortByStartDateTime($participant1, $participant2);
        if ($s != 0) {
            return $s;
        };
        $value1 = $participant1->authorNames();
        $value2 = $participant2->authorNames();
        $s = strcmp($value1, $value2);
        if ($s == 0) {
            $value1 = $participant1->title();
            $value2 = $participant2->title();
            return strcmp($value1, $value2);
        };
        return $s;
    }

    public function countApprovedParticipants($conf) {
        $sql = 'select
                count(*)
              from {{participant}}
              where conf_id=:conf_id
                and status=1';
        $cmd = $this->dbConnection->createCommand($sql);
        $cmd->params = array(':conf_id' => $conf->id);
        $count = $cmd->queryScalar();
        return $count;
    }

    public function findByConf($conf, $sorted = true) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'conf_id=:conf_id';
        $criteria->params = array(':conf_id' => $conf->id);
        if ($sorted) {
            $participants = $this->with('authors')->findAll($criteria);
            usort($participants, array("Participant", "SortByAuthorsTitle"));
        } else {
            $participants = $this->findAll($criteria);
        }
        foreach ($participants as &$participant) {
            $participant->_conf = $conf;
        }
        return $participants;
    }
    
    public function findIdsByConf($conf, $approvedOnly = FALSE) {
        $sql = 'SELECT
                    id
                FROM 
                    {{participant}}
                WHERE 
                    conf_id = :conf_id';
        if ($approvedOnly) {
            $sql .= ' and status = 1';
        }
        $cmd = $this->dbConnection->createCommand($sql);
        $cmd->params = array(':conf_id' => $conf->id);
        $res = $cmd->queryAll();
        $ids = array();
        foreach($res as $i => $row) {
            $ids[] = $row['id'];
        }    
        return $ids;
    }
    
    public function findByTopic($conf, $topic) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'conf_id=:conf_id and topic_id=:topic_id';
        $criteria->params = array(':topic_id' => $topic->id, ':conf_id' => $conf->id);
        $participants = $this->with('authors')->findAll($criteria);
        usort($participants, array("Participant", "SortByAuthorsTitle"));
        foreach ($participants as &$participant) {
            $participant->_conf = $conf;
        }
        return $participants;
    }

    public function countByConfUser($conf_id, $user_id) {
        $sql = 'select count(*) from {{participant}} where user_id=:user_id and conf_id=:conf_id';
        $command = $this->db->createCommand($sql)->bindValue(':user_id', $user_id)->bindValue(':conf_id', $conf_id);
        $count = $command->queryScalar();
        return ($count > 0);
    }

    public function urn() {
        return $this->id;
    }

    protected $_user = NULL;

    public function user() {
        if ($this->_user == NULL) {
            $this->_user = User::model()->findByPk($this->user_id);
        }
        return $this->_user;
    }

    
    protected $_creator = NULL;

    public function creator() {
        if ($this->_creator == NULL) {
            if (empty($this->creator_id)) {
                $this->creator_id =  $this->user_id;
            }
            $this->_creator = User::model()->findByPk($this->creator_id);
        }
        return $this->_creator;
    }

    protected $_conf = NULL;

    public function conf() {
        if ($this->_conf == NULL) {
            $this->_conf = Conf::model()->findByPk($this->conf_id);
        }
        return $this->_conf;
    }

    public function getConf() {
        return $this->conf();
    }

    public function setConf($conf) {
        $this->_conf = $conf;
    }

    public function scopes() {
        return array(
            'approved' => array(
                'condition' => 'status=' . Participant::STATUS_APPROVED,
                'order' => 'registration_date desc'
            ),
            'reports' => array(
                'condition' => 'participation_type in (1,2,3,5,10)'
            ),
            'withTopic' => array(
                'condition' => 'topic_id !=0'
            ),
            'new' => array(
                'condition' => 'status=' . Participant::STATUS_NEW,
                'order' => 'registration_date desc'
            )
        );
    }

    public function relations() {
        return array(
            'authors' => array(self::HAS_MANY, 'Author', array('participant_id' => 'id'), 'alias' => 'author', 'order' => 'author.id ASC')
        );
    }

    public function groupByTopic($participants) {
        $groups = array();
        foreach ($participants as $participant) {
            $topic_id = $participant->topic_id;
            if (!array_key_exists($topic_id, $groups)) {
                $groups[$topic_id] = array();
            }
            array_push($groups[$topic_id], $participant);
        }
        return $groups;
    }

    protected $_authorNames = NULL;

    public function authorNames($language = NULL) {
        $authorNames = $this->_authorNames;
        if ($authorNames != NULL) {
            return $authorNames;
        }
        $authorNames = '';
        $authors = $this->authors;
        foreach ($authors as $i => $author) {
            if ($i > 0) {
                $authorNames.=', ';
            };
            $authorNames.=$author->authorName($language);
        }
        return $authorNames;
    }

    public function speaker() {
        $authors = $this->authors;
        $speaker = $authors[0];
        return $speaker;
    }

    public function participationType() {
        $types = ParticipationType::participation_types();
        return $types[$this->participation_type];
    }

    public function isApproved() {
        return $this->status == Participant::STATUS_APPROVED;
    }

    public function isNew() {
        return $this->status == Participant::STATUS_NEW;
    }

    public function isPublished() {
        $conf = $this->conf();
        $published = !empty($this->topic_id) && $this->isApproved() && $conf->isParticipantsPublished();
        $published = $published && ($conf->participant_publishing_option == ParticipantPublishingOption::FULL_LIST);
        if (!$conf->show_all_participants) {
            if (!ParticipationType::isOfType($participant->participation_type, ParticipationType::TYPE_PAPER)) {
                $published = false;
            }
        };
        return $published;
    }

    public function isReport() {
        return ParticipationType::isOfType($this->participation_type, ParticipationType::TYPE_PAPER);
    }

    public function isApplication() {
        return ParticipationType::isOfType($this->participation_type, ParticipationType::TYPE_WO_PAPER);
    }

    public function onStatusChanged($event) {
        $this->raiseEvent("onStatusChanged", $event);
    }

    public function onDelete($event) {
        $this->raiseEvent("onDelete", $event);
    }

    public function onCreate($event) {
        $this->raiseEvent("onCreate", $event);
    }

    public function onComment($event) {
        $this->raiseEvent("onComment", $event);
    }

    public function getEditLanguage() {
        if (empty($this->edit_language) && $this->isNewRecord) {
            $this->edit_language = Yii::app()->language;
        };
        // для обратной совместимости
        // for back compatibility
        if (empty($this->edit_language) && !$this->isNewRecord) {
            $firstAuthor = $this->speaker();
            $this->edit_language = $firstAuthor->locale;
        };
        return $this->edit_language;
    }
    
    public function setEditLanguage($editLanguage) {
        if (empty($this->edit_language)) {
            $this->edit_language = $editLanguage;
        };
    }
    
    protected function beforeSave() {
        if (!parent::beforeSave()) {
            return false;
        };
        $this->has_content_file = $this->hasAnyFile('content_files');
        if ($this->isNewRecord) {
            $this->edit_language = Yii::app()->language;
        } else if(empty($this->edit_language)) {
            // для обратной совместимости
            // for back compatibility
            // предполагаем, что это предпочтительный язык первого автора
            // lets suppose it is first author prefferred language
            $firstAuthor = $this->speaker();
            $this->edit_language = $firstAuthor->locale;
        }
        return true;
    }

    public function afterDelete() {
        parent::afterDelete();

        //  уведомление об удалении доклада
        //  привязываем обработчик события
        //  notification about report deletion
        //  attaching an event handler
        $this->onDelete = array(NotificationService::getInstance(), "nofityParticipantDeleted");
        //  инициируем то событие
        //  initiating the event
        $this->onDelete(new CEvent($this, array("participant" => $this)));

        //  удаляем авторов доклада
        //  deleting authors of the participant
        $authors = Author::model()->findByParticipant($this);
        foreach ($authors as $author) {
            $author->delete();
        }
        //  удаляем комментарии
        //  deleting comments
        $comments = Comment::model()->findAllByItemSubItem($this->id);
        foreach ($comments as $comment) {
            $comment->delete();
        }
        $commentedItems = CommentedItem::model()->findByItemSubItem($this->id);
        foreach ($commentedItems as $item) {
            $item->delete();
        }
    }

}

?>
