<?php

/**
 *  Тематическая секция конференции или заседание.
 *  
 *  A conference topic.
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class ConfTopic extends ActiveRecord {

    public $id;
    public $conf_id;
    public $number;
    //  вспомогательное поле state, не хранимое в базе
    //  new, removed, updated, пусто по умолчанию
    //  auxiliary field not saved to database
    //  new, removed, updated, empty by default
    public $state = ''; 
    //  многоязычные поля
    //  multilingual fields
    
    //  название секции
    //  topic name
    public $title; 
    //  научное направление
    //  scientific area
    public $scientific_area;
    //  место проведения
    //  topic location
    public $place; 

    public static function noTopic() {
        $noTopic = new ConfTopic();
        $noTopic->id = 0;
        $noTopic->title = array(Yii::app()->language => Yii::t('confs', 'no topic (unpublished)'));
        $noTopic->scientific_area = array(Yii::app()->language => '');
        return $noTopic;
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{conf_topic}}';
    }

    public function behaviors() {
        return array(
            'MultilingualBehavior' => array(
                'class' => 'application.behaviors.MultilingualBehavior',
                'table' => 'multilingual_conf_topic',
                'table_fk' => 'conf_topic_id',
                'language_column' => 'language',
                'columns' => array('title', 'scientific_area', 'place'),
                'languages' => Yii::app()->params['languages'],
            ),
            'FullXssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('title', 'scientific_area', 'place'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => array()
            ),
        );
    }

    protected $_conf = NULL;

    protected function getConf() {
        if ($this->_conf == NULL) {
            $this->_conf = Conf::model()->findByPk($this->conf_id);
        }
        return $this->_conf;
    }

    public function rules() {
        return array(
            array('id', 'unsafe'),
            array('conf_id', 'unsafe'),
            array('number', 'unsafe'),
            
            //  topics scenario
            array('title', 'RequiredEachValidator', 'on' => 'topics', 'languages' => $this->getConf()->getLanguages()),
            array('title', 'LengthEachValidator', 'on' => 'topics', 'max' => 700),
            array('scientific_area', 'safe', 'on' => 'topics'),
            
            //  topic scenario
            array('place', 'safe', 'on' => 'topic'),
        );
    }

    public function attributeLabels() {
        return array(
            'title' => Yii::t('confs', 'Title'),
            'scientific_area' => Yii::t('confs', 'Group/Scientific Area'),
            'place' => Yii::t('confs', 'Place')
        );
    }

    public function title($language = NULL) {
        return $this->value('title', $language);
    }

    public function strictTitle($language) {
        return $this->strictValue('title', $language);
    }

    public function scientific_area($language = NULL) {
        return $this->value('scientific_area', $language);
    }

    public function place($language = NULL) {
        return $this->value('place', $language);
    }

    public function CompareByScientificArea($topic1, $topic2) {
        $value1 = $topic1->scientific_area();
        $value2 = $topic2->scientific_area();
        return strcmp($value1, $value2);
        if ($value1 == $value2) {
            return 0;
        }
        return ($value1 < $value2) ? -1 : 1;
    }

    public function findByConf($conf) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'conf_id=:conf_id';
        $criteria->params = array(':conf_id' => $conf->id);
        $criteria->order = 'number asc';
        $topics = $this->findAll($criteria);
        Sorter::sort($topics, "ConfTopic", "CompareByScientificArea");
        foreach ($topics as &$topic) {
            $topic->_conf = $conf;
        }
        return $topics;
    }

    public function SortByTitle($topic1, $topic2) {
        $value1 = $topic1->title();
        $value2 = $topic2->title();
        if ($value1 == $value2) {
            return 0;
        }
        if (empty($value1))
            return 1;
        return ($value1 < $value2) ? -1 : 1;
    }

    public function findByConfNameAsc($conf) {
        $topics = $this->findByConf($conf);
        usort($topics, array("ConfTopic", "SortByTitle"));
        foreach ($topics as $topic) {
            $topic->_conf = $conf;
        }
        return $topics;
    }

    public function groupByScientificArea($topics) {
        $groups = array();
        $noAreaGroup = array();
        if (!empty($topics)) {
            foreach ($topics as $topic) {
                $area = $topic->scientific_area();
                if (empty($area)) {
                    array_push($noAreaGroup, $topic);
                } else {
                    if (!array_key_exists($area, $groups)) {
                        $groups[$area] = array();
                    }
                    array_push($groups[$area], $topic);
                }
            }
        };
        if (!empty($noAreaGroup)) {
            $groups[''] = $noAreaGroup;
        }
        return $groups;
    }

    /**
     * $topicGroups = array(
     *     array(
     *       'title' => 'Название группы',
     *       'count' => <число заявок в группе>,
     *       'topics' => array( // массив секций
     *            'topic' => <секция>,
     *            'count' => <число заявок в секции>,
     *            'participants' => <участники>
     *         )
     *     ),
     *     ...
     * );
     * $userView используется для просмотра списка обычным пользователем.
     * 
     * $topicGroups = array(
     *     array(
     *       'title' => 'Group title',
     *       'count' => <number of participants in a group>,
     *       'topics' => array( // array of topics
     *            'topic' => <topic>,
     *            'count' => <number of participants in a topic>,
     *            'participants' => <list of participants>
     *         )
     *     ),
     *     ...
     * );
     * $userView is used for viewing the list by a simple user.
     */
    public function getTopicGroups($conf, $userView = true, &$participantCount) {
        $topics = $this->findByConf($conf);
        $noTopic = ConfTopic::noTopic();
        array_push($topics, $noTopic);
        $sql = "select p.topic_id as topic_id, p.status status,count(*)as `count`
              from {{participant}} p  left outer join {{conf_topic}} t on p.topic_id=t.id
              where p.conf_id=:conf_id  
              group by p.topic_id, p.status";
        if ($userView) {
            //  только одобренные 
            //  approved only
            if ($conf->show_all_participants) {
                //  всех участников  
                //  all participants
                $sql = "select p.topic_id as topic_id, p.status status, count(*)as `count`
                 from {{participant}} p join {{conf_topic}} t on p.topic_id=t.id
                 where p.conf_id=:conf_id and p.status=1 
                 group by p.topic_id";
            } else {
                //  только доклады 
                //  reports only
                $sql = "select p.topic_id as topic_id, p.status status, count(*)as `count`
                 from {{participant}} p join {{conf_topic}} t on p.topic_id=t.id
                 where p.conf_id=:conf_id and p.status=1 and p.participation_type in (1,2,3,5,10)
                 group by p.topic_id";
            }
        }
        $command = $this->dbConnection->createCommand($sql);
        $command->bindValue(":conf_id", $conf->id);
        $rows = $command->queryAll();

        $participantCount = 0;
        foreach ($rows as $row) {
            $participantCount+=$row['count'];
        };

        $topicGroups = array();
        $groupTitle = NULL;
        $groupCount = 0;
        $groupTopics = array();
        $last = new ConfTopic();
        $last->id = -1;
        array_push($topics, $last);
        foreach ($topics as $i => $topic) {
            if ($i == 0) {
                $groupTitle = $topic->scientific_area();
            } else
            if ($topic->id == $last->id || (strcmp($topic->scientific_area(), $groupTitle) != 0)) {
                if (($groupCount > 0) || !$userView) {
                    //  добавляем предыдущую группу, если в ней есть заявки
                    //  adding a previous group if is contains a participant
                    $topicGroups[] = array(
                        'title' => $groupTitle,
                        'count' => $groupCount,
                        'topics' => $groupTopics
                    );
                }
                if ($topic->id == $last->id) {
                    break;
                }
                $groupTitle = $topic->scientific_area();
                $groupCount = 0;
                $groupTopics = array();
            }
            $topicCount = 0;
            $approvedCount = 0;
            $newCount = 0;
            $discardedCount = 0;
            $topicParticipants = array();
            foreach ($rows as $row) {
                if (($row['topic_id'] == $topic->id) && ($row['status'] == Participant::STATUS_APPROVED)) {
                    $approvedCount = $row['count'];
                }
                if (($row['topic_id'] == $topic->id) && ($row['status'] == Participant::STATUS_NEW)) {
                    $newCount = $row['count'];
                }
                if (($row['topic_id'] == $topic->id) && ($row['status'] == Participant::STATUS_DISCARDED)) {
                    $discardedCount = $row['count'];
                }
            }
            $topicCount = $approvedCount + $newCount + $discardedCount;
            if ($userView && ($topicCount > 0) && ($participantCount < ParticipantController::MAX_REPORTS_COUNT)) {
                if ($conf->show_all_participants) {
                    $topicParticipants = Participant::model()->approved()->findByTopic($conf, $topic);
                } else {
                    $topicParticipants = Participant::model()->approved()->reports()->findByTopic($conf, $topic);
                }
            }
            $groupCount+=$topicCount;
            if (($topicCount > 0) || !$userView) {
                $groupTopics[] = array(
                    'topic' => $topic,
                    'count' => $topicCount,
                    'approvedCount' => $approvedCount,
                    'newCount' => $newCount,
                    'discardedCount' => $discardedCount,
                    'participants' => $topicParticipants
                );
            }
        }
        return $topicGroups;
    }

    protected function beforeDelete() {
        parent::beforeDelete();
        $conf = Conf::model()->findByPk($this->conf_id);
        $participants = Participant::model()->findByTopic($conf, $this);
        $noTopic = ConfTopic::noTopic();
        foreach ($participants as $participant) {
            $participant->topic_id = $noTopic->id;
            $participant->save();
        }
        return true;
    }

    public function urn() {
        return $this->id;
    }

}

?>
