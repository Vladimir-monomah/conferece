<?php

/**
 *  Валидатор для проверки подадресов конференции.
 * 
 *  Validator to examine sub urn for the conference.
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class ConfUrnValidator extends CValidator {

    public $conf_id = NULL;

    protected function validateAttribute($object, $attribute) {
        $value = $object->$attribute;
        $labels = $object->attributeLabels();
        $label = $labels[$attribute];
        if (!UrnRule::isUrn($value) && !empty($value)) {
            $this->addError($object, $attribute, Yii::t('validators', 'Field {label} must contain letters, digits, `-` and `_` characters.', array('{label}' => $label)));
        }
        if (ConfMenu::exists($this->conf_id, $value)) {
            $this->addError($object, $attribute, Yii::t('validators', 'This website address is already being used. Please choose another one.', array('{label}' => $label)));
        }
    }

}

?>
