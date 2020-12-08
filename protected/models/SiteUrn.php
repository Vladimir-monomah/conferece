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
class SiteUrn extends ActiveRecord {

    public $urn;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{urn}}';
    }

    public function addUrn($urn) {
        if (!empty($urn)) {
            $cmd = $this->dbConnection->createCommand();
            $cmd->insert('{{urn}}', array('urn' => $urn));
        }
    }

    public function deleteUrn($urn) {
        if (!empty($urn)) {
            $cmd = $this->dbConnection->createCommand('delete from {{urn}} where urn=:urn');
            $cmd->bindValue(":urn", $urn);
            $cmd->execute();
        };
    }

    public function replace($oldUrn, $newUrn) {
        if (!empty($oldUrn) && !empty($newUrn)) {
            $cmd = $this->dbConnection->createCommand('update {{urn}} set urn=:newurn where urn=:oldurn');
            $cmd->bindValue(":oldurn", $oldUrn);
            $cmd->bindValue(":newurn", $newUrn);
            $cmd->execute();
        };
    }

    public function exists($urn) {
        $cmd = $this->dbConnection->createCommand('select count(*) from {{urn}} where urn=:urn');
        $cmd->bindValue(":urn", $urn);
        $count = $cmd->queryScalar();
        return $count > 0;
    }

}

?>
