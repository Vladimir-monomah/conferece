<?php

class m171102_080702_update_application_form_settings extends CDbMigration {

    public function up() {
        $standard_fields = array(
            'lastname', 'firstname', 'middlename',
            'org', 'org_address', 'position',
            'academic_degree', 'academic_title', 'supervisor',
            'country', 'city', 'address',
            'phone', 'fax', 'email',
            'membership',
            'annotation', 'report_title', 'report_topic', 'classification', 'report_text', 'report_file',
            'more_info',
            'accommodation',
            'image');

        $additional_fields = array(
            'ps_field', 'as_field', // строковые string
            'pt_field', 'at_field', // текстовые text
            'pc_field', 'ac_field', // чекбоксы checkbox
            'pl_field', 'al_field', // списки list
            'pf_field', 'af_field'  // файловые file field
        );

        $this->addProperties($standard_fields, $additional_fields);
        $this->addAuthorFileFields();
        $this->migrateData($standard_fields, $additional_fields);
        $this->removeProperties($standard_fields, $additional_fields);
        /*
          $sql = '';
          $sql .= $this->addPropertiesSQL($standard_fields, $additional_fields);
          $sql .= $this->addAuthorFileFieldsSQL();
          $sql .= $this->migrateDataSQL($standard_fields, $additional_fields);
          $sql .= $this->removePropertiesSQL($standard_fields, $additional_fields);
          print $sql; */
    }

    protected function addProperties($standard_fields, $additional_fields) {
        $settings = new AppFormSettings();

        $this->addColumn('{{app_form_settings}}', "authors_order", 'int(11) DEFAULT 0');

        foreach ($standard_fields as $field) {
            $default = intval($settings->{"${field}_order"});
            $this->addColumn('{{app_form_settings}}', "${field}_order", "int(11) DEFAULT $default");
            $default = intval($settings->{"${field}_wi_paper_mode"});
            $this->addColumn('{{app_form_settings}}', "${field}_wi_paper_mode", "int(11) DEFAULT $default");
            $default = intval($settings->{"${field}_wo_paper_mode"});
            $this->addColumn('{{app_form_settings}}', "${field}_wo_paper_mode", "int(11) DEFAULT $default");
            $default = intval($settings->{"is_${field}_wi_paper_published"});
            $this->addColumn('{{app_form_settings}}', "is_${field}_wi_paper_published", "tinyint(1) DEFAULT $default");
            $default = intval($settings->{"is_${field}_wo_paper_published"});
            $this->addColumn('{{app_form_settings}}', "is_${field}_wo_paper_published", "tinyint(1) DEFAULT $default");
        };

        foreach ($additional_fields as $field) {
            for ($i = 1; $i <= 5; $i++) {
                $default = intval($settings->{"${field}${i}_order"});
                $this->addColumn('{{app_form_settings}}', "${field}${i}_order", "int(11) DEFAULT $default");
                $default = intval($settings->{"${field}${i}_wi_paper_mode"});
                $this->addColumn('{{app_form_settings}}', "${field}${i}_wi_paper_mode", "int(11) DEFAULT $default");
                $default = intval($settings->{"${field}${i}_wo_paper_mode"});
                $this->addColumn('{{app_form_settings}}', "${field}${i}_wo_paper_mode", "int(11) DEFAULT $default");
                $default = intval($settings->{"is_${field}${i}_wi_paper_published"});
                $this->addColumn('{{app_form_settings}}', "is_${field}${i}_wi_paper_published", "tinyint(1) DEFAULT $default");
                $default = intval($settings->{"is_${field}${i}_wo_paper_published"});
                $this->addColumn('{{app_form_settings}}', "is_${field}${i}_wo_paper_published", "tinyint(1) DEFAULT $default");
            };
        };
    }

    protected function addPropertiesSQL($standard_fields, $additional_fields) {
        $settings = new AppFormSettings();

        $sql = "ALTER TABLE tbl_app_form_settings ADD `authors_order` int(11) DEFAULT 0;\n\n";

        foreach ($standard_fields as $field) {
            $default = intval($settings->{"${field}_order"});
            $sql .= "ALTER TABLE tbl_app_form_settings ADD `${field}_order` int(11) DEFAULT $default;\n";
            $default = intval($settings->{"${field}_wi_paper_mode"});
            $sql .= "ALTER TABLE tbl_app_form_settings ADD `${field}_wi_paper_mode` int(11) DEFAULT $default;\n";
            $default = intval($settings->{"${field}_wo_paper_mode"});
            $sql .= "ALTER TABLE tbl_app_form_settings ADD `${field}_wo_paper_mode` int(11) DEFAULT $default;\n";
            $default = intval($settings->{"is_${field}_wi_paper_published"});
            $sql .= "ALTER TABLE tbl_app_form_settings ADD `is_${field}_wi_paper_published` tinyint(1) DEFAULT $default;\n";
            $default = intval($settings->{"is_${field}_wo_paper_published"});
            $sql .= "ALTER TABLE tbl_app_form_settings ADD `is_${field}_wo_paper_published` tinyint(1) DEFAULT $default;\n\n";
        };

        foreach ($additional_fields as $field) {
            for ($i = 1; $i <= 5; $i++) {
                $default = intval($settings->{"${field}${i}_order"});
                $sql .= "ALTER TABLE tbl_app_form_settings ADD `${field}${i}_order` int(11) DEFAULT $default;\n";
                $default = intval($settings->{"${field}${i}_wi_paper_mode"});
                $sql .= "ALTER TABLE tbl_app_form_settings ADD `${field}${i}_wi_paper_mode` int(11) DEFAULT $default;\n";
                $default = intval($settings->{"${field}${i}_wo_paper_mode"});
                $sql .= "ALTER TABLE tbl_app_form_settings ADD `${field}${i}_wo_paper_mode` int(11) DEFAULT $default;\n";
                $default = intval($settings->{"is_${field}${i}_wi_paper_published"});
                $sql .= "ALTER TABLE tbl_app_form_settings ADD `is_${field}${i}_wi_paper_published` tinyint(1) DEFAULT $default;\n";
                $default = intval($settings->{"is_${field}${i}_wo_paper_published"});
                $sql .= "ALTER TABLE tbl_app_form_settings ADD `is_${field}${i}_wo_paper_published` tinyint(1) DEFAULT $default;\n\n";
            };
        };

        return $sql;
    }

    protected function addAuthorFileFields() {
        $settings = new AppFormSettings();
        for ($i = 1; $i <= 5; $i++) {
            $this->addColumn('{{app_form_settings}}', "is_af_field${i}_enabled", 'tinyint(1) DEFAULT 0');
            $this->addColumn('{{app_form_settings}}', "is_af_field${i}_published", 'tinyint(1) DEFAULT 0'); //temporary
            $this->addColumn('{{app_form_settings}}', "af_field${i}_mandatory", 'int(11) DEFAULT 0'); //temporary
            $this->addColumn('{{multilingual_app_form_settings}}', "af_field${i}_name", 'text');
            $this->addColumn('{{multilingual_app_form_settings}}', "af_field${i}_hint", 'text');
        }
    }

    protected function addAuthorFileFieldsSQL() {
        $sql = '';
        for ($i = 1; $i <= 5; $i++) {
            $sql .= "ALTER TABLE tbl_app_form_settings ADD `is_af_field${i}_enabled` tinyint(1) DEFAULT 0;\n";
            $sql .= "ALTER TABLE tbl_app_form_settings ADD `is_af_field${i}_published` tinyint(1) DEFAULT 0;\n";
            $sql .= "ALTER TABLE tbl_app_form_settings ADD `af_field${i}_mandatory` int(11) DEFAULT 0;\n";
            $sql .= "ALTER TABLE tbl_multilingual_app_form_settings ADD `af_field${i}_name` text COLLATE utf8_unicode_ci;\n";
            $sql .= "ALTER TABLE tbl_multilingual_app_form_settings ADD `af_field${i}_hint` text COLLATE utf8_unicode_ci;\n\n";
        };
        return $sql;
    }

    protected function migrateData($standard_fields, $additional_fields) {
        $rows = $this->dbConnection->createCommand("select * from {{app_form_settings}}")->queryAll();
        foreach ($rows as $row) {
            $id = $row['id'];

            print("    > migrating data in table {{app_form_settings}} for id = $id ...");

            foreach ($standard_fields as $field) {
                $mandatory = intval($row["${field}_mandatory"]);
                $wi_published = intval($row["is_${field}_published"]);
                $wo_published = $wi_published;
                $enabled = intval($row["is_${field}_enabled"]);
                $wi_mode = $enabled ? ($mandatory + 1) : 0;
                $wo_mode = $wi_mode;
                if (($wi_mode == 0) && in_array($field, array('email', 'lastname', 'firstname', 'middlename'))) {
                    $wi_mode = 1;
                    $wo_mode = 1;
                };
                if (in_array($field, array('lastname', 'firstname', 'middlename'))) {
                    $wi_published = 1;
                    $wo_published = 1;
                };

                if (in_array($field, array('report_title', 'annotation', 'report_file', 'classification', 'report_text'))) {
                    $wo_mode = 0;
                    $wo_published = 0;
                }
                $sql = "update {{app_form_settings}} set `${field}_wi_paper_mode` = :paper_mode,"
                        . " `${field}_wo_paper_mode` = :wo_paper_mode, `is_${field}_wi_paper_published` = :paper_published, "
                        . " `is_${field}_wo_paper_published` = :wo_paper_published where id=:id";
                $this->dbConnection->createCommand($sql)->execute(
                        array(':paper_mode' => $wi_mode, ':wo_paper_mode' => $wo_mode,
                            ':paper_published' => $wi_published, ':wo_paper_published' => $wo_published, ':id' => $id));
            };

            foreach ($additional_fields as $field) {
                for ($i = 1; $i <= 5; $i++) {
                    $mandatory = intval($row["${field}${i}_mandatory"]);
                    $published = intval($row["is_${field}${i}_published"]);
                    $enabled = intval($row["is_${field}${i}_enabled"]);
                    $mode = $enabled ? ($mandatory + 1) : 0;
                    $sql = "update {{app_form_settings}} set `${field}${i}_wi_paper_mode` = :paper_mode,"
                            . " `${field}${i}_wo_paper_mode` = :wo_paper_mode, `is_${field}${i}_wi_paper_published` = :paper_published, "
                            . " `is_${field}${i}_wo_paper_published` = :wo_paper_published where id=:id";
                    $this->dbConnection->createCommand($sql)->execute(
                            array(':paper_mode' => $mode, ':wo_paper_mode' => $mode,
                                ':paper_published' => $published, ':wo_paper_published' => $published, ':id' => $id));
                };
            };

            print(" done\n");
        };
    }

    protected function migrateDataSQL($standard_fields, $additional_fields) {
        $sql = '';
        foreach ($standard_fields as $field) {
            if ($field == 'email') {
                $sql .= "UPDATE tbl_app_form_settings SET "
                        . " ${field}_wi_paper_mode = IF(is_${field}_enabled = 1, IFNULL(${field}_mandatory, 0) + 1, 1),"
                        . " ${field}_wo_paper_mode = IF(is_${field}_enabled = 1, IFNULL(${field}_mandatory, 0) + 1, 1),"
                        . " is_${field}_wi_paper_published = IFNULL(is_${field}_published, 0),"
                        . " is_${field}_wo_paper_published = IFNULL(is_${field}_published, 0);\n\n";
            } else if (in_array($field, array('lastname', 'firstname', 'middlename'))) {
                $sql .= "UPDATE tbl_app_form_settings SET "
                        . " ${field}_wi_paper_mode = IF(is_${field}_enabled = 1, IFNULL(${field}_mandatory, 0) + 1, 1),"
                        . " ${field}_wo_paper_mode = IF(is_${field}_enabled = 1, IFNULL(${field}_mandatory, 0) + 1, 1),"
                        . " is_${field}_wi_paper_published = 1,"
                        . " is_${field}_wo_paper_published = 1;\n\n";
            } else if (in_array($field, array('report_title', 'annotation', 'report_file', 'classification', 'report_text'))) {
                $sql .= "UPDATE tbl_app_form_settings SET "
                        . " ${field}_wi_paper_mode = IF(is_${field}_enabled = 1, IFNULL(${field}_mandatory, 0) + 1, 0),"
                        . " ${field}_wo_paper_mode = 0,"
                        . " is_${field}_wi_paper_published = IFNULL(is_${field}_published, 0),"
                        . " is_${field}_wo_paper_published = 0;\n\n";
            } else {
                $sql .= "UPDATE tbl_app_form_settings SET "
                        . " ${field}_wi_paper_mode = IF(is_${field}_enabled = 1, IFNULL(${field}_mandatory, 0) + 1, 0),"
                        . " ${field}_wo_paper_mode = IF(is_${field}_enabled = 1, IFNULL(${field}_mandatory, 0) + 1, 0),"
                        . " is_${field}_wi_paper_published = IFNULL(is_${field}_published, 0),"
                        . " is_${field}_wo_paper_published = IFNULL(is_${field}_published, 0);\n\n";
            };
        };

        foreach ($additional_fields as $field) {
            for ($i = 1; $i <= 5; $i++) {
                $sql .= "UPDATE tbl_app_form_settings SET "
                        . " ${field}${i}_wi_paper_mode = IF(is_${field}${i}_enabled = 1, IFNULL(${field}${i}_mandatory, 0) + 1, 0),"
                        . " ${field}${i}_wo_paper_mode = IF(is_${field}${i}_enabled = 1, IFNULL(${field}${i}_mandatory, 0) + 1, 0),"
                        . " is_${field}${i}_wi_paper_published = IFNULL(is_${field}${i}_published, 0),"
                        . " is_${field}${i}_wo_paper_published = IFNULL(is_${field}${i}_published, 0);\n\n";
            };
        };

        return $sql;
    }

    protected function removeProperties($standard_fields, $additional_fields) {

        foreach ($standard_fields as $field) {
            $this->dropColumn('{{app_form_settings}}', "${field}_mandatory");
            $this->dropColumn('{{app_form_settings}}', "is_${field}_published");
        };

        foreach ($additional_fields as $field) {
            for ($i = 1; $i <= 5; $i++) {
                $this->dropColumn('{{app_form_settings}}', "${field}${i}_mandatory");
                $this->dropColumn('{{app_form_settings}}', "is_${field}${i}_published");
            };
        };
    }

    protected function removePropertiesSQL($standard_fields, $additional_fields) {
        $sql = '';

        foreach ($standard_fields as $field) {
            $sql .= "ALTER TABLE tbl_app_form_settings DROP COLUMN `${field}_mandatory`;\n";
            $sql .= "ALTER TABLE tbl_app_form_settings DROP COLUMN `is_${field}_published`;\n\n";
        };

        foreach ($additional_fields as $field) {
            for ($i = 1; $i <= 5; $i++) {
                $sql .= "ALTER TABLE tbl_app_form_settings DROP COLUMN `${field}${i}_mandatory`;\n";
                $sql .= "ALTER TABLE tbl_app_form_settings DROP COLUMN `is_${field}${i}_published`;\n\n";
            };
        };

        return $sql;
    }

    public function down() {
        echo "m171102_080702_update_application_form_settings does not support migration down.\n";
        return false;
    }

}
