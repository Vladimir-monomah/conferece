<?php

class m180301_075353_rename_page_tables extends CDbMigration
{
	public function up()
	{
           /* code already included in CreateTables.php 
            $this->dropForeignKey('fk_multilingual_page_page_id', "{{multilingual_page}}");
            $this->renameTable('{{page}}', '{{site_page}}');
            $this->renameTable('{{multilingual_page}}', '{{multilingual_site_page}}');
            $this->addForeignKey('fk_multilingual_page_page_id', "{{multilingual_site_page}}", 'page_id', "{{site_page}}", 'id', 'CASCADE', 'NO ACTION');*/
 	}

	public function down()
	{
		echo "m180301_075353_rename_page_tables does not support migration down.\n";
		return false;
	}

}