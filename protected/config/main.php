<?php
/**  
 *  Это главный конфигурационный файл приложения.
 *  В нем содержатся настройки со стандартными значениями, обеспечивающими
 *  работу приложения.
 *  Основные настройки, подлежащие изменению, вынесены в файл config.php.
 *  Файл config.php создается на основе шаблонного файла config.dist.   
 *  
 *  This is the general web application configuration file.
 *  It contains the settings to default values, providing working
 *  application. 
 *  Main settings to be configured are placed in config.php that can be
 *  created from template config.dist file. 
 */
$config = require(dirname(__FILE__) . '/config.php');
$languages = NULL;
if (isset($config['params']['languages'])){
    $languages = $config['params']['languages'];
};
$return  =  CMap::mergeArray(
    array(
            'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
            'homeUrl' => 'confs/current',
            'preload' => array('log'),
            'import' => array(
                'application.models.*',
                'application.models.files.*',
                'application.models.utils.*',
                'application.validators.*',
                'application.components.*',
                'application.behaviors.*',
                'application.widgets.*',
                'application.filters.*'
            ),
            //'catchAllRequest' => array('site/maintenance'),
            'components' => array(
                'request' => array(
                    'enableCsrfValidation' => true,
                ),
                'user' => array(
                    'allowAutoLogin' => true,
                    'loginUrl' => array('/site/login'),
                ),
                'urlManager' => array(
                    'urlFormat' => 'path',
                    'showScriptName' => false,
                    'rules' => array(
                        array(
                            'class' => 'application.components.UrnRule',
                            'connectionID' => 'db',
                        )
                    ),
                ),
                'db' => array(
                    'emulatePrepare' => true,
                    'charset' => 'utf8',
                    'tablePrefix' => 'tbl_',
                    'schemaCachingDuration' => 180, 
                ),
                'session' => array(
                    'autoStart' => true,
                    'timeout' => 43200, //  12 hours
                    'class' => 'CHttpSession'
                ),
                'errorHandler' => array(
                    'errorAction' => 'site/error',
                ),
                //  все логи пишутся в application.log 
                //  all log messages are routed to application.log 
                'log' => array(
                    'class' => 'CLogRouter',
                    'routes' => array(
                        array(
                            'class' => 'CFileLogRoute',
                            'levels' => 'error, info, warning',
                            'maxFileSize' => 500 * 1024, //500 Mb,
                            'maxLogFiles' => 10
                        )
                    ),
                ),
                'authManager' => array(
                    'class' => 'AuthManager',
                    'connectionID' => 'db',
                    'defaultRoles' => array('guest', 'authenticated', 'owner', 'reviewer', 'conf_admin', 'admin'),
                    'assignmentTable' => 'tbl_authassignment',
                    'itemTable' => 'tbl_authitem',
                    'itemChildTable' => 'tbl_authitemchild',
                ),
            ),
            'params' => array(               
                //  языки приложения
                //  application languages
                'languages' => array('ru' => 'Русский', 'en' => 'English', ),
                
                //  подсказки многоязычных полей
                //  hints for multilingual attributes
                'hints' => array('ru' => 'in russian', 'en' => 'in english', ),
                
                'logoExts' => array('jpg', 'gif', 'png'),
                
                //  расширения файлов, которые может прикреплять пользователь
                //  file extensions that are allowed to be uploaded by users
                'fileExts' => array(
                    'doc', 'docx', 'dot', 'pdf', 'rtf', 'tex', 'txt', 'ppt', 'pptx',  // documents 
                    'rar', 'zip',  // archives 
                    'jpg', 'png', 'gif', // images 
                    'mp4', 'webm', 'ogv', 'flv', // video
                    'ogg', 'mp3','wav'), // audio
                
                //'thumbnaleSize' => 150,
                //'confLogoSize' => 270,
                //'userLogoSize' => 270,
                //'authorLogoSize' => 270,
                //'orgLogoSize' => 270,
                
                //  расширения файлов, экспортируемых в dspace
                //  extensions of files exported to dSpace
                'dspaceExportExts' => array('pdf', 'doc', 'docx', 'rtf', 'ps', 'tex', 'zip', 'rar'),
                
                //  ограничение размера картинок, документов и других файлов, загружаемых пользователями, включая медиафайлы
                //  the size limit of files being uploaded by users, including media files
                'userFileSize' => 1024 * 1024 * 200, //200 Мб 
                                  
                //  главный язык сайта, используется для генерации ссылок
                //  на страницы конференции с языковым контекстом 
                //  
                //  website main language, used as default language for construction
                //  of web link with language context to the conference pages
                'mainLanguage' => 'ru',
                
                //  авторизованные пользователи, которые могут создавать конференции (all, admins)
                //  authorized users that are allowed to create conferences (all or admins)
                'usersThatCreateConf' => 'all'
            ),
        
            //  текущий язык сайта, здесь настраивается его значение по умолчанию
            //  website current language, here its default value is set    
            'language' => 'ru',
        
            //  язык исходных текстов приложения (не менять)
            //  application source language (do not change)
            'sourceLanguage' => 'en',
        
            'onBeginRequest' => array('RequestFilter', 'onBeginRequest')
    ), 
   $config
);
if($languages != NULL ){
    $return['params']['languages'] = $languages;
};
return $return;
