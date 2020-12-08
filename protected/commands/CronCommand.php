<?php
/* * 
 *  Для запуска команды выполните: yiic cron.
 * 
 *  To launch this command run 'yiic cron'. 
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class CronCommand extends CConsoleCommand {

    public function run() {
        try {          
            echo "Running cron...\n";
            Yii::setPathOfAlias('webroot',dirname($_SERVER['SCRIPT_FILENAME']). DIRECTORY_SEPARATOR . '..' );
            $cron = Cron::model()->getInstance();
            $cron->run();
            echo "Cron completed.";
        } catch (Exception $e) {
            Yii::log("Error occured when running cron.", 'error', 'CronCommand.run');
            throw $e;
        }
    }

}

?>
