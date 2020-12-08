<?php

/**
 *  Это команда выполняет тестовое копироваие директории с соблюдением
 *  уникальности имен файлов.
 * 
 *  This command copies files from $srcDir to $destDir making file names
 *  unique and in lowercase.
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class FilesCommand extends CConsoleCommand {

    public function actionImport($srcDir = NULL, $destDir = NULL) {
        Yii::setPathOfAlias('webroot', dirname($_SERVER['SCRIPT_FILENAME']) . DIRECTORY_SEPARATOR . '..');
        if (empty($srcDir)) {
            $srcDir = FileUtils::storagePath();
            ;
        };
        if (empty($destDir)) {
            $destDir = Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR;
        };
        $fileLength = 0;
        $renamed = 0;
        $count = 0;
        if (is_dir($srcDir)) {
            $files = scandir($srcDir);
            echo "Starting importing files. Files count (with directories) = " . count($files) . ".\n";
            foreach ($files as $file) {
                if ($file != "." && $file != ".." && !is_dir($srcDir . $file)) {
                    $newFile = FileUtils::fixUpName($file);
                    if (file_exists($destDir . $newFile)) {
                        echo "\nGenerating new file name for file: $newFile\n";
                        $newFile = FileUtils::uniqueName($file, $destDir);
                        $renames+=1;
                    };
                    $len = strlen($newFile);
                    if ($len > $fileLength) {
                        $fileLength = $len;
                    };
                    $src = "{$srcDir}{$file}";
                    $dest = "{$destDir}{$newFile}";
                    $srclen = strlen($src);
                    $destlen = strlen($dest);
                    if (empty($newFile) || !@copy($src, $dest)) {
                        echo "\nError: could not be copied {$src} into {$dest} ...\n";
                        if (($srclen >= 260) || ($destlen >= 260)) {
                            echo "Possible reason is the limitation for the length of the file path on Windows (260 chars). File src length = {$srclen}, dest length = {$destlen}.\n";
                        };
                    } else {
                        $count++;
                    }
                }
            }
        }
        echo "\n$count files imported.\n";
        echo "Max file name length = " . $fileLength . " bytes.\n";
        echo "Renamed files = " . $renamed;
    }

}

?>
