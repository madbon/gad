<?php

use yii\db\Migration;

/**
 * Class m190930_051936_regional_role
 */
class m190930_051936_regional_role extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%auth_item}}',['name'=>'RegionalAdministrator','type'=>'1','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554696631','updated_at'=>'1560133863']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190930_051936_regional_role cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190930_051936_regional_role cannot be reverted.\n";

        return false;
    }
    */
}
