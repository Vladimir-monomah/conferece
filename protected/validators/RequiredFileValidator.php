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
class RequiredFileValidator extends CValidator {

    public $required = AppFormSettings::MODE_ENABLED;
    public $required_language = NULL;
    public $required_languages = array('ru' => 'Русский');

    protected function validateAttribute($object, $attribute) {
        if ($this->required == AppFormSettings::MODE_ENABLED) {
            return;
        }
        $behaviors = $object->behaviors();
        $files = NULL;
        if (isset($behaviors['FilesBehavior'])) {
            $files = $object->getFiles($attribute);
        } else {
            $files = $object->$attribute;
        }
        $labels = $object->attributeLabels();
        $label = $labels[$attribute];
        $valid = true;
        $languages_count = count(array_keys($this->required_languages));
        //  $file — object of type MultilingualFile
        if (!is_array($files)) {
            $file = $files;
            $count = 0;
            $count_required_language = 0;
            if ($file != NULL) {
                $file->prepareFiles();
                foreach ($this->required_languages as $language => $name) {
                    if (!$file->isEmpty($language)) {
                        $count++;
                        if ($language == $this->required_language) {
                            $count_required_language++;
                        }
                    }
                };
            };
            if (($this->required == AppFormSettings::MODE_MANDATORY_ONE) && ($count == 0)) {
                $valid = false;
            };
            if (($this->required == AppFormSettings::MODE_MANDATORY_CURRENT) && ($count_required_language == 0)) {
                $valid = false;
            };
            if (($this->required == AppFormSettings::MODE_MANDATORY_ALL) && ($count < $languages_count)) {
                $valid = false;
            };
            if (!$valid && ($languages_count <= 1)) {
                $this->addError($object, $attribute, Yii::t('validators', 'It is required to upload {label}.', array('{label}' => $label)));
            };
            if (!$valid && ($languages_count > 1) && ($this->required == AppFormSettings::MODE_MANDATORY_ONE)) {
                $this->addError($object, $attribute, Yii::t('validators', 'It is required to upload {label}.', array('{label}' => $label)));
            };
            if (!$valid && ($languages_count > 1) && ($this->required == AppFormSettings::MODE_MANDATORY_CURRENT)) {
                $this->addError($object, $attribute, Yii::t('validators', 'It is required to upload {label}.', array('{label}' => $label)));
            };
            if (!$valid && ($languages_count > 1) && ($this->required == AppFormSettings::MODE_MANDATORY_ALL)) {
                $this->addError($object, $attribute, Yii::t('validators', 'It is required to upload the files in the {label} in all languages.', array('{label}' => $label)));
            };
        } else {
            $files_count = 0;
            foreach ($files as $file) {
                if ($file != NULL) {
                    $count = 0;
                    $count_required_language = 0;
                    $file->prepareFiles();
                    foreach ($this->required_languages as $language => $name) {
                        if (!$file->isEmpty($language)) {
                            $count++;
                            if ($language == $this->required_language) {
                                $count_required_language++;
                            }
                        }
                    };
                    // если $count==0 то считаем, что по ошибке нажата кнопка Добавить файл
                    if ($count > 0) {
                        $files_count++;
                        if (($this->required == AppFormSettings::MODE_MANDATORY_CURRENT) && ($count_required_language == 0)) {
                            $valid = false;
                        };
                        if (($this->required == AppFormSettings::MODE_MANDATORY_ALL) && ($count < $languages_count)) {
                            $valid = false;
                        };
                    };
                }
            }
            if (($files_count == 0) && in_array($this->required, array(
                        AppFormSettings::MODE_MANDATORY_ONE, 
                        AppFormSettings::MODE_MANDATORY_CURRENT, 
                        AppFormSettings::MODE_MANDATORY_ALL))) {
                $this->addError($object, $attribute, Yii::t('validators', 'It is required to upload {label}.', array('{label}' => $label)));
            }
            if ($files_count > 0) {
                if (!$valid && ($this->required == AppFormSettings::MODE_MANDATORY_CURRENT)) {
                    $this->addError($object, $attribute, Yii::t('validators', 'It is required to upload {label}.', array('{label}' => $label)));
                }
                if (!$valid && ($this->required == AppFormSettings::MODE_MANDATORY_ALL)) {
                    $this->addError($object, $attribute, Yii::t('validators', 'It is required to upload the files in the {label} in all languages.', array('{label}' => $label)));
                }
            }
        }
    }

}
