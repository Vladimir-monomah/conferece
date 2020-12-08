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
class User extends ActiveRecord {

    public $id;
    public $email;
    public $password;
    public $country;
    public $city;
    public $institution;
    public $institution_address;
    public $position;
    public $academic_degree;
    public $academic_title;
    public $supervisor;
    public $home_address;
    public $phone;
    public $fax;
    public $locale;
    //  многоязычные оля
    //  multilingual fields
    public $firstname;
    public $lastname;
    public $middlename;
    //  вспомогательные поля
    //  auxiliary fields
    public $password1;
    public $password2;

    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';

    //  значение роли по умолчанию
    //  default role value
    public $role = User::ROLE_USER;
    
    // honeypot
    public $ukazhite_e_mail;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function createFromAuthor($author) {
        $user = new User();
        $user->email = $author->email;

        $user->firstname = $author->firstname;
        $user->lastname = $author->lastname;
        $user->middlename = $author->middlename;

        $user->locale = $author->locale;
        $user->phone = $author->phone;
        $user->fax = $author->fax;

        $user->country = isset($author->country[Yii::app()->language])?$author->country[Yii::app()->language]:'';
        $user->city = isset($author->city[Yii::app()->language])?$author->city[Yii::app()->language]:'';
        $user->institution = isset($author->institution[Yii::app()->language])?$author->institution[Yii::app()->language]:'';
        $user->institution_address = isset($author->institution_address[Yii::app()->language])?$author->institution_address[Yii::app()->language]:'';
        $user->position = isset($author->position[Yii::app()->language])?$author->position[Yii::app()->language]:'';
        $user->academic_degree = isset($author->academic_degree[Yii::app()->language])?$author->academic_degree[Yii::app()->language]:'';
        $user->academic_title = isset($author->academic_title[Yii::app()->language])?$author->academic_title[Yii::app()->language]:'';
        $user->supervisor = isset($author->supervisor[Yii::app()->language])?$author->supervisor[Yii::app()->language]:'';
        $user->home_address = isset($author->home_address[Yii::app()->language])?$author->home_address[Yii::app()->language]:'';

        return $user;
    }

    public function copyAuthorImage($author) {
        $authorImage = $author->getFile('image');
        if ((($authorImage != NULL) && !$authorImage->isEmpty())) {
            $userImage = $authorImage->createCopy($this, 'User', 'image', FileType::LOGO);
            if ($userImage != NULL) {
                $this->setFile($userImage, 'image');
            };
        };
    }

    public function tableName() {
        return '{{user}}';
    }

    public function rules() {
        return array(
            //  unsafe
            array('id', 'unsafe'),
            array('role', 'unsafe'),
            //  search scenario
            array('lastname,firstname,middlename, email', 'safe', 'on' => 'search'),
            //  save scenario
            array('email', 'required', 'on' => 'save'),
            array('email', 'email', 'on' => 'save'),
            array('email', 'unique', 'on' => 'save'),
            array('email', 'length', 'on' => 'save', 'max' => 100),
            array('password1', 'compare', 'compareAttribute' => 'password2', 'on' => 'save'),
            array('password2', 'safe', 'on' => 'save'),
            array('password1,password2', 'length', 'on' => 'save', 'max' => 50),
            array('password', 'unsafe'),
            array('image', 'FilesValidator', 'on' => 'save', 'size' => Yii::app()->params['userFileSize'], 'exts' => Yii::app()->params['logoExts']),
            array('lastname,firstname', 'RequiredOneValidator', 'on' => 'save'),
            array('lastname,firstname,middlename', 'LengthEachValidator', 'on' => 'save', 'max' => 30),
            array('phone', 'length', 'on' => 'save', 'max' => 100),
            array('fax', 'length', 'on' => 'save', 'max' => 40),
            array('locale', 'safe', 'on' => 'save'),
            array('country,city', 'length', 'on' => 'save', 'max' => 100),
            array('home_address,institution_address,position', 'length', 'on' => 'save', 'max' => 150),
            array('institution', 'length', 'on' => 'save', 'max' => 300),
            array('academic_degree, academic_title', 'length', 'on' => 'save', 'max' => 100),
            array('supervisor', 'length', 'on' => 'save', 'max' => 200),
            //  register scenario
            array('ukazhite_e_mail', 'HoneypotValidator', 'on' => 'register'),
            array('email', 'required', 'on' => 'register'),
            array('email', 'email', 'on' => 'register'),
            array('email', 'unique', 'on' => 'register'),
            array('email', 'length', 'on' => 'register', 'max' => 100),
            array('password1', 'compare', 'compareAttribute' => 'password2', 'on' => 'register'),
            array('password1,password2', 'required', 'on' => 'register'),
            array('password1,password2', 'length', 'on' => 'register', 'max' => 50),
            array('password', 'unsafe'),
            array('lastname,firstname', 'RequiredOneValidator', 'on' => 'register'),
            array('lastname,firstname,middlename', 'LengthEachValidator', 'on' => 'register', 'max' => 30),
            array('phone,country,city', 'length', 'on' => 'register', 'max' => 100),
            array('institution_address,position', 'length', 'on' => 'register', 'max' => 150),
            array('institution', 'length', 'on' => 'register', 'max' => 300),
            array('academic_degree, academic_title', 'length', 'on' => 'register', 'max' => 100),
            array('supervisor', 'length', 'on' => 'register', 'max' => 200),
            array('image', 'FilesValidator', 'on' => 'register', 'size' => Yii::app()->params['userFileSize'], 'exts' => Yii::app()->params['logoExts']),
            array('registration_date', 'default', 'on' => 'register', 'value' => time()),
            array('last_date', 'default', 'on' => 'register', 'value' => time()),
            array('last_ip', 'default', 'on' => 'register', 'value' => Yii::app()->request->userHostAddress),
            array('locale', 'default', 'on' => 'register', 'value' => Yii::app()->language),
        );
    }

    public function attributeLabels() {
        return array(
            'lastname' => Yii::t('users', 'Lastname'),
            'firstname' => Yii::t('users', 'Firstname'),
            'middlename' => Yii::t('users', 'Middlename'),
            'email' => Yii::t('users', 'E-mail'),
            'ukazhite_e_mail' => Yii::t('validators', 'Enter E-mail'),
            'password1' => Yii::t('users', 'Password'),
            'password2' => Yii::t('users', 'Password confirmation'),
            'phone' => Yii::t('users', 'Telephone'),
            'fax' => Yii::t('users', 'Fax'),
            'locale' => Yii::t('users', 'Preferred Language'),
            'country' => Yii::t('users', 'Country'),
            'city' => Yii::t('users', 'City'),
            'home_address' => Yii::t('users', 'Home Address'),
            'institution' => Yii::t('users', 'Institution'),
            'institution_address' => Yii::t('users', 'Institution Address'),
            'position' => Yii::t('users', 'Position'),
            'academic_degree' => Yii::t('users', 'Academic Degree'),
            'academic_title' => Yii::t('users', 'Academic Title'),
            'supervisor' => Yii::t('users', 'Supervisor'),
            'last_date' => Yii::t('users', 'Last Date'),
            'last_ip' => Yii::t('users', 'Last IP'),
            'registration_date' => Yii::t('users', 'Registration Date'),
            'role' => Yii::t('users', 'Role'),
            'image' => Yii::t('users', 'Image'),
        );
    }

    protected function beforeValidate() {
        if (parent::beforeValidate()) {
            $this->email = trim($this->email);
            $this->password1 = trim($this->password1);
            $this->password2 = trim($this->password2);
            return true;
        }
        return false;
    }

    public function afterValidate() {
        parent::afterValidate();
        if (!empty($this->password1)) {
            $this->password = new CDbExpression("password('{$this->password1}')");
        }
    }

    public function behaviors() {
        return array(
            'MultilingualBehavior' => array(
                'class' => 'application.behaviors.MultilingualBehavior',
                'table' => 'multilingual_user',
                'table_fk' => 'user_id',
                'language_column' => 'language',
                'columns' => array('firstname', 'lastname', 'middlename'),
                'languages' => Yii::app()->params['languages'],
            ),
            'StrictXssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('institution', 'supervisor'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => XssFilter::$STRICTED_ALLOWED_TAGS
            ),
            'FullXssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('firstname', 'lastname', 'middlename',
                    'email', 'phone', 'fax',
                    'country', 'city', 'institution_address', 'position',
                    'academic_degree', 'academic_title', 'home_address'),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => array()
            ),
            'FilesBehavior' => array(
                'class' => 'application.behaviors.FilesBehavior',
                'fileAttrs' => array(
                    'image' => FileType::LOGO)
            )
        );
    }

    public function firstName($language = NULL) {
        return $this->value('firstname', $language);
    }

    public function lastName($language = NULL) {
        return $this->value('lastname', $language);
    }

    public function middleName($language = NULL) {
        return $this->value('middlename', $language);
    }

    public function fullName($language = NULL) {
        return $this->lastName($language) . ' ' . $this->firstName($language) . ' ' . $this->middleName($language);
    }
    
    public function fullNameForEmail($language = NULL) {
        $f = $this->firstName($language);
        $m = $this->middleName($language);
        $l = $this->lastName($language);
        $name = '';
        if (!empty($f)) {
            $name .= $f;
        }
        if (!empty($m)) {
            $name .= (empty($name)?'': ' ') . $m;
        }
        if (!empty($l)) {
            $name .= (empty($name)?'': ' ') . $l;
        }
        return $name;
    }
    
    public function fullEmail($language = NULL) {
        mb_regex_encoding("UTF-8");
        $validator = new CEmailValidator();
        $validator->allowEmpty = FALSE;
        $validator->allowName = TRUE;
        $name = $this->fullNameForEmail($language);
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

    public function findAllEmailAsc() {
        $criteria = new CDbCriteria;
        $criteria->order = 'email asc';
        $users = $this->findAll($criteria);
        return $users;
    }

    public function findAllEmailDesc() {
        $criteria = new CDbCriteria;
        $criteria->order = 'email desc';
        $users = $this->findAll($criteria);
        return $users;
    }

    public function SortByFullNameAsc($user1, $user2) {
        $value1 = $user1->fullName();
        $value2 = $user2->fullName();
        if ($value1 == $value2) {
            return 0;
        }
        return ($value1 < $value2) ? -1 : 1;
    }

    public function SortByFullNameDesc($user1, $user2) {
        $value1 = $user1->fullName();
        $value2 = $user2->fullName();
        if ($value1 == $value2) {
            return 0;
        }
        return ($value1 > $value2) ? -1 : 1;
    }

    public function findAllFullNameAsc() {
        $users = $this->findAll();
        usort($users, array("User", "SortByFullNameAsc"));
        return $users;
    }

    public function findAllFullNameDesc() {
        $users = $this->findAll();
        usort($users, array("User", "SortByFullNameDesc"));
        return $users;
    }

    public function findByEmail($email) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'email=:email';
        $criteria->params = array(':email' => $email);
        return $this->find($criteria);
    }

    public function findAllAdmins() {
        $criteria = new CDbCriteria;
        $criteria->condition = "role='" . User::ROLE_ADMIN . "'";
        return $this->findAll($criteria);
    }
    
    protected function searchCriteria(&$criteria, $searchUser) {
        $criteria->distinct = true;
        $criteria->alias = 'u';
        $criteria->join = 'LEFT JOIN {{multilingual_user}} mu ON mu.user_id=u.id';
        $criteria->condition = 'mu.language=mu.language ';
        $email = Trim($searchUser->email);
        if (!empty($email)) {
            $criteria->condition.=' and u.email like :email ';
            $criteria->params[':email'] = '%' . $email . '%';
        };
        $lastname = Trim($searchUser->lastname());
        if (!empty($lastname)) {
            $criteria->condition.=' and mu.lastname like :lastname ';
            $criteria->params[':lastname'] = '%' . $lastname . '%';
        };
        $firstname = Trim($searchUser->firstname());
        if (!empty($firstname)) {
            $criteria->condition.=' and mu.firstname like :firstname ';
            $criteria->params[':firstname'] = '%' . $firstname . '%';
        };
        $middlename = Trim($searchUser->middlename());
        if (!empty($middlename)) {
            $criteria->condition.=' and mu.middlename like :middlename ';
            $criteria->params[':middlename'] = '%' . $middlename . '%';
        };
    }
    
    public function countForPaging($searchUser) {
        $criteria = new CDbCriteria;
        $this->searchCriteria($criteria, $searchUser);
        return $this->count($criteria);
    }
    
    public function findForPaging($searchUser, $currentPage = 0, $pageSize = 0) {
        $criteria = new CDbCriteria;
        $criteria->limit = $pageSize;
        $criteria->offset = $currentPage * $pageSize;
        $this->searchCriteria($criteria, $searchUser);        
        return $this->findAll($criteria);    
    }

    public function generateNewPassword() {
        $chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
        $max = 8;
        $size = strlen($chars) - 1;
        $password = '';
        while ($max--) {
            $password.=$chars[rand(0, $size)];
        }
        $this->password1 = $password;
        $this->password2 = $password;
        return $password;
    }

    public function onNewPassword($event) {
        $this->raiseEvent("onNewPassword", $event);
    }

    public function onCreate($event) {
        $this->raiseEvent("onCreate", $event);
    }

    protected function afterSave() {
        parent::afterSave();
        if ($this->isNewRecord) {
            //  привязываем обработчик события
            //  attaching an event handler
            $this->onCreate = array(NotificationService::getInstance(), "nofityUserCreated");
            //  инициируем то событие
            //  initiating the event
            $this->onCreate(new CEvent($this, array("user" => $this)));
        }
    }

    public function afterDelete() {
        parent::afterDelete();
        $user_id = $this->id;
        //  очищаем ссылку на создателя из заявок
        //  removing a link to the user where they is a creator of application
        $cmd = $this->dbConnection->createCommand('update {{participant}} set user_id=NULL where user_id=:user_id');
        $cmd->bindValue(":user_id", $user_id);
        $cmd->execute();
        //  удаляем админов конференции
        //  deleting conference administrators
        $admins = ConfAdmin::model()->findAllByAttributes(array('user_id' => $user_id));
        foreach ($admins as $admin) {
            $admin->delete();
        };
        //  комментирование
        //  commenting
        $cmd = $this->dbConnection->createCommand('update {{comment}} set user_id=NULL where user_id=:user_id');
        $cmd->bindValue(":user_id", $user_id);
        $cmd->execute();
    }

    public function searchAdmins($searchUser) {        
        $lastname = Trim($searchUser->lastname());
        $firstname = Trim($searchUser->firstname());
        $middlename = Trim($searchUser->middlename());
        if (empty($lastname) && empty($firstname) && empty($middlename)) {
            return false;
        };      
        $criteria = new CDbCriteria;        
        $this->searchCriteria($criteria, $searchUser);               
        return $this->findAll($criteria);
    }
    
    public function isLastAdmin(){
        $isLastAdmin = false;
        $sql = "select count(*) from {{user}} where role=:role";
        $command = $this->dbConnection->createCommand($sql);
        $command->bindValue(":role", AuthManager::ROLE_ADMIN);
        $count = $command->queryScalar(); 
        $isLastAdmin = ($count == 1) && ($this->role == AuthManager::ROLE_ADMIN);
        return $isLastAdmin;
    }

    public function xml($copyToTemp = false) {
        $xml = "<user>";
        foreach (Yii::app()->params['languages'] as $language => $name) {
            $xml.= "<firstname lang='" . $language . "'>" . htmlspecialchars($this->firstname[$language]) . "</firstname>";
        };
        foreach (Yii::app()->params['languages'] as $language => $name) {
            $xml.= "<lastname lang='" . $language . "'>" . htmlspecialchars($this->lastname[$language]) . "</lastname>";
        };
        foreach (Yii::app()->params['languages'] as $language => $name) {
            $xml.= "<middlename lang='" . $language . "'>" . htmlspecialchars($this->middlename[$language]) . "</middlename>";
        };
        $xml.="<locale>" . $this->locale . "</locale>";
        $xml.="<phone>" . htmlspecialchars($this->phone) . "</phone>";
        $xml.="<fax>" . htmlspecialchars($this->fax) . "</fax>";
        $xml.="<country>" . htmlspecialchars($this->country) . "</country>";
        $xml.="<city>" . htmlspecialchars($this->city) . "</city>";
        $xml.="<institution>" . htmlspecialchars($this->institution) . "</institution>";
        $xml.="<institution_address>" . htmlspecialchars($this->institution_address) . "</institution_address>";
        $xml.="<position>" . htmlspecialchars($this->position) . "</position>";
        $xml.="<academic_degree>" . htmlspecialchars($this->academic_degree) . "</academic_degree>";
        $xml.="<academic_title>" . htmlspecialchars($this->academic_title) . "</academic_title>";
        $xml.="<supervisor>" . htmlspecialchars($this->supervisor) . "</supervisor>";
        $xml.="<home_address>" . htmlspecialchars($this->home_address) . "</home_address>";
        $image_url = '';
        $image_filename = '';
        $image = $this->getFile('image');
        if (($image != NULL) && !$image->isEmpty()) {
            if ($image->copyToTemp()) {
                $image_url = $image->url();
                $image_filename = $image->name();
            };      
        };
        $xml.="<image_url>" . htmlspecialchars($image_url) . "</image_url>";
        $xml.="<image_filename>" . htmlspecialchars($image_filename) . "</image_filename>";    
        $xml.="</user>";
        return $xml;
    }
    
}

?>
