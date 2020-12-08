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
class FileUtils {

    public static $tempFolder = 'temp';
    public static $webFolder = 'uploads';
    public static $storagePathAlias = 'webroot.uploads';
    public static $tempPathAlias = 'webroot.temp';

    public static function storagePath() {
        return Yii::getPathOfAlias(self::$storagePathAlias) . DIRECTORY_SEPARATOR;
    }

    public static function tempPath() {
        return Yii::getPathOfAlias(self::$tempPathAlias) . DIRECTORY_SEPARATOR;
    }
    
    public static function arePathsAvailable(){
        return is_dir(Yii::getPathOfAlias(self::$tempPathAlias)) && is_dir(Yii::getPathOfAlias(self::$storagePathAlias));
    }

    /**  
     *  Преобразует строку в допустимый набор символов.
     * 
     *  Converts a string into valid charset.   
     */
    public static function fixUpName($name) {
        $name = strtolower(FileUtils::translitIt($name));
        return substr($name, 0, 255); 
    }

    public static function uniqueName($name, $path = NULL) {
        $orig_name = $name;
        if (empty($name)) {
            return $name;
        };
        if (empty($path)) {
            $path = FileUtils::storagePath();
        };
        if (!file_exists($path)) {
            return "";
        };
        $name_ext = FileUtils::fixUpName($name);
        $ext = '';
        $i = 0;
        for ($i = (strlen($name_ext) - 1); $i >= 0; $i--) {
            if ($name_ext{$i} == '.')
                break;
            $ext = $name_ext{$i} . $ext;
        }
        $name_ext = mb_substr($name_ext, 0, $i + 1, 'UTF-8') . $ext;
        $name = mb_substr($name_ext, 0, $i);
        if (file_exists($path . htmlspecialchars($name_ext))) {
            $i = 1;
            while (file_exists($path . htmlspecialchars($name_ext))) {
                $name_ext = $name . '_' . $i . '.' . $ext;
                $i++;
            }
        }
        return $name_ext;
    }

    public static function uniqueTempName($name, $path = NULL) {
        if (empty($name)) {
            return $name;
        };
        return FileUtils::uniqueName($name, FileUtils::tempPath());
    }

    public static function translitIt($string) {   
       $converter = array(
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ь' => '\'', 'ы' => 'y', 'ъ' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
            'А' => 'A', 'Б' => 'B', 'В' => 'V',
            'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
            'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
            'И' => 'I', 'Й' => 'Y', 'К' => 'K',
            'Л' => 'L', 'М' => 'M', 'Н' => 'N',
            'О' => 'O', 'П' => 'P', 'Р' => 'R',
            'С' => 'S', 'Т' => 'T', 'У' => 'U',
            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
            'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '',
            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya'
        );
        $string = strtr($string, $converter);
        $res = '';
        for ($i = 0; $i <= (strlen($string) - 1); $i++) {
            $ch = substr($string, $i, 1);
            if (strlen($ch) > 1) {
                $ch = '_';
            };
            $res .= $ch;
        }       
        return iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $res);
    }

    // без перевода в нижний регистр
    // without to lower case
    public static function safeFileName($fileName) {
        $fileName = FileUtils::translitIt($fileName);
        $fileName = str_replace(' ', '_', $fileName);
        $fileName = preg_replace('![^0-9A-Za-z_.-]!', '', $fileName);
        return $fileName;
    }

    public static function getExtension($fileName) {
        $r = '';
        for ($i = (mb_strlen($fileName) - 1); $i >= 0; $i--) {
            if ($fileName{$i} == ".")
                break;
            $r = $fileName{$i} . $r;
        }
        return $r;
    }

    public static function getFileName($fileName) {
        $ext = FileUtils::getExtension($fileName);
        $len = mb_strlen($fileName) - mb_strlen($ext) - 1;
        return mb_strcut($fileName, 0, $len);
    }

    public static function isImage($fileName) {
        return in_array(self::getExtension($fileName), array("png", "jpg", "gif"));
    }

    public static function fileSizeStr($size, $language = 'ru') {
        $fileSizeName = array(Yii::t('site', 'bytes'),
            Yii::t('site', 'KB'), Yii::t('site', 'MB'),
            Yii::t('site', 'GB'), Yii::t('site', 'TB'),
            Yii::t('site', 'PB'), Yii::t('site', 'EB'),
            Yii::t('site', 'ZB'), Yii::t('site', 'YB'));
        return $size ?
                round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $fileSizeName[$i] : '0 ' . Yii::t('site', 'bytes');
    }

    public static function listStr($list, $separator = ', ') {
        $listStr = '';
        if (!is_array($list)) {
            return $list;
        }
        if ($list) {
            $count = count($list);
            if ($count > 1) {
                for ($i = 0; $i < $count - 1; $i++) {
                    $listStr.=$list[$i] . $separator;
                }
            }
            $listStr.=$list[$count - 1];
        }
        return $listStr;
    }
    
}

?>
