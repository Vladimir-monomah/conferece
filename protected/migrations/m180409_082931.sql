UPDATE tbl_mail_task set recipients = 'one' where recipients = 'participant_authors';
ALTER TABLE tbl_mail_task ADD `error_statistics` text COLLATE utf8_unicode_ci;
ALTER TABLE tbl_mail_task ADD `success_statistics` text COLLATE utf8_unicode_ci;
ALTER TABLE tbl_mail_task ADD `participants` text COLLATE utf8_unicode_ci;
ALTER TABLE tbl_mail_task CHANGE `sent_count` `skip_count` int(11) DEFAULT 0;
ALTER TABLE tbl_mail_task DROP COLUMN `error_emails`;