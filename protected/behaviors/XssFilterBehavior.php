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
class XssFilterBehavior extends CActiveRecordBehavior {

    public $attributes = array();
    public $languages = array();
    public $allowed_tags = array();
    protected $_filter;

    protected function getFilter() {
        if ($this->_filter == NULL) {
            $this->_filter = new XssFilter();
        }
        return $this->_filter;
    }

    protected function filterOut() {
        $allowed_tags = $this->allowed_tags;
        $filter = $this->getFilter();
        $owner = $this->getOwner();
        foreach ($this->attributes as $attribute) {
            if (is_array($owner->{$attribute})) {
                foreach ($this->languages as $language => $name) {
                    if (isset($owner->{$attribute}[$language])) {
                        $owner->{$attribute}[$language] = $filter->filter_xss($owner->{$attribute}[$language], $allowed_tags);
                    }
                }
            } else {
                $owner->{$attribute} = $filter->filter_xss($owner->{$attribute}, $allowed_tags);
            }
        }
    }

    public function beforeValidate($event) {
        $this->filterOut();
    }

}

?>
