<?php

use yii\db\Migration;

/**
 * Class m191104_022929_add_attribute_futuretense_gad_status
 */
class m191104_022929_add_attribute_futuretense_gad_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->addColumn('gad_status', 'future_tense', 'VARCHAR(150) NULL AFTER `title` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191104_022929_add_attribute_futuretense_gad_status cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191104_022929_add_attribute_futuretense_gad_status cannot be reverted.\n";

        return false;
    }
    */
}
