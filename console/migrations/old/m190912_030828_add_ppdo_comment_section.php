<?php

use yii\db\Migration;

/**
 * Class m190912_030828_add_ppdo_comment_section
 */
class m190912_030828_add_ppdo_comment_section extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_ppdo','child'=>'gad_comment_performance']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190912_030828_add_ppdo_comment_section cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190912_030828_add_ppdo_comment_section cannot be reverted.\n";

        return false;
    }
    */
}
