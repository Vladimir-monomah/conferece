<?php

class m180409_082931_update_mail_task extends CDbMigration
{
	public function up()
	{
            $this->execute("UPDATE {{mail_task}} set recipients = 'one' where recipients = 'participant_authors'");           
            $this->renameColumn('{{mail_task}}', 'sent_count', 'skip_count');
            $this->dropColumn('{{mail_task}}', 'error_emails');
            $this->addColumn('{{mail_task}}', 'participants', 'text');
            $this->addColumn('{{mail_task}}', 'error_statistics', 'text');
            $this->addColumn('{{mail_task}}', 'success_statistics', 'text');
        }

	public function down()
	{
		echo "m180409_082931_update_mail_task does not support migration down.\n";
		return false;
	}

}