<?php

/*
 *  Вспомогательный класс для работы Responsive Filemanager. 
 * 
 *  Responsive Filemanager utililty class.
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class RFilemanagerUtils {

    

    public static function RFPath() {
        return Yii::getPathOfAlias(RFilemanagerConsts::$RFFolderPathAlias) . DIRECTORY_SEPARATOR;
    }

    public static function RFThumbsPath() {
        return Yii::getPathOfAlias(RFilemanagerConsts::$RFThumbsFolderPathAlias) . DIRECTORY_SEPARATOR;
    }

    protected static function mkDir($dir) {
        if (!is_dir($dir)) {
            mkdir($dir);
        };
    }

    public static function rmDir($dir) {
        if (is_dir($dir)) {
            foreach (scandir($dir) as $item) {
                if ($item == '.' || $item == '..')
                    continue;
                unlink($dir . DIRECTORY_SEPARATOR . $item);
            }
            rmdir($dir);
        }
    }

    public static function renameDir($oldDir, $newDir) {
        if (is_dir($newDir)) {
             Yii::log('RFilemanagerUtils: ' . $newDir . ' already exists, can not rename ' . $oldDir . ' to ' . $newDir, 'error', 'RFilemanagerUtils');
        }
        if (is_dir($oldDir)) {
            rename($oldDir, $newDir);
        }
    }
   
    protected static function createSubfolder($obj) {
        if (!empty($obj)) {
            $rf_dir = self::RFPath();
            self::mkDir($rf_dir);
            $obj_dir = $rf_dir . DIRECTORY_SEPARATOR . $obj->subfolder();
            self::mkDir($obj_dir);
        }
    }
    
    /*
     *   См. RFilemanagerBehavior.
     * 
     *   Work in pair with RFilemanagerBehavior.
     */
    public static function saveSubfolder($obj) {
        $temp_id = $obj->temp_id;
        $id = $obj->id;

        $rf_dir = self::RFPath();
        $obj_dir = $rf_dir . $obj->subfolder($id);
        $obj_temp_dir = $rf_dir . $obj->subfolder($temp_id);
        self::renameDir($obj_temp_dir, $obj_dir);

        $thumbs_dir = self::RFThumbsPath();
        $thumbs_obj_dir = $thumbs_dir . $obj->subfolder($id);
        $thumbs_obj_temp_dir = $thumbs_dir . $obj->subfolder($temp_id);
        self::renameDir($thumbs_obj_temp_dir, $thumbs_obj_dir);
    }
    
    public static function deleteSubfolder($obj) {
        if (!empty($obj)) {
            $rf_dir = self::RFPath();
            $obj_dir = $rf_dir . $obj->subfolder();
            self::rmDir($obj_dir);
            $thumbs_dir = self::RFThumbsPath();
            $thumbs_obj_dir = $thumbs_dir . $obj->subfolder();
            self::rmDir($thumbs_obj_dir);
        }
    }
      
    /**
     * Ключ доступа содержит код доступа, id конференции, id доклада и секретный код
     * и имеет следующую структуру: AXСXXXPXXXSXXXXX.
     * 
     * Access key contains access code, id of the conference, id of the participant
     * and the secret code and has the following structure: AXСXXXPXXXSXXXXX.
     */
    public static function genAccessKey($conf, $participant = NULL) {
        $akey = 'AU';
        if(Yii::app()->authManager->isConfAdmin($conf->id) || Yii::app()->authManager->isAdmin()){
            $akey = 'AA';     
        };
        $akey .= 'C' . $conf->subfolder_id() . 'P';
        if($participant == NULL){
            $akey .= '0';
            RFilemanagerUtils::createSubfolder($conf);
        } else {
            $akey .= $participant->subfolder_id();
            RFilemanagerUtils::createSubfolder($participant);
        };        
        $username = Yii::app()->user->name;
        $salt = uniqid();
        $secret = md5($username . $salt);       
        $akey .= 'S' . $secret;
        $_SESSION[RFilemanagerConsts::$ACCESS_KEYS][] = $akey;
        return $akey;
    }
    
   
    public static function parseAccessKey($akey = NULL){
        if(empty($akey)) return '' ;
        $pattern = '/^A(.+)C(\d+)P(.*)S(.+)$/';
        preg_match($pattern, $akey, $matches);
        $access = $matches[1];
        $conf_id = $matches[2];
        $participant_id = $matches[3];
        $secret = $matches[4];
        return array($access, $conf_id, $participant_id, $secret);
    }
    
}
