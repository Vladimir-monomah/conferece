<?php

class m160414_061302_create_reg_table extends CDbMigration {

    public function up() {
        $this->createTable('{{reg}}', array(
            'id' => 'pk',
            'title' => 'string',
            'url' => 'string',
            'date' => 'integer'
                ), CreateTables::TABLE_OPTIONS);
    }

    public function down() {
        $this->dropTable('{{reg}}');
    }

}
