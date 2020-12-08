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
class MultilingualBehavior extends CActiveRecordBehavior {

    public $table;
    public $table_fk;
    public $language_column;
    public $columns;
    public $languages = array();

    public function value($attribute, $language = NULL) {
        if (!isset($language)) {
            $language = Yii::app()->language;
        }
        $value = isset($this->getOwner()->{$attribute}[$language])?$this->getOwner()->{$attribute}[$language]:'';
        if (empty($value)) {
            foreach ($this->languages as $language => $name) {
                $value = isset($this->getOwner()->{$attribute}[$language])?$this->getOwner()->{$attribute}[$language]:'';
                if (!empty($value))
                    break;
            }
        }
        return $value;
    }

    public function strictValue($attribute, $language) {
        return $this->getOwner()->{$attribute}[$language];
    }

    public function afterFind($event) {
        $owner = $this->getOwner();
        $owner_pk = $owner->getPrimaryKey();

        $cmd = Yii::app()->db->createCommand()
                ->select('*')
                ->from('{{' . $this->table . '}}')
                ->where("{$this->table_fk}=:id", array(':id' => $owner_pk));

        $rows = $cmd->queryAll();

        foreach ($this->languages as $language => $name) {
            $exists = false;
            foreach ($rows as $row) {
                if ($row[$this->language_column] == $language) {
                    $exists = true;
                    foreach ($this->columns as $column) {
                        $owner->{$column}[$language] = $row[$column];
                    }
                }
            }
            if (!$exists) {
                foreach ($this->columns as $column) {
                    $owner->{$column}[$language] = NULL;
                }
            }
        }
    }

    public function afterSave($event) {
        $owner = $this->getOwner();
        $owner_pk = $owner->getPrimaryKey();
        $rows = array();

        if (!$owner->isNewRecord) {
            $cmd = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from('{{' . $this->table . '}}')
                    ->where("{$this->table_fk}=:id", array(':id' => $owner_pk));

            $rows = $cmd->queryAll();
        } else {
            $cmd = Yii::app()->db->createCommand();
        }

        foreach ($this->languages as $language => $name) {
            $exists = false;
            foreach ($rows as &$row) {
                if ($row[$this->language_column] == $language) {
                    $exists = true;
                    foreach ($this->columns as $column) {
                        $row[$column] = isset($owner->{$column}[$language])?$owner->{$column}[$language]:'';
                    }
                    $cmd->update('{{' . $this->table . '}}', $row, "`{$this->table_fk}`=:id and `{$this->language_column}`=:language", array(":id" => $owner_pk, ':language' => $language));
                }
            }
            if (!$exists) {
                $row = array();
                foreach ($this->columns as $column) {
                    $row[$column] = isset($owner->{$column}[$language])?$owner->{$column}[$language]:'';
                }
                $row[$this->table_fk] = $owner_pk;
                $row[$this->language_column] = $language;
                $cmd->insert('{{' . $this->table . '}}', $row);
            }
        }
    }

    public function afterDelete($event) {
        $owner = $this->getOwner();
        $owner_pk = $owner->getPrimaryKey();

        $cmd = Yii::app()->db->createCommand()
                ->delete('{{' . $this->table . '}}', "`{$this->table_fk}`=:id", array(':id' => $owner_pk));
    }

}

?>
