<?php

/**
 *  Валидатор для проверки honeypot поля (антиспам).
 * 
 *  The class validates honeypot property. 
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class HoneypotValidator extends CValidator {

    protected function validateAttribute($object, $attribute) {
        $value = $object->$attribute;
        $labels = $object->attributeLabels();
        $label = $labels[$attribute];
        if (!empty($value)) {
            $this->addError($object, $attribute, Yii::t('validators', 'There was a problem with your form submission. Please refresh the page and try again.'));
        }
    }

}

