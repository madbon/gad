<?php

use yii\db\Migration;

/**
 * Class m190822_080619_added_permission_to_lgu_province
 */
class m190822_080619_added_permission_to_lgu_province extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_delete_rowaccomplishment']);
        $this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_delete_rowplanbudget']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190822_080619_added_permission_to_lgu_province cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190822_080619_added_permission_to_lgu_province cannot be reverted.\n";

        return false;
    }
    */
}
