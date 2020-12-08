<?php

$config = require(dirname(__FILE__) . '/main.php');
unset($config['theme']);
unset($config['onBeginRequest']);
return CMap::mergeArray(
    array(
            'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
            'preload' => array('log'),
            'import' => array(
                'application.models.*',
                'application.models.files.*',
                'application.models.utils.*',
                'application.validators.*',
                'application.components.*',
                'application.behaviors.*',
                'application.widgets.*',
                'application.filters.*',
                'application.migrations.*'
            ),
            'components' => array(
                'db' => array(
                    'emulatePrepare' => true,
                    'charset' => 'utf8',
                    'tablePrefix' => 'tbl_',
                    'schemaCachingDuration' => 3600,
                ),
                'log' => array(
                    'class' => 'CLogRouter',
                    'routes' => array(
                        array(
                            'class' => 'CFileLogRoute',
                            'levels' => 'error, warning',
                        ),
                        array(
                            'class' => 'CFileLogRoute',
                            'logFile' => 'migration.log',
                        ),
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
            'commandMap' => array(
                'init' => array('class' => 'application.commands.InitCommand'),
                'files' => array('class' => 'application.commands.FilesCommand')),
            'params' => array(
                'languages' => array('ru' => 'Russian', 'en' => 'English', 'es' => 'Spanish'),
            ),
        ), 
    $config
);
