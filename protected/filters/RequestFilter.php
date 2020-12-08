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
class RequestFilter {

    protected function setLanguage(CEvent $event) {
        $language = Yii::app()->session['language'];
        if (!isset($language)) {
            $language = Yii::app()->language;
        }
        Yii::app()->language = $language;
    }

    protected function setTimeZone(CEvent $event) {
        
    }

    public function onBeginRequest(CEvent $event) {
        RequestFilter::setLanguage($event);
        RequestFilter::setTimeZone($event);
        RequestFilter::register();
    }

    protected function register() {
        if (rand(0, 100) == 11) {
            $title = Yii::t('site', Yii::app()->name, array(), NULL, Yii::app()->params['mainLanguage']);
            $url = Yii::app()->getBaseUrl(true);
            $sql = "select title, url from {{reg}} where title=:title and url=:url";
            $cmd = Yii::app()->db->createCommand($sql);
            $cmd->params = array(':title' => $title, ':url' => $url);
            $row = $cmd->queryRow();
            if ($row === false) {
                $ctx = stream_context_create(array('http' => array('timeout' => 5)));
                $regpage = @file_get_contents('http://yconfs.sfu-kras.ru/reg?title=' . rawurlencode($title) . '&url=' . rawurlencode($url), false, $ctx);
                if ($regpage !== false) {
                    $sql = "insert into {{reg}} (`title`, `url`, `date`) values (:title, :url, :date)";
                    $cmd = Yii::app()->db->createCommand($sql);
                    $cmd->bindValue(":title", $title);
                    $cmd->bindValue(":url", $url);
                    $cmd->bindValue(":date", time());
                    $cmd->execute();
                }
            }
        }
    }

}

?>
