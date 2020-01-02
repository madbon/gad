<?php

use yii\db\Migration;

/**
 * Class m191226_062421_update_tables_migrations
 */
class m191226_062421_update_tables_migrations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gad_accomplishment_report', 'plan_type_code', 'INT(11) NULL AFTER `this_tuc` ');
        $this->addColumn('gad_ar_attributed_program', 'plan_type_code', 'INT(11) NULL AFTER `time_updated` ');
        $this->addColumn('gad_attributed_program', 'old_row_id', 'INT(11) NULL AFTER `id` ');
        $this->addColumn('gad_record', 'plan_type_code', 'INT(11) NULL AFTER `id` ');
        $this->addColumn('gad_record', 'supplemental_record_id', 'INT(11) NULL AFTER `plan_type_code` ');
        $this->addColumn('gad_record', 'has_additional_lgu_budget', 'VARCHAR(3) NULL AFTER `citymun_c` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191226_062421_update_tables_migrations cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191226_062421_update_tables_migrations cannot be reverted.\n";

        return false;
    }
    */
}
