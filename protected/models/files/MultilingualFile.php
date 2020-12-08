<?php

/**
 *  Свойства класса MultilingualFile, хранимые в БД:
 *      id — идентификатор файла,
 *      file_type — тип файла (см. класс FileType),
 *      owner_id — идентификатор объекта-владельца,
 *      owner_class — класс объекта-владельца (напр., Conf или Participant),
 *      name — название файла (многоязычное),     
 *      title — подпись к файлу для людей (многоязычное, пока не используется).
 * 
 * Attributes of MultilingualFile stored in database:
 *      id — file idetifier,
 *      file_type — file type (see FileType class),
 *      owner_id — owner object identifier,
 *      owner_class — owner class name (e. g., Conf or Participant),
 *      name — file name (multilingual),     
 *      title — file title for human (multilingual, unused so far).  
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class MultilingualFile extends CActiveRecord {

    public $id;
    public $file_type;
    public $owner_id;
    public $owner_class;
    
    //  многоязычные поля
    //  multilingual attributes
    public $title;
    public $name;
    
    //  имена файлов, помещенных во временную папку
    //  file names, placed to temp folder
    protected $temp_name = array();
    
    //  сценарии для файла, для каждого языка
    //  file scenarios for each language
    public $scenarios = array();
    
    public $is_valid = array();
    
    //  эти поля используется для веб-интерфейса
    //  there attributes are used in HTML form
    public $ownerIdx = NULL;
    public $ownerAttr;
    public $ownerAttrIdx;

    //  константы значений миниатюр для разных классов объектов 
    //  constants for thumbnail sizes for different classes of objects 
    const THUMBNAIL_SIZE = 100;
    const CONF_LOGO_SIZE = 170;
    const USER_LOGO_SIZE = 230;
    const AUTHOR_LOGO_SIZE = 230;
    const ORG_LOGO_SIZE = 200;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function __construct($scenario = 'insert') {
        $this->_languages = Yii::app()->params['languages'];
        $this->scenarios = array();
        foreach ($this->_languages as $language => $name) {
            $this->scenarios[$language] = $scenario;
        };
        $this->is_valid = array();
        foreach ($this->_languages as $language => $name) {
            $this->is_valid[$language] = true;
        };
        parent::__construct($scenario);
    }
    
    public function ThumbnailSize(){
        $params = Yii::app()->params;
        return (isset($params['thumbnaleSize']))?intval($params['thumbnaleSize']):MultilingualFile::THUMBNAIL_SIZE;
    }
    
    public function ConfLogoSize(){
        $params = Yii::app()->params;
        return (isset($params['confLogoSize']))?intval($params['confLogoSize']):MultilingualFile::CONF_LOGO_SIZE;
    }
    
    public function UserLogoSize(){
        $params = Yii::app()->params;
        return (isset($params['userLogoSize']))?intval($params['userLogoSize']):MultilingualFile::USER_LOGO_SIZE;
    }
    
    public function AuthorLogoSize(){
        $params = Yii::app()->params;
        return (isset($params['authorLogoSize']))?intval($params['authorLogoSize']):MultilingualFile::AUTHOR_LOGO_SIZE;
    }
    
    public function OrgLogoSize(){
        $params = Yii::app()->params;
        return (isset($params['orgLogoSize']))?intval($params['orgLogoSize']):MultilingualFile::ORG_LOGO_SIZE;
    }
    
    public function createTempCopy($owner, $owner_class, $ownerAttr, $fileType, $ownerAttrIdx = -1) {
        $created = TRUE;
        $copy = new MultilingualFile('copy');
        $copy->owner_id = $owner->id;
        $copy->owner_class = $owner_class;
        $copy->ownerAttr = $ownerAttr;
        $copy->file_type = $fileType;
        $copy->ownerAttrIdx = $ownerAttrIdx;
        $copy->title = $this->title;
        $copy->name = array();
        foreach ($this->languages as $language => $name) {
            $old_name = $this->name[$language];
            if (empty($old_name)) {
                continue;
            };
            $old_path = $this->path($language);
            $new_name = FileUtils::uniqueTempName($old_name);
            $copy->temp_name[$language] = $new_name;
            $new_path = $copy->temp_path($language);
            if (is_file($old_path)) {
                if (copy($old_path, $new_path)) {
                    Yii::log("Creating a temporary copy of the file. Original file: {$old_path}, a temporary copy of the file: {$new_path}.", 'info', 'MultilingualFile.createTempCopy');
                } else {
                    $created = FALSE;
                    Yii::log("Error occured when creating a temporary copy of the file. Original file: {$old_path}, a temporary copy of the file: {$new_path}.", 'error', 'MultilingualFile.createTempCopy');
                };
            };
        };
        if (!$created) {
            $copy = NULL;
        };
        return $copy;
    }

    public function createCopy($owner, $owner_class, $ownerAttr, $fileType, $ownerAttrIdx = -1) {
        $created = TRUE;
        $copy = new MultilingualFile('copy');
        $copy->owner_id = $owner->id;
        $copy->owner_class = $owner_class;
        $copy->ownerAttr = $ownerAttr;
        $copy->file_type = $fileType;
        $copy->ownerAttrIdx = $ownerAttrIdx;
        $copy->title = $this->title;
        $copy->name = array();
        foreach ($this->languages as $language => $name) {
            $old_name = $this->name[$language];
            if (empty($old_name)) {
                continue;
            };
            $old_path = $this->path($language);
            $new_name = FileUtils::uniqueName($old_name);
            $copy->name[$language] = $new_name;
            $copy->title[$language] = $new_name;
            $new_path = $copy->path($language);
            if (is_file($old_path)) {
                if (copy($old_path, $new_path)) {
                    Yii::log("Creating a copy of the file. Original file: {$old_path}, a copy of the file: {$new_path}.", 'info', 'MultilingualFile.createCopy');
                } else {
                    $created = FALSE;
                    Yii::log("Error occured when creating a copy of the file. Original file: {$old_path}, a copy of the file: {$new_path}.", 'error', 'MultilingualFile.createCopy');
                }
            };
        };
        //  чтобы не обновлять поля из запроса
        //  to avoid getting new values from request
        $copy->processed = true; 
        if (!$created) {
            $copy = NULL;
        };
        return $copy;
    }

    public function tableName() {
        return '{{file}}';
    }

    //  languages attribute is taken from MultilingualBehavior
    protected $_languages = array();

    public function behaviors() {
        return array(
            'MultilingualBehavior' => array(
                'class' => 'application.behaviors.MultilingualBehavior',
                'table' => 'multilingual_file',
                'table_fk' => 'file_id',
                'language_column' => 'language',
                'columns' => array('title', 'name'),
                'languages' => $this->_languages,
            ),
        );
    }

    public function rules() {
        return array();
    }

    public function title($language = NULL) {
        return $this->value('title', $language);
    }

    public function name($language = NULL) {
        return $this->value('name', $language);
    }
    
    public function strictName($language = NULL) {
        return $this->strictValue('name', $language);
    }
  
    public function temp_name($language = NULL) {
        if ($language != NULL) {
            return isset($this->temp_name[$language])?$this->temp_name[$language]:'';
        };
        $language = Yii::app()->language;
        $value = isset($this->temp_name[$language])?$this->temp_name[$language]:'';
        if (empty($value)) {
            foreach ($this->languages as $language => $name) {
                $value = isset($this->temp_name[$language])?$this->temp_name[$language]:'';
                if (!empty($value))
                    break;
            };
        };
        return $value;
    }

    public function path($language = NULL) {
        return FileUtils::storagePath() . $this->name($language);
    }

    public function temp_path($language = NULL) {
        return FileUtils::tempPath() . $this->temp_name($language);
    }

    public function extension($language = NULL) {
        $_name = $this->name($language);
        return FileUtils::getExtension($_name);
    }

    public function temp_extension($language = NULL) {
        $_name = $this->temp_name($language);
        return FileUtils::getExtension($_name);
    }

    protected function strictPath($language) {
        return FileUtils::storagePath() . $this->strictValue('name', $language);
    }

    protected function strictTempPath($language) {
        return FileUtils::tempPath() . $this->temp_name[$language];
    }

    public function url($language = NULL) {
        $temp_name = $this->temp_name($language);
        if (!empty($temp_name)) {
            return '/' . FileUtils::$tempFolder . '/' . $temp_name;
        };
        $url = '/' . FileUtils::$webFolder . '/' . $this->name($language);
        if ($this->file_type == FileType::LOGO) {
            $url = '/' . FileUtils::$webFolder . '/' . $this->resizedFileName($language);
        };
        return $url;
    }

    protected function thumbnailFileName($language) {
        if (($this->file_type == FileType::LOGO) && ($this->owner_class == "Author")) {
            $file_name = $this->name($language);
            if (!empty($file_name)) {
                $extension = FileUtils::getExtension($file_name);
                $thumbnail_name = FileUtils::getFileName($file_name) . '_thumbnail.' . $extension;
                $file_path = FileUtils::storagePath() . $file_name;
                $thumbnail_path = FileUtils::storagePath() . $thumbnail_name;
                if (!file_exists($thumbnail_path)) {
                    $img = NULL;
                    //  создаем миниатюру, должна быть включена библиотека gd в php
                    //  creating a thumbnail, php gd library must be enabled
                    if (($extension == 'jpg') || ($extension == 'jpeg')) {
                        $img = imagecreatefromjpeg($file_path);
                    };
                    if ($extension == 'gif') {
                        $img = imagecreatefromgif($file_path);
                    };
                    if ($extension == 'png') {
                        $img = imagecreatefrompng($file_path);
                    };
                    if ($img === FALSE) {
                        return NULL;
                    };
                    $width = imagesx($img);
                    $height = imagesy($img);
                    $min = min($width, $height);

                    //  calculating thumbnail size
                    $new_min = ($min > $this->ThumbnailSize() ? $this->ThumbnailSize() : $min);

                    $thumb = imagecreatetruecolor($new_min, $new_min);
                    imagecopyresampled($thumb, $img, 0, 0, 0, 0, $new_min, $new_min, $min, $min);

                    $created = FALSE;
                    //  saving thumbnail into a file
                    if (($extension == 'jpg') || ($extension == 'jpeg')) {
                        $created = imagejpeg($thumb, $thumbnail_path);
                    };
                    if ($extension == 'gif') {
                        $created = imagegif($thumb, $thumbnail_path);
                    };
                    if ($extension == 'png') {
                        $created = imagepng($thumb, $thumbnail_path);
                    };
                    if ($created) {
                        Yii::log("The thumbnail created: {$thumbnail_name}.", 'info', 'FileUtils.thumbnailFileName');
                    } else {
                        $thumbnail_name = NULL;
                        Yii::log("Error occured when creating thumbnail: {$thumbnail_name}.", 'error', 'FileUtils.thumbnailFileName');
                    };
                };
                return $thumbnail_name;
            };
        };
        return NULL;
    }

    protected function resizedFileName($language) {
        if ($this->file_type == FileType::LOGO) {
            $file_name = $this->name($language);
            if (!empty($file_name)) {
                $extension = FileUtils::getExtension($file_name);
                $file_path = FileUtils::storagePath() . $file_name;

                $img = NULL;
                //  должна быть включена библиотека gd в php
                //  php gd library must be enabled
                if (($extension == 'jpg') || ($extension == 'jpeg')) {
                    $img = imagecreatefromjpeg($file_path);
                };
                if ($extension == 'gif') {
                    $img = imagecreatefromgif($file_path);
                };
                if ($extension == 'png') {
                    $img = imagecreatefrompng($file_path);
                };
                if ($img === FALSE) {
                    return NULL;
                };
                $width = imagesx($img);
                $height = imagesy($img);

                //  calculating new size
                $size = $this->ConfLogoSize();
                if ($this->owner_class == "Org") {
                    $size = $this->OrgLogoSize();
                };
                if ($this->owner_class == "User") {
                    $size = $this->UserLogoSize();
                };
                if ($this->owner_class == "Author") {
                    $size = $this->AuthorLogoSize();
                };
                $max = max($width, $height);
                if ($max <= $size) {
                    //  не надо изменять размер
                    //  no need to change file size
                    return $file_name;
                };
                $new_width = intval($width * ($size / $max));
                $new_height = intval($height * ($size / $max));

                $resized_file_name = FileUtils::getFileName($file_name) . '_' . intval($new_width) . '_' . intval($new_height) . '.' . $extension;
                $resized_file_path = FileUtils::storagePath() . $resized_file_name;
                if (!file_exists($resized_file_path)) {
                    $resized = imagecreatetruecolor($new_width, $new_height);
                    imagecopyresampled($resized, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

                    $created = FALSE;
                    //  saving resized file
                    if (($extension == 'jpg') || ($extension == 'jpeg')) {
                        $created = imagejpeg($resized, $resized_file_path);
                    };
                    if ($extension == 'gif') {
                        $created = imagegif($resized, $resized_file_path);
                    };
                    if ($extension == 'png') {
                        $created = imagepng($resized, $resized_file_path);
                    };
                    if ($created) {
                        Yii::log("A smaller copy of a file created: {$resized_file_path}.", 'info', 'FileUtils.resizedFileName');
                    } else {
                        $resized_file_name = NULL;
                        Yii::log("Error occured when creating a smaller copy of a file: {$resized_file_path}.", 'error', 'FileUtils.resizedFileName');
                    }
                }
                return $resized_file_name;
            };
        };
        return NULL;
    }

    public function thumbnail_url($language = NULL) {
        if ($this->file_type == FileType::LOGO) {
            $name = $this->thumbnailFileName($language);
            if (empty($name)) {
                return NULL;
            };
            return '/' . FileUtils::$webFolder . '/' . $name;
        }
        return NULL;
    }

    public function sizeStr($language = NULL) {
        $size = 0;
        $path = $this->path($language);
        if ($path && file_exists($path)) {
            $size = filesize($path);
        }
        return FileUtils::fileSizeStr($size, $language);
    }

    public function getBaseInputField($language = 'ru') {
        $inputField = '';
        $ownerIdx = '';
        if ($this->ownerIdx !== NULL) {
            $ownerIdx = '[' . $this->ownerIdx . ']';
        };
        if ($this->ownerAttrIdx >= 0) {
            $inputField = $this->owner_class . $ownerIdx . '[' . $this->ownerAttr . '][' . $this->ownerAttrIdx . ']';
        } else {
            $inputField = $this->owner_class . $ownerIdx . '[' . $this->ownerAttr . ']';
        }
        if ($language) {
            $inputField.='[' . $language . ']';
        }
        return $inputField;
    }

    public function getFileInputFieldName($language = 'ru') {
        return $this->getBaseInputField($language) . '[file]';
    }

    public function getIdInputFieldName($language = 'ru') {
        return $this->getBaseInputField($language) . '[id]';
    }

    public function getTempNameInputFieldName($language = 'ru') {
        return $this->getBaseInputField($language) . '[temp_name]';
    }

    protected function uploadedFileId($language = 'ru') {
        $id = isset($_POST[$this->owner_class])?$_POST[$this->owner_class]:array();
        if ($this->ownerIdx !== NULL) {
            $id = $id[$this->ownerIdx];
        };
        $id = isset($id[$this->ownerAttr])?$id[$this->ownerAttr]:'';
        if ($this->ownerAttrIdx >= 0) {
            $id = isset($id[$this->ownerAttrIdx])?$id[$this->ownerAttrIdx]:'';
        }
        $id = isset($id[$language])?$id[$language]['id']:'';
        return $id;
    }

    protected function uploadedFileTempName($language = 'ru') {
        $temp_name = isset($_POST[$this->owner_class])?$_POST[$this->owner_class]:array();
        if ($this->ownerIdx !== NULL) {
            $temp_name = $temp_name[$this->ownerIdx];
            
        };
        $temp_name = isset($temp_name[$this->ownerAttr])?$temp_name[$this->ownerAttr]:'';
        if ($this->ownerAttrIdx >= 0) {
            $temp_name = isset($temp_name[$this->ownerAttrIdx])?$temp_name[$this->ownerAttrIdx]:'';
        }
        $temp_name = isset($temp_name[$language])?$temp_name[$language]['temp_name']:'';
        return urldecode($temp_name);
    }

    protected $processed = false;

    protected function processPOSTFiles() {
        if (!$this->processed) {
            $this->processed = true;

            foreach ($this->languages as $language => $name) {
                $fileInputName = $this->getFileInputFieldName($language);
                $uploadedFile = CUploadedFile::getInstanceByName($fileInputName);

                $uploadedId = $this->uploadedFileId($language);
                $uploadedName = $this->uploadedFileTempName($language);
                //  если файл был загружен в предыдущем запросе, но еще не сохранен
                //  if the file has been uploaded in previous submit but has not been saved yet
                $this->temp_name[$language] = $uploadedName;

                //  если пришел новый файл, то его загружаем
                //  if a new file has come then uploading it
                if ($uploadedFile) {
                    $this->temp_name[$language] = FileUtils::uniqueTempName($uploadedFile->name);
                    $fileSaved = FALSE;
                    if (FileUtils::arePathsAvailable()){
                        $fileSaved = $uploadedFile->saveAs($this->temp_path($language));
                    }
                    $uploadedName = $this->temp_name[$language];
                    if (empty($uploadedName) && !empty($uploadedFile->name)) {
                        $uploadedName = $uploadedFile->name;
                        $this->temp_name[$language] = $uploadedName;
                    }
                    if ($fileSaved) {
                        Yii::log("Creating a temportay file: {$this->temp_path($language)}.", 'info', 'MultilingualFile.processPOSTFiles');
                    } else {
                        Yii::log("Error occured when creating a temportay file: {$this->temp_path($language)}.", 'error', 'MultilingualFile.processPOSTFiles');     
                    }
                };

                
                //  если в запросе пришел только id, то файл остается без изменений, ничего не делаем
                //  if only id of the file has come in request then the file stays unchanged, nothing to do 
                $this->scenarios[$language] = ''; //пустой сценарий                
                //  если пришел и id и файл, то файл модифицируем
                //  if id and file have come then updating the file
                if (!empty($uploadedId) && !empty($uploadedName)) {
                    $this->scenarios[$language] = 'modify';
                }
                //  если ничего не пришло, то файл удален
                //  if nothing has arrived then deleting the file
                if (empty($uploadedId) && empty($uploadedName)) {
                    $this->scenarios[$language] = 'delete';
                }
                //  если пришел только файл, то создаем новый
                //  if only file arrived then creating a new one
                if (empty($uploadedId) && !empty($uploadedName)) {
                    $this->scenarios[$language] = 'insert';
                }
            }
        }
    }

    public function isToDelete() {
        return !$this->isNewRecord && $this->allScenariosEqual('delete');
    }

    public function isToCopy() {
        return $this->isNewRecord && $this->allScenariosEqual('copy');
    }

    public function isToSave() {
        return !$this->allScenariosEqual('delete');
    }

    public function allScenariosEqual($scenario = 'delete') {
        $res = true;
        foreach ($this->languages as $language => $name) {
            $res = $res && ($this->scenarios[$language] == $scenario);
        }
        return $res;
    }

    public function prepareFiles() {
        $this->processPOSTFiles();
    }

    /**  
     *  Считаем файл пустым, если нет имени и временного имени.
     * 
     *  File is empty if there is no name nor temporary name for it. 
     */
    public function isEmpty($language = NULL) {
        $empty = true;
        if ($language != NULL) {
            $empty = empty($this->name[$language]) && empty($this->temp_name[$language]) || $this->scenarios[$language] == 'delete';
            return $empty;
        }
        foreach ($this->languages as $language => $name) {
            $empty = $empty && (empty($this->name[$language]) && empty($this->temp_name[$language]) || ($this->scenarios[$language] == 'delete'));
        }
        return $empty;
    }
    
    /**
     *  Проверяет, существует ли физический временный файл (файлы) на диске.
     * 
     *  Checks if a temporary file (files) physically exists on a drive.
     */
    public function isTempFileUploaded($language = NULL){    
        if ($language != NULL) {
            $name = $this->temp_name[$language];
            if (!empty($name)) {
                $path = $this->strictTempPath($language);
                if (is_file($path) === FALSE) {
                    //$this->temp_name[$language] = '';
                    $this->is_valid[$language] = false;
                    return FALSE;
                };
            };        
        }
        $uploaded = TRUE;
        foreach ($this->languages as $language => $name) {
            $name = $this->temp_name[$language];
            if (!empty($name)) {
                $path = $this->strictTempPath($language);
                if (is_file($path) === FALSE) {
                    //$this->temp_name[$language] = '';
                    $this->is_valid[$language] = false;
                    $uploaded = FALSE;
                };
            };   
        }
        return $uploaded;
    }
    

    //  simple unsaved case
    public function getNotEmptyLanguages() {
        $langs = array();
        foreach ($this->languages as $language => $name) {
            if (!empty($this->name[$language])) {
                $langs[$language] = $name;
            }
        };
        return $langs;
    }

    public function isToUpdate() {
        $res = false;
        $scenarios = array('insert', 'modify', 'delete');
        foreach ($this->languages as $language => $name) {
            $scenario = $this->scenarios[$language];
            $res = $res || (!empty($this->name[$language]) && in_array($scenario, $scenarios));
        }
        return $res;
    }

    protected function afterFind() {
        parent::afterFind();
        $this->setValid();
    }

    public function setValid() {
        $this->is_valid = array();
        foreach ($this->languages as $language => $name) {
            $this->is_valid[$language] = true;
        };
    }

    public function isValid($language = NULL) {
        $is_valid = true;
        if ($language != NULL) {
            $is_valid = $this->is_valid[$language] && ($this->scenarios[$language] != 'delete');
        } else
            foreach ($this->languages as $language => $name) {
                $is_valid = $is_valid && $this->is_valid[$language];
            }
        return $is_valid;
    }

    public function validateFiles($validator) {
        $valid = true;
        $this->prepareFiles();
        foreach ($this->languages as $language => $name) {
            $file_name = $this->temp_name[$language];
            if (!empty($file_name)) {
                $file_path = $this->temp_path($language);
                $valid_file = $validator->validate($file_path);
                $this->is_valid[$language] = $this->is_valid[$language] && $valid_file;
                $valid = $valid && $valid_file;
            };
        }
        return $valid;
    }

    public function beforeSave() {
        if (!parent::beforeSave()) {
            return FALSE;
        };
        $this->prepareFiles();
        foreach ($this->languages as $language => $name) {
            $scenario = $this->scenarios[$language];
            if (in_array($scenario, array('insert', 'modify'))) {
                //  удаляем старый файл с диска
                //  removing an old file
                $this->deleteFile($language);
                //  переписываем временный файл в папку постоянного хранения
                //  moving the temporary file to the permanent folder
                $temp_name = $this->temp_name[$language];
                $this->name[$language] = FileUtils::uniqueName($temp_name);
                $created = FALSE;
                $old_path = $this->temp_path($language);
                $new_path = $this->path($language);
                if (!empty($this->name[$language])) {
                    $created = copy($old_path, $new_path);
                }
                $this->temp_name[$language] = '';
                if ($created) {
                    Yii::log("Moving a temporary file: {$old_path} to a permanent: {$new_path}.", 'info', 'MultilingualFile.beforeSave');
                } else {
                    Yii::log("Error occured when moving a temporary file: {$old_path} to a permanent: {$new_path}.", 'error', 'MultilingualFile.beforeSave');
                    return FALSE;
                }
                if (is_file($old_path)) {
                    $deleted = unlink($old_path);
                    if ($deleted) {
                        Yii::log("The temporary file {$old_path} deleted.", 'info', 'MultilingualFile.beforeSave');
                    } else {
                        Yii::log("Could not delete the temporary file {$old_path}.", 'error', 'MultilingualFile.beforeSave');
                    }
                };
            } else if ('delete' == $scenario) {
                $this->deleteFile($language);
                $this->name[$language] = NULL;
            };
        }
        return TRUE;
    }

    /**  
     *  При удалении объекта-файла, удаляем физические файлы.
     * 
     *  When a file object is removed, physical files are deleted as well.  
     */
    public function afterDelete() {
        parent::afterDelete();
        $this->deleteFiles();
    }

    protected function deleteFiles() {
        foreach ($this->languages as $language => $name) {
            $this->deleteFile($language);
        }
    }

    protected function deleteFile($language = NULL) {
        $file_name = isset($this->name[$language])?$this->name[$language]:'';
        $filePath = FileUtils::storagePath() . $file_name;
        if ($this->file_type == FileType::LOGO) {
            if (!empty($file_name)) {
                //  удаляем миниатюру
                //  deleting a thumbnail
                $thumbnail_name = $this->thumbnailFileName($language);
                $thumbnailPath = FileUtils::storagePath() . $thumbnail_name;
                if (is_file($thumbnailPath)) {
                    $deleted = unlink($thumbnailPath);
                    if ($deleted) {
                        Yii::log("A thumbnail {$thumbnailPath} deleted.", 'info', 'MultilingualFile.deleteFile');
                    } else {
                        Yii::log("Could not delete a thumbnail {$thumbnailPath}.", 'error', 'MultilingualFile.deleteFile');
                    }
                }
                //  удаляем уменьшеную копию
                //  deleting a smaller copy
                $resized_name = $this->resizedFileName($language);
                $resized_path = FileUtils::storagePath() . $resized_name;
                if (is_file($resized_path)) {
                    $deleted = unlink($resized_path);
                    if ($deleted) {
                        Yii::log("A smaller copy {$resized_path} deleted.", 'info', 'MultilingualFile.deleteFile');
                    } else {
                        Yii::log("Could not delete a smaller copy {$resized_path}.", 'error', 'MultilingualFile.deleteFile');
                    }
                };
            };
        };
        //  удаляем сам файл после удаления миниатюр
        //  deleting the source file
        if (is_file($filePath)) {
            $deleted = unlink($filePath);
            if ($deleted) {
                Yii::log("The file {$filePath} deleted.", 'info', 'MultilingualFile.deleteFile');
            } else {
                Yii::log("Could not delete the file {$filePath}.", 'error', 'MultilingualFile.deleteFile');
            }
        };
    }

    public function copyToTemp() {
        $copied = FALSE;
        foreach ($this->languages as $language => $name) {
            $tmp_path = FileUtils::tempPath() . $this->name($language);
            $path = $this->path($language);
            if (FileUtils::arePathsAvailable() && is_file($path)) {
                if (copy($path, $tmp_path)) {
                    $copied = TRUE;
                    Yii::log("Copying to a temporary file. Original file: {$path}, a temporary file: {$tmp_path}.", 'info', 'MultilingualFile.copyToTemp');
                } else {
                    Yii::log("Error occured when copying to a temporary file. Original file: {$path}, a temporary file: {$tmp_path}.", 'error', 'MultilingualFile.copyToTemp');
                }
            };
        };
        return $copied;
    }

    protected function deleteTempFile($language = NULL) {
        $filePath = $this->strictTempPath($language);
        if (is_file($filePath)) {
            $deleted = unlink($filePath);
            if ($deleted) {
                Yii::log("The temporary file {$filePath} deleted.", 'info', 'MultilingualFile.deleteTempFile');
            } else {
                Yii::log("Could not delete the temporary file {$filePath}.", 'error', 'MultilingualFile.deleteTempFile');
            }
        };    
    }

    public function setOwnerAttributes($owner, $owner_class, $ownerAttr, $fileType, $ownerAttrIdx = -1) {
        $this->owner_id = $owner->id;
        $this->owner_class = $owner_class;
        $this->file_type = $fileType;
        $this->ownerAttr = $ownerAttr;
        $this->ownerAttrIdx = $ownerAttrIdx;
    }

    public function findByOwner($owner, $owner_class, $ownerAttr, $fileType, $ownerAttrIdx = -1) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'owner_id=:owner_id and owner_class=:owner_class and file_type=:file_type';
        $criteria->params = array(
            ':owner_id' => $owner->id,
            ':owner_class' => $owner_class,
            ':file_type' => $fileType
        );
        $file = $this->find($criteria);
        if ($file) {
            $file->setOwnerAttributes($owner, $owner_class, $ownerAttr, $fileType, $ownerAttrIdx);
        }
        return $file;
    }

    public function findAllByOwner($owner, $owner_class, $ownerAttr, $fileType) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'owner_id=:owner_id and owner_class=:owner_class and file_type=:file_type';
        $criteria->params = array(
            ':owner_id' => $owner->id,
            ':owner_class' => $owner_class,
            ':file_type' => $fileType
        );
        $files = $this->findAll($criteria);
        foreach ($files as $i => $file) {
            $file->setOwnerAttributes($owner, $owner_class, $ownerAttr, $fileType, $i);
        }
        return $files;
    }

    public function findParticipantFilesByConf($conf) {
        $criteria = new CDbCriteria;
        $criteria->alias = 'file';
        $criteria->join = 'LEFT JOIN {{participant}} participant ON participant.id=file.owner_id';
        $criteria->condition = 'participant.conf_id=:conf_id and owner_class=:owner_class and file_type=:file_type';
        $criteria->params = array(
            ':conf_id' => $conf->id,
            ':owner_class' => 'Participant',
            ':file_type' => FileType::TEXT);
        return $this->findAll($criteria);
    }

    public function findFirstAuthorPtotoesByConf($conf) {
        $criteria = new CDbCriteria;
        $criteria->alias = 'file';
        $criteria->join = 'LEFT JOIN {{author}} author ON author.id=file.owner_id';
        $criteria->condition = 'file.owner_class=:owner_class and file.file_type=:file_type'
                . ' and author.id in ('
                . ' select min(author.id)'
                . ' FROM tbl_author author left join tbl_participant participant on author.participant_id=participant.id'
                . ' where participant.conf_id=:conf_id'
                . ' GROUP BY participant.id'
                . ' )';
        $criteria->params = array(
            ':conf_id' => $conf->id,
            ':owner_class' => 'Author',
            ':file_type' => FileType::LOGO);
        return $this->findAll($criteria);
    }

}

?>
