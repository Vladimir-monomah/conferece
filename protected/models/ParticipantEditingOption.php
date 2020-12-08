<?php

/**
 *  Опция когда разрешать редактировать участникам свои заявки.
 * 
 *  An option when a participant can edit its application form.
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class ParticipantEditingOption {

    //  до принятия/отклонения доклада или до окончания даты принятия докладов
    //  till acceptance/discarding of application or till end of submission date
    const ANY = 0;     
    //  до окончания даты принятия докладов
    //  till end of submission date
    const DATE = 1;     
    //  до принятия/отклонения доклада
    //  till acceptance/discarding of the application
    const APPROVED = 2; 
    //  всегда
    //  always
    const ALWAYS = 4;   

    public static function getOptionList() {
        return array(
            ParticipantEditingOption::DATE => Yii::t('participants', 'till the submission end date has passed'),
            ParticipantEditingOption::ANY => Yii::t('participants', 'till application is approved/discarded or the submission end date has passed'),
            ParticipantEditingOption::APPROVED => Yii::t('participants', 'till application is approved/discarded'),
            ParticipantEditingOption::ALWAYS => Yii::t('participants', 'always')
        );
    }

}

?>
