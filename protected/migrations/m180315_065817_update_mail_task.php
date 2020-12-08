<?php

class m180315_065817_update_mail_task extends CDbMigration
{
	public function up()
	{
                $this->addColumn('{{mail_task}}', 'participant_id', 'integer not null');
                $this->addColumn('{{mail_task}}', 'error_emails', 'text');
	}

	public function down()
	{
		echo "m180315_065817_update_mail_task does not support migration down.\n";
		return false;
	}

}