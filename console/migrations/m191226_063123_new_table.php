<?php

use yii\db\Migration;

/**
 * Class m191226_063123_new_table
 */
class m191226_063123_new_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        $dbType = $this->db->driverName;
        $tableOptions_mysql = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $tableOptions_mssql = "";
        $tableOptions_pgsql = "";
        $tableOptions_sqlite = "";
        /* MYSQL */
        if (!in_array('gad_plan_type', $tables))  { 
        if ($dbType == "mysql") {
            $this->createTable('{{%gad_plan_type}}', [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                0 => 'PRIMARY KEY (`id`)',
                'code' => 'INT(11) NULL',
                'title' => 'VARCHAR(250) NULL',
                'description' => 'VARCHAR(250) NULL',
            ], $tableOptions_mysql);
        }
        }
         
         
        $this->execute('SET foreign_key_checks = 0');
        $this->insert('{{%gad_plan_type}}',['id'=>'1','code'=>'1','title'=>'First Plan','description'=>'']);
        $this->insert('{{%gad_plan_type}}',['id'=>'2','code'=>'2','title'=>'Supplemental Plan','description'=>'']);
        $this->insert('{{%gad_plan_type}}',['id'=>'3','code'=>'3','title'=>'For Revision Plan','description'=>'']);
        $this->execute('SET foreign_key_checks = 1;');

        $tables = Yii::$app->db->schema->getTableNames();
        $dbType = $this->db->driverName;
        $tableOptions_mysql = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $tableOptions_mssql = "";
        $tableOptions_pgsql = "";
        $tableOptions_sqlite = "";
        /* MYSQL */
        if (!in_array('gad_update_history', $tables))  { 
        if ($dbType == "mysql") {
            $this->createTable('{{%gad_update_history}}', [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                0 => 'PRIMARY KEY (`id`)',
                'record_id' => 'INT(11) NULL',
                'record_tuc' => 'VARCHAR(100) NULL',
                'user_id' => 'INT(11) NULL',
                'fullname' => 'VARCHAR(150) NULL',
                'column_title' => 'VARCHAR(250) NULL',
                'row_id' => 'INT(11) NULL',
                'value' => 'MEDIUMTEXT NULL',
                'model_name' => 'VARCHAR(250) NULL',
                'date_created' => 'DATE NULL',
                'time_created' => 'VARCHAR(10) NULL',
            ], $tableOptions_mysql);
        }
        }
 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191226_063123_new_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191226_063123_new_table cannot be reverted.\n";

        return false;
    }
    */
}
