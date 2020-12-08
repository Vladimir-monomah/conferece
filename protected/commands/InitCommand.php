<?php

/**  
 *  Для создания приложения с пустой базой 
 *  нужно вызвать команду App (см. actionApp).
 * 
 *  To create an application with empty database it is needed
 *  to launch app command (see actionApp).  
 *
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class InitCommand extends CConsoleCommand {
    
    /**  
     *  Команда настраивает пустую БД и создает администратора.
     *  По умолчанию логин и пароль администратора: admin.
     *  Вызов команды: yiic init app.
     * 
     *  The command initializes empty database and creates an administrator.
     *  By default, administrator's email and password equal 'admin'.
     *  To launch this command run: yiic init app.
     */
    public function actionApp() {
        $this->actionDb();
        $this->actionRoles();
        $this->actionAdmin('admin', 'admin');
        $this->actionAbout();
    }

    /**  
     *  Команда инициализирует подсистему авторизации.
     *  Вызов команды: yiic create roles.
     * 
     *  The command initializes authorization system.
     *  To launch this command run: yiic create roles.  
     */
    public function actionRoles() {
        $auth = Yii::app()->authManager;
        $auth->createRoles();
    }

    /**  
     *  Команда создает пустые таблицы в БД.
     * 
     *  The command creates empty tables in database.
     */
    public function actionDb() {
        $cmd = new CreateTables();
        $cmd->run();
    }

    /**  
     *  Команда создает администратора сайта.
     *  Вызов команды: yiic create admin --email=my@email --password=mypassword.
     * 
     *  The command creates the administrator of the website.
     *  To launch the command run: yiic create admin --email=my@email --password=mypassword.   
     */
    public function actionAdmin($email, $password) {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            Yii::app()->db->createCommand()->insert('{{user}}', 
                    array(
                        'email' => $email,
                        'password' => new CDbExpression("password('{$password}')"),
                        'role' => 'admin',
                        'registration_date' => time(),
                        'locale' => 'ru'
                    )
            );
            $user_id =  Yii::app()->db->createCommand("select id from {{user}} where email=:email")->bindValue(':email', $email)->queryScalar();           
            Yii::app()->db->createCommand()->insert('{{multilingual_user}}', 
                    array(
                        'user_id' => $user_id,
                        'language' => 'ru',
                        'lastname' => 'admin',
                        'firstname' => 'admin',
                        'middlename' => 'admin',  
                    )
            );            
            $transaction->commit();
            echo "Administrator created.\n";
        } catch (Exception $e) {
            $transaction->rollback();
            Yii::log("Error when creating administrator.", 'error', 'CreateCommand.actionAdmin');
            throw $e;
        }
    }

    /**  
     *  Команда создает стандартную страницу "О сайте".
     * 
     *  The command creates default page "About".   
     */ 
    protected function actionAbout() {
        $page = new SitePage('insert');
        $page->urn = 'about';
        $page->title = array();
        $page->content = array();
        $languages = Yii::app()->params['languages'];
        foreach ($languages as $language => $name) {
            $page->title[$language] = Yii::t('site', 'About', array(), NULL, $language);
            $content = '';
            $localizedFileName = Yii::app()->findLocalizedFile(Yii::app()->basePath . '/messages/init/about.php', NULL, $language);
            if (!empty($localizedFileName) && file_exists($localizedFileName)) {
                $content = file_get_contents($localizedFileName);
            };
            $page->content[$language] = $content;
        };
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $page->save(false);
            $transaction->commit();
            echo "About page created.\n";
        } catch (Exception $e) {
            $transaction->rollback();
            Yii::log("Error occured when creating About page.", 'error', 'CreateCommand.actionAbout');
            throw $e;
        };
    }

}

?>
