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
class ParticipationType {

    //  участие с докладом
    //  participantion with report
    //  секционный доклад
    const REPORT = 1;
    //  стендовый доклад
    const WORKSHOP_REPORT = 2;
    //  пленарный доклад
    const PLENARY_REPORT = 3;
    //  публикация (заочное участие)
    const PUBLICATION = 5;
    //  заочное участие
    const PART_TIME = 10;
    //  дистанционное онлайн-участие
    const ONLINE_PART = 13;
    
    const PRESENTATION_AND_PAPER = 14;   

    //  участие без доклада
    //  participation without report
    //  слушатель (без доклада)
    const AUDIENCE = 4;
    //  участие в работе круглого стола
    const TABLE_DISCUSSION = 6;
    //  участие в дискусии
    const DISCUSSION = 7;
    //  участие в мастер-классе
    const MASTER_CLASS = 8;
    //  участие в семинаре
    const WORKSHOP = 9;
    // модератор
    const MODERATOR = 11;
    // секционный доклад
    const SECTIONAL_REPORT = 12;
    
    //  тип участия
    //  type of participation
    //  любой
    const TYPE_ANY = 0;
    //  с докладом
    const TYPE_PAPER = 1;
    //  без доклада
    const TYPE_WO_PAPER = 2;

    public static function participation_types($type = ParticipationType::TYPE_ANY) {
        $arr = array();
        if ($type == ParticipationType::TYPE_PAPER) {
            $arr[ParticipationType::REPORT] = Yii::t('participants', 'Report');
            $arr[ParticipationType::SECTIONAL_REPORT] = Yii::t('participants', 'Sectional Report');
            $arr[ParticipationType::WORKSHOP_REPORT] = Yii::t('participants', 'Workshop Report');
            $arr[ParticipationType::PLENARY_REPORT] = Yii::t('participants', 'Plenary Report');
            $arr[ParticipationType::PUBLICATION] = Yii::t('participants', 'Publication');
            $arr[ParticipationType::PART_TIME] = Yii::t('participants', 'Part-time participation');
            $arr[ParticipationType::ONLINE_PART] = Yii::t('participants', 'Online participation');
            $arr[ParticipationType::PRESENTATION_AND_PAPER] = Yii::t('participants', 'Presentation and Paper');
        } else if ($type == ParticipationType::TYPE_WO_PAPER) {
            $arr[ParticipationType::AUDIENCE] = Yii::t('participants', 'Audience (w/o Report)');
            $arr[ParticipationType::TABLE_DISCUSSION] = Yii::t('participants', 'Participation in Round-Table Discussion');
            $arr[ParticipationType::DISCUSSION] = Yii::t('participants', 'Participation in Discussion');
            $arr[ParticipationType::MASTER_CLASS] = Yii::t('participants', 'Participation in Master Class');
            $arr[ParticipationType::WORKSHOP] = Yii::t('participants', 'Participation in Workshop');
            $arr[ParticipationType::MODERATOR] = Yii::t('participants', 'Moderator');
        } else {
            $arr[ParticipationType::REPORT] = Yii::t('participants', 'Report');
            $arr[ParticipationType::WORKSHOP_REPORT] = Yii::t('participants', 'Workshop Report');
            $arr[ParticipationType::PLENARY_REPORT] = Yii::t('participants', 'Plenary Report');
            $arr[ParticipationType::SECTIONAL_REPORT] = Yii::t('participants', 'Sectional Report');
            $arr[ParticipationType::AUDIENCE] = Yii::t('participants', 'Audience (w/o Report)');
            $arr[ParticipationType::PUBLICATION] = Yii::t('participants', 'Publication');
            $arr[ParticipationType::TABLE_DISCUSSION] = Yii::t('participants', 'Participation in Round-Table Discussion');
            $arr[ParticipationType::DISCUSSION] = Yii::t('participants', 'Participation in Discussion');
            $arr[ParticipationType::MASTER_CLASS] = Yii::t('participants', 'Participation in Master Class');
            $arr[ParticipationType::WORKSHOP] = Yii::t('participants', 'Participation in Workshop');
            $arr[ParticipationType::MODERATOR] = Yii::t('participants', 'Moderator');
            $arr[ParticipationType::PART_TIME] = Yii::t('participants', 'Part-time participation');
            $arr[ParticipationType::ONLINE_PART] = Yii::t('participants', 'Online participation');
            $arr[ParticipationType::PRESENTATION_AND_PAPER] = Yii::t('participants', 'Presentation and Paper');
        }
        return $arr;
    }
    
    public static function participation_types_ids($type = ParticipationType::TYPE_ANY) {
        $arr = ParticipationType::participation_types($type);
        return array_keys($arr);
    }
   

    public static function isOfType($participation, $type = ParticipationType::TYPE_ANY) {
        if (in_array($participation, array(ParticipationType::REPORT,
                    ParticipationType::WORKSHOP_REPORT,
                    ParticipationType::PLENARY_REPORT,
                    ParticipationType::PUBLICATION,
                    ParticipationType::PART_TIME,
                    ParticipationType::ONLINE_PART,
                    ParticipationType::SECTIONAL_REPORT,
                    ParticipationType::PRESENTATION_AND_PAPER)
                ) && $type == ParticipationType::TYPE_PAPER) {
            return true;
        }
        if (in_array($participation, array(ParticipationType::AUDIENCE,
                    ParticipationType::TABLE_DISCUSSION,
                    ParticipationType::DISCUSSION,
                    ParticipationType::MASTER_CLASS,
                    ParticipationType::WORKSHOP,
                    ParticipationType::MODERATOR)
                ) && $type == ParticipationType::TYPE_WO_PAPER) {
            return true;
        }
        if ($type == ParticipationType::TYPE_ANY) {
            return true;
        }
        return false;
    }

}

?>
