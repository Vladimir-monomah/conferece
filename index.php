<?php

//  change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yiilite.php';
$config=dirname(__FILE__).'/protected/config/main.php';

//  to enable two themes on different domains
if(($_SERVER['HTTP_HOST'] == 'bmt.conf.bmt-bug.ru') || ($_SERVER['HTTP_HOST'] == 'bmt2020.conf.bmt-bug.ru') || ($_SERVER['HTTP_HOST'] == 'conf2.bmt-bug.ru')){
    $config=dirname(__FILE__).'/protected/config/dev.php';
};

//  remove the following lines when in production mode
//  defined('YII_DEBUG') or define('YII_DEBUG',true);
//  specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

//  php errors handling
define('YII_ENABLE_ERROR_HANDLER', false);
ini_set('display_errors', 'Off');
ini_set('log_errors', 'On');
ini_set('error_log', dirname(__FILE__).'/protected/runtime/php_errors.log');

require_once(dirname(__FILE__) . '/protected/vendors/PHPExcel-1.8/Classes/PHPExcel.php');
require_once($yii);

Yii::createWebApplication($config)->run();
