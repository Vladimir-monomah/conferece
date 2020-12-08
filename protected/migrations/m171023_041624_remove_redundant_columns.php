<?php

class m171023_041624_remove_redundant_columns extends CDbMigration
{
	public function up()
	{
              $this->dropColumn('{{app_form_settings}}', 'ps_field1_type');
              $this->dropColumn('{{app_form_settings}}', 'ps_field2_type');
              $this->dropColumn('{{app_form_settings}}', 'ps_field3_type');
              $this->dropColumn('{{app_form_settings}}', 'ps_field4_type');
              $this->dropColumn('{{app_form_settings}}', 'ps_field5_type');
              
              $this->dropColumn('{{app_form_settings}}', 'as_field1_type');
              $this->dropColumn('{{app_form_settings}}', 'as_field2_type');
              $this->dropColumn('{{app_form_settings}}', 'as_field3_type');
              $this->dropColumn('{{app_form_settings}}', 'as_field4_type');
              $this->dropColumn('{{app_form_settings}}', 'as_field5_type');
              
              $this->dropColumn('{{app_form_settings}}', 'pt_field1_type');
              $this->dropColumn('{{app_form_settings}}', 'pt_field2_type');
              $this->dropColumn('{{app_form_settings}}', 'pt_field3_type');
              $this->dropColumn('{{app_form_settings}}', 'pt_field4_type');
              $this->dropColumn('{{app_form_settings}}', 'pt_field5_type');
              
              $this->dropColumn('{{app_form_settings}}', 'at_field1_type');
              $this->dropColumn('{{app_form_settings}}', 'at_field2_type');
              $this->dropColumn('{{app_form_settings}}', 'at_field3_type');
              $this->dropColumn('{{app_form_settings}}', 'at_field4_type');
              $this->dropColumn('{{app_form_settings}}', 'at_field5_type');
              
              $this->dropColumn('{{app_form_settings}}', 'pc_field1_type');
              $this->dropColumn('{{app_form_settings}}', 'pc_field2_type');
              $this->dropColumn('{{app_form_settings}}', 'pc_field3_type');
              $this->dropColumn('{{app_form_settings}}', 'pc_field4_type');
              $this->dropColumn('{{app_form_settings}}', 'pc_field5_type');
              
              $this->dropColumn('{{app_form_settings}}', 'ac_field1_type');
              $this->dropColumn('{{app_form_settings}}', 'ac_field2_type');
              $this->dropColumn('{{app_form_settings}}', 'ac_field3_type');
              $this->dropColumn('{{app_form_settings}}', 'ac_field4_type');
              $this->dropColumn('{{app_form_settings}}', 'ac_field5_type');
              
              $this->dropColumn('{{app_form_settings}}', 'pl_field1_type');
              $this->dropColumn('{{app_form_settings}}', 'pl_field2_type');
              $this->dropColumn('{{app_form_settings}}', 'pl_field3_type');
              $this->dropColumn('{{app_form_settings}}', 'pl_field4_type');
              $this->dropColumn('{{app_form_settings}}', 'pl_field5_type');
              
              $this->dropColumn('{{app_form_settings}}', 'al_field1_type');
              $this->dropColumn('{{app_form_settings}}', 'al_field2_type');
              $this->dropColumn('{{app_form_settings}}', 'al_field3_type');
              $this->dropColumn('{{app_form_settings}}', 'al_field4_type');
              $this->dropColumn('{{app_form_settings}}', 'al_field5_type'); 
          
	}

	public function down()
	{
		echo "m171023_041624_remove_redundant_columns does not support migration down.\n";
		return false;
	}

}