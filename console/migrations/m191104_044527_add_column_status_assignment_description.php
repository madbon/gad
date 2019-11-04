<?php

use yii\db\Migration;

/**
 * Class m191104_044527_add_column_status_assignment_description
 */
class m191104_044527_add_column_status_assignment_description extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gad_status_assignment', 'description', 'VARCHAR(500) NULL AFTER `role` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191104_044527_add_column_status_assignment_description cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191104_044527_add_column_status_assignment_description cannot be reverted.\n";

        return false;
    }
    */
}
