ALTER TABLE tbl_multilingual_page DROP FOREIGN KEY `fk_multilingual_page_page_id`;
ALTER TABLE tbl_page RENAME tbl_site_page;
ALTER TABLE tbl_multilingual_page RENAME tbl_multilingual_site_page;
ALTER TABLE tbl_multilingual_site_page ADD CONSTRAINT `fk_multilingual_page_page_id` FOREIGN KEY (`page_id`) REFERENCES `tbl_site_page` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

