<?php

use yii\db\Migration;

/**
 * Class m190924_042655_add_attributes_report_gad_report_history_table
 */
class m190924_042655_add_attributes_report_gad_report_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gad_report_history', 'responsible_region_c', 'VARCHAR(2) NULL AFTER `responsible_user_id` ');
        $this->addColumn('gad_report_history', 'responsible_province_c', 'VARCHAR(2) NULL AFTER `responsible_region_c` ');
        $this->addColumn('gad_report_history', 'responsible_citymun_c', 'VARCHAR(2) NULL AFTER `responsible_province_c` ');
        $this->addColumn('gad_report_history', 'fullname', 'VARCHAR(250) NULL AFTER `responsible_citymun_c` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190924_042655_add_attributes_report_gad_report_history_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190924_042655_add_attributes_report_gad_report_history_table cannot be reverted.\n";

        return false;
    }
    */
}
