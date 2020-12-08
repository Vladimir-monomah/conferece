ALTER TABLE tbl_mail_task ADD `participant_id` int(11) DEFAULT 0;
ALTER TABLE tbl_mail_task ADD `error_emails` text COLLATE utf8_unicode_ci;