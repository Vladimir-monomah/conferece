<?php

class m180126_091956_add_participant_edit_language extends CDbMigration
{
	public function up()
	{
            $this->addColumn('{{participant}}', "edit_language", 'string');
	}

	public function down()
	{
		echo "m180126_091956_add_participant_edit_language does not support migration down.\n";
		return false;
	}

}