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
class FileExtValidator {

    public $exts;

    public function validate($file_path = NULL) {
        if (empty($file_path)) {
            return true;
        };
        $this->exts = StringUtils::asArray($this->exts);
        $extension = FileUtils::getExtension($file_path);
        return in_array($extension, $this->exts);
    }

}

?>
