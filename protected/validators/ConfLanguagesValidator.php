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
class ConfLanguagesValidator extends CValidator {

    protected function validateAttribute($object, $attribute) {
        $values = $object->$attribute;
        $labels = $object->attributeLabels();
        $label = $labels[$attribute];
        $error = false;
        $count = 0;
        if (is_array($values)) {
            foreach ($values as $value) {
                if (!in_array($value, array_keys(Yii::app()->params['languages']))) {
                    $error = true;
                } else {
                    $count++;
                }
            }
        }
        if ($count == 0) {
            $error = true;
        }
        if ($error) {
            $this->addError($object, $attribute, Yii::t('validators', 'At least one {label} must be selected.', array('{label}' => $label)));
        }
    }
    
}

?>
