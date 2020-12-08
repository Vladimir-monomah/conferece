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
class AuthManager extends CDbAuthManager {

    public function checkAccess($itemName, $userId, $params = array()) {
        $assignments = array(); //$this->getAuthAssignments($userId);
        return $this->checkAccessRecursive($itemName, $userId, $params, $assignments);
    }

    const ROLE_GUEST = 'guest';
    const ROLE_AUTHENTICATED = 'authenticated';
    const ROLE_OWNER = 'owner';
    const ROLE_REVIEWER = 'reviewer';
    const ROLE_CONF_ADMIN = 'conf_admin';
    const ROLE_ADMIN = 'admin';

    protected $_conf = NULL;

    protected function getConf($conf_id) {
        if ($this->_conf == NULL || ($this->_conf->id != $conf_id)) {
            $this->_conf = BaseConfView::model()->findByPk($conf_id);
        };
        return $this->_conf;
    }

    public function isAdmin($user_id = NULL) {
        if ($user_id == NULL) {
            $user_id = Yii::app()->user->id;
        }
        if ($user_id == NULL) {
            return false;
        }
        $sql = "select count(*) from {{user}} where id=:id and role='admin'";
        $command = $this->db->createCommand($sql)->bindValue(':id', $user_id);
        $count = $command->queryScalar();
        return $count > 0;
    }
    
    protected function canCreateConf($user_id = NULL){
        if ($user_id == NULL) {
            $user_id = Yii::app()->user->id;
        }
        if ($user_id == NULL) {
            return false;
        }
        if ($this->isAdmin($user_id)){
            return true;
        }
        return (Yii::app()->params['usersThatCreateConf'] !== 'admins');
    }

    protected function isEnabledConf($conf_id) {
        if ($conf_id == NULL) {
            return false;
        }
        $sql = 'select is_enabled from {{conf}} where id=:conf_id';
        $command = $this->db->createCommand($sql)->bindValue(':conf_id', $conf_id);
        $is_enabled = $command->queryScalar();
        return $is_enabled == true;
    }

    public function isConfAdmin($conf_id, $user_id = NULL) {
        if ($conf_id == NULL) {
            return false;
        }
        if ($user_id == NULL) {
            $user_id = Yii::app()->user->id;
        }
        if ($user_id == NULL) {
            return false;
        }
        $user = ConfAdmin::model()->find("user_id=:user_id and conf_id=:conf_id", array(':user_id' => $user_id, ':conf_id' => $conf_id));
        return $user != NULL;
    }

    public function isOwner($class, $id, $owner_attr = 'user_id', $user_id = NULL) {
        if ($class == NULL || $id == NULL) {
            return false;
        }
        if ($user_id == NULL) {
            $user_id = Yii::app()->user->id;
        }
        if ($user_id == NULL) {
            return false;
        }
        $cmd = $this->db->createCommand()
                ->select('id')
                ->from('{{' . mb_strtolower($class) . '}}');
        $cmd->where('id=:id and ' . $owner_attr . '=:owner_id', array(':id' => $id, ':owner_id' => $user_id));
        $scalar = $cmd->queryScalar();
        return $scalar > 0;
    }

    protected function isParticipantPublished($participant_id) {
        //  см. реализацию $participant->isPublished()
        //  see $participant->isPublished() 
        $sql = 'select id, status,conf_id, participation_type, topic_id from {{participant}} where id=:participant_id';
        $command = $this->db->createCommand($sql)->bindValue(':participant_id', $participant_id);
        $participant = $command->queryRow();
        $published = false;
        if ($participant) {
            $conf = ConfView::model()->findByPk($participant['conf_id']);
            $published = ($conf->topicCount == 0) || !empty($participant['topic_id']);
            $published = $published && ($participant['status'] == Participant::STATUS_APPROVED) && $conf->isParticipantsPublished() && ($conf->participant_publishing_option == ParticipantPublishingOption::FULL_LIST);
            if (!$conf->show_all_participants) {
                if (!ParticipationType::isOfType($participant['participation_type'], ParticipationType::TYPE_PAPER)) {
                    $published = false;
                }
            };
        }
        return $published;
    }

    /**  
     *  Администратор конференции и администратор сайта могут всегда изменять доклад.
     *  Создатель не может изменять свой доклад, если:
     *      1) в соответствие с опцией в настройках,
     *      2) конференция закрыта,
     *      3) есть рецензии (не реализовано).
     * 
     *  Website administration and administrator of the conferense can always
     *  modify participant.
     *  The owner can NOT modify their application:
     *      1) with correspondence with an option in settings,
     *      2) if the conference is disabled,
     *      3) there are some reviews (not implemented yet).    
     */
    protected function canModifyParticipant($participant_id, $conf_id, $user_id = NULL) {
        if ($user_id == NULL) {
            $user_id = Yii::app()->user->id;
        }
        if ($this->isAdmin($user_id) || $this->isConfAdmin($conf_id, $user_id)) {
            return true;
        }
        $sql = 'select id, status, user_id from {{participant}} where id=:participant_id';
        $command = $this->db->createCommand($sql)->bindValue(':participant_id', $participant_id);
        $participant = $command->queryRow();
        if ($participant == NULL) {
            return false;
        }
        //  заявка не от текущего пользователя
        //  application is not from current user
        if ($participant['user_id'] != $user_id) {
            return false;
        }
        $conf = $this->getConf($conf_id);

        //  конференция закрыта
        //  the conference is disabled
        if (!$conf->is_enabled) {
            return false;
        };

        if (($conf->participant_editing_option == ParticipantEditingOption::ANY) || ($conf->participant_editing_option == ParticipantEditingOption::APPROVED)) {
            //  заявка принята
            //  application is approved
            if ($participant['status'] == Participant::STATUS_APPROVED) {
                return false;
            }
        };

        if (($conf->participant_editing_option == ParticipantEditingOption::ANY) || ($conf->participant_editing_option == ParticipantEditingOption::DATE)) {
            //  истекла реальная дата окончания принятия докладов
            //  real submission date is over
            $now = DateUtils::today();
            $date = $conf->getSubmissionEndDate();
            if ($date < $now) {
                return false;
            }
        }

        //  есть рецензии
        //  there are some reviews
        /*
          $reviews=get_reviews($conf, $member_id);
          if($reviews) {
          foreach($reviews as $review) {
          if($review['approved']!=2) {
          return false;
          }
          }
          } */

        return true;
    }

    public function canModifyParticipantTopic($participant_id, $user_id) {
        if ($user_id == NULL) {
            $user_id = Yii::app()->user->id;
        }
        if ($this->isAdmin($user_id) || $this->isConfAdmin($conf_id, $user_id)) {
            return true;
        }
        $sql = 'select id, status, user_id from {{participant}} where id=:participant_id';
        $command = $this->db->createCommand($sql)->bindValue(':participant_id', $participant_id);
        $participant = $command->queryRow();
        if ($participant == NULL) {
            return false;
        };
        //  заявка не от текущего пользователя
        //  the application is not from current user
        if ($participant['user_id'] != $user_id) {
            return false;
        };

        if ($participant['status'] == Participant::STATUS_APPROVED) {
            return false;
        };

        return true;
    }

    /**  
     *  Администраторы всегда могут подать новую заявку. 
     *  Подавать заявку нельзя, если:
     *      1) конференция закрыта,
     *      2) если не включена онлайн регистрация,
     *      3) и дата окончания регистрации истекла.
     * 
     *  Administration can always submit new application.
     *  A user can NOT submit an application:
     *      1) if the conference is disabled,
     *      2) if online registration is off,
     *      3) if the registration date is over.    
     */
    public function canCreateParticipant($conf_id, $user_id = NULL) {
        if ($user_id == NULL) {
            $user_id = Yii::app()->user->id;
        }
        if ($this->isAdmin($user_id) || $this->isConfAdmin($conf_id, $user_id)) {
            return true;
        }
        $conf = $this->getConf($conf_id);
        if (!$conf->is_enabled) {
            return false;
        };
        if (!$conf->is_registration_enabled) {
            return false;
        }
        $now = DateUtils::today();
        $date = $conf->getRegistrationEndDate();
        if ($date < $now) {
            return false;
        }
        return true;
    }

    public function canViewMyApplicationPage($conf_id, $user_id = NULL) {
        if ($user_id == NULL) {
            $user_id = Yii::app()->user->id;
        }
        if ($this->isAdmin($user_id) || $this->isConfAdmin($conf_id, $user_id)) {
            return false;
        }
        $conf = $this->getConf($conf_id);
        if (!$conf->is_enabled) {
            return false;
        };
        $count = Participant::model()->countByAttributes(array('user_id' => $user_id, 'conf_id' => $conf_id));
        return ($count > 0);
    }

    public function canViewApplicationPageLink($conf_id, $user_id = NULL) {
        $conf = $this->getConf($conf_id);
        if (!$conf->is_enabled) {
            return false;
        };
        if (!$conf->is_registration_enabled) {
            return false;
        };
        $now = DateUtils::today();
        $date = $conf->getRegistrationEndDate();
        if ($date < $now) {
            return false;
        }
        return true;
    }
    
    public function canAccessApplicationPage($conf_id, $user_id = NULL) {
        if ($user_id == NULL) {
            $user_id = Yii::app()->user->id;
        };
        if ($this->isAdmin($user_id) || $this->isConfAdmin($conf_id, $user_id)) {
            return true;
        }
        /*if ($this->canViewApplicationPageLink($conf_id, $user_id)) {
            return true;
        };*/
        $conf = $this->getConf($conf_id);
        if (!$conf->is_enabled) {
            return false;
        };
        if (!$conf->is_registration_enabled) {
            return false;
        };
        return true; // return false;
    }

    /**  
     *  Метод инициализирует систему авторизации. Нужно вызвать один раз
     *  в начале создания сайта.
     * 
     *  The method initializes authorization system. It should be invoked
     *  once in the beginning of the creation of the website.   
     */
    public function createRoles() {
        $this->createTables();
        $transaction = Yii::app()->db->beginTransaction();
        try {
            //  операции с пользователями
            //  user operations
            $this->createOperation('listUsers', 'View User List');
            $this->createOperation('createUser', 'Create User');
            $this->createOperation('viewUser', 'View User');
            $this->createOperation('modifyUser', 'Modify User');
            $this->createOperation('assignUserRole', 'Assign User`s Role');

            //  операции с организациями
            //  operations with organizations
            $this->createOperation('listOrgs', 'View List of Orgarizations');
            $this->createOperation('createOrg', 'Create Organization');
            $this->createOperation('viewOrg', 'View Organization');
            $this->createOperation('modifyOrg', 'Modify Organization');

            //  операции с конференциями
            //  operations with conferences
            $this->createOperation('listConfs', 'View List of Conferences');
            $bizRule = 'return Yii::app()->authManager->canCreateConf($params["user_id"]);';
            $this->createOperation('createConf', 'Create Conference', $bizRule);
            $bizRule = 'return Yii::app()->authManager->isEnabledConf($params["conf_id"]);';
            $viewEnabledConf = $this->createOperation('viewEnabledConf', 'View Enabled Conference', $bizRule);
            $this->createOperation('viewConf', 'View Conference');
            $viewEnabledConf->addChild('viewConf');
            $modifyConf = $this->createOperation('modifyConf', 'Modify Conference');
            $modifyConf->addChild('viewConf');
            $this->createOperation('enableConf', 'Enable|Disable Conference');
            $this->createOperation('viewGuestbook', 'View messages in guestbook');
            $this->createOperation('postGuestbook', 'Post messages in guestbook');
            $this->createOperation('editGuestbook', 'Post/delete messages in guestbook');

            //  операции с заявками на участие
            //  Operations with applications
            $viewPublishedParticipants = $this->createOperation('viewPublishedParticipants', 'View Published Participants');
            $viewAllParticipants = $this->createOperation('viewAllParticipants', 'View All Participants');
            $exportParticipants = $this->createOperation('exportParticipants', 'Export All Participants');
            $exportParticipants->addChild('viewAllParticipants');
            $bizRule = 'return Yii::app()->authManager->canCreateParticipant($params["conf_id"]);';
            $this->createOperation('createParticipant', 'Create Participant/Apply for Participation', $bizRule);
            $bizRule = 'return Yii::app()->authManager->isParticipantPublished($params["participant_id"]);';
            $this->createOperation('viewPublishedParticipant', 'View Published Participant', $bizRule);
            $this->createOperation('viewParticipant', 'View Participant');
            $bizRule = 'return Yii::app()->authManager->canModifyParticipant($params["participant_id"],$params["conf_id"],$params["user_id"]);';
            $this->createOperation('modifyParticipant', 'Modify Participant', $bizRule);
            $this->createOperation('enableParticipant', 'Enable|Disable Participant');
            $bizRule = 'return Yii::app()->authManager->canModifyParticipantTopic($params["participant_id"],$params["user_id"]);';
            $this->createOperation('modifyParticipantTopic', 'Modify Participant Topic', $bizRule);
            $bizRule = 'return Yii::app()->authManager->canViewApplicationPageLink($params["conf_id"],$params["user_id"]);';
            $this->createOperation('viewApplicationPageLink', 'View Application Page Link', $bizRule);
            $bizRule = 'return Yii::app()->authManager->canAccessApplicationPage($params["conf_id"],$params["user_id"]);';
            $this->createOperation('accessApplicationPage', 'Access Application Page', $bizRule);
            $bizRule = 'return Yii::app()->authManager->canViewMyApplicationPage($params["conf_id"],$params["user_id"]);';
            $this->createOperation('viewMyApplicationPage', 'View MyApplication Page', $bizRule);

            //  операции с рецензиями
            //  operations with reviews
            //  todo
              
            //  операции с комментариями
            //  operations with comments
            $this->createOperation('createComment', 'Create Comment');
            $this->createOperation('modifyComment', 'Modify Comment');
            $this->createOperation('enableComment', 'Enable|Disable Comment');


            //  роли и их права
            //  roles and rights
              
            //  права гостевого доступа
            //  guest access rights
            $bizRule = 'return Yii::app()->user->isGuest;';
            $guest = $this->createRole(AuthManager::ROLE_GUEST, 'Guest', $bizRule);
            $guest->addChild('createUser');
            $guest->addChild('viewOrg');
            $guest->addChild('viewEnabledConf');
            $guest->addChild('listConfs');
            $guest->addChild('viewPublishedParticipants');
            $guest->addChild('createParticipant');
            $guest->addChild('viewPublishedParticipant');
            $guest->addChild('viewGuestbook');
            $guest->addChild('viewApplicationPageLink');
            $guest->addChild('accessApplicationPage');

            //  права владельца
            //  owner access rights
            $bizRule = 'return Yii::app()->authManager->isOwner($params["class"],$params["id"],$params["owner_attr"],$params["user_id"]);';
            $owner = $this->createRole(AuthManager::ROLE_OWNER, 'Owner Role', $bizRule);
            $owner->addChild('viewUser');
            $owner->addChild('modifyUser');
            $owner->addChild('viewParticipant');
            $owner->addChild('modifyParticipant');
            $owner->addChild('modifyComment');
            $owner->addChild('modifyParticipantTopic');
            //  todo modifyReview
            
            //  права авторизованного пользователя
            //  authorized user access rights
            $bizRule = 'return !Yii::app()->user->isGuest;';
            $authenticated = $this->createRole(AuthManager::ROLE_AUTHENTICATED, 'Authenticated User', $bizRule);
            $authenticated->addChild('viewOrg');
            $authenticated->addChild('viewEnabledConf');
            $authenticated->addChild('listConfs');
            $authenticated->addChild('createOrg');
            $authenticated->addChild('createConf');
            $authenticated->addChild('viewPublishedParticipants');
            $authenticated->addChild('createParticipant');
            $authenticated->addChild('viewPublishedParticipant');
            $authenticated->addChild('postGuestbook');
            $authenticated->addChild('createComment');
            $authenticated->addChild('viewApplicationPageLink');
            $authenticated->addChild('accessApplicationPage');
            $authenticated->addChild('viewMyApplicationPage');

            //  права администратора конференции
            //  conference administrator access rights
            $bizRule = 'return Yii::app()->authManager->isConfAdmin($params["conf_id"],$params["user_id"]);';
            $confAdmin = $this->createRole(AuthManager::ROLE_CONF_ADMIN, 'Conference Administrator', $bizRule);
            $confAdmin->addChild('modifyConf');
            $confAdmin->addChild('viewAllParticipants');
            $confAdmin->addChild('viewParticipant');
            $confAdmin->addChild('modifyParticipant');
            $confAdmin->addChild('enableParticipant');
            $confAdmin->addChild('editGuestbook');
            $confAdmin->addChild('modifyComment');
            $confAdmin->addChild('enableComment');
            $confAdmin->addChild('modifyParticipantTopic');

            //  права администратора сайта
            //  website administrator access rights
            $bizRule = 'return Yii::app()->authManager->isAdmin($params["user_id"]);';
            $admin = $this->createRole(AuthManager::ROLE_ADMIN, 'Administrator', $bizRule);
            $admin->addChild('viewUser');
            $admin->addChild('listUsers');
            $admin->addChild('listOrgs');
            $admin->addChild('modifyUser');
            $admin->addChild('modifyOrg');
            $admin->addChild('assignUserRole');
            $admin->addChild('modifyConf');
            $admin->addChild('enableConf');
            $admin->addChild('viewAllParticipants');
            $admin->addChild('viewParticipant');
            $admin->addChild('modifyParticipant');
            $admin->addChild('enableParticipant');
            $admin->addChild('editGuestbook');
            $admin->addChild('modifyComment');
            $admin->addChild('enableComment');
            $admin->addChild('modifyParticipantTopic');

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            Yii::log("Error occured when creating roles.", 'error', 'CreateCommand.actionRoles');
            throw $e;
        }
    }

    public function createTables() {
        //  sql взят из файла framework/web/auth/schema.sql
        //  sql is taken from framework/web/auth/schema.sql
        $sql = "drop table if exists {{authassignment}}";
        $res = Yii::app()->db->createCommand($sql)->execute();
        $sql = "drop table if exists {{authitemchild}}";
        $res = Yii::app()->db->createCommand($sql)->execute();
        $sql = "drop table if exists {{authitem}}";
        $res = Yii::app()->db->createCommand($sql)->execute();
        $sql = "create table {{authitem}}
(
   `name`                 varchar(64) not null,
   `type`                 integer not null,
   `description`          text,
   `bizrule`              text,
   `data`                 text,
   primary key (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
        $res = Yii::app()->db->createCommand($sql)->execute();
        $sql = "create table {{authitemchild}}
(
   `parent`               varchar(64) not null,
   `child`                varchar(64) not null,
   primary key (`parent`,`child`),
   foreign key (`parent`) references {{authitem}} (`name`) on delete cascade on update cascade,
   foreign key (`child`) references {{authitem}} (`name`) on delete cascade on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
        $res = Yii::app()->db->createCommand($sql)->execute();
        $sql = "create table {{authassignment}}
(
   `itemname`             varchar(64) not null,
   `userid`               varchar(64) not null,
   `bizrule`              text,
   `data`                 text,
   primary key (`itemname`,`userid`),
   foreign key (`itemname`) references {{authitem}} (`name`) on delete cascade on update cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
        $res = Yii::app()->db->createCommand($sql)->execute();
    }

}

?>
