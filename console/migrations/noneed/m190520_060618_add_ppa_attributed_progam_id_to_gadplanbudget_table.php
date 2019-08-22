<?php

use yii\db\Migration;

/**
 * Class m190520_060618_add_ppa_attributed_progam_id_to_gadplanbudget_table
 */
class m190520_060618_add_ppa_attributed_progam_id_to_gadplanbudget_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gad_plan_budget', 'cliorg_ppa_attributed_program_id', 'VARCHAR(50) DEFAULT NULL AFTER inner_category_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190520_060618_add_ppa_attributed_progam_id_to_gadplanbudget_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190520_060618_add_ppa_attributed_progam_id_to_gadplanbudget_table cannot be reverted.\n";

        return false;
    }
    */
}
