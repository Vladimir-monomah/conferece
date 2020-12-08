<?php

class m180306_041808_rename_conf_section_tables extends CDbMigration
{
	public function up()
	{
            /* code already included in CreateTables.php
            $this->dropForeignKey('fk_multilingual_conf_conf_section_id', "{{multilingual_conf_section}}");
            $this->renameTable('{{conf_section}}', '{{conf_page}}');
            $this->renameTable('{{multilingual_conf_section}}', '{{multilingual_conf_page}}');
            $this->renameColumn('{{multilingual_conf_page}}', 'conf_section_id', 'conf_page_id');
            $this->addForeignKey('fk_multilingual_conf_conf_page_id', "{{multilingual_conf_page}}", 'conf_page_id', "{{conf_page}}", 'id', 'CASCADE', 'NO ACTION');*/
 
	}

	public function down()
	{
		echo "m180306_041808_rename_conf_section_tables does not support migration down.\n";
		return false;
	}

}