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
class ConfsController extends BaseController {

    protected function setActiveMenuItem(CAction $action) {
        $activeUrn = $action->id;
        if (in_array($activeUrn, array('confs', 'current'))) {
            //  all conferences
            $this->userMenu[0]['active'] = true;
        }
        if (in_array($activeUrn, array('new'))) {
            //  new conferences
            $this->userMenu[4]['active'] = true;
        }
    }

    public function actionIndex() {
        $current_confs = ConfListView::model()->findCurrentConfs();
        $recent_confs = ConfListView::model()->findRecentConfs();
        $this->render('index', array('current_confs' => $current_confs, 'recent_confs' => $recent_confs));
    }

    public function actionConfs($year = NULL) {
        if ($year == NULL) {
            $year = (int) date('Y', time());
        }
        $start_year = Conf::model()->startYear();
        $end_year = (int) date('Y', time());
        $confs = array();
        if ('current' === $year) {
            $confs = ConfListView::model()->findCurrentConfs();
        }
        if ('current' !== $year) {
            $confs = ConfListView::model()->findYearConfs($year);
        };
        $this->render('confs', array('start_year' => $start_year,
            'end_year' => $end_year, 'year' => $year,
            'confs' => $confs));
    }

    public function actionCurrent() {
        return $this->actionConfs('current');
    }

    public function actionNew() {
        $confs = ConfListView::model()->findNewConfs();
        $this->render('new', array('confs' => $confs));
    }

    public function actionRegistration() {
        $confs = ConfListView::model()->findAllWithOpenRegistration();
        $this->render('registration', array('confs' => $confs));
    }

    public function filters() {
        return array_merge(
                parent::filters(), 
                array('accessControl',)
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('confs', 'index', 'current', 'registration'),
                'expression' => 'Yii::app()->user->checkAccess("listConfs")'
            ),
            array('allow',
                'actions' => array('new'),
                'expression' => 'Yii::app()->user->checkAccess("admin")'
            ),
            array('deny',
                'users' => array('*')   //  any user
            )
        );
    }

}

?>
