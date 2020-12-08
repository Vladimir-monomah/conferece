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
class RequiredOneValidator extends CValidator {

    protected $oneErrorMsg = 'At least one field in field group {label} is required.';
    protected $currentErrorMsg = '{label} cannot be blank.';
    
    public $requiredLang = NULL;

    protected function validateAttribute($object, $attribute) {
        $allEmpty = true;
        $values = $object->$attribute;
        if ($values) {
            if (!empty($this->requiredLang)) {
                $value = $values[$this->requiredLang];
                $allEmpty = $this->isEmpty($value, true);
            } else {
                foreach ($values as $key => $value) {
                    $allEmpty = ($allEmpty && $this->isEmpty($value, true));
                }
            }
        }
        $labels = $object->attributeLabels();
        $label = $labels[$attribute];
        if ($allEmpty) {
            $this->addError($object, $attribute, Yii::t('validators', (empty($this->requiredLang) ? $this->oneErrorMsg : $this->currentErrorMsg), array('{label}' => $label)));
        }
    }

}

?>
