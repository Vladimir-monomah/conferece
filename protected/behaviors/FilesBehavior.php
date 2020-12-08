<?php

/** 
 *  Для использования поведения,
 *  класс должен наследоваться от models/ActiveRecord.
 * 
 *  To adopt this behaviour a class should be inherited from 
 *  models/ActiveRecord. 
 * 
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license.     
 */
class FilesBehavior extends CActiveRecordBehavior {

    /**  
     *  Максимальное количество файлов, которое можно хранить в одном
     *  атрибуте объекта.
     * 
     *  Max files allowed to be attached to an object via one attribute.    
     */
    const MAX_ATTR_FILES_COUNT = 10;

    /**  
     *  Этот атрибут используется в классах (напр. View-классах), где нужно
     *  переопределять класс-владелец, чтобы данные верно сохранялись в базе.
     * 
     *  This attribute is used in classes (e.g. View classes) where it is
     *  needed to redefine the owner class so that data be saved to database
     *  correctly.  
     */
    public $_owner_class = NULL;

    public function getOwner_class() {
        if ($this->_owner_class == NULL) {
            $this->_owner_class = get_class($this->getOwner());
        }
        return $this->_owner_class;
    }

    /**  
     *  Индекс объекта, используется если объектов, в которых нужно обновить
     *  файлы, несколько.
     * 
     *  Owner object index is used when where exist several objects where files
     *  should be updated. 
     */
    public $ownerIdx = NULL;
    
    /**  
     *  Ассоциативный массив из имен атрибутов и типов файлов. Если атрибут
     *  сам является массивом, то имя нужно писать в виде: 'add_files[]',
     *  например: array('logo' => FileType::LOGO,'add_files[]' => FileType::TEXT).
     * 
     *  An associative array of attributes and corresponding file types. If 
     *  an attribute is an array itself then square brackets should be appended
     *  as follows: 'add_files[]',
     *  e.g. array('logo' => FileType::LOGO,'add_files[]' => FileType::TEXT).   
     */ 
    public $fileAttrs = array();
    
    /**  
     *  Ассоциативный массив из имен атрибутов и соответствующих объектов
     *  типа MultilingualFile.
     * 
     *  An associative array of attributes and corresponding objects of type
     *  MultilingualFile.   
     */
    protected $files = array();

    protected function isIndexedAttr($attr) {
        return (mb_substr($attr, -2, 2) == '[]');
    }

    protected function getAttrName($attr) {
        if ($this->isIndexedAttr($attr)) {
            return mb_substr($attr, 0, mb_strlen($attr) - 2);
        }
        return $attr;
    }

    /**
     *  Проверяет существует ли в объекте заданный атрибут.
     * 
     *  Checks if a specified attribute exists in the object. 
     */
    public function hasFileAttr($attrName) {
        foreach ($this->fileAttrs as $attr => $fileType) {
            $_attrName = $this->getAttrName($attr);
            if ($attrName == $_attrName) {
                return true;
            }
        }
        return false;
    }

    /**
    *  Проверяет существует ли файл для заданного атрибута в текущем объекте.
    * 
    *  Checks if a file for the specified attribute exists in the object. 
    */
    public function hasFile($attrName) {
        $file = $this->getFile($attrName);
        return ($file != NULL && !$file->isEmpty());
    }
    
    public function hasAnyFile($attrName){
        return ($this->countFiles($attrName) > 0);
    }

    /**  
     *  Имя в виде: 'logo' или 'add_files' (без скобок).
     * 
     *  An attribute name without brackets, e. g. 'logo' or 'add_files'.   
     */
    public function getFile($attrName, $idx = -1) {
        if ($idx >= 0) {
            return isset($this->files[$attrName][$idx])?$this->files[$attrName][$idx]:NULL;
        }
        return isset($this->files[$attrName])?$this->files[$attrName]:NULL;
    }

    /**  
     *  $file — объект типа MultilingualFile.
     *  $attrName — имя в виде: 'logo' или 'add_files' (без скобок).
     * 
     *  $file is an object of type MultilingualFile.
     *  $attrName — an attribute name without brackets, e. g. 'logo' or 'add_files'.    
     */
    public function setFile($file, $attrName, $idx = -1) {
        if ($idx >= 0) {
            $this->files[$attrName][$idx] = $file;
        } else {
            $this->files[$attrName] = $file;
        }
    }

    public function countFiles($attrName) {
        $count = -1;
        $files = $this->getFiles($attrName);
        foreach($files as $i => $file){
            if( ($file != NULL) && !$file->isEmpty()){
                if ($count < $i) {
                    $count = $i;
                }
            }
        }
        $count++;
        return $count;
    }

    public function getFiles($attrName) {
        return $this->getFile($attrName);
    }

    protected function findFile($attr) {
        return $this->findFiles($attr);
    }

    public function getIdInputFieldName($attrName, $idx, $language) {
        $owner = $this->getOwner();
        $attr = $attrName;
        $file = $this->getFile($attr, $idx);
        if ($file == NULL) {
            $file = new MultilingualFile('insert');
            $file->setOwnerAttributes($owner, $this->owner_class, $attrName, isset($this->fileAttrs[$attr])?$this->fileAttrs[$attr]:NULL, $idx);
        }
        $file->ownerIdx = $this->ownerIdx;
        return $file->getIdInputFieldName($language);
    }

    public function getTempNameInputFieldName($attrName, $idx, $language) {
        $owner = $this->getOwner();
        $attr = $attrName;
        $file = $this->getFile($attr, $idx);
        if ($file == NULL) {
            $file = new MultilingualFile('insert');
            $file->setOwnerAttributes($owner, $this->owner_class, $attrName, isset($this->fileAttrs[$attr])?$this->fileAttrs[$attr]:NULL, $idx);
        }
        $file->ownerIdx = $this->ownerIdx;
        return $file->getTempNameInputFieldName($language);
    }

    public function getFileInputFieldName($attrName, $idx, $language) {
        $owner = $this->getOwner();
        $attr = $attrName;
        $file = $this->getFile($attrName, $idx);
        if ($file == NULL) {
            $file = new MultilingualFile('insert');
            $file->setOwnerAttributes($owner, $this->owner_class, $attrName, isset($this->fileAttrs[$attr])?$this->fileAttrs[$attr]:NULL, $idx);
        }
        $file->ownerIdx = $this->ownerIdx;
        return $file->getFileInputFieldName($language);
    }

    protected function findFiles($attr) {
        $owner = $this->getOwner();
        $attrName = $this->getAttrName($attr);
        $fileType = $this->fileAttrs[$attr];
        if (!$this->isIndexedAttr($attr)) {
            return MultilingualFile::model()->findByOwner($owner, $this->owner_class, $attrName, $fileType);
        } else {
            return MultilingualFile::model()->findAllByOwner($owner, $this->owner_class, $attrName, $fileType);
        }
    }

    protected function findAllFiles() {
        $files = array();
        foreach ($this->fileAttrs as $attr => $fileType) {
            $attrName = $this->getAttrName($attr);
            $files[$attrName] = $this->findFiles($attr);
        }
        return $files;
    }

    /**  
     *  Метод проверяет можно ли в текущем сценарии обновлять атрибут.
     * 
     *  The method checks if an attribute can be modified in the current scenario.  
     */
    protected function canModify($attrName) {
        $owner = $this->getOwner();
        //validators applied to current scenario
        $validators = $owner->getValidators($attrName);
        if (empty($validators)) {
            return false;
        }
        return true;
    }

    protected function prepareFiles($attr) {
        $attrName = $this->getAttrName($attr);
        $owner = $this->getOwner();
        $ownerIdx = $this->ownerIdx;
        $this->files[$attrName] = $this->findFiles($attr);
        if (!$this->isIndexedAttr($attr)) {
            if ($this->files[$attrName] == NULL) {
                $this->files[$attrName] = new MultilingualFile('insert');
                $this->files[$attrName]->setOwnerAttributes($owner, $this->owner_class, $attrName, $this->fileAttrs[$attr]);
            };
            $this->files[$attrName]->ownerIdx = $ownerIdx;
            $this->files[$attrName]->prepareFiles();
        } else {
            $count = count($this->files[$attrName]);
            for ($i = $count; $i < FilesBehavior::MAX_ATTR_FILES_COUNT; $i++) {
                $file = new MultilingualFile('insert');
                $file->setOwnerAttributes($owner, $this->owner_class, $attrName, $this->fileAttrs[$attr], $i);
                array_push($this->files[$attrName], $file);
            };
            foreach ($this->files[$attrName] as $file) {
                $file->ownerIdx = $ownerIdx;
                $file->prepareFiles();
            }
        }
    }

    public function beforeValidate($event) {
        foreach ($this->fileAttrs as $attr => $fileType) {
            $attrName = $this->getAttrName($attr);
            if ($this->canModify($attrName)) {
                $this->prepareFiles($attr);
            }
        }
    }

    public function afterSave($event) {
        $saved = TRUE;
        foreach ($this->fileAttrs as $attr => $fileType) {
            $attrName = $this->getAttrName($attr);
            if ($this->canModify($attrName)) {
                $saved = $saved && $this->saveAttr($attr);
            }
        }
        if (!$saved) {
            throw new CException('Error occured when saving a file.');
        }
    }

    /**  
     *  После удаления объекта-владельца, удаляем его файлы.
     * 
     *  After removal of owner object descendant files are removed as well. 
     */   
    public function afterDelete($event) {
        foreach ($this->fileAttrs as $attr => $fileType) {
            $attrName = $this->getAttrName($attr);
            if (!$this->isIndexedAttr($attr)) {
                $file = $this->files[$attrName];
                if ($file) {
                    $file->delete();
                }
            } else {
                $files = $this->files[$attrName];
                foreach ($files as $i => $file) {
                    if ($file) {
                        $file->delete();
                    }
                }
            }
        }
    }

    public function afterFind($event) {
        $this->files = $this->findAllFiles();
    }

    protected function saveAttr($attr) {
        $saved = TRUE;
        $attrName = $this->getAttrName($attr);
        if (!$this->isIndexedAttr($attr)) {
            $file = $this->files[$attrName];
            if ($file == NULL) {
                return TRUE;
            };
            if ($file->isToDelete()) {
                $file->delete();
            } else if ($file->isToSave()) {
                $owner = $this->getOwner();
                $file->setOwnerAttributes($owner, $this->owner_class, $attrName, $this->fileAttrs[$attr]);
                $saved = $file->save();
            }
        } else {
            $files = $this->files[$attrName];
            foreach ($files as $i => $file) {
                if ($file->isToDelete()) {
                    $file->delete();
                } else if ($file->isToSave()) {
                    $owner = $this->getOwner();
                    $file->setOwnerAttributes($owner, $this->owner_class, $attrName, $this->fileAttrs[$attr]);
                    $saved = $saved && $file->save();
                }
            }
        }
        return $saved;
    }

}

?>
