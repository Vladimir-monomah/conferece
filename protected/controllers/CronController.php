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
class CronController extends CController {

    function actionIndex() {
        if (isset($_GET['pwd']) &&
                !empty(Yii::app()->params['cronPwd']) &&
                ($_GET['pwd'] == Yii::app()->params['cronPwd'])) {
            echo "Running cron...\n";
            Yii::log('Cron started.', 'info', 'cron');
            $cron = Cron::model()->getInstance();
            $cron->run();
            echo "Cron completed.";
            Yii::log('Cron completed.', 'info', 'cron');
        }
        Yii::app()->end();
    }

}

?>