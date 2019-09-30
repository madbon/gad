<?php

use yii\db\Migration;

/**
 * Class m190925_084803_gad_status_assignment_table
 */
class m190925_084803_gad_status_assignment_table extends Migration
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
            if (!in_array('gad_status_assignment', $tables))  { 
            if ($dbType == "mysql") {
                $this->createTable('{{%gad_status_assignment}}', [
                    'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                    0 => 'PRIMARY KEY (`id`)',
                    'role' => 'VARCHAR(250) NULL',
                    'status' => 'VARCHAR(250) NULL',
                ], $tableOptions_mysql);
            }
            }
             
             
            $this->execute('SET foreign_key_checks = 0');
            $this->insert('{{%gad_status_assignment}}',['id'=>'1','role'=>'gad_region_dilg','status'=>'3,6,8,9,10,11,14,18,21']);
            $this->insert('{{%gad_status_assignment}}',['id'=>'2','role'=>'gad_ppdo','status'=>'0,1,2,4,5,7,12,13,15,16,17,19,20,22']);
            $this->insert('{{%gad_status_assignment}}',['id'=>'3','role'=>'gad_province_dilg','status'=>'0,1,2,4,5,7,12,13,15,17,19,20,22,16']);
            $this->insert('{{%gad_status_assignment}}',['id'=>'4','role'=>'gad_lgu_non_huc','status'=>'0,1,2,4,5,7,12,13,15,16,17,19,20,22']);
            $this->insert('{{%gad_status_assignment}}',['id'=>'5','role'=>'gad_lgu_huc','status'=>'3,6,8,10,11,14,18,21']);
            $this->insert('{{%gad_status_assignment}}',['id'=>'6','role'=>'gad_province_lgu','status'=>'3,6,9,10,11,14,18,21']);
            $this->insert('{{%gad_status_assignment}}',['id'=>'7','role'=>'gad_all_status','status'=>'0,1,2,4,5,3,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22']);
            $this->insert('{{%gad_status_assignment}}',['id'=>'8','role'=>'gad_field_huc','status'=>'3,6,8,10,11,14,18,21']);
            $this->insert('{{%gad_status_assignment}}',['id'=>'9','role'=>'gad_field_non_huc','status'=>'0,1,2,4,5,7,12,13,15,16,17,19,20,22']);
            $this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190925_084803_gad_status_assignment_table cannot be reverted.\n";

         $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `gad_status_assignment`');
        $this->execute('SET foreign_key_checks = 1;');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190925_084803_gad_status_assignment_table cannot be reverted.\n";

        return false;
    }
    */
}
