<?php

use yii\db\Migration;

/**
 * Class m190827_015502_gad_year_lookup_table
 */
class m190827_015502_gad_year_lookup_table extends Migration
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
        if (!in_array('gad_year', $tables))  { 
        if ($dbType == "mysql") {
            $this->createTable('{{%gad_year}}', [
                'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                0 => 'PRIMARY KEY (`id`)',
                'value' => 'INT(11) NOT NULL',
            ], $tableOptions_mysql);
        }
        }
         
         
        $this->execute('SET foreign_key_checks = 0');
        $this->insert('{{%gad_year}}',['id'=>'1','value'=>'2017']);
        $this->insert('{{%gad_year}}',['id'=>'2','value'=>'2018']);
        $this->insert('{{%gad_year}}',['id'=>'3','value'=>'2019']);
        $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190827_015502_gad_year_lookup_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190827_015502_gad_year_lookup_table cannot be reverted.\n";

        return false;
    }
    */
}
