ALTER TABLE tbl_app_form_settings ADD `authors_order` int(11) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `lastname_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `lastname_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `lastname_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_lastname_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_lastname_wo_paper_published` tinyint(1) DEFAULT 1;

ALTER TABLE tbl_app_form_settings ADD `firstname_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `firstname_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `firstname_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_firstname_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_firstname_wo_paper_published` tinyint(1) DEFAULT 1;

ALTER TABLE tbl_app_form_settings ADD `middlename_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `middlename_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `middlename_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_middlename_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_middlename_wo_paper_published` tinyint(1) DEFAULT 1;

ALTER TABLE tbl_app_form_settings ADD `org_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `org_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `org_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_org_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_org_wo_paper_published` tinyint(1) DEFAULT 1;

ALTER TABLE tbl_app_form_settings ADD `org_address_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `org_address_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `org_address_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_org_address_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_org_address_wo_paper_published` tinyint(1) DEFAULT 1;

ALTER TABLE tbl_app_form_settings ADD `position_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `position_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `position_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_position_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_position_wo_paper_published` tinyint(1) DEFAULT 1;

ALTER TABLE tbl_app_form_settings ADD `academic_degree_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `academic_degree_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `academic_degree_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_academic_degree_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_academic_degree_wo_paper_published` tinyint(1) DEFAULT 1;

ALTER TABLE tbl_app_form_settings ADD `academic_title_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `academic_title_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `academic_title_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_academic_title_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_academic_title_wo_paper_published` tinyint(1) DEFAULT 1;

ALTER TABLE tbl_app_form_settings ADD `supervisor_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `supervisor_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `supervisor_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_supervisor_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_supervisor_wo_paper_published` tinyint(1) DEFAULT 1;

ALTER TABLE tbl_app_form_settings ADD `country_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `country_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `country_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_country_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_country_wo_paper_published` tinyint(1) DEFAULT 1;

ALTER TABLE tbl_app_form_settings ADD `city_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `city_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `city_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_city_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_city_wo_paper_published` tinyint(1) DEFAULT 1;

ALTER TABLE tbl_app_form_settings ADD `address_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `address_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `address_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_address_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_address_wo_paper_published` tinyint(1) DEFAULT 1;

ALTER TABLE tbl_app_form_settings ADD `phone_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `phone_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `phone_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_phone_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_phone_wo_paper_published` tinyint(1) DEFAULT 1;

ALTER TABLE tbl_app_form_settings ADD `fax_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `fax_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `fax_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_fax_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_fax_wo_paper_published` tinyint(1) DEFAULT 1;

ALTER TABLE tbl_app_form_settings ADD `email_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `email_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `email_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_email_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_email_wo_paper_published` tinyint(1) DEFAULT 1;

ALTER TABLE tbl_app_form_settings ADD `membership_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `membership_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `membership_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_membership_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_membership_wo_paper_published` tinyint(1) DEFAULT 1;

ALTER TABLE tbl_app_form_settings ADD `annotation_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `annotation_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `annotation_wo_paper_mode` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_annotation_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_annotation_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `report_title_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `report_title_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `report_title_wo_paper_mode` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_report_title_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_report_title_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `report_topic_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `report_topic_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `report_topic_wo_paper_mode` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_report_topic_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_report_topic_wo_paper_published` tinyint(1) DEFAULT 1;

ALTER TABLE tbl_app_form_settings ADD `classification_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `classification_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `classification_wo_paper_mode` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_classification_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_classification_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `report_text_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `report_text_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `report_text_wo_paper_mode` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_report_text_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_report_text_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `report_file_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `report_file_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `report_file_wo_paper_mode` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_report_file_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_report_file_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `more_info_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `more_info_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `more_info_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_more_info_wi_paper_published` tinyint(1) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_more_info_wo_paper_published` tinyint(1) DEFAULT 1;

ALTER TABLE tbl_app_form_settings ADD `accommodation_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `accommodation_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `accommodation_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_accommodation_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_accommodation_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `image_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `image_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `image_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_image_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_image_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `ps_field1_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `ps_field1_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `ps_field1_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_ps_field1_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_ps_field1_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `ps_field2_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `ps_field2_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `ps_field2_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_ps_field2_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_ps_field2_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `ps_field3_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `ps_field3_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `ps_field3_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_ps_field3_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_ps_field3_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `ps_field4_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `ps_field4_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `ps_field4_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_ps_field4_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_ps_field4_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `ps_field5_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `ps_field5_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `ps_field5_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_ps_field5_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_ps_field5_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `as_field1_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `as_field1_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `as_field1_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_as_field1_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_as_field1_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `as_field2_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `as_field2_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `as_field2_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_as_field2_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_as_field2_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `as_field3_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `as_field3_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `as_field3_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_as_field3_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_as_field3_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `as_field4_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `as_field4_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `as_field4_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_as_field4_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_as_field4_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `as_field5_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `as_field5_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `as_field5_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_as_field5_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_as_field5_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pt_field1_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pt_field1_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pt_field1_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pt_field1_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pt_field1_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pt_field2_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pt_field2_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pt_field2_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pt_field2_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pt_field2_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pt_field3_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pt_field3_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pt_field3_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pt_field3_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pt_field3_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pt_field4_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pt_field4_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pt_field4_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pt_field4_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pt_field4_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pt_field5_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pt_field5_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pt_field5_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pt_field5_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pt_field5_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `at_field1_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `at_field1_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `at_field1_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_at_field1_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_at_field1_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `at_field2_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `at_field2_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `at_field2_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_at_field2_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_at_field2_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `at_field3_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `at_field3_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `at_field3_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_at_field3_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_at_field3_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `at_field4_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `at_field4_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `at_field4_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_at_field4_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_at_field4_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `at_field5_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `at_field5_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `at_field5_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_at_field5_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_at_field5_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pc_field1_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pc_field1_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pc_field1_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pc_field1_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pc_field1_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pc_field2_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pc_field2_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pc_field2_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pc_field2_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pc_field2_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pc_field3_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pc_field3_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pc_field3_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pc_field3_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pc_field3_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pc_field4_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pc_field4_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pc_field4_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pc_field4_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pc_field4_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pc_field5_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pc_field5_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pc_field5_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pc_field5_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pc_field5_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `ac_field1_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `ac_field1_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `ac_field1_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_ac_field1_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_ac_field1_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `ac_field2_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `ac_field2_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `ac_field2_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_ac_field2_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_ac_field2_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `ac_field3_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `ac_field3_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `ac_field3_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_ac_field3_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_ac_field3_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `ac_field4_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `ac_field4_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `ac_field4_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_ac_field4_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_ac_field4_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `ac_field5_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `ac_field5_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `ac_field5_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_ac_field5_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_ac_field5_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pl_field1_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pl_field1_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pl_field1_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pl_field1_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pl_field1_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pl_field2_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pl_field2_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pl_field2_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pl_field2_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pl_field2_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pl_field3_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pl_field3_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pl_field3_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pl_field3_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pl_field3_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pl_field4_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pl_field4_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pl_field4_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pl_field4_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pl_field4_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pl_field5_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pl_field5_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pl_field5_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pl_field5_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pl_field5_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `al_field1_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `al_field1_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `al_field1_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_al_field1_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_al_field1_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `al_field2_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `al_field2_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `al_field2_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_al_field2_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_al_field2_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `al_field3_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `al_field3_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `al_field3_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_al_field3_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_al_field3_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `al_field4_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `al_field4_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `al_field4_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_al_field4_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_al_field4_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `al_field5_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `al_field5_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `al_field5_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_al_field5_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_al_field5_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pf_field1_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pf_field1_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pf_field1_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pf_field1_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pf_field1_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pf_field2_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pf_field2_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pf_field2_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pf_field2_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pf_field2_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pf_field3_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pf_field3_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pf_field3_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pf_field3_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pf_field3_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pf_field4_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pf_field4_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pf_field4_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pf_field4_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pf_field4_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `pf_field5_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `pf_field5_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `pf_field5_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_pf_field5_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_pf_field5_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `af_field1_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `af_field1_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `af_field1_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_af_field1_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_af_field1_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `af_field2_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `af_field2_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `af_field2_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_af_field2_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_af_field2_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `af_field3_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `af_field3_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `af_field3_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_af_field3_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_af_field3_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `af_field4_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `af_field4_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `af_field4_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_af_field4_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_af_field4_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `af_field5_order` int(11) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `af_field5_wi_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `af_field5_wo_paper_mode` int(11) DEFAULT 1;
ALTER TABLE tbl_app_form_settings ADD `is_af_field5_wi_paper_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_af_field5_wo_paper_published` tinyint(1) DEFAULT 0;

ALTER TABLE tbl_app_form_settings ADD `is_af_field1_enabled` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_af_field1_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `af_field1_mandatory` int(11) DEFAULT 0;
ALTER TABLE tbl_multilingual_app_form_settings ADD `af_field1_name` text COLLATE utf8_unicode_ci;
ALTER TABLE tbl_multilingual_app_form_settings ADD `af_field1_hint` text COLLATE utf8_unicode_ci;

ALTER TABLE tbl_app_form_settings ADD `is_af_field2_enabled` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_af_field2_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `af_field2_mandatory` int(11) DEFAULT 0;
ALTER TABLE tbl_multilingual_app_form_settings ADD `af_field2_name` text COLLATE utf8_unicode_ci;
ALTER TABLE tbl_multilingual_app_form_settings ADD `af_field2_hint` text COLLATE utf8_unicode_ci;

ALTER TABLE tbl_app_form_settings ADD `is_af_field3_enabled` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_af_field3_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `af_field3_mandatory` int(11) DEFAULT 0;
ALTER TABLE tbl_multilingual_app_form_settings ADD `af_field3_name` text COLLATE utf8_unicode_ci;
ALTER TABLE tbl_multilingual_app_form_settings ADD `af_field3_hint` text COLLATE utf8_unicode_ci;

ALTER TABLE tbl_app_form_settings ADD `is_af_field4_enabled` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_af_field4_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `af_field4_mandatory` int(11) DEFAULT 0;
ALTER TABLE tbl_multilingual_app_form_settings ADD `af_field4_name` text COLLATE utf8_unicode_ci;
ALTER TABLE tbl_multilingual_app_form_settings ADD `af_field4_hint` text COLLATE utf8_unicode_ci;

ALTER TABLE tbl_app_form_settings ADD `is_af_field5_enabled` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `is_af_field5_published` tinyint(1) DEFAULT 0;
ALTER TABLE tbl_app_form_settings ADD `af_field5_mandatory` int(11) DEFAULT 0;
ALTER TABLE tbl_multilingual_app_form_settings ADD `af_field5_name` text COLLATE utf8_unicode_ci;
ALTER TABLE tbl_multilingual_app_form_settings ADD `af_field5_hint` text COLLATE utf8_unicode_ci;

UPDATE tbl_app_form_settings SET  lastname_wi_paper_mode = IF(is_lastname_enabled = 1, IFNULL(lastname_mandatory, 0) + 1, 1), lastname_wo_paper_mode = IF(is_lastname_enabled = 1, IFNULL(lastname_mandatory, 0) + 1, 1), is_lastname_wi_paper_published = 1, is_lastname_wo_paper_published = 1;

UPDATE tbl_app_form_settings SET  firstname_wi_paper_mode = IF(is_firstname_enabled = 1, IFNULL(firstname_mandatory, 0) + 1, 1), firstname_wo_paper_mode = IF(is_firstname_enabled = 1, IFNULL(firstname_mandatory, 0) + 1, 1), is_firstname_wi_paper_published = 1, is_firstname_wo_paper_published = 1;

UPDATE tbl_app_form_settings SET  middlename_wi_paper_mode = IF(is_middlename_enabled = 1, IFNULL(middlename_mandatory, 0) + 1, 1), middlename_wo_paper_mode = IF(is_middlename_enabled = 1, IFNULL(middlename_mandatory, 0) + 1, 1), is_middlename_wi_paper_published = 1, is_middlename_wo_paper_published = 1;

UPDATE tbl_app_form_settings SET  org_wi_paper_mode = IF(is_org_enabled = 1, IFNULL(org_mandatory, 0) + 1, 0), org_wo_paper_mode = IF(is_org_enabled = 1, IFNULL(org_mandatory, 0) + 1, 0), is_org_wi_paper_published = IFNULL(is_org_published, 0), is_org_wo_paper_published = IFNULL(is_org_published, 0);

UPDATE tbl_app_form_settings SET  org_address_wi_paper_mode = IF(is_org_address_enabled = 1, IFNULL(org_address_mandatory, 0) + 1, 0), org_address_wo_paper_mode = IF(is_org_address_enabled = 1, IFNULL(org_address_mandatory, 0) + 1, 0), is_org_address_wi_paper_published = IFNULL(is_org_address_published, 0), is_org_address_wo_paper_published = IFNULL(is_org_address_published, 0);

UPDATE tbl_app_form_settings SET  position_wi_paper_mode = IF(is_position_enabled = 1, IFNULL(position_mandatory, 0) + 1, 0), position_wo_paper_mode = IF(is_position_enabled = 1, IFNULL(position_mandatory, 0) + 1, 0), is_position_wi_paper_published = IFNULL(is_position_published, 0), is_position_wo_paper_published = IFNULL(is_position_published, 0);

UPDATE tbl_app_form_settings SET  academic_degree_wi_paper_mode = IF(is_academic_degree_enabled = 1, IFNULL(academic_degree_mandatory, 0) + 1, 0), academic_degree_wo_paper_mode = IF(is_academic_degree_enabled = 1, IFNULL(academic_degree_mandatory, 0) + 1, 0), is_academic_degree_wi_paper_published = IFNULL(is_academic_degree_published, 0), is_academic_degree_wo_paper_published = IFNULL(is_academic_degree_published, 0);

UPDATE tbl_app_form_settings SET  academic_title_wi_paper_mode = IF(is_academic_title_enabled = 1, IFNULL(academic_title_mandatory, 0) + 1, 0), academic_title_wo_paper_mode = IF(is_academic_title_enabled = 1, IFNULL(academic_title_mandatory, 0) + 1, 0), is_academic_title_wi_paper_published = IFNULL(is_academic_title_published, 0), is_academic_title_wo_paper_published = IFNULL(is_academic_title_published, 0);

UPDATE tbl_app_form_settings SET  supervisor_wi_paper_mode = IF(is_supervisor_enabled = 1, IFNULL(supervisor_mandatory, 0) + 1, 0), supervisor_wo_paper_mode = IF(is_supervisor_enabled = 1, IFNULL(supervisor_mandatory, 0) + 1, 0), is_supervisor_wi_paper_published = IFNULL(is_supervisor_published, 0), is_supervisor_wo_paper_published = IFNULL(is_supervisor_published, 0);

UPDATE tbl_app_form_settings SET  country_wi_paper_mode = IF(is_country_enabled = 1, IFNULL(country_mandatory, 0) + 1, 0), country_wo_paper_mode = IF(is_country_enabled = 1, IFNULL(country_mandatory, 0) + 1, 0), is_country_wi_paper_published = IFNULL(is_country_published, 0), is_country_wo_paper_published = IFNULL(is_country_published, 0);

UPDATE tbl_app_form_settings SET  city_wi_paper_mode = IF(is_city_enabled = 1, IFNULL(city_mandatory, 0) + 1, 0), city_wo_paper_mode = IF(is_city_enabled = 1, IFNULL(city_mandatory, 0) + 1, 0), is_city_wi_paper_published = IFNULL(is_city_published, 0), is_city_wo_paper_published = IFNULL(is_city_published, 0);

UPDATE tbl_app_form_settings SET  address_wi_paper_mode = IF(is_address_enabled = 1, IFNULL(address_mandatory, 0) + 1, 0), address_wo_paper_mode = IF(is_address_enabled = 1, IFNULL(address_mandatory, 0) + 1, 0), is_address_wi_paper_published = IFNULL(is_address_published, 0), is_address_wo_paper_published = IFNULL(is_address_published, 0);

UPDATE tbl_app_form_settings SET  phone_wi_paper_mode = IF(is_phone_enabled = 1, IFNULL(phone_mandatory, 0) + 1, 0), phone_wo_paper_mode = IF(is_phone_enabled = 1, IFNULL(phone_mandatory, 0) + 1, 0), is_phone_wi_paper_published = IFNULL(is_phone_published, 0), is_phone_wo_paper_published = IFNULL(is_phone_published, 0);

UPDATE tbl_app_form_settings SET  fax_wi_paper_mode = IF(is_fax_enabled = 1, IFNULL(fax_mandatory, 0) + 1, 0), fax_wo_paper_mode = IF(is_fax_enabled = 1, IFNULL(fax_mandatory, 0) + 1, 0), is_fax_wi_paper_published = IFNULL(is_fax_published, 0), is_fax_wo_paper_published = IFNULL(is_fax_published, 0);

UPDATE tbl_app_form_settings SET  email_wi_paper_mode = IF(is_email_enabled = 1, IFNULL(email_mandatory, 0) + 1, 1), email_wo_paper_mode = IF(is_email_enabled = 1, IFNULL(email_mandatory, 0) + 1, 1), is_email_wi_paper_published = IFNULL(is_email_published, 0), is_email_wo_paper_published = IFNULL(is_email_published, 0);

UPDATE tbl_app_form_settings SET  membership_wi_paper_mode = IF(is_membership_enabled = 1, IFNULL(membership_mandatory, 0) + 1, 0), membership_wo_paper_mode = IF(is_membership_enabled = 1, IFNULL(membership_mandatory, 0) + 1, 0), is_membership_wi_paper_published = IFNULL(is_membership_published, 0), is_membership_wo_paper_published = IFNULL(is_membership_published, 0);

UPDATE tbl_app_form_settings SET  annotation_wi_paper_mode = IF(is_annotation_enabled = 1, IFNULL(annotation_mandatory, 0) + 1, 0), annotation_wo_paper_mode = 0, is_annotation_wi_paper_published = IFNULL(is_annotation_published, 0), is_annotation_wo_paper_published = 0;

UPDATE tbl_app_form_settings SET  report_title_wi_paper_mode = IF(is_report_title_enabled = 1, IFNULL(report_title_mandatory, 0) + 1, 0), report_title_wo_paper_mode = 0, is_report_title_wi_paper_published = IFNULL(is_report_title_published, 0), is_report_title_wo_paper_published = 0;

UPDATE tbl_app_form_settings SET  report_topic_wi_paper_mode = IF(is_report_topic_enabled = 1, IFNULL(report_topic_mandatory, 0) + 1, 0), report_topic_wo_paper_mode = IF(is_report_topic_enabled = 1, IFNULL(report_topic_mandatory, 0) + 1, 0), is_report_topic_wi_paper_published = IFNULL(is_report_topic_published, 0), is_report_topic_wo_paper_published = IFNULL(is_report_topic_published, 0);

UPDATE tbl_app_form_settings SET  classification_wi_paper_mode = IF(is_classification_enabled = 1, IFNULL(classification_mandatory, 0) + 1, 0), classification_wo_paper_mode = 0, is_classification_wi_paper_published = IFNULL(is_classification_published, 0), is_classification_wo_paper_published = 0;

UPDATE tbl_app_form_settings SET  report_text_wi_paper_mode = IF(is_report_text_enabled = 1, IFNULL(report_text_mandatory, 0) + 1, 0), report_text_wo_paper_mode = 0, is_report_text_wi_paper_published = IFNULL(is_report_text_published, 0), is_report_text_wo_paper_published = 0;

UPDATE tbl_app_form_settings SET  report_file_wi_paper_mode = IF(is_report_file_enabled = 1, IFNULL(report_file_mandatory, 0) + 1, 0), report_file_wo_paper_mode = 0, is_report_file_wi_paper_published = IFNULL(is_report_file_published, 0), is_report_file_wo_paper_published = 0;

UPDATE tbl_app_form_settings SET  more_info_wi_paper_mode = IF(is_more_info_enabled = 1, IFNULL(more_info_mandatory, 0) + 1, 0), more_info_wo_paper_mode = IF(is_more_info_enabled = 1, IFNULL(more_info_mandatory, 0) + 1, 0), is_more_info_wi_paper_published = IFNULL(is_more_info_published, 0), is_more_info_wo_paper_published = IFNULL(is_more_info_published, 0);

UPDATE tbl_app_form_settings SET  accommodation_wi_paper_mode = IF(is_accommodation_enabled = 1, IFNULL(accommodation_mandatory, 0) + 1, 0), accommodation_wo_paper_mode = IF(is_accommodation_enabled = 1, IFNULL(accommodation_mandatory, 0) + 1, 0), is_accommodation_wi_paper_published = IFNULL(is_accommodation_published, 0), is_accommodation_wo_paper_published = IFNULL(is_accommodation_published, 0);

UPDATE tbl_app_form_settings SET  image_wi_paper_mode = IF(is_image_enabled = 1, IFNULL(image_mandatory, 0) + 1, 0), image_wo_paper_mode = IF(is_image_enabled = 1, IFNULL(image_mandatory, 0) + 1, 0), is_image_wi_paper_published = IFNULL(is_image_published, 0), is_image_wo_paper_published = IFNULL(is_image_published, 0);

UPDATE tbl_app_form_settings SET  ps_field1_wi_paper_mode = IF(is_ps_field1_enabled = 1, IFNULL(ps_field1_mandatory, 0) + 1, 0), ps_field1_wo_paper_mode = IF(is_ps_field1_enabled = 1, IFNULL(ps_field1_mandatory, 0) + 1, 0), is_ps_field1_wi_paper_published = IFNULL(is_ps_field1_published, 0), is_ps_field1_wo_paper_published = IFNULL(is_ps_field1_published, 0);

UPDATE tbl_app_form_settings SET  ps_field2_wi_paper_mode = IF(is_ps_field2_enabled = 1, IFNULL(ps_field2_mandatory, 0) + 1, 0), ps_field2_wo_paper_mode = IF(is_ps_field2_enabled = 1, IFNULL(ps_field2_mandatory, 0) + 1, 0), is_ps_field2_wi_paper_published = IFNULL(is_ps_field2_published, 0), is_ps_field2_wo_paper_published = IFNULL(is_ps_field2_published, 0);

UPDATE tbl_app_form_settings SET  ps_field3_wi_paper_mode = IF(is_ps_field3_enabled = 1, IFNULL(ps_field3_mandatory, 0) + 1, 0), ps_field3_wo_paper_mode = IF(is_ps_field3_enabled = 1, IFNULL(ps_field3_mandatory, 0) + 1, 0), is_ps_field3_wi_paper_published = IFNULL(is_ps_field3_published, 0), is_ps_field3_wo_paper_published = IFNULL(is_ps_field3_published, 0);

UPDATE tbl_app_form_settings SET  ps_field4_wi_paper_mode = IF(is_ps_field4_enabled = 1, IFNULL(ps_field4_mandatory, 0) + 1, 0), ps_field4_wo_paper_mode = IF(is_ps_field4_enabled = 1, IFNULL(ps_field4_mandatory, 0) + 1, 0), is_ps_field4_wi_paper_published = IFNULL(is_ps_field4_published, 0), is_ps_field4_wo_paper_published = IFNULL(is_ps_field4_published, 0);

UPDATE tbl_app_form_settings SET  ps_field5_wi_paper_mode = IF(is_ps_field5_enabled = 1, IFNULL(ps_field5_mandatory, 0) + 1, 0), ps_field5_wo_paper_mode = IF(is_ps_field5_enabled = 1, IFNULL(ps_field5_mandatory, 0) + 1, 0), is_ps_field5_wi_paper_published = IFNULL(is_ps_field5_published, 0), is_ps_field5_wo_paper_published = IFNULL(is_ps_field5_published, 0);

UPDATE tbl_app_form_settings SET  as_field1_wi_paper_mode = IF(is_as_field1_enabled = 1, IFNULL(as_field1_mandatory, 0) + 1, 0), as_field1_wo_paper_mode = IF(is_as_field1_enabled = 1, IFNULL(as_field1_mandatory, 0) + 1, 0), is_as_field1_wi_paper_published = IFNULL(is_as_field1_published, 0), is_as_field1_wo_paper_published = IFNULL(is_as_field1_published, 0);

UPDATE tbl_app_form_settings SET  as_field2_wi_paper_mode = IF(is_as_field2_enabled = 1, IFNULL(as_field2_mandatory, 0) + 1, 0), as_field2_wo_paper_mode = IF(is_as_field2_enabled = 1, IFNULL(as_field2_mandatory, 0) + 1, 0), is_as_field2_wi_paper_published = IFNULL(is_as_field2_published, 0), is_as_field2_wo_paper_published = IFNULL(is_as_field2_published, 0);

UPDATE tbl_app_form_settings SET  as_field3_wi_paper_mode = IF(is_as_field3_enabled = 1, IFNULL(as_field3_mandatory, 0) + 1, 0), as_field3_wo_paper_mode = IF(is_as_field3_enabled = 1, IFNULL(as_field3_mandatory, 0) + 1, 0), is_as_field3_wi_paper_published = IFNULL(is_as_field3_published, 0), is_as_field3_wo_paper_published = IFNULL(is_as_field3_published, 0);

UPDATE tbl_app_form_settings SET  as_field4_wi_paper_mode = IF(is_as_field4_enabled = 1, IFNULL(as_field4_mandatory, 0) + 1, 0), as_field4_wo_paper_mode = IF(is_as_field4_enabled = 1, IFNULL(as_field4_mandatory, 0) + 1, 0), is_as_field4_wi_paper_published = IFNULL(is_as_field4_published, 0), is_as_field4_wo_paper_published = IFNULL(is_as_field4_published, 0);

UPDATE tbl_app_form_settings SET  as_field5_wi_paper_mode = IF(is_as_field5_enabled = 1, IFNULL(as_field5_mandatory, 0) + 1, 0), as_field5_wo_paper_mode = IF(is_as_field5_enabled = 1, IFNULL(as_field5_mandatory, 0) + 1, 0), is_as_field5_wi_paper_published = IFNULL(is_as_field5_published, 0), is_as_field5_wo_paper_published = IFNULL(is_as_field5_published, 0);

UPDATE tbl_app_form_settings SET  pt_field1_wi_paper_mode = IF(is_pt_field1_enabled = 1, IFNULL(pt_field1_mandatory, 0) + 1, 0), pt_field1_wo_paper_mode = IF(is_pt_field1_enabled = 1, IFNULL(pt_field1_mandatory, 0) + 1, 0), is_pt_field1_wi_paper_published = IFNULL(is_pt_field1_published, 0), is_pt_field1_wo_paper_published = IFNULL(is_pt_field1_published, 0);

UPDATE tbl_app_form_settings SET  pt_field2_wi_paper_mode = IF(is_pt_field2_enabled = 1, IFNULL(pt_field2_mandatory, 0) + 1, 0), pt_field2_wo_paper_mode = IF(is_pt_field2_enabled = 1, IFNULL(pt_field2_mandatory, 0) + 1, 0), is_pt_field2_wi_paper_published = IFNULL(is_pt_field2_published, 0), is_pt_field2_wo_paper_published = IFNULL(is_pt_field2_published, 0);

UPDATE tbl_app_form_settings SET  pt_field3_wi_paper_mode = IF(is_pt_field3_enabled = 1, IFNULL(pt_field3_mandatory, 0) + 1, 0), pt_field3_wo_paper_mode = IF(is_pt_field3_enabled = 1, IFNULL(pt_field3_mandatory, 0) + 1, 0), is_pt_field3_wi_paper_published = IFNULL(is_pt_field3_published, 0), is_pt_field3_wo_paper_published = IFNULL(is_pt_field3_published, 0);

UPDATE tbl_app_form_settings SET  pt_field4_wi_paper_mode = IF(is_pt_field4_enabled = 1, IFNULL(pt_field4_mandatory, 0) + 1, 0), pt_field4_wo_paper_mode = IF(is_pt_field4_enabled = 1, IFNULL(pt_field4_mandatory, 0) + 1, 0), is_pt_field4_wi_paper_published = IFNULL(is_pt_field4_published, 0), is_pt_field4_wo_paper_published = IFNULL(is_pt_field4_published, 0);

UPDATE tbl_app_form_settings SET  pt_field5_wi_paper_mode = IF(is_pt_field5_enabled = 1, IFNULL(pt_field5_mandatory, 0) + 1, 0), pt_field5_wo_paper_mode = IF(is_pt_field5_enabled = 1, IFNULL(pt_field5_mandatory, 0) + 1, 0), is_pt_field5_wi_paper_published = IFNULL(is_pt_field5_published, 0), is_pt_field5_wo_paper_published = IFNULL(is_pt_field5_published, 0);

UPDATE tbl_app_form_settings SET  at_field1_wi_paper_mode = IF(is_at_field1_enabled = 1, IFNULL(at_field1_mandatory, 0) + 1, 0), at_field1_wo_paper_mode = IF(is_at_field1_enabled = 1, IFNULL(at_field1_mandatory, 0) + 1, 0), is_at_field1_wi_paper_published = IFNULL(is_at_field1_published, 0), is_at_field1_wo_paper_published = IFNULL(is_at_field1_published, 0);

UPDATE tbl_app_form_settings SET  at_field2_wi_paper_mode = IF(is_at_field2_enabled = 1, IFNULL(at_field2_mandatory, 0) + 1, 0), at_field2_wo_paper_mode = IF(is_at_field2_enabled = 1, IFNULL(at_field2_mandatory, 0) + 1, 0), is_at_field2_wi_paper_published = IFNULL(is_at_field2_published, 0), is_at_field2_wo_paper_published = IFNULL(is_at_field2_published, 0);

UPDATE tbl_app_form_settings SET  at_field3_wi_paper_mode = IF(is_at_field3_enabled = 1, IFNULL(at_field3_mandatory, 0) + 1, 0), at_field3_wo_paper_mode = IF(is_at_field3_enabled = 1, IFNULL(at_field3_mandatory, 0) + 1, 0), is_at_field3_wi_paper_published = IFNULL(is_at_field3_published, 0), is_at_field3_wo_paper_published = IFNULL(is_at_field3_published, 0);

UPDATE tbl_app_form_settings SET  at_field4_wi_paper_mode = IF(is_at_field4_enabled = 1, IFNULL(at_field4_mandatory, 0) + 1, 0), at_field4_wo_paper_mode = IF(is_at_field4_enabled = 1, IFNULL(at_field4_mandatory, 0) + 1, 0), is_at_field4_wi_paper_published = IFNULL(is_at_field4_published, 0), is_at_field4_wo_paper_published = IFNULL(is_at_field4_published, 0);

UPDATE tbl_app_form_settings SET  at_field5_wi_paper_mode = IF(is_at_field5_enabled = 1, IFNULL(at_field5_mandatory, 0) + 1, 0), at_field5_wo_paper_mode = IF(is_at_field5_enabled = 1, IFNULL(at_field5_mandatory, 0) + 1, 0), is_at_field5_wi_paper_published = IFNULL(is_at_field5_published, 0), is_at_field5_wo_paper_published = IFNULL(is_at_field5_published, 0);

UPDATE tbl_app_form_settings SET  pc_field1_wi_paper_mode = IF(is_pc_field1_enabled = 1, IFNULL(pc_field1_mandatory, 0) + 1, 0), pc_field1_wo_paper_mode = IF(is_pc_field1_enabled = 1, IFNULL(pc_field1_mandatory, 0) + 1, 0), is_pc_field1_wi_paper_published = IFNULL(is_pc_field1_published, 0), is_pc_field1_wo_paper_published = IFNULL(is_pc_field1_published, 0);

UPDATE tbl_app_form_settings SET  pc_field2_wi_paper_mode = IF(is_pc_field2_enabled = 1, IFNULL(pc_field2_mandatory, 0) + 1, 0), pc_field2_wo_paper_mode = IF(is_pc_field2_enabled = 1, IFNULL(pc_field2_mandatory, 0) + 1, 0), is_pc_field2_wi_paper_published = IFNULL(is_pc_field2_published, 0), is_pc_field2_wo_paper_published = IFNULL(is_pc_field2_published, 0);

UPDATE tbl_app_form_settings SET  pc_field3_wi_paper_mode = IF(is_pc_field3_enabled = 1, IFNULL(pc_field3_mandatory, 0) + 1, 0), pc_field3_wo_paper_mode = IF(is_pc_field3_enabled = 1, IFNULL(pc_field3_mandatory, 0) + 1, 0), is_pc_field3_wi_paper_published = IFNULL(is_pc_field3_published, 0), is_pc_field3_wo_paper_published = IFNULL(is_pc_field3_published, 0);

UPDATE tbl_app_form_settings SET  pc_field4_wi_paper_mode = IF(is_pc_field4_enabled = 1, IFNULL(pc_field4_mandatory, 0) + 1, 0), pc_field4_wo_paper_mode = IF(is_pc_field4_enabled = 1, IFNULL(pc_field4_mandatory, 0) + 1, 0), is_pc_field4_wi_paper_published = IFNULL(is_pc_field4_published, 0), is_pc_field4_wo_paper_published = IFNULL(is_pc_field4_published, 0);

UPDATE tbl_app_form_settings SET  pc_field5_wi_paper_mode = IF(is_pc_field5_enabled = 1, IFNULL(pc_field5_mandatory, 0) + 1, 0), pc_field5_wo_paper_mode = IF(is_pc_field5_enabled = 1, IFNULL(pc_field5_mandatory, 0) + 1, 0), is_pc_field5_wi_paper_published = IFNULL(is_pc_field5_published, 0), is_pc_field5_wo_paper_published = IFNULL(is_pc_field5_published, 0);

UPDATE tbl_app_form_settings SET  ac_field1_wi_paper_mode = IF(is_ac_field1_enabled = 1, IFNULL(ac_field1_mandatory, 0) + 1, 0), ac_field1_wo_paper_mode = IF(is_ac_field1_enabled = 1, IFNULL(ac_field1_mandatory, 0) + 1, 0), is_ac_field1_wi_paper_published = IFNULL(is_ac_field1_published, 0), is_ac_field1_wo_paper_published = IFNULL(is_ac_field1_published, 0);

UPDATE tbl_app_form_settings SET  ac_field2_wi_paper_mode = IF(is_ac_field2_enabled = 1, IFNULL(ac_field2_mandatory, 0) + 1, 0), ac_field2_wo_paper_mode = IF(is_ac_field2_enabled = 1, IFNULL(ac_field2_mandatory, 0) + 1, 0), is_ac_field2_wi_paper_published = IFNULL(is_ac_field2_published, 0), is_ac_field2_wo_paper_published = IFNULL(is_ac_field2_published, 0);

UPDATE tbl_app_form_settings SET  ac_field3_wi_paper_mode = IF(is_ac_field3_enabled = 1, IFNULL(ac_field3_mandatory, 0) + 1, 0), ac_field3_wo_paper_mode = IF(is_ac_field3_enabled = 1, IFNULL(ac_field3_mandatory, 0) + 1, 0), is_ac_field3_wi_paper_published = IFNULL(is_ac_field3_published, 0), is_ac_field3_wo_paper_published = IFNULL(is_ac_field3_published, 0);

UPDATE tbl_app_form_settings SET  ac_field4_wi_paper_mode = IF(is_ac_field4_enabled = 1, IFNULL(ac_field4_mandatory, 0) + 1, 0), ac_field4_wo_paper_mode = IF(is_ac_field4_enabled = 1, IFNULL(ac_field4_mandatory, 0) + 1, 0), is_ac_field4_wi_paper_published = IFNULL(is_ac_field4_published, 0), is_ac_field4_wo_paper_published = IFNULL(is_ac_field4_published, 0);

UPDATE tbl_app_form_settings SET  ac_field5_wi_paper_mode = IF(is_ac_field5_enabled = 1, IFNULL(ac_field5_mandatory, 0) + 1, 0), ac_field5_wo_paper_mode = IF(is_ac_field5_enabled = 1, IFNULL(ac_field5_mandatory, 0) + 1, 0), is_ac_field5_wi_paper_published = IFNULL(is_ac_field5_published, 0), is_ac_field5_wo_paper_published = IFNULL(is_ac_field5_published, 0);

UPDATE tbl_app_form_settings SET  pl_field1_wi_paper_mode = IF(is_pl_field1_enabled = 1, IFNULL(pl_field1_mandatory, 0) + 1, 0), pl_field1_wo_paper_mode = IF(is_pl_field1_enabled = 1, IFNULL(pl_field1_mandatory, 0) + 1, 0), is_pl_field1_wi_paper_published = IFNULL(is_pl_field1_published, 0), is_pl_field1_wo_paper_published = IFNULL(is_pl_field1_published, 0);

UPDATE tbl_app_form_settings SET  pl_field2_wi_paper_mode = IF(is_pl_field2_enabled = 1, IFNULL(pl_field2_mandatory, 0) + 1, 0), pl_field2_wo_paper_mode = IF(is_pl_field2_enabled = 1, IFNULL(pl_field2_mandatory, 0) + 1, 0), is_pl_field2_wi_paper_published = IFNULL(is_pl_field2_published, 0), is_pl_field2_wo_paper_published = IFNULL(is_pl_field2_published, 0);

UPDATE tbl_app_form_settings SET  pl_field3_wi_paper_mode = IF(is_pl_field3_enabled = 1, IFNULL(pl_field3_mandatory, 0) + 1, 0), pl_field3_wo_paper_mode = IF(is_pl_field3_enabled = 1, IFNULL(pl_field3_mandatory, 0) + 1, 0), is_pl_field3_wi_paper_published = IFNULL(is_pl_field3_published, 0), is_pl_field3_wo_paper_published = IFNULL(is_pl_field3_published, 0);

UPDATE tbl_app_form_settings SET  pl_field4_wi_paper_mode = IF(is_pl_field4_enabled = 1, IFNULL(pl_field4_mandatory, 0) + 1, 0), pl_field4_wo_paper_mode = IF(is_pl_field4_enabled = 1, IFNULL(pl_field4_mandatory, 0) + 1, 0), is_pl_field4_wi_paper_published = IFNULL(is_pl_field4_published, 0), is_pl_field4_wo_paper_published = IFNULL(is_pl_field4_published, 0);

UPDATE tbl_app_form_settings SET  pl_field5_wi_paper_mode = IF(is_pl_field5_enabled = 1, IFNULL(pl_field5_mandatory, 0) + 1, 0), pl_field5_wo_paper_mode = IF(is_pl_field5_enabled = 1, IFNULL(pl_field5_mandatory, 0) + 1, 0), is_pl_field5_wi_paper_published = IFNULL(is_pl_field5_published, 0), is_pl_field5_wo_paper_published = IFNULL(is_pl_field5_published, 0);

UPDATE tbl_app_form_settings SET  al_field1_wi_paper_mode = IF(is_al_field1_enabled = 1, IFNULL(al_field1_mandatory, 0) + 1, 0), al_field1_wo_paper_mode = IF(is_al_field1_enabled = 1, IFNULL(al_field1_mandatory, 0) + 1, 0), is_al_field1_wi_paper_published = IFNULL(is_al_field1_published, 0), is_al_field1_wo_paper_published = IFNULL(is_al_field1_published, 0);

UPDATE tbl_app_form_settings SET  al_field2_wi_paper_mode = IF(is_al_field2_enabled = 1, IFNULL(al_field2_mandatory, 0) + 1, 0), al_field2_wo_paper_mode = IF(is_al_field2_enabled = 1, IFNULL(al_field2_mandatory, 0) + 1, 0), is_al_field2_wi_paper_published = IFNULL(is_al_field2_published, 0), is_al_field2_wo_paper_published = IFNULL(is_al_field2_published, 0);

UPDATE tbl_app_form_settings SET  al_field3_wi_paper_mode = IF(is_al_field3_enabled = 1, IFNULL(al_field3_mandatory, 0) + 1, 0), al_field3_wo_paper_mode = IF(is_al_field3_enabled = 1, IFNULL(al_field3_mandatory, 0) + 1, 0), is_al_field3_wi_paper_published = IFNULL(is_al_field3_published, 0), is_al_field3_wo_paper_published = IFNULL(is_al_field3_published, 0);

UPDATE tbl_app_form_settings SET  al_field4_wi_paper_mode = IF(is_al_field4_enabled = 1, IFNULL(al_field4_mandatory, 0) + 1, 0), al_field4_wo_paper_mode = IF(is_al_field4_enabled = 1, IFNULL(al_field4_mandatory, 0) + 1, 0), is_al_field4_wi_paper_published = IFNULL(is_al_field4_published, 0), is_al_field4_wo_paper_published = IFNULL(is_al_field4_published, 0);

UPDATE tbl_app_form_settings SET  al_field5_wi_paper_mode = IF(is_al_field5_enabled = 1, IFNULL(al_field5_mandatory, 0) + 1, 0), al_field5_wo_paper_mode = IF(is_al_field5_enabled = 1, IFNULL(al_field5_mandatory, 0) + 1, 0), is_al_field5_wi_paper_published = IFNULL(is_al_field5_published, 0), is_al_field5_wo_paper_published = IFNULL(is_al_field5_published, 0);

UPDATE tbl_app_form_settings SET  pf_field1_wi_paper_mode = IF(is_pf_field1_enabled = 1, IFNULL(pf_field1_mandatory, 0) + 1, 0), pf_field1_wo_paper_mode = IF(is_pf_field1_enabled = 1, IFNULL(pf_field1_mandatory, 0) + 1, 0), is_pf_field1_wi_paper_published = IFNULL(is_pf_field1_published, 0), is_pf_field1_wo_paper_published = IFNULL(is_pf_field1_published, 0);

UPDATE tbl_app_form_settings SET  pf_field2_wi_paper_mode = IF(is_pf_field2_enabled = 1, IFNULL(pf_field2_mandatory, 0) + 1, 0), pf_field2_wo_paper_mode = IF(is_pf_field2_enabled = 1, IFNULL(pf_field2_mandatory, 0) + 1, 0), is_pf_field2_wi_paper_published = IFNULL(is_pf_field2_published, 0), is_pf_field2_wo_paper_published = IFNULL(is_pf_field2_published, 0);

UPDATE tbl_app_form_settings SET  pf_field3_wi_paper_mode = IF(is_pf_field3_enabled = 1, IFNULL(pf_field3_mandatory, 0) + 1, 0), pf_field3_wo_paper_mode = IF(is_pf_field3_enabled = 1, IFNULL(pf_field3_mandatory, 0) + 1, 0), is_pf_field3_wi_paper_published = IFNULL(is_pf_field3_published, 0), is_pf_field3_wo_paper_published = IFNULL(is_pf_field3_published, 0);

UPDATE tbl_app_form_settings SET  pf_field4_wi_paper_mode = IF(is_pf_field4_enabled = 1, IFNULL(pf_field4_mandatory, 0) + 1, 0), pf_field4_wo_paper_mode = IF(is_pf_field4_enabled = 1, IFNULL(pf_field4_mandatory, 0) + 1, 0), is_pf_field4_wi_paper_published = IFNULL(is_pf_field4_published, 0), is_pf_field4_wo_paper_published = IFNULL(is_pf_field4_published, 0);

UPDATE tbl_app_form_settings SET  pf_field5_wi_paper_mode = IF(is_pf_field5_enabled = 1, IFNULL(pf_field5_mandatory, 0) + 1, 0), pf_field5_wo_paper_mode = IF(is_pf_field5_enabled = 1, IFNULL(pf_field5_mandatory, 0) + 1, 0), is_pf_field5_wi_paper_published = IFNULL(is_pf_field5_published, 0), is_pf_field5_wo_paper_published = IFNULL(is_pf_field5_published, 0);

UPDATE tbl_app_form_settings SET  af_field1_wi_paper_mode = IF(is_af_field1_enabled = 1, IFNULL(af_field1_mandatory, 0) + 1, 0), af_field1_wo_paper_mode = IF(is_af_field1_enabled = 1, IFNULL(af_field1_mandatory, 0) + 1, 0), is_af_field1_wi_paper_published = IFNULL(is_af_field1_published, 0), is_af_field1_wo_paper_published = IFNULL(is_af_field1_published, 0);

UPDATE tbl_app_form_settings SET  af_field2_wi_paper_mode = IF(is_af_field2_enabled = 1, IFNULL(af_field2_mandatory, 0) + 1, 0), af_field2_wo_paper_mode = IF(is_af_field2_enabled = 1, IFNULL(af_field2_mandatory, 0) + 1, 0), is_af_field2_wi_paper_published = IFNULL(is_af_field2_published, 0), is_af_field2_wo_paper_published = IFNULL(is_af_field2_published, 0);

UPDATE tbl_app_form_settings SET  af_field3_wi_paper_mode = IF(is_af_field3_enabled = 1, IFNULL(af_field3_mandatory, 0) + 1, 0), af_field3_wo_paper_mode = IF(is_af_field3_enabled = 1, IFNULL(af_field3_mandatory, 0) + 1, 0), is_af_field3_wi_paper_published = IFNULL(is_af_field3_published, 0), is_af_field3_wo_paper_published = IFNULL(is_af_field3_published, 0);

UPDATE tbl_app_form_settings SET  af_field4_wi_paper_mode = IF(is_af_field4_enabled = 1, IFNULL(af_field4_mandatory, 0) + 1, 0), af_field4_wo_paper_mode = IF(is_af_field4_enabled = 1, IFNULL(af_field4_mandatory, 0) + 1, 0), is_af_field4_wi_paper_published = IFNULL(is_af_field4_published, 0), is_af_field4_wo_paper_published = IFNULL(is_af_field4_published, 0);

UPDATE tbl_app_form_settings SET  af_field5_wi_paper_mode = IF(is_af_field5_enabled = 1, IFNULL(af_field5_mandatory, 0) + 1, 0), af_field5_wo_paper_mode = IF(is_af_field5_enabled = 1, IFNULL(af_field5_mandatory, 0) + 1, 0), is_af_field5_wi_paper_published = IFNULL(is_af_field5_published, 0), is_af_field5_wo_paper_published = IFNULL(is_af_field5_published, 0);

ALTER TABLE tbl_app_form_settings DROP COLUMN `lastname_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_lastname_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `firstname_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_firstname_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `middlename_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_middlename_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `org_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_org_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `org_address_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_org_address_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `position_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_position_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `academic_degree_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_academic_degree_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `academic_title_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_academic_title_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `supervisor_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_supervisor_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `country_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_country_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `city_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_city_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `address_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_address_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `phone_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_phone_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `fax_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_fax_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `email_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_email_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `membership_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_membership_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `annotation_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_annotation_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `report_title_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_report_title_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `report_topic_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_report_topic_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `classification_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_classification_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `report_text_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_report_text_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `report_file_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_report_file_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `more_info_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_more_info_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `accommodation_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_accommodation_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `image_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_image_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `ps_field1_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_ps_field1_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `ps_field2_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_ps_field2_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `ps_field3_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_ps_field3_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `ps_field4_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_ps_field4_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `ps_field5_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_ps_field5_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `as_field1_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_as_field1_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `as_field2_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_as_field2_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `as_field3_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_as_field3_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `as_field4_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_as_field4_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `as_field5_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_as_field5_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pt_field1_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pt_field1_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pt_field2_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pt_field2_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pt_field3_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pt_field3_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pt_field4_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pt_field4_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pt_field5_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pt_field5_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `at_field1_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_at_field1_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `at_field2_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_at_field2_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `at_field3_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_at_field3_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `at_field4_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_at_field4_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `at_field5_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_at_field5_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pc_field1_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pc_field1_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pc_field2_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pc_field2_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pc_field3_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pc_field3_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pc_field4_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pc_field4_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pc_field5_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pc_field5_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `ac_field1_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_ac_field1_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `ac_field2_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_ac_field2_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `ac_field3_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_ac_field3_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `ac_field4_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_ac_field4_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `ac_field5_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_ac_field5_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pl_field1_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pl_field1_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pl_field2_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pl_field2_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pl_field3_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pl_field3_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pl_field4_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pl_field4_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pl_field5_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pl_field5_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `al_field1_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_al_field1_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `al_field2_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_al_field2_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `al_field3_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_al_field3_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `al_field4_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_al_field4_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `al_field5_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_al_field5_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pf_field1_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pf_field1_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pf_field2_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pf_field2_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pf_field3_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pf_field3_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pf_field4_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pf_field4_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `pf_field5_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_pf_field5_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `af_field1_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_af_field1_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `af_field2_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_af_field2_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `af_field3_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_af_field3_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `af_field4_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_af_field4_published`;

ALTER TABLE tbl_app_form_settings DROP COLUMN `af_field5_mandatory`;
ALTER TABLE tbl_app_form_settings DROP COLUMN `is_af_field5_published`;
