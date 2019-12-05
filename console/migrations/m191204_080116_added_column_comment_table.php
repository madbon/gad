<?php

use yii\db\Migration;

/**
 * Class m191204_080116_added_column_comment_table
 */
class m191204_080116_added_column_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gad_comment', 'role_name', 'VARCHAR(50) NULL AFTER `id` ');
        $this->addColumn('gad_comment', 'full_name', 'VARCHAR(250) NULL AFTER `role_name` ');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191204_080116_added_column_comment_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191204_080116_added_column_comment_table cannot be reverted.\n";

        return false;
    }
    */
}
