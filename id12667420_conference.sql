-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Июн 21 2020 г., 09:44
-- Версия сервера: 10.3.16-MariaDB
-- Версия PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `id12667420_conference`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_app_form_settings`
--

CREATE TABLE `tbl_app_form_settings` (
  `id` int(11) NOT NULL,
  `is_lastname_enabled` tinyint(1) DEFAULT NULL,
  `is_firstname_enabled` tinyint(1) DEFAULT NULL,
  `is_middlename_enabled` tinyint(1) DEFAULT NULL,
  `is_org_enabled` tinyint(1) DEFAULT NULL,
  `is_org_address_enabled` tinyint(1) DEFAULT NULL,
  `is_position_enabled` tinyint(1) DEFAULT NULL,
  `is_academic_degree_enabled` tinyint(1) DEFAULT NULL,
  `is_academic_title_enabled` tinyint(1) DEFAULT NULL,
  `is_supervisor_enabled` tinyint(1) DEFAULT NULL,
  `is_country_enabled` tinyint(1) DEFAULT NULL,
  `is_city_enabled` tinyint(1) DEFAULT NULL,
  `is_address_enabled` tinyint(1) DEFAULT NULL,
  `is_phone_enabled` tinyint(1) DEFAULT NULL,
  `is_fax_enabled` tinyint(1) DEFAULT NULL,
  `is_email_enabled` tinyint(1) DEFAULT NULL,
  `is_membership_enabled` tinyint(1) DEFAULT NULL,
  `is_annotation_enabled` tinyint(1) DEFAULT NULL,
  `is_report_title_enabled` tinyint(1) DEFAULT NULL,
  `is_report_topic_enabled` tinyint(1) DEFAULT NULL,
  `is_classification_enabled` tinyint(1) DEFAULT NULL,
  `is_report_text_enabled` tinyint(1) DEFAULT NULL,
  `is_report_file_enabled` tinyint(1) DEFAULT NULL,
  `is_more_info_enabled` tinyint(1) DEFAULT NULL,
  `is_accommodation_enabled` tinyint(1) DEFAULT NULL,
  `is_image_enabled` tinyint(1) DEFAULT NULL,
  `is_as_field1_enabled` tinyint(1) DEFAULT NULL,
  `is_as_field2_enabled` tinyint(1) DEFAULT NULL,
  `is_as_field3_enabled` tinyint(1) DEFAULT NULL,
  `is_as_field4_enabled` tinyint(1) DEFAULT NULL,
  `is_as_field5_enabled` tinyint(1) DEFAULT NULL,
  `is_ps_field1_enabled` tinyint(1) DEFAULT NULL,
  `is_ps_field2_enabled` tinyint(1) DEFAULT NULL,
  `is_ps_field3_enabled` tinyint(1) DEFAULT NULL,
  `is_ps_field4_enabled` tinyint(1) DEFAULT NULL,
  `is_ps_field5_enabled` tinyint(1) DEFAULT NULL,
  `is_at_field1_enabled` tinyint(1) DEFAULT NULL,
  `is_at_field2_enabled` tinyint(1) DEFAULT NULL,
  `is_at_field3_enabled` tinyint(1) DEFAULT NULL,
  `is_at_field4_enabled` tinyint(1) DEFAULT NULL,
  `is_at_field5_enabled` tinyint(1) DEFAULT NULL,
  `is_pt_field1_enabled` tinyint(1) DEFAULT NULL,
  `is_pt_field2_enabled` tinyint(1) DEFAULT NULL,
  `is_pt_field3_enabled` tinyint(1) DEFAULT NULL,
  `is_pt_field4_enabled` tinyint(1) DEFAULT NULL,
  `is_pt_field5_enabled` tinyint(1) DEFAULT NULL,
  `is_ac_field1_enabled` tinyint(1) DEFAULT NULL,
  `is_ac_field2_enabled` tinyint(1) DEFAULT NULL,
  `is_ac_field3_enabled` tinyint(1) DEFAULT NULL,
  `is_ac_field4_enabled` tinyint(1) DEFAULT NULL,
  `is_ac_field5_enabled` tinyint(1) DEFAULT NULL,
  `is_pc_field1_enabled` tinyint(1) DEFAULT NULL,
  `is_pc_field2_enabled` tinyint(1) DEFAULT NULL,
  `is_pc_field3_enabled` tinyint(1) DEFAULT NULL,
  `is_pc_field4_enabled` tinyint(1) DEFAULT NULL,
  `is_pc_field5_enabled` tinyint(1) DEFAULT NULL,
  `is_al_field1_enabled` tinyint(1) DEFAULT NULL,
  `al_field1_list_id` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_al_field2_enabled` tinyint(1) DEFAULT NULL,
  `al_field2_list_id` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_al_field3_enabled` tinyint(1) DEFAULT NULL,
  `al_field3_list_id` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_al_field4_enabled` tinyint(1) DEFAULT NULL,
  `al_field4_list_id` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_al_field5_enabled` tinyint(1) DEFAULT NULL,
  `al_field5_list_id` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_pl_field1_enabled` tinyint(1) DEFAULT NULL,
  `pl_field1_list_id` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_pl_field2_enabled` tinyint(1) DEFAULT NULL,
  `pl_field2_list_id` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_pl_field3_enabled` tinyint(1) DEFAULT NULL,
  `pl_field3_list_id` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_pl_field4_enabled` tinyint(1) DEFAULT NULL,
  `pl_field4_list_id` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_pl_field5_enabled` tinyint(1) DEFAULT NULL,
  `pl_field5_list_id` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_pf_field1_enabled` tinyint(1) DEFAULT NULL,
  `is_pf_field2_enabled` tinyint(1) DEFAULT NULL,
  `is_pf_field3_enabled` tinyint(1) DEFAULT NULL,
  `is_pf_field4_enabled` tinyint(1) DEFAULT NULL,
  `is_pf_field5_enabled` tinyint(1) DEFAULT NULL,
  `authors_order` int(11) DEFAULT 0,
  `lastname_order` int(11) DEFAULT 0,
  `lastname_wi_paper_mode` int(11) DEFAULT 1,
  `lastname_wo_paper_mode` int(11) DEFAULT 1,
  `is_lastname_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_lastname_wo_paper_published` tinyint(1) DEFAULT 1,
  `firstname_order` int(11) DEFAULT 0,
  `firstname_wi_paper_mode` int(11) DEFAULT 1,
  `firstname_wo_paper_mode` int(11) DEFAULT 1,
  `is_firstname_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_firstname_wo_paper_published` tinyint(1) DEFAULT 1,
  `middlename_order` int(11) DEFAULT 0,
  `middlename_wi_paper_mode` int(11) DEFAULT 1,
  `middlename_wo_paper_mode` int(11) DEFAULT 1,
  `is_middlename_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_middlename_wo_paper_published` tinyint(1) DEFAULT 1,
  `org_order` int(11) DEFAULT 0,
  `org_wi_paper_mode` int(11) DEFAULT 1,
  `org_wo_paper_mode` int(11) DEFAULT 1,
  `is_org_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_org_wo_paper_published` tinyint(1) DEFAULT 1,
  `org_address_order` int(11) DEFAULT 0,
  `org_address_wi_paper_mode` int(11) DEFAULT 1,
  `org_address_wo_paper_mode` int(11) DEFAULT 1,
  `is_org_address_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_org_address_wo_paper_published` tinyint(1) DEFAULT 1,
  `position_order` int(11) DEFAULT 0,
  `position_wi_paper_mode` int(11) DEFAULT 1,
  `position_wo_paper_mode` int(11) DEFAULT 1,
  `is_position_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_position_wo_paper_published` tinyint(1) DEFAULT 1,
  `academic_degree_order` int(11) DEFAULT 0,
  `academic_degree_wi_paper_mode` int(11) DEFAULT 1,
  `academic_degree_wo_paper_mode` int(11) DEFAULT 1,
  `is_academic_degree_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_academic_degree_wo_paper_published` tinyint(1) DEFAULT 1,
  `academic_title_order` int(11) DEFAULT 0,
  `academic_title_wi_paper_mode` int(11) DEFAULT 1,
  `academic_title_wo_paper_mode` int(11) DEFAULT 1,
  `is_academic_title_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_academic_title_wo_paper_published` tinyint(1) DEFAULT 1,
  `supervisor_order` int(11) DEFAULT 0,
  `supervisor_wi_paper_mode` int(11) DEFAULT 1,
  `supervisor_wo_paper_mode` int(11) DEFAULT 1,
  `is_supervisor_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_supervisor_wo_paper_published` tinyint(1) DEFAULT 1,
  `country_order` int(11) DEFAULT 0,
  `country_wi_paper_mode` int(11) DEFAULT 1,
  `country_wo_paper_mode` int(11) DEFAULT 1,
  `is_country_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_country_wo_paper_published` tinyint(1) DEFAULT 1,
  `city_order` int(11) DEFAULT 0,
  `city_wi_paper_mode` int(11) DEFAULT 1,
  `city_wo_paper_mode` int(11) DEFAULT 1,
  `is_city_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_city_wo_paper_published` tinyint(1) DEFAULT 1,
  `address_order` int(11) DEFAULT 0,
  `address_wi_paper_mode` int(11) DEFAULT 1,
  `address_wo_paper_mode` int(11) DEFAULT 1,
  `is_address_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_address_wo_paper_published` tinyint(1) DEFAULT 1,
  `phone_order` int(11) DEFAULT 0,
  `phone_wi_paper_mode` int(11) DEFAULT 1,
  `phone_wo_paper_mode` int(11) DEFAULT 1,
  `is_phone_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_phone_wo_paper_published` tinyint(1) DEFAULT 1,
  `fax_order` int(11) DEFAULT 0,
  `fax_wi_paper_mode` int(11) DEFAULT 1,
  `fax_wo_paper_mode` int(11) DEFAULT 1,
  `is_fax_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_fax_wo_paper_published` tinyint(1) DEFAULT 1,
  `email_order` int(11) DEFAULT 0,
  `email_wi_paper_mode` int(11) DEFAULT 1,
  `email_wo_paper_mode` int(11) DEFAULT 1,
  `is_email_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_email_wo_paper_published` tinyint(1) DEFAULT 1,
  `membership_order` int(11) DEFAULT 0,
  `membership_wi_paper_mode` int(11) DEFAULT 1,
  `membership_wo_paper_mode` int(11) DEFAULT 1,
  `is_membership_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_membership_wo_paper_published` tinyint(1) DEFAULT 1,
  `annotation_order` int(11) DEFAULT 0,
  `annotation_wi_paper_mode` int(11) DEFAULT 1,
  `annotation_wo_paper_mode` int(11) DEFAULT 0,
  `is_annotation_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_annotation_wo_paper_published` tinyint(1) DEFAULT 0,
  `report_title_order` int(11) DEFAULT 0,
  `report_title_wi_paper_mode` int(11) DEFAULT 1,
  `report_title_wo_paper_mode` int(11) DEFAULT 0,
  `is_report_title_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_report_title_wo_paper_published` tinyint(1) DEFAULT 0,
  `report_topic_order` int(11) DEFAULT 0,
  `report_topic_wi_paper_mode` int(11) DEFAULT 1,
  `report_topic_wo_paper_mode` int(11) DEFAULT 0,
  `is_report_topic_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_report_topic_wo_paper_published` tinyint(1) DEFAULT 1,
  `classification_order` int(11) DEFAULT 0,
  `classification_wi_paper_mode` int(11) DEFAULT 1,
  `classification_wo_paper_mode` int(11) DEFAULT 0,
  `is_classification_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_classification_wo_paper_published` tinyint(1) DEFAULT 0,
  `report_text_order` int(11) DEFAULT 0,
  `report_text_wi_paper_mode` int(11) DEFAULT 1,
  `report_text_wo_paper_mode` int(11) DEFAULT 0,
  `is_report_text_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_report_text_wo_paper_published` tinyint(1) DEFAULT 0,
  `report_file_order` int(11) DEFAULT 0,
  `report_file_wi_paper_mode` int(11) DEFAULT 1,
  `report_file_wo_paper_mode` int(11) DEFAULT 0,
  `is_report_file_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_report_file_wo_paper_published` tinyint(1) DEFAULT 0,
  `more_info_order` int(11) DEFAULT 0,
  `more_info_wi_paper_mode` int(11) DEFAULT 1,
  `more_info_wo_paper_mode` int(11) DEFAULT 1,
  `is_more_info_wi_paper_published` tinyint(1) DEFAULT 1,
  `is_more_info_wo_paper_published` tinyint(1) DEFAULT 1,
  `accommodation_order` int(11) DEFAULT 0,
  `accommodation_wi_paper_mode` int(11) DEFAULT 1,
  `accommodation_wo_paper_mode` int(11) DEFAULT 1,
  `is_accommodation_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_accommodation_wo_paper_published` tinyint(1) DEFAULT 0,
  `image_order` int(11) DEFAULT 0,
  `image_wi_paper_mode` int(11) DEFAULT 1,
  `image_wo_paper_mode` int(11) DEFAULT 1,
  `is_image_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_image_wo_paper_published` tinyint(1) DEFAULT 0,
  `ps_field1_order` int(11) DEFAULT 0,
  `ps_field1_wi_paper_mode` int(11) DEFAULT 1,
  `ps_field1_wo_paper_mode` int(11) DEFAULT 1,
  `is_ps_field1_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_ps_field1_wo_paper_published` tinyint(1) DEFAULT 0,
  `ps_field2_order` int(11) DEFAULT 0,
  `ps_field2_wi_paper_mode` int(11) DEFAULT 1,
  `ps_field2_wo_paper_mode` int(11) DEFAULT 1,
  `is_ps_field2_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_ps_field2_wo_paper_published` tinyint(1) DEFAULT 0,
  `ps_field3_order` int(11) DEFAULT 0,
  `ps_field3_wi_paper_mode` int(11) DEFAULT 1,
  `ps_field3_wo_paper_mode` int(11) DEFAULT 1,
  `is_ps_field3_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_ps_field3_wo_paper_published` tinyint(1) DEFAULT 0,
  `ps_field4_order` int(11) DEFAULT 0,
  `ps_field4_wi_paper_mode` int(11) DEFAULT 1,
  `ps_field4_wo_paper_mode` int(11) DEFAULT 1,
  `is_ps_field4_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_ps_field4_wo_paper_published` tinyint(1) DEFAULT 0,
  `ps_field5_order` int(11) DEFAULT 0,
  `ps_field5_wi_paper_mode` int(11) DEFAULT 1,
  `ps_field5_wo_paper_mode` int(11) DEFAULT 1,
  `is_ps_field5_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_ps_field5_wo_paper_published` tinyint(1) DEFAULT 0,
  `as_field1_order` int(11) DEFAULT 0,
  `as_field1_wi_paper_mode` int(11) DEFAULT 1,
  `as_field1_wo_paper_mode` int(11) DEFAULT 1,
  `is_as_field1_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_as_field1_wo_paper_published` tinyint(1) DEFAULT 0,
  `as_field2_order` int(11) DEFAULT 0,
  `as_field2_wi_paper_mode` int(11) DEFAULT 1,
  `as_field2_wo_paper_mode` int(11) DEFAULT 1,
  `is_as_field2_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_as_field2_wo_paper_published` tinyint(1) DEFAULT 0,
  `as_field3_order` int(11) DEFAULT 0,
  `as_field3_wi_paper_mode` int(11) DEFAULT 1,
  `as_field3_wo_paper_mode` int(11) DEFAULT 1,
  `is_as_field3_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_as_field3_wo_paper_published` tinyint(1) DEFAULT 0,
  `as_field4_order` int(11) DEFAULT 0,
  `as_field4_wi_paper_mode` int(11) DEFAULT 1,
  `as_field4_wo_paper_mode` int(11) DEFAULT 1,
  `is_as_field4_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_as_field4_wo_paper_published` tinyint(1) DEFAULT 0,
  `as_field5_order` int(11) DEFAULT 0,
  `as_field5_wi_paper_mode` int(11) DEFAULT 1,
  `as_field5_wo_paper_mode` int(11) DEFAULT 1,
  `is_as_field5_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_as_field5_wo_paper_published` tinyint(1) DEFAULT 0,
  `pt_field1_order` int(11) DEFAULT 0,
  `pt_field1_wi_paper_mode` int(11) DEFAULT 1,
  `pt_field1_wo_paper_mode` int(11) DEFAULT 1,
  `is_pt_field1_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pt_field1_wo_paper_published` tinyint(1) DEFAULT 0,
  `pt_field2_order` int(11) DEFAULT 0,
  `pt_field2_wi_paper_mode` int(11) DEFAULT 1,
  `pt_field2_wo_paper_mode` int(11) DEFAULT 1,
  `is_pt_field2_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pt_field2_wo_paper_published` tinyint(1) DEFAULT 0,
  `pt_field3_order` int(11) DEFAULT 0,
  `pt_field3_wi_paper_mode` int(11) DEFAULT 1,
  `pt_field3_wo_paper_mode` int(11) DEFAULT 1,
  `is_pt_field3_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pt_field3_wo_paper_published` tinyint(1) DEFAULT 0,
  `pt_field4_order` int(11) DEFAULT 0,
  `pt_field4_wi_paper_mode` int(11) DEFAULT 1,
  `pt_field4_wo_paper_mode` int(11) DEFAULT 1,
  `is_pt_field4_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pt_field4_wo_paper_published` tinyint(1) DEFAULT 0,
  `pt_field5_order` int(11) DEFAULT 0,
  `pt_field5_wi_paper_mode` int(11) DEFAULT 1,
  `pt_field5_wo_paper_mode` int(11) DEFAULT 1,
  `is_pt_field5_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pt_field5_wo_paper_published` tinyint(1) DEFAULT 0,
  `at_field1_order` int(11) DEFAULT 0,
  `at_field1_wi_paper_mode` int(11) DEFAULT 1,
  `at_field1_wo_paper_mode` int(11) DEFAULT 1,
  `is_at_field1_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_at_field1_wo_paper_published` tinyint(1) DEFAULT 0,
  `at_field2_order` int(11) DEFAULT 0,
  `at_field2_wi_paper_mode` int(11) DEFAULT 1,
  `at_field2_wo_paper_mode` int(11) DEFAULT 1,
  `is_at_field2_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_at_field2_wo_paper_published` tinyint(1) DEFAULT 0,
  `at_field3_order` int(11) DEFAULT 0,
  `at_field3_wi_paper_mode` int(11) DEFAULT 1,
  `at_field3_wo_paper_mode` int(11) DEFAULT 1,
  `is_at_field3_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_at_field3_wo_paper_published` tinyint(1) DEFAULT 0,
  `at_field4_order` int(11) DEFAULT 0,
  `at_field4_wi_paper_mode` int(11) DEFAULT 1,
  `at_field4_wo_paper_mode` int(11) DEFAULT 1,
  `is_at_field4_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_at_field4_wo_paper_published` tinyint(1) DEFAULT 0,
  `at_field5_order` int(11) DEFAULT 0,
  `at_field5_wi_paper_mode` int(11) DEFAULT 1,
  `at_field5_wo_paper_mode` int(11) DEFAULT 1,
  `is_at_field5_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_at_field5_wo_paper_published` tinyint(1) DEFAULT 0,
  `pc_field1_order` int(11) DEFAULT 0,
  `pc_field1_wi_paper_mode` int(11) DEFAULT 1,
  `pc_field1_wo_paper_mode` int(11) DEFAULT 1,
  `is_pc_field1_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pc_field1_wo_paper_published` tinyint(1) DEFAULT 0,
  `pc_field2_order` int(11) DEFAULT 0,
  `pc_field2_wi_paper_mode` int(11) DEFAULT 1,
  `pc_field2_wo_paper_mode` int(11) DEFAULT 1,
  `is_pc_field2_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pc_field2_wo_paper_published` tinyint(1) DEFAULT 0,
  `pc_field3_order` int(11) DEFAULT 0,
  `pc_field3_wi_paper_mode` int(11) DEFAULT 1,
  `pc_field3_wo_paper_mode` int(11) DEFAULT 1,
  `is_pc_field3_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pc_field3_wo_paper_published` tinyint(1) DEFAULT 0,
  `pc_field4_order` int(11) DEFAULT 0,
  `pc_field4_wi_paper_mode` int(11) DEFAULT 1,
  `pc_field4_wo_paper_mode` int(11) DEFAULT 1,
  `is_pc_field4_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pc_field4_wo_paper_published` tinyint(1) DEFAULT 0,
  `pc_field5_order` int(11) DEFAULT 0,
  `pc_field5_wi_paper_mode` int(11) DEFAULT 1,
  `pc_field5_wo_paper_mode` int(11) DEFAULT 1,
  `is_pc_field5_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pc_field5_wo_paper_published` tinyint(1) DEFAULT 0,
  `ac_field1_order` int(11) DEFAULT 0,
  `ac_field1_wi_paper_mode` int(11) DEFAULT 1,
  `ac_field1_wo_paper_mode` int(11) DEFAULT 1,
  `is_ac_field1_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_ac_field1_wo_paper_published` tinyint(1) DEFAULT 0,
  `ac_field2_order` int(11) DEFAULT 0,
  `ac_field2_wi_paper_mode` int(11) DEFAULT 1,
  `ac_field2_wo_paper_mode` int(11) DEFAULT 1,
  `is_ac_field2_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_ac_field2_wo_paper_published` tinyint(1) DEFAULT 0,
  `ac_field3_order` int(11) DEFAULT 0,
  `ac_field3_wi_paper_mode` int(11) DEFAULT 1,
  `ac_field3_wo_paper_mode` int(11) DEFAULT 1,
  `is_ac_field3_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_ac_field3_wo_paper_published` tinyint(1) DEFAULT 0,
  `ac_field4_order` int(11) DEFAULT 0,
  `ac_field4_wi_paper_mode` int(11) DEFAULT 1,
  `ac_field4_wo_paper_mode` int(11) DEFAULT 1,
  `is_ac_field4_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_ac_field4_wo_paper_published` tinyint(1) DEFAULT 0,
  `ac_field5_order` int(11) DEFAULT 0,
  `ac_field5_wi_paper_mode` int(11) DEFAULT 1,
  `ac_field5_wo_paper_mode` int(11) DEFAULT 1,
  `is_ac_field5_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_ac_field5_wo_paper_published` tinyint(1) DEFAULT 0,
  `pl_field1_order` int(11) DEFAULT 0,
  `pl_field1_wi_paper_mode` int(11) DEFAULT 1,
  `pl_field1_wo_paper_mode` int(11) DEFAULT 1,
  `is_pl_field1_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pl_field1_wo_paper_published` tinyint(1) DEFAULT 0,
  `pl_field2_order` int(11) DEFAULT 0,
  `pl_field2_wi_paper_mode` int(11) DEFAULT 1,
  `pl_field2_wo_paper_mode` int(11) DEFAULT 1,
  `is_pl_field2_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pl_field2_wo_paper_published` tinyint(1) DEFAULT 0,
  `pl_field3_order` int(11) DEFAULT 0,
  `pl_field3_wi_paper_mode` int(11) DEFAULT 1,
  `pl_field3_wo_paper_mode` int(11) DEFAULT 1,
  `is_pl_field3_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pl_field3_wo_paper_published` tinyint(1) DEFAULT 0,
  `pl_field4_order` int(11) DEFAULT 0,
  `pl_field4_wi_paper_mode` int(11) DEFAULT 1,
  `pl_field4_wo_paper_mode` int(11) DEFAULT 1,
  `is_pl_field4_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pl_field4_wo_paper_published` tinyint(1) DEFAULT 0,
  `pl_field5_order` int(11) DEFAULT 0,
  `pl_field5_wi_paper_mode` int(11) DEFAULT 1,
  `pl_field5_wo_paper_mode` int(11) DEFAULT 1,
  `is_pl_field5_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pl_field5_wo_paper_published` tinyint(1) DEFAULT 0,
  `al_field1_order` int(11) DEFAULT 0,
  `al_field1_wi_paper_mode` int(11) DEFAULT 1,
  `al_field1_wo_paper_mode` int(11) DEFAULT 1,
  `is_al_field1_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_al_field1_wo_paper_published` tinyint(1) DEFAULT 0,
  `al_field2_order` int(11) DEFAULT 0,
  `al_field2_wi_paper_mode` int(11) DEFAULT 1,
  `al_field2_wo_paper_mode` int(11) DEFAULT 1,
  `is_al_field2_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_al_field2_wo_paper_published` tinyint(1) DEFAULT 0,
  `al_field3_order` int(11) DEFAULT 0,
  `al_field3_wi_paper_mode` int(11) DEFAULT 1,
  `al_field3_wo_paper_mode` int(11) DEFAULT 1,
  `is_al_field3_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_al_field3_wo_paper_published` tinyint(1) DEFAULT 0,
  `al_field4_order` int(11) DEFAULT 0,
  `al_field4_wi_paper_mode` int(11) DEFAULT 1,
  `al_field4_wo_paper_mode` int(11) DEFAULT 1,
  `is_al_field4_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_al_field4_wo_paper_published` tinyint(1) DEFAULT 0,
  `al_field5_order` int(11) DEFAULT 0,
  `al_field5_wi_paper_mode` int(11) DEFAULT 1,
  `al_field5_wo_paper_mode` int(11) DEFAULT 1,
  `is_al_field5_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_al_field5_wo_paper_published` tinyint(1) DEFAULT 0,
  `pf_field1_order` int(11) DEFAULT 0,
  `pf_field1_wi_paper_mode` int(11) DEFAULT 1,
  `pf_field1_wo_paper_mode` int(11) DEFAULT 1,
  `is_pf_field1_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pf_field1_wo_paper_published` tinyint(1) DEFAULT 0,
  `pf_field2_order` int(11) DEFAULT 0,
  `pf_field2_wi_paper_mode` int(11) DEFAULT 1,
  `pf_field2_wo_paper_mode` int(11) DEFAULT 1,
  `is_pf_field2_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pf_field2_wo_paper_published` tinyint(1) DEFAULT 0,
  `pf_field3_order` int(11) DEFAULT 0,
  `pf_field3_wi_paper_mode` int(11) DEFAULT 1,
  `pf_field3_wo_paper_mode` int(11) DEFAULT 1,
  `is_pf_field3_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pf_field3_wo_paper_published` tinyint(1) DEFAULT 0,
  `pf_field4_order` int(11) DEFAULT 0,
  `pf_field4_wi_paper_mode` int(11) DEFAULT 1,
  `pf_field4_wo_paper_mode` int(11) DEFAULT 1,
  `is_pf_field4_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pf_field4_wo_paper_published` tinyint(1) DEFAULT 0,
  `pf_field5_order` int(11) DEFAULT 0,
  `pf_field5_wi_paper_mode` int(11) DEFAULT 1,
  `pf_field5_wo_paper_mode` int(11) DEFAULT 1,
  `is_pf_field5_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_pf_field5_wo_paper_published` tinyint(1) DEFAULT 0,
  `af_field1_order` int(11) DEFAULT 0,
  `af_field1_wi_paper_mode` int(11) DEFAULT 1,
  `af_field1_wo_paper_mode` int(11) DEFAULT 1,
  `is_af_field1_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_af_field1_wo_paper_published` tinyint(1) DEFAULT 0,
  `af_field2_order` int(11) DEFAULT 0,
  `af_field2_wi_paper_mode` int(11) DEFAULT 1,
  `af_field2_wo_paper_mode` int(11) DEFAULT 1,
  `is_af_field2_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_af_field2_wo_paper_published` tinyint(1) DEFAULT 0,
  `af_field3_order` int(11) DEFAULT 0,
  `af_field3_wi_paper_mode` int(11) DEFAULT 1,
  `af_field3_wo_paper_mode` int(11) DEFAULT 1,
  `is_af_field3_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_af_field3_wo_paper_published` tinyint(1) DEFAULT 0,
  `af_field4_order` int(11) DEFAULT 0,
  `af_field4_wi_paper_mode` int(11) DEFAULT 1,
  `af_field4_wo_paper_mode` int(11) DEFAULT 1,
  `is_af_field4_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_af_field4_wo_paper_published` tinyint(1) DEFAULT 0,
  `af_field5_order` int(11) DEFAULT 0,
  `af_field5_wi_paper_mode` int(11) DEFAULT 1,
  `af_field5_wo_paper_mode` int(11) DEFAULT 1,
  `is_af_field5_wi_paper_published` tinyint(1) DEFAULT 0,
  `is_af_field5_wo_paper_published` tinyint(1) DEFAULT 0,
  `is_af_field1_enabled` tinyint(1) DEFAULT 0,
  `is_af_field2_enabled` tinyint(1) DEFAULT 0,
  `is_af_field3_enabled` tinyint(1) DEFAULT 0,
  `is_af_field4_enabled` tinyint(1) DEFAULT 0,
  `is_af_field5_enabled` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_app_form_settings`
--

INSERT INTO `tbl_app_form_settings` (`id`, `is_lastname_enabled`, `is_firstname_enabled`, `is_middlename_enabled`, `is_org_enabled`, `is_org_address_enabled`, `is_position_enabled`, `is_academic_degree_enabled`, `is_academic_title_enabled`, `is_supervisor_enabled`, `is_country_enabled`, `is_city_enabled`, `is_address_enabled`, `is_phone_enabled`, `is_fax_enabled`, `is_email_enabled`, `is_membership_enabled`, `is_annotation_enabled`, `is_report_title_enabled`, `is_report_topic_enabled`, `is_classification_enabled`, `is_report_text_enabled`, `is_report_file_enabled`, `is_more_info_enabled`, `is_accommodation_enabled`, `is_image_enabled`, `is_as_field1_enabled`, `is_as_field2_enabled`, `is_as_field3_enabled`, `is_as_field4_enabled`, `is_as_field5_enabled`, `is_ps_field1_enabled`, `is_ps_field2_enabled`, `is_ps_field3_enabled`, `is_ps_field4_enabled`, `is_ps_field5_enabled`, `is_at_field1_enabled`, `is_at_field2_enabled`, `is_at_field3_enabled`, `is_at_field4_enabled`, `is_at_field5_enabled`, `is_pt_field1_enabled`, `is_pt_field2_enabled`, `is_pt_field3_enabled`, `is_pt_field4_enabled`, `is_pt_field5_enabled`, `is_ac_field1_enabled`, `is_ac_field2_enabled`, `is_ac_field3_enabled`, `is_ac_field4_enabled`, `is_ac_field5_enabled`, `is_pc_field1_enabled`, `is_pc_field2_enabled`, `is_pc_field3_enabled`, `is_pc_field4_enabled`, `is_pc_field5_enabled`, `is_al_field1_enabled`, `al_field1_list_id`, `is_al_field2_enabled`, `al_field2_list_id`, `is_al_field3_enabled`, `al_field3_list_id`, `is_al_field4_enabled`, `al_field4_list_id`, `is_al_field5_enabled`, `al_field5_list_id`, `is_pl_field1_enabled`, `pl_field1_list_id`, `is_pl_field2_enabled`, `pl_field2_list_id`, `is_pl_field3_enabled`, `pl_field3_list_id`, `is_pl_field4_enabled`, `pl_field4_list_id`, `is_pl_field5_enabled`, `pl_field5_list_id`, `is_pf_field1_enabled`, `is_pf_field2_enabled`, `is_pf_field3_enabled`, `is_pf_field4_enabled`, `is_pf_field5_enabled`, `authors_order`, `lastname_order`, `lastname_wi_paper_mode`, `lastname_wo_paper_mode`, `is_lastname_wi_paper_published`, `is_lastname_wo_paper_published`, `firstname_order`, `firstname_wi_paper_mode`, `firstname_wo_paper_mode`, `is_firstname_wi_paper_published`, `is_firstname_wo_paper_published`, `middlename_order`, `middlename_wi_paper_mode`, `middlename_wo_paper_mode`, `is_middlename_wi_paper_published`, `is_middlename_wo_paper_published`, `org_order`, `org_wi_paper_mode`, `org_wo_paper_mode`, `is_org_wi_paper_published`, `is_org_wo_paper_published`, `org_address_order`, `org_address_wi_paper_mode`, `org_address_wo_paper_mode`, `is_org_address_wi_paper_published`, `is_org_address_wo_paper_published`, `position_order`, `position_wi_paper_mode`, `position_wo_paper_mode`, `is_position_wi_paper_published`, `is_position_wo_paper_published`, `academic_degree_order`, `academic_degree_wi_paper_mode`, `academic_degree_wo_paper_mode`, `is_academic_degree_wi_paper_published`, `is_academic_degree_wo_paper_published`, `academic_title_order`, `academic_title_wi_paper_mode`, `academic_title_wo_paper_mode`, `is_academic_title_wi_paper_published`, `is_academic_title_wo_paper_published`, `supervisor_order`, `supervisor_wi_paper_mode`, `supervisor_wo_paper_mode`, `is_supervisor_wi_paper_published`, `is_supervisor_wo_paper_published`, `country_order`, `country_wi_paper_mode`, `country_wo_paper_mode`, `is_country_wi_paper_published`, `is_country_wo_paper_published`, `city_order`, `city_wi_paper_mode`, `city_wo_paper_mode`, `is_city_wi_paper_published`, `is_city_wo_paper_published`, `address_order`, `address_wi_paper_mode`, `address_wo_paper_mode`, `is_address_wi_paper_published`, `is_address_wo_paper_published`, `phone_order`, `phone_wi_paper_mode`, `phone_wo_paper_mode`, `is_phone_wi_paper_published`, `is_phone_wo_paper_published`, `fax_order`, `fax_wi_paper_mode`, `fax_wo_paper_mode`, `is_fax_wi_paper_published`, `is_fax_wo_paper_published`, `email_order`, `email_wi_paper_mode`, `email_wo_paper_mode`, `is_email_wi_paper_published`, `is_email_wo_paper_published`, `membership_order`, `membership_wi_paper_mode`, `membership_wo_paper_mode`, `is_membership_wi_paper_published`, `is_membership_wo_paper_published`, `annotation_order`, `annotation_wi_paper_mode`, `annotation_wo_paper_mode`, `is_annotation_wi_paper_published`, `is_annotation_wo_paper_published`, `report_title_order`, `report_title_wi_paper_mode`, `report_title_wo_paper_mode`, `is_report_title_wi_paper_published`, `is_report_title_wo_paper_published`, `report_topic_order`, `report_topic_wi_paper_mode`, `report_topic_wo_paper_mode`, `is_report_topic_wi_paper_published`, `is_report_topic_wo_paper_published`, `classification_order`, `classification_wi_paper_mode`, `classification_wo_paper_mode`, `is_classification_wi_paper_published`, `is_classification_wo_paper_published`, `report_text_order`, `report_text_wi_paper_mode`, `report_text_wo_paper_mode`, `is_report_text_wi_paper_published`, `is_report_text_wo_paper_published`, `report_file_order`, `report_file_wi_paper_mode`, `report_file_wo_paper_mode`, `is_report_file_wi_paper_published`, `is_report_file_wo_paper_published`, `more_info_order`, `more_info_wi_paper_mode`, `more_info_wo_paper_mode`, `is_more_info_wi_paper_published`, `is_more_info_wo_paper_published`, `accommodation_order`, `accommodation_wi_paper_mode`, `accommodation_wo_paper_mode`, `is_accommodation_wi_paper_published`, `is_accommodation_wo_paper_published`, `image_order`, `image_wi_paper_mode`, `image_wo_paper_mode`, `is_image_wi_paper_published`, `is_image_wo_paper_published`, `ps_field1_order`, `ps_field1_wi_paper_mode`, `ps_field1_wo_paper_mode`, `is_ps_field1_wi_paper_published`, `is_ps_field1_wo_paper_published`, `ps_field2_order`, `ps_field2_wi_paper_mode`, `ps_field2_wo_paper_mode`, `is_ps_field2_wi_paper_published`, `is_ps_field2_wo_paper_published`, `ps_field3_order`, `ps_field3_wi_paper_mode`, `ps_field3_wo_paper_mode`, `is_ps_field3_wi_paper_published`, `is_ps_field3_wo_paper_published`, `ps_field4_order`, `ps_field4_wi_paper_mode`, `ps_field4_wo_paper_mode`, `is_ps_field4_wi_paper_published`, `is_ps_field4_wo_paper_published`, `ps_field5_order`, `ps_field5_wi_paper_mode`, `ps_field5_wo_paper_mode`, `is_ps_field5_wi_paper_published`, `is_ps_field5_wo_paper_published`, `as_field1_order`, `as_field1_wi_paper_mode`, `as_field1_wo_paper_mode`, `is_as_field1_wi_paper_published`, `is_as_field1_wo_paper_published`, `as_field2_order`, `as_field2_wi_paper_mode`, `as_field2_wo_paper_mode`, `is_as_field2_wi_paper_published`, `is_as_field2_wo_paper_published`, `as_field3_order`, `as_field3_wi_paper_mode`, `as_field3_wo_paper_mode`, `is_as_field3_wi_paper_published`, `is_as_field3_wo_paper_published`, `as_field4_order`, `as_field4_wi_paper_mode`, `as_field4_wo_paper_mode`, `is_as_field4_wi_paper_published`, `is_as_field4_wo_paper_published`, `as_field5_order`, `as_field5_wi_paper_mode`, `as_field5_wo_paper_mode`, `is_as_field5_wi_paper_published`, `is_as_field5_wo_paper_published`, `pt_field1_order`, `pt_field1_wi_paper_mode`, `pt_field1_wo_paper_mode`, `is_pt_field1_wi_paper_published`, `is_pt_field1_wo_paper_published`, `pt_field2_order`, `pt_field2_wi_paper_mode`, `pt_field2_wo_paper_mode`, `is_pt_field2_wi_paper_published`, `is_pt_field2_wo_paper_published`, `pt_field3_order`, `pt_field3_wi_paper_mode`, `pt_field3_wo_paper_mode`, `is_pt_field3_wi_paper_published`, `is_pt_field3_wo_paper_published`, `pt_field4_order`, `pt_field4_wi_paper_mode`, `pt_field4_wo_paper_mode`, `is_pt_field4_wi_paper_published`, `is_pt_field4_wo_paper_published`, `pt_field5_order`, `pt_field5_wi_paper_mode`, `pt_field5_wo_paper_mode`, `is_pt_field5_wi_paper_published`, `is_pt_field5_wo_paper_published`, `at_field1_order`, `at_field1_wi_paper_mode`, `at_field1_wo_paper_mode`, `is_at_field1_wi_paper_published`, `is_at_field1_wo_paper_published`, `at_field2_order`, `at_field2_wi_paper_mode`, `at_field2_wo_paper_mode`, `is_at_field2_wi_paper_published`, `is_at_field2_wo_paper_published`, `at_field3_order`, `at_field3_wi_paper_mode`, `at_field3_wo_paper_mode`, `is_at_field3_wi_paper_published`, `is_at_field3_wo_paper_published`, `at_field4_order`, `at_field4_wi_paper_mode`, `at_field4_wo_paper_mode`, `is_at_field4_wi_paper_published`, `is_at_field4_wo_paper_published`, `at_field5_order`, `at_field5_wi_paper_mode`, `at_field5_wo_paper_mode`, `is_at_field5_wi_paper_published`, `is_at_field5_wo_paper_published`, `pc_field1_order`, `pc_field1_wi_paper_mode`, `pc_field1_wo_paper_mode`, `is_pc_field1_wi_paper_published`, `is_pc_field1_wo_paper_published`, `pc_field2_order`, `pc_field2_wi_paper_mode`, `pc_field2_wo_paper_mode`, `is_pc_field2_wi_paper_published`, `is_pc_field2_wo_paper_published`, `pc_field3_order`, `pc_field3_wi_paper_mode`, `pc_field3_wo_paper_mode`, `is_pc_field3_wi_paper_published`, `is_pc_field3_wo_paper_published`, `pc_field4_order`, `pc_field4_wi_paper_mode`, `pc_field4_wo_paper_mode`, `is_pc_field4_wi_paper_published`, `is_pc_field4_wo_paper_published`, `pc_field5_order`, `pc_field5_wi_paper_mode`, `pc_field5_wo_paper_mode`, `is_pc_field5_wi_paper_published`, `is_pc_field5_wo_paper_published`, `ac_field1_order`, `ac_field1_wi_paper_mode`, `ac_field1_wo_paper_mode`, `is_ac_field1_wi_paper_published`, `is_ac_field1_wo_paper_published`, `ac_field2_order`, `ac_field2_wi_paper_mode`, `ac_field2_wo_paper_mode`, `is_ac_field2_wi_paper_published`, `is_ac_field2_wo_paper_published`, `ac_field3_order`, `ac_field3_wi_paper_mode`, `ac_field3_wo_paper_mode`, `is_ac_field3_wi_paper_published`, `is_ac_field3_wo_paper_published`, `ac_field4_order`, `ac_field4_wi_paper_mode`, `ac_field4_wo_paper_mode`, `is_ac_field4_wi_paper_published`, `is_ac_field4_wo_paper_published`, `ac_field5_order`, `ac_field5_wi_paper_mode`, `ac_field5_wo_paper_mode`, `is_ac_field5_wi_paper_published`, `is_ac_field5_wo_paper_published`, `pl_field1_order`, `pl_field1_wi_paper_mode`, `pl_field1_wo_paper_mode`, `is_pl_field1_wi_paper_published`, `is_pl_field1_wo_paper_published`, `pl_field2_order`, `pl_field2_wi_paper_mode`, `pl_field2_wo_paper_mode`, `is_pl_field2_wi_paper_published`, `is_pl_field2_wo_paper_published`, `pl_field3_order`, `pl_field3_wi_paper_mode`, `pl_field3_wo_paper_mode`, `is_pl_field3_wi_paper_published`, `is_pl_field3_wo_paper_published`, `pl_field4_order`, `pl_field4_wi_paper_mode`, `pl_field4_wo_paper_mode`, `is_pl_field4_wi_paper_published`, `is_pl_field4_wo_paper_published`, `pl_field5_order`, `pl_field5_wi_paper_mode`, `pl_field5_wo_paper_mode`, `is_pl_field5_wi_paper_published`, `is_pl_field5_wo_paper_published`, `al_field1_order`, `al_field1_wi_paper_mode`, `al_field1_wo_paper_mode`, `is_al_field1_wi_paper_published`, `is_al_field1_wo_paper_published`, `al_field2_order`, `al_field2_wi_paper_mode`, `al_field2_wo_paper_mode`, `is_al_field2_wi_paper_published`, `is_al_field2_wo_paper_published`, `al_field3_order`, `al_field3_wi_paper_mode`, `al_field3_wo_paper_mode`, `is_al_field3_wi_paper_published`, `is_al_field3_wo_paper_published`, `al_field4_order`, `al_field4_wi_paper_mode`, `al_field4_wo_paper_mode`, `is_al_field4_wi_paper_published`, `is_al_field4_wo_paper_published`, `al_field5_order`, `al_field5_wi_paper_mode`, `al_field5_wo_paper_mode`, `is_al_field5_wi_paper_published`, `is_al_field5_wo_paper_published`, `pf_field1_order`, `pf_field1_wi_paper_mode`, `pf_field1_wo_paper_mode`, `is_pf_field1_wi_paper_published`, `is_pf_field1_wo_paper_published`, `pf_field2_order`, `pf_field2_wi_paper_mode`, `pf_field2_wo_paper_mode`, `is_pf_field2_wi_paper_published`, `is_pf_field2_wo_paper_published`, `pf_field3_order`, `pf_field3_wi_paper_mode`, `pf_field3_wo_paper_mode`, `is_pf_field3_wi_paper_published`, `is_pf_field3_wo_paper_published`, `pf_field4_order`, `pf_field4_wi_paper_mode`, `pf_field4_wo_paper_mode`, `is_pf_field4_wi_paper_published`, `is_pf_field4_wo_paper_published`, `pf_field5_order`, `pf_field5_wi_paper_mode`, `pf_field5_wo_paper_mode`, `is_pf_field5_wi_paper_published`, `is_pf_field5_wo_paper_published`, `af_field1_order`, `af_field1_wi_paper_mode`, `af_field1_wo_paper_mode`, `is_af_field1_wi_paper_published`, `is_af_field1_wo_paper_published`, `af_field2_order`, `af_field2_wi_paper_mode`, `af_field2_wo_paper_mode`, `is_af_field2_wi_paper_published`, `is_af_field2_wo_paper_published`, `af_field3_order`, `af_field3_wi_paper_mode`, `af_field3_wo_paper_mode`, `is_af_field3_wi_paper_published`, `is_af_field3_wo_paper_published`, `af_field4_order`, `af_field4_wi_paper_mode`, `af_field4_wo_paper_mode`, `is_af_field4_wi_paper_published`, `is_af_field4_wo_paper_published`, `af_field5_order`, `af_field5_wi_paper_mode`, `af_field5_wo_paper_mode`, `is_af_field5_wi_paper_published`, `is_af_field5_wo_paper_published`, `is_af_field1_enabled`, `is_af_field2_enabled`, `is_af_field3_enabled`, `is_af_field4_enabled`, `is_af_field5_enabled`) VALUES
(24, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0, 1, 0, 1, 0, 1, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0', 0, '0', 0, '0', 0, '0', 0, '0', 0, '0', 0, '0', 0, '0', 0, '0', 0, '0', 0, 0, 0, 0, 0, 3, 2, 1, 1, 0, 0, 3, 1, 1, 0, 0, 4, 1, 1, 0, 0, 6, 1, 1, 1, 1, 7, 1, 1, 1, 1, 8, 1, 1, 1, 1, 9, 1, 1, 1, 1, 10, 1, 1, 1, 1, 12, 1, 1, 1, 1, 0, 1, 1, 1, 1, 11, 1, 1, 1, 1, 0, 1, 1, 1, 1, 5, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 1, 1, 4, 1, 0, 1, 0, 2, 1, 0, 1, 0, 1, 1, 0, 1, 1, 0, 1, 0, 1, 0, 0, 1, 0, 1, 0, 5, 1, 0, 1, 0, 0, 1, 1, 1, 1, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_authassignment`
--

CREATE TABLE `tbl_authassignment` (
  `itemname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `userid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `bizrule` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_authitem`
--

CREATE TABLE `tbl_authitem` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `bizrule` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_authitem`
--

INSERT INTO `tbl_authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('accessApplicationPage', 0, 'Access Application Page', 'return Yii::app()->authManager->canAccessApplicationPage($params[\"conf_id\"],$params[\"user_id\"]);', 'N;'),
('admin', 2, 'Administrator', 'return Yii::app()->authManager->isAdmin($params[\"user_id\"]);', 'N;'),
('assignUserRole', 0, 'Assign User`s Role', NULL, 'N;'),
('authenticated', 2, 'Authenticated User', 'return !Yii::app()->user->isGuest;', 'N;'),
('conf_admin', 2, 'Conference Administrator', 'return Yii::app()->authManager->isConfAdmin($params[\"conf_id\"],$params[\"user_id\"]);', 'N;'),
('createComment', 0, 'Create Comment', NULL, 'N;'),
('createConf', 0, 'Create Conference', 'return Yii::app()->authManager->canCreateConf($params[\"user_id\"]);', 'N;'),
('createOrg', 0, 'Create Organization', NULL, 'N;'),
('createParticipant', 0, 'Create Participant/Apply for Participation', 'return Yii::app()->authManager->canCreateParticipant($params[\"conf_id\"]);', 'N;'),
('createUser', 0, 'Create User', NULL, 'N;'),
('editGuestbook', 0, 'Post/delete messages in guestbook', NULL, 'N;'),
('enableComment', 0, 'Enable|Disable Comment', NULL, 'N;'),
('enableConf', 0, 'Enable|Disable Conference', NULL, 'N;'),
('enableParticipant', 0, 'Enable|Disable Participant', NULL, 'N;'),
('exportParticipants', 0, 'Export All Participants', NULL, 'N;'),
('guest', 2, 'Guest', 'return Yii::app()->user->isGuest;', 'N;'),
('listConfs', 0, 'View List of Conferences', NULL, 'N;'),
('listOrgs', 0, 'View List of Orgarizations', NULL, 'N;'),
('listUsers', 0, 'View User List', NULL, 'N;'),
('modifyComment', 0, 'Modify Comment', NULL, 'N;'),
('modifyConf', 0, 'Modify Conference', NULL, 'N;'),
('modifyOrg', 0, 'Modify Organization', NULL, 'N;'),
('modifyParticipant', 0, 'Modify Participant', 'return Yii::app()->authManager->canModifyParticipant($params[\"participant_id\"],$params[\"conf_id\"],$params[\"user_id\"]);', 'N;'),
('modifyParticipantTopic', 0, 'Modify Participant Topic', 'return Yii::app()->authManager->canModifyParticipantTopic($params[\"participant_id\"],$params[\"user_id\"]);', 'N;'),
('modifyUser', 0, 'Modify User', NULL, 'N;'),
('owner', 2, 'Owner Role', 'return Yii::app()->authManager->isOwner($params[\"class\"],$params[\"id\"],$params[\"owner_attr\"],$params[\"user_id\"]);', 'N;'),
('postGuestbook', 0, 'Post messages in guestbook', NULL, 'N;'),
('viewAllParticipants', 0, 'View All Participants', NULL, 'N;'),
('viewApplicationPageLink', 0, 'View Application Page Link', 'return Yii::app()->authManager->canViewApplicationPageLink($params[\"conf_id\"],$params[\"user_id\"]);', 'N;'),
('viewConf', 0, 'View Conference', NULL, 'N;'),
('viewEnabledConf', 0, 'View Enabled Conference', 'return Yii::app()->authManager->isEnabledConf($params[\"conf_id\"]);', 'N;'),
('viewGuestbook', 0, 'View messages in guestbook', NULL, 'N;'),
('viewMyApplicationPage', 0, 'View MyApplication Page', 'return Yii::app()->authManager->canViewMyApplicationPage($params[\"conf_id\"],$params[\"user_id\"]);', 'N;'),
('viewOrg', 0, 'View Organization', NULL, 'N;'),
('viewParticipant', 0, 'View Participant', NULL, 'N;'),
('viewPublishedParticipant', 0, 'View Published Participant', 'return Yii::app()->authManager->isParticipantPublished($params[\"participant_id\"]);', 'N;'),
('viewPublishedParticipants', 0, 'View Published Participants', NULL, 'N;'),
('viewUser', 0, 'View User', NULL, 'N;');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_authitemchild`
--

CREATE TABLE `tbl_authitemchild` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_authitemchild`
--

INSERT INTO `tbl_authitemchild` (`parent`, `child`) VALUES
('admin', 'assignUserRole'),
('admin', 'editGuestbook'),
('admin', 'enableComment'),
('admin', 'enableConf'),
('admin', 'enableParticipant'),
('admin', 'listOrgs'),
('admin', 'listUsers'),
('admin', 'modifyComment'),
('admin', 'modifyConf'),
('admin', 'modifyOrg'),
('admin', 'modifyParticipant'),
('admin', 'modifyParticipantTopic'),
('admin', 'modifyUser'),
('admin', 'viewAllParticipants'),
('admin', 'viewParticipant'),
('admin', 'viewUser'),
('authenticated', 'accessApplicationPage'),
('authenticated', 'createComment'),
('authenticated', 'createConf'),
('authenticated', 'createOrg'),
('authenticated', 'createParticipant'),
('authenticated', 'listConfs'),
('authenticated', 'postGuestbook'),
('authenticated', 'viewApplicationPageLink'),
('authenticated', 'viewEnabledConf'),
('authenticated', 'viewMyApplicationPage'),
('authenticated', 'viewOrg'),
('authenticated', 'viewPublishedParticipant'),
('authenticated', 'viewPublishedParticipants'),
('conf_admin', 'editGuestbook'),
('conf_admin', 'enableComment'),
('conf_admin', 'enableParticipant'),
('conf_admin', 'modifyComment'),
('conf_admin', 'modifyConf'),
('conf_admin', 'modifyParticipant'),
('conf_admin', 'modifyParticipantTopic'),
('conf_admin', 'viewAllParticipants'),
('conf_admin', 'viewParticipant'),
('exportParticipants', 'viewAllParticipants'),
('guest', 'accessApplicationPage'),
('guest', 'createParticipant'),
('guest', 'createUser'),
('guest', 'listConfs'),
('guest', 'viewApplicationPageLink'),
('guest', 'viewEnabledConf'),
('guest', 'viewGuestbook'),
('guest', 'viewOrg'),
('guest', 'viewPublishedParticipant'),
('guest', 'viewPublishedParticipants'),
('modifyConf', 'viewConf'),
('owner', 'modifyComment'),
('owner', 'modifyParticipant'),
('owner', 'modifyParticipantTopic'),
('owner', 'modifyUser'),
('owner', 'viewParticipant'),
('owner', 'viewUser'),
('viewEnabledConf', 'viewConf');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_author`
--

CREATE TABLE `tbl_author` (
  `id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `email` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ac_field1_value` tinyint(1) DEFAULT NULL,
  `ac_field2_value` tinyint(1) DEFAULT NULL,
  `ac_field3_value` tinyint(1) DEFAULT NULL,
  `ac_field4_value` tinyint(1) DEFAULT NULL,
  `ac_field5_value` tinyint(1) DEFAULT NULL,
  `al_field1_value` int(11) DEFAULT NULL,
  `al_field2_value` int(11) DEFAULT NULL,
  `al_field3_value` int(11) DEFAULT NULL,
  `al_field4_value` int(11) DEFAULT NULL,
  `al_field5_value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_author`
--

INSERT INTO `tbl_author` (`id`, `participant_id`, `email`, `locale`, `phone`, `fax`, `ac_field1_value`, `ac_field2_value`, `ac_field3_value`, `ac_field4_value`, `ac_field5_value`, `al_field1_value`, `al_field2_value`, `al_field3_value`, `al_field4_value`, `al_field5_value`) VALUES
(1, 1, 'ivanov@mail.ru', 'ru', '9874561239', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_comment`
--

CREATE TABLE `tbl_comment` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `sub_item_id` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_commented_item`
--

CREATE TABLE `tbl_commented_item` (
  `item_id` int(11) NOT NULL,
  `sub_item_id` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `commented` char(1) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_conf`
--

CREATE TABLE `tbl_conf` (
  `id` int(11) NOT NULL,
  `is_enabled` tinyint(1) DEFAULT NULL,
  `urn` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` int(11) DEFAULT NULL,
  `end_date` int(11) DEFAULT NULL,
  `registration_end_date` int(11) DEFAULT NULL,
  `submission_end_date` int(11) DEFAULT NULL,
  `publication_date` int(11) DEFAULT NULL,
  `website` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `is_registration_enabled` tinyint(1) DEFAULT NULL,
  `is_guestbook_enabled` tinyint(1) DEFAULT NULL,
  `is_reviewing_enabled` tinyint(1) DEFAULT NULL,
  `is_commenting_enabled` tinyint(1) DEFAULT NULL,
  `conf_languages` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_exts` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `participation_types` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `participant_editing_option` int(11) DEFAULT NULL,
  `participant_publishing_option` int(11) DEFAULT NULL,
  `show_all_participants` tinyint(1) DEFAULT NULL,
  `show_images` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_conf`
--

INSERT INTO `tbl_conf` (`id`, `is_enabled`, `urn`, `start_date`, `end_date`, `registration_end_date`, `submission_end_date`, `publication_date`, `website`, `email`, `phone`, `fax`, `creation_date`, `last_update_date`, `is_registration_enabled`, `is_guestbook_enabled`, `is_reviewing_enabled`, `is_commenting_enabled`, `conf_languages`, `file_exts`, `participation_types`, `participant_editing_option`, `participant_publishing_option`, `show_all_participants`, `show_images`) VALUES
(1, 1, '', 1585094400, 1585612800, 1584489600, 1584748800, 1583784000, 'http://bumate.ru/', 'info@bumate.ru', '8(85594) 9-11-16, 9-10-86 ', '', 1583169343, 1586370796, 1, 0, NULL, 1, 'ru;', '', '1;', 0, 0, 1, 0),
(22, 0, '', 1586563200, 1587254400, NULL, NULL, NULL, '', '', '', '', 1587304440, 1587304440, NULL, NULL, NULL, NULL, 'ru;', '', '1;', 1, 0, 0, 0),
(23, 0, '', 1587168000, 1587772800, NULL, NULL, NULL, '', '', '', '', 1587304860, 1587304860, NULL, NULL, NULL, NULL, 'ru;', '', '1;', 1, 0, 0, 0),
(24, 1, '', 1587254400, 1587772800, 1587859200, 1587859200, 1587859200, 'htpp.//bumate.ru', 'abzalova1974@list.com', '89274542453', '', 1587305180, 1587305477, 1, 1, NULL, 1, 'ru;en;', '', '1;13;', 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_conf_admin`
--

CREATE TABLE `tbl_conf_admin` (
  `id` int(11) NOT NULL,
  `conf_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_conf_admin`
--

INSERT INTO `tbl_conf_admin` (`id`, `conf_id`, `user_id`) VALUES
(1, 1, 2),
(22, 22, 2),
(23, 23, 2),
(24, 24, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_conf_org`
--

CREATE TABLE `tbl_conf_org` (
  `id` int(11) NOT NULL,
  `conf_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_conf_org`
--

INSERT INTO `tbl_conf_org` (`id`, `conf_id`, `org_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_conf_page`
--

CREATE TABLE `tbl_conf_page` (
  `id` int(11) NOT NULL,
  `conf_id` int(11) NOT NULL,
  `urn` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `next_urn` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_conf_topic`
--

CREATE TABLE `tbl_conf_topic` (
  `id` int(11) NOT NULL,
  `conf_id` int(11) NOT NULL,
  `number` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_cron`
--

CREATE TABLE `tbl_cron` (
  `id` int(11) NOT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_file`
--

CREATE TABLE `tbl_file` (
  `id` int(11) NOT NULL,
  `file_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `owner_id` int(11) NOT NULL,
  `owner_class` varchar(150) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_file`
--

INSERT INTO `tbl_file` (`id`, `file_type`, `owner_id`, `owner_class`) VALUES
(1, 'text', 1, 'Participant'),
(34, 'logo', 24, 'Conf'),
(35, 'info_letter', 24, 'Conf');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_guestbook`
--

CREATE TABLE `tbl_guestbook` (
  `id` int(11) NOT NULL,
  `conf_id` int(11) NOT NULL,
  `date` int(11) DEFAULT NULL,
  `ip` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_list_item`
--

CREATE TABLE `tbl_list_item` (
  `id` int(11) NOT NULL,
  `num` int(11) DEFAULT NULL,
  `list_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_mail_task`
--

CREATE TABLE `tbl_mail_task` (
  `id` int(11) NOT NULL,
  `conf_id` int(11) NOT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `recipients` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_from` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `name_from` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `emails` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `total_count` int(11) DEFAULT NULL,
  `skip_count` int(11) DEFAULT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `completion_date` int(11) DEFAULT NULL,
  `participant_id` int(11) NOT NULL,
  `participants` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `error_statistics` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `success_statistics` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_mail_task`
--

INSERT INTO `tbl_mail_task` (`id`, `conf_id`, `status`, `subject`, `body`, `recipients`, `email_from`, `name_from`, `emails`, `total_count`, `skip_count`, `creation_date`, `completion_date`, `participant_id`, `participants`, `error_statistics`, `success_statistics`) VALUES
(1, 1, 'new', 'Conferences of the city of Bugulma and BMT. ', '<p><br /><br /><br />Организационный комитет конференции <a href=\"\">&laquo;Будущее.Молодость.Технологии.&raquo;</a>.</p>\r\n<div class=\"\" style=\"\">&nbsp;</div>', 'all', 'info@bumate.ru', 'Организационный комитет конференции «Будущее.Молодость.Технологии.».', NULL, NULL, NULL, 1583920511, NULL, 0, '43:1:ru: Иван Иванович Иванов <ivanov@mail.ru>', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_migration`
--

CREATE TABLE `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1575953856),
('m160414_061302_create_reg_table', 1575953862),
('m160530_070606_add_menu_title', 1575953863),
('m171020_071907_add_additional_file_fields', 1575953874),
('m171023_041624_remove_redundant_columns', 1575953891),
('m171102_080702_update_application_form_settings', 1575954084),
('m180126_091956_add_participant_edit_language', 1575954085),
('m180301_075353_rename_page_tables', 1575954085),
('m180306_041808_rename_conf_section_tables', 1575954085),
('m180315_065817_update_mail_task', 1575954086),
('m180409_082931_update_mail_task', 1575954087),
('m190911_055709_participant_add_creator', 1575954087);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_multilingual_app_form_settings`
--

CREATE TABLE `tbl_multilingual_app_form_settings` (
  `app_form_settings_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `lastname_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `middlename_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `org_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `org_address_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `position_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `academic_degree_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `academic_title_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `supervisor_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `city_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `membership_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `annotation_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `report_title_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `report_topic_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `classification_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `report_text_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `report_file_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `more_info_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `accommodation_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `image_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `as_field1_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `as_field1_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `as_field2_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `as_field2_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `as_field3_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `as_field3_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `as_field4_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `as_field4_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `as_field5_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `as_field5_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ps_field1_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ps_field1_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ps_field2_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ps_field2_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ps_field3_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ps_field3_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ps_field4_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ps_field4_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ps_field5_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ps_field5_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `at_field1_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `at_field1_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `at_field2_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `at_field2_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `at_field3_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `at_field3_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `at_field4_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `at_field4_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `at_field5_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `at_field5_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pt_field1_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pt_field1_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pt_field2_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pt_field2_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pt_field3_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pt_field3_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pt_field4_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pt_field4_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pt_field5_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pt_field5_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ac_field1_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ac_field1_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ac_field2_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ac_field2_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ac_field3_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ac_field3_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ac_field4_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ac_field4_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ac_field5_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ac_field5_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pc_field1_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pc_field1_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pc_field2_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pc_field2_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pc_field3_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pc_field3_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pc_field4_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pc_field4_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pc_field5_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pc_field5_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `al_field1_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `al_field1_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `al_field2_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `al_field2_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `al_field3_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `al_field3_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `al_field4_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `al_field4_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `al_field5_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `al_field5_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pl_field1_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pl_field1_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pl_field2_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pl_field2_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pl_field3_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pl_field3_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pl_field4_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pl_field4_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pl_field5_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pl_field5_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_field1_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_field1_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_field2_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_field2_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_field3_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_field3_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_field4_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_field4_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_field5_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_field5_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `af_field1_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `af_field1_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `af_field2_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `af_field2_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `af_field3_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `af_field3_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `af_field4_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `af_field4_hint` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `af_field5_name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `af_field5_hint` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_multilingual_app_form_settings`
--

INSERT INTO `tbl_multilingual_app_form_settings` (`app_form_settings_id`, `language`, `lastname_hint`, `firstname_hint`, `middlename_hint`, `org_hint`, `org_address_hint`, `position_hint`, `academic_degree_hint`, `academic_title_hint`, `supervisor_hint`, `country_hint`, `city_hint`, `address_hint`, `phone_hint`, `fax_hint`, `email_hint`, `membership_hint`, `annotation_hint`, `report_title_hint`, `report_topic_hint`, `classification_hint`, `report_text_hint`, `report_file_hint`, `more_info_hint`, `accommodation_hint`, `image_hint`, `as_field1_name`, `as_field1_hint`, `as_field2_name`, `as_field2_hint`, `as_field3_name`, `as_field3_hint`, `as_field4_name`, `as_field4_hint`, `as_field5_name`, `as_field5_hint`, `ps_field1_name`, `ps_field1_hint`, `ps_field2_name`, `ps_field2_hint`, `ps_field3_name`, `ps_field3_hint`, `ps_field4_name`, `ps_field4_hint`, `ps_field5_name`, `ps_field5_hint`, `at_field1_name`, `at_field1_hint`, `at_field2_name`, `at_field2_hint`, `at_field3_name`, `at_field3_hint`, `at_field4_name`, `at_field4_hint`, `at_field5_name`, `at_field5_hint`, `pt_field1_name`, `pt_field1_hint`, `pt_field2_name`, `pt_field2_hint`, `pt_field3_name`, `pt_field3_hint`, `pt_field4_name`, `pt_field4_hint`, `pt_field5_name`, `pt_field5_hint`, `ac_field1_name`, `ac_field1_hint`, `ac_field2_name`, `ac_field2_hint`, `ac_field3_name`, `ac_field3_hint`, `ac_field4_name`, `ac_field4_hint`, `ac_field5_name`, `ac_field5_hint`, `pc_field1_name`, `pc_field1_hint`, `pc_field2_name`, `pc_field2_hint`, `pc_field3_name`, `pc_field3_hint`, `pc_field4_name`, `pc_field4_hint`, `pc_field5_name`, `pc_field5_hint`, `al_field1_name`, `al_field1_hint`, `al_field2_name`, `al_field2_hint`, `al_field3_name`, `al_field3_hint`, `al_field4_name`, `al_field4_hint`, `al_field5_name`, `al_field5_hint`, `pl_field1_name`, `pl_field1_hint`, `pl_field2_name`, `pl_field2_hint`, `pl_field3_name`, `pl_field3_hint`, `pl_field4_name`, `pl_field4_hint`, `pl_field5_name`, `pl_field5_hint`, `pf_field1_name`, `pf_field1_hint`, `pf_field2_name`, `pf_field2_hint`, `pf_field3_name`, `pf_field3_hint`, `pf_field4_name`, `pf_field4_hint`, `pf_field5_name`, `pf_field5_hint`, `af_field1_name`, `af_field1_hint`, `af_field2_name`, `af_field2_hint`, `af_field3_name`, `af_field3_hint`, `af_field4_name`, `af_field4_hint`, `af_field5_name`, `af_field5_hint`) VALUES
(24, 'en', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(24, 'ru', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_multilingual_author`
--

CREATE TABLE `tbl_multilingual_author` (
  `author_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middlename` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `institution` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `institution_address` varchar(450) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` varchar(750) COLLATE utf8_unicode_ci DEFAULT NULL,
  `academic_degree` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `academic_title` varchar(450) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supervisor` varchar(750) COLLATE utf8_unicode_ci DEFAULT NULL,
  `home_address` varchar(450) COLLATE utf8_unicode_ci DEFAULT NULL,
  `membership` varchar(750) COLLATE utf8_unicode_ci DEFAULT NULL,
  `as_field1_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `as_field2_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `as_field3_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `as_field4_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `as_field5_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `at_field1_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `at_field2_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `at_field3_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `at_field4_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `at_field5_value` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_multilingual_author`
--

INSERT INTO `tbl_multilingual_author` (`author_id`, `language`, `lastname`, `firstname`, `middlename`, `country`, `city`, `institution`, `institution_address`, `position`, `academic_degree`, `academic_title`, `supervisor`, `home_address`, `membership`, `as_field1_value`, `as_field2_value`, `as_field3_value`, `as_field4_value`, `as_field5_value`, `at_field1_value`, `at_field2_value`, `at_field3_value`, `at_field4_value`, `at_field5_value`) VALUES
(1, 'en', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1, 'ru', 'Иванов', 'Иван', 'Иванович', 'Россия', 'Бугульма', 'БИПТ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_multilingual_conf`
--

CREATE TABLE `tbl_multilingual_conf` (
  `conf_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(900) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(900) COLLATE utf8_unicode_ci DEFAULT NULL,
  `place` varchar(450) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `fee` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `accommodation` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `committee` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `program` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `report` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `contacts` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(450) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_title` varchar(900) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_multilingual_conf`
--

INSERT INTO `tbl_multilingual_conf` (`conf_id`, `language`, `title`, `subject`, `place`, `description`, `fee`, `accommodation`, `committee`, `program`, `report`, `contacts`, `address`, `menu_title`) VALUES
(1, 'en', '', '', '', '', '', '', '', '', '', '', '', ''),
(1, 'ru', 'Будущее.Молодость.Технологии.', 'Международная научно-практическая конференция', 'Бугульминский машиностроительный техникум', '<p>Научная сессия студентов покажет все практические навыки у студентов Бугульминского машиностроительного техникома, которые они приобрели за время обучения в техникуме</p>\r\n<div class=\"\" style=\"\">&nbsp;</div>', '<p>&nbsp;</p>\r\n<div class=\"\" style=\"\">&nbsp;</div>', '<p>Все вопросы по счёт проживания(для иногородних), просьба подходить в 308 кабинет</p>\r\n<div class=\"\" style=\"\">&nbsp;</div>', '<p>Лазарева Светлана Владимировна</p>\r\n<p>Дмитриева Лилия Ильдаровна</p>\r\n<p>Морозова Ольга Юрьевна</p>', '<p>Конференция \"Будущее.Молодость.Технологии\" позволит обучающимся проверить все свои практические навыки по своей специальности и показать чему они научились за&nbsp;время обучения. В программу входят множество компетенций: информационные технологии, гумманитарные искусства, технические изделия и другие.</p>', '', '', '', ''),
(22, 'en', '', '', '', '', '', '', '', '', '', '', '', ''),
(22, 'ru', 'управление цифровой трансформации ', 'Международная конференция по программированию', '', '', '', '', '', '', '', '', '', ''),
(23, 'en', '', '', '', '', '', '', '', '', '', '', '', ''),
(23, 'ru', 'управление цифровой трансформации ', 'Международная конференция по программированию', '', '', '', '', '', '', '', '', '', ''),
(24, 'en', '', '', '', '', '', '', '', '', '', '', '', ''),
(24, 'ru', 'управление цифровой трансформации ', 'Международная конференция по программированию', 'Бмт ', '', '', '<p>город Бугульма&nbsp;</p>', '<p>Толстошеев Иван Сергеевич&nbsp;</p>\r\n<p>Гуряев Дмитрий Сергеевич&nbsp;</p>', '<p>программирование в компьютерных системах&nbsp;</p>', '', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_multilingual_conf_org`
--

CREATE TABLE `tbl_multilingual_conf_org` (
  `conf_org_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `sub_org` varchar(450) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_multilingual_conf_org`
--

INSERT INTO `tbl_multilingual_conf_org` (`conf_org_id`, `language`, `sub_org`) VALUES
(1, 'en', ''),
(1, 'ru', '');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_multilingual_conf_page`
--

CREATE TABLE `tbl_multilingual_conf_page` (
  `conf_page_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_multilingual_conf_topic`
--

CREATE TABLE `tbl_multilingual_conf_topic` (
  `conf_topic_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `title` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `scientific_area` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `place` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_multilingual_file`
--

CREATE TABLE `tbl_multilingual_file` (
  `file_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(450) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_multilingual_file`
--

INSERT INTO `tbl_multilingual_file` (`file_id`, `language`, `title`, `name`) VALUES
(1, 'en', '', ''),
(1, 'ru', '', 'prblema razuma v kosmose.pptx'),
(34, 'en', '', ''),
(34, 'ru', '', 'islands-200.png'),
(35, 'en', '', ''),
(35, 'ru', '', 'abzalova.docx');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_multilingual_list_item`
--

CREATE TABLE `tbl_multilingual_list_item` (
  `item_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `item_value` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_multilingual_org`
--

CREATE TABLE `tbl_multilingual_org` (
  `org_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `shortname` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_multilingual_org`
--

INSERT INTO `tbl_multilingual_org` (`org_id`, `language`, `name`, `shortname`, `address`) VALUES
(1, 'en', '', '', ''),
(1, 'ru', 'Администрация Бугульминского машиностроительного техникума', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_multilingual_participant`
--

CREATE TABLE `tbl_multilingual_participant` (
  `participant_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(1200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `annotation` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `information` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_reason` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ps_field1_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ps_field2_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ps_field3_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ps_field4_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `ps_field5_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pt_field1_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pt_field2_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pt_field3_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pt_field4_value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `pt_field5_value` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_multilingual_participant`
--

INSERT INTO `tbl_multilingual_participant` (`participant_id`, `language`, `title`, `content`, `annotation`, `information`, `status_reason`, `ps_field1_value`, `ps_field2_value`, `ps_field3_value`, `ps_field4_value`, `ps_field5_value`, `pt_field1_value`, `pt_field2_value`, `pt_field3_value`, `pt_field4_value`, `pt_field5_value`) VALUES
(1, 'en', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''),
(1, 'ru', 'Проблема разума в космосе', '', '<p>Проблема существования внеземного разума несравненно глубже, чем думают многие. Она вырастает в величайшую загадку мироздания, над которой с каждым годом всё больше размышляют астрономы, физики, биологи, психологи и философы. Становится всё более очевидным, что это также проблема понимания нас самих, осознание нашего сознания, соотношений между нами и постигаемой нами Вселенной.</p>\r\n<p>Можно ли поверить, что во всей этой огромной Вселенной только мы, разумные существа на Земле, понимаем, где мы живём? Однако же единственный достоверный факт в деле поисковиков разума во Вселенной &ndash; это факт нашего собственного существования. Факт простой, но огромного значения, подобно тому, как величайший секрет атомной бомбы состоял просто в том, что её можно сделать. Разум может существовать во Вселенной!</p>', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_multilingual_site_page`
--

CREATE TABLE `tbl_multilingual_site_page` (
  `page_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_multilingual_site_page`
--

INSERT INTO `tbl_multilingual_site_page` (`page_id`, `language`, `title`, `content`) VALUES
(1, 'ru', 'О сайте', '<h2>Основные возможности сайта</h2>\r\n<p>Сайт предназначен для информационно-организационного сопровождения конференций и поддерживает:\r\n<ul>\r\n<li>хранение списка предстоящих и архива прошедших конференций; \r\n<li>хранение подробной информации о каждой конференции в виде подсайта конференции, доступного по настраиваемому адресу в домене основного сайта; сайт конференции состоит из стандартных и настраиваемых информационных и административных страниц;\r\n<li>возможность назначения администраторов конференции;\r\n<li>организацию многоязычных конференций;\r\n<li>онлайн-регистрацию участников и загрузку тезисов докладов и сопутствующих электронных материалов;\r\n<li>публикацию докладов участников конференции на сайте;\r\n<li>визуальный редактор со встроенным файловым менеджером для участников и организаторов конференций.\r\n</ul>\r\n\r\n<h2>Регистрация участников</h2>\r\n<p>Если на конференции предусмотрена онлайн-регистрация, то для посетителей становится доступной страница «Регистрация» на сайте конференции. \r\n<p>Для регистрации на конференцию не требуется предварительная регистрация на сайте, участнику автоматически будет сгенерирован пароль для дальнейшего доступа к сайту.\r\n<p>Некоторые особенности регистрации участников:\r\n<ul>\r\n<li>заявка на участие в конференции может быть подана персонально или от коллектива: при подаче заявки указываются все докладчики;\r\n<li>допускается размещение нескольких заявок от одного участника;\r\n<li>допускается подача заявки за другого участника конференции, если у того нет возможности сделать это лично;\r\n<li>участники могут изменять данные своих заявок, если это разрешено администратором конференции.\r\n</ul>\r\n\r\n<h2>Размещение информации о конференции</h2>\r\n<p>В зависимости от настроек сайта, организаторы конференций могут самостоятельно добавлять информацию о конференциях на сайт или же данную функцию осуществляет администратор сайта.\r\n\r\n<p>Чтобы самостоятельно разместить информацию о конференции:</p>\r\n<ol>\r\n<li>Зарегистрируйтесь на сайте.\r\n<li>Выберите в главном меню «Добавить конференцию» и&nbsp;заполните основную информацию о конференции.\r\n<li>После добавления конференции, отредактируйте актуальные страницы конференции.\r\n<li>Если требуется, откройте онлайн-регистрацию участников, для чего на странице «Настройки» выберите опцию «Онлайн-регистрация участников».\r\n<li>После проверки администратором сайта конференция станет доступной для посетителей.\r\n</ol>\r\n\r\n<p>Если создание конференции осуществляется администратором сайта и вы являетесь представителем оргкомитета конференции и хотите разместить информацию о конференции на сайте, то:\r\n<ol>\r\n<li>Зарегистрируйтесь на сайте.\r\n<li>Передайте информационное письмо и другие материалы вместе с вашим именем пользователя администратору сайта.\r\n<li>Если необходима возможность онлайн-регистрации, то передайте также перечень полей регистрационной формы, секций конференции и видов участия (очное с докладом, заочное с докладом, стендовый доклад, слушатель и т. п.).\r\n<li>Администратор выполнит предварительную настройку сайта конференции и при необходимости предоставит вам к нему доступ для редактирования информации и просмотра зарегистрированных участников. \r\n<li>После получения адреса сайта конференции, его можно вставить в текст информационного письма.\r\n</ol>\r\n\r\n\r\n<h2>Администрирование сайта конференции</h2>\r\n<p>Администрирование сайта конференции предполагает наполнение информационных страниц конференции и выполнение дополнительных настроек, доступное через меню «Администрирование». \r\n<p>Вот основные административные действия: \r\n<ol>\r\n<li>Чтобы отредактировать информационную страницу конференции, откройте ее и перейдите по ссылке «Редактировать».\r\n<li>Чтобы просмотреть список зарегистрированных участников или принять/отклонить заявки на участие, перейдите на страницу «Участники». На странице имеется возможность выгрузить все заявки и доклады для составления программы или сборника.\r\n<li>Чтобы добавить новую страницу конференции, воспользуйтесь пунктом «Страницы» меню «Администрирование».\r\n<li>Назначить дополнительных администраторов конференции можно на странице «Администраторы».\r\n<li>В разделе «Рассылка» можно выполнять рассылку сообщений участникам конференции по электронной почте.\r\n</ol>\r\n'),
(1, 'en', 'About', '<h2>About page template...</h2>\r\n'),
(1, 'es', 'Sobre esta página web', '<h2>About page template (es)...</h2>\r\n');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_multilingual_user`
--

CREATE TABLE `tbl_multilingual_user` (
  `user_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middlename` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_multilingual_user`
--

INSERT INTO `tbl_multilingual_user` (`user_id`, `language`, `lastname`, `firstname`, `middlename`) VALUES
(2, 'en', '', '', ''),
(2, 'ru', 'Абзалова', 'Ильвина', 'Ильнуровна'),
(3, 'en', '', '', ''),
(3, 'ru', 'Иванов', 'Иван', 'Иванович'),
(4, 'en', '', '', ''),
(4, 'ru', 'Петров ', 'Иван ', 'Иванович ');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_org`
--

CREATE TABLE `tbl_org` (
  `id` int(11) NOT NULL,
  `is_enabled` tinyint(1) DEFAULT NULL,
  `urn` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_org`
--

INSERT INTO `tbl_org` (`id`, `is_enabled`, `urn`, `website`, `email`, `phone`, `fax`) VALUES
(1, 0, '', '', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_participant`
--

CREATE TABLE `tbl_participant` (
  `id` int(11) NOT NULL,
  `conf_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `registration_date` int(11) DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL,
  `start_date` int(11) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `participation_type` int(11) DEFAULT NULL,
  `is_accommodation_required` tinyint(1) DEFAULT NULL,
  `has_content_file` tinyint(1) DEFAULT NULL,
  `classification_code` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pc_field1_value` tinyint(1) DEFAULT NULL,
  `pc_field2_value` tinyint(1) DEFAULT NULL,
  `pc_field3_value` tinyint(1) DEFAULT NULL,
  `pc_field4_value` tinyint(1) DEFAULT NULL,
  `pc_field5_value` tinyint(1) DEFAULT NULL,
  `pl_field1_value` int(11) DEFAULT NULL,
  `pl_field2_value` int(11) DEFAULT NULL,
  `pl_field3_value` int(11) DEFAULT NULL,
  `pl_field4_value` int(11) DEFAULT NULL,
  `pl_field5_value` int(11) DEFAULT NULL,
  `edit_language` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_participant`
--

INSERT INTO `tbl_participant` (`id`, `conf_id`, `topic_id`, `user_id`, `registration_date`, `last_update_date`, `start_date`, `start_time`, `status`, `participation_type`, `is_accommodation_required`, `has_content_file`, `classification_code`, `pc_field1_value`, `pc_field2_value`, `pc_field3_value`, `pc_field4_value`, `pc_field5_value`, `pl_field1_value`, `pl_field2_value`, `pl_field3_value`, `pl_field4_value`, `pl_field5_value`, `edit_language`, `creator_id`) VALUES
(1, 1, 0, 3, 1583170456, 1583170456, 1583352000, 1583128843, 1, 1, NULL, 1, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ru', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_reg`
--

CREATE TABLE `tbl_reg` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_reg`
--

INSERT INTO `tbl_reg` (`id`, `title`, `url`, `date`) VALUES
(1, 'Conferences of the city of Bugulma and BMT', 'http://conference', 1583321402),
(2, 'Conferences of the city of Bugulma and BMT', 'https://bugulmaconference.000webhostapp.com', 1586373426);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_site_page`
--

CREATE TABLE `tbl_site_page` (
  `id` int(11) NOT NULL,
  `urn` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `next_urn` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_site_page`
--

INSERT INTO `tbl_site_page` (`id`, `urn`, `next_urn`) VALUES
(1, 'about', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_urn`
--

CREATE TABLE `tbl_urn` (
  `urn` varchar(90) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_urn`
--

INSERT INTO `tbl_urn` (`urn`) VALUES
('about'),
('confs'),
('create'),
('en'),
('es'),
('language'),
('login'),
('logout'),
('lostpassword'),
('org'),
('orgs'),
('registration'),
('ru'),
('user'),
('users');

-- --------------------------------------------------------

--
-- Структура таблицы `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `registration_date` int(11) DEFAULT NULL,
  `last_date` int(11) DEFAULT NULL,
  `last_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `institution` varchar(900) COLLATE utf8_unicode_ci DEFAULT NULL,
  `institution_address` varchar(450) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` varchar(450) COLLATE utf8_unicode_ci DEFAULT NULL,
  `academic_degree` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `academic_title` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supervisor` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `home_address` varchar(450) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `email`, `password`, `role`, `registration_date`, `last_date`, `last_ip`, `locale`, `country`, `city`, `institution`, `institution_address`, `position`, `academic_degree`, `academic_title`, `supervisor`, `home_address`, `phone`, `fax`) VALUES
(2, 'abzalovailvin@gmail.com', '*4ACFE3202A5FF5CF467898FC58AAB1D615029441', 'admin', 1583168652, 1589712063, '78.138.189.156', 'ru', 'Россия', 'Бугульма', 'БМТ', '', '', '', '', '', '', '89297272909', ''),
(3, 'ivanov@mail.ru', '*23AE809DDACAF96AF0FD78ED04B6A265E05AA257', 'user', 1583170456, 1587310173, '188.225.125.198', 'ru', 'Россия', 'Бугульма', 'БИПТ', '', '', '', '', '', '', '9874561239', ''),
(4, 'abzalova1974@list.com', '*B47D4EFC83DECDCD49BB81B913D0B1EDC35DECD1', 'user', 1586372072, 1586372072, '178.206.195.177', 'ru', 'Россия', 'Бугульма', 'БМТ', '', '', '', '', '', '', '89274542453', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tbl_app_form_settings`
--
ALTER TABLE `tbl_app_form_settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tbl_authassignment`
--
ALTER TABLE `tbl_authassignment`
  ADD PRIMARY KEY (`itemname`,`userid`);

--
-- Индексы таблицы `tbl_authitem`
--
ALTER TABLE `tbl_authitem`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `tbl_authitemchild`
--
ALTER TABLE `tbl_authitemchild`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Индексы таблицы `tbl_author`
--
ALTER TABLE `tbl_author`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tbl_commented_item`
--
ALTER TABLE `tbl_commented_item`
  ADD PRIMARY KEY (`item_id`,`sub_item_id`);

--
-- Индексы таблицы `tbl_conf`
--
ALTER TABLE `tbl_conf`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tbl_conf_admin`
--
ALTER TABLE `tbl_conf_admin`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tbl_conf_org`
--
ALTER TABLE `tbl_conf_org`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tbl_conf_page`
--
ALTER TABLE `tbl_conf_page`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tbl_conf_topic`
--
ALTER TABLE `tbl_conf_topic`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tbl_cron`
--
ALTER TABLE `tbl_cron`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tbl_file`
--
ALTER TABLE `tbl_file`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tbl_guestbook`
--
ALTER TABLE `tbl_guestbook`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tbl_list_item`
--
ALTER TABLE `tbl_list_item`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tbl_mail_task`
--
ALTER TABLE `tbl_mail_task`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tbl_migration`
--
ALTER TABLE `tbl_migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `tbl_multilingual_app_form_settings`
--
ALTER TABLE `tbl_multilingual_app_form_settings`
  ADD PRIMARY KEY (`app_form_settings_id`,`language`);

--
-- Индексы таблицы `tbl_multilingual_author`
--
ALTER TABLE `tbl_multilingual_author`
  ADD PRIMARY KEY (`author_id`,`language`);

--
-- Индексы таблицы `tbl_multilingual_conf`
--
ALTER TABLE `tbl_multilingual_conf`
  ADD PRIMARY KEY (`conf_id`,`language`);

--
-- Индексы таблицы `tbl_multilingual_conf_org`
--
ALTER TABLE `tbl_multilingual_conf_org`
  ADD PRIMARY KEY (`conf_org_id`,`language`);

--
-- Индексы таблицы `tbl_multilingual_conf_page`
--
ALTER TABLE `tbl_multilingual_conf_page`
  ADD PRIMARY KEY (`conf_page_id`,`language`);

--
-- Индексы таблицы `tbl_multilingual_conf_topic`
--
ALTER TABLE `tbl_multilingual_conf_topic`
  ADD PRIMARY KEY (`conf_topic_id`,`language`);

--
-- Индексы таблицы `tbl_multilingual_file`
--
ALTER TABLE `tbl_multilingual_file`
  ADD PRIMARY KEY (`file_id`,`language`);

--
-- Индексы таблицы `tbl_multilingual_list_item`
--
ALTER TABLE `tbl_multilingual_list_item`
  ADD KEY `fk_multilingual_list_item_id` (`item_id`);

--
-- Индексы таблицы `tbl_multilingual_org`
--
ALTER TABLE `tbl_multilingual_org`
  ADD PRIMARY KEY (`org_id`,`language`);

--
-- Индексы таблицы `tbl_multilingual_participant`
--
ALTER TABLE `tbl_multilingual_participant`
  ADD PRIMARY KEY (`participant_id`,`language`);

--
-- Индексы таблицы `tbl_multilingual_site_page`
--
ALTER TABLE `tbl_multilingual_site_page`
  ADD KEY `fk_multilingual_page_page_id` (`page_id`);

--
-- Индексы таблицы `tbl_multilingual_user`
--
ALTER TABLE `tbl_multilingual_user`
  ADD PRIMARY KEY (`user_id`,`language`);

--
-- Индексы таблицы `tbl_org`
--
ALTER TABLE `tbl_org`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tbl_participant`
--
ALTER TABLE `tbl_participant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `CONF_ID_STATUS` (`conf_id`,`status`);

--
-- Индексы таблицы `tbl_reg`
--
ALTER TABLE `tbl_reg`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tbl_site_page`
--
ALTER TABLE `tbl_site_page`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `tbl_urn`
--
ALTER TABLE `tbl_urn`
  ADD UNIQUE KEY `urn` (`urn`);

--
-- Индексы таблицы `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tbl_app_form_settings`
--
ALTER TABLE `tbl_app_form_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `tbl_author`
--
ALTER TABLE `tbl_author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `tbl_comment`
--
ALTER TABLE `tbl_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_conf`
--
ALTER TABLE `tbl_conf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `tbl_conf_admin`
--
ALTER TABLE `tbl_conf_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `tbl_conf_org`
--
ALTER TABLE `tbl_conf_org`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `tbl_conf_page`
--
ALTER TABLE `tbl_conf_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `tbl_conf_topic`
--
ALTER TABLE `tbl_conf_topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `tbl_cron`
--
ALTER TABLE `tbl_cron`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_file`
--
ALTER TABLE `tbl_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT для таблицы `tbl_guestbook`
--
ALTER TABLE `tbl_guestbook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_list_item`
--
ALTER TABLE `tbl_list_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `tbl_mail_task`
--
ALTER TABLE `tbl_mail_task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `tbl_org`
--
ALTER TABLE `tbl_org`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `tbl_participant`
--
ALTER TABLE `tbl_participant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `tbl_reg`
--
ALTER TABLE `tbl_reg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `tbl_site_page`
--
ALTER TABLE `tbl_site_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `tbl_authassignment`
--
ALTER TABLE `tbl_authassignment`
  ADD CONSTRAINT `tbl_authassignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `tbl_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tbl_authitemchild`
--
ALTER TABLE `tbl_authitemchild`
  ADD CONSTRAINT `tbl_authitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `tbl_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_authitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `tbl_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `tbl_multilingual_app_form_settings`
--
ALTER TABLE `tbl_multilingual_app_form_settings`
  ADD CONSTRAINT `fk_multilingual_app_form_settings_app_form_settings_id` FOREIGN KEY (`app_form_settings_id`) REFERENCES `tbl_app_form_settings` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `tbl_multilingual_author`
--
ALTER TABLE `tbl_multilingual_author`
  ADD CONSTRAINT `fk_multilingual_author_author_id` FOREIGN KEY (`author_id`) REFERENCES `tbl_author` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `tbl_multilingual_conf`
--
ALTER TABLE `tbl_multilingual_conf`
  ADD CONSTRAINT `fk_multilingual_conf_conf_id` FOREIGN KEY (`conf_id`) REFERENCES `tbl_conf` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_multilingual_org_org_id` FOREIGN KEY (`conf_id`) REFERENCES `tbl_conf` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `tbl_multilingual_conf_org`
--
ALTER TABLE `tbl_multilingual_conf_org`
  ADD CONSTRAINT `fk_multilingual_conf_org_conf_org_id` FOREIGN KEY (`conf_org_id`) REFERENCES `tbl_conf_org` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `tbl_multilingual_conf_page`
--
ALTER TABLE `tbl_multilingual_conf_page`
  ADD CONSTRAINT `fk_multilingual_conf_conf_page_id` FOREIGN KEY (`conf_page_id`) REFERENCES `tbl_conf_page` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `tbl_multilingual_conf_topic`
--
ALTER TABLE `tbl_multilingual_conf_topic`
  ADD CONSTRAINT `fk_multilingual_conf_conf_topic_id` FOREIGN KEY (`conf_topic_id`) REFERENCES `tbl_conf_topic` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `tbl_multilingual_file`
--
ALTER TABLE `tbl_multilingual_file`
  ADD CONSTRAINT `fk_multilingual_file_file_id` FOREIGN KEY (`file_id`) REFERENCES `tbl_file` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `tbl_multilingual_list_item`
--
ALTER TABLE `tbl_multilingual_list_item`
  ADD CONSTRAINT `fk_multilingual_list_item_id` FOREIGN KEY (`item_id`) REFERENCES `tbl_list_item` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `tbl_multilingual_participant`
--
ALTER TABLE `tbl_multilingual_participant`
  ADD CONSTRAINT `fk_multilingual_participant_participant_id` FOREIGN KEY (`participant_id`) REFERENCES `tbl_participant` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `tbl_multilingual_site_page`
--
ALTER TABLE `tbl_multilingual_site_page`
  ADD CONSTRAINT `fk_multilingual_page_page_id` FOREIGN KEY (`page_id`) REFERENCES `tbl_site_page` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `tbl_multilingual_user`
--
ALTER TABLE `tbl_multilingual_user`
  ADD CONSTRAINT `fk_multilingual_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
