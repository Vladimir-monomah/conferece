<?php

class m171020_071907_add_additional_file_fields extends CDbMigration
{
	public function up()
	{ 
            $this->addColumn('{{app_form_settings}}', 'is_pf_field1_enabled', 'boolean');
            $this->addColumn('{{app_form_settings}}', 'is_pf_field1_published', 'boolean');
            $this->addColumn('{{app_form_settings}}', 'pf_field1_mandatory', 'integer');
            $this->addColumn('{{multilingual_app_form_settings}}', 'pf_field1_name', 'text');
            $this->addColumn('{{multilingual_app_form_settings}}', 'pf_field1_hint', 'text');
            
            $this->addColumn('{{app_form_settings}}', 'is_pf_field2_enabled', 'boolean');
            $this->addColumn('{{app_form_settings}}', 'is_pf_field2_published', 'boolean');
            $this->addColumn('{{app_form_settings}}', 'pf_field2_mandatory', 'integer');
            $this->addColumn('{{multilingual_app_form_settings}}', 'pf_field2_name', 'text');
            $this->addColumn('{{multilingual_app_form_settings}}', 'pf_field2_hint', 'text');

            $this->addColumn('{{app_form_settings}}', 'is_pf_field3_enabled', 'boolean');
            $this->addColumn('{{app_form_settings}}', 'is_pf_field3_published', 'boolean');
            $this->addColumn('{{app_form_settings}}', 'pf_field3_mandatory', 'integer');
            $this->addColumn('{{multilingual_app_form_settings}}', 'pf_field3_name', 'text');
            $this->addColumn('{{multilingual_app_form_settings}}', 'pf_field3_hint', 'text');
 
            $this->addColumn('{{app_form_settings}}', 'is_pf_field4_enabled', 'boolean');
            $this->addColumn('{{app_form_settings}}', 'is_pf_field4_published', 'boolean');
            $this->addColumn('{{app_form_settings}}', 'pf_field4_mandatory', 'integer');
            $this->addColumn('{{multilingual_app_form_settings}}', 'pf_field4_name', 'text');
            $this->addColumn('{{multilingual_app_form_settings}}', 'pf_field4_hint', 'text');

            $this->addColumn('{{app_form_settings}}', 'is_pf_field5_enabled', 'boolean');
            $this->addColumn('{{app_form_settings}}', 'is_pf_field5_published', 'boolean');
            $this->addColumn('{{app_form_settings}}', 'pf_field5_mandatory', 'integer');
            $this->addColumn('{{multilingual_app_form_settings}}', 'pf_field5_name', 'text');
            $this->addColumn('{{multilingual_app_form_settings}}', 'pf_field5_hint', 'text');
         
	}

	public function down()
	{
		echo "m171020_071907_add_additional_file_fields does not support migration down.\n";
		return false;
	}

}