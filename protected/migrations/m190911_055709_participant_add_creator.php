<?php

class m190911_055709_participant_add_creator extends CDbMigration
{
	public function up()
	{
             $this->addColumn('{{participant}}', 'creator_id', 'integer');
	}

	public function down()
	{
		echo "m190911_055709_participant_add_creator does not support migration down.\n";
		return false;
	}
}