<?php

use yii\db\Migration;

/**
 * Class m191030_024947_new_table_archive_history
 */
class m191030_024947_new_table_archive_history extends Migration
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
        if (!in_array('gad_archive_history', $tables))  { 
            if ($dbType == "mysql") {
                $this->createTable('{{%gad_archive_history}}', [
                    'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                    0 => 'PRIMARY KEY (`id`)',
                    'record_id' => 'INT(11) NULL',
                    'record_tuc' => 'VARCHAR(250) NULL',
                    'archiveby_userid' => 'INT(11) NULL',
                    'archiveby_name' => 'VARCHAR(150) NULL',
                    'remarks' => 'VARCHAR(250) NULL',
                    'status' => 'INT(11) NULL',
                    'date_created' => 'DATE NULL',
                    'time_created' => 'VARCHAR(10) NULL',
                    'date_restored' => 'DATE NULL',
                    'time_restored' => 'VARCHAR(10) NULL',
                ], $tableOptions_mysql);
            }
        }
             
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191030_024947_new_table_archive_history cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191030_024947_new_table_archive_history cannot be reverted.\n";

        return false;
    }
    */
}
