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
class LengthEachValidator extends CValidator {

    public $min = 0;
    public $max = 0;

    protected function validateAttribute($object, $attribute) {
        $values = $object->$attribute;
        $minError = false;
        $maxError = false;
        if (!empty($values)) {
            foreach ($values as $key => $value) {
                if (function_exists('mb_strlen'))
                    $length = mb_strlen($value, Yii::app()->charset);
                else
                    $length = strlen($value);
                $labels = $object->attributeLabels();
                $label = isset($labels[$attribute])?$labels[$attribute]:'';
                if ($this->min > 0 && $length < $this->min && !$minError) {
                    $minError = true;
                    $this->addError($object, $attribute, Yii::t('validators', '{label} field must contain at least {min} characters.', array('{label}' => $label, '{min}' => $this->min)));
                }
                if ($this->max > 0 && $length > $this->max && !$maxError) {
                    $maxError = true;
                    $this->addError($object, $attribute, Yii::t('validators', '{label} field should contain no more than {max} symbols.', array('{label}' => $label, '{max}' => $this->max)));
                }
            }
        };
    }

}

?>
