<?php

use yii\db\Migration;

/**
 * Class m190822_134020_gad_attributed_programs_table
 */
class m190822_134020_gad_attributed_programs_table extends Migration
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
            if (!in_array('gad_attributed_program', $tables))  { 
            if ($dbType == "mysql") {
                $this->createTable('{{%gad_attributed_program}}', [
                    'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
                    0 => 'PRIMARY KEY (`id`)',
                    'record_id' => 'INT(11) NULL',
                    'record_tuc' => 'VARCHAR(150) NULL',
                    'controller_id' => 'VARCHAR(150) NULL',
                    'ppa_attributed_program_id' => 'VARCHAR(50) NULL',
                    'ppa_attributed_program_others' => 'TEXT NULL',
                    'lgu_program_project' => 'TEXT NULL',
                    'checklist_id' => 'INT(11) NULL',
                    'hgdg' => 'DOUBLE NULL',
                    'total_annual_pro_budget' => 'DECIMAL(18,2) NULL',
                    'attributed_pro_budget' => 'DECIMAL(18,2) NULL',
                    'ap_lead_responsible_office' => 'VARCHAR(150) NULL',
                    'date_created' => 'DATE NULL',
                    'time_created' => 'VARCHAR(10) NULL',
                    'date_updated' => 'DATE NULL',
                    'time_updated' => 'VARCHAR(10) NULL',
                    'upload_status' => 'INT(11) NOT NULL',
                ], $tableOptions_mysql);
            }
            }
             
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190822_134020_gad_attributed_programs_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190822_134020_gad_attributed_programs_table cannot be reverted.\n";

        return false;
    }
    */
}
