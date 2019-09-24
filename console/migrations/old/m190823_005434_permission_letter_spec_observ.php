<?php

use yii\db\Migration;

/**
 * Class m190823_005434_permission_letter_spec_observ
 */
class m190823_005434_permission_letter_spec_observ extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%auth_item}}',['name'=>'gad_letter_specifc_observation','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1560912904','updated_at'=>'1560912904']);
        $this->insert('{{%auth_item_child}}',['parent'=>'gad_province_permission','child'=>'gad_letter_specifc_observation']);
        $this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_letter_specifc_observation']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190823_005434_permission_letter_spec_observ cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190823_005434_permission_letter_spec_observ cannot be reverted.\n";

        return false;
    }
    */
}
