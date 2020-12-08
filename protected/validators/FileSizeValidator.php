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
class FileSizeValidator {

    public $size;

    public function validate($file_path = NULL) {
        $size = 0;
        if (!empty($file_path) && file_exists($file_path)) {
            $size = filesize($file_path);
        };
        return ($size <= $this->size);
    }

}

?>
