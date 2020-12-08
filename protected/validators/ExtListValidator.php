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
class ExtListValidator extends CValidator {

    public $exts = NULL;

    protected function validateAttribute($object, $attribute) {
        if ($this->exts != NULL) {
            $value = $object->$attribute;
            $value_arr = explode(",", $value);
            $labels = $object->attributeLabels();
            $label = $labels[$attribute];
            foreach ($value_arr as $ext) {
                $_ext = trim($ext);
                if (!empty($_ext) && !in_array($_ext, $this->exts)) {
                    $this->addError($object, $attribute, Yii::t('validators', 'Unsupported file extension {ext} in {label} specified.', array('{label}' => $label, '{ext}' => $_ext)));
                    return false;
                }
            }
        }
    }

}

?>
