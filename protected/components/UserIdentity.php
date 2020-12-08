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
class UserIdentity extends CUserIdentity {

    private $_id;

    public function findUser() {
        $user = NULL;
        if (!empty($this->username) && !empty($this->password)) {
            $user = User::model()->find("email=:email and password=password(:pwd)", array(':email' => $this->username, ':pwd' => $this->password));
        };
        return $user;
    }

    public function authenticate() {
        $user = $this->findUser();
        if (!isset($user))
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else {
            $this->_id = $user->id;
            //$this->setState('fullname', $user->fullName());
            $this->errorCode = self::ERROR_NONE;
        };
        return !$this->errorCode;
    }

    public function getId() {
        return $this->_id;
    }

}

?>
