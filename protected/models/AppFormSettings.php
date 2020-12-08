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
class AppFormSettings extends ActiveRecord {

    public $is_lastname_enabled = true;
    public $is_firstname_enabled = true;
    public $is_middlename_enabled = true;
    public $is_org_enabled = true;
    public $is_org_address_enabled = true;
    public $is_position_enabled = true;
    public $is_academic_degree_enabled = true;
    public $is_academic_title_enabled = true;
    public $is_supervisor_enabled = false;
    public $is_country_enabled = true;
    public $is_city_enabled = true;
    public $is_address_enabled = false;
    public $is_phone_enabled = true;
    public $is_fax_enabled = false;
    public $is_email_enabled = true;
    public $is_membership_enabled = false;
    public $is_annotation_enabled = true;
    public $is_report_title_enabled = true;
    public $is_report_topic_enabled = true;
    public $is_classification_enabled = false;
    public $is_report_text_enabled = false;
    public $is_report_file_enabled = true;
    public $is_more_info_enabled = false;
    public $is_accommodation_enabled = false;
    public $is_image_enabled = false;

    const MODE_DISABLED = 0;
    const MODE_ENABLED = 1; // enabled, but optional
    const MODE_MANDATORY_ALL = 2; // mandatory in all languages
    const MODE_MANDATORY = 2; // synonym for MODE_MANDATORY_ALL
    const MODE_MANDATORY_ONE = 3; // mandatory at least in one language
    const MODE_MANDATORY_CURRENT = 4; // mandatory in current language
    const MODE_ENABLED_CURRENT = 5; // enabled in current language

    const MODE_OPTIONS_YES_NO = 1;
    const MODE_OPTIONS_ALL = 2;
    
    public $lastname_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $lastname_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $firstname_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $firstname_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $middlename_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $middlename_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $org_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $org_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $org_address_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $org_address_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $position_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $position_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $academic_degree_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $academic_degree_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $academic_title_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $academic_title_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $supervisor_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $supervisor_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $country_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $country_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $city_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $city_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $address_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $address_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $phone_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $phone_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $fax_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $fax_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $email_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $email_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $membership_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $membership_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $annotation_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $annotation_wo_paper_mode = AppFormSettings::MODE_DISABLED;
    public $report_title_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $report_title_wo_paper_mode = AppFormSettings::MODE_DISABLED;
    public $report_topic_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $report_topic_wo_paper_mode = AppFormSettings::MODE_DISABLED;
    public $classification_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $classification_wo_paper_mode = AppFormSettings::MODE_DISABLED;
    public $report_text_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $report_text_wo_paper_mode = AppFormSettings::MODE_DISABLED;
    public $report_file_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $report_file_wo_paper_mode = AppFormSettings::MODE_DISABLED;
    public $more_info_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $more_info_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $accommodation_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $accommodation_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $image_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $image_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $lastname_type = FieldType::STRING;
    public $firstname_type = FieldType::STRING;
    public $middlename_type = FieldType::STRING;
    public $org_type = FieldType::STRING;
    public $org_address_type = FieldType::STRING;
    public $position_type = FieldType::STRING;
    public $academic_degree_type = FieldType::STRING;
    public $academic_title_type = FieldType::STRING;
    public $supervisor_type = FieldType::STRING;
    public $country_type = FieldType::STRING;
    public $city_type = FieldType::STRING;
    public $address_type = FieldType::STRING;
    public $phone_type = FieldType::STRING;
    public $fax_type = FieldType::STRING;
    public $email_type = FieldType::STRING;
    public $membership_type = FieldType::STRING;
    public $annotation_type = FieldType::TEXT;
    public $report_title_type = FieldType::TEXT;
    public $report_topic_type = FieldType::SELECT;
    public $classification_type = FieldType::STRING;
    public $report_text_type = FieldType::TEXT;
    public $report_file_type = FieldType::FILE;
    public $more_info_type = FieldType::TEXT;
    public $accommodation_type = FieldType::CHECKBOX;
    public $image_type = FieldType::FILE;
    //многоязычные поля
    public $lastname_hint = NULL;
    public $firstname_hint = NULL;
    public $middlename_hint = NULL;
    public $org_hint = NULL;
    public $org_address_hint = NULL;
    public $position_hint = NULL;
    public $academic_degree_hint = NULL;
    public $academic_title_hint = NULL;
    public $supervisor_hint = NULL;
    public $country_hint = NULL;
    public $city_hint = NULL;
    public $address_hint = NULL;
    public $phone_hint = NULL;
    public $fax_hint = NULL;
    public $email_hint = NULL;
    public $membership_hint = NULL;
    public $annotation_hint = NULL;
    public $report_title_hint = NULL;
    public $report_topic_hint = NULL;
    public $classification_hint = NULL;
    public $report_text_hint = NULL;
    public $report_file_hint = NULL;
    public $more_info_hint = NULL;
    public $accommodation_hint = NULL;
    public $image_hint = NULL;
    public $is_lastname_wi_paper_published = true;
    public $is_lastname_wo_paper_published = true;
    public $is_firstname_wi_paper_published = true;
    public $is_firstname_wo_paper_published = true;
    public $is_middlename_wi_paper_published = true;
    public $is_middlename_wo_paper_published = true;
    public $is_org_wi_paper_published = true;
    public $is_org_wo_paper_published = true;
    public $is_org_address_wi_paper_published = true;
    public $is_org_address_wo_paper_published = true;
    public $is_position_wi_paper_published = true;
    public $is_position_wo_paper_published = true;
    public $is_academic_degree_wi_paper_published = true;
    public $is_academic_degree_wo_paper_published = true;
    public $is_academic_title_wi_paper_published = true;
    public $is_academic_title_wo_paper_published = true;
    public $is_supervisor_wi_paper_published = true;
    public $is_supervisor_wo_paper_published = true;
    public $is_country_wi_paper_published = true;
    public $is_country_wo_paper_published = true;
    public $is_city_wi_paper_published = true;
    public $is_city_wo_paper_published = true;
    public $is_address_wi_paper_published = true;
    public $is_address_wo_paper_published = true;
    public $is_phone_wi_paper_published = true;
    public $is_phone_wo_paper_published = true;
    public $is_fax_wi_paper_published = true;
    public $is_fax_wo_paper_published = true;
    public $is_email_wi_paper_published = true;
    public $is_email_wo_paper_published = true;
    public $is_membership_wi_paper_published = true;
    public $is_membership_wo_paper_published = true;
    public $is_annotation_wi_paper_published = true;
    public $is_annotation_wo_paper_published = false;
    public $is_report_title_wi_paper_published = true;
    public $is_report_title_wo_paper_published = false;
    public $is_report_topic_wi_paper_published = true;
    public $is_report_topic_wo_paper_published = true;
    public $is_classification_wi_paper_published = true;
    public $is_classification_wo_paper_published = false;
    public $is_report_text_wi_paper_published = true;
    public $is_report_text_wo_paper_published = false;
    public $is_report_file_wi_paper_published = true;
    public $is_report_file_wo_paper_published = false;
    public $is_more_info_wi_paper_published = true;
    public $is_more_info_wo_paper_published = true;
    public $is_accommodation_wi_paper_published = false;
    public $is_accommodation_wo_paper_published = false;
    public $is_image_wi_paper_published = false;
    public $is_image_wo_paper_published = false;
    // порядок отображения поля в форме
    // field order in application form
    public $lastname_order = 0;
    public $firstname_order = 0;
    public $middlename_order = 0;
    public $org_order = 0;
    public $org_address_order = 0;
    public $position_order = 0;
    public $academic_degree_order = 0;
    public $academic_title_order = 0;
    public $supervisor_order = 0;
    public $country_order = 0;
    public $city_order = 0;
    public $address_order = 0;
    public $phone_order = 0;
    public $fax_order = 0;
    public $email_order = 0;
    public $membership_order = 0;
    public $annotation_order = 0;
    public $report_title_order = 0;
    public $report_topic_order = 0;
    public $classification_order = 0;
    public $report_text_order = 0;
    public $report_file_order = 0;
    public $more_info_order = 0;
    public $accommodation_order = 0;
    public $image_order = 0;
    // порядок для блока с авторами
    // order for authors block
    public $authors_order = 0;
    //  дополнительные строковые поля для заявки на участие
    //  additional string fields for an application form
    public $ps_field1_name = NULL;
    public $ps_field1_type = FieldType::STRING;
    public $is_ps_field1_enabled = false;
    public $ps_field1_order = 0;
    public $is_ps_field1_wi_paper_published = false;
    public $is_ps_field1_wo_paper_published = false;
    public $ps_field1_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ps_field1_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ps_field1_hint = NULL;
    public $ps_field2_name = NULL;
    public $ps_field2_type = FieldType::STRING;
    public $is_ps_field2_enabled = false;
    public $ps_field2_order = 0;
    public $is_ps_field2_wi_paper_published = false;
    public $is_ps_field2_wo_paper_published = false;
    public $ps_field2_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ps_field2_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ps_field2_hint = NULL;
    public $ps_field3_name = NULL;
    public $ps_field3_type = FieldType::STRING;
    public $is_ps_field3_enabled = false;
    public $ps_field3_order = 0;
    public $is_ps_field3_wi_paper_published = false;
    public $is_ps_field3_wo_paper_published = false;
    public $ps_field3_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ps_field3_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ps_field3_hint = NULL;
    public $ps_field4_name = NULL;
    public $ps_field4_type = FieldType::STRING;
    public $is_ps_field4_enabled = false;
    public $ps_field4_order = 0;
    public $is_ps_field4_wi_paper_published = false;
    public $is_ps_field4_wo_paper_published = false;
    public $ps_field4_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ps_field4_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ps_field4_hint = NULL;
    public $ps_field5_name = NULL;
    public $ps_field5_type = FieldType::STRING;
    public $is_ps_field5_enabled = false;
    public $ps_field5_order = 0;
    public $is_ps_field5_wi_paper_published = false;
    public $is_ps_field5_wo_paper_published = false;
    public $ps_field5_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ps_field5_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ps_field5_hint = NULL;
    //  дополнительные строковые поля для автора
    //  additional string fields for author
    public $as_field1_name = NULL;
    public $as_field1_type = FieldType::STRING;
    public $is_as_field1_enabled = false;
    public $as_field1_order = 0;
    public $is_as_field1_wi_paper_published = false;
    public $is_as_field1_wo_paper_published = false;
    public $as_field1_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $as_field1_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $as_field1_hint = NULL;
    public $as_field2_name = NULL;
    public $as_field2_type = FieldType::STRING;
    public $is_as_field2_enabled = false;
    public $as_field2_order = 0;
    public $is_as_field2_wi_paper_published = false;
    public $is_as_field2_wo_paper_published = false;
    public $as_field2_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $as_field2_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $as_field2_hint = NULL;
    public $as_field3_name = NULL;
    public $as_field3_type = FieldType::STRING;
    public $is_as_field3_enabled = false;
    public $as_field3_order = 0;
    public $is_as_field3_wi_paper_published = false;
    public $is_as_field3_wo_paper_published = false;
    public $as_field3_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $as_field3_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $as_field3_hint = NULL;
    public $as_field4_name = NULL;
    public $as_field4_type = FieldType::STRING;
    public $is_as_field4_enabled = false;
    public $as_field4_order = 0;
    public $is_as_field4_wi_paper_published = false;
    public $is_as_field4_wo_paper_published = false;
    public $as_field4_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $as_field4_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $as_field4_hint = NULL;
    public $as_field5_name = NULL;
    public $as_field5_type = FieldType::STRING;
    public $is_as_field5_enabled = false;
    public $as_field5_order = 0;
    public $is_as_field5_wi_paper_published = false;
    public $is_as_field5_wo_paper_published = false;
    public $as_field5_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $as_field5_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $as_field5_hint = NULL;
    //  дополнительные текстовые поля для заявки на участие
    //  additional text fields for the application form
    public $pt_field1_name = NULL;
    public $pt_field1_type = FieldType::TEXT;
    public $is_pt_field1_enabled = false;
    public $pt_field1_order = 0;
    public $is_pt_field1_wi_paper_published = false;
    public $is_pt_field1_wo_paper_published = false;
    public $pt_field1_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pt_field1_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pt_field1_hint;
    public $pt_field2_name = NULL;
    public $pt_field2_type = FieldType::TEXT;
    public $is_pt_field2_enabled = false;
    public $pt_field2_order = 0;
    public $is_pt_field2_wi_paper_published = false;
    public $is_pt_field2_wo_paper_published = false;
    public $pt_field2_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pt_field2_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pt_field2_hint = NULL;
    public $pt_field3_name = NULL;
    public $pt_field3_type = FieldType::TEXT;
    public $is_pt_field3_enabled = false;
    public $pt_field3_order = 0;
    public $is_pt_field3_wi_paper_published = false;
    public $is_pt_field3_wo_paper_published = false;
    public $pt_field3_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pt_field3_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pt_field3_hint = NULL;
    public $pt_field4_name = NULL;
    public $pt_field4_type = FieldType::TEXT;
    public $is_pt_field4_enabled = false;
    public $pt_field4_order = 0;
    public $is_pt_field4_wi_paper_published = false;
    public $is_pt_field4_wo_paper_published = false;
    public $pt_field4_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pt_field4_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pt_field4_hint = NULL;
    public $pt_field5_name = NULL;
    public $pt_field5_type = FieldType::TEXT;
    public $is_pt_field5_enabled = false;
    public $pt_field5_order = 0;
    public $is_pt_field5_wi_paper_published = false;
    public $is_pt_field5_wo_paper_published = false;
    public $pt_field5_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pt_field5_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pt_field5_hint = NULL;
    //  дополнительные текстовые поля для автора
    //  additional text fields for author
    public $at_field1_name = NULL;
    public $at_field1_type = FieldType::TEXT;
    public $is_at_field1_enabled = false;
    public $at_field1_order = 0;
    public $is_at_field1_wi_paper_published = false;
    public $is_at_field1_wo_paper_published = false;
    public $at_field1_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $at_field1_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $at_field1_hint = NULL;
    public $at_field2_name = NULL;
    public $at_field2_type = FieldType::TEXT;
    public $is_at_field2_enabled = false;
    public $at_field2_order = 0;
    public $is_at_field2_wi_paper_published = false;
    public $is_at_field2_wo_paper_published = false;
    public $at_field2_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $at_field2_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $at_field2_hint = NULL;
    public $at_field3_name = NULL;
    public $at_field3_type = FieldType::TEXT;
    public $is_at_field3_enabled = false;
    public $at_field3_order = 0;
    public $is_at_field3_wi_paper_published = false;
    public $is_at_field3_wo_paper_published = false;
    public $at_field3_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $at_field3_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $at_field3_hint = NULL;
    public $at_field4_name = NULL;
    public $at_field4_type = FieldType::TEXT;
    public $is_at_field4_enabled = false;
    public $at_field4_order = 0;
    public $is_at_field4_wi_paper_published = false;
    public $is_at_field4_wo_paper_published = false;
    public $at_field4_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $at_field4_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $at_field4_hint = NULL;
    public $at_field5_name = NULL;
    public $at_field5_type = FieldType::TEXT;
    public $is_at_field5_enabled = false;
    public $at_field5_order = 0;
    public $is_at_field5_wi_paper_published = false;
    public $is_at_field5_wo_paper_published = false;
    public $at_field5_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $at_field5_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $at_field5_hint = NULL;
    //  дополнительные поля-флажки для заявки на участие
    //  additional checkbox fields for the application form 
    public $pc_field1_name = NULL;
    public $pc_field1_type = FieldType::CHECKBOX;
    public $is_pc_field1_enabled = false;
    public $pc_field1_order = 0;
    public $is_pc_field1_wi_paper_published = false;
    public $is_pc_field1_wo_paper_published = false;
    public $pc_field1_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pc_field1_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pc_field1_hint = NULL;
    public $pc_field2_name = NULL;
    public $pc_field2_type = FieldType::CHECKBOX;
    public $is_pc_field2_enabled = false;
    public $pc_field2_order = 0;
    public $is_pc_field2_wi_paper_published = false;
    public $is_pc_field2_wo_paper_published = false;
    public $pc_field2_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pc_field2_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pc_field2_hint = NULL;
    public $pc_field3_name = NULL;
    public $pc_field3_type = FieldType::CHECKBOX;
    public $is_pc_field3_enabled = false;
    public $pc_field3_order = 0;
    public $is_pc_field3_wi_paper_published = false;
    public $is_pc_field3_wo_paper_published = false;
    public $pc_field3_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pc_field3_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pc_field3_hint = NULL;
    public $pc_field4_name = NULL;
    public $pc_field4_type = FieldType::CHECKBOX;
    public $is_pc_field4_enabled = false;
    public $pc_field4_order = 0;
    public $is_pc_field4_wi_paper_published = false;
    public $is_pc_field4_wo_paper_published = false;
    public $pc_field4_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pc_field4_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pc_field4_hint = NULL;
    public $pc_field5_name = NULL;
    public $pc_field5_type = FieldType::CHECKBOX;
    public $is_pc_field5_enabled = false;
    public $pc_field5_order = 0;
    public $is_pc_field5_wi_paper_published = false;
    public $is_pc_field5_wo_paper_published = false;
    public $pc_field5_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pc_field5_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pc_field5_hint = NULL;
    //  дополнительные поля-флажки для автора
    //  additional checkbox fields for author
    public $ac_field1_name = NULL;
    public $ac_field1_type = FieldType::CHECKBOX;
    public $is_ac_field1_enabled = false;
    public $ac_field1_order = 0;
    public $is_ac_field1_wi_paper_published = false;
    public $is_ac_field1_wo_paper_published = false;
    public $ac_field1_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ac_field1_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ac_field1_hint = NULL;
    public $ac_field2_name = NULL;
    public $ac_field2_type = FieldType::CHECKBOX;
    public $is_ac_field2_enabled = false;
    public $ac_field2_order = 0;
    public $is_ac_field2_wi_paper_published = false;
    public $is_ac_field2_wo_paper_published = false;
    public $ac_field2_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ac_field2_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ac_field2_hint = NULL;
    public $ac_field3_name = NULL;
    public $ac_field3_type = FieldType::CHECKBOX;
    public $is_ac_field3_enabled = false;
    public $ac_field3_order = 0;
    public $is_ac_field3_wi_paper_published = false;
    public $is_ac_field3_wo_paper_published = false;
    public $ac_field3_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ac_field3_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ac_field3_hint = NULL;
    public $ac_field4_name = NULL;
    public $ac_field4_type = FieldType::CHECKBOX;
    public $is_ac_field4_enabled = false;
    public $ac_field4_order = 0;
    public $is_ac_field4_wi_paper_published = false;
    public $is_ac_field4_wo_paper_published = false;
    public $ac_field4_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ac_field4_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ac_field4_hint = NULL;
    public $ac_field5_name = NULL;
    public $ac_field5_type = FieldType::CHECKBOX;
    public $is_ac_field5_enabled = false;
    public $ac_field5_order = 0;
    public $is_ac_field5_wi_paper_published = false;
    public $is_ac_field5_wo_paper_published = false;
    public $ac_field5_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ac_field5_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $ac_field5_hint = NULL;
    //  дополнительные поля-списки для заявки на участие
    //  additional list fields for the application form
    public $pl_field1_name = NULL;
    public $pl_field1_type = FieldType::SELECT;
    public $is_pl_field1_enabled = false;
    public $pl_field1_order = 0;
    public $is_pl_field1_wi_paper_published = false;
    public $is_pl_field1_wo_paper_published = false;
    public $pl_field1_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pl_field1_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pl_field1_hint = NULL;
    public $pl_field1_list_id = 0;
    public $pl_field2_name = NULL;
    public $pl_field2_type = FieldType::SELECT;
    public $is_pl_field2_enabled = false;
    public $pl_field2_order = 0;
    public $is_pl_field2_wi_paper_published = false;
    public $is_pl_field2_wo_paper_published = false;
    public $pl_field2_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pl_field2_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pl_field2_hint = NULL;
    public $pl_field2_list_id = 0;
    public $pl_field3_name = NULL;
    public $pl_field3_type = FieldType::SELECT;
    public $is_pl_field3_enabled = false;
    public $pl_field3_order = 0;
    public $is_pl_field3_wi_paper_published = false;
    public $is_pl_field3_wo_paper_published = false;
    public $pl_field3_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pl_field3_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pl_field3_hint = NULL;
    public $pl_field3_list_id = 0;
    public $pl_field4_name = NULL;
    public $pl_field4_type = FieldType::SELECT;
    public $is_pl_field4_enabled = false;
    public $pl_field4_order = 0;
    public $is_pl_field4_wi_paper_published = false;
    public $is_pl_field4_wo_paper_published = false;
    public $pl_field4_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pl_field4_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pl_field4_hint = NULL;
    public $pl_field4_list_id = 0;
    public $pl_field5_name = NULL;
    public $pl_field5_type = FieldType::SELECT;
    public $is_pl_field5_enabled = false;
    public $pl_field5_order = 0;
    public $is_pl_field5_wi_paper_published = false;
    public $is_pl_field5_wo_paper_published = false;
    public $pl_field5_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pl_field5_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pl_field5_hint = NULL;
    public $pl_field5_list_id = 0;
    //  дополнительные поля-списки для автора
    //  additional list fields for author
    public $al_field1_name = NULL;
    public $al_field1_type = FieldType::SELECT;
    public $is_al_field1_enabled = false;
    public $al_field1_order = 0;
    public $is_al_field1_wi_paper_published = false;
    public $is_al_field1_wo_paper_published = false;
    public $al_field1_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $al_field1_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $al_field1_hint = NULL;
    public $al_field1_list_id = 0;
    public $al_field2_name = NULL;
    public $al_field2_type = FieldType::SELECT;
    public $is_al_field2_enabled = false;
    public $al_field2_order = 0;
    public $is_al_field2_wi_paper_published = false;
    public $is_al_field2_wo_paper_published = false;
    public $al_field2_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $al_field2_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $al_field2_hint = NULL;
    public $al_field2_list_id = 0;
    public $al_field3_name = NULL;
    public $al_field3_type = FieldType::SELECT;
    public $is_al_field3_enabled = false;
    public $al_field3_order = 0;
    public $is_al_field3_wi_paper_published = false;
    public $is_al_field3_wo_paper_published = false;
    public $al_field3_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $al_field3_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $al_field3_hint = NULL;
    public $al_field3_list_id = 0;
    public $al_field4_name = NULL;
    public $al_field4_type = FieldType::SELECT;
    public $is_al_field4_enabled = false;
    public $al_field4_order = 0;
    public $is_al_field4_wi_paper_published = false;
    public $is_al_field4_wo_paper_published = false;
    public $al_field4_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $al_field4_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $al_field4_hint = NULL;
    public $al_field4_list_id = 0;
    public $al_field5_name = NULL;
    public $al_field5_type = FieldType::SELECT;
    public $is_al_field5_enabled = false;
    public $al_field5_order = 0;
    public $is_al_field5_wi_paper_published = false;
    public $is_al_field5_wo_paper_published = false;
    public $al_field5_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $al_field5_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $al_field5_hint = NULL;
    public $al_field5_list_id = 0;
    // дополнительные файловые поля для заявки на участие
    // additional file fields for the application form
    public $pf_field1_name = NULL;
    public $pf_field1_type = FieldType::FILE;
    public $is_pf_field1_enabled = false;
    public $pf_field1_order = 0;
    public $is_pf_field1_wi_paper_published = false;
    public $is_pf_field1_wo_paper_published = false;
    public $pf_field1_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pf_field1_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pf_field1_hint = NULL;
    public $pf_field2_name = NULL;
    public $pf_field2_type = FieldType::FILE;
    public $is_pf_field2_enabled = false;
    public $pf_field2_order = 0;
    public $is_pf_field2_wi_paper_published = false;
    public $is_pf_field2_wo_paper_published = false;
    public $pf_field2_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pf_field2_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pf_field2_hint = NULL;
    public $pf_field3_name = NULL;
    public $pf_field3_type = FieldType::FILE;
    public $is_pf_field3_enabled = false;
    public $pf_field3_order = 0;
    public $is_pf_field3_wi_paper_published = false;
    public $is_pf_field3_wo_paper_published = false;
    public $pf_field3_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pf_field3_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pf_field3_hint = NULL;
    public $pf_field4_name = NULL;
    public $pf_field4_type = FieldType::FILE;
    public $is_pf_field4_enabled = false;
    public $pf_field4_order = 0;
    public $is_pf_field4_wi_paper_published = false;
    public $is_pf_field4_wo_paper_published = false;
    public $pf_field4_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pf_field4_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pf_field4_hint = NULL;
    public $pf_field5_name = NULL;
    public $pf_field5_type = FieldType::FILE;
    public $is_pf_field5_enabled = false;
    public $pf_field5_order = 0;
    public $is_pf_field5_wi_paper_published = false;
    public $is_pf_field5_wo_paper_published = false;
    public $pf_field5_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pf_field5_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $pf_field5_hint = NULL;
    // дополнительные файловые поля для авторов
    // additional file fields for author
    public $af_field1_name = NULL;
    public $af_field1_type = FieldType::FILE;
    public $is_af_field1_enabled = false;
    public $af_field1_order = 0;
    public $is_af_field1_wi_paper_published = false;
    public $is_af_field1_wo_paper_published = false;
    public $af_field1_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $af_field1_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $af_field1_hint = NULL;
    public $af_field2_name = NULL;
    public $af_field2_type = FieldType::FILE;
    public $is_af_field2_enabled = false;
    public $af_field2_order = 0;
    public $is_af_field2_wi_paper_published = false;
    public $is_af_field2_wo_paper_published = false;
    public $af_field2_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $af_field2_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $af_field2_hint = NULL;
    public $af_field3_name = NULL;
    public $af_field3_type = FieldType::FILE;
    public $is_af_field3_enabled = false;
    public $af_field3_order = 0;
    public $is_af_field3_wi_paper_published = false;
    public $is_af_field3_wo_paper_published = false;
    public $af_field3_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $af_field3_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $af_field3_hint = NULL;
    public $af_field4_name = NULL;
    public $af_field4_type = FieldType::FILE;
    public $is_af_field4_enabled = false;
    public $af_field4_order = 0;
    public $is_af_field4_wi_paper_published = false;
    public $is_af_field4_wo_paper_published = false;
    public $af_field4_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $af_field4_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $af_field4_hint = NULL;
    public $af_field5_name = NULL;
    public $af_field5_type = FieldType::FILE;
    public $is_af_field5_enabled = false;
    public $af_field5_order = 0;
    public $is_af_field5_wi_paper_published = false;
    public $is_af_field5_wo_paper_published = false;
    public $af_field5_wi_paper_mode = AppFormSettings::MODE_ENABLED;
    public $af_field5_wo_paper_mode = AppFormSettings::MODE_ENABLED;
    public $af_field5_hint = NULL;
    // вспомогательные поля
    // auxiliary attributes
    public $new_pattribute = '';
    public $new_aattribute = '';
    public $conf = NULL;
    protected static $STANDARD_AATTRIBUTES = array(
        'email',
        'lastname', 'firstname', 'middlename',
        'image',
        'phone', 'fax',
        'org', 'org_address', 'position',
        'academic_degree', 'academic_title', 'supervisor',
        'country', 'city', 'address',
        'membership');
    protected static $ADDITIONAL_AATTRIBUTES = array(
        'as_field', 'at_field', 'ac_field', 'al_field', 'af_field');
    protected static $STANDARD_PATTRIBUTES = array(
        'report_topic',
        'report_title',
        'classification',
        'annotation',
        'report_text',
        'report_file',
        'more_info',
        'accommodation');
    protected static $ADDITIONAL_PATTRIBUTES = array(
        'ps_field', 'pt_field', 'pc_field', 'pl_field', 'pf_field');

    protected function allStandardAttributes() {
        return array_merge(AppFormSettings::$STANDARD_PATTRIBUTES, AppFormSettings::$STANDARD_AATTRIBUTES);
    }

    protected function allAdditionalAttributes() {
        return array_merge(AppFormSettings::$ADDITIONAL_PATTRIBUTES, AppFormSettings::$ADDITIONAL_AATTRIBUTES);
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{app_form_settings}}';
    }

    public function attributeLabels() {
        return array(
            'lastname' => Yii::t('participants', 'Last Name'),
            'firstname' => Yii::t('participants', 'First Name'),
            'middlename' => Yii::t('participants', 'Middle Name'),
            'org' => Yii::t('participants', 'Institution'),
            'org_address' => Yii::t('participants', 'Institution Address'),
            'position' => Yii::t('participants', 'Position'),
            'academic_degree' => Yii::t('participants', 'Academic Degree'),
            'academic_title' => Yii::t('participants', 'Academic Title'),
            'supervisor' => Yii::t('participants', 'Supervisor'),
            'country' => Yii::t('participants', 'Country'),
            'city' => Yii::t('participants', 'City'),
            'address' => Yii::t('participants', 'Home Address'),
            'phone' => Yii::t('participants', 'Phone'),
            'fax' => Yii::t('participants', 'Fax'),
            'email' => Yii::t('participants', 'E-mail'),
            'membership' => Yii::t('participants', 'Membership'),
            'annotation' => Yii::t('participants', 'Annotation'),
            'report_title' => Yii::t('participants', 'Title'),
            'report_topic' => Yii::t('participants', 'Topic'),
            'classification' => Yii::t('participants', 'Classification Code'),
            'report_text' => Yii::t('participants', 'Report Text'),
            'report_file' => Yii::t('participants', 'Paper Files'),
            'more_info' => Yii::t('participants', 'Additional Information'),
            'accommodation' => Yii::t('participants', 'Accommodation Required'),
            'image' => Yii::t('participants', 'Image')
        );
    }

    public function rules() {
        return array(
            array('id', 'unsafe'),
            array('is_lastname_enabled', 'boolean', 'on' => 'save'),
            array('is_firstname_enabled', 'boolean', 'on' => 'save'),
            array('is_middlename_enabled', 'boolean', 'on' => 'save'),
            array('is_org_enabled', 'boolean', 'on' => 'save'),
            array('is_org_address_enabled', 'boolean', 'on' => 'save'),
            array('is_position_enabled', 'boolean', 'on' => 'save'),
            array('is_academic_degree_enabled', 'boolean', 'on' => 'save'),
            array('is_academic_title_enabled', 'boolean', 'on' => 'save'),
            array('is_supervisor_enabled', 'boolean', 'on' => 'save'),
            array('is_country_enabled', 'boolean', 'on' => 'save'),
            array('is_city_enabled', 'boolean', 'on' => 'save'),
            array('is_address_enabled', 'boolean', 'on' => 'save'),
            array('is_phone_enabled', 'boolean', 'on' => 'save'),
            array('is_fax_enabled', 'boolean', 'on' => 'save'),
            array('is_email_enabled', 'boolean', 'on' => 'save'),
            array('is_membership_enabled', 'boolean', 'on' => 'save'),
            array('is_annotation_enabled', 'boolean', 'on' => 'save'),
            array('is_report_title_enabled', 'boolean', 'on' => 'save'),
            array('is_report_topic_enabled', 'boolean', 'on' => 'save'),
            array('is_classification_enabled', 'boolean', 'on' => 'save'),
            array('is_report_text_enabled', 'boolean', 'on' => 'save'),
            array('is_report_file_enabled', 'boolean', 'on' => 'save'),
            array('is_more_info_enabled', 'boolean', 'on' => 'save'),
            array('is_accommodation_enabled', 'boolean', 'on' => 'save'),
            array('is_image_enabled', 'boolean', 'on' => 'save'),
            array('lastname_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('lastname_wi_paper_mode', 'in', 'range' => array('1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('lastname_wo_paper_mode', 'in', 'range' => array('1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_lastname_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_lastname_wo_paper_published', 'boolean', 'on' => 'save'),
            array('firstname_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('firstname_wi_paper_mode', 'in', 'range' => array('1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('firstname_wo_paper_mode', 'in', 'range' => array('1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_firstname_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_firstname_wo_paper_published', 'boolean', 'on' => 'save'),
            array('middlename_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('middlename_wi_paper_mode', 'in', 'range' => array('1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('middlename_wo_paper_mode', 'in', 'range' => array('1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_middlename_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_middlename_wo_paper_published', 'boolean', 'on' => 'save'),
            array('org_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('org_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4' , '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('org_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4' , '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_org_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_org_wo_paper_published', 'boolean', 'on' => 'save'),
            array('org_address_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('org_address_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('org_address_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_org_address_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_org_address_wo_paper_published', 'boolean', 'on' => 'save'),
            array('position_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('position_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('position_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_position_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_position_wo_paper_published', 'boolean', 'on' => 'save'),
            array('academic_degree_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('academic_degree_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('academic_degree_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_academic_degree_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_academic_degree_wo_paper_published', 'boolean', 'on' => 'save'),
            array('academic_title_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('academic_title_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('academic_title_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_academic_title_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_academic_title_wo_paper_published', 'boolean', 'on' => 'save'),
            array('supervisor_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('supervisor_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('supervisor_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_supervisor_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_supervisor_wo_paper_published', 'boolean', 'on' => 'save'),
            array('country_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('country_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('country_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_country_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_country_wo_paper_published', 'boolean', 'on' => 'save'),
            array('city_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('city_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('city_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_city_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_city_wo_paper_published', 'boolean', 'on' => 'save'),
            array('address_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('address_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('address_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_address_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_address_wo_paper_published', 'boolean', 'on' => 'save'),
            array('phone_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('phone_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('phone_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_phone_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_phone_wo_paper_published', 'boolean', 'on' => 'save'),
            array('fax_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('fax_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('fax_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_fax_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_fax_wo_paper_published', 'boolean', 'on' => 'save'),
            array('email_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('email_wi_paper_mode', 'in', 'range' => array('1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('email_wo_paper_mode', 'in', 'range' => array('1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_email_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_email_wo_paper_published', 'boolean', 'on' => 'save'),
            array('membership_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('membership_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('membership_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_membership_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_membership_wo_paper_published', 'boolean', 'on' => 'save'),
            array('annotation_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('annotation_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('annotation_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_annotation_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_annotation_wo_paper_published', 'boolean', 'on' => 'save'),
            array('report_title_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('report_title_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('report_title_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_report_title_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_report_title_wo_paper_published', 'boolean', 'on' => 'save'),
            array('report_topic_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('report_topic_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('report_topic_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_report_topic_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_report_topic_wo_paper_published', 'boolean', 'on' => 'save'),
            array('classification_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('classification_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('classification_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_classification_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_classification_wo_paper_published', 'boolean', 'on' => 'save'),
            array('report_text_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('report_text_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('report_text_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_report_text_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_report_text_wo_paper_published', 'boolean', 'on' => 'save'),
            array('report_file_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('report_file_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('report_file_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_report_file_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_report_file_wo_paper_published', 'boolean', 'on' => 'save'),
            array('more_info_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('more_info_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('more_info_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_more_info_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_more_info_wo_paper_published', 'boolean', 'on' => 'save'),
            array('accommodation_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('accommodation_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('accommodation_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_accommodation_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_accommodation_wo_paper_published', 'boolean', 'on' => 'save'),
            array('image_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('image_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('image_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('is_image_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_image_wo_paper_published', 'boolean', 'on' => 'save'),
            array('authors_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('lastname_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('firstname_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('middlename_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('org_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('org_address_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('position_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('academic_degree_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('academic_title_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('supervisor_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('country_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('city_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('address_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('phone_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('fax_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('email_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('membership_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('annotation_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('report_title_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('report_topic_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('classification_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('report_text_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('report_file_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('more_info_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('accommodation_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('image_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            //  дополнительные строковые поля в заявке на участие
            //  additional string fields for the application form
            array('ps_field1_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_ps_field1_enabled', 'boolean', 'on' => 'save'),
            array('ps_field1_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_ps_field1_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_ps_field1_wo_paper_published', 'boolean', 'on' => 'save'),
            array('ps_field1_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('ps_field1_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('ps_field1_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('ps_field2_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_ps_field2_enabled', 'boolean', 'on' => 'save'),
            array('ps_field2_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_ps_field2_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_ps_field2_wo_paper_published', 'boolean', 'on' => 'save'),
            array('ps_field2_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('ps_field2_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('ps_field2_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('ps_field3_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_ps_field3_enabled', 'boolean', 'on' => 'save'),
            array('ps_field3_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_ps_field3_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_ps_field3_wo_paper_published', 'boolean', 'on' => 'save'),
            array('ps_field3_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('ps_field3_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('ps_field3_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('ps_field4_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_ps_field4_enabled', 'boolean', 'on' => 'save'),
            array('ps_field4_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_ps_field4_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_ps_field4_wo_paper_published', 'boolean', 'on' => 'save'),
            array('ps_field4_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('ps_field4_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('ps_field4_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('ps_field5_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_ps_field5_enabled', 'boolean', 'on' => 'save'),
            array('ps_field5_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_ps_field5_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_ps_field5_wo_paper_published', 'boolean', 'on' => 'save'),
            array('ps_field5_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('ps_field5_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('ps_field5_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            //  дополнительные строковые поля автора
            //  additional string fields for author
            array('as_field1_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_as_field1_enabled', 'boolean', 'on' => 'save'),
            array('as_field1_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_as_field1_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_as_field1_wo_paper_published', 'boolean', 'on' => 'save'),
            array('as_field1_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('as_field1_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('as_field1_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('as_field2_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_as_field2_enabled', 'boolean', 'on' => 'save'),
            array('as_field2_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_as_field2_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_as_field2_wo_paper_published', 'boolean', 'on' => 'save'),
            array('as_field2_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('as_field2_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('as_field2_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('as_field3_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_as_field3_enabled', 'boolean', 'on' => 'save'),
            array('as_field3_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_as_field3_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_as_field3_wo_paper_published', 'boolean', 'on' => 'save'),
            array('as_field3_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('as_field3_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('as_field3_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('as_field4_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_as_field4_enabled', 'boolean', 'on' => 'save'),
            array('as_field4_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_as_field4_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_as_field4_wo_paper_published', 'boolean', 'on' => 'save'),
            array('as_field4_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('as_field4_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('as_field4_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('as_field5_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_as_field5_enabled', 'boolean', 'on' => 'save'),
            array('as_field5_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_as_field5_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_as_field5_wo_paper_published', 'boolean', 'on' => 'save'),
            array('as_field5_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('as_field5_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('as_field5_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            //  дополнительные текстовые поля в заявке на участие
            //  additional text fields for the application form
            array('pt_field1_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pt_field1_enabled', 'boolean', 'on' => 'save'),
            array('pt_field1_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pt_field1_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pt_field1_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pt_field1_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pt_field1_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pt_field1_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('pt_field2_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pt_field2_enabled', 'boolean', 'on' => 'save'),
            array('pt_field2_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pt_field2_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pt_field2_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pt_field2_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pt_field2_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pt_field2_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('pt_field3_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pt_field3_enabled', 'boolean', 'on' => 'save'),
            array('pt_field3_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pt_field3_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pt_field3_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pt_field3_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pt_field3_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pt_field3_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('pt_field4_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pt_field4_enabled', 'boolean', 'on' => 'save'),
            array('pt_field4_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pt_field4_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pt_field4_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pt_field4_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pt_field4_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pt_field4_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('pt_field5_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pt_field5_enabled', 'boolean', 'on' => 'save'),
            array('pt_field5_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pt_field5_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pt_field5_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pt_field5_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pt_field5_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pt_field5_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            //  дополнительные текстовые поля автора
            //  additional text fields for author
            array('at_field1_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_at_field1_enabled', 'boolean', 'on' => 'save'),
            array('at_field1_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_at_field1_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_at_field1_wo_paper_published', 'boolean', 'on' => 'save'),
            array('at_field1_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('at_field1_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('at_field1_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('at_field2_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_at_field2_enabled', 'boolean', 'on' => 'save'),
            array('at_field2_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_at_field2_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_at_field2_wo_paper_published', 'boolean', 'on' => 'save'),
            array('at_field2_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('at_field2_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('at_field2_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('at_field3_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_at_field3_enabled', 'boolean', 'on' => 'save'),
            array('at_field3_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_at_field3_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_at_field3_wo_paper_published', 'boolean', 'on' => 'save'),
            array('at_field3_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('at_field3_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('at_field3_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('at_field4_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_at_field4_enabled', 'boolean', 'on' => 'save'),
            array('at_field4_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_at_field4_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_at_field4_wo_paper_published', 'boolean', 'on' => 'save'),
            array('at_field4_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('at_field4_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('at_field4_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('at_field5_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_at_field5_enabled', 'boolean', 'on' => 'save'),
            array('at_field5_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_at_field5_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_at_field5_wo_paper_published', 'boolean', 'on' => 'save'),
            array('at_field5_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('at_field5_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('at_field5_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            //  дополнительные поля-флажки в заявке на участие
            //  additional checkbox fields for the application form    
            array('pc_field1_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pc_field1_enabled', 'boolean', 'on' => 'save'),
            array('pc_field1_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pc_field1_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pc_field1_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pc_field1_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pc_field1_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pc_field1_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('pc_field2_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pc_field2_enabled', 'boolean', 'on' => 'save'),
            array('pc_field2_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pc_field2_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pc_field2_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pc_field2_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pc_field2_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pc_field2_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('pc_field3_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pc_field3_enabled', 'boolean', 'on' => 'save'),
            array('pc_field3_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pc_field3_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pc_field3_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pc_field3_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pc_field3_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pc_field3_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('pc_field4_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pc_field4_enabled', 'boolean', 'on' => 'save'),
            array('pc_field4_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pc_field4_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pc_field4_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pc_field4_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pc_field4_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pc_field4_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('pc_field5_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pc_field5_enabled', 'boolean', 'on' => 'save'),
            array('pc_field5_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pc_field5_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pc_field5_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pc_field5_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pc_field5_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pc_field5_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            //  дополнительные поля-флажки автора
            //  additional checkbox fields for author
            array('ac_field1_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_ac_field1_enabled', 'boolean', 'on' => 'save'),
            array('ac_field1_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_ac_field1_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_ac_field1_wo_paper_published', 'boolean', 'on' => 'save'),
            array('ac_field1_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('ac_field1_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('ac_field1_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('ac_field2_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_ac_field2_enabled', 'boolean', 'on' => 'save'),
            array('ac_field2_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_ac_field2_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_ac_field2_wo_paper_published', 'boolean', 'on' => 'save'),
            array('ac_field2_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('ac_field2_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('ac_field2_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('ac_field3_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_ac_field3_enabled', 'boolean', 'on' => 'save'),
            array('ac_field3_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_ac_field3_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_ac_field3_wo_paper_published', 'boolean', 'on' => 'save'),
            array('ac_field3_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('ac_field3_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('ac_field3_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('ac_field4_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_ac_field4_enabled', 'boolean', 'on' => 'save'),
            array('ac_field4_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_ac_field4_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_ac_field4_wo_paper_published', 'boolean', 'on' => 'save'),
            array('ac_field4_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('ac_field4_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('ac_field4_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('ac_field5_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_ac_field5_enabled', 'boolean', 'on' => 'save'),
            array('ac_field5_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_ac_field5_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_ac_field5_wo_paper_published', 'boolean', 'on' => 'save'),
            array('ac_field5_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('ac_field5_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('ac_field5_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            //  дополнительные поля-списки в заявке на участие
            //  additional list fields for the application form
            array('pl_field1_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pl_field1_enabled', 'boolean', 'on' => 'save'),
            array('pl_field1_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pl_field1_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pl_field1_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pl_field1_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pl_field1_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pl_field1_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('pl_field2_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pl_field2_enabled', 'boolean', 'on' => 'save'),
            array('pl_field2_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pl_field2_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pl_field2_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pl_field2_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pl_field2_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pl_field2_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('pl_field3_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pl_field3_enabled', 'boolean', 'on' => 'save'),
            array('pl_field3_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pl_field3_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pl_field3_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pl_field3_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pl_field3_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pl_field3_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('pl_field4_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pl_field4_enabled', 'boolean', 'on' => 'save'),
            array('pl_field4_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pl_field4_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pl_field4_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pl_field4_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pl_field4_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pl_field4_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('pl_field5_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pl_field5_enabled', 'boolean', 'on' => 'save'),
            array('pl_field5_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pl_field5_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pl_field5_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pl_field5_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pl_field5_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('pl_field5_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            //  дополнительные поля-списки автора
            //  additional list fields for the author
            array('al_field1_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_al_field1_enabled', 'boolean', 'on' => 'save'),
            array('al_field1_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_al_field1_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_al_field1_wo_paper_published', 'boolean', 'on' => 'save'),
            array('al_field1_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('al_field1_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('al_field1_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('al_field2_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_al_field2_enabled', 'boolean', 'on' => 'save'),
            array('al_field2_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_al_field2_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_al_field2_wo_paper_published', 'boolean', 'on' => 'save'),
            array('al_field2_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('al_field2_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('al_field2_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('al_field3_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_al_field3_enabled', 'boolean', 'on' => 'save'),
            array('al_field3_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_al_field3_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_al_field3_wo_paper_published', 'boolean', 'on' => 'save'),
            array('al_field3_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('al_field3_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('al_field3_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('al_field4_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_al_field4_enabled', 'boolean', 'on' => 'save'),
            array('al_field4_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_al_field4_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_al_field4_wo_paper_published', 'boolean', 'on' => 'save'),
            array('al_field4_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('al_field4_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('al_field4_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('al_field5_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_al_field5_enabled', 'boolean', 'on' => 'save'),
            array('al_field5_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_al_field5_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_al_field5_wo_paper_published', 'boolean', 'on' => 'save'),
            array('al_field5_wi_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('al_field5_wo_paper_mode', 'in', 'range' => array('0', '1', '2'), 'allowEmpty' => false, 'on' => 'save'),
            array('al_field5_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            //  дополнительные файловые поля в заявке на участие
            //  additional file fields for the application form
            array('pf_field1_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pf_field1_enabled', 'boolean', 'on' => 'save'),
            array('pf_field1_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pf_field1_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pf_field1_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pf_field1_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pf_field1_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pf_field1_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('pf_field2_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pf_field2_enabled', 'boolean', 'on' => 'save'),
            array('pf_field2_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pf_field2_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pf_field2_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pf_field2_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pf_field2_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pf_field2_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('pf_field3_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pf_field3_enabled', 'boolean', 'on' => 'save'),
            array('pf_field3_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pf_field3_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pf_field3_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pf_field3_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pf_field3_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pf_field3_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('pf_field4_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pf_field4_enabled', 'boolean', 'on' => 'save'),
            array('pf_field4_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pf_field4_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pf_field4_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pf_field4_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pf_field4_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pf_field4_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('pf_field5_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_pf_field5_enabled', 'boolean', 'on' => 'save'),
            array('pf_field5_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_pf_field5_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_pf_field5_wo_paper_published', 'boolean', 'on' => 'save'),
            array('pf_field5_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pf_field5_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('pf_field5_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            //  дополнительные файловые поля автора
            //  additional file fields for author
            array('af_field1_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_af_field1_enabled', 'boolean', 'on' => 'save'),
            array('af_field1_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_af_field1_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_af_field1_wo_paper_published', 'boolean', 'on' => 'save'),
            array('af_field1_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('af_field1_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('af_field1_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('af_field2_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_af_field2_enabled', 'boolean', 'on' => 'save'),
            array('af_field2_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_af_field2_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_af_field2_wo_paper_published', 'boolean', 'on' => 'save'),
            array('af_field2_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('af_field2_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('af_field2_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('af_field3_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_af_field3_enabled', 'boolean', 'on' => 'save'),
            array('af_field3_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_af_field3_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_af_field3_wo_paper_published', 'boolean', 'on' => 'save'),
            array('af_field3_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('af_field3_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('af_field3_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('af_field4_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_af_field4_enabled', 'boolean', 'on' => 'save'),
            array('af_field4_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_af_field4_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_af_field4_wo_paper_published', 'boolean', 'on' => 'save'),
            array('af_field4_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('af_field4_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('af_field4_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('af_field5_name', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
            array('is_af_field5_enabled', 'boolean', 'on' => 'save'),
            array('af_field5_order', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'on' => 'save'),
            array('is_af_field5_wi_paper_published', 'boolean', 'on' => 'save'),
            array('is_af_field5_wo_paper_published', 'boolean', 'on' => 'save'),
            array('af_field5_wi_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('af_field5_wo_paper_mode', 'in', 'range' => array('0', '1', '2', '3', '4', '5'), 'allowEmpty' => false, 'on' => 'save'),
            array('af_field5_hint', 'LengthEachValidator', 'on' => 'save', 'max' => 200),
        );
    }

    public function behaviors() {
        return array(
            'MultilingualBehavior' => array(
                'class' => 'application.behaviors.MultilingualBehavior',
                'table' => 'multilingual_app_form_settings',
                'table_fk' => 'app_form_settings_id',
                'language_column' => 'language',
                'columns' => array('lastname_hint', 'firstname_hint', 'middlename_hint',
                    'org_hint', 'org_address_hint', 'position_hint', 'academic_degree_hint',
                    'academic_title_hint', 'supervisor_hint', 'country_hint',
                    'city_hint', 'address_hint', 'phone_hint', 'fax_hint',
                    'email_hint', 'membership_hint', 'annotation_hint',
                    'report_title_hint', 'report_topic_hint', 'classification_hint',
                    'report_text_hint', 'report_file_hint',
                    'more_info_hint', 'accommodation_hint', 'image_hint',
                    'ps_field1_name', 'ps_field1_hint',
                    'ps_field2_name', 'ps_field2_hint',
                    'ps_field3_name', 'ps_field3_hint',
                    'ps_field4_name', 'ps_field4_hint',
                    'ps_field5_name', 'ps_field5_hint',
                    'as_field1_name', 'as_field1_hint',
                    'as_field2_name', 'as_field2_hint',
                    'as_field3_name', 'as_field3_hint',
                    'as_field4_name', 'as_field4_hint',
                    'as_field5_name', 'as_field5_hint',
                    'pt_field1_name', 'pt_field1_hint',
                    'pt_field2_name', 'pt_field2_hint',
                    'pt_field3_name', 'pt_field3_hint',
                    'pt_field4_name', 'pt_field4_hint',
                    'pt_field5_name', 'pt_field5_hint',
                    'at_field1_name', 'at_field1_hint',
                    'at_field2_name', 'at_field2_hint',
                    'at_field3_name', 'at_field3_hint',
                    'at_field4_name', 'at_field4_hint',
                    'at_field5_name', 'at_field5_hint',
                    'pc_field1_name', 'pc_field1_hint',
                    'pc_field2_name', 'pc_field2_hint',
                    'pc_field3_name', 'pc_field3_hint',
                    'pc_field4_name', 'pc_field4_hint',
                    'pc_field5_name', 'pc_field5_hint',
                    'ac_field1_name', 'ac_field1_hint',
                    'ac_field2_name', 'ac_field2_hint',
                    'ac_field3_name', 'ac_field3_hint',
                    'ac_field4_name', 'ac_field4_hint',
                    'ac_field5_name', 'ac_field5_hint',
                    'pl_field1_name', 'pl_field1_hint',
                    'pl_field2_name', 'pl_field2_hint',
                    'pl_field3_name', 'pl_field3_hint',
                    'pl_field4_name', 'pl_field4_hint',
                    'pl_field5_name', 'pl_field5_hint',
                    'al_field1_name', 'al_field1_hint',
                    'al_field2_name', 'al_field2_hint',
                    'al_field3_name', 'al_field3_hint',
                    'al_field4_name', 'al_field4_hint',
                    'al_field5_name', 'al_field5_hint',
                    'pf_field1_name', 'pf_field1_hint',
                    'pf_field2_name', 'pf_field2_hint',
                    'pf_field3_name', 'pf_field3_hint',
                    'pf_field4_name', 'pf_field4_hint',
                    'pf_field5_name', 'pf_field5_hint',
                    'af_field1_name', 'af_field1_hint',
                    'af_field2_name', 'af_field2_hint',
                    'af_field3_name', 'af_field3_hint',
                    'af_field4_name', 'af_field4_hint',
                    'af_field5_name', 'af_field5_hint',
                ),
                'languages' => Yii::app()->params['languages'],
            ),
            'StrictXssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array('lastname_hint', 'firstname_hint', 'middlename_hint',
                    'org_hint', 'org_address_hint', 'position_hint', 'academic_degree_hint',
                    'academic_title_hint', 'supervisor_hint', 'country_hint',
                    'city_hint', 'address_hint', 'phone_hint', 'fax_hint',
                    'email_hint', 'membership_hint', 'annotation_hint',
                    'report_title_hint', 'report_topic_hint', 'classification_hint',
                    'report_text_hint', 'report_file_hint',
                    'more_info_hint', 'accommodation_hint', 'image_hint',
                    'ps_field1_hint',
                    'ps_field2_hint',
                    'ps_field3_hint',
                    'ps_field4_hint',
                    'ps_field5_hint',
                    'as_field1_hint',
                    'as_field2_hint',
                    'as_field3_hint',
                    'as_field4_hint',
                    'as_field5_hint',
                    'pt_field1_hint',
                    'pt_field2_hint',
                    'pt_field3_hint',
                    'pt_field4_hint',
                    'pt_field5_hint',
                    'at_field1_hint',
                    'at_field2_hint',
                    'at_field3_hint',
                    'at_field4_hint',
                    'at_field5_hint',
                    'pc_field1_hint',
                    'pc_field2_hint',
                    'pc_field3_hint',
                    'pc_field4_hint',
                    'pc_field5_hint',
                    'ac_field1_hint',
                    'ac_field2_hint',
                    'ac_field3_hint',
                    'ac_field4_hint',
                    'ac_field5_hint',
                    'pl_field1_hint',
                    'pl_field2_hint',
                    'pl_field3_hint',
                    'pl_field4_hint',
                    'pl_field5_hint',
                    'al_field1_hint',
                    'al_field2_hint',
                    'al_field3_hint',
                    'al_field4_hint',
                    'al_field5_hint',
                    'pf_field1_hint',
                    'pf_field2_hint',
                    'pf_field3_hint',
                    'pf_field4_hint',
                    'pf_field5_hint',
                    'af_field1_hint',
                    'af_field2_hint',
                    'af_field3_hint',
                    'af_field4_hint',
                    'af_field5_hint',
                ),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => array('a')
            ),
            'FullXssFilterBehavior' => array(
                'class' => 'application.behaviors.XssFilterBehavior',
                'attributes' => array(
                    'ps_field1_name',
                    'ps_field2_name',
                    'ps_field3_name',
                    'ps_field4_name',
                    'ps_field5_name',
                    'as_field1_name',
                    'as_field2_name',
                    'as_field3_name',
                    'as_field4_name',
                    'as_field5_name',
                    'pt_field1_name',
                    'pt_field2_name',
                    'pt_field3_name',
                    'pt_field4_name',
                    'pt_field5_name',
                    'at_field1_name',
                    'at_field2_name',
                    'at_field3_name',
                    'at_field4_name',
                    'at_field5_name',
                    'pc_field1_name',
                    'pc_field2_name',
                    'pc_field3_name',
                    'pc_field4_name',
                    'pc_field5_name',
                    'ac_field1_name',
                    'ac_field2_name',
                    'ac_field3_name',
                    'ac_field4_name',
                    'ac_field5_name',
                    'pl_field1_name',
                    'pl_field2_name',
                    'pl_field3_name',
                    'pl_field4_name',
                    'pl_field5_name',
                    'al_field1_name',
                    'al_field2_name',
                    'al_field3_name',
                    'al_field4_name',
                    'al_field5_name',
                    'pf_field1_name',
                    'pf_field2_name',
                    'pf_field3_name',
                    'pf_field4_name',
                    'pf_field5_name',
                    'af_field1_name',
                    'af_field2_name',
                    'af_field3_name',
                    'af_field4_name',
                    'af_field5_name',
                ),
                'languages' => Yii::app()->params['languages'],
                'allowed_tags' => array()
            )
        );
    }

    public function lastname_hint($language = NULL) {
        return $this->value('lastname_hint', $language);
    }

    public function firstname_hint($language = NULL) {
        return $this->value('firstname_hint', $language);
    }

    public function middlename_hint($language = NULL) {
        return $this->value('middlename_hint', $language);
    }

    public function org_hint($language = NULL) {
        return $this->value('org_hint', $language);
    }

    public function org_address_hint($language = NULL) {
        return $this->value('org_address_hint', $language);
    }

    public function position_hint($language = NULL) {
        return $this->value('position_hint', $language);
    }

    public function academic_degree_hint($language = NULL) {
        return $this->value('academic_degree_hint', $language);
    }

    public function academic_title_hint($language = NULL) {
        return $this->value('academic_title_hint', $language);
    }

    public function supervisor_hint($language = NULL) {
        return $this->value('supervisor_hint', $language);
    }

    public function country_hint($language = NULL) {
        return $this->value('country_hint', $language);
    }

    public function city_hint($language = NULL) {
        return $this->value('city_hint', $language);
    }

    public function address_hint($language = NULL) {
        return $this->value('address_hint', $language);
    }

    public function phone_hint($language = NULL) {
        return $this->value('phone_hint', $language);
    }

    public function fax_hint($language = NULL) {
        return $this->value('fax_hint', $language);
    }

    public function email_hint($language = NULL) {
        return $this->value('email_hint', $language);
    }

    public function membership_hint($language = NULL) {
        return $this->value('membership_hint', $language);
    }

    public function annotation_hint($language = NULL) {
        return $this->value('annotation_hint', $language);
    }

    public function report_title_hint($language = NULL) {
        return $this->value('report_title_hint', $language);
    }

    public function report_topic_hint($language = NULL) {
        return $this->value('report_topic_hint', $language);
    }

    public function classification_hint($language = NULL) {
        return $this->value('classification_hint', $language);
    }

    public function report_text_hint($language = NULL) {
        return $this->value('report_text_hint', $language);
    }

    public function report_file_hint($language = NULL) {
        return $this->value('report_file_hint', $language);
    }

    public function more_info_hint($language = NULL) {
        return $this->value('more_info_hint', $language);
    }

    public function accommodation_hint($language = NULL) {
        return $this->value('accommodation_hint', $language);
    }

    public function image_hint($language = NULL) {
        return $this->value('image_hint', $language);
    }

    public function field_name($field_name, $language = NULL) {
        return $this->value($field_name, $language);
    }

    public function label($attribute) {
        if ($this->isAdditionalAttribute($attribute)) {
            $field_name = $attribute . '_name';
            return $this->field_name($field_name);
        } else {
            $labels = $this->attributeLabels();
            return $labels[$attribute];
        }
    }

    public function field_hint($field_hint, $language = NULL) {
        return $this->value($field_hint, $language);
    }

    public function getSelectFieldList($field, $language = NULL) {
        $data = array('0' => Yii::t('admin', 'Unselected'));
        $list_id = $this->{$field . '_list_id'}; //$this->id.'_'.$field;
        $items = ListItem::model()->findAllByListId($list_id);
        foreach ($items as $item) {
            if (!$item->isEmpty()) {
                $data[$item->id] = $item->itemValue($language);
            }
        };
        return $data;
    }

    public function a_field_count($fieldType) {
        $count = 0;
        $attribute = '';
        if ($fieldType == FieldType::STRING) {
            $attribute = 'as_field';
        };
        if ($fieldType == FieldType::TEXT) {
            $attribute = 'at_field';
        };
        if ($fieldType == FieldType::CHECKBOX) {
            $attribute = 'ac_field';
        };
        if ($fieldType == FieldType::SELECT) {
            $attribute = 'al_field';
        };
        if ($fieldType == FieldType::FILE) {
            $attribute = 'af_field';
        };
        $i = 1;
        $fieldName = $this->value("{$attribute}{$i}_name");
        while (!empty($fieldName)) {
            $count++;
            $i++;
            if ($i == 6) {
                break;
            };
            $fieldName = $this->value("{$attribute}{$i}_name");
        };
        return $count;
    }

    public function p_field_count($fieldType) {
        $count = 0;
        $attribute = '';
        if ($fieldType == FieldType::STRING) {
            $attribute = 'ps_field';
        };
        if ($fieldType == FieldType::TEXT) {
            $attribute = 'pt_field';
        };
        if ($fieldType == FieldType::CHECKBOX) {
            $attribute = 'pc_field';
        };
        if ($fieldType == FieldType::SELECT) {
            $attribute = 'pl_field';
        };
        if ($fieldType == FieldType::FILE) {
            $attribute = 'pf_field';
        };
        $i = 1;
        $fieldName = $this->value("{$attribute}{$i}_name");
        while (!empty($fieldName)) {
            $count++;
            $i++;
            if ($i == 6) {
                break;
            };
            $fieldName = $this->value("{$attribute}{$i}_name");
        };
        return $count;
    }

    /*
     *    возвращает упорядоченный список атрибутов в заявке на участие
     *    активных ($enabled) или выключенных
     * 
     *    returns an ordered list of attributes in application form
     *    $enabled or disabled attributes
     * */

    public function getPAttributes($enabled = true) {
        $enabled_attributes = array(
            array('authors', 4)
        );
        $disabled_attributes = array();

        // приоритет priority
        $pri = 1;
        $standard_fields = array();
        foreach (AppFormSettings::$STANDARD_PATTRIBUTES as $attr) {
            $standard_fields[$attr] = $pri++;
            if ($pri == 4) {
                $pri++;
            };
        }
        $additional_fields = array();
        foreach (AppFormSettings::$ADDITIONAL_PATTRIBUTES as $attr) {
            $additional_fields[$attr] = $pri++;
        }

        foreach ($standard_fields as $field => $pri) {
            if ($this->{'is_' . $field . '_enabled'}) {
                $enabled_attributes[] = array($field, $pri);
            } else {
                $disabled_attributes[] = array($field, $pri);
            }
        };

        foreach ($additional_fields as $field => $pri) {
            for ($i = 1; $i <= 5; $i++) {
                if ($this->{'is_' . $field . $i . '_enabled'}) {
                    $enabled_attributes[] = array($field . $i, $pri);
                } else {
                    $disabled_attributes[] = array($field . $i, $pri);
                }
            }
        };

        $a = $enabled_attributes;
        if (!$enabled) {
            $a = $disabled_attributes;
        };
        uasort($a, array($this, 'cmpAttributesByOrder'));
        $b = array();
        foreach ($a as $arr) {
            list($attr, $pri) = $arr;
            $b[] = $attr;
        }
        return $b;
    }

    /*
     *    возвращает упорядоченный список атрибутов авторов
     *    активных ($enabled) или выключенных
     * 
     *    returns an ordered list of attributes for author
     *    $enabled or disabled attributes
     * */

    public function getAAttributes($enabled = true) {
        $enabled_attributes = array();
        $disabled_attributes = array();

        // приоритет priority
        $pri = 1;
        $standard_fields = array();
        foreach (AppFormSettings::$STANDARD_AATTRIBUTES as $attr) {
            $standard_fields[$attr] = $pri++;
        };
        $additional_fields = array();
        foreach (AppFormSettings::$ADDITIONAL_AATTRIBUTES as $attr) {
            $additional_fields[$attr] = $pri++;
        }

        foreach ($standard_fields as $field => $pri) {
            if ($this->{'is_' . $field . '_enabled'}) {
                $enabled_attributes[] = array($field, $pri);
            } else {
                $disabled_attributes[] = array($field, $pri);
            }
        };

        foreach ($additional_fields as $field => $pri) {
            for ($i = 1; $i <= 5; $i++) {
                if ($this->{'is_' . $field . $i . '_enabled'}) {
                    $enabled_attributes[] = array($field . $i, $pri);
                } else {
                    $disabled_attributes[] = array($field . $i, $pri);
                }
            }
        };

        $a = $enabled_attributes;
        if (!$enabled) {
            $a = $disabled_attributes;
        };

        uasort($a, array($this, 'cmpAttributesByOrder'));

        $b = array();
        foreach ($a as $arr) {
            list($attr, $pri) = $arr;
            $b[] = $attr;
        }
        return $b;
    }

    public function isAAttribute($attribute) {
        $aattributes = array_merge(AppFormSettings::$STANDARD_AATTRIBUTES, AppFormSettings::$ADDITIONAL_AATTRIBUTES);
        foreach ($aattributes as $attr) {
            if (strpos($attribute, $attr) !== FALSE) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function resetOrders() {
        $standard_attributes = $this->allStandardAttributes();
        $additional_attributes = $this->allAdditionalAttributes();
        foreach ($standard_attributes as $attribute) {
            $this->{$attribute . '_order'} = 0;
        };
        $this->{'authors_order'} = 0;
        foreach ($additional_attributes as $attribute) {
            for ($i = 1; $i <= 5; $i++) {
                $this->{$attribute . $i . '_order'} = 0;
            }
        }
    }

    public function resetBooleanAttributes() {
        $form = new AppFormSettings();
        $attributes = $this->allStandardAttributes();
        foreach ($attributes as $attribute) {
            $this->{'is_' . $attribute . '_enabled'} = $form->{'is_' . $attribute . '_enabled'};
            $this->{$attribute . '_order'} = $form->{$attribute . '_order'};
            $this->{$attribute . '_wi_paper_mode'} = $form->{$attribute . '_wi_paper_mode'};
            $this->{$attribute . '_wo_paper_mode'} = $form->{$attribute . '_wo_paper_mode'};
            $this->{'is_' . $attribute . '_wi_paper_published'} = $form->{'is_' . $attribute . '_wi_paper_published'};
            $this->{'is_' . $attribute . '_wo_paper_published'} = $form->{'is_' . $attribute . '_wo_paper_published'};
        }
        $attributes = $this->allAdditionalAttributes();
        foreach ($attributes as $attribute) {
            for ($i = 1; $i <= 5; $i++) {
                $this->{'is_' . $attribute . $i . '_enabled'} = $form->{'is_' . $attribute . $i . '_enabled'};
                $this->{$attribute . $i . '_order'} = $form->{$attribute . $i . '_order'};
                $this->{$attribute . $i . '_wi_paper_mode'} = $form->{$attribute . $i . '_wi_paper_mode'};
                $this->{$attribute . $i . '_wo_paper_mode'} = $form->{$attribute . $i . '_wo_paper_mode'};
                $this->{'is_' . $attribute . $i . '_wi_paper_published'} = $form->{'is_' . $attribute . $i . '_wi_paper_published'};
                $this->{'is_' . $attribute . $i . '_wo_paper_published'} = $form->{'is_' . $attribute . $i . '_wo_paper_published'};
            }
        }
    }

    public function enableAttribute($attribute) {
        $standard_attributes = $this->allStandardAttributes();
        $this->{'is_' . $attribute . '_enabled'} = TRUE;
        if (!in_array($attribute, $standard_attributes)) {
            $field_names = array();
            if ($this->conf != NULL) {
                $langs = $this->conf->getLanguages();
                foreach ($langs as $lang => $name) {
                    $field_names[$lang] = Yii::t('admin', 'New field', array(), NULL, $lang);
                };
            };
            $this->{$attribute . '_name'} = $field_names;
        }
        $this->{$attribute . '_hint'} = array('ru' => '', 'en' => '', 'es' => '');
        $this->{$attribute . '_wi_paper_mode'} = AppFormSettings::MODE_ENABLED;
        $this->{$attribute . '_wo_paper_mode'} = AppFormSettings::MODE_ENABLED;
        $this->{'is_' . $attribute . '_wi_paper_published'} = TRUE;
        $this->{'is_' . $attribute . '_wo_paper_published'} = TRUE;

        // если список - то очищаем ранее сохраненные элементы, если они были
        if (strpos($attribute, 'l_field') !== FALSE) {
            $list_id = $this->{$attribute . '_list_id'};
            if ($list_id) {
                ListItem::model()->deleteAllByListId($list_id);
            }
        }
    }

    private function cmpAttributesByOrder($arr1, $arr2) {
        list($attr1, $pri1) = $arr1;
        list($attr2, $pri2) = $arr2;

        if ($this->{$attr1 . '_order'} == $this->{$attr2 . '_order'}) {
            if ($pri1 == $pri2) {
                return strcmp($attr1, $attr2);
            };
            return ($pri1 < $pri2 ? -1 : 1);
        }
        return ($this->{$attr1 . '_order'} < $this->{$attr2 . '_order'}) ? -1 : 1;
    }

    public function isAdditionalAttribute($attribute) {
        return strpos($attribute, '_field');
    }

    /**
     * Проверяет включен ли атрибут для заданного вида доклала
     * Checks if the $attribute is enabled for a specific application form (wi_paper_mode or wo_paper_mode)
     * $wi_paper_mode = TRUE or FALSE or ANY
     */
    public function isAttributeEnabled($attribute, $wi_paper_mode) {
        $enabled = $this->{'is_' . $attribute . '_enabled'};
        $wi_mode = $this->{$attribute . '_wi_paper_mode'};
        $wo_mode = $this->{$attribute . '_wo_paper_mode'};
        if ($wi_paper_mode === 'ANY') {
            return $enabled && (($wi_mode != AppFormSettings::MODE_DISABLED) || ($wo_mode != AppFormSettings::MODE_DISABLED));
        }
        if ($wi_paper_mode === TRUE) {
            return $enabled && ($wi_mode != AppFormSettings::MODE_DISABLED);
        }
        return $enabled && ($wo_mode != AppFormSettings::MODE_DISABLED);
    }

    // $wi_paper_mode = TRUE or FALSE
    public function getAttributeMode($attribute, $wi_paper_mode) {
        $wi_mode = $this->{$attribute . '_wi_paper_mode'};
        $wo_mode = $this->{$attribute . '_wo_paper_mode'};
        if ($wi_paper_mode) {
            return $wi_mode;
        }
        return $wo_mode;
    }

    /**
     * Проверяет опубликован ли атрибут для заданного вида доклала
     * Checks if the $attribute is enabled for a specific application form (wi_paper_mode or wo_paper_mode)
     * $wi_paper_mode = TRUE or FALSE or ANY
     */
    public function isAttributePublished($attribute, $wi_paper_mode) {
        $enabled = $this->isAttributeEnabled($attribute, $wi_paper_mode);
        $wi_published = $this->{'is_' . $attribute . '_wi_paper_published'};
        $wo_published = $this->{'is_' . $attribute . '_wo_paper_published'};
        if ($wi_paper_mode === 'ANY') {
            return $enabled && ($wi_published || $wo_published);
        }
        if ($wi_paper_mode === TRUE) {
            return $enabled && $wi_published;
        }
        return $enabled && $wo_published;
    }

    public function modeOptionsType($attribute) {
        $conf = $this->conf;
        if (($conf != NULL) && $conf->isInOneLanguage()) {
            return AppFormSettings::MODE_OPTIONS_YES_NO;
        };
        $yes_no_mode_attributes = array(
            'report_topic', // секция конференции
            'accommodation', // бронировать гостиницу?
            'classification',
            'image',
            'phone',
            'email',
            'fax',
            'pc_field', // чекбоксы в заявке на участие 
            'pl_field', // списки в завке на участие
            'ac_field', // чекбоксы автора
            'al_field', // списки автора  
        );
        foreach ($yes_no_mode_attributes as $attr) {
            if (strpos($attribute, $attr) !== FALSE) {
                return AppFormSettings::MODE_OPTIONS_YES_NO;
            };
        };
        return AppFormSettings::MODE_OPTIONS_ALL;
    }

    public function findByConf($conf) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'id=:conf_id';
        $criteria->params = array(':conf_id' => $conf->id);
        $obj = $this->find($criteria);
        //  если не найдено, то возвращаем настройки по умолчанию
        //  if not found then return default settings
        if (!$obj) {
            $obj = new AppFormSettings();
            $obj->id = $conf->id;
        }
        $obj->conf = $conf;
        return $obj;
    }

    protected function packFields() {
        //  упаковываем строковые, текстовые, флажки и файловые поля
        //  packing string, text, checkbox and file fields
        $attributes = array('ps_field', 'as_field', 'at_field', 'pt_field', 'pc_field', 'ac_field', 'af_field', 'pf_field');
        foreach ($attributes as $attribute) {
            $swap = true;
            while ($swap) {
                $swap = false;
                for ($i = 1; $i < 5; $i++) {
                    $field = "{$attribute}{$i}";
                    $fieldName = $this->value("{$field}_name");
                    $next_i = $i + 1;
                    $nextField = "{$attribute}{$next_i}";
                    $nextFieldName = $this->value("{$nextField}_name");
                    if (empty($fieldName) && !empty($nextFieldName)) {
                        $swap = true;
                        $this->{$field . '_name'} = $this->{$nextField . '_name'};
                        $this->{'is_' . $field . '_enabled'} = $this->{'is_' . $nextField . '_enabled'};
                        $this->{$field . '_order'} = $this->{$nextField . '_order'};
                        $this->{'is_' . $field . '_wi_paper_published'} = $this->{'is_' . $nextField . '_wi_paper_published'};
                        $this->{'is_' . $field . '_wo_paper_published'} = $this->{'is_' . $nextField . '_wo_paper_published'};
                        $this->{$field . '_wi_paper_mode'} = $this->{$nextField . '_wi_paper_mode'};
                        $this->{$field . '_wo_paper_mode'} = $this->{$nextField . '_wo_paper_mode'};
                        $this->{$field . '_hint'} = $this->{$nextField . '_hint'};
                        $this->{$nextField . '_name'} = array();
                        $this->{'is_' . $nextField . '_enabled'} = true;
                        $this->{$nextField . '_order'} = 0;
                        $this->{'is_' . $nextField . '_wi_paper_published'} = false;
                        $this->{'is_' . $nextField . '_wo_paper_published'} = false;
                        $this->{$nextField . '_wi_paper_mode'} = AppFormSettings::MODE_DISABLED;
                        $this->{$nextField . '_wo_paper_mode'} = AppFormSettings::MODE_DISABLED;
                        $this->{$nextField . '_hint'} = array();
                    }
                }
            }
        };

        //  упаковываем поля-списки
        //  packing list fields
        $attributes = array('pl_field', 'al_field');
        foreach ($attributes as $attribute) {
            $swap = true;
            while ($swap) {
                $swap = false;
                for ($i = 1; $i < 5; $i++) {
                    $field = "{$attribute}{$i}";
                    $fieldName = $this->value("{$field}_name");
                    $next_i = $i + 1;
                    $nextField = "{$attribute}{$next_i}";
                    $nextFieldName = $this->value("{$nextField}_name");
                    if (empty($fieldName) && !empty($nextFieldName)) {
                        $swap = true;
                        $this->{$field . '_name'} = $this->{$nextField . '_name'};
                        $this->{'is_' . $field . '_enabled'} = $this->{'is_' . $nextField . '_enabled'};
                        $this->{$field . '_order'} = $this->{$nextField . '_order'};
                        $this->{'is_' . $field . '_wi_paper_published'} = $this->{'is_' . $nextField . '_wi_paper_published'};
                        $this->{'is_' . $field . '_wo_paper_published'} = $this->{'is_' . $nextField . '_wo_paper_published'};
                        $this->{$field . '_wi_paper_mode'} = $this->{$nextField . '_wi_paper_mode'};
                        $this->{$field . '_wo_paper_mode'} = $this->{$nextField . '_wo_paper_mode'};
                        $this->{$field . '_hint'} = $this->{$nextField . '_hint'};
                        $this->{$field . '_list_id'} = $this->{$nextField . '_list_id'};
                        $this->{$nextField . '_name'} = array();
                        $this->{'is_' . $nextField . '_enabled'} = true;
                        $this->{$nextField . '_order'} = 0;
                        $this->{'is_' . $nextField . '_wi_paper_published'} = false;
                        $this->{'is_' . $nextField . '_wo_paper_published'} = false;
                        $this->{$nextField . '_wi_paper_mode'} = AppFormSettings::MODE_DISABLED;
                        ;
                        $this->{$nextField . '_wo_paper_mode'} = AppFormSettings::MODE_DISABLED;
                        ;
                        $this->{$nextField . '_hint'} = array();
                        $this->{$nextField . '_list_id'} = 0;
                    }
                }
            }
        }
    }

    protected function beforeSave() {
        parent::beforeSave();
        $this->packFields();
        return true;
    }

    public function delete() {
        if (!$this->getIsNewRecord()) {
            parent::delete();
            // удаляем значения полей-списков
            // delete items of list fields
            foreach (array('al_field', 'pl_field') as $field) {
                for ($i = 1; $i <= 5; $i++) {
                    $attribute = $field . $i;
                    $list_id = $this->{$attribute . '_list_id'};
                    if ($list_id) {
                        ListItem::model()->deleteAllByListId($list_id);
                    }
                }
            }
        }
    }

}

?>
