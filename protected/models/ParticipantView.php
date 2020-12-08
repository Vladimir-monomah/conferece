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
class ParticipantView extends ActiveRecord {

    public $id;
    public $user_id;
    public $creator_id;
    public $status;
    public $conf_id;
    public $topic_id;
    public $participation_type;
    public $is_accommodation_required;
    public $has_content_file;
    //  дата начала выступления
    //  date of report
    public $start_date; 
    //  время начала выступления
    //  start time of report
    public $start_time; 
    public $_authors = array(); // array of AuthorView
    public $_title = '';
    protected $_content = '';
    protected $_annotation = '';
    protected $_authorNames = '';
    protected $_supervisor = '';
    protected $_content_files = array();
    //  докладчик - первый по порядку автор
    //  speaker (the first author)
    protected $_speakerName;
    protected $_speakerId;
    protected $_speaker_photo;
    
    //  для экспорта
    //  for export
    public $file_src = '';
    public $file_dest = '';
    public $_file_dest = '';
    
    //  дополнительные поля-списки
    //  additional list fields
    public $pl_field1_value;
    public $pl_field2_value;
    public $pl_field3_value;
    public $pl_field4_value;
    public $pl_field5_value;
    
    //  дополнительные текстовые поля
    //  additional text fields
    public $pt_field1_value = '';
    public $pt_field2_value = '';
    public $pt_field3_value = '';
    public $pt_field4_value = '';
    public $pt_field5_value = '';
   

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{participant}}';
    }

    public function title($language = NULL) {
        if ($language == NULL) {
            $language = Yii::app()->language;
        }
        $value = $this->_title[$language];
        return empty($value) ? '' : $value;
    }

    public function content($language = NULL) {
        if ($language == NULL) {
            $language = Yii::app()->language;
        }
        $value = $this->_content[$language];
        return empty($value) ? '' : $value;
    }

    public function annotation($language = NULL) {
        if ($language == NULL) {
            $language = Yii::app()->language;
        }
        $value = $this->_annotation[$language];
        return empty($value) ? '' : $value;
    }

    public function authorNames() {
        return $this->_authorNames;
    }
    
    public function creatorName() {
        if (!empty($this->creator_id) && ($this->user_id != $this->creator_id)) {
                $creator = User::model()->findByPk($this->creator_id);
                return $creator->fullName();
        }
        return '';
    }

    // returns array of AuthorView
    public function getAuthors(){
        return $this->_authors;
    }
    
    public function fileDest() {
        return $this->_file_dest;
    }

    public function speakerName() {
        return $this->_speakerName;
    }

    public function speakerPhoto() {
        return $this->_speaker_photo;
    }

    public function supervisor() {
        return $this->_supervisor;
    }

    public function hasFile() {
        return $this->has_content_file;
    }

    public function getFile() {
        return isset($this->_content_files[0])?$this->_content_files[0]:NULL;
    } 

    public function getContentFile() {
        return isset($this->_content_files[0])?$this->_content_files[0]:NULL;
    }
    
    public function getContentFiles() {
         return $this->_content_files;
    }

    public function urn() {
        return $this->id;
    }
    
    public function fullTitleWithLinks($conf, $separator = '<br />'){
        $titles = array();
        foreach($conf->getLanguages() as $language => $name) {
            $title = $this->title($language);
            if(empty($title) || in_array($title, $titles)) {
                continue;
            };
            array_push($titles, $title);
        };
        if (empty($titles)) {
            $titles[] = Yii::t('participants','Untitled');
        }
        $links = array();
        foreach($titles as $title){
            $links[] = CHtml::link(StringUtils::prepareHtml($title), Yii::app()->createUrl('participant/view', array('urn'=>$conf->urn(),'participant_urn'=>$this->urn())));
        }
        return join($separator, $links);
    }

    public function rules() {
        return array(
            //  unsafe
            array('id', 'unsafe'),
            
            //  datetime scenarion
            array('startDate', 'safe', 'on' => 'datetime'),
            array('startTime', 'safe', 'on' => 'datetime'),
        );
    }

    public function getStartTime() {
        return DateUtils::getTimeStr($this->start_time);
    }

    public function getStartDate() {
        return DateUtils::getDateStr($this->start_date);
    }

    public function setStartTime($timeStr) {
        $this->start_time = DateUtils::parseTime($timeStr);
    }

    public function setStartDate($dateStr) {
        $this->start_date = DateUtils::parseDate($dateStr);
    }

    public function saveStartDateTime() {
        $cmd = $this->dbConnection->createCommand('update {{participant}} set start_time=:start_time, start_date=:start_date where id=:id');
        $cmd->bindValue(":start_time", $this->start_time);
        $cmd->bindValue(":start_date", $this->start_date);
        $cmd->bindValue(":id", $this->id);
        $cmd->execute();
    }

    public function authorById($id, &$author) {
        foreach ($this->_authors as $a) {
            if ($a->id == $id) {
                $author = $a;
                return true;
            };
        };
        $author = new AuthorView();
        $author->id = $id;
        $this->_authors[$id] = $author;
        return true;
    }

    public function participationType() {
        $types = ParticipationType::participation_types();
        return $types[$this->participation_type];
    }

    public function isReport() {
        return ParticipationType::isOfType($this->participation_type, ParticipationType::TYPE_PAPER);
    }

    public function isApplication() {
        return ParticipationType::isOfType($this->participation_type, ParticipationType::TYPE_WO_PAPER);
    }

    /*
     *  Используется в других сортировках,
     *  упорядочивает по дате и времени.
     * 
     *  Used in other sorting methods,
     *  orders by date and time.
     */
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

    /*
     *  Сначала упорядочиваем по авторам, затем по названию доклада.
     *  Используется для вывода всего списка участников,
     *  если в конференции есть секции.
     * 
     *  Ordering by author first, the by title of the report.
     *  Used to show the list of all participants,
     *  if the conference has topics.  
     */
    public function SortByAuthorsTitle($participant1, $participant2) {
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
    
    
    function notEmptyTitle() {  
        $language = Yii::app()->language;
        $languages = Yii::app()->params['languages'];
        $value = $this->_title[$language];
        $value = trim($value);
        if (empty($value)) {
            foreach ($languages as $lang => $name) {
                $value = $this->_title[$lang];
                $value = trim($value);
                if (!empty($value))
                    break;
            }
        }
        if (empty($value)) {
            $value = Yii::t('participants','Untitled');
        }
        return $value;    
    }
        
    public function SortByTitle($participant1, $participant2) {
        $value1 = $participant1->notEmptyTitle();
        $value2 = $participant2->notEmptyTitle();
        return strcmp($value1, $value2);
    }

    /*
     *  Сначала упорядочиваем по дате и времени,
     *  затем по авторам, 
     *  затем по названию доклада.
     *  Используется для вывода всего списка участников,
     *  если в конференции нет секций.
     *
     *  Ordering by date and time first, 
     *  then by authors,
     *  then by title of the report.
     *  Used to show the list of all participants,
     *  if the conference has no topic. 
     */

    public function SortByDateTimeAuthorsTitle($participant1, $participant2) {
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

    
    /*
     *  Используется для упорядочения списка для экспорта.
     *  
     *  Used to sort for export.
     */
    public function SortByTopicTitleAuthors($participant1, $participant2) {
        $value1 = strval($participant1->topic_id); 
        $value2 = strval($participant2->topic_id);
        if ($value1 == $value2) {
            $s = $this->SortByDateTimeAuthorsTitle($participant1, $participant2);
            if ($s != 0) {
                return $s;
            };
            return 0;
        }
        return ($value1 < $value2) ? -1 : 1;
    }

    /*
     *  Используется для списка докладов на странице пользователя.
     *  Упорядочивает по конференции (неявно по времени ее создания),
     *  затем по авторам, затем по названию доклада.
     * 
     *  Used to show the list of applications at the user's page.
     *  Orders by conference, then by authors, then by title of the report.
     */
    public function SortByConfAuthorsTitle($participant1, $participant2) {
        $value1 = $participant1->conf_id;
        $value2 = $participant2->conf_id;
        if ($value1 == $value2) {
            $value1 = $participant1->authorNames();
            $value2 = $participant2->authorNames();
            $s = strcmp($value1, $value2);
            if ($s == 0) {
                $value1 = $participant1->title();
                $value2 = $participant2->title();
                return strcmp($value1, $value2);
            };
            return $s;
        };
        return ($value1 < $value2) ? -1 : 1;
    }

    protected function rowsToObjects($rows, $authorSeparator = ',') {
        if (empty($rows)) {
            return array();
        };
        $participants = array();
        $participant = NULL;
        $last_id = NULL;
        $rows[] = array('id' => 'final');
        foreach ($rows as $row) {
            $id = $row['id'];
            if ($last_id != $id) {
                //  обрабатываем полностью заполненный объект
                //  working with filled object
                if ($participant != NULL) {
                    $language = Yii::app()->language;
                    $languages = Yii::app()->params['languages'];
                    //  список авторов
                    //  list of authors
                    $authorNames = '';
                    $fileDest = '';
                    //  список научных руководителей
                    //  list of supervisors
                    $supervisors = '';
                    //  докладчик
                    //  speaker
                    $speaker = '';
                    $authors = $participant->_authors;
                    $i = 0;
                    foreach ($authors as $author_id => $author) {
                        if ($i > 0) {
                            $authorNames.=$authorSeparator . ' ';
                            $fileDest.='_';
                        };
                        $firstName = $author->firstName($language);
                        if (empty($firstName)) {
                            foreach ($languages as $lang => $name) {
                                $firstName = $author->firstName($lang);
                                if (!empty($firstName)) {
                                    break;
                                };
                            };
                        };
                        $lastName = $author->lastName($language);
                        if (empty($lastName)) {
                            foreach ($languages as $lang => $name) {
                                $lastName = $author->lastName($lang);
                                if (!empty($lastName)) {
                                    break;
                                };
                            };
                        };
                        $middleName = $author->middleName($language);
                        if (empty($middleName)) {
                            foreach ($languages as $lang => $name) {
                                $middleName = $author->middleName($lang);
                                if (!empty($middleName)) {
                                    break;
                                };
                            };
                        };
                        $institution = $author->institution($language);
                        if (empty($institution)) {
                            foreach ($languages as $lang => $name) {
                                $institution = $author->institution($lang);
                                if (!empty($institution)) {
                                    break;
                                };
                            };
                        };
                        $country = $author->country($language);
                        if (empty($country)) {
                            foreach ($languages as $lang => $name) {
                                $country = $author->country($lang);
                                if (!empty($country)) {
                                    break;
                                };
                            };
                        };
                        $city = $author->city($language);
                        if (empty($city)) {
                            foreach ($languages as $lang => $name) {
                                $city = $author->city($lang);
                                if (!empty($city)) {
                                    break;
                                };
                            };
                        };
                        $position = $author->position($language);
                        if (empty($position)) {
                            foreach ($languages as $lang => $name) {
                                $position = $author->position($lang);
                                if (!empty($position)) {
                                    break;
                                };
                            };
                        };
                        $supervisor = $author->supervisor($language);
                        if (empty($supervisor)) {
                            foreach ($languages as $lang => $name) {
                                $supervisor = $author->supervisor($lang);
                                if (!empty($supervisor)) {
                                    break;
                                };
                            };
                        };
                        $f = StringUtils::firstUChar($firstName);
                        $m = StringUtils::firstUChar($middleName);
                        $authorName = $lastName;
                        if (!empty($f)) {
                            $authorName.=' ' . $f . '.';
                        };
                        if (!empty($m)) {
                            $authorName.=' ' . $m . '.';
                        };
                        if (!empty($institution)) {
                            $authorName.=', ' . $institution;
                        };
                        if (!empty($position)) {
                            $authorName.=', ' . $position;
                        };
                        $authorNames.=$authorName;
                        $fileDest.=$lastName;
                        if ($i == 0) {
                            $speaker = $authorName;
                        };
                        if (!empty($supervisor)) {
                            if (!empty($supervisors)) {
                                $supervisors.=', ';
                            }
                            $supervisors.=$supervisor;
                        }
                        $i++;
                    }
                    $participant->_authorNames = $authorNames;
                    $participant->_file_dest = $fileDest;
                    $participant->_speakerName = $speaker;
                    $participant->_supervisor = $supervisors;
                }
                if ($id !== 'final') {
                    $participant = new ParticipantView();
                    $participants[] = $participant;
                    $participant->id = $id;
                    $participant->conf_id = isset($row['conf_id'])?$row['conf_id']:'';
                    $participant->topic_id = isset($row['topic_id'])?$row['topic_id']:'';
                    $participant->user_id = isset($row['user_id'])?$row['user_id']:'';
                    $participant->creator_id = isset($row['creator_id'])?$row['creator_id']:'';
                    $participant->status = isset($row['status'])?$row['status']:'';
                    $participant->start_date = isset($row['start_date'])?$row['start_date']:'';
                    $participant->start_time = isset($row['start_time'])?$row['start_time']:'';
                    $participant->participation_type = isset($row['participation_type'])?$row['participation_type']:'';
                    $participant->is_accommodation_required = isset($row['is_accommodation_required'])?$row['is_accommodation_required']:'';
                    $participant->has_content_file = isset($row['has_content_file'])?$row['has_content_file']:'';
                    $participant->pl_field1_value = isset($row['pl_field1_value'])?$row['pl_field1_value']:'';
                    $participant->pl_field2_value = isset($row['pl_field2_value'])?$row['pl_field2_value']:'';
                    $participant->pl_field3_value = isset($row['pl_field3_value'])?$row['pl_field3_value']:'';
                    $participant->pl_field4_value = isset($row['pl_field4_value'])?$row['pl_field4_value']:'';
                    $participant->pl_field5_value = isset($row['pl_field5_value'])?$row['pl_field5_value']:'';
                }
                $last_id = $id;
            }
            $participant_language = isset($row['participant_language'])?$row['participant_language']:'';
            $participant->_title[$participant_language] = isset($row['title'])?$row['title']:'';
            $participant->_content[$participant_language] = isset($row['content'])?$row['content']:'';
            $participant->_annotation[$participant_language] = isset($row['annotation'])?$row['annotation']:'';
            $participant->pt_field1_value[$participant_language] = isset($row['pt_field1_value']) ? $row['pt_field1_value'] : '';
            $participant->pt_field2_value[$participant_language] = isset($row['pt_field2_value']) ? $row['pt_field2_value'] : '';
            $participant->pt_field3_value[$participant_language] = isset($row['pt_field3_value']) ? $row['pt_field3_value'] : '';
            $participant->pt_field4_value[$participant_language] = isset($row['pt_field4_value']) ? $row['pt_field4_value'] : '';
            $participant->pt_field5_value[$participant_language] = isset($row['pt_field5_value']) ? $row['pt_field5_value']: '';            
            $author_id = isset($row['author_id'])?$row['author_id']:'';
            $author_locale = isset($row['author_locale'])?$row['author_locale']:'';
            if (empty($participant->_speakerId)) {
                $participant->_speakerId = $author_id;
            };
            $author_language = isset($row['author_language'])?$row['author_language']:'';
            $author_lastname = isset($row['author_lastname'])?$row['author_lastname']:'';
            $author_firstname = isset($row['author_firstname'])?$row['author_firstname']:'';
            $author_middlename = isset($row['author_middlename'])?$row['author_middlename']:'';
            $author_institution = isset($row['author_institution'])?$row['author_institution']:'';
            $author_country = isset($row['author_country'])?$row['author_country']:'';
            $author_city = isset($row['author_city'])?$row['author_city']:'';
            $author_position = isset($row['author_position'])?$row['author_position']:'';
            $author_supervisor = isset($row['author_supervisor'])?$row['author_supervisor']:'';
            $author_academic_degree = isset($row['author_academic_degree'])?$row['author_academic_degree']:'';
            $author_email = isset($row['author_email'])?$row['author_email']:'';
            $author_phone = isset( $row['author_phone'])?$row['author_phone']:'';
            // дополнительные поля
            $author_al_field1_value = isset($row['author_al_field1_value'])?$row['author_al_field1_value']:'';
            $author_al_field2_value = isset($row['author_al_field2_value'])?$row['author_al_field2_value']:'';
            $author_al_field3_value = isset($row['author_al_field3_value'])?$row['author_al_field3_value']:'';
            $author_al_field4_value = isset($row['author_al_field4_value'])?$row['author_al_field4_value']:'';
            $author_al_field5_value = isset($row['author_al_field5_value'])?$row['author_al_field5_value']:'';
            $author = NULL;
            if ($author_id) {
                $participant->authorById($author_id, $author);
                $author->locale = $author_locale;
                $author->lastname[$author_language] = $author_lastname;
                $author->firstname[$author_language] = $author_firstname;
                $author->middlename[$author_language] = $author_middlename;
                $author->position[$author_language] = $author_position;
                $author->institution[$author_language] = $author_institution;
                $author->country[$author_language] = $author_country;
                $author->city[$author_language] = $author_city;
                $author->supervisor[$author_language] = $author_supervisor;
                $author->academic_degree[$author_language] = $author_academic_degree;
                $author->email = $author_email;
                $author->phone = $author_phone;
                $author->al_field1_value = $author_al_field1_value;
                $author->al_field2_value = $author_al_field2_value;
                $author->al_field3_value = $author_al_field3_value;
                $author->al_field4_value = $author_al_field4_value;
                $author->al_field5_value = $author_al_field5_value;
            }
        };
        return $participants;
    }

    public function findByConf($conf, $showSpeaker = false) {
        $sql = "select
           a.participant_id id,
           p.conf_id conf_id,
           p.user_id user_id,
           p.status status,
           p.participation_type participation_type,
           p.is_accommodation_required is_accommodation_required,
           p.has_content_file has_content_file,
           p.start_time start_time,
           p.start_date start_date,
           mp.`language` participant_language,
           trim(mp.title) title,
           a.id author_id,
           ma.`language` author_language,
           trim(ma.lastname) author_lastname,
           trim(ma.firstname) author_firstname,
           trim(ma.middlename) author_middlename
           from
           {{author}} a,
           {{multilingual_author}} ma,
           {{participant}} p ,
           {{multilingual_participant}} mp
           where
           a.participant_id=p.id
           and a.id = ma.author_id
           and p.id=mp.participant_id
           and p.conf_id=:conf_id
           order by p.id, author_id";
        $cmd = $this->dbConnection->createCommand($sql);
        $cmd->params = array(':conf_id' => $conf->id);
        $rows = $cmd->queryAll();
        $participants = $this->rowsToObjects($rows);
        if ($conf->topicCount == 0) {
            usort($participants, array("ParticipantView", "SortByDateTimeAuthorsTitle"));
        } else {
            //  если есть секции, то упорядочение по дате и времени
            //  происходит только для списка докладов по секциям
            //  
            //  if topics exist then sorting by date and time
            //  is performed withing topics
            usort($participants, array("ParticipantView", "SortByAuthorsTitle"));
        };
        if ($showSpeaker) {
            //  выполняем загрузку и прикрепление фотографий
            //  attaching photoes
            $files = MultilingualFile::model()->findFirstAuthorPtotoesByConf($conf);
            foreach ($files as $file) {
                foreach ($participants as $participant) {
                    if ($participant->_speakerId == $file->owner_id) {
                        $participant->_speaker_photo = $file;
                        break;
                    };
                };
            };
        }
        return $participants;
    }
    
    public function findByConfSortedByTitle($conf, $approvedOnly = FALSE) {
        $sql = "select
           a.participant_id id,
           p.conf_id conf_id,
           p.user_id user_id,
           p.status status,
           p.participation_type participation_type,
           p.is_accommodation_required is_accommodation_required,
           p.has_content_file has_content_file,
           p.start_time start_time,
           p.start_date start_date,
           mp.`language` participant_language,
           trim(mp.title) title,
           a.id author_id,
           a.locale author_locale,
           a.email author_email,
           ma.`language` author_language,
           trim(ma.lastname) author_lastname,
           trim(ma.firstname) author_firstname,
           trim(ma.middlename) author_middlename
           from
           {{author}} a,
           {{multilingual_author}} ma,
           {{participant}} p ,
           {{multilingual_participant}} mp
           where
           a.participant_id=p.id
           and a.id = ma.author_id
           and p.id=mp.participant_id
           and p.conf_id=:conf_id ";
           if ($approvedOnly) { // только одобренные доклады
                $sql .= " and p.status = 1 ";
           };        
           $sql .= " order by p.id, author_id";
        $cmd = $this->dbConnection->createCommand($sql);
        $cmd->params = array(':conf_id' => $conf->id);
        $rows = $cmd->queryAll();
        $participants = $this->rowsToObjects($rows);
        usort($participants, array("ParticipantView", "SortByTitle"));
        return $participants;
    }

    /**
     *  $showSpeaker — загружать ли фото докладчика.
     *  
     *  $showSpeaker — attach speaker's image or not.
     */
    public function findApprovedByConf($conf, $showSpeaker = false) {
        $sql = "select
           a.participant_id id,
           p.conf_id conf_id,
           p.user_id user_id,
           p.status status,
           p.participation_type participation_type,
           p.is_accommodation_required is_accommodation_required,
           p.has_content_file has_content_file,
           p.start_time start_time,
           p.start_date start_date,
           mp.`language` participant_language,
           trim(mp.title) title,
           a.id author_id,
           ma.`language` author_language,
           trim(ma.lastname) author_lastname,
           trim(ma.firstname) author_firstname,
           trim(ma.middlename) author_middlename
           from
           {{author}} a,
           {{multilingual_author}} ma,
           {{participant}} p ,
           {{multilingual_participant}} mp
           where
           a.participant_id=p.id
           and a.id = ma.author_id
           and p.id=mp.participant_id
           and p.conf_id=:conf_id
           and p.status=1
           order by p.id, author_id";
        $cmd = $this->dbConnection->createCommand($sql);
        $cmd->params = array(':conf_id' => $conf->id);
        $rows = $cmd->queryAll();
        $participants = $this->rowsToObjects($rows);
        if ($conf->topicCount == 0) {
            usort($participants, array("ParticipantView", "SortByDateTimeAuthorsTitle"));
        } else {
            //  если есть секции, то упорядочение по дате и времени
            //  происходит только для списка докладов по секциям
            //  
            //  if topics exist then sorting by date and time
            //  is performed withing topics
            usort($participants, array("ParticipantView", "SortByAuthorsTitle"));
        };
        if ($showSpeaker) {
            //  выполняем загрузку и прикрепление фотографий
            //  attaching speaker's images
            $files = MultilingualFile::model()->findFirstAuthorPtotoesByConf($conf);
            foreach ($files as $file) {
                foreach ($participants as $participant) {
                    if ($participant->_speakerId == $file->owner_id) {
                        $participant->_speaker_photo = $file;
                        break;
                    };
                };
            };
        }
        return $participants;
    }

    public function findApprovedReportsByConf($conf, $showSpeaker = false) {
        $part_ids = ParticipationType::participation_types_ids(ParticipationType::TYPE_PAPER);
        $part_ids = join($part_ids, ',');
        $sql = "select
           a.participant_id id,
           p.conf_id conf_id,
           p.user_id user_id,
           p.status status,
           p.participation_type participation_type,
           p.is_accommodation_required is_accommodation_required,
           p.has_content_file has_content_file,
           p.start_time start_time,
           p.start_date start_date,
           mp.`language` participant_language,
           trim(mp.title) title,
           a.id author_id,
           ma.`language` author_language,
           trim(ma.lastname) author_lastname,
           trim(ma.firstname) author_firstname,
           trim(ma.middlename) author_middlename
           from
           {{author}} a,
           {{multilingual_author}} ma,
           {{participant}} p ,
           {{multilingual_participant}} mp
           where
           a.participant_id=p.id
           and a.id = ma.author_id
           and p.id=mp.participant_id
           and p.conf_id=:conf_id
           and p.status=1
           and p.participation_type in (${part_ids})
           order by p.id, author_id";
        $cmd = $this->dbConnection->createCommand($sql);
        $cmd->params = array(':conf_id' => $conf->id);
        $rows = $cmd->queryAll();
        $participants = $this->rowsToObjects($rows);
        if ($conf->topicCount == 0) {
            usort($participants, array("ParticipantView", "SortByDateTimeAuthorsTitle"));
        } else {
            //если есть секции, то упорядочение по дате и времени
            //происходит только для списка докладов по секциям
            //
            //  if topics exist then sorting by date and time
            //  is performed withing topics
            usort($participants, array("ParticipantView", "SortByAuthorsTitle"));
        };
        if ($showSpeaker) {
            //  выполняем загрузку и прикрепление фотографий
            //  attaching speaker's images
            $files = MultilingualFile::model()->findFirstAuthorPtotoesByConf($conf);
            foreach ($files as $file) {
                foreach ($participants as $participant) {
                    if ($participant->_speakerId == $file->owner_id) {
                        $participant->_speaker_photo = $file;
                        break;
                    };
                };
            };
        }
        return $participants;
    }

    public function findApprovedWithTopicByConf($conf, $showSpeaker = false) {
        $sql = "select
           a.participant_id id,
           p.conf_id conf_id,
           p.user_id user_id,
           p.status status,
           p.participation_type participation_type,
           p.is_accommodation_required is_accommodation_required,
           p.has_content_file has_content_file,
           p.start_time start_time,
           p.start_date start_date,
           mp.`language` participant_language,
           trim(mp.title) title,
           a.id author_id,
           ma.`language` author_language,
           trim(ma.lastname) author_lastname,
           trim(ma.firstname) author_firstname,
           trim(ma.middlename) author_middlename
           from
           {{author}} a,
           {{multilingual_author}} ma,
           {{participant}} p ,
           {{multilingual_participant}} mp
           where
           a.participant_id=p.id
           and a.id = ma.author_id
           and p.id=mp.participant_id
           and p.conf_id=:conf_id
           and p.status=1
           and p.topic_id !=0
           order by p.id, author_id";
        $cmd = $this->dbConnection->createCommand($sql);
        $cmd->params = array(':conf_id' => $conf->id);
        $rows = $cmd->queryAll();
        $participants = $this->rowsToObjects($rows);
        if ($conf->topicCount == 0) {
            usort($participants, array("ParticipantView", "SortByDateTimeAuthorsTitle"));
        } else {
            //  если есть секции, то упорядочение по дате и времени
            //  происходит только для списка докладов по секциям
            //  
            //  if topics exist then sorting by date and time
            //  is performed withing topics
            usort($participants, array("ParticipantView", "SortByAuthorsTitle"));
        };
        if ($showSpeaker) {
            //  выполняем загрузку и прикрепление фотографий
            //  attaching speaker's images
            $files = MultilingualFile::model()->findFirstAuthorPtotoesByConf($conf);
            foreach ($files as $file) {
                foreach ($participants as $participant) {
                    if ($participant->_speakerId == $file->owner_id) {
                        $participant->_speaker_photo = $file;
                        break;
                    };
                };
            };
        }
        return $participants;
    }

    public function findApprovedReportsWithTopicByConf($conf, $showSpeaker = false) {
        $part_ids = ParticipationType::participation_types_ids(ParticipationType::TYPE_PAPER);
        $part_ids = join($part_ids, ',');
        $sql = "select
           a.participant_id id,
           p.conf_id conf_id,
           p.user_id user_id,
           p.status status,
           p.participation_type participation_type,
           p.is_accommodation_required is_accommodation_required,
           p.has_content_file has_content_file,
           p.start_time start_time,
           p.start_date start_date,
           mp.`language` participant_language,
           trim(mp.title) title,
           a.id author_id,
           ma.`language` author_language,
           trim(ma.lastname) author_lastname,
           trim(ma.firstname) author_firstname,
           trim(ma.middlename) author_middlename
           from
           {{author}} a,
           {{multilingual_author}} ma,
           {{participant}} p ,
           {{multilingual_participant}} mp
           where
           a.participant_id=p.id
           and a.id = ma.author_id
           and p.id=mp.participant_id
           and p.conf_id=:conf_id
           and p.status=1
           and p.participation_type in (${part_ids})
           and p.topic_id !=0
           order by p.id, author_id";
        $cmd = $this->dbConnection->createCommand($sql);
        $cmd->params = array(':conf_id' => $conf->id);
        $rows = $cmd->queryAll();
        $participants = $this->rowsToObjects($rows);
        if ($conf->topicCount == 0) {
            usort($participants, array("ParticipantView", "SortByDateTimeAuthorsTitle"));
        } else {
            //  если есть секции, то упорядочение по дате и времени
            //  происходит только для списка докладов по секциям
            //  
            //  if topics exist then sorting by date and time
            //  is performed withing topics
            usort($participants, array("ParticipantView", "SortByAuthorsTitle"));
        };
        if ($showSpeaker) {
            //  выполняем загрузку и прикрепление фотографий
            //  attaching speaker's images
            $files = MultilingualFile::model()->findFirstAuthorPtotoesByConf($conf);
            foreach ($files as $file) {
                foreach ($participants as $participant) {
                    if ($participant->_speakerId == $file->owner_id) {
                        $participant->_speaker_photo = $file;
                        break;
                    };
                };
            };
        }
        return $participants;
    }

    public function findByUser($user) {
        $sql = "select
           a.participant_id id,
           p.conf_id conf_id,
           p.user_id user_id,
           p.status status,
           p.participation_type participation_type,
           p.is_accommodation_required is_accommodation_required,
           p.has_content_file has_content_file,
           p.start_time start_time,
           p.start_date start_date,
           mp.`language` participant_language,
           trim(mp.title) title,
           a.id author_id,
           ma.`language` author_language,
           trim(ma.lastname) author_lastname,
           trim(ma.firstname) author_firstname,
           trim(ma.middlename) author_middlename
           from
           {{author}} a,
           {{multilingual_author}} ma,
           {{participant}} p ,
           {{multilingual_participant}} mp
           where
           a.participant_id=p.id
           and a.id = ma.author_id
           and p.id=mp.participant_id
           and p.user_id=:user_id
           order by p.id, author_id";
        $cmd = $this->dbConnection->createCommand($sql);
        $cmd->params = array(':user_id' => $user->id);
        $rows = $cmd->queryAll();
        $participants = $this->rowsToObjects($rows);
        usort($participants, array("ParticipantView", "SortByConfAuthorsTitle"));
        return $participants;
    }
    
    public function findByUserOrCreator($user) {
        $sql = "select
           a.participant_id id,
           p.conf_id conf_id,
           p.user_id user_id,
           p.creator_id creator_id,
           p.status status,
           p.participation_type participation_type,
           p.is_accommodation_required is_accommodation_required,
           p.has_content_file has_content_file,
           p.start_time start_time,
           p.start_date start_date,
           mp.`language` participant_language,
           trim(mp.title) title,
           a.id author_id,
           ma.`language` author_language,
           trim(ma.lastname) author_lastname,
           trim(ma.firstname) author_firstname,
           trim(ma.middlename) author_middlename
           from
           {{author}} a,
           {{multilingual_author}} ma,
           {{participant}} p ,
           {{multilingual_participant}} mp
           where
           a.participant_id=p.id
           and a.id = ma.author_id
           and p.id=mp.participant_id
           and ( p.user_id=:user_id or p.creator_id=:creator_id )
           order by p.id, author_id";
        $cmd = $this->dbConnection->createCommand($sql);
        $cmd->params = array(':user_id' => $user->id, ':creator_id' => $user->id);
        $rows = $cmd->queryAll();
        $participants = $this->rowsToObjects($rows);
        usort($participants, array("ParticipantView", "SortByConfAuthorsTitle"));
        return $participants;
    }

    public function findByConfUser($conf, $user) {
        $sql = "select
           a.participant_id id,
           p.conf_id conf_id,
           p.user_id user_id,
           p.status status,
           p.participation_type participation_type,
           p.is_accommodation_required is_accommodation_required,
           p.has_content_file has_content_file,
           p.start_time start_time,
           p.start_date start_date,
           mp.`language` participant_language,
           trim(mp.title) title,
           a.id author_id,
           ma.`language` author_language,
           trim(ma.lastname) author_lastname,
           trim(ma.firstname) author_firstname,
           trim(ma.middlename) author_middlename
           from
           {{author}} a,
           {{multilingual_author}} ma,
           {{participant}} p ,
           {{multilingual_participant}} mp
           where
           a.participant_id=p.id
           and a.id = ma.author_id
           and p.id=mp.participant_id
           and p.user_id=:user_id
           and p.conf_id=:conf_id
           order by p.id, author_id";
        $cmd = $this->dbConnection->createCommand($sql);
        $cmd->params = array(':user_id' => $user->id, ':conf_id' => $conf->id);
        $rows = $cmd->queryAll();
        $participants = $this->rowsToObjects($rows);
        usort($participants, array("ParticipantView", "SortByConfAuthorsTitle"));
        return $participants;
    }

    public function findAllForExport($conf, $exportOption, $topic_id = NULL) {
        $sql = "select
           a.participant_id id,
           p.conf_id conf_id,
           p.topic_id topic_id,
           p.user_id user_id,
           p.status status,
           p.start_date start_date,
           p.start_time start_time,
           p.participation_type participation_type,
           p.is_accommodation_required is_accommodation_required,
           p.has_content_file has_content_file,
           mp.`language` participant_language,
           trim(mp.title) title,
           trim(mp.content) content,
           trim(mp.annotation) annotation,
           trim(p.pl_field1_value) pl_field1_value,
           trim(p.pl_field2_value) pl_field2_value,
           trim(p.pl_field3_value) pl_field3_value,
           trim(p.pl_field4_value) pl_field4_value,
           trim(p.pl_field5_value) pl_field5_value,
           trim(mp.pt_field1_value) pt_field1_value,
           trim(mp.pt_field2_value) pt_field2_value,
           trim(mp.pt_field3_value) pt_field3_value,
           trim(mp.pt_field4_value) pt_field4_value,
           trim(mp.pt_field5_value) pt_field5_value,
           a.id author_id,
           trim(a.email) author_email,
           trim(a.phone) author_phone,
           ma.`language` author_language,
           trim(ma.lastname) author_lastname,
           trim(ma.firstname) author_firstname,
           trim(ma.middlename) author_middlename,
           trim(ma.supervisor) author_supervisor,
           trim(ma.position) author_position,
           trim(ma.institution) author_institution, 
           trim(ma.country) author_country,
           trim(ma.city) author_city,
           trim(ma.academic_degree) author_academic_degree,
           trim(a.al_field1_value) author_al_field1_value,
           trim(a.al_field2_value) author_al_field2_value,
           trim(a.al_field3_value) author_al_field3_value,
           trim(a.al_field4_value) author_al_field4_value,
           trim(a.al_field5_value) author_al_field5_value
           from
           {{author}} a,
           {{multilingual_author}} ma,
           {{participant}} p ,
           {{multilingual_participant}} mp
           where
           a.participant_id=p.id
           and a.id = ma.author_id
           and p.id=mp.participant_id
           and p.conf_id=:conf_id";
        if ($exportOption == ExportController::EXPORT_PUBLISHED) {
            $sql.=" and p.status=1 ";
            if ($conf->show_all_participants == 0) {
                $part_ids = ParticipationType::participation_types_ids(ParticipationType::TYPE_PAPER);
                $part_ids = join($part_ids, ',');        
                //  только доклады
                //  reports only
                $sql.=" and p.participation_type in (${part_ids}) ";
            };
            if ($conf->topicCount > 0) {
                $sql.=" and p.topic_id<>0 ";
            };
        };
        if ($exportOption == ExportController::EXPORT_ACCEPTED) {
            $sql.=" and p.status=1";
        };
        if ($topic_id != NULL) {
            $sql.=" and p.topic_id=:topic_id ";
        };
        $sql.=" order by p.id, author_id";
        $cmd = $this->dbConnection->createCommand($sql);
        $cmd->params = array(':conf_id' => $conf->id);
        if ($topic_id != NULL) {
            $cmd->params[':topic_id'] = $topic_id;
        };
        $rows = $cmd->queryAll();
        $participants = $this->rowsToObjects($rows, ';');
        usort($participants, array("ParticipantView", "SortByTopicTitleAuthors"));
        //  загрузить и прикрепить файлы доклада
        //  attaching report's files
        $files = MultilingualFile::model()->findParticipantFilesByConf($conf);
        foreach ($files as $file) {
            foreach ($participants as $participant) {
                if ($participant->id == $file->owner_id) {
                    $participant->_content_files[] = $file;
                    break;
                };
            };
        };
        return $participants;
    }

    protected $_conf = NULL;

    public function conf() {
        if ($this->_conf == NULL) {
            $this->_conf = ConfView::model()->findByPk($this->conf_id);
        }
        return $this->_conf;
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

}

?>
