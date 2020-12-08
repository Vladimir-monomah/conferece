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
class Author extends ActiveRecord {

    public $id;
    public $participant_id;
    public $email;
    public $locale;
    public $phone;
    public $fax;
    //  многоязычные поля
    //  multilingual fields
    public $firstname;
    public $lastname;
    public $middlename;
    public $country;
    public $city;
    public $institution;
    public $institution_address;
    public $position;
    public $academic_degree;
    public $academic_title;
    public $supervisor;
    public $home_address;
    public $membership;
    //  не хранимое поле
    //  non-db field
    public $password;
    
    //  дополнительные строковые поля
    //  additional string fields
    public $as_field1_value;
    public $as_field2_value;
    public $as_field3_value;
    public $as_field4_value;
    public $as_field5_value;
    //  дополнительные текстовые поля
    //  additional text fields
    public $at_field1_value;
    public $at_field2_value;
    public $at_field3_value;
    public $at_field4_value;
    public $at_field5_value;
    //  дополнительные поля-флажки
    //  additional checkbox fields
    public $ac_field1_value;
    public $ac_field2_value;
    public $ac_field3_value;
    public $ac_field4_value;
    public $ac_field5_value;
    //  дополнительные поля-списки
    //  additional list fields
    public $al_field1_value;
    public $al_field2_value;
    public $al_field3_value;
    public $al_field4_value;
    public $al_field5_value;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{author}}';
    }

    public function behaviors() {
        return array(
            'MultilingualBehavior' => array(
                'class' => 'application.behaviors.MultilingualBehavior',
                'table' => 'multilingual_author',
                'table_fk' => 'author_id',
                'language_column' => 'language',
                'columns' => array('firstname', 'lastname', 'middlename',
                    'country', 'city', 'institution', 'institution_address',
                    'position', 'academic_degree', 'academic_title',
                    'supervisor', 'home_address', 'membership',
                    'as_field1_value',
                    'as_field2_value',
                    'as_field3_value',
                    'as_field4_value',
                    'as_field5_value',
                    'at_field1_value',
                    'at_field2_value',
                    'at_field3_value',
                    'at_field4_value',
                    'at_field5_value'
                ),
                'languages' => Yii::app()->params['languages'],
            ),
            'StrictXssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('institution', 'membership'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => XssFilter::$STRICTED_ALLOWED_TAGS
            ),
            'FullXssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('firstname', 'lastname', 'middlename',
                    'email', 'phone', 'fax',
                    'country', 'city', 'institution_address', 'position',
                    'academic_degree', 'academic_title', 'supervisor', 'home_address',
                    'as_field1_value',
                    'as_field2_value',
                    'as_field3_value',
                    'as_field4_value',
                    'as_field5_value',
                    'at_field1_value',
                    'at_field2_value',
                    'at_field3_value',
                    'at_field4_value',
                    'at_field5_value'
                ),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => array()
            ),
            'FilesBehavior' => array(
                'class' => 'application.behaviors.FilesBehavior',
                'fileAttrs' => array(
                    'image' => FileType::LOGO,
                    // дополнительные файловые поля
                    // additional file fields
                    'af_field1_files[]' => 'additional1',
                    'af_field2_files[]' => 'additional2',
                    'af_field3_files[]' => 'additional3',
                    'af_field4_files[]' => 'additional4',
                    'af_field5_files[]' => 'additional5')
            )
        );
    }

    public function rules() {
        return array(
            //  unsafe attributes
            array('id', 'unsafe'),
            array('participant_id', 'unsafe'),
            //  save scenario
            array('lastname,firstname,middlename', 'safe', 'on' => 'save'),
            array('institution,institution_address,position', 'safe', 'on' => 'save'),
            array('academic_degree,academic_title,supervisor', 'safe', 'on' => 'save'),
            array('country,city,home_address,membership,locale', 'safe', 'on' => 'save'),
            array('phone,fax', 'safe', 'on' => 'save'),
            array('email', 'email', 'on' => 'save'),
            array('password', 'safe', 'on' => 'save'),
            array('image', 'FilesValidator', 'on' => 'save', 'size' => Yii::app()->params['userFileSize'], 'exts' => Yii::app()->params['logoExts']),
            array('af_field1_files,af_field2_files,af_field3_files,af_field4_files,af_field5_files', 'FilesValidator', 'on' => 'save', 'size' => Yii::app()->params['userFileSize'], 'exts' => $this->conf->fileExts),            
            array('as_field1_value,as_field2_value,as_field3_value,as_field4_value,as_field5_value', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('at_field1_value,at_field2_value,at_field3_value,at_field4_value,at_field5_value', 'safe', 'on' => 'save'),
            array('ac_field1_value,ac_field2_value,ac_field3_value,ac_field4_value,ac_field5_value', 'safe', 'on' => 'save'),
            array('al_field1_value,al_field2_value,al_field3_value,al_field4_value,al_field5_value', 'safe', 'on' => 'save')
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
            'firstname' => Yii::t('participants', 'First Name'),
            'lastname' => Yii::t('participants', 'Last Name'),
            'middlename' => Yii::t('participants', 'Middle Name'),
            'institution' => Yii::t('participants', 'Institution'),
            'institution_address' => Yii::t('participants', 'Institution Address'),
            'position' => Yii::t('participants', 'Position'),
            'academic_degree' => Yii::t('participants', 'Academic Degree'),
            'academic_title' => Yii::t('participants', 'Academic Title'),
            'supervisor' => Yii::t('participants', 'Supervisor'),
            'country' => Yii::t('participants', 'Country'),
            'city' => Yii::t('participants', 'City'),
            'home_address' => Yii::t('participants', 'Home Address'),
            'email' => Yii::t('participants', 'E-mail'),
            'password' => Yii::t('users', 'Password'),
            'password1' => Yii::t('users', 'Password'),
            'password2' => Yii::t('users', 'Password confirmation'),
            'phone' => Yii::t('participants', 'Phone'),
            'fax' => Yii::t('participants', 'Fax'),
            'membership' => Yii::t('participants', 'Membership'),
            'locale' => Yii::t('users', 'Preferred Language'),
            'image' => Yii::t('users', 'Image'),
            'as_field1_value' => $this->getFieldName('as_field1'),
            'as_field2_value' => $this->getFieldName('as_field2'),
            'as_field3_value' => $this->getFieldName('as_field3'),
            'as_field4_value' => $this->getFieldName('as_field4'),
            'as_field5_value' => $this->getFieldName('as_field5'),
            'at_field1_value' => $this->getFieldName('at_field1'),
            'at_field2_value' => $this->getFieldName('at_field2'),
            'at_field3_value' => $this->getFieldName('at_field3'),
            'at_field4_value' => $this->getFieldName('at_field4'),
            'at_field5_value' => $this->getFieldName('at_field5'),
            'ac_field1_value' => $this->getFieldName('ac_field1'),
            'ac_field2_value' => $this->getFieldName('ac_field2'),
            'ac_field3_value' => $this->getFieldName('ac_field3'),
            'ac_field4_value' => $this->getFieldName('ac_field4'),
            'ac_field5_value' => $this->getFieldName('ac_field5'),
            'al_field1_value' => $this->getFieldName('al_field1'),
            'al_field2_value' => $this->getFieldName('al_field2'),
            'al_field3_value' => $this->getFieldName('al_field3'),
            'al_field4_value' => $this->getFieldName('al_field4'),
            'al_field5_value' => $this->getFieldName('al_field5'),
            'af_field1_files' => $this->getFieldName('af_field1'),
            'af_field2_files' => $this->getFieldName('af_field2'),
            'af_field3_files' => $this->getFieldName('af_field3'),
            'af_field4_files' => $this->getFieldName('af_field4'),
            'af_field5_files' => $this->getFieldName('af_field5')             
        );
    }

    public function firstName($language = NULL) {
        return $this->value('firstname', $language);
    }

    public function strictFirstName($language) {
        return $this->strictValue('firstname', $language);
    }

    public function lastName($language = NULL) {
        return $this->value('lastname', $language);
    }

    public function strictLastName($language) {
        return $this->strictValue('lastname', $language);
    }

    public function middleName($language = NULL) {
        return $this->value('middlename', $language);
    }

    public function strictMiddleName($language) {
        return $this->strictValue('middlename', $language);
    }

    public function country($language = NULL) {
        return $this->value('country', $language);
    }

    public function city($language = NULL) {
        return $this->value('city', $language);
    }

    public function institution($language = NULL) {
        return $this->value('institution', $language);
    }

    public function institutionAddress($language = NULL) {
        return $this->value('institution_address', $language);
    }

    public function position($language = NULL) {
        return $this->value('position', $language);
    }

    public function academicDegree($language = NULL) {
        return $this->value('academic_degree', $language);
    }

    public function academicTitle($language = NULL) {
        return $this->value('academic_title', $language);
    }

    public function supervisor($language = NULL) {
        return $this->value('supervisor', $language);
    }

    public function homeAddress($language = NULL) {
        return $this->value('home_address', $language);
    }

    public function membership($language = NULL) {
        return $this->value('membership', $language);
    }

    public function fullName($language = NULL) {
        return $this->lastName($language) . ' ' . $this->firstName($language) . ' ' . $this->middleName($language);
    }
    
    public function authorFullName($language = NULL) {
        return $this->lastName($language) . ' ' . $this->firstName($language) . ' ' . $this->middleName($language);
    }

    public function authorName($language = NULL) {
        $f = StringUtils::firstUChar($this->firstName($language));
        $m = StringUtils::firstUChar($this->middleName($language));
        $authorName = $this->lastName($language);
        if (!empty($f)) {
            $authorName.=' ' . $f . '.';
        }
        if (!empty($m)) {
            $authorName.=' ' . $m . '.';
        }
        return $authorName;
    }
    
    public function authorNameForEmail($language = NULL) {
        $f = $this->firstName($language);
        $m = $this->middleName($language);
        $l = $this->lastName($language);
        $authorName = '';
        if (!empty($f)) {
            $authorName .= $f;
        }
        if (!empty($m)) {
            $authorName .= (empty($authorName)?'': ' ') . $m;
        }
        if (!empty($l)) {
            $authorName .= (empty($authorName)?'': ' ') . $l;
        }
        return $authorName;
    }
    
    public function fullEmail($language = NULL) {
        mb_regex_encoding("UTF-8");
        $validator = new CEmailValidator();
        $validator->allowEmpty = FALSE;
        $validator->allowName = TRUE;
        $name = $this->authorNameForEmail($language);
        $email = trim($this->email);
        // remove forbidden characters (brackets and comma)
        $name = mb_ereg_replace('[<>,]', '', $name);
        $email = mb_ereg_replace('[<>,]', '', $email);
        $email = (empty($email) ? $name : "${name} <${email}>");
        if ($validator->validateValue($email)) {
            return $email;
        }
        return '';
    }

    public function authorNameDC($language) {
        $f = StringUtils::firstUChar($this->strictFirstName($language));
        $m = StringUtils::firstUChar($this->strictMiddleName($language));
        $authorName = $this->strictLastName($language);
        if (!empty($authorName))
            $authorName.=',';
        if (!empty($f)) {
            $authorName.=' ' . $f . '.';
        }
        if (!empty($m)) {
            $authorName.=' ' . $m . '.';
        }
        return $authorName;
    }

    public function authorNameDC2($language) {
        $f = StringUtils::firstUChar($this->strictFirstName($language));
        $m = StringUtils::firstUChar($this->strictMiddleName($language));
        if (!empty($f)) {
            $authorName.=$f . '.';
        }
        if (!empty($m)) {
            $authorName.=' ' . $m . '.';
        }
        $l = $this->strictLastName($language);
        if (!empty($l)) {
            $authorName.=' ' . $l;
        };
        return $authorName;
    }
    
    protected $_conf = NULL;

    public function conf() {
        if ($this->_conf == NULL) {
            $participant = ParticipantView::model()->findByPk($this->participant_id);
            $this->_conf = Conf::model()->findByPk($participant->conf_id);
        }
        return $this->_conf;
    }

    public function getConf() {
        return $this->conf();
    }

    public function setConf($conf) {
        $this->_conf = $conf;
    }

    public function findByParticipant($participant, $conf = NULL) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'participant_id=:participant_id';
        $criteria->params = array(':participant_id' => $participant->id);
        $criteria->order = 'id asc';
        $authors = $this->findAll($criteria);
        if ($conf == NULL) {
            $conf = Conf::model()->findByPk($participant->conf_id);
        }
        foreach($authors as $author) {
            $author->setConf($conf);
        };
        return $authors;
    }
    
    public function findByParticipantId($participant_id, $conf) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'participant_id=:participant_id';
        $criteria->params = array(':participant_id' => $participant_id);
        $criteria->order = 'id asc';
        $authors = $this->findAll($criteria);
        foreach($authors as $author) {
            $author->setConf($conf);
        };
        return $authors;
    }

    public function findApprovedByConf($conf) {
        $criteria = new CDbCriteria;
        $criteria->alias = 'author';
        $criteria->join = 'LEFT JOIN {{participant}} participant ON participant.id=author.participant_id';
        $criteria->condition = 'participant.conf_id=:conf_id and participant.status=' . Participant::STATUS_APPROVED;
        $criteria->params = array(':conf_id' => $conf->id);
        $criteria->order = 'author.id asc';
        $authors = $this->findAll($criteria);
        foreach($authors as $author) {
            $author->setConf($conf);
        };
        return $authors;
    }

    public function countAllByConf($conf) {
        $sql = 'select
                count(distinct author.id)
              from {{author}} author
                LEFT JOIN {{participant}} participant ON participant.id=author.participant_id
              where participant.conf_id=:conf_id';
        $cmd = $this->dbConnection->createCommand($sql);
        $cmd->params = array(':conf_id' => $conf->id);
        $count = $cmd->queryScalar();
        return $count;
    }

    public function countApprovedByConf($conf) {
        $sql = 'select
                count(distinct author.id)
              from {{author}} author
                LEFT JOIN {{participant}} participant ON participant.id=author.participant_id
              where participant.conf_id=:conf_id and participant.status=1';
        $cmd = $this->dbConnection->createCommand($sql);
        $cmd->params = array(':conf_id' => $conf->id);
        $count = $cmd->queryScalar();
        return $count;
    }

    public function findAllByConf($conf) {
        $criteria = new CDbCriteria;
        $criteria->alias = 'author';
        $criteria->join = 'LEFT JOIN {{participant}} participant ON participant.id=author.participant_id';
        $criteria->condition = 'participant.conf_id=:conf_id ';
        $criteria->params = array(':conf_id' => $conf->id);
        $criteria->order = 'author.id asc';
        return $this->findAll($criteria);
    }

    public function groupByParticipant($authors) {
        $groups = array();
        foreach ($authors as $author) {
            $id = $author->participant_id;
            if (!array_key_exists($id, $groups)) {
                $groups[$id] = array();
            }
            array_push($groups[$id], $author);
        }
        return $groups;
    }

    public static function createFromUser($user) {
        $author = new Author();
        $author->firstname = $user->firstname;
        $author->lastname = $user->lastname;
        $author->middlename = $user->middlename;
        $author->email = $user->email;
        $author->locale = $user->locale;
        $author->phone = $user->phone;
        $author->fax = $user->fax;
        $author->country = array(Yii::app()->language => $user->country);
        $author->city = array(Yii::app()->language => $user->city);
        $author->institution = array(Yii::app()->language => $user->institution);
        $author->institution_address = array(Yii::app()->language => $user->institution_address);
        $author->position = array(Yii::app()->language => $user->position);
        $author->academic_degree = array(Yii::app()->language => $user->academic_degree);
        $author->academic_title = array(Yii::app()->language => $user->academic_title);
        $author->supervisor = array(Yii::app()->language => $user->supervisor);
        $author->home_address = array(Yii::app()->language => $user->home_address);
        $userImage = $user->getFile('image');
        if ((($userImage != NULL) && !$userImage->isEmpty())) {
            $authorImage = $userImage->createTempCopy($author, 'Author', 'image', FileType::LOGO);
            if ($authorImage != NULL) {
                $author->setFile($authorImage, 'image');
            };
        }
        return $author;
    }

    protected function beforeValidate() {
        if (parent::beforeValidate()) {
            $this->email = trim($this->email);
            return true;
        }
        return false;
    }

}

?>
