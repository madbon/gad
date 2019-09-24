<?php

use yii\db\Migration;

/**
 * Class m190912_004553_superadmin_admin
 */
class m190912_004553_superadmin_admin extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%auth_item}}',['name'=>'SuperAdministrator','type'=>'1','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554696631','updated_at'=>'1560133863']);
        $this->insert('{{%auth_item}}',['name'=>'Administrator','type'=>'1','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554696631','updated_at'=>'1560133863']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190912_004553_superadmin_admin cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190912_004553_superadmin_admin cannot be reverted.\n";

        return false;
    }
    */
}
