/*****************************************************************************/

  Copyright © 2016 Siberian Federal University
 
  Веб-приложение YConfs разработано в Сибирском федеральном университете.
  YConfs является свободно распространяемым программным обеспечением: 
  вы можете распространять и/или модифицировать его согласно условиям
  лицензии GNU General Public License; дополнительную информацию о лицензии
  смотрите на сайте http://yconfs.sfu-kras.ru/license.

/*****************************************************************************/

  СИСТЕМНЫЕ ТРЕБОВАНИЯ

  1. Веб-сервер Apache с включенной поддержкой .htaccess и модулем mod_rewrite.

  2. PHP версии выше 5.2 с библиотекой GD и настройкой почтового сервера. 
     (Протестировано до версии PHP 5.6).

  3. СУБД MySQL с поддержкой InnoDb.

/*****************************************************************************/

  ПОРЯДОК УСТАНОВКИ

  1. Cкопировать папку веб-приложения на серверный компьютер с установленными
     Apache + PHP + MySQL. Предоставить права записи на директории assets, 
     uploads, temp, protected/runtime. 
   
  2. Настроить Virtual Host в Apache на папку веб-приложения.
     Эти настройки выполняются в конфигурационном файле веб-сервера Apache
     (в файле httpd.conf, httpd-vhosts.conf или другом, в зависимости от
     настроек системы).

  3. Создать в MySQL базу данных и пользователя с правами для нее.
     Загрузить в нее схему (дамп базы данных) из файла protected/data/schema.sql. 
    
     Краткая справка по созданию базы данных и пользователя в MySQL.
     Из консоли запустите команду "mysql.exe -u root -p" (имя пользователя 
     может отличаться в вашем случае) и выполните:
     CREATE DATABASE `my_db` CHARACTER SET utf8 COLLATE utf8_general_ci;
     CREATE USER 'my_user'@'localhost' IDENTIFIED BY 'my_password';
     GRANT ALL PRIVILEGES ON my_db.* TO 'my_user'@'localhost';
     exit;
     Вместо my_db укажите желаемое название базы данных, вместо my_user — имя
     нового пользователя, вместо my_password — пароль для него.
     Для загрузки схемы базы данных выполните команду: 
     "mysql.exe -u root -p my_db < schema.sql". 

  4. Настроить конфигурацию приложения: скопируйте файл 
     protected/config/config.dist в файл protected/config/config.php 
     и отредактируйте новый файл.
     Основное, что нужно указать — это название сайта (параметр name) и 
     параметры подключения к базе данных:
     'connectionString' => 'mysql:host=localhost;dbname=my_db',
     'username' => 'my_user',
     'password' => 'my_password'.

  5. Настроить запуск cron (рекомендуется раз в 10 минут):
     a) для вызова cron через веб нужно использовать адрес:
        http://адрес/cron/cronPwd,
        (параметр cronPwd задается в конфигурационном файле);
     б) для вызова cron из командной строки используется команда:
        protected/yiic.php cron.

     В unix-подобной системе выполните команду "crontab -e"
     и добавьте строку (для запуска через HTTP):
     */10 * * * * wget -O /dev/null -q http://адрес/cron/cronPwd
     или строку (для запуска в консольном режиме): 
     */10 * * * * /usr/bin/php /путь_до_каталога_yconfs/protected/yiic.php cron

  Для первоначального доступа к сайту используйте логин и пароль 'admin'.
  Поменяйте учетные данные администратора после первого входа на сайт.

/*****************************************************************************/