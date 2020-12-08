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
class ConfListView extends ActiveRecord {

    public $id;
    public $is_enabled = 0;
    public $urn;
    public $start_date;
    public $end_date;
    //  многоязычные поля
    //  multilingual fields
    public $title;
    public $subject;
    //  вспомогательное поле
    //  auxiliary field
    public $is_registration_open = false;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{conf}}';
    }

    public function behaviors() {
        return array(
            'MultilingualBehavior' => array(
                'class' => 'application.behaviors.MultilingualBehavior',
                'table' => 'multilingual_conf',
                'table_fk' => 'conf_id',
                'language_column' => 'language',
                'columns' => array('title', 'subject'),
                'languages' => Yii::app()->params['languages'],
        ));
    }

    public function title($language = NULL) {
        return $this->value('title', $language);
    }

    public function subject($language = NULL) {
        return $this->value('subject', $language);
    }

    public function urn() {
        return $this->urn ? $this->urn : $this->id;
    }

    public function findCurrentConfs() {
        $criteria = new CDbCriteria;
        $criteria->condition = '(end_date >= :end_date) and (is_enabled=1)';
        $criteria->params = array(':end_date' => DateUtils::today());
        $criteria->order = 'start_date asc';
        $confs = $this->findAll($criteria);
        $openConfs = $this->findAllWithOpenRegistration();
        foreach ($confs as &$conf) {
            foreach ($openConfs as $openConf) {
                if ($conf->id == $openConf->id) {
                    $conf->is_registration_open = true;
                };
            };
        };
        return $confs;
    }

    public function findRecentConfs() {
        $criteria = new CDbCriteria;
        $criteria->condition = '(end_date <= :end_date) and (is_enabled=1)';
        $criteria->params = array(':end_date' => DateUtils::today());
        $criteria->order = 'start_date desc';
        $criteria->limit = 5;
        $confs = $this->findAll($criteria);
        return $confs;
    }

    public function findYearConfs($year) {
        if (is_null($year)) {
            $year = date('Y', time());
        }
        $criteria = new CDbCriteria;
        $year_start_date = mktime(0, 0, 0, 1, 1, $year);
        $year_end_date = mktime(0, 0, 0, 1, 1, $year + 1);
        $criteria->condition = '(start_date >= :year_start_date) and (start_date < :year_end_date) and (is_enabled=1)';
        $criteria->params = array(':year_start_date' => $year_start_date, ':year_end_date' => $year_end_date);
        $criteria->order = 'start_date desc';
        $confs = $this->findAll($criteria);
        return $confs;
    }

    public function findNewConfs() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'is_enabled=0';
        $criteria->order = 'start_date desc';
        $confs = $this->findAll($criteria);
        return $confs;
    }

    public function findAllWithOpenRegistration() {
        $criteria = new CDbCriteria;
        $criteria->condition = ' is_enabled=1 and is_registration_enabled=1';
        $criteria->condition.=' and DATE(NOW()) <= DATE(FROM_UNIXTIME(if(registration_end_date, registration_end_date, start_date-60*60*24)))';
        $criteria->order = 'start_date desc';
        return $this->findAll($criteria);
    }

}

?>
