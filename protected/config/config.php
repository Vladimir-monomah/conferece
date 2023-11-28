<?php
/**  
 *  Это шаблон конфигурационного файла приложения.
 *  В файле содержатся основные параметры настройки.
 *  Для работы приложения измените расширение файла на .php и исправьте
 *  значения параметров.
 * 
 *  Остальные конфигурационные параметры хранятся в файлах:
 *      main.php (для веб-приложения),
 *      console.php (для запуска консольных команд).
 *  
 *  The file is a template configuration file for yii application.
 *  It contains main configuration parameters.
 *  To start appliaction change its extension to .php and set correct
 *  parameter values.
 *
 *  Other configuration parameters are stored in:
 *      main.php (for web application),
 *      console.php (for console commands). 
 */
return array(
        //  название приложения, русский перевод лежит в файле messages/ru/site.php
        //  application name
        'name' => 'Conferences of the city of Bugulma and BMT',
        'homeUrl' => 'confs/current',

        'components' => array(
                //  параметры подключения к базе данных
                //  options to connect to database
                'db' => array(
                        'connectionString' => 'mysql:host=localhost;dbname=conferece',
                        'username' => 'root',
                        'password' => '',
                ),
        ),

        'params'=>array(
                //  почтовый адрес админа:
                //  1. отображается в подвале
                //  2. используется для уведомления о неполадках с cron
                //  3. используется как обратный при рассылке автоматических уведомлений с сайта
                //  
                //  administrator's email address:
                //  1. is shown in the footer
                //  2. is used to send notification messages about cron errors
                //  3. is used as return address when sending notification messages from website
                'adminEmail' => '',
            
                //  телефон отображается в подвале
                //  phone is displayed in the footer
                'adminPhone' => '',

                //  посылать все письма на этот e-mail (в целях тестирования),
                //  если не указан, то высылается на реальные адреса
                //  
                //  testing mode email address, if it is specified 
                //  all email messages are sent to this email address, 
                //  otherwise to real email addresses
                'testMailTo' => '',

                //Google Analytics Tracker Id
                'GaTrackerId' => '',

                //  для вызова cron через веб нужно использовать адрес:
                //  [адрес приложения]/cron/cronPwd
                //  cronPwd задается здесь и не может быть пустым
                //  
                //  to launch cron via web one should use the following address
                //  [web application address]/cron/cronPwd
                //  cronPwd should not be blank
                'cronPwd' => '',
            
                //  авторизованные пользователи, которые могут создавать конференции (all, admins)
                //  authorized users that are allowed to create conferences (all or admins)
                'usersThatCreateConf' => 'all'               
        ),

        //  текущий язык сайта, здесь настраивается его значение по умолчанию
        //  current website language, here its default value is set
        'language' => 'ru',
    
        'timeZone' => 'Moscow',
        )
?>

