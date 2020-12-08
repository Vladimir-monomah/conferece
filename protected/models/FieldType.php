<?php

/**
 *  Типы дополнительных полей в классах Author и Participant.
 * 
 *  Types of additional fields in Author and Participant classes.
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class FieldType {

    //  строковое поле
    //  string field
    const STRING = 0; 
    //  текстовое поле
    //  text field
    const TEXT = 1;   
    //  флажок
    //  checkbox
    const CHECKBOX = 2; 
    //  выбор из списка
    //  list field
    const SELECT = 3;
    //  файл
    //  file field
    const FILE = 4; 

    public static function name($fieldType) {
        if ($fieldType == FieldType::STRING) {
            return Yii::t('admin', 'string field');
        };
        if ($fieldType == FieldType::TEXT) {
            return Yii::t('admin', 'multi-line text field');
        };
        if ($fieldType == FieldType::CHECKBOX) {
            return Yii::t('admin', 'checkbox field');
        };
        if ($fieldType == FieldType::SELECT) {
            return Yii::t('admin', 'select field');
        };
        if ($fieldType == FieldType::FILE) {
            return Yii::t('admin', 'file field');
        }
    }

}

?>
