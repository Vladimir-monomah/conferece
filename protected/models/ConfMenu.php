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
class ConfMenu {

    protected static $conf_urns = array('view', 'info', 'letter', 'committee', 'program', 'contacts', 'report',
        'participant', 'participants', 'application', 'myapplication', 'submitReport', 'submitApplication',
        'guestbook', 'postGuestbook', 'deleteGuestbook', 'export', 'settings', 'sections', 'admins', 'pages',
        'form', 'topics', 'mailing', 'recipients', 'delete', 'registration');

    public static function exists($conf_id, $urn) {
        if (in_array($urn, ConfMenu::$conf_urns)) {
            return true;
        };
        return false;
    }

    public static function validateUniqueUrns($conf_pages) {
        $valid = true;
        $urns = array();
        foreach ($conf_pages as $conf_page) {
            $urn = $conf_page->urn;
            if (in_array($urn, $urns)) {
                $labels = $conf_page->attributeLabels();
                $label = $labels['urn'];
                $valid = false;
                $conf_page->addError('urn', Yii::t('validators', 'This website address is already being used. Please choose another one.', array('{label}' => $label))
                );
            }
            $urns[] = $urn;
        }
        return $valid;
    }

    /**
     *  Раздел всегда видим администратору конференции.
     *  Некоторые разделы показываются пользователю только если они непустые. 
     * 
     *  Any conference page is visible to a conference administrator,
     *  Some pages are visible to a simple user if they are not empty only.  
     */
    public static function isVisibleMenuItem($confView, $menu_urn, $conf_page = NULL) {
        $params = array('conf_id' => $confView->id, 'user_id' => Yii::app()->user->id);
        if (Yii::app()->user->checkAccess('modifyConf', $params)) {
            return true;
        };
        //  оргкомитет
        //  organizing committe
        if ($menu_urn == 'committee') {
            $content = $confView->committee();
            return !empty($content);
        };
        //  программа конференции
        //  conference program
        if ($menu_urn == 'program') {
            $content = $confView->program();
            return !empty($content);
        };
        //  труды конференции
        //  conference proceedings    
        $hasProceedings = $confView->hasProceedings();
        if ($menu_urn == 'proceedings') {
            return $hasProceedings;
        };
        //  участники
        //  participants
        if ($menu_urn == 'participants') {
            $count = 0;
            if (Yii::app()->user->checkAccess("viewAllParticipants", array('conf_id' => $confView->id, 'user_id' => Yii::app()->user->id))) {
                $count = $confView->countParticipants();
            } else if (Yii::app()->user->checkAccess("viewPublishedParticipants", array('conf_id' => $confView->id, 'user_id' => Yii::app()->user->id))) {
                if (($confView->participant_publishing_option != ParticipantPublishingOption::HIDDEN) && !$hasProceedings) {
                    $count = $confView->countApprovedParticipants();
                };
            };
            return ($count > 0);
        };
        //  моя заявка на участие
        //  my application page
        if ($menu_urn == 'myapplication') {
            return Yii::app()->user->checkAccess("viewMyApplicationPage", array('conf_id' => $confView->id, 'user_id' => Yii::app()->user->id));
        };
        //  отчет о конференции
        //  conference report
        if ($menu_urn == 'report') {
            $content = $confView->report();
            return !empty($content);
        };
        //  страница "Контакты"
        //  "Contacts" page
        if ($menu_urn == 'contacts') {
            $content = $confView->address() . $confView->phone . $confView->fax . $confView->email . $confView->contacts();
            return !empty($content);
        };
        //  секция конференции
        //  conference topic
        if ($menu_urn == 'page') {
            $content = $conf_page->content();
            return !empty($content);
        }
        //  остальные страницы видны
        //  other pages are visible
        return true;
    }

    public static function defaultMenuItems($confView, $showEmpty = true) {
        $menuItems = array();
        //  страница "Общая информация"
        //  "General information" page
        $menuItems[] = array('urn' => 'info', 'title' => Yii::t('confs', 'General Information'));

        //  страница "Оргкомитет"
        //  "Organizing committee" page
        $content = $confView->committee();
        if ($showEmpty || !empty($content)) {
            $menuItems[] = array('urn' => 'committee', 'title' => Yii::t('confs', 'Organizing Committee'));
        };
        //  страница "Программа конференции"
        //  "Conference program" page
        $content = $confView->program();
        if ($showEmpty || !empty($content)) {
            $menuItems[] = array('urn' => 'program', 'title' => Yii::t('confs', 'Conference Program'));
        }

        $hasProceedings = $confView->hasProceedings();
        //  страница "Участники"
        //  "Participants" page
        $count = 0;
        if (Yii::app()->user->checkAccess("viewAllParticipants", array('conf_id' => $confView->id, 'user_id' => Yii::app()->user->id))) {
            $count = $confView->countParticipants();
        } else if (Yii::app()->user->checkAccess("viewPublishedParticipants", array('conf_id' => $confView->id, 'user_id' => Yii::app()->user->id))) {
            if (($confView->participant_publishing_option != ParticipantPublishingOption::HIDDEN) && !$hasProceedings) {
                $count = $confView->countApprovedParticipants();
            };
        }
        if ($showEmpty || ($count > 0)) {
            $menuItems[] = array('urn' => 'participants', 'title' => Yii::t('participants', 'Participants'));
        }
        //  страница "Заявка на участие"
        //  "Application" page
        if (Yii::app()->user->checkAccess("viewApplicationPageLink", array('conf_id' => $confView->id, 'user_id' => Yii::app()->user->id))) {
            $menuItems[] = array('urn' => 'application', 'title' => Yii::t('confs', 'Registration'));
        }
        //  страница "Моя заявка"
        //  "My application" page
        if (Yii::app()->user->checkAccess("viewMyApplicationPage", array('conf_id' => $confView->id, 'user_id' => Yii::app()->user->id))) {
            $count = ParticipantView::model()->countByAttributes(array('user_id' => Yii::app()->user->id, 'conf_id' => $confView->id));
            $title = Yii::t('confs', 'My application');
            if ($count > 1) {
                $title = Yii::t('confs', 'My applications');
            }
            $menuItems[] = array('urn' => 'myApplication', 'title' => $title);
        }
        //  страница "Труды конференции"
        //  "Conference proceedings" page
        if ($showEmpty || $hasProceedings) {
            $menuItems[] = array('urn' => 'proceedings', 'title' => Yii::t('confs', 'Conference Proceedings'));
        }
        //  страница "Отчет о конференции"
        //  "Conference report" page
        $content = $confView->report();
        if ($showEmpty || !empty($content)) {
            $menuItems[] = array('urn' => 'report', 'title' => Yii::t('confs', 'Conference Report'));
        }
        //  страница "Контакты"
        //  "Contacts" page
        $content = $confView->address() . $confView->phone . $confView->fax . $confView->email . $confView->contacts();
        if ($showEmpty || !empty($content)) {
            $menuItems[] = array('urn' => 'contacts', 'title' => Yii::t('confs', 'Contacts'));
        }
        return $menuItems;
    }

    public static function allMenuItems($confView, $editMode = false, $showEmpty = true) {
        $menu_items = ConfMenu::defaultMenuItems($confView, $showEmpty);
        $conf_pages = ConfPage::model()->findByConf($confView);
        foreach ($conf_pages as &$conf_page) {
            $items = array();
            $included = false;
            foreach ($menu_items as $item) {
                if ($conf_page->next_urn == $item['urn']) {
                    $content = $conf_page->content();
                    if ($showEmpty || !empty($content)) {
                        $included = true;
                        array_push($items, array('urn' => $conf_page->urn, 'title' => $conf_page->title()));
                    }
                }
                array_push($items, $item);
            }
            //  случай, когда последний в списке
            //  a case, when it is the last in the list
            if (!$included) {
                $content = $conf_page->content();
                if ($showEmpty || !empty($content)) {
                    array_push($items, array('urn' => $conf_page->urn, 'title' => $conf_page->title()));
                }
            }
            $menu_items = $items;
        }
        if (!$editMode && $confView->is_guestbook_enabled) {
            $menu_items[] = array('urn' => 'guestbook', 'title' => Yii::t('confs', 'Guestbook'));
        }
        return $menu_items;
    }

}
