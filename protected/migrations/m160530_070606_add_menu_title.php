<?php

class m160530_070606_add_menu_title extends CDbMigration {

    public function up() {
        $this->addColumn('{{multilingual_conf}}', 'menu_title', 'varchar(900)');
    }

    public function down() {
        echo "m160530_070606_add_menu_title does not support migration down.\n";
        return false;
    }

}
