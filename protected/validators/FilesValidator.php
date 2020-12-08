<?php

/**
 *  Проверяет файл на соответствие органичениям по размеру и расширению.
 *  Применим к объекту с полем типа File
 *  либо, если к объекту прикручено поведение FilesBehavior,
 *  в котором перечислен такой файл.
 * 
 *  Tests a file to obey to restrictions on max size and allowed extensions.
 *  Applicable to a an object with attribute of type File
 *  or if an object has FilesBehavior where such a file listed. 
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class FilesValidator extends CValidator {

    public $size = NULL;
    public $exts = NULL;

    //  e.g. $object of class Org, $attribute = logo of class File
    protected function validateAttribute($object, $attribute) {
        $behaviors = $object->behaviors();
        $files = NULL;
        if (isset($behaviors['FilesBehavior'])) {
            $files = $object->getFiles($attribute);
        } else {
            $files = $object->$attribute;
        }
        if (!is_array($files)) {
            $files = array($files);
        }
        $uploadError = FALSE;
        $sizeError = FALSE;
        $extError = FALSE;
        foreach ($files as $file) {
            //  $file — объект типа MultilingualFile
            //  $file — an object of type MultilingualFile
            if (($file != NULL) && !$file->isEmpty()) {
                $labels = $object->attributeLabels();
                $label = $labels[$attribute];
                $file->setValid();
                //  validate if files are uploaded
                $file->prepareFiles();
                $uploaded = $file->isTempFileUploaded();
                if (!$uploaded) {
                    if (!$uploadError) {
                        if ($attribute == 'info_letter') {
                            $this->addError($object, $attribute, Yii::t('validators', 'Information letter was not uploaded, an error occured.'));                  
                        } else if ($attribute == 'image') {
                            $this->addError($object, $attribute, Yii::t('validators', 'Image was not uploaded, an error occured.'));             
                        } else if ($file->file_type == FileType::LOGO) {
                            $this->addError($object, $attribute, Yii::t('validators', '{label} was not uploaded, an error occured.', array('{label}' => $label)));    
                        } else {
                            $this->addError($object, $attribute, Yii::t('validators', '{label} were not uploaded, an error occured.', array('{label}' => $label)));
                        }
                    }
                    $uploadError = TRUE;
                    continue;                 
                }
                //  validate size
                if ($this->size) {
                    $validator = new FileSizeValidator();
                    $validator->size = $this->size;
                    $valid = $file->validateFiles($validator);
                    if (!$valid) {
                        if (!$sizeError) {
                            $this->addError($object, $attribute, Yii::t('validators', '{label} must not exceed size of {size}.', array('{label}' => $label, '{size}' => FileUtils::fileSizeStr($this->size))));
                        }
                        $sizeError = TRUE;
                    }
                }
                //  exts validator
                if ($this->exts) {
                    $validator = new FileExtValidator();
                    $validator->exts = $this->exts;
                    $valid = $file->validateFiles($validator);
                    if (!$valid) {
                        if (!$extError) {
                            $this->addError($object, $attribute, Yii::t('validators', 'Unsupported format for {label}.', array('{label}' => $label)));    
                        }
                        $extError = TRUE;
                    }
                }
            }
        }
    }

}

?>
