<?php

/**  
 *  Типы загружаемых файлов:
 *      info_letter — информационное письмо конференции,
 *      text — любой текстовый файл конференции или доклада,
 *      video — видео доклада,
 *      logo — логотип конференции.
 * 
 *  Types of uploaded files:
 *      info_letter — information letter of the conference,
 *      text — any text file,
 *      video — video report,
 *      logo — conference logo or entity image. 
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class FileType {

    const INFO_LETTER = 'info_letter';
    const TEXT = 'text';
    const LOGO = 'logo';
    const PROCEEDINGS = 'proceedings';

}

?>
