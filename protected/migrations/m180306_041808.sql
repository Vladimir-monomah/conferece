ALTER TABLE tbl_multilingual_conf_section DROP FOREIGN KEY `fk_multilingual_conf_conf_section_id`;
ALTER TABLE tbl_conf_section RENAME tbl_conf_page;
ALTER TABLE tbl_multilingual_conf_section RENAME tbl_multilingual_conf_page;
ALTER TABLE tbl_multilingual_conf_page CHANGE `conf_section_id` `conf_page_id` int(11) NOT NULL;
ALTER TABLE tbl_multilingual_conf_page ADD CONSTRAINT `fk_multilingual_conf_conf_page_id` FOREIGN KEY (`conf_page_id`) REFERENCES `tbl_conf_page` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
