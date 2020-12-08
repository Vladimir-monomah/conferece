<?php

/**
 *  Режим публикации списка участников.
 * 
 *  An option of publication of list of participants.
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class ParticipantPublishingOption {

    //  показывать список (значение по умолчанию)
    //  show list without full texts (default value)
    const SHORT_LIST = 0;      
    //  показывать список вместе с докладами
    //  show list with full texts
    const FULL_LIST = 1;   
    //  показывать статистику (кол-во)
    //  show statistics (amount)
    const AMOUNT = 2;          
    //  не показывать никогда
    //  do not show
    const HIDDEN = 3;          

    public static function getOptionList() {
        return array(
            ParticipantPublishingOption::SHORT_LIST => Yii::t('participants', 'Show list without full texts'),
            ParticipantPublishingOption::FULL_LIST => Yii::t('participants', 'Show list with full texts'),
            ParticipantPublishingOption::AMOUNT => Yii::t('participants', 'Show amount only'),
            ParticipantPublishingOption::HIDDEN => Yii::t('participants', 'Do not show')
        );
    }

}
