<?php

use yii\db\Migration;

/**
 * Class m191030_024714_new_permission_archive_filtered_result
 */
class m191030_024714_new_permission_archive_filtered_result extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%auth_item}}',['name'=>'gad_archive_filtered_result','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1572403501','updated_at'=>'1572403501']);
        $this->insert('{{%auth_item_child}}',['parent'=>'gad_admin_permission','child'=>'gad_archive_filtered_result']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191030_024714_new_permission_archive_filtered_result cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191030_024714_new_permission_archive_filtered_result cannot be reverted.\n";

        return false;
    }
    */
}
