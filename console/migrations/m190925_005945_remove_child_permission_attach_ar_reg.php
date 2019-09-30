<?php

use yii\db\Migration;

/**
 * Class m190925_005945_remove_child_permission_attach_ar_reg
 */
class m190925_005945_remove_child_permission_attach_ar_reg extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->delete('auth_item_child',['parent' => 'gad_region_permission', 'child' => 'gad_attach_accomplishment']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190925_005945_remove_child_permission_attach_ar_reg cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190925_005945_remove_child_permission_attach_ar_reg cannot be reverted.\n";

        return false;
    }
    */
}
