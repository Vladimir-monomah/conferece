-- MySQL dump 10.13  Distrib 5.5.8, for Win32 (x86)
--
-- Host: localhost    Database: yconfs
-- ------------------------------------------------------
-- Server version	5.5.8

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_app_form_settings`
--

DROP TABLE IF EXISTS `tbl_app_form_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_app_form_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `authors_order` int(11) DEFAULT '0',
  `lastname_order` int(11) DEFAULT '0',
  `lastname_wi_paper_mode` int(11) DEFAULT '1',
  `lastname_wo_paper_mode` int(11) DEFAULT '1',
  `is_lastname_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_lastname_wo_paper_published` tinyint(1) DEFAULT '1',
  `firstname_order` int(11) DEFAULT '0',
  `firstname_wi_paper_mode` int(11) DEFAULT '1',
  `firstname_wo_paper_mode` int(11) DEFAULT '1',
  `is_firstname_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_firstname_wo_paper_published` tinyint(1) DEFAULT '1',
  `middlename_order` int(11) DEFAULT '0',
  `middlename_wi_paper_mode` int(11) DEFAULT '1',
  `middlename_wo_paper_mode` int(11) DEFAULT '1',
  `is_middlename_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_middlename_wo_paper_published` tinyint(1) DEFAULT '1',
  `org_order` int(11) DEFAULT '0',
  `org_wi_paper_mode` int(11) DEFAULT '1',
  `org_wo_paper_mode` int(11) DEFAULT '1',
  `is_org_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_org_wo_paper_published` tinyint(1) DEFAULT '1',
  `org_address_order` int(11) DEFAULT '0',
  `org_address_wi_paper_mode` int(11) DEFAULT '1',
  `org_address_wo_paper_mode` int(11) DEFAULT '1',
  `is_org_address_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_org_address_wo_paper_published` tinyint(1) DEFAULT '1',
  `position_order` int(11) DEFAULT '0',
  `position_wi_paper_mode` int(11) DEFAULT '1',
  `position_wo_paper_mode` int(11) DEFAULT '1',
  `is_position_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_position_wo_paper_published` tinyint(1) DEFAULT '1',
  `academic_degree_order` int(11) DEFAULT '0',
  `academic_degree_wi_paper_mode` int(11) DEFAULT '1',
  `academic_degree_wo_paper_mode` int(11) DEFAULT '1',
  `is_academic_degree_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_academic_degree_wo_paper_published` tinyint(1) DEFAULT '1',
  `academic_title_order` int(11) DEFAULT '0',
  `academic_title_wi_paper_mode` int(11) DEFAULT '1',
  `academic_title_wo_paper_mode` int(11) DEFAULT '1',
  `is_academic_title_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_academic_title_wo_paper_published` tinyint(1) DEFAULT '1',
  `supervisor_order` int(11) DEFAULT '0',
  `supervisor_wi_paper_mode` int(11) DEFAULT '1',
  `supervisor_wo_paper_mode` int(11) DEFAULT '1',
  `is_supervisor_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_supervisor_wo_paper_published` tinyint(1) DEFAULT '1',
  `country_order` int(11) DEFAULT '0',
  `country_wi_paper_mode` int(11) DEFAULT '1',
  `country_wo_paper_mode` int(11) DEFAULT '1',
  `is_country_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_country_wo_paper_published` tinyint(1) DEFAULT '1',
  `city_order` int(11) DEFAULT '0',
  `city_wi_paper_mode` int(11) DEFAULT '1',
  `city_wo_paper_mode` int(11) DEFAULT '1',
  `is_city_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_city_wo_paper_published` tinyint(1) DEFAULT '1',
  `address_order` int(11) DEFAULT '0',
  `address_wi_paper_mode` int(11) DEFAULT '1',
  `address_wo_paper_mode` int(11) DEFAULT '1',
  `is_address_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_address_wo_paper_published` tinyint(1) DEFAULT '1',
  `phone_order` int(11) DEFAULT '0',
  `phone_wi_paper_mode` int(11) DEFAULT '1',
  `phone_wo_paper_mode` int(11) DEFAULT '1',
  `is_phone_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_phone_wo_paper_published` tinyint(1) DEFAULT '1',
  `fax_order` int(11) DEFAULT '0',
  `fax_wi_paper_mode` int(11) DEFAULT '1',
  `fax_wo_paper_mode` int(11) DEFAULT '1',
  `is_fax_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_fax_wo_paper_published` tinyint(1) DEFAULT '1',
  `email_order` int(11) DEFAULT '0',
  `email_wi_paper_mode` int(11) DEFAULT '1',
  `email_wo_paper_mode` int(11) DEFAULT '1',
  `is_email_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_email_wo_paper_published` tinyint(1) DEFAULT '1',
  `membership_order` int(11) DEFAULT '0',
  `membership_wi_paper_mode` int(11) DEFAULT '1',
  `membership_wo_paper_mode` int(11) DEFAULT '1',
  `is_membership_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_membership_wo_paper_published` tinyint(1) DEFAULT '1',
  `annotation_order` int(11) DEFAULT '0',
  `annotation_wi_paper_mode` int(11) DEFAULT '1',
  `annotation_wo_paper_mode` int(11) DEFAULT '0',
  `is_annotation_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_annotation_wo_paper_published` tinyint(1) DEFAULT '0',
  `report_title_order` int(11) DEFAULT '0',
  `report_title_wi_paper_mode` int(11) DEFAULT '1',
  `report_title_wo_paper_mode` int(11) DEFAULT '0',
  `is_report_title_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_report_title_wo_paper_published` tinyint(1) DEFAULT '0',
  `report_topic_order` int(11) DEFAULT '0',
  `report_topic_wi_paper_mode` int(11) DEFAULT '1',
  `report_topic_wo_paper_mode` int(11) DEFAULT '0',
  `is_report_topic_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_report_topic_wo_paper_published` tinyint(1) DEFAULT '1',
  `classification_order` int(11) DEFAULT '0',
  `classification_wi_paper_mode` int(11) DEFAULT '1',
  `classification_wo_paper_mode` int(11) DEFAULT '0',
  `is_classification_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_classification_wo_paper_published` tinyint(1) DEFAULT '0',
  `report_text_order` int(11) DEFAULT '0',
  `report_text_wi_paper_mode` int(11) DEFAULT '1',
  `report_text_wo_paper_mode` int(11) DEFAULT '0',
  `is_report_text_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_report_text_wo_paper_published` tinyint(1) DEFAULT '0',
  `report_file_order` int(11) DEFAULT '0',
  `report_file_wi_paper_mode` int(11) DEFAULT '1',
  `report_file_wo_paper_mode` int(11) DEFAULT '0',
  `is_report_file_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_report_file_wo_paper_published` tinyint(1) DEFAULT '0',
  `more_info_order` int(11) DEFAULT '0',
  `more_info_wi_paper_mode` int(11) DEFAULT '1',
  `more_info_wo_paper_mode` int(11) DEFAULT '1',
  `is_more_info_wi_paper_published` tinyint(1) DEFAULT '1',
  `is_more_info_wo_paper_published` tinyint(1) DEFAULT '1',
  `accommodation_order` int(11) DEFAULT '0',
  `accommodation_wi_paper_mode` int(11) DEFAULT '1',
  `accommodation_wo_paper_mode` int(11) DEFAULT '1',
  `is_accommodation_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_accommodation_wo_paper_published` tinyint(1) DEFAULT '0',
  `image_order` int(11) DEFAULT '0',
  `image_wi_paper_mode` int(11) DEFAULT '1',
  `image_wo_paper_mode` int(11) DEFAULT '1',
  `is_image_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_image_wo_paper_published` tinyint(1) DEFAULT '0',
  `ps_field1_order` int(11) DEFAULT '0',
  `ps_field1_wi_paper_mode` int(11) DEFAULT '1',
  `ps_field1_wo_paper_mode` int(11) DEFAULT '1',
  `is_ps_field1_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_ps_field1_wo_paper_published` tinyint(1) DEFAULT '0',
  `ps_field2_order` int(11) DEFAULT '0',
  `ps_field2_wi_paper_mode` int(11) DEFAULT '1',
  `ps_field2_wo_paper_mode` int(11) DEFAULT '1',
  `is_ps_field2_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_ps_field2_wo_paper_published` tinyint(1) DEFAULT '0',
  `ps_field3_order` int(11) DEFAULT '0',
  `ps_field3_wi_paper_mode` int(11) DEFAULT '1',
  `ps_field3_wo_paper_mode` int(11) DEFAULT '1',
  `is_ps_field3_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_ps_field3_wo_paper_published` tinyint(1) DEFAULT '0',
  `ps_field4_order` int(11) DEFAULT '0',
  `ps_field4_wi_paper_mode` int(11) DEFAULT '1',
  `ps_field4_wo_paper_mode` int(11) DEFAULT '1',
  `is_ps_field4_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_ps_field4_wo_paper_published` tinyint(1) DEFAULT '0',
  `ps_field5_order` int(11) DEFAULT '0',
  `ps_field5_wi_paper_mode` int(11) DEFAULT '1',
  `ps_field5_wo_paper_mode` int(11) DEFAULT '1',
  `is_ps_field5_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_ps_field5_wo_paper_published` tinyint(1) DEFAULT '0',
  `as_field1_order` int(11) DEFAULT '0',
  `as_field1_wi_paper_mode` int(11) DEFAULT '1',
  `as_field1_wo_paper_mode` int(11) DEFAULT '1',
  `is_as_field1_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_as_field1_wo_paper_published` tinyint(1) DEFAULT '0',
  `as_field2_order` int(11) DEFAULT '0',
  `as_field2_wi_paper_mode` int(11) DEFAULT '1',
  `as_field2_wo_paper_mode` int(11) DEFAULT '1',
  `is_as_field2_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_as_field2_wo_paper_published` tinyint(1) DEFAULT '0',
  `as_field3_order` int(11) DEFAULT '0',
  `as_field3_wi_paper_mode` int(11) DEFAULT '1',
  `as_field3_wo_paper_mode` int(11) DEFAULT '1',
  `is_as_field3_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_as_field3_wo_paper_published` tinyint(1) DEFAULT '0',
  `as_field4_order` int(11) DEFAULT '0',
  `as_field4_wi_paper_mode` int(11) DEFAULT '1',
  `as_field4_wo_paper_mode` int(11) DEFAULT '1',
  `is_as_field4_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_as_field4_wo_paper_published` tinyint(1) DEFAULT '0',
  `as_field5_order` int(11) DEFAULT '0',
  `as_field5_wi_paper_mode` int(11) DEFAULT '1',
  `as_field5_wo_paper_mode` int(11) DEFAULT '1',
  `is_as_field5_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_as_field5_wo_paper_published` tinyint(1) DEFAULT '0',
  `pt_field1_order` int(11) DEFAULT '0',
  `pt_field1_wi_paper_mode` int(11) DEFAULT '1',
  `pt_field1_wo_paper_mode` int(11) DEFAULT '1',
  `is_pt_field1_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pt_field1_wo_paper_published` tinyint(1) DEFAULT '0',
  `pt_field2_order` int(11) DEFAULT '0',
  `pt_field2_wi_paper_mode` int(11) DEFAULT '1',
  `pt_field2_wo_paper_mode` int(11) DEFAULT '1',
  `is_pt_field2_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pt_field2_wo_paper_published` tinyint(1) DEFAULT '0',
  `pt_field3_order` int(11) DEFAULT '0',
  `pt_field3_wi_paper_mode` int(11) DEFAULT '1',
  `pt_field3_wo_paper_mode` int(11) DEFAULT '1',
  `is_pt_field3_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pt_field3_wo_paper_published` tinyint(1) DEFAULT '0',
  `pt_field4_order` int(11) DEFAULT '0',
  `pt_field4_wi_paper_mode` int(11) DEFAULT '1',
  `pt_field4_wo_paper_mode` int(11) DEFAULT '1',
  `is_pt_field4_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pt_field4_wo_paper_published` tinyint(1) DEFAULT '0',
  `pt_field5_order` int(11) DEFAULT '0',
  `pt_field5_wi_paper_mode` int(11) DEFAULT '1',
  `pt_field5_wo_paper_mode` int(11) DEFAULT '1',
  `is_pt_field5_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pt_field5_wo_paper_published` tinyint(1) DEFAULT '0',
  `at_field1_order` int(11) DEFAULT '0',
  `at_field1_wi_paper_mode` int(11) DEFAULT '1',
  `at_field1_wo_paper_mode` int(11) DEFAULT '1',
  `is_at_field1_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_at_field1_wo_paper_published` tinyint(1) DEFAULT '0',
  `at_field2_order` int(11) DEFAULT '0',
  `at_field2_wi_paper_mode` int(11) DEFAULT '1',
  `at_field2_wo_paper_mode` int(11) DEFAULT '1',
  `is_at_field2_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_at_field2_wo_paper_published` tinyint(1) DEFAULT '0',
  `at_field3_order` int(11) DEFAULT '0',
  `at_field3_wi_paper_mode` int(11) DEFAULT '1',
  `at_field3_wo_paper_mode` int(11) DEFAULT '1',
  `is_at_field3_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_at_field3_wo_paper_published` tinyint(1) DEFAULT '0',
  `at_field4_order` int(11) DEFAULT '0',
  `at_field4_wi_paper_mode` int(11) DEFAULT '1',
  `at_field4_wo_paper_mode` int(11) DEFAULT '1',
  `is_at_field4_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_at_field4_wo_paper_published` tinyint(1) DEFAULT '0',
  `at_field5_order` int(11) DEFAULT '0',
  `at_field5_wi_paper_mode` int(11) DEFAULT '1',
  `at_field5_wo_paper_mode` int(11) DEFAULT '1',
  `is_at_field5_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_at_field5_wo_paper_published` tinyint(1) DEFAULT '0',
  `pc_field1_order` int(11) DEFAULT '0',
  `pc_field1_wi_paper_mode` int(11) DEFAULT '1',
  `pc_field1_wo_paper_mode` int(11) DEFAULT '1',
  `is_pc_field1_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pc_field1_wo_paper_published` tinyint(1) DEFAULT '0',
  `pc_field2_order` int(11) DEFAULT '0',
  `pc_field2_wi_paper_mode` int(11) DEFAULT '1',
  `pc_field2_wo_paper_mode` int(11) DEFAULT '1',
  `is_pc_field2_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pc_field2_wo_paper_published` tinyint(1) DEFAULT '0',
  `pc_field3_order` int(11) DEFAULT '0',
  `pc_field3_wi_paper_mode` int(11) DEFAULT '1',
  `pc_field3_wo_paper_mode` int(11) DEFAULT '1',
  `is_pc_field3_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pc_field3_wo_paper_published` tinyint(1) DEFAULT '0',
  `pc_field4_order` int(11) DEFAULT '0',
  `pc_field4_wi_paper_mode` int(11) DEFAULT '1',
  `pc_field4_wo_paper_mode` int(11) DEFAULT '1',
  `is_pc_field4_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pc_field4_wo_paper_published` tinyint(1) DEFAULT '0',
  `pc_field5_order` int(11) DEFAULT '0',
  `pc_field5_wi_paper_mode` int(11) DEFAULT '1',
  `pc_field5_wo_paper_mode` int(11) DEFAULT '1',
  `is_pc_field5_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pc_field5_wo_paper_published` tinyint(1) DEFAULT '0',
  `ac_field1_order` int(11) DEFAULT '0',
  `ac_field1_wi_paper_mode` int(11) DEFAULT '1',
  `ac_field1_wo_paper_mode` int(11) DEFAULT '1',
  `is_ac_field1_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_ac_field1_wo_paper_published` tinyint(1) DEFAULT '0',
  `ac_field2_order` int(11) DEFAULT '0',
  `ac_field2_wi_paper_mode` int(11) DEFAULT '1',
  `ac_field2_wo_paper_mode` int(11) DEFAULT '1',
  `is_ac_field2_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_ac_field2_wo_paper_published` tinyint(1) DEFAULT '0',
  `ac_field3_order` int(11) DEFAULT '0',
  `ac_field3_wi_paper_mode` int(11) DEFAULT '1',
  `ac_field3_wo_paper_mode` int(11) DEFAULT '1',
  `is_ac_field3_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_ac_field3_wo_paper_published` tinyint(1) DEFAULT '0',
  `ac_field4_order` int(11) DEFAULT '0',
  `ac_field4_wi_paper_mode` int(11) DEFAULT '1',
  `ac_field4_wo_paper_mode` int(11) DEFAULT '1',
  `is_ac_field4_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_ac_field4_wo_paper_published` tinyint(1) DEFAULT '0',
  `ac_field5_order` int(11) DEFAULT '0',
  `ac_field5_wi_paper_mode` int(11) DEFAULT '1',
  `ac_field5_wo_paper_mode` int(11) DEFAULT '1',
  `is_ac_field5_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_ac_field5_wo_paper_published` tinyint(1) DEFAULT '0',
  `pl_field1_order` int(11) DEFAULT '0',
  `pl_field1_wi_paper_mode` int(11) DEFAULT '1',
  `pl_field1_wo_paper_mode` int(11) DEFAULT '1',
  `is_pl_field1_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pl_field1_wo_paper_published` tinyint(1) DEFAULT '0',
  `pl_field2_order` int(11) DEFAULT '0',
  `pl_field2_wi_paper_mode` int(11) DEFAULT '1',
  `pl_field2_wo_paper_mode` int(11) DEFAULT '1',
  `is_pl_field2_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pl_field2_wo_paper_published` tinyint(1) DEFAULT '0',
  `pl_field3_order` int(11) DEFAULT '0',
  `pl_field3_wi_paper_mode` int(11) DEFAULT '1',
  `pl_field3_wo_paper_mode` int(11) DEFAULT '1',
  `is_pl_field3_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pl_field3_wo_paper_published` tinyint(1) DEFAULT '0',
  `pl_field4_order` int(11) DEFAULT '0',
  `pl_field4_wi_paper_mode` int(11) DEFAULT '1',
  `pl_field4_wo_paper_mode` int(11) DEFAULT '1',
  `is_pl_field4_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pl_field4_wo_paper_published` tinyint(1) DEFAULT '0',
  `pl_field5_order` int(11) DEFAULT '0',
  `pl_field5_wi_paper_mode` int(11) DEFAULT '1',
  `pl_field5_wo_paper_mode` int(11) DEFAULT '1',
  `is_pl_field5_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pl_field5_wo_paper_published` tinyint(1) DEFAULT '0',
  `al_field1_order` int(11) DEFAULT '0',
  `al_field1_wi_paper_mode` int(11) DEFAULT '1',
  `al_field1_wo_paper_mode` int(11) DEFAULT '1',
  `is_al_field1_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_al_field1_wo_paper_published` tinyint(1) DEFAULT '0',
  `al_field2_order` int(11) DEFAULT '0',
  `al_field2_wi_paper_mode` int(11) DEFAULT '1',
  `al_field2_wo_paper_mode` int(11) DEFAULT '1',
  `is_al_field2_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_al_field2_wo_paper_published` tinyint(1) DEFAULT '0',
  `al_field3_order` int(11) DEFAULT '0',
  `al_field3_wi_paper_mode` int(11) DEFAULT '1',
  `al_field3_wo_paper_mode` int(11) DEFAULT '1',
  `is_al_field3_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_al_field3_wo_paper_published` tinyint(1) DEFAULT '0',
  `al_field4_order` int(11) DEFAULT '0',
  `al_field4_wi_paper_mode` int(11) DEFAULT '1',
  `al_field4_wo_paper_mode` int(11) DEFAULT '1',
  `is_al_field4_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_al_field4_wo_paper_published` tinyint(1) DEFAULT '0',
  `al_field5_order` int(11) DEFAULT '0',
  `al_field5_wi_paper_mode` int(11) DEFAULT '1',
  `al_field5_wo_paper_mode` int(11) DEFAULT '1',
  `is_al_field5_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_al_field5_wo_paper_published` tinyint(1) DEFAULT '0',
  `pf_field1_order` int(11) DEFAULT '0',
  `pf_field1_wi_paper_mode` int(11) DEFAULT '1',
  `pf_field1_wo_paper_mode` int(11) DEFAULT '1',
  `is_pf_field1_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pf_field1_wo_paper_published` tinyint(1) DEFAULT '0',
  `pf_field2_order` int(11) DEFAULT '0',
  `pf_field2_wi_paper_mode` int(11) DEFAULT '1',
  `pf_field2_wo_paper_mode` int(11) DEFAULT '1',
  `is_pf_field2_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pf_field2_wo_paper_published` tinyint(1) DEFAULT '0',
  `pf_field3_order` int(11) DEFAULT '0',
  `pf_field3_wi_paper_mode` int(11) DEFAULT '1',
  `pf_field3_wo_paper_mode` int(11) DEFAULT '1',
  `is_pf_field3_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pf_field3_wo_paper_published` tinyint(1) DEFAULT '0',
  `pf_field4_order` int(11) DEFAULT '0',
  `pf_field4_wi_paper_mode` int(11) DEFAULT '1',
  `pf_field4_wo_paper_mode` int(11) DEFAULT '1',
  `is_pf_field4_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pf_field4_wo_paper_published` tinyint(1) DEFAULT '0',
  `pf_field5_order` int(11) DEFAULT '0',
  `pf_field5_wi_paper_mode` int(11) DEFAULT '1',
  `pf_field5_wo_paper_mode` int(11) DEFAULT '1',
  `is_pf_field5_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_pf_field5_wo_paper_published` tinyint(1) DEFAULT '0',
  `af_field1_order` int(11) DEFAULT '0',
  `af_field1_wi_paper_mode` int(11) DEFAULT '1',
  `af_field1_wo_paper_mode` int(11) DEFAULT '1',
  `is_af_field1_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_af_field1_wo_paper_published` tinyint(1) DEFAULT '0',
  `af_field2_order` int(11) DEFAULT '0',
  `af_field2_wi_paper_mode` int(11) DEFAULT '1',
  `af_field2_wo_paper_mode` int(11) DEFAULT '1',
  `is_af_field2_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_af_field2_wo_paper_published` tinyint(1) DEFAULT '0',
  `af_field3_order` int(11) DEFAULT '0',
  `af_field3_wi_paper_mode` int(11) DEFAULT '1',
  `af_field3_wo_paper_mode` int(11) DEFAULT '1',
  `is_af_field3_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_af_field3_wo_paper_published` tinyint(1) DEFAULT '0',
  `af_field4_order` int(11) DEFAULT '0',
  `af_field4_wi_paper_mode` int(11) DEFAULT '1',
  `af_field4_wo_paper_mode` int(11) DEFAULT '1',
  `is_af_field4_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_af_field4_wo_paper_published` tinyint(1) DEFAULT '0',
  `af_field5_order` int(11) DEFAULT '0',
  `af_field5_wi_paper_mode` int(11) DEFAULT '1',
  `af_field5_wo_paper_mode` int(11) DEFAULT '1',
  `is_af_field5_wi_paper_published` tinyint(1) DEFAULT '0',
  `is_af_field5_wo_paper_published` tinyint(1) DEFAULT '0',
  `is_af_field1_enabled` tinyint(1) DEFAULT '0',
  `is_af_field2_enabled` tinyint(1) DEFAULT '0',
  `is_af_field3_enabled` tinyint(1) DEFAULT '0',
  `is_af_field4_enabled` tinyint(1) DEFAULT '0',
  `is_af_field5_enabled` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_app_form_settings`
--

LOCK TABLES `tbl_app_form_settings` WRITE;
/*!40000 ALTER TABLE `tbl_app_form_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_app_form_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_authassignment`
--

DROP TABLE IF EXISTS `tbl_authassignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_authassignment` (
  `itemname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `userid` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `bizrule` text COLLATE utf8_unicode_ci,
  `data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`itemname`,`userid`),
  CONSTRAINT `tbl_authassignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `tbl_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_authassignment`
--

LOCK TABLES `tbl_authassignment` WRITE;
/*!40000 ALTER TABLE `tbl_authassignment` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_authassignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_authitem`
--

DROP TABLE IF EXISTS `tbl_authitem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_authitem` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `bizrule` text COLLATE utf8_unicode_ci,
  `data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_authitem`
--

LOCK TABLES `tbl_authitem` WRITE;
/*!40000 ALTER TABLE `tbl_authitem` DISABLE KEYS */;
INSERT INTO `tbl_authitem` VALUES ('accessApplicationPage',0,'Access Application Page','return Yii::app()->authManager->canAccessApplicationPage($params[\"conf_id\"],$params[\"user_id\"]);','N;'),('admin',2,'Administrator','return Yii::app()->authManager->isAdmin($params[\"user_id\"]);','N;'),('assignUserRole',0,'Assign User`s Role',NULL,'N;'),('authenticated',2,'Authenticated User','return !Yii::app()->user->isGuest;','N;'),('conf_admin',2,'Conference Administrator','return Yii::app()->authManager->isConfAdmin($params[\"conf_id\"],$params[\"user_id\"]);','N;'),('createComment',0,'Create Comment',NULL,'N;'),('createConf',0,'Create Conference','return Yii::app()->authManager->canCreateConf($params[\"user_id\"]);','N;'),('createOrg',0,'Create Organization',NULL,'N;'),('createParticipant',0,'Create Participant/Apply for Participation','return Yii::app()->authManager->canCreateParticipant($params[\"conf_id\"]);','N;'),('createUser',0,'Create User',NULL,'N;'),('editGuestbook',0,'Post/delete messages in guestbook',NULL,'N;'),('enableComment',0,'Enable|Disable Comment',NULL,'N;'),('enableConf',0,'Enable|Disable Conference',NULL,'N;'),('enableParticipant',0,'Enable|Disable Participant',NULL,'N;'),('exportParticipants',0,'Export All Participants',NULL,'N;'),('guest',2,'Guest','return Yii::app()->user->isGuest;','N;'),('listConfs',0,'View List of Conferences',NULL,'N;'),('listOrgs',0,'View List of Orgarizations',NULL,'N;'),('listUsers',0,'View User List',NULL,'N;'),('modifyComment',0,'Modify Comment',NULL,'N;'),('modifyConf',0,'Modify Conference',NULL,'N;'),('modifyOrg',0,'Modify Organization',NULL,'N;'),('modifyParticipant',0,'Modify Participant','return Yii::app()->authManager->canModifyParticipant($params[\"participant_id\"],$params[\"conf_id\"],$params[\"user_id\"]);','N;'),('modifyParticipantTopic',0,'Modify Participant Topic','return Yii::app()->authManager->canModifyParticipantTopic($params[\"participant_id\"],$params[\"user_id\"]);','N;'),('modifyUser',0,'Modify User',NULL,'N;'),('owner',2,'Owner Role','return Yii::app()->authManager->isOwner($params[\"class\"],$params[\"id\"],$params[\"owner_attr\"],$params[\"user_id\"]);','N;'),('postGuestbook',0,'Post messages in guestbook',NULL,'N;'),('viewAllParticipants',0,'View All Participants',NULL,'N;'),('viewApplicationPageLink',0,'View Application Page Link','return Yii::app()->authManager->canViewApplicationPageLink($params[\"conf_id\"],$params[\"user_id\"]);','N;'),('viewConf',0,'View Conference',NULL,'N;'),('viewEnabledConf',0,'View Enabled Conference','return Yii::app()->authManager->isEnabledConf($params[\"conf_id\"]);','N;'),('viewGuestbook',0,'View messages in guestbook',NULL,'N;'),('viewMyApplicationPage',0,'View MyApplication Page','return Yii::app()->authManager->canViewMyApplicationPage($params[\"conf_id\"],$params[\"user_id\"]);','N;'),('viewOrg',0,'View Organization',NULL,'N;'),('viewParticipant',0,'View Participant',NULL,'N;'),('viewPublishedParticipant',0,'View Published Participant','return Yii::app()->authManager->isParticipantPublished($params[\"participant_id\"]);','N;'),('viewPublishedParticipants',0,'View Published Participants',NULL,'N;'),('viewUser',0,'View User',NULL,'N;');
/*!40000 ALTER TABLE `tbl_authitem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_authitemchild`
--

DROP TABLE IF EXISTS `tbl_authitemchild`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_authitemchild` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `tbl_authitemchild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `tbl_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_authitemchild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `tbl_authitem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_authitemchild`
--

LOCK TABLES `tbl_authitemchild` WRITE;
/*!40000 ALTER TABLE `tbl_authitemchild` DISABLE KEYS */;
INSERT INTO `tbl_authitemchild` VALUES ('authenticated','accessApplicationPage'),('guest','accessApplicationPage'),('admin','assignUserRole'),('authenticated','createComment'),('authenticated','createConf'),('authenticated','createOrg'),('authenticated','createParticipant'),('guest','createParticipant'),('guest','createUser'),('admin','editGuestbook'),('conf_admin','editGuestbook'),('admin','enableComment'),('conf_admin','enableComment'),('admin','enableConf'),('admin','enableParticipant'),('conf_admin','enableParticipant'),('authenticated','listConfs'),('guest','listConfs'),('admin','listOrgs'),('admin','listUsers'),('admin','modifyComment'),('conf_admin','modifyComment'),('owner','modifyComment'),('admin','modifyConf'),('conf_admin','modifyConf'),('admin','modifyOrg'),('admin','modifyParticipant'),('conf_admin','modifyParticipant'),('owner','modifyParticipant'),('admin','modifyParticipantTopic'),('conf_admin','modifyParticipantTopic'),('owner','modifyParticipantTopic'),('admin','modifyUser'),('owner','modifyUser'),('authenticated','postGuestbook'),('admin','viewAllParticipants'),('conf_admin','viewAllParticipants'),('exportParticipants','viewAllParticipants'),('authenticated','viewApplicationPageLink'),('guest','viewApplicationPageLink'),('modifyConf','viewConf'),('viewEnabledConf','viewConf'),('authenticated','viewEnabledConf'),('guest','viewEnabledConf'),('guest','viewGuestbook'),('authenticated','viewMyApplicationPage'),('authenticated','viewOrg'),('guest','viewOrg'),('admin','viewParticipant'),('conf_admin','viewParticipant'),('owner','viewParticipant'),('authenticated','viewPublishedParticipant'),('guest','viewPublishedParticipant'),('authenticated','viewPublishedParticipants'),('guest','viewPublishedParticipants'),('admin','viewUser'),('owner','viewUser');
/*!40000 ALTER TABLE `tbl_authitemchild` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_author`
--

DROP TABLE IF EXISTS `tbl_author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `al_field5_value` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_author`
--

LOCK TABLES `tbl_author` WRITE;
/*!40000 ALTER TABLE `tbl_author` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_comment`
--

DROP TABLE IF EXISTS `tbl_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `sub_item_id` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` text COLLATE utf8_unicode_ci,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_comment`
--

LOCK TABLES `tbl_comment` WRITE;
/*!40000 ALTER TABLE `tbl_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_commented_item`
--

DROP TABLE IF EXISTS `tbl_commented_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_commented_item` (
  `item_id` int(11) NOT NULL,
  `sub_item_id` char(100) COLLATE utf8_unicode_ci NOT NULL,
  `commented` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`item_id`,`sub_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_commented_item`
--

LOCK TABLES `tbl_commented_item` WRITE;
/*!40000 ALTER TABLE `tbl_commented_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_commented_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_conf`
--

DROP TABLE IF EXISTS `tbl_conf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_conf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `show_images` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_conf`
--

LOCK TABLES `tbl_conf` WRITE;
/*!40000 ALTER TABLE `tbl_conf` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_conf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_conf_admin`
--

DROP TABLE IF EXISTS `tbl_conf_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_conf_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conf_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_conf_admin`
--

LOCK TABLES `tbl_conf_admin` WRITE;
/*!40000 ALTER TABLE `tbl_conf_admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_conf_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_conf_org`
--

DROP TABLE IF EXISTS `tbl_conf_org`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_conf_org` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conf_id` int(11) NOT NULL,
  `org_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_conf_org`
--

LOCK TABLES `tbl_conf_org` WRITE;
/*!40000 ALTER TABLE `tbl_conf_org` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_conf_org` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_conf_page`
--

DROP TABLE IF EXISTS `tbl_conf_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_conf_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conf_id` int(11) NOT NULL,
  `urn` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `next_urn` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_conf_page`
--

LOCK TABLES `tbl_conf_page` WRITE;
/*!40000 ALTER TABLE `tbl_conf_page` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_conf_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_conf_topic`
--

DROP TABLE IF EXISTS `tbl_conf_topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_conf_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conf_id` int(11) NOT NULL,
  `number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_conf_topic`
--

LOCK TABLES `tbl_conf_topic` WRITE;
/*!40000 ALTER TABLE `tbl_conf_topic` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_conf_topic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_cron`
--

DROP TABLE IF EXISTS `tbl_cron`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_cron` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cron`
--

LOCK TABLES `tbl_cron` WRITE;
/*!40000 ALTER TABLE `tbl_cron` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_cron` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_file`
--

DROP TABLE IF EXISTS `tbl_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `owner_id` int(11) NOT NULL,
  `owner_class` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_file`
--

LOCK TABLES `tbl_file` WRITE;
/*!40000 ALTER TABLE `tbl_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_guestbook`
--

DROP TABLE IF EXISTS `tbl_guestbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_guestbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conf_id` int(11) NOT NULL,
  `date` int(11) DEFAULT NULL,
  `ip` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_guestbook`
--

LOCK TABLES `tbl_guestbook` WRITE;
/*!40000 ALTER TABLE `tbl_guestbook` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_guestbook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_list_item`
--

DROP TABLE IF EXISTS `tbl_list_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_list_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` int(11) DEFAULT NULL,
  `list_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_list_item`
--

LOCK TABLES `tbl_list_item` WRITE;
/*!40000 ALTER TABLE `tbl_list_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_list_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_mail_task`
--

DROP TABLE IF EXISTS `tbl_mail_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_mail_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `conf_id` int(11) NOT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` text COLLATE utf8_unicode_ci,
  `body` text COLLATE utf8_unicode_ci,
  `recipients` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_from` text COLLATE utf8_unicode_ci,
  `name_from` text COLLATE utf8_unicode_ci,
  `emails` mediumtext COLLATE utf8_unicode_ci,
  `total_count` int(11) DEFAULT NULL,
  `skip_count` int(11) DEFAULT NULL,
  `creation_date` int(11) DEFAULT NULL,
  `completion_date` int(11) DEFAULT NULL,
  `participant_id` int(11) NOT NULL,
  `participants` text COLLATE utf8_unicode_ci,
  `error_statistics` text COLLATE utf8_unicode_ci,
  `success_statistics` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_mail_task`
--

LOCK TABLES `tbl_mail_task` WRITE;
/*!40000 ALTER TABLE `tbl_mail_task` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_mail_task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_migration`
--

DROP TABLE IF EXISTS `tbl_migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_migration`
--

LOCK TABLES `tbl_migration` WRITE;
/*!40000 ALTER TABLE `tbl_migration` DISABLE KEYS */;
INSERT INTO `tbl_migration` VALUES ('m000000_000000_base',1575953856),('m160414_061302_create_reg_table',1575953862),('m160530_070606_add_menu_title',1575953863),('m171020_071907_add_additional_file_fields',1575953874),('m171023_041624_remove_redundant_columns',1575953891),('m171102_080702_update_application_form_settings',1575954084),('m180126_091956_add_participant_edit_language',1575954085),('m180301_075353_rename_page_tables',1575954085),('m180306_041808_rename_conf_section_tables',1575954085),('m180315_065817_update_mail_task',1575954086),('m180409_082931_update_mail_task',1575954087),('m190911_055709_participant_add_creator',1575954087);
/*!40000 ALTER TABLE `tbl_migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_multilingual_app_form_settings`
--

DROP TABLE IF EXISTS `tbl_multilingual_app_form_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_multilingual_app_form_settings` (
  `app_form_settings_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `lastname_hint` text COLLATE utf8_unicode_ci,
  `firstname_hint` text COLLATE utf8_unicode_ci,
  `middlename_hint` text COLLATE utf8_unicode_ci,
  `org_hint` text COLLATE utf8_unicode_ci,
  `org_address_hint` text COLLATE utf8_unicode_ci,
  `position_hint` text COLLATE utf8_unicode_ci,
  `academic_degree_hint` text COLLATE utf8_unicode_ci,
  `academic_title_hint` text COLLATE utf8_unicode_ci,
  `supervisor_hint` text COLLATE utf8_unicode_ci,
  `country_hint` text COLLATE utf8_unicode_ci,
  `city_hint` text COLLATE utf8_unicode_ci,
  `address_hint` text COLLATE utf8_unicode_ci,
  `phone_hint` text COLLATE utf8_unicode_ci,
  `fax_hint` text COLLATE utf8_unicode_ci,
  `email_hint` text COLLATE utf8_unicode_ci,
  `membership_hint` text COLLATE utf8_unicode_ci,
  `annotation_hint` text COLLATE utf8_unicode_ci,
  `report_title_hint` text COLLATE utf8_unicode_ci,
  `report_topic_hint` text COLLATE utf8_unicode_ci,
  `classification_hint` text COLLATE utf8_unicode_ci,
  `report_text_hint` text COLLATE utf8_unicode_ci,
  `report_file_hint` text COLLATE utf8_unicode_ci,
  `more_info_hint` text COLLATE utf8_unicode_ci,
  `accommodation_hint` text COLLATE utf8_unicode_ci,
  `image_hint` text COLLATE utf8_unicode_ci,
  `as_field1_name` text COLLATE utf8_unicode_ci,
  `as_field1_hint` text COLLATE utf8_unicode_ci,
  `as_field2_name` text COLLATE utf8_unicode_ci,
  `as_field2_hint` text COLLATE utf8_unicode_ci,
  `as_field3_name` text COLLATE utf8_unicode_ci,
  `as_field3_hint` text COLLATE utf8_unicode_ci,
  `as_field4_name` text COLLATE utf8_unicode_ci,
  `as_field4_hint` text COLLATE utf8_unicode_ci,
  `as_field5_name` text COLLATE utf8_unicode_ci,
  `as_field5_hint` text COLLATE utf8_unicode_ci,
  `ps_field1_name` text COLLATE utf8_unicode_ci,
  `ps_field1_hint` text COLLATE utf8_unicode_ci,
  `ps_field2_name` text COLLATE utf8_unicode_ci,
  `ps_field2_hint` text COLLATE utf8_unicode_ci,
  `ps_field3_name` text COLLATE utf8_unicode_ci,
  `ps_field3_hint` text COLLATE utf8_unicode_ci,
  `ps_field4_name` text COLLATE utf8_unicode_ci,
  `ps_field4_hint` text COLLATE utf8_unicode_ci,
  `ps_field5_name` text COLLATE utf8_unicode_ci,
  `ps_field5_hint` text COLLATE utf8_unicode_ci,
  `at_field1_name` text COLLATE utf8_unicode_ci,
  `at_field1_hint` text COLLATE utf8_unicode_ci,
  `at_field2_name` text COLLATE utf8_unicode_ci,
  `at_field2_hint` text COLLATE utf8_unicode_ci,
  `at_field3_name` text COLLATE utf8_unicode_ci,
  `at_field3_hint` text COLLATE utf8_unicode_ci,
  `at_field4_name` text COLLATE utf8_unicode_ci,
  `at_field4_hint` text COLLATE utf8_unicode_ci,
  `at_field5_name` text COLLATE utf8_unicode_ci,
  `at_field5_hint` text COLLATE utf8_unicode_ci,
  `pt_field1_name` text COLLATE utf8_unicode_ci,
  `pt_field1_hint` text COLLATE utf8_unicode_ci,
  `pt_field2_name` text COLLATE utf8_unicode_ci,
  `pt_field2_hint` text COLLATE utf8_unicode_ci,
  `pt_field3_name` text COLLATE utf8_unicode_ci,
  `pt_field3_hint` text COLLATE utf8_unicode_ci,
  `pt_field4_name` text COLLATE utf8_unicode_ci,
  `pt_field4_hint` text COLLATE utf8_unicode_ci,
  `pt_field5_name` text COLLATE utf8_unicode_ci,
  `pt_field5_hint` text COLLATE utf8_unicode_ci,
  `ac_field1_name` text COLLATE utf8_unicode_ci,
  `ac_field1_hint` text COLLATE utf8_unicode_ci,
  `ac_field2_name` text COLLATE utf8_unicode_ci,
  `ac_field2_hint` text COLLATE utf8_unicode_ci,
  `ac_field3_name` text COLLATE utf8_unicode_ci,
  `ac_field3_hint` text COLLATE utf8_unicode_ci,
  `ac_field4_name` text COLLATE utf8_unicode_ci,
  `ac_field4_hint` text COLLATE utf8_unicode_ci,
  `ac_field5_name` text COLLATE utf8_unicode_ci,
  `ac_field5_hint` text COLLATE utf8_unicode_ci,
  `pc_field1_name` text COLLATE utf8_unicode_ci,
  `pc_field1_hint` text COLLATE utf8_unicode_ci,
  `pc_field2_name` text COLLATE utf8_unicode_ci,
  `pc_field2_hint` text COLLATE utf8_unicode_ci,
  `pc_field3_name` text COLLATE utf8_unicode_ci,
  `pc_field3_hint` text COLLATE utf8_unicode_ci,
  `pc_field4_name` text COLLATE utf8_unicode_ci,
  `pc_field4_hint` text COLLATE utf8_unicode_ci,
  `pc_field5_name` text COLLATE utf8_unicode_ci,
  `pc_field5_hint` text COLLATE utf8_unicode_ci,
  `al_field1_name` text COLLATE utf8_unicode_ci,
  `al_field1_hint` text COLLATE utf8_unicode_ci,
  `al_field2_name` text COLLATE utf8_unicode_ci,
  `al_field2_hint` text COLLATE utf8_unicode_ci,
  `al_field3_name` text COLLATE utf8_unicode_ci,
  `al_field3_hint` text COLLATE utf8_unicode_ci,
  `al_field4_name` text COLLATE utf8_unicode_ci,
  `al_field4_hint` text COLLATE utf8_unicode_ci,
  `al_field5_name` text COLLATE utf8_unicode_ci,
  `al_field5_hint` text COLLATE utf8_unicode_ci,
  `pl_field1_name` text COLLATE utf8_unicode_ci,
  `pl_field1_hint` text COLLATE utf8_unicode_ci,
  `pl_field2_name` text COLLATE utf8_unicode_ci,
  `pl_field2_hint` text COLLATE utf8_unicode_ci,
  `pl_field3_name` text COLLATE utf8_unicode_ci,
  `pl_field3_hint` text COLLATE utf8_unicode_ci,
  `pl_field4_name` text COLLATE utf8_unicode_ci,
  `pl_field4_hint` text COLLATE utf8_unicode_ci,
  `pl_field5_name` text COLLATE utf8_unicode_ci,
  `pl_field5_hint` text COLLATE utf8_unicode_ci,
  `pf_field1_name` text COLLATE utf8_unicode_ci,
  `pf_field1_hint` text COLLATE utf8_unicode_ci,
  `pf_field2_name` text COLLATE utf8_unicode_ci,
  `pf_field2_hint` text COLLATE utf8_unicode_ci,
  `pf_field3_name` text COLLATE utf8_unicode_ci,
  `pf_field3_hint` text COLLATE utf8_unicode_ci,
  `pf_field4_name` text COLLATE utf8_unicode_ci,
  `pf_field4_hint` text COLLATE utf8_unicode_ci,
  `pf_field5_name` text COLLATE utf8_unicode_ci,
  `pf_field5_hint` text COLLATE utf8_unicode_ci,
  `af_field1_name` text COLLATE utf8_unicode_ci,
  `af_field1_hint` text COLLATE utf8_unicode_ci,
  `af_field2_name` text COLLATE utf8_unicode_ci,
  `af_field2_hint` text COLLATE utf8_unicode_ci,
  `af_field3_name` text COLLATE utf8_unicode_ci,
  `af_field3_hint` text COLLATE utf8_unicode_ci,
  `af_field4_name` text COLLATE utf8_unicode_ci,
  `af_field4_hint` text COLLATE utf8_unicode_ci,
  `af_field5_name` text COLLATE utf8_unicode_ci,
  `af_field5_hint` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`app_form_settings_id`,`language`),
  CONSTRAINT `fk_multilingual_app_form_settings_app_form_settings_id` FOREIGN KEY (`app_form_settings_id`) REFERENCES `tbl_app_form_settings` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_multilingual_app_form_settings`
--

LOCK TABLES `tbl_multilingual_app_form_settings` WRITE;
/*!40000 ALTER TABLE `tbl_multilingual_app_form_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_multilingual_app_form_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_multilingual_author`
--

DROP TABLE IF EXISTS `tbl_multilingual_author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_multilingual_author` (
  `author_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middlename` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `institution` text COLLATE utf8_unicode_ci,
  `institution_address` varchar(450) COLLATE utf8_unicode_ci DEFAULT NULL,
  `position` varchar(750) COLLATE utf8_unicode_ci DEFAULT NULL,
  `academic_degree` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `academic_title` varchar(450) COLLATE utf8_unicode_ci DEFAULT NULL,
  `supervisor` varchar(750) COLLATE utf8_unicode_ci DEFAULT NULL,
  `home_address` varchar(450) COLLATE utf8_unicode_ci DEFAULT NULL,
  `membership` varchar(750) COLLATE utf8_unicode_ci DEFAULT NULL,
  `as_field1_value` text COLLATE utf8_unicode_ci,
  `as_field2_value` text COLLATE utf8_unicode_ci,
  `as_field3_value` text COLLATE utf8_unicode_ci,
  `as_field4_value` text COLLATE utf8_unicode_ci,
  `as_field5_value` text COLLATE utf8_unicode_ci,
  `at_field1_value` text COLLATE utf8_unicode_ci,
  `at_field2_value` text COLLATE utf8_unicode_ci,
  `at_field3_value` text COLLATE utf8_unicode_ci,
  `at_field4_value` text COLLATE utf8_unicode_ci,
  `at_field5_value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`author_id`,`language`),
  CONSTRAINT `fk_multilingual_author_author_id` FOREIGN KEY (`author_id`) REFERENCES `tbl_author` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_multilingual_author`
--

LOCK TABLES `tbl_multilingual_author` WRITE;
/*!40000 ALTER TABLE `tbl_multilingual_author` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_multilingual_author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_multilingual_conf`
--

DROP TABLE IF EXISTS `tbl_multilingual_conf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_multilingual_conf` (
  `conf_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(900) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(900) COLLATE utf8_unicode_ci DEFAULT NULL,
  `place` varchar(450) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `fee` text COLLATE utf8_unicode_ci,
  `accommodation` text COLLATE utf8_unicode_ci,
  `committee` text COLLATE utf8_unicode_ci,
  `program` text COLLATE utf8_unicode_ci,
  `report` text COLLATE utf8_unicode_ci,
  `contacts` text COLLATE utf8_unicode_ci,
  `address` varchar(450) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_title` varchar(900) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`conf_id`,`language`),
  CONSTRAINT `fk_multilingual_conf_conf_id` FOREIGN KEY (`conf_id`) REFERENCES `tbl_conf` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_multilingual_org_org_id` FOREIGN KEY (`conf_id`) REFERENCES `tbl_conf` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_multilingual_conf`
--

LOCK TABLES `tbl_multilingual_conf` WRITE;
/*!40000 ALTER TABLE `tbl_multilingual_conf` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_multilingual_conf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_multilingual_conf_org`
--

DROP TABLE IF EXISTS `tbl_multilingual_conf_org`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_multilingual_conf_org` (
  `conf_org_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `sub_org` varchar(450) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`conf_org_id`,`language`),
  CONSTRAINT `fk_multilingual_conf_org_conf_org_id` FOREIGN KEY (`conf_org_id`) REFERENCES `tbl_conf_org` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_multilingual_conf_org`
--

LOCK TABLES `tbl_multilingual_conf_org` WRITE;
/*!40000 ALTER TABLE `tbl_multilingual_conf_org` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_multilingual_conf_org` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_multilingual_conf_page`
--

DROP TABLE IF EXISTS `tbl_multilingual_conf_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_multilingual_conf_page` (
  `conf_page_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`conf_page_id`,`language`),
  CONSTRAINT `fk_multilingual_conf_conf_page_id` FOREIGN KEY (`conf_page_id`) REFERENCES `tbl_conf_page` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_multilingual_conf_page`
--

LOCK TABLES `tbl_multilingual_conf_page` WRITE;
/*!40000 ALTER TABLE `tbl_multilingual_conf_page` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_multilingual_conf_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_multilingual_conf_topic`
--

DROP TABLE IF EXISTS `tbl_multilingual_conf_topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_multilingual_conf_topic` (
  `conf_topic_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `title` text COLLATE utf8_unicode_ci,
  `scientific_area` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `place` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`conf_topic_id`,`language`),
  CONSTRAINT `fk_multilingual_conf_conf_topic_id` FOREIGN KEY (`conf_topic_id`) REFERENCES `tbl_conf_topic` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_multilingual_conf_topic`
--

LOCK TABLES `tbl_multilingual_conf_topic` WRITE;
/*!40000 ALTER TABLE `tbl_multilingual_conf_topic` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_multilingual_conf_topic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_multilingual_file`
--

DROP TABLE IF EXISTS `tbl_multilingual_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_multilingual_file` (
  `file_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(450) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`file_id`,`language`),
  CONSTRAINT `fk_multilingual_file_file_id` FOREIGN KEY (`file_id`) REFERENCES `tbl_file` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_multilingual_file`
--

LOCK TABLES `tbl_multilingual_file` WRITE;
/*!40000 ALTER TABLE `tbl_multilingual_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_multilingual_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_multilingual_list_item`
--

DROP TABLE IF EXISTS `tbl_multilingual_list_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_multilingual_list_item` (
  `item_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `item_value` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  KEY `fk_multilingual_list_item_id` (`item_id`),
  CONSTRAINT `fk_multilingual_list_item_id` FOREIGN KEY (`item_id`) REFERENCES `tbl_list_item` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_multilingual_list_item`
--

LOCK TABLES `tbl_multilingual_list_item` WRITE;
/*!40000 ALTER TABLE `tbl_multilingual_list_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_multilingual_list_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_multilingual_org`
--

DROP TABLE IF EXISTS `tbl_multilingual_org`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_multilingual_org` (
  `org_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci,
  `shortname` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`org_id`,`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_multilingual_org`
--

LOCK TABLES `tbl_multilingual_org` WRITE;
/*!40000 ALTER TABLE `tbl_multilingual_org` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_multilingual_org` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_multilingual_participant`
--

DROP TABLE IF EXISTS `tbl_multilingual_participant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_multilingual_participant` (
  `participant_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(1200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `annotation` text COLLATE utf8_unicode_ci,
  `information` text COLLATE utf8_unicode_ci,
  `status_reason` text COLLATE utf8_unicode_ci,
  `ps_field1_value` text COLLATE utf8_unicode_ci,
  `ps_field2_value` text COLLATE utf8_unicode_ci,
  `ps_field3_value` text COLLATE utf8_unicode_ci,
  `ps_field4_value` text COLLATE utf8_unicode_ci,
  `ps_field5_value` text COLLATE utf8_unicode_ci,
  `pt_field1_value` text COLLATE utf8_unicode_ci,
  `pt_field2_value` text COLLATE utf8_unicode_ci,
  `pt_field3_value` text COLLATE utf8_unicode_ci,
  `pt_field4_value` text COLLATE utf8_unicode_ci,
  `pt_field5_value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`participant_id`,`language`),
  CONSTRAINT `fk_multilingual_participant_participant_id` FOREIGN KEY (`participant_id`) REFERENCES `tbl_participant` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_multilingual_participant`
--

LOCK TABLES `tbl_multilingual_participant` WRITE;
/*!40000 ALTER TABLE `tbl_multilingual_participant` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_multilingual_participant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_multilingual_site_page`
--

DROP TABLE IF EXISTS `tbl_multilingual_site_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_multilingual_site_page` (
  `page_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  KEY `fk_multilingual_page_page_id` (`page_id`),
  CONSTRAINT `fk_multilingual_page_page_id_1` FOREIGN KEY (`page_id`) REFERENCES `tbl_site_page` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_multilingual_site_page`
--

LOCK TABLES `tbl_multilingual_site_page` WRITE;
/*!40000 ALTER TABLE `tbl_multilingual_site_page` DISABLE KEYS */;
INSERT INTO `tbl_multilingual_site_page` VALUES (1,'ru','О сайте','<h2>Основные возможности сайта</h2>\r\n<p>Сайт предназначен для информационно-организационного сопровождения конференций и поддерживает:\r\n<ul>\r\n<li>хранение списка предстоящих и архива прошедших конференций; \r\n<li>хранение подробной информации о каждой конференции в виде подсайта конференции, доступного по настраиваемому адресу в домене основного сайта; сайт конференции состоит из стандартных и настраиваемых информационных и административных страниц;\r\n<li>возможность назначения администраторов конференции;\r\n<li>организацию многоязычных конференций;\r\n<li>онлайн-регистрацию участников и загрузку тезисов докладов и сопутствующих электронных материалов;\r\n<li>публикацию докладов участников конференции на сайте;\r\n<li>визуальный редактор со встроенным файловым менеджером для участников и организаторов конференций.\r\n</ul>\r\n\r\n<h2>Регистрация участников</h2>\r\n<p>Если на конференции предусмотрена онлайн-регистрация, то для посетителей становится доступной страница «Регистрация» на сайте конференции. \r\n<p>Для регистрации на конференцию не требуется предварительная регистрация на сайте, участнику автоматически будет сгенерирован пароль для дальнейшего доступа к сайту.\r\n<p>Некоторые особенности регистрации участников:\r\n<ul>\r\n<li>заявка на участие в конференции может быть подана персонально или от коллектива: при подаче заявки указываются все докладчики;\r\n<li>допускается размещение нескольких заявок от одного участника;\r\n<li>допускается подача заявки за другого участника конференции, если у того нет возможности сделать это лично;\r\n<li>участники могут изменять данные своих заявок, если это разрешено администратором конференции.\r\n</ul>\r\n\r\n<h2>Размещение информации о конференции</h2>\r\n<p>В зависимости от настроек сайта, организаторы конференций могут самостоятельно добавлять информацию о конференциях на сайт или же данную функцию осуществляет администратор сайта.\r\n\r\n<p>Чтобы самостоятельно разместить информацию о конференции:</p>\r\n<ol>\r\n<li>Зарегистрируйтесь на сайте.\r\n<li>Выберите в главном меню «Добавить конференцию» и&nbsp;заполните основную информацию о конференции.\r\n<li>После добавления конференции, отредактируйте актуальные страницы конференции.\r\n<li>Если требуется, откройте онлайн-регистрацию участников, для чего на странице «Настройки» выберите опцию «Онлайн-регистрация участников».\r\n<li>После проверки администратором сайта конференция станет доступной для посетителей.\r\n</ol>\r\n\r\n<p>Если создание конференции осуществляется администратором сайта и вы являетесь представителем оргкомитета конференции и хотите разместить информацию о конференции на сайте, то:\r\n<ol>\r\n<li>Зарегистрируйтесь на сайте.\r\n<li>Передайте информационное письмо и другие материалы вместе с вашим именем пользователя администратору сайта.\r\n<li>Если необходима возможность онлайн-регистрации, то передайте также перечень полей регистрационной формы, секций конференции и видов участия (очное с докладом, заочное с докладом, стендовый доклад, слушатель и т. п.).\r\n<li>Администратор выполнит предварительную настройку сайта конференции и при необходимости предоставит вам к нему доступ для редактирования информации и просмотра зарегистрированных участников. \r\n<li>После получения адреса сайта конференции, его можно вставить в текст информационного письма.\r\n</ol>\r\n\r\n\r\n<h2>Администрирование сайта конференции</h2>\r\n<p>Администрирование сайта конференции предполагает наполнение информационных страниц конференции и выполнение дополнительных настроек, доступное через меню «Администрирование». \r\n<p>Вот основные административные действия: \r\n<ol>\r\n<li>Чтобы отредактировать информационную страницу конференции, откройте ее и перейдите по ссылке «Редактировать».\r\n<li>Чтобы просмотреть список зарегистрированных участников или принять/отклонить заявки на участие, перейдите на страницу «Участники». На странице имеется возможность выгрузить все заявки и доклады для составления программы или сборника.\r\n<li>Чтобы добавить новую страницу конференции, воспользуйтесь пунктом «Страницы» меню «Администрирование».\r\n<li>Назначить дополнительных администраторов конференции можно на странице «Администраторы».\r\n<li>В разделе «Рассылка» можно выполнять рассылку сообщений участникам конференции по электронной почте.\r\n</ol>\r\n'),(1,'en','About','<h2>About page template...</h2>\r\n'),(1,'es','Sobre esta página web','<h2>About page template (es)...</h2>\r\n');
/*!40000 ALTER TABLE `tbl_multilingual_site_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_multilingual_user`
--

DROP TABLE IF EXISTS `tbl_multilingual_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_multilingual_user` (
  `user_id` int(11) NOT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `middlename` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`,`language`),
  CONSTRAINT `fk_multilingual_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_multilingual_user`
--

LOCK TABLES `tbl_multilingual_user` WRITE;
/*!40000 ALTER TABLE `tbl_multilingual_user` DISABLE KEYS */;
INSERT INTO `tbl_multilingual_user` VALUES (1,'ru','admin','admin','admin');
/*!40000 ALTER TABLE `tbl_multilingual_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_org`
--

DROP TABLE IF EXISTS `tbl_org`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_org` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_enabled` tinyint(1) DEFAULT NULL,
  `urn` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_org`
--

LOCK TABLES `tbl_org` WRITE;
/*!40000 ALTER TABLE `tbl_org` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_org` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_participant`
--

DROP TABLE IF EXISTS `tbl_participant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_participant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `creator_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `CONF_ID_STATUS` (`conf_id`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_participant`
--

LOCK TABLES `tbl_participant` WRITE;
/*!40000 ALTER TABLE `tbl_participant` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_participant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_reg`
--

DROP TABLE IF EXISTS `tbl_reg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_reg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_reg`
--

LOCK TABLES `tbl_reg` WRITE;
/*!40000 ALTER TABLE `tbl_reg` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_reg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_site_page`
--

DROP TABLE IF EXISTS `tbl_site_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_site_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `urn` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `next_urn` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_site_page`
--

LOCK TABLES `tbl_site_page` WRITE;
/*!40000 ALTER TABLE `tbl_site_page` DISABLE KEYS */;
INSERT INTO `tbl_site_page` VALUES (1,'about',NULL);
/*!40000 ALTER TABLE `tbl_site_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_urn`
--

DROP TABLE IF EXISTS `tbl_urn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_urn` (
  `urn` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `urn` (`urn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_urn`
--

LOCK TABLES `tbl_urn` WRITE;
/*!40000 ALTER TABLE `tbl_urn` DISABLE KEYS */;
INSERT INTO `tbl_urn` VALUES ('about'),('confs'),('create'),('en'),('es'),('language'),('login'),('logout'),('lostpassword'),('org'),('orgs'),('registration'),('ru'),('user'),('users');
/*!40000 ALTER TABLE `tbl_urn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `fax` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_user`
--

LOCK TABLES `tbl_user` WRITE;
/*!40000 ALTER TABLE `tbl_user` DISABLE KEYS */;
INSERT INTO `tbl_user` VALUES (1,'admin','*4ACFE3202A5FF5CF467898FC58AAB1D615029441','admin',1575953834,NULL,NULL,'ru',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbl_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-10 12:03:19
