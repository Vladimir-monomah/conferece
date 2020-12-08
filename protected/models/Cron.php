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
class Cron extends CActiveRecord {

    const ID = 1;
    const STATUS_WORKING = 'working';

    protected $status = '';

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{cron}}';
    }

    public function getInstance() {
        $cron = Cron::model()->findByPk(Cron::ID);
        if ($cron == NULL) {
            $cron = new Cron();
            $cron->id = Cron::ID;
            $cron->save();
        } else if ($cron->status == Cron::STATUS_WORKING) {
            //  уведомляем админа о попытке запуска
            //  второго экземпляра крона
            //  notification for administrator about
            //  launching of a second instance
            $mail = new MailMessage();
            $mail->subject = 'The second instance of cron launched.';
            $mail->body = 'There was an attempt to launch the second instance of cron.';
            $mail->emailTo = Yii::app()->params['adminEmail'];
            $mail->send();
            throw new Exception("The second instance of cron launched.");
        }
        return $cron;
    }

    public function run() {
        $this->status = Cron::STATUS_WORKING;
        $this->save();
        
        // инициализируем все новые рассылки
        // starting all new mailing
        $tasks = MailTask::model()->findAllNew();
        foreach ($tasks as $task) {
            $task->perform();
        };
        
        // оправляем позволенный максимум писем
        // sending allowed number of emails
        $sentMessagesCount = 0;
        $tasks = MailTask::model()->findAllStarted();
        foreach ($tasks as $task) {
            $sentMessagesCount += $task->perform();
            if ($sentMessagesCount >= MailTask::MAX_MSGS_COUNT) {
                break;
            };
        };
        
        //  если рассылка не завершена в течение 2 суток, то считаем ее повисшей
        //  if a mailing has not finished during 2 days then consider it hanging
        $tasks = MailTask::model()->findAllHanging();
        foreach ($tasks as $task) {
            $mail = new MailMessage();
            $mail->subject = 'Mailing hangs.';
            $mail->body = 'Mailing with id=' . $task->id . ' hangs.';
            $mail->emailTo = Yii::app()->params['adminEmail'];
            $mail->send();
        };

        $today = DateUtils::today();
        //  удаляем вчерашние временные файлы из temp
        //  deleting outdated temporary files
        $path = FileUtils::tempPath();
        $files = array_diff(scandir($path), array('..', '.', '.hgempty', '.htaccess'));
        foreach ($files as $filename) {
            $filepath = $path . $filename;
            if (is_dir($filepath)) {
                continue;
            };
            $filedate = filemtime($filepath);
            if ($filedate < $today) {
                Yii::log('Cron: ' . $filepath . ' removed', 'info', 'cron');
                @unlink($filepath);
            }
        };
        //  удаляем вчерашние файлы из uploads/export
        //  deleting outdated files from uploads/export
        $path = FileUtils::storagePath() . 'export/';
        $files = array_diff(scandir($path), array('..', '.', '.hgempty', '.htaccess'));
        foreach ($files as $filename) {
            $filepath = $path . $filename;
            if (is_dir($filepath)) {
                continue;
            };
            $filedate = filemtime($filepath);
            if ($filedate < $today) {
                Yii::log('Cron: ' . $filepath . ' removed', 'info', 'cron');
                @unlink($filepath);
            }
        };
        // удаляем временные папки файлового менеджера
        // deleting outdatde files of file manager
        $path = RFilemanagerUtils::RFPath();
        $dirs = array_diff(scandir($path), array('..', '.', '.hgempty', '.htaccess'));
        foreach ($dirs as $dirname) {
            $dirpath = $path . $dirname;
            $thumbspath = RFilemanagerUtils::RFThumbsPath() . $dirname;
            if (is_dir($dirpath)) {
                $dirdate = filemtime($dirpath . '/.');
                if (($dirdate < $today) && (mb_strpos($dirname,'_temp') !== false)) {                 
                    RFilemanagerUtils::rmDir($dirpath);
                    RFilemanagerUtils::rmDir($thumbspath);
                    Yii::log('Cron: ' . $dirpath . ' removed', 'info', 'cron');
                }
            };
        }
        $this->status = '';
        $this->save();
    }

}

?>
