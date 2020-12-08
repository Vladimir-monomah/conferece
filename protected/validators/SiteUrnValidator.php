<?php

/**
 *  Валидатор для проверки адресов объектов (конференций и организаций) в пределах сайта.
 *  
 *  The class validates urns of objects (conferences or organizations) on the website. 
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class SiteUrnValidator extends CValidator {

    public $oldurn=NULL;

    protected function validateAttribute($object,$attribute) {
        $value=$object->$attribute;
        $labels = $object->attributeLabels();
        $label = $labels[$attribute];
        if(!UrnRule::isUrn($value) && !empty($value)) {
            $this->addError($object, $attribute,
                    Yii::t('validators', 'Field {label} must contain letters, digits, `-` and `_` characters.',
                    array('{label}'=> $label)));
        }
        if($this->oldurn!=$value){
            if(SiteUrn::model()->exists($value)){
                $this->addError($object, $attribute,
                    Yii::t('validators', 'This website address is already being used. Please choose another one.',
                    array('{label}'=> $label)));
            }
        }
    }


}

?>
