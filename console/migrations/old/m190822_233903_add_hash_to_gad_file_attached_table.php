<?php

use yii\db\Migration;

/**
 * Class m190822_233903_add_hash_to_gad_file_attached_table
 */
class m190822_233903_add_hash_to_gad_file_attached_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gad_file_attached', 'hash', 'VARCHAR(150) AFTER `model_name` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190822_233903_add_hash_to_gad_file_attached_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190822_233903_add_hash_to_gad_file_attached_table cannot be reverted.\n";

        return false;
    }
    */
}
