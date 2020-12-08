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
class UrnRule extends CBaseUrlRule {

    public $connectionID = 'db';

    public static function isId($str) {
        if (preg_match('%^\d+$%', $str)) {
            return true;
        }
        return false;
    }

    public static function isUrn($str) {
        if (preg_match('%^[\w\d-_]+$%', $str) && !UrnRule::isId($str)) {
            return true;
        }
        return false;
    }

    protected function controller($controller, $urn, $class) {
        if ($class == 'Conf') {
            return $urn;
        }
        if ($class == 'Org') {
            $existsConf = Conf::model()->testExistsByUrn($urn);
            if (!$existsConf) {
                return $urn;
            }
        }
        if ($class == 'User') {
            $existsConf = Conf::model()->testExistsByUrn($urn);
            if (!$existsConf) {
                $existsOrg = Org::model()->testExistsByUrn($urn);
                if (!$existsOrg) {
                    return $urn;
                }
            }
        }
        return $controller . '/' . $urn;
    }

    public function createUrl($manager, $route, $params, $ampersand) {
        $url = false;

        $path = explode("/", $route);
        //  по умолчанию
        //  default url
        if ($route == Yii::app()->homeUrl) {
            $url = '';
        } else
        //  логин
        //  login
        if ($route == 'site/login') {
            $url = 'login';
        } else
        //  выход, страница о сайте, режим обслуживания
        //  logout, view and edit About page, maintenance mode    
        if (isset($path[0]) && ($path[0] == 'site')) {
            $action = isset($path[1])?$path[1]:'';
            if (in_array($action, array('logout', 'about', 'maintenance'))) {
                $url = $action;
            }
            if ($action == 'editAbout') {
                $url = 'about/edit';
            }
        } else
        //**** Пользователи ****
        //**** Users ****
        
        //  регистрация
        //  registration    
        if ($route == 'user/register') {
            $url = 'registration';
        } else
        //  восстановление пароля
        //  password recovery    
        if ($route == 'user/lostpassword') {
            $url = 'lostpassword';
        } else
        if ($route == 'user/find') {
            $url = 'user/find';
        } else
        if ($route == 'user/authorize') {
            $url = 'user/authorize';
        } else
        if ($route == 'user/sendpassoword') {
            $url = 'user/sendpassoword';
        } else
        //  список пользователей
        //  user list    
        if ($route == 'user/list') {
            /*if (!empty($params['sort'])) {
                $url = 'users/' . $params['sort'];
            }*/
            if (!empty($params['page'])) {
                $url = 'users/' . $params['page'];
            } else {
                $url = 'users';
            };
        } else
        //  просмотр, редактирование, удаление пользователя, сохранение, изменение роли, удаление своих заявок
        //  view, edit, delete user; save, update user role; modification and removal of own applications    
        if (isset($path[0]) && ($path[0] == 'user')) {
            $action = isset($path[1])?$path[1]:'';
            if (in_array($action, array('edit', 'save', 'role', 'delete', 'deleteParticipants'))) {
                $url = 'user/' . (isset($params['id'])?$params['id']:'') . '/' . $action;
            } else
            if (empty($action) || ($action == 'view')) {
                $url = 'user/' . (isset($params['id'])?$params['id']:'');
            }
        } else
        //**** Список конференций ****
        //**** Conferences list ****
        
        //  список новых конференций
        //  new conferences list    
        if ($route == 'confs/new') {
            $url = 'confs/new';
        } else
        //  список конференций за указанный год
        //  list of conferences in the specified year    
        if (($route == 'confs/confs') && !empty($params['year'])) {
            $url = 'confs/' . $params['year'];
        } else
        //  список конференций за текущий год
        //  list of conferences in the current year    
        if (($route == 'confs/confs')) {
            $url = 'confs';
        } else
        //  список конференций с открытой регистрацией
        //  list of conferenses with open registration    
        if (($route == 'confs/registration')) {
            $url = 'confs/registration';
        } else
        //**** Конференция ****
        //**** A conference ****
        
        //  создание конференции
        //  conference creation    
        if (($route == 'confCreate/create')) {
            $url = 'create';
        } else
        //  просмотр конференции
        //  conference viewing    
        if (isset($path[0]) && ($path[0] == 'conf')) {
            $action = isset($path[1])?$path[1]:'';
            $urn = isset($params['urn'])?$params['urn']:'';
            $controller = $this->controller('conf', $urn, 'Conf');
            //  просмотр по умолчанию
            //  view action by default
            if (empty($action) || ($action == 'view')) {
                $url = $controller;
            } else
            //  просмотр стандартных разделов конференции
            //  standard conference pages viewing    
            if (in_array($action, array('view', 'info', 'contacts', 'report', 'committee', 'program', 'proceedings', 'letter'))) {
                $url = $controller . '/' . $action;
            } else
            //  гостевая книга
            //  guestbook    
            if (in_array($action, array('guestbook', 'postGuestbook'))) {
                $url = $controller . '/' . $action;
            } else
            if ($action == 'deleteGuestbook') {
                $url = $controller . '/guestbook/' . (isset($params['guestbook_id'])?$params['guestbook_id']:'');
            } else {
                //  просмотр дополнительных разделов конференции
                //  additional conference pages viewing
                $conf_page_urn = $action;
                //$conf=Conf::model()->findByUrn($urn);
                $conf_id = Conf::model()->findIdByUrn($urn);
                $conf_page = ConfPage::model()->findByUrnConf($conf_id, $conf_page_urn);
                if ($conf_page) {
                    $url = $controller . '/' . $conf_page_urn;
                }
            }
        } else
        //  администрирование конференции
        //  conference administration    
        if (isset($path[0]) && ($path[0] == 'admin')) {
            $action = isset($path[1])?$path[1]:'';
            $urn = isset($params['urn'])?$params['urn']:'';
            $controller = $this->controller('conf', $urn, 'Conf');
            if (in_array($action, array('admins', 'delete', 'form', 'mailing', 'recipients', 'reviewing', 'settings', 'topics', 'pages'))) {
                $url = $controller . '/' . $action;
                if ($action == 'mailing') {
                    $participant_id = isset($params['participant_id'])?$params['participant_id']:'';
                    if (!empty($participant_id)) {
                        $url .= '/' . $participant_id; 
                    }
                }
            } else
            if ($action == 'fieldList') {
                $field = isset($params['field'])?$params['field']:'';
                $url = $controller . '/form/fieldList/' . $field;
            }
        } else
        //  редактирование конференции
        //  conference editing    
        if (isset($path[0]) && ($path[0] == 'confEdit')) {
            $action = isset($path[1])?$path[1]:'';
            $urn = isset($params['urn'])?$params['urn']:'';
            $controller = $this->controller('conf', $urn, 'Conf');
            //  редактирование стандартных разделов конференции
            //  standard conference pages editing 
            if (in_array($action, array('view', 'info', 'contacts', 'report', 'committee', 'program', 'proceedings'))) {
                $url = $controller . '/' . $action . '/edit';
            } else {
                //  additional conference pages editing 
                $conf_page_urn = $action;
                //$conf=Conf::model()->findByUrn($urn);
                $conf_id = Conf::model()->findIdByUrn($urn);
                $conf_page = ConfPage::model()->findByUrnConf($conf_id, $conf_page_urn);
                if ($conf_page) {
                    $url = $controller . '/' . $conf_page_urn . '/edit';
                }
            }
        } else
        //**** Организации ****
        //**** Organizations ****
        
        //  список организаций
        //  list of organizations    
        if ($route == 'org/list') {
            if (!empty($params['sort'])) {
                $url = 'orgs/' . $params['sort'];
            } else {
                $url = 'orgs';
            }
        } else
        if (isset($path[0]) && ($path[0] == 'org')) {
            $action = isset($path[1])?$path[1]:'';
            $urn = $params['urn'];
            $controller = $this->controller('org', $urn, 'Org');
            //  просмотр организации по умолчанию
            //  org viewing by default
            if (empty($action) || ($action == 'view')) {
                $url = $controller;
            } else
            //  просмотр/редактирование/удаление организации
            //  view, edit, delete organization    
            if (in_array($action, array('view', 'edit', 'save', 'delete'))) {
                $url = $controller . '/' . $action;
            }
        } else
        //**** Доклады ****
        //**** Applications ****
        
        //  список докладов по умолчанию
        //  list of applications by default    
        if ($route == 'participant/list') {
            $urn = $params['urn'];
            $controller = $this->controller('conf', $urn, 'Conf');
            $url = $controller . '/participants';
        } else
        //  список всех докладов
        //  list of all applications    
        if ($route == 'participant/all') {
            $urn = $params['urn'];
            $controller = $this->controller('conf', $urn, 'Conf');
            $url = $controller . '/participants/all';
        } else
        //  список докладов из секции
        //  list of applications in a topic    
        if ($route == 'participant/topicList') {
            $urn = $params['urn'];
            $topic_urn = $params['topic_urn'];
            $controller = $this->controller('conf', $urn, 'Conf');
            $url = $controller . '/participants/' . $topic_urn;
        } else
        //  удаление секции
        //  topic removal    
        if ($route == 'participant/deleteTopic') {
            $urn = $params['urn'];
            $topic_urn = $params['topic_urn'];
            $controller = $this->controller('conf', $urn, 'Conf');
            $url = $controller . '/participants/' . $topic_urn . '/delete';
        } else
        //  просмотр доклада
        //  application viewing    
        if ($route == 'participant/view') {
            $urn = $params['urn'];
            $controller = $this->controller('conf', $urn, 'Conf');
            $participant_urn = $params['participant_urn'];
            $url = $controller . '/participant/' . $participant_urn;
        } else
        //  редактирование доклада edit,save
        //  edit, save application    
        if (isset($path[0]) && ($path[0] == 'participant')) {
            $action = isset($path[1])?$path[1]:'';
            if (in_array($action, array('edit', 'save', 'enable'))) {
                $urn = isset($params['urn'])?$params['urn']:'';
                $controller = $this->controller('conf', $urn, 'Conf');
                $participant_urn = $params['participant_urn'];
                $url = $controller . '/participant/' . $participant_urn . '/' . $action;
            } else {
                //  подача заявки на участие в конференции
                //  submitting new application
                $urn = isset($params['urn'])?$params['urn']:'';
                $controller = $this->controller('conf', $urn, 'Conf');
                if (in_array($action, array('application', 'myApplication', 'submitReport', 'submitApplication'))) {
                    $url = $controller . '/' . $action;
                } else
                if ($action == 'create') {
                    $url = $controller . '/participant/' . $action;
                }
            }
        } else
        //**** Экспорт докладов****
        //**** Report export ****    
        if (isset($path[0]) && ($path[0] == 'export')) {
            $action = isset($path[1])?$path[1]:'';
            $urn = $params['urn'];
            $controller = $this->controller('conf', $urn, 'Conf');
            $url = $controller . '/export/' . $action;
            if (isset($params['topic_id'])) {
                $url.='?topic_id=' . $params['topic_id'];
            };
        }

        if ($url !== false) {
            //  добавляем языковой контекст
            //  injecting language context
            $language = Yii::app()->language;
            if ($language == Yii::app()->params['mainLanguage']) {
                $language = '';
            };
            if (!empty($language)) {
                if (empty($url)) {
                    $url = $language;
                } else {
                    $url = $language . '/' . $url;
                };
            };
        };

        return $url;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo) {
        //  используется при подключении GA
        //  used for Google Analytics injection
        $_GET['conf_id'] = NULL;

        $path = explode("/", $pathInfo);
      
        $language = isset($path[0])?$path[0]:'';
        if (in_array($language, array_keys(Yii::app()->params['languages']))) {
            array_shift($path);
        } else {
            $language = Yii::app()->params['mainLanguage'];
        }
        //  переключаем приложение на новый язык, если текущий язык другой
        //  switch the application to the new language
        if (Yii::app()->language != $language) {
            $_GET['language'] = $language;
        };

        //  captcha
        if (isset($path[1]) && ($path[1] == 'captcha')) {
            if (isset($path[2])) { $_GET[$path[2]] = isset($path[3])?$path[3]:'';};
            return $path[0] . '/captcha';
        }
        //  cron
        if (isset($path[0]) && ($path[0] == 'cron')) {
            $_GET['pwd'] = isset($path[1])?$path[1]:'';
            return 'cron/index';
        }
        //  по умолчанию
        //  default
        if (empty($path[0])) {
            return Yii::app()->homeUrl;
        }
        //  комментирование
        //  commenting
        if (isset($path[0]) && ($path[0] == 'comments')) {
            return 'comments/index';
        }
        //  изменение языка
        //  language setting
        if (isset($path[0]) && ($path[0] == 'language')) {
            $_GET['language'] = isset($path[1])?$path[1]:'';
            return 'site/language';
        }
        $action = isset($path[0])?$path[0]:'';
        //  вход на сайт
        //  login
        if (isset($path[0]) && ($path[0] == 'login')) {
            return 'site/login';
        };
        //  выход, страница о сайте, режим обслуживания
        //  logout, About page, maintenanance mode
        if (in_array($action, array('logout', 'maintenance'))) {
            return 'site/' . $action;
        }
        if ($action == 'about') {
            $edit = isset($path[1])?$path[1]:'';
            if ($edit == 'edit') {
                $_GET['edit'] = true;
            }
            return 'site/' . $action;
        }
        //**** Пользователи ****
        //**** Users ****
        
        //  регистрация
        //  registration
        if (isset($path[0]) && ($path[0] == 'registration')) {
            return 'user/register';
        };
        //  восстановление пароля
        //  password recovery
        if (isset($path[0]) && ($path[0] == 'lostpassword')) {
            return 'user/lostpassword';
        };
        //  список пользователей
        //  list of users
        if (isset($path[0]) && ($path[0] == 'users')) {
            /*$sort = isset($path[1])?$path[1]:'';
            if (!empty($sort)) {
                $_GET['sort'] = $sort;
            }*/
            $page = isset($path[1])?$path[1]:'';
            if (!empty($page)) {
                $_GET['page'] = $page;
            }
            return 'user/list';
        };
        //  поиск пользователя
        //  user search
        if (isset($path[0]) && isset($path[1]) && (($path[0] . '/' . $path[1]) == 'user/find')) {
            $email = $request->getParam('email');
            $_GET['email'] = $email;
            return 'user/find';
        };
        //  проверка пользователя
        //  user authorization
        if (isset($path[0]) && isset($path[1]) && (($path[0] . '/' . $path[1]) == 'user/authorize')) {
            $email = $request->getParam('email');
            $_GET['email'] = $email;
            return 'user/authorize';
        };
        //  высылаем новый пароль
        //  sending new password
        if (isset($path[0]) && isset($path[1]) && (($path[0] . '/' . $path[1]) == 'user/sendpassword')) {
            $email = $request->getParam('email');
            $_GET['email'] = $email;
            return 'user/sendpassword';
        };
        //  просмотр, редактирование пользователя, сохранение, изменение роли
        //  view, edit user; save or modify user role, delete application
        if (isset($path[0]) && ($path[0] == 'user')) {
            $_GET['id'] = isset($path[1])?$path[1]:'';
            $action = isset($path[2])?$path[2]:'';
            if (in_array($action, array('edit', 'save', 'delete', 'role', 'deleteParticipants'))) {
                return 'user/' . $action;
            }
            if (empty($action) || $action == 'view') {
                return 'user/view';
            }
        }
        //**** Список конференций ****
        //**** List of conferences ****
        
        //  список новых конференций
        //  list of the new conferences
        if (isset($path[0]) && isset($path[1]) && (($path[0] . '/' . $path[1]) == 'confs/new')) {
            return 'confs/new';
        };
        //  список конференций за текущий год
        //  list of conferences in the current year
        if ((isset($path[0]) && ($path[0] == 'confs'))) {
            if (isset($path[1])) {
                //  список конференций за указанный год
                //  list of conferences in the specified year
                $_GET['year'] = $path[1];
            };
            return 'confs/confs';
        }
        //  список конференций с открытой регистрацией
        //  list of conferences with open registration
        if (isset($path[0]) && isset($path[1]) && (($path[0] . '/' . $path[1]) == 'confs/registration')) {
            return 'confs/registration';
        }
        //**** Конференция ****
        //**** A conference ****
        
        //  создание конференции
        //  conference creation
        if (isset($path[0])&& ($path[0] == 'create')) {
            return 'confCreate/create';
        }
        //  просмотр/редактирование/администрирование конференции
        //  viewing/editing/administering of the confernece
        if (isset($path[0]) && ($path[0] == 'conf')) {
            array_shift($path);
        }
        $urn = isset($path[0])?$path[0]:'';
        //$conf=Conf::model()->findByUrn($urn);
        $conf_id = Conf::model()->findIdByUrn($urn);
        if ($conf_id != NULL) {
            $_GET['id'] = $conf_id;
            $_GET['conf_id'] = $conf_id;
            $controller = 'conf';
            $action = isset($path[1])?$path[1]:'';
            $edit = isset($path[2])?$path[2]:'';
            if ($edit == 'edit') {
                $controller = 'confEdit';
            }
            //  просмотр по умолчанию
            //  view action by default
            if (empty($action)) {
                return 'conf/view';
            }
            //  просмотр/редактирование стандартных разделов конференции, кроме отчета о конференции
            //  view/edit standard conference pages
            if (in_array($action, array('view', 'info', 'contacts', 'committee', 'program', 'proceedings', 'letter'))) {
                return $controller . '/' . $action;
            }
            //  гостевая книга
            //  guestbook
            if (in_array($action, array('guestbook', 'postGuestbook'))) {
                $guestbook_id = isset($path[2])?$path[2]:'';
                if (!empty($guestbook_id)) {
                    $_GET['guestbook_id'] = $guestbook_id;
                    return $controller . '/deleteGuestbook';
                }
                return $controller . '/' . $action;
            }
            //  просмотр/редактирование дополнительных разделов конференции
            //  view/edit additional conference pages
            $conf_page_urn = $action;
            $conf_page = ConfPage::model()->findByUrnConf($conf_id, $conf_page_urn);
            if ($conf_page) {
                $_GET['conf_page_id'] = $conf_page->id;
                return $controller . '/page';
            }
            //  просмотр списка докладов
            //  view list of applications
            if ($action == 'participants') {
                if (array_key_exists(2, $path)) {
                    if ($path[2] == 'all') {
                        //  список всех докладов
                        //  view list of all applications
                        return 'participant/all';
                    }
                    $topic_urn = $path[2];
                    $_GET['topic_id'] = $topic_urn;
                    if (isset($path[3]) && ($path[3] == 'delete')) {
                        //  удаляем секцию
                        //  topic removal
                        return 'participant/deleteTopic';
                    }
                    //  список докладов из секции
                    //  list of applications in the topic
                    return 'participant/topicList';
                }
                return 'participant/list';
            }
            //  просмотр/редактирование отчета о конференции
            //  view/edit conference report
            if ($action == 'report') {
                if (empty($edit) || ($edit == 'edit')) {
                    return $controller . '/' . $action;
                }
            }
            if ($action == 'participant') {
                //  подача заявки на участие в конференции,
                //  уведомление о успешнй отсылке
                //  new application submitting
                $subAction = isset($path[2])?$path[2]:'';
                if (in_array($subAction, array('create'))) {
                    return 'participant/' . $subAction;
                }
                //  просмотр и редактирование доклада
                //  view/edit application
                $participant_urn = isset($path[2])?$path[2]:'';
                $_GET['participant_id'] = $participant_urn;
                $subAction = isset($path[3])?$path[3]:'';
                if (!empty($subAction)) {
                    return 'participant/' . $subAction;
                }
                return 'participant/view';
            }
            //  подача заявки на участие в конференции
            //  submitting new application for teh conference
            if (in_array($action, array('application', 'myApplication', 'submitReport', 'submitApplication'))) {
                return 'participant/' . $action;
            }
            //  экспорт
            //  export
            if ($action == 'export') {
                $controller = 'export';
                $action = isset($path[2])?$path[2]:'';
                return $controller . '/' . $action;
            }
            //  администрирование конференции
            //  administering of the conferenece
            if (in_array($action, array('admins', 'recipients', 'delete', 'reviewing', 'settings', 'topics', 'pages'))) {
                return 'admin' . '/' . $action;
            }
            if ($action == 'mailing') {
                 $participant_id = isset($path[2])?$path[2]:'';
                 if (!empty($participant_id)) {
                    $_GET['participant_id'] = $participant_id;
                 };
                 return 'admin' . '/' . $action;
            }
            if ($action == 'form') {
                $subAction = isset($path[2])?$path[2]:'';
                if ($subAction == 'fieldList') {
                    $field = isset($path[3])?$path[3]:'';
                    $_GET['field'] = $field;
                    return 'admin/fieldList';
                } else {
                    return 'admin' . '/' . $action;
                }
            }
        }
        //**** Организации ****
        //**** Organizations ****
        
        //  список организаций
        //  list of organizations
        if (isset($path[0]) && ($path[0] == 'orgs')) {
            $sort = isset($path[1])?$path[1]:'';
            if (!empty($sort)) {
                $_GET['sort'] = $sort;
            }
            return 'org/list';
        };
        if (isset($path[0]) && ($path[0] == 'org')) {
            array_shift($path);
        }
        $urn = isset($path[0])?$path[0]:'';
        $org = Org::model()->findByUrn($urn);
        if ($org != NULL) {
            $_GET['id'] = $org->id;
            $controller = 'org';
            $action = isset($path[1])?$path[1]:'';
            //  просмотр по умолчанию
            //  viewing by dafault
            if (empty($action)) {
                return 'org/view';
            }
            //  просмотр/редактирование организации
            //  view/edit organization
            if (in_array($action, array('view', 'edit', 'save', 'delete'))) {
                return $controller . '/' . $action;
            }
        }
        return false;
    }

}

?>
