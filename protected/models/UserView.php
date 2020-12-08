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
class UserView extends ActiveRecord {

    public $id;
    public $email;
    //  многоязычные поля
    //  multilingual fields
    public $firstname = array();
    public $lastname = array();
    public $middlename = array();
    protected $_fullname = '';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{user}}';
    }

    public function fullName() {
        return $this->_fullname;
    }

    protected function rowsToObjects($rows) {
        $users = array();
        $user = NULL;
        $last_id = NULL;
        $rows[] = array('id' => 'last'); // fake row
        foreach ($rows as $row) {
            $id = $row['id'];
            if ($last_id != $id) {
                if ($user != NULL) {
                    $language = Yii::app()->language;
                    $fullname = trim($user->lastname[$language] . ' ' . $user->firstname[$language] . ' ' . $user->middlename[$language]);
                    if (empty($fullname)) {
                        $languages = Yii::app()->params['languages'];
                        foreach ($languages as $language => $name) {
                            $fullname = $user->lastname[$language] . ' ' . $user->firstname[$language] . ' ' . $user->middlename[$language];
                            if ($fullname != '  ')
                                break;
                        }
                    }
                    $user->_fullname = $fullname;
                }
                if ($id == 'last') {
                    break;
                };
                $user = new UserView();
                $users[] = $user;
                $user->id = $id;
                $user->email = $row['email'];
                $last_id = $id;
            }

            $lang = $row['lang'];
            $user->firstname[$lang] = $row['firstname'];
            $user->lastname[$lang] = $row['lastname'];
            $user->middlename[$lang] = $row['middlename'];
        }
        return $users;
    }

    public function findAll() {
        $sql = "select
            u.id id,
            trim(u.email) email,
            mu.`language` lang,
            trim(mu.lastname) lastname,
            trim(mu.firstname) firstname,
            trim(mu.middlename) middlename
            from
            {{user}} u, {{multilingual_user}} mu
            where mu.user_id=u.id";
        $cmd = $this->dbConnection->createCommand($sql);
        $rows = $cmd->queryAll();
        return $this->rowsToObjects($rows);
    }

    public function findAllEmailAsc() {
        $sql = "select
            u.id id,
            trim(u.email) email,
            mu.`language` lang,
            trim(mu.lastname) lastname,
            trim(mu.firstname) firstname,
            trim(mu.middlename) middlename
            from
            {{user}} u, {{multilingual_user}} mu
            where mu.user_id=u.id
            order by trim(u.email) asc";
        $cmd = $this->dbConnection->createCommand($sql);
        $rows = $cmd->queryAll();
        return $this->rowsToObjects($rows);
    }

    public function findAllEmailDesc() {
        $sql = "select
            u.id id,
            trim(u.email) email,
            mu.`language` lang,
            trim(mu.lastname) lastname,
            trim(mu.firstname) firstname,
            trim(mu.middlename) middlename
            from
            {{user}} u, {{multilingual_user}} mu
            where mu.user_id=u.id
            order by trim(u.email) desc";
        $cmd = $this->dbConnection->createCommand($sql);
        $rows = $cmd->queryAll();
        return $this->rowsToObjects($rows);
    }

    public function SortByFullNameAsc($user1, $user2) {
        $value1 = $user1->fullName();
        $value2 = $user2->fullName();
        return strcmp($value1, $value2);
    }

    public function SortByFullNameDesc($user1, $user2) {
        $value1 = $user1->fullName();
        $value2 = $user2->fullName();
        return strcmp($value2, $value1);
    }

    public function findAllFullNameAsc() {
        $users = $this->findAll();
        usort($users, array("UserView", "SortByFullNameAsc"));
        return $users;
    }

    public function findAllFullNameDesc() {
        $users = $this->findAll();
        usort($users, array("UserView", "SortByFullNameDesc"));
        return $users;
    }

    public function findByEmail($email) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'email=:email';
        $criteria->params = array(':email' => $email);
        return $this->find($criteria);
    }

}

?>
