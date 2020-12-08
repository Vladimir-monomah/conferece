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
class AuthorView extends ActiveRecord {

    public $id;
    public $email;
    public $locale; // предпочтительный язык автора
    public $phone;
    //  ассоциативные массивы c ключом-языком
    //  associative arrays with language keys
    public $firstname = array();
    public $lastname = array();
    public $middlename = array();
    public $institution = array();
    public $country = array();
    public $city = array();
    public $position = array();
    public $supervisor = array();
    public $academic_degree = array();
    
    //  дополнительные поля-списки
    //  additional list fields
    public $al_field1_value;
    public $al_field2_value;
    public $al_field3_value;
    public $al_field4_value;
    public $al_field5_value;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{author}}';
    }

    public function firstName($language = NULL) {
        if (empty($language)) {
            $language = Yii::app()->language;
        }
        $value = isset($this->firstname[$language])?$this->firstname[$language]:'';
        return empty($value) ? '' : $value;
    }
    
    public function notEmptyFirstName($language = NULL) {
        if (empty($language)) {
            $language = Yii::app()->language;
        }
        $value = isset($this->firstname[$language])?$this->firstname[$language]:'';
        if (empty($value)) {
            $languages = Yii::app()->params['languages'];
            foreach ($languages as $language => $name) {
                $value = isset($this->firstname[$language])?$this->firstname[$language]:'';
                if (!empty($value))
                    break;
            }
        }
        return empty($value) ? '' : $value;
    }

    public function middleName($language = NULL) {
        if (empty($language)) {
            $language = Yii::app()->language;
        }
        $value = isset($this->middlename[$language])?$this->middlename[$language]:'';
        return empty($value) ? '' : $value;
    }
    
    public function l_field_value($field) {
        return empty($this->{$field})?'':$this->{$field};
    }
    
    public function notEmptyMiddleName($language = NULL) {
        if (empty($language)) {
            $language = Yii::app()->language;
        }
        $value = isset($this->middlename[$language])?$this->middlename[$language]:'';
        if (empty($value)) {
            $languages = Yii::app()->params['languages'];
            foreach ($languages as $language => $name) {
                $value = isset($this->middlename[$language])?$this->middlename[$language]:'';
                if (!empty($value))
                    break;
            }
        }
        return empty($value) ? '' : $value;
    }

    public function lastName($language = NULL) {
        if (empty($language)) {
            $language = Yii::app()->language;
        }
        $value = isset($this->lastname[$language])?$this->lastname[$language]:'';
        return empty($value) ? '' : $value;
    }
    
    public function notEmptyLastName($language = NULL) {
        if (empty($language)) {
            $language = Yii::app()->language;
        }
        $value = isset($this->lastname[$language])?$this->lastname[$language]:'';
        if (empty($value)) {
            $languages = Yii::app()->params['languages'];
            foreach ($languages as $language => $name) {
                $value = isset($this->lastname[$language])?$this->lastname[$language]:'';
                if (!empty($value))
                    break;
            }
        }
        return empty($value) ? '' : $value;
    }
    
    public function authorNameForEmail($language = NULL) {
        $f = $this->notEmptyFirstName($language);
        $m = $this->notEmptyMiddleName($language);
        $l = $this->notEmptyLastName($language);
        $authorName = '';
        if (!empty($f)) {
            $authorName .= $f;
        }
        if (!empty($m)) {
            $authorName .= (empty($authorName)?'': ' ') . $m;
        }
        if (!empty($l)) {
            $authorName .= (empty($authorName)?'': ' ') . $l;
        }
        return $authorName;
    }

    public function academicDegree($language = NULL) {
        if (empty($language)) {
            $language = Yii::app()->language;
        };
        $value = isset($this->academic_degree[$language])?$this->academic_degree[$language]:'';
        return empty($value) ? '' : $value;
    }

    public function institution($language = NULL) {
        if (empty($language)) {
            $language = Yii::app()->language;
        };
        $value = isset($this->institution[$language])?$this->institution[$language]:'';
        return empty($value) ? '' : $value;
    }
    
    public function country($language = NULL) {
        if (empty($language)) {
            $language = Yii::app()->language;
        };
        $value = isset($this->country[$language])?$this->country[$language]:'';
        return empty($value) ? '' : $value;
    }
    
    public function notEmptyCountry($language = NULL) {     
        if (empty($language)) {
            $language = Yii::app()->language;
        }
        $value = isset($this->country[$language])?$this->country[$language]:'';
        if (empty($value)) {
            $languages = Yii::app()->params['languages'];
            foreach ($languages as $language => $name) {
                $value = isset($this->country[$language])?$this->country[$language]:'';
                if (!empty($value))
                    break;
            }
        }
        return empty($value) ? '' : $value;
    }

    public function city($language = NULL) {
        if (empty($language)) {
            $language = Yii::app()->language;
        };
        $value = isset($this->city[$language])?$this->city[$language]:'';
        return empty($value) ? '' : $value;
    }

    public function notEmptyCity($language = NULL) {     
        if (empty($language)) {
            $language = Yii::app()->language;
        }
        $value = isset($this->city[$language])?$this->city[$language]:'';
        if (empty($value)) {
            $languages = Yii::app()->params['languages'];
            foreach ($languages as $language => $name) {
                $value = isset($this->city[$language])?$this->city[$language]:'';
                if (!empty($value))
                    break;
            }
        }
        return empty($value) ? '' : $value;
    }
    
    public function position($language = NULL) {
        if (empty($language)) {
            $language = Yii::app()->language;
        };
        $value = isset($this->position[$language])?$this->position[$language]:'';
        return empty($value) ? '' : $value;
    }

    public function supervisor($language = NULL) {
        if (empty($language)) {
            $language = Yii::app()->language;
        }
        $value = isset($this->supervisor[$language])?$this->supervisor[$language]:'';
        return empty($value) ? '' : $value;
    }

    public function authorName($language = NULL) {
        $f = StringUtils::firstUChar($this->firstName($language));
        $m = StringUtils::firstUChar($this->middleName($language));
        $authorName = $this->lastName($language);
        if (!empty($f)) {
            $authorName.=' ' . $f . '.';
        }
        if (!empty($m)) {
            $authorName.=' ' . $m . '.';
        }
        return $authorName;
    }

    public function authorFullName($language = NULL) {
        return $this->lastName($language) . ' ' . $this->firstName($language) . ' ' . $this->middleName($language);
    }

    public function authorNameDC($language) {
        $f = StringUtils::firstUChar($this->firstName($language));
        $m = StringUtils::firstUChar($this->middleName($language));
        $authorName = $this->lastName($language);
        if (!empty($authorName))
            $authorName.=',';
        if (!empty($f)) {
            $authorName.=' ' . $f . '.';
        }
        if (!empty($m)) {
            $authorName.=' ' . $m . '.';
        }
        return $authorName;
    }

    public function authorNameDC2($language) {
        $f = StringUtils::firstUChar($this->firstName($language));
        $m = StringUtils::firstUChar($this->middleName($language));
        $authorName = '';
        if (!empty($f)) {
            $authorName.=$f . '.';
        }
        if (!empty($m)) {
            $authorName.=' ' . $m . '.';
        }
        $l = $this->lastName($language);
        if (!empty($l)) {
            $authorName.=' ' . $l;
        };
        return $authorName;
    }

}
