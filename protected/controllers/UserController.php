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
class UserController extends BaseController {

    protected function setActiveMenuItem(CAction $action) {
        $activeUrn = $action->id;
        if (in_array($activeUrn, array('view', 'edit'))) {
            $params = $this->getActionParams();
            $user_id = $params['id'];
            if (Yii::app()->user->id == $user_id) {
                //  моя страница
                //  my page
                $this->userMenu[7]['active'] = true;
            } else {
                //  пользователи
                //  users
                $this->userMenu[5]['active'] = true;
            }
        }
        if ($activeUrn == 'lostpassword') {
            //  вход
            //  login
            $this->userMenu[9]['active'] = true;
        }
        if ($activeUrn == 'list') {
            $this->userMenu[5]['active'] = true;
        }
        if ($activeUrn == 'register') {
            $this->userMenu[8]['active'] = true;
        }
    }

    public function actionIndex() {
        $this->actionList();
    }

    public function actionList($page = 0) {
        $pageSize = 50;
        
        $currentPage = $page - 1;
        if ($currentPage < 0) { 
            $currentPage = 0;
        };
          
        $searchUser = new User();               
        if (isset($_POST['User'])) {
            $searchUser->scenario = 'search';
            $searchUser->attributes = $_POST['User'];
            Yii::app()->session['searchUser'] = $_POST['User'];
        } else if (isset(Yii::app()->session['searchUser'])) {
            $searchUser->scenario = 'search';
            $searchUser->attributes = Yii::app()->session['searchUser'];
        };    
                
        $count = User::model()->countForPaging($searchUser);
                
        $users = User::model()->findForPaging($searchUser, $currentPage, $pageSize);
               
        $this->render('list', array('users' => $users, 'searchUser' => $searchUser, 'currentPage' => $currentPage, 'pageSize' => $pageSize, 'itemCount' => $count));
    }

    public function actionView($id) {
        $id = (int) $id;
        $user = User::model()->findByPk($id);
        if (!$user) {
            throw new CHttpException(404, 'User not found.');
        }
        $myConfs = ConfView::model()->with('newParticipants')->with('approvedParticipants')->findByConfAdmin($user);
        $myApplications = ParticipantView::model()->findByUserOrCreator($user);
        $this->render('view', array('user' => $user, 'myConfs' => $myConfs, 'myApplications' => $myApplications));
    }

    public function actionDeleteParticipants($id) {
        if ($_POST['delete']) {
            $deleted = $_POST['deleted'];
            if (!empty($deleted)) {
                $transaction = $this->beginTransaction();
                try {
                    foreach ($deleted as $deletedId => $value) {
                        $participant = Participant::model()->findByPk($deletedId);
                        if ($participant != NULL) {
                            $participant->delete();
                        }
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when deleting participants.", 'error', 'UserController.actionDeleteParticipants');
                    throw new CHttpException(400, 'System error.');
                }
            }
        }
        $this->redirect(array('view', 'id' => $id));
    }

    public function actionRole($id) {
        $id = (int) $id;
        $user = User::model()->findByPk($id);
        if (!$user) {
            throw new CHttpException(404, 'User not found.');
        }
        // нельзя изменять роль последнего админа
        // not allowed to change the role of the last admin
        if ($user->isLastAdmin()){
            Yii::app()->user->setFlash('error', Yii::t('confs', 'It is not allowed to delete the last website administrator.'));
            $this->redirect(array('view', 'id' => $user->id));
        };
        if (Yii::app()->request->isPostRequest) {
            $role = $_POST['role'];
            $user->role = $role;
            $transaction = $this->beginTransaction();
            try {
                $user->save(false);
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::log("Error occured when updating role for a user with id = {$user->id}.", 'error', 'UserController.actionRole');
                throw new CHttpException(400, 'System error.');
            }
        };
        $this->redirect(array('view', 'id' => $user->id));
    }

    public function actionEdit($id) {
        $id = (int) $id;
        $user = User::model()->findByPk($id);
        if (!$user) {
            throw new CHttpException(404, 'User not found.');
        }
        $fullName = $user->fullName();
        $this->render('edit', array('user' => $user, 'fullName' => $fullName));
    }

    public function actionRegister() {
        if (!Yii::app()->user->isGuest) {
            $this->redirect(array('user/view', 'id' => Yii::app()->user->id));
        };
        $user = new User;
        $captcha = new Captcha();
        if (isset($_POST['User'])) {
            $user->scenario = 'register';
            $user->attributes = $_POST['User'];
            $user->validate();
            $valid = !$user->hasErrors();
            //  капча
            //  captcha
            if (Yii::app()->user->isGuest) {
                $captcha->scenario = 'captcha';
                $captcha->attributes = $_POST['Captcha'];
                $captcha->validate();
                $valid = $valid && !$captcha->hasErrors();
            }
            if ($valid) {
                $transaction = $this->beginTransaction();
                try {
                    $user->save(false);
                    //  в транзакцию попадает метод afterSave (см. MultilingualBehavior)
                    //  method 'afterSave' executes within transaction
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when registering new user.", 'error', 'UserController.actionRegister');
                    throw new CHttpException(400, 'System error.');
                }
                $this->setLanguage($user->locale);
                $identity = new UserIdentity($user->email, $user->password1);
                $identity->authenticate();
                Yii::app()->user->login($identity);
                $this->redirect(array('user/view', 'id' => Yii::app()->user->id));
            }
        }
        $this->render('register', array('user' => $user, 'captcha' => $captcha));
    }

    public function actionLostpassword() {
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $honeypot = Trim($_POST['LoginForm']['ukazhite_e_mail']);
            if (!empty($honeypot)) {
                $this->redirect(array('lostpassword'));
            }
            $user = User::model()->findByEmail($email);
            if ($user) {
                //  генерируем новый пароль
                //  generating a new password
                $newPassword = $user->generateNewPassword();
                $transaction = $this->beginTransaction();
                try {
                    //  сохраняем с валидацией
                    //  save with validation
                    $user->save(true);                   
                    //  в транзакцию попадает метод afterSave (см. MultilingualBehavior)
                    //  method 'afterSave' executes within transaction
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when restoring user's password.", 'error', 'UserController.actionLostpassword');
                    throw new CHttpException(400, 'System error.');
                }
                //  привязываем обработчик события onNewPassword
                //  attach handler for onNewPassword event 
                $user->onNewPassword = array(NotificationService::getInstance(), "notifyNewPassword");
                //  инициируем то событие
                //  initiating the event
                $user->onNewPassword(new CEvent($this, array("user" => $user, "password" => $newPassword)));

                Yii::app()->user->setFlash('passwordSent', Yii::t('users', 'New password has been sent to your e-mail.'));
                $this->redirect(array('site/login'));
            }
            Yii::app()->user->setFlash('emailNotFound', Yii::t('users', 'E-mail not found.'));
            $this->redirect(array('lostpassword'));
        }
        $this->render('lostpassword');
    }

    public function actionSave($id) {
        $id = (int) $id;
        $user = User::model()->findByPk($id);
        if (!$user) {
            throw new CHttpException(404, 'User not found.');
        }
        $fullName = $user->fullName();
        if (Yii::app()->request->isPostRequest) {
            $user->scenario = 'save';
            if (isset($_POST['User'])) {
                $user->attributes = $_POST['User'];
            }
            $valid = $user->validate();
            if ($valid) {
                $transaction = $this->beginTransaction();
                try {
                    $user->save(false);
                    //  в транзакцию попадает метод afterSave (см. MultilingualBehavior)
                    //  method 'afterSave' executes within transaction
                    $transaction->commit();
                    
                } catch (Exception $e) {
                    $transaction->rollback();
                    Yii::log("Error occured when updating user with id = {$id}.", 'error', 'UserController.actionSave');
                    throw new CHttpException(400, 'System error.');
                }
                //  если редактируешь свою страницу, то меняем язык
                //  if updating own page then changing language 
                if (Yii::app()->user->id == $user->id) {
                    $this->setLanguage($user->locale);
                }
                Yii::app()->user->setFlash('saved', Yii::t('confs', 'Information has been saved.'));
                $this->redirect(array('view', 'id' => $user->id));
            }
        }
        $this->render('edit', array('user' => $user, 'fullName' => $fullName));
    }

    public function actionDelete($id) {
        $id = (int) $id;
        $user = User::model()->findByPk($id);
        if (!$user) {
            throw new CHttpException(404, 'User not found.');
        };
        // нельзя удалять последнего админа
        // not allowed to delete the last admin
        if ($user->isLastAdmin()){
            Yii::app()->user->setFlash('error', Yii::t('confs', 'It is not allowed to delete the last website administrator.'));
            $this->redirect(array('view', 'id' => $user->id));
        };
        if (Yii::app()->request->isPostRequest) {
            $transaction = $this->beginTransaction();
            try {
                $user->delete();
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::log("Error occured when deleting user with id = {$id}.", 'error', 'UserController.actionDelete');
                throw new CHttpException(400, 'System error.');
            }
        };
        if (Yii::app()->user->id == $id) {
            $this->redirect(array('site/logout'));
        };
        $this->redirect(array('list'));
    }
    
    /**
     *  Метод для ajax-запроса.
     * 
     *  Ajax method. 
     */
    public function actionFind($email) {
        $user = User::model()->findByEmail($email);
        if ($user) {
            echo "<root><user>Exists</user></root>";
        } else {
            echo "<root><result></result></root>";
        };
        Yii::app()->end();
    }

    public function actionAuthorize($email) {
        if (Yii::app()->request->isPostRequest) {
            $password = $_POST['password'];
            if (!empty($password)) {
                $userIdentity = new UserIdentity($email, $password);
                $user = $userIdentity->findUser();
                if ($user) {
                    echo "<root>" . $user->xml() . "</root>";
                    Yii::app()->end();
                };
            };
        };
        echo "<root><result></result></root>";
        Yii::app()->end();
    }

    /**
     *  Метод для ajax-запроса.
     * 
     *  Ajax method.
     */
    public function actionSendpassword($email) {
        $user = User::model()->findByEmail($email);
        if ($user && Yii::app()->request->isPostRequest) {
            //  генерируем новый пароль
            //  generating new password
            $newPassword = $user->generateNewPassword();
            $transaction = $this->beginTransaction();
            try {
                //  сохраняем с валидацией
                //  saving with validation
                $user->save(true);
                //  в транзакцию попадает метод afterSave (см. MultilingualBehavior)
                //  method 'afterSave' executes within transaction
                $transaction->commit();
                //  привязываем обработчик события onNewPassword
                //  attaching handler for onNewPassword event 
                $user->onNewPassword = array(NotificationService::getInstance(), "notifyNewPassword");
                //  инициируем то событие
                //  initializing the event
                $user->onNewPassword(new CEvent($this, array("user" => $user, "password" => $newPassword)));
                echo "<root><result>Password sent.</result></root>";
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::log("Error occured when restoring user's password.", 'error', 'UserController.actionLostpassword');
                echo "<root><result></result></root>";
            };
        } else {
            echo "<root><result></result></root>";
        }
        Yii::app()->end();
    }

    public function filters() {
        return array_merge(
                parent::filters(), 
                array('accessControl',)
        );
    }

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'testLimit' => 2,
                'maxLength' => 9,
                'minLength' => 8,
                'offset' => -4
            ),
        );
    }

    public function accessRules() {
        $params = 'array(
            "class" => "User",
            "id" => Yii::app()->getRequest()->getQuery("id"),
            "owner_attr" => "id",
            "user_id" => Yii::app()->user->id
        )';
        return array(
            array('allow',
                'actions' => array('register'),
                'users' => array('*')
            ),
            array('allow',
                'actions' => array('index', 'list'),
                'expression' => 'Yii::app()->user->checkAccess("listUsers",' . $params . ')'
            ),
            array('allow',
                'actions' => array('view'),
                'expression' => 'Yii::app()->user->checkAccess("viewUser",' . $params . ')'
            ),
            array('allow',
                'actions' => array('edit', 'save', 'delete', 'deleteParticipants'),
                'expression' => 'Yii::app()->user->checkAccess("modifyUser",' . $params . ')',
            ),
            array('allow',
                'actions' => array('role'),
                'expression' => 'Yii::app()->user->checkAccess("assignUserRole",' . $params . ')',
            ),
            array('allow',
                'actions' => array('captcha', 'lostpassword', 'find', 'sendpassword', 'authorize'),
                'users' => array('*'),
            ),
            array('deny',
                'users' => array('*')   //  any user
            )
        );
    }

}

?>
