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
class CreateTables extends CDbMigration {

    public function run() {
        $this->safeUp();
    }

    public function safeUp() {
        $this->createUrnTbl();
        $this->createUserTbls();
        $this->createConfTbls();
        $this->createFileTbls();
        $this->createOrgTbls();
        $this->createConfOrgTbls();
        $this->createConfPageTbls();
        $this->createConfAdminTbls();
        $this->createAppFormSettingsTbls();
        $this->createConfTopicTbls();
        $this->createParticipantTbls();
        $this->createAuthorTbls();
        $this->createGuestbookTbls();
        $this->createCommentingTbls();
        $this->createMailingTbls();
        $this->createCronTbls();
        $this->createListTbl();
        $this->createSitePageTbls();
        return true;
    }

    public function safeDown() {
        return true;
    }

    const TABLE_OPTIONS = 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci';

    protected function createUserTbls() {
        //  удаляем таблицы, если они уже существуют
        //  drop tables if exist
        $sql = "drop table if exists {{multilingual_user}}";
        $res = $this->dbConnection->createCommand($sql)->execute();
        $sql = "drop table if exists {{user}}";
        $res = $this->dbConnection->createCommand($sql)->execute();

        //  создание таблицы пользователей
        //  creating users table
        $this->createTable('{{user}}', array(
            'id' => 'pk',
            'email' => 'varchar(255) not null',
            'password' => 'varchar(150) not null',
            'role' => 'varchar(50) not null',
            'registration_date' => 'integer',
            'last_date' => 'integer',
            'last_ip' => 'string',
            'locale' => 'varchar(5)',
            'country' => 'varchar(300)',
            'city' => 'varchar(300)',
            'institution' => 'varchar(900)',
            'institution_address' => 'varchar(450)',
            'position' => 'varchar(450)',
            'academic_degree' => 'varchar(300)',
            'academic_title' => 'varchar(300)',
            'supervisor' => 'varchar(600)',
            'home_address' => 'varchar(450)',
            'phone' => 'varchar(300)',
            'fax' => 'varchar(120)',
            'unique (`email`)'
                ), CreateTables::TABLE_OPTIONS);

        //  создание таблицы с переводами
        //  creating i18n table for users 
        $this->createTable('{{multilingual_user}}', array(
            'user_id' => 'integer not null',
            'language' => 'varchar(5) not null',
            'lastname' => 'varchar(90)',
            'firstname' => 'varchar(90)',
            'middlename' => 'varchar(90)',
            'primary key (`user_id`,`language`)'
                ), CreateTables::TABLE_OPTIONS);

        //  создание внешних ключей
        //  creating foreign keys
        $this->addForeignKey('fk_multilingual_user_user_id', "{{multilingual_user}}", 'user_id', "{{user}}", 'id', 'CASCADE', 'NO ACTION');
    }

    protected function createUrnTbl() {
        //  удаление таблицы
        //  drop table if exist
        $sql = "drop table if exists {{urn}}";
        $res = $this->dbConnection->createCommand($sql)->execute();

        //  создание таблицы веб-адресов сайтов
        //  creating table with reserved iternal web addresses for website
        $this->createTable('{{urn}}', array(
            'urn' => 'varchar(90) not null',
            'unique (`urn`)'
                ), CreateTables::TABLE_OPTIONS
        );
        //  стандартные урлы
        //  adding standard urls
        $cmd = $this->dbConnection->createCommand();
        $urns = array('language', 'login', 'logout', 'about', 'registration',
            'lostpassword', 'users', 'user', 'confs', 'create', 'orgs', 'org');
        $languages = array_keys(Yii::app()->params['languages']);
        foreach ($languages as $language) {
            $urns[] = $language;
        };
        foreach ($urns as $urn) {
            $cmd->insert('{{urn}}', array(
                'urn' => $urn));
        }
    }

    protected function createConfTbls() {

        //  удаление таблиц
        //  drop tables if exist
        $sql = "drop table if exists {{multilingual_conf}}";
        $res = $this->dbConnection->createCommand($sql)->execute();
        $sql = "drop table if exists {{conf}}";
        $res = $this->dbConnection->createCommand($sql)->execute();

        //  создание таблицы конференций
        //  creating conferences table
        $this->createTable('{{conf}}', array(
            'id' => 'pk',
            'is_enabled' => 'boolean',
            'urn' => 'varchar(90) not null',
            'start_date' => 'integer',
            'end_date' => 'integer',
            'registration_end_date' => 'integer',
            'submission_end_date' => 'integer',
            'publication_date' => 'integer',
            'website' => 'varchar(300)',
            'email' => 'varchar(300)',
            'phone' => 'varchar(300)',
            'fax' => 'varchar(300)',
            'creation_date' => 'integer',
            'last_update_date' => 'integer',
            'is_registration_enabled' => 'boolean',
            'is_guestbook_enabled' => 'boolean',
            'is_reviewing_enabled' => 'boolean',
            'is_commenting_enabled' => 'boolean',
            'conf_languages' => 'varchar(60)',
            'file_exts' => 'varchar(200)',
            'participation_types' => 'varchar(100)',
            'participant_editing_option' => 'integer',
            'participant_publishing_option' => 'integer',
            'show_all_participants' => 'boolean',
            'show_images' => 'boolean',), CreateTables::TABLE_OPTIONS);

        //  создание таблицы с переводами
        //  creating i18n table for conferences
        $this->createTable('{{multilingual_conf}}', array(
            'conf_id' => 'integer not null',
            'language' => 'varchar(5) not null',
            'title' => 'varchar(900)',
            'subject' => 'varchar(900)',
            'place' => 'varchar(450)',
            'description' => 'text',
            'fee' => 'text',
            'accommodation' => 'text',
            'committee' => 'text',
            'program' => 'text',
            'report' => 'text',
            'contacts' => 'text',
            'address' => 'varchar(450)',
            'primary key (`conf_id`,`language`)'
                ), CreateTables::TABLE_OPTIONS);

        //  создание внешних ключей
        //  creating foreign keys
        $this->addForeignKey('fk_multilingual_conf_conf_id', "{{multilingual_conf}}", 'conf_id', "{{conf}}", 'id', 'CASCADE', 'NO ACTION');
    }

    protected function createFileTbls() {

        //  удаление таблиц
        //  drop tables if exist
        $sql = "drop table if exists {{multilingual_file}}";
        $res = $this->dbConnection->createCommand($sql)->execute();
        $sql = "drop table if exists {{file}}";
        $res = $this->dbConnection->createCommand($sql)->execute();

        //  создание таблицы файлов
        //  creating table for files
        $this->createTable('{{file}}', array(
            'id' => 'pk',
            'file_type' => 'varchar(20) not null',
            'owner_id' => 'integer not null',
            'owner_class' => 'varchar(150) not null'
                ), CreateTables::TABLE_OPTIONS);

        //  создание таблицы с переводами
        //  creating i18n table for files
        $this->createTable('{{multilingual_file}}', array(
            'file_id' => 'integer not null',
            'language' => 'varchar(5) not null',
            'title' => 'varchar(450)',
            'name' => 'varchar(250)',
            'primary key (`file_id`,`language`)'
                ), CreateTables::TABLE_OPTIONS);

        //  создание внешних ключей
        //  creating foreign keys
        $this->addForeignKey('fk_multilingual_file_file_id', "{{multilingual_file}}", 'file_id', "{{file}}", 'id', 'CASCADE', 'NO ACTION');
    }

    protected function createOrgTbls() {

        //  удаление таблиц
        //  drop tables if exist
        $sql = "drop table if exists {{multilingual_org}}";
        $res = $this->dbConnection->createCommand($sql)->execute();
        $sql = "drop table if exists {{org}}";
        $res = $this->dbConnection->createCommand($sql)->execute();

        //  создание таблицы организаций
        //  creating table for organizations
        $this->createTable('{{org}}', array(
            'id' => 'pk',
            'is_enabled' => 'boolean',
            'urn' => 'varchar(90)', //  max length 30
            'website' => 'varchar(300)', // max length 100
            'email' => 'varchar(300)', //   max length 100
            'phone' => 'varchar(300)',
            'fax' => 'varchar(300)'), CreateTables::TABLE_OPTIONS);

        //  создание таблицы с переводами
        //  creating i18n table for organizations
        $this->createTable('{{multilingual_org}}', array(
            'org_id' => 'integer not null',
            'language' => 'varchar(5) not null',
            'name' => 'text', //    max length 400 (русских символов, russian chars)
            'shortname' => 'varchar(120)', //   max length 40 (русских символов, russian chars)
            'address' => 'varchar(600)', // max length 200 (русских символов, russian chars)
            'primary key (`org_id`,`language`)'
                ), CreateTables::TABLE_OPTIONS);

        //  создание внешних ключей
        //  creating foreign keys
        $this->addForeignKey('fk_multilingual_org_org_id', "{{multilingual_conf}}", 'conf_id', "{{conf}}", 'id', 'CASCADE', 'NO ACTION');
    }

    protected function createConfOrgTbls() {

        //  удаление таблиц
        //  drop tables if exist
        $sql = "drop table if exists {{multilingual_conf_org}}";
        $res = $this->dbConnection->createCommand($sql)->execute();
        $sql = "drop table if exists {{conf_org}}";
        $res = $this->dbConnection->createCommand($sql)->execute();

        //  создание таблицы организаций
        //  creating table for conference organizations
        $this->createTable('{{conf_org}}', array(
            'id' => 'pk',
            'conf_id' => 'integer not null',
            'org_id' => 'integer not null'
                ), CreateTables::TABLE_OPTIONS);

        //  создание таблицы с переводами
        //  creating i18n table for conference organizations
        $this->createTable('{{multilingual_conf_org}}', array(
            'conf_org_id' => 'integer not null',
            'language' => 'varchar(5) not null',
            'sub_org' => 'varchar(450)', // max length 150 русских символов
            'primary key (`conf_org_id`,`language`)'
                ), CreateTables::TABLE_OPTIONS);

        //  создание внешних ключей
        //  creating foreign keys
        $this->addForeignKey('fk_multilingual_conf_org_conf_org_id', "{{multilingual_conf_org}}", 'conf_org_id', "{{conf_org}}", 'id', 'CASCADE', 'NO ACTION');
    }

    protected function createConfPageTbls() {
        $sql = "drop table if exists {{multilingual_conf_page}}";
        $res = $this->dbConnection->createCommand($sql)->execute();
        $sql = "drop table if exists {{conf_page}}";
        $res = $this->dbConnection->createCommand($sql)->execute();

        //  создание таблицы страниц конференции
        //  creating table for additional conference pages
        $this->createTable('{{conf_page}}', array(
            'id' => 'pk',
            'conf_id' => 'integer not null',
            'urn' => 'varchar(60)',
            'next_urn' => 'varchar(60)'), CreateTables::TABLE_OPTIONS);

        //  создание таблицы с переводами
        //  creating i18n table for additional conference pages
        $this->createTable('{{multilingual_conf_page}}', array(
            'conf_page_id' => 'integer not null',
            'language' => 'varchar(5) not null',
            'title' => 'varchar(300)',
            'content' => 'text',
            'primary key (`conf_page_id`,`language`)'
                ), CreateTables::TABLE_OPTIONS);

        //  создание внешних ключей
        //  creating foreign keys
        $this->addForeignKey('fk_multilingual_conf_conf_page_id', "{{multilingual_conf_page}}", 'conf_page_id', "{{conf_page}}", 'id', 'CASCADE', 'NO ACTION');
    }

    protected function createConfAdminTbls() {
        $sql = "drop table if exists {{conf_admin}}";
        $res = $this->dbConnection->createCommand($sql)->execute();

        //  создание таблицы
        $this->createTable('{{conf_admin}}', array(
            'id' => 'pk',
            'conf_id' => 'integer not null',
            'user_id' => 'integer not null'), CreateTables::TABLE_OPTIONS);
    }

    protected function createAppFormSettingsTbls() {
        $sql = "drop table if exists {{multilingual_app_form_settings}}";
        $res = $this->dbConnection->createCommand($sql)->execute();
        $sql = "drop table if exists {{app_form_settings}}";
        $res = $this->dbConnection->createCommand($sql)->execute();

        //  создание таблицы с настройками формы регистрации на конференцию
        //  creating table for conference application form
        $this->createTable('{{app_form_settings}}', array(
            'id' => 'pk',
            'is_lastname_enabled' => 'boolean',
            'is_firstname_enabled' => 'boolean',
            'is_middlename_enabled' => 'boolean',
            'is_org_enabled' => 'boolean',
            'is_org_address_enabled' => 'boolean',
            'is_position_enabled' => 'boolean',
            'is_academic_degree_enabled' => 'boolean',
            'is_academic_title_enabled' => 'boolean',
            'is_supervisor_enabled' => 'boolean',
            'is_country_enabled' => 'boolean',
            'is_city_enabled' => 'boolean',
            'is_address_enabled' => 'boolean',
            'is_phone_enabled' => 'boolean',
            'is_fax_enabled' => 'boolean',
            'is_email_enabled' => 'boolean',
            'is_membership_enabled' => 'boolean',
            'is_annotation_enabled' => 'boolean',
            'is_report_title_enabled' => 'boolean',
            'is_report_topic_enabled' => 'boolean',
            'is_classification_enabled' => 'boolean',
            'is_report_text_enabled' => 'boolean',
            'is_report_file_enabled' => 'boolean',            
            'is_more_info_enabled' => 'boolean',
            'is_accommodation_enabled' => 'boolean',
            'is_image_enabled' => 'boolean',
            'is_lastname_published' => 'boolean',
            'is_firstname_published' => 'boolean',
            'is_middlename_published' => 'boolean',
            'is_org_published' => 'boolean',
            'is_org_address_published' => 'boolean',
            'is_position_published' => 'boolean',
            'is_academic_degree_published' => 'boolean',
            'is_academic_title_published' => 'boolean',
            'is_supervisor_published' => 'boolean',
            'is_country_published' => 'boolean',
            'is_city_published' => 'boolean',
            'is_address_published' => 'boolean',
            'is_phone_published' => 'boolean',
            'is_fax_published' => 'boolean',
            'is_email_published' => 'boolean',
            'is_membership_published' => 'boolean',
            'is_annotation_published' => 'boolean',
            'is_report_title_published' => 'boolean',
            'is_report_topic_published' => 'boolean',
            'is_classification_published' => 'boolean',
            'is_report_text_published' => 'boolean',
            'is_report_file_published' => 'boolean',
            'is_more_info_published' => 'boolean',
            'is_accommodation_published' => 'boolean',
            'is_image_published' => 'boolean',
            'lastname_mandatory' => 'integer',
            'firstname_mandatory' => 'integer',
            'middlename_mandatory' => 'integer',
            'org_mandatory' => 'integer',
            'org_address_mandatory' => 'integer',
            'position_mandatory' => 'integer',
            'academic_degree_mandatory' => 'integer',
            'academic_title_mandatory' => 'integer',
            'supervisor_mandatory' => 'integer',
            'country_mandatory' => 'integer',
            'city_mandatory' => 'integer',
            'address_mandatory' => 'integer',
            'phone_mandatory' => 'integer',
            'fax_mandatory' => 'integer',
            'email_mandatory' => 'integer',
            'membership_mandatory' => 'integer',
            'annotation_mandatory' => 'integer',
            'report_title_mandatory' => 'integer',
            'report_topic_mandatory' => 'integer',
            'classification_mandatory' => 'integer',
            'report_text_mandatory' => 'integer',
            'report_file_mandatory' => 'integer',
            'more_info_mandatory' => 'integer',
            'accommodation_mandatory' => 'integer',
            'image_mandatory' => 'integer',
            //  дополнительные строковые поля
            //  additional string fields
            'is_as_field1_enabled' => 'boolean',
            'is_as_field1_published' => 'boolean',
            'as_field1_type' => 'integer',
            'as_field1_mandatory' => 'integer',
            'is_as_field2_enabled' => 'boolean',
            'is_as_field2_published' => 'boolean',
            'as_field2_type' => 'integer',
            'as_field2_mandatory' => 'integer',
            'is_as_field3_enabled' => 'boolean',
            'is_as_field3_published' => 'boolean',
            'as_field3_type' => 'integer',
            'as_field3_mandatory' => 'integer',
            'is_as_field4_enabled' => 'boolean',
            'is_as_field4_published' => 'boolean',
            'as_field4_type' => 'integer',
            'as_field4_mandatory' => 'integer',
            'is_as_field5_enabled' => 'boolean',
            'is_as_field5_published' => 'boolean',
            'as_field5_type' => 'integer',
            'as_field5_mandatory' => 'integer',
            'is_ps_field1_enabled' => 'boolean',
            'is_ps_field1_published' => 'boolean',
            'ps_field1_type' => 'integer',
            'ps_field1_mandatory' => 'integer',
            'is_ps_field2_enabled' => 'boolean',
            'is_ps_field2_published' => 'boolean',
            'ps_field2_type' => 'integer',
            'ps_field2_mandatory' => 'integer',
            'is_ps_field3_enabled' => 'boolean',
            'is_ps_field3_published' => 'boolean',
            'ps_field3_type' => 'integer',
            'ps_field3_mandatory' => 'integer',
            'is_ps_field4_enabled' => 'boolean',
            'is_ps_field4_published' => 'boolean',
            'ps_field4_type' => 'integer',
            'ps_field4_mandatory' => 'integer',
            'is_ps_field5_enabled' => 'boolean',
            'is_ps_field5_published' => 'boolean',
            'ps_field5_type' => 'integer',
            'ps_field5_mandatory' => 'integer',
            //  дополнительные текстовые поля
            //  additional text fields
            'is_at_field1_enabled' => 'boolean',
            'is_at_field1_published' => 'boolean',
            'at_field1_type' => 'integer',
            'at_field1_mandatory' => 'integer',
            'is_at_field2_enabled' => 'boolean',
            'is_at_field2_published' => 'boolean',
            'at_field2_type' => 'integer',
            'at_field2_mandatory' => 'integer',
            'is_at_field3_enabled' => 'boolean',
            'is_at_field3_published' => 'boolean',
            'at_field3_type' => 'integer',
            'at_field3_mandatory' => 'integer',
            'is_at_field4_enabled' => 'boolean',
            'is_at_field4_published' => 'boolean',
            'at_field4_type' => 'integer',
            'at_field4_mandatory' => 'integer',
            'is_at_field5_enabled' => 'boolean',
            'is_at_field5_published' => 'boolean',
            'at_field5_type' => 'integer',
            'at_field5_mandatory' => 'integer',
            'is_pt_field1_enabled' => 'boolean',
            'is_pt_field1_published' => 'boolean',
            'pt_field1_type' => 'integer',
            'pt_field1_mandatory' => 'integer',
            'is_pt_field2_enabled' => 'boolean',
            'is_pt_field2_published' => 'boolean',
            'pt_field2_type' => 'integer',
            'pt_field2_mandatory' => 'integer',
            'is_pt_field3_enabled' => 'boolean',
            'is_pt_field3_published' => 'boolean',
            'pt_field3_type' => 'integer',
            'pt_field3_mandatory' => 'integer',
            'is_pt_field4_enabled' => 'boolean',
            'is_pt_field4_published' => 'boolean',
            'pt_field4_type' => 'integer',
            'pt_field4_mandatory' => 'integer',
            'is_pt_field5_enabled' => 'boolean',
            'is_pt_field5_published' => 'boolean',
            'pt_field5_type' => 'integer',
            'pt_field5_mandatory' => 'integer',
            //  дополнительные поля-флажки
            //  additional checkbox fields
            'is_ac_field1_enabled' => 'boolean',
            'is_ac_field1_published' => 'boolean',
            'ac_field1_mandatory' => 'boolean',
            'ac_field1_type' => 'integer',
            'is_ac_field2_enabled' => 'boolean',
            'is_ac_field2_published' => 'boolean',
            'ac_field2_mandatory' => 'boolean',
            'ac_field2_type' => 'integer',
            'is_ac_field3_enabled' => 'boolean',
            'is_ac_field3_published' => 'boolean',
            'ac_field3_mandatory' => 'boolean',
            'ac_field3_type' => 'integer',
            'is_ac_field4_enabled' => 'boolean',
            'is_ac_field4_published' => 'boolean',
            'ac_field4_mandatory' => 'boolean',
            'ac_field4_type' => 'integer',
            'is_ac_field5_enabled' => 'boolean',
            'is_ac_field5_published' => 'boolean',
            'ac_field5_mandatory' => 'boolean',
            'ac_field5_type' => 'integer',
            'is_pc_field1_enabled' => 'boolean',
            'is_pc_field1_published' => 'boolean',
            'pc_field1_mandatory' => 'boolean',
            'pc_field1_type' => 'integer',
            'is_pc_field2_enabled' => 'boolean',
            'is_pc_field2_published' => 'boolean',
            'pc_field2_mandatory' => 'boolean',
            'pc_field2_type' => 'integer',
            'is_pc_field3_enabled' => 'boolean',
            'is_pc_field3_published' => 'boolean',
            'pc_field3_mandatory' => 'boolean',
            'pc_field3_type' => 'integer',
            'is_pc_field4_enabled' => 'boolean',
            'is_pc_field4_published' => 'boolean',
            'pc_field4_mandatory' => 'boolean',
            'pc_field4_type' => 'integer',
            'is_pc_field5_enabled' => 'boolean',
            'is_pc_field5_published' => 'boolean',
            'pc_field5_mandatory' => 'boolean',
            'pc_field5_type' => 'integer',
            //  дополнительные поля-списки
            //  additional list fields
            'is_al_field1_enabled' => 'boolean',
            'is_al_field1_published' => 'boolean',
            'al_field1_mandatory' => 'boolean',
            'al_field1_type' => 'integer',
            'al_field1_list_id' => 'varchar(25)',
            'is_al_field2_enabled' => 'boolean',
            'is_al_field2_published' => 'boolean',
            'al_field2_mandatory' => 'boolean',
            'al_field2_type' => 'integer',
            'al_field2_list_id' => 'varchar(25)',
            'is_al_field3_enabled' => 'boolean',
            'is_al_field3_published' => 'boolean',
            'al_field3_mandatory' => 'boolean',
            'al_field3_type' => 'integer',
            'al_field3_list_id' => 'varchar(25)',
            'is_al_field4_enabled' => 'boolean',
            'is_al_field4_published' => 'boolean',
            'al_field4_mandatory' => 'boolean',
            'al_field4_type' => 'integer',
            'al_field4_list_id' => 'varchar(25)',
            'is_al_field5_enabled' => 'boolean',
            'is_al_field5_published' => 'boolean',
            'al_field5_mandatory' => 'boolean',
            'al_field5_type' => 'integer',
            'al_field5_list_id' => 'varchar(25)',
            'is_pl_field1_enabled' => 'boolean',
            'is_pl_field1_published' => 'boolean',
            'pl_field1_mandatory' => 'boolean',
            'pl_field1_type' => 'integer',
            'pl_field1_list_id' => 'varchar(25)',
            'is_pl_field2_enabled' => 'boolean',
            'is_pl_field2_published' => 'boolean',
            'pl_field2_mandatory' => 'boolean',
            'pl_field2_type' => 'integer',
            'pl_field2_list_id' => 'varchar(25)',
            'is_pl_field3_enabled' => 'boolean',
            'is_pl_field3_published' => 'boolean',
            'pl_field3_mandatory' => 'boolean',
            'pl_field3_type' => 'integer',
            'pl_field3_list_id' => 'varchar(25)',
            'is_pl_field4_enabled' => 'boolean',
            'is_pl_field4_published' => 'boolean',
            'pl_field4_mandatory' => 'boolean',
            'pl_field4_type' => 'integer',
            'pl_field4_list_id' => 'varchar(25)',
            'is_pl_field5_enabled' => 'boolean',
            'is_pl_field5_published' => 'boolean',
            'pl_field5_mandatory' => 'boolean',
            'pl_field5_type' => 'integer',
            'pl_field5_list_id' => 'varchar(25)',
                ), CreateTables::TABLE_OPTIONS);


        //  создание таблицы с переводами
        //  creating i18n table for application forms
        $this->createTable('{{multilingual_app_form_settings}}', array(
            'app_form_settings_id' => 'integer not null',
            'language' => 'varchar(5) not null',
            'lastname_hint' => 'text',
            'firstname_hint' => 'text',
            'middlename_hint' => 'text',
            'org_hint' => 'text',
            'org_address_hint' => 'text',
            'position_hint' => 'text',
            'academic_degree_hint' => 'text',
            'academic_title_hint' => 'text',
            'supervisor_hint' => 'text',
            'country_hint' => 'text',
            'city_hint' => 'text',
            'address_hint' => 'text',
            'phone_hint' => 'text',
            'fax_hint' => 'text',
            'email_hint' => 'text',
            'membership_hint' => 'text',
            'annotation_hint' => 'text',
            'report_title_hint' => 'text',
            'report_topic_hint' => 'text',
            'classification_hint' => 'text',
            'report_text_hint' => 'text',
            'report_file_hint' => 'text',
            'more_info_hint' => 'text',
            'accommodation_hint' => 'text',
            'image_hint' => 'text',
            'as_field1_name' => 'text',
            'as_field1_hint' => 'text',
            'as_field2_name' => 'text',
            'as_field2_hint' => 'text',
            'as_field3_name' => 'text',
            'as_field3_hint' => 'text',
            'as_field4_name' => 'text',
            'as_field4_hint' => 'text',
            'as_field5_name' => 'text',
            'as_field5_hint' => 'text',
            'ps_field1_name' => 'text',
            'ps_field1_hint' => 'text',
            'ps_field2_name' => 'text',
            'ps_field2_hint' => 'text',
            'ps_field3_name' => 'text',
            'ps_field3_hint' => 'text',
            'ps_field4_name' => 'text',
            'ps_field4_hint' => 'text',
            'ps_field5_name' => 'text',
            'ps_field5_hint' => 'text',
            'at_field1_name' => 'text',
            'at_field1_hint' => 'text',
            'at_field2_name' => 'text',
            'at_field2_hint' => 'text',
            'at_field3_name' => 'text',
            'at_field3_hint' => 'text',
            'at_field4_name' => 'text',
            'at_field4_hint' => 'text',
            'at_field5_name' => 'text',
            'at_field5_hint' => 'text',
            'pt_field1_name' => 'text',
            'pt_field1_hint' => 'text',
            'pt_field2_name' => 'text',
            'pt_field2_hint' => 'text',
            'pt_field3_name' => 'text',
            'pt_field3_hint' => 'text',
            'pt_field4_name' => 'text',
            'pt_field4_hint' => 'text',
            'pt_field5_name' => 'text',
            'pt_field5_hint' => 'text',
            'ac_field1_name' => 'text',
            'ac_field1_hint' => 'text',
            'ac_field2_name' => 'text',
            'ac_field2_hint' => 'text',
            'ac_field3_name' => 'text',
            'ac_field3_hint' => 'text',
            'ac_field4_name' => 'text',
            'ac_field4_hint' => 'text',
            'ac_field5_name' => 'text',
            'ac_field5_hint' => 'text',
            'pc_field1_name' => 'text',
            'pc_field1_hint' => 'text',
            'pc_field2_name' => 'text',
            'pc_field2_hint' => 'text',
            'pc_field3_name' => 'text',
            'pc_field3_hint' => 'text',
            'pc_field4_name' => 'text',
            'pc_field4_hint' => 'text',
            'pc_field5_name' => 'text',
            'pc_field5_hint' => 'text',
            'al_field1_name' => 'text',
            'al_field1_hint' => 'text',
            'al_field2_name' => 'text',
            'al_field2_hint' => 'text',
            'al_field3_name' => 'text',
            'al_field3_hint' => 'text',
            'al_field4_name' => 'text',
            'al_field4_hint' => 'text',
            'al_field5_name' => 'text',
            'al_field5_hint' => 'text',
            'pl_field1_name' => 'text',
            'pl_field1_hint' => 'text',
            'pl_field2_name' => 'text',
            'pl_field2_hint' => 'text',
            'pl_field3_name' => 'text',
            'pl_field3_hint' => 'text',
            'pl_field4_name' => 'text',
            'pl_field4_hint' => 'text',
            'pl_field5_name' => 'text',
            'pl_field5_hint' => 'text',
            'primary key (`app_form_settings_id`,`language`)'
                ), CreateTables::TABLE_OPTIONS);

        //  создание внешних ключей
        //  creating foreign keys
        $this->addForeignKey('fk_multilingual_app_form_settings_app_form_settings_id', "{{multilingual_app_form_settings}}", 'app_form_settings_id', "{{app_form_settings}}", 'id', 'CASCADE', 'NO ACTION');
    }

    protected function createConfTopicTbls() {
        $sql = "drop table if exists {{multilingual_conf_topic}}";
        $res = $this->dbConnection->createCommand($sql)->execute();
        $sql = "drop table if exists {{conf_topic}}";
        $res = $this->dbConnection->createCommand($sql)->execute();

        //  создание таблицы для секций конференции
        //  creating tanle for conference topic
        $this->createTable('{{conf_topic}}', array(
            'id' => 'pk',
            'conf_id' => 'integer not null',
            'number' => 'integer',
                ), CreateTables::TABLE_OPTIONS);

        //  создание таблицы с переводами
        //  creating i18n table for conference topics
        $this->createTable('{{multilingual_conf_topic}}', array(
            'conf_topic_id' => 'integer not null',
            'language' => 'varchar(5) not null',
            'title' => 'text',
            'scientific_area' => 'varchar(300)',
            'place' => 'text',
            'primary key (`conf_topic_id`,`language`)'
                ), CreateTables::TABLE_OPTIONS);

        //  создание внешних ключей
        //  creating foreign keys
        $this->addForeignKey('fk_multilingual_conf_conf_topic_id', "{{multilingual_conf_topic}}", 'conf_topic_id', "{{conf_topic}}", 'id', 'CASCADE', 'NO ACTION');
    }

    protected function createParticipantTbls() {
        $sql = "drop table if exists {{multilingual_participant}}";
        $res = $this->dbConnection->createCommand($sql)->execute();
        $sql = "drop table if exists {{participant}}";
        $res = $this->dbConnection->createCommand($sql)->execute();

        //  создание таблицы участников
        //  creating table for participants
        $this->createTable('{{participant}}', array(
            'id' => 'pk',
            'conf_id' => 'integer not null',
            'topic_id' => 'integer not null',
            'user_id' => 'integer not null',
            'registration_date' => 'integer',
            'last_update_date' => 'integer',
            'start_date' => 'integer',
            'start_time' => 'integer',
            'status' => 'integer',
            'participation_type' => 'integer',
            'is_accommodation_required' => 'boolean',
            'has_content_file' => 'boolean',
            'classification_code' => 'varchar(60)',
            'pc_field1_value' => 'boolean',
            'pc_field2_value' => 'boolean',
            'pc_field3_value' => 'boolean',
            'pc_field4_value' => 'boolean',
            'pc_field5_value' => 'boolean',
            'pl_field1_value' => 'integer',
            'pl_field2_value' => 'integer',
            'pl_field3_value' => 'integer',
            'pl_field4_value' => 'integer',
            'pl_field5_value' => 'integer',
                ), CreateTables::TABLE_OPTIONS);
        $this->createIndex('CONF_ID_STATUS', '{{participant}}', 'conf_id,status');

        //  создание таблицы с переводами для участников
        //  creating i18n table for participants
        $this->createTable('{{multilingual_participant}}', array(
            'participant_id' => 'integer not null',
            'language' => 'varchar(5) not null',
            'title' => 'varchar(1200)',
            'content' => 'text',
            'annotation' => 'text',
            'information' => 'text',
            'status_reason' => 'text',
            'ps_field1_value' => 'text',
            'ps_field2_value' => 'text',
            'ps_field3_value' => 'text',
            'ps_field4_value' => 'text',
            'ps_field5_value' => 'text',
            'pt_field1_value' => 'text',
            'pt_field2_value' => 'text',
            'pt_field3_value' => 'text',
            'pt_field4_value' => 'text',
            'pt_field5_value' => 'text',
            'primary key (`participant_id`,`language`)'
                ), CreateTables::TABLE_OPTIONS);

        //  создание внешних ключей
        //  creating foreign keys
        $this->addForeignKey('fk_multilingual_participant_participant_id', "{{multilingual_participant}}", 'participant_id', "{{participant}}", 'id', 'CASCADE', 'NO ACTION');
    }

    protected function createAuthorTbls() {
        $sql = "drop table if exists {{multilingual_author}}";
        $res = $this->dbConnection->createCommand($sql)->execute();
        $sql = "drop table if exists {{author}}";
        $res = $this->dbConnection->createCommand($sql)->execute();

        //  создание таблицы авторов
        //  creating table for authors
        $this->createTable('{{author}}', array(
            'id' => 'pk',
            'participant_id' => 'integer not null',
            'email' => 'varchar(300) not null',
            'locale' => 'varchar(5)',
            'phone' => 'varchar(300)',
            'fax' => 'varchar(120)',
            'ac_field1_value' => 'boolean',
            'ac_field2_value' => 'boolean',
            'ac_field3_value' => 'boolean',
            'ac_field4_value' => 'boolean',
            'ac_field5_value' => 'boolean',
            'al_field1_value' => 'integer',
            'al_field2_value' => 'integer',
            'al_field3_value' => 'integer',
            'al_field4_value' => 'integer',
            'al_field5_value' => 'integer',
                ), CreateTables::TABLE_OPTIONS);

        //  создание таблицы с переводами авторов
        //  creating i18n table for authors
        $this->createTable('{{multilingual_author}}', array(
            'author_id' => 'integer not null',
            'language' => 'varchar(5) not null',
            'lastname' => 'varchar(90)',
            'firstname' => 'varchar(90)',
            'middlename' => 'varchar(90)',
            'country' => 'varchar(300)',
            'city' => 'varchar(300)',
            'institution' => 'text',
            'institution_address' => 'varchar(450)',
            'position' => 'varchar(750)',
            'academic_degree' => 'varchar(300)',
            'academic_title' => 'varchar(450)',
            'supervisor' => 'varchar(750)',
            'home_address' => 'varchar(450)',
            'membership' => 'varchar(750)',
            'as_field1_value' => 'text',
            'as_field2_value' => 'text',
            'as_field3_value' => 'text',
            'as_field4_value' => 'text',
            'as_field5_value' => 'text',
            'at_field1_value' => 'text',
            'at_field2_value' => 'text',
            'at_field3_value' => 'text',
            'at_field4_value' => 'text',
            'at_field5_value' => 'text',
            'primary key (`author_id`,`language`)'
                ), CreateTables::TABLE_OPTIONS);

        //  создание внешних ключей
        //  creating foreign keys
        $this->addForeignKey('fk_multilingual_author_author_id', "{{multilingual_author}}", 'author_id', "{{author}}", 'id', 'CASCADE', 'NO ACTION');
    }

    protected function createGuestbookTbls() {
        $sql = "drop table if exists {{guestbook}}";
        $res = $this->dbConnection->createCommand($sql)->execute();

        //  создание таблицы сообщений гостевой книги
        //  creating guestbook table
        $this->createTable('{{guestbook}}', array(
            'id' => 'pk',
            'conf_id' => 'integer not null',
            'date' => 'integer',
            'ip' => 'varchar(100)',
            'name' => 'varchar(100)',
            'email' => 'varchar(300)',
            'message' => 'text',
                ), CreateTables::TABLE_OPTIONS);
    }

    protected function createCommentingTbls() {
        $sql = "drop table if exists {{comment}}";
        $res = $this->dbConnection->createCommand($sql)->execute();
        $sql = "drop table if exists {{commented_item}}";
        $res = $this->dbConnection->createCommand($sql)->execute();

        $this->createTable('{{comment}}', array(
            'id' => 'pk',
            'item_id' => 'integer not null',
            'sub_item_id' => 'char(100) not null',
            'user_id' => 'integer not null',
            'text' => 'text',
            'date' => 'integer not null',
                ), CreateTables::TABLE_OPTIONS);

        $this->createTable('{{commented_item}}', array(
            'item_id' => 'integer not null',
            'sub_item_id' => 'char(100) not null',
            'commented' => 'char(1)',
            'primary key (`item_id`,`sub_item_id`)'
                ), CreateTables::TABLE_OPTIONS);
    }

    protected function createMailingTbls() {
        $sql = "drop table if exists {{mail_task}}";
        $res = $this->dbConnection->createCommand($sql)->execute();

        $this->createTable('{{mail_task}}', array(
            'id' => 'pk',
            'conf_id' => 'integer not null',
            'status' => 'varchar(10)',
            'subject' => 'text',
            'body' => 'text',
            'recipients' => 'varchar(200)',
            'email_from' => 'text',
            'name_from' => 'text',
            'emails' => 'mediumtext',
            'total_count' => 'integer',
            'sent_count' => 'integer',
            'creation_date' => 'integer',
            'completion_date' => 'integer'
                ), CreateTables::TABLE_OPTIONS);
    }

    protected function createCronTbls() {
        $sql = "drop table if exists {{cron}}";
        $res = $this->dbConnection->createCommand($sql)->execute();

        $this->createTable('{{cron}}', array(
            'id' => 'pk',
            'status' => 'varchar(10)'
                ), CreateTables::TABLE_OPTIONS);
    }

    protected function createListTbl() {
        $sql = "drop table if exists {{multilingual_list_item}}";
        $res = $this->dbConnection->createCommand($sql)->execute();
        $sql = "drop table if exists {{list_item}}";
        $res = $this->dbConnection->createCommand($sql)->execute();

        //  создание таблицы дополнительных полей-списков
        //  creating table for additional lis fields
        $this->createTable('{{list_item}}', array(
            'id' => 'pk',
            'num' => 'integer',
            'list_id' => 'varchar(30)'
                ), CreateTables::TABLE_OPTIONS);

        //  создание таблицы с переводами
        //  creating i18n table for additional list fields
        $this->createTable('{{multilingual_list_item}}', array(
            'item_id' => 'integer not null',
            'language' => 'varchar(5) not null',
            'item_value' => 'varchar(600)'), CreateTables::TABLE_OPTIONS
        );

        //  создание внешних ключей
        //  creating foreign keys
        $this->addForeignKey('fk_multilingual_list_item_id', "{{multilingual_list_item}}", 'item_id', "{{list_item}}", 'id', 'CASCADE', 'NO ACTION');
    }

    protected function createSitePageTbls() {
        $sql = "drop table if exists {{multilingual_site_page}}";
        $res = $this->dbConnection->createCommand($sql)->execute();
        $sql = "drop table if exists {{site_page}}";
        $res = $this->dbConnection->createCommand($sql)->execute();

        //  cоздание таблицы для страниц сайта
        //  creatin gtabel for website pages
        $this->createTable('{{site_page}}', array(
            'id' => 'pk',
            'urn' => 'varchar(60)',
            'next_urn' => 'varchar(60)'
                ), CreateTables::TABLE_OPTIONS);

        //  cоздание таблицы с переводами
        //  creating i18n table for websie pages
        $this->createTable('{{multilingual_site_page}}', array(
            'page_id' => 'integer not null',
            'language' => 'varchar(5) not null',
            'title' => 'varchar(600)',
            'content' => 'text'), CreateTables::TABLE_OPTIONS
        );

        //  создание внешних ключей
        //  creating foreign keys
        $this->addForeignKey('fk_multilingual_page_page_id', "{{multilingual_site_page}}", 'page_id', "{{site_page}}", 'id', 'CASCADE', 'NO ACTION');
    }

}

?>
