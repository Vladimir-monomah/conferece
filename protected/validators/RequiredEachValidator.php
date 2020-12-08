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
class RequiredEachValidator extends CValidator {

    public $languages = NULL;

    protected function validateAttribute($object, $attribute) {
        $allNotEmpty = true;
        $values = $object->$attribute;
        $count_languages = 0; 
        if ($this->languages == NULL) {
            foreach ($values as $key => $value) {
                $allNotEmpty = ($allNotEmpty && !$this->isEmpty($value, true));
            }
        } else {
            $count_languages = count($this->languages);
            foreach ($this->languages as $language => $name) {
                $value = $values[$language];
                $allNotEmpty = ($allNotEmpty && !$this->isEmpty($value, true));
            }
        }
        $labels = $object->attributeLabels();
        $label = $labels[$attribute];
        if (!$allNotEmpty) {
            if ($count_languages > 1) {
                $this->addError($object, $attribute, Yii::t('validators', 'Each field in field group {label} is required.', array('{label}' => $label)));
            } else {
                $this->addError($object, $attribute, Yii::t('validators',  '{label} cannot be blank.' , array('{label}' => $label))); 
            }
        }
    }

}

?>
