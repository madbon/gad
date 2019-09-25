<?php

use yii\db\Migration;

/**
 * Class m190817_085755_gad_transaction_table
 */
class m190817_085755_gad_transaction_table extends Migration
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
if (!in_array('gad_accomplishment_report', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_accomplishment_report}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'plan_budget_id' => 'INT(11) NULL',
        'user_id' => 'INT(11) NULL',
        'record_id' => 'INT(11) NULL',
        'focused_id' => 'INT(11) NULL',
        'inner_category_id' => 'INT(11) NULL',
        'gi_sup_data' => 'TEXT NULL',
        'source' => 'VARCHAR(250) NULL',
        'cliorg_ppa_attributed_program_id' => 'VARCHAR(50) NULL',
        'ppa_focused_id' => 'INT(11) NULL',
        'ppa_value' => 'TEXT NULL',
        'cause_gender_issue' => 'TEXT NULL',
        'objective' => 'TEXT NULL',
        'relevant_lgu_ppa' => 'TEXT NULL',
        'activity_category_id' => 'VARCHAR(150) NULL',
        'activity' => 'TEXT NULL',
        'performance_indicator' => 'TEXT NULL',
        'target' => 'TEXT NULL',
        'actual_results' => 'TEXT NULL',
        'total_approved_gad_budget' => 'DECIMAL(18,2) NULL',
        'actual_cost_expenditure' => 'DECIMAL(18,2) NULL',
        'variance_remarks' => 'TEXT NULL',
        'date_created' => 'DATE NULL',
        'time_created' => 'VARCHAR(10) NULL',
        'date_updated' => 'DATE NULL',
        'time_updated' => 'VARCHAR(10) NULL',
        'record_tuc' => 'VARCHAR(150) NULL',
        'this_tuc' => 'VARCHAR(150) NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_ar_attributed_program', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_ar_attributed_program}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'record_id' => 'INT(11) NULL',
        'record_tuc' => 'VARCHAR(150) NULL',
        'controller_id' => 'VARCHAR(150) NULL',
        'ppa_attributed_program_id' => 'VARCHAR(150) NULL',
        'ppa_attributed_program_others' => 'TEXT NULL',
        'lgu_program_project' => 'TEXT NULL',
        'checklist_id' => 'INT(11) NULL',
        'score_type' => 'INT(11) NULL',
        'hgdg_pimme' => 'VARCHAR(10) NULL',
        'total_annual_pro_cost' => 'DECIMAL(18,2) NULL',
        'gad_attributed_pro_cost' => 'DECIMAL(18,2) NULL',
        'ar_ap_variance_remarks' => 'TEXT NULL',
        'date_created' => 'DATE NULL',
        'time_created' => 'VARCHAR(10) NULL',
        'date_updated' => 'DATE NULL',
        'time_updated' => 'VARCHAR(10) NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_category_comment', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_category_comment}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'category_id' => 'INT(11) NULL',
        'record_id' => 'INT(11) NULL',
        'value' => 'TEXT NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_cms_values', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_cms_values}}', [
        'id' => 'INT(255) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'term_record_id' => 'VARCHAR(255) NULL',
        'yearly_record_id' => 'INT(255) NULL',
        'da_brgy_id' => 'INT(255) NULL',
        'category_id' => 'INT(255) NOT NULL',
        'indicator_id' => 'INT(255) NOT NULL',
        'sub_question_id' => 'INT(255) NULL',
        'frequency_details_id' => 'INT(255) NULL',
        'value' => 'VARCHAR(200) NOT NULL',
        'remarks' => 'TEXT NOT NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_comment', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_comment}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'resp_user_id' => 'INT(11) NULL',
        'resp_office_c' => 'INT(2) NULL',
        'record_id' => 'INT(11) NULL',
        'plan_budget_id' => 'INT(11) NOT NULL',
        'resp_region_c' => 'VARCHAR(2) NULL',
        'resp_province_c' => 'VARCHAR(2) NULL',
        'resp_citymun_c' => 'VARCHAR(2) NULL',
        'focused_id' => 'INT(11) NOT NULL',
        'inner_category_id' => 'INT(11) NOT NULL',
        'comment' => 'MEDIUMTEXT NULL',
        'row_no' => 'INT(11) NOT NULL',
        'column_no' => 'INT(11) NOT NULL',
        'column_title' => 'VARCHAR(250) NULL',
        'row_value' => 'TEXT NOT NULL',
        'column_value' => 'TEXT NOT NULL',
        'model_name' => 'VARCHAR(150) NULL',
        'attribute_name' => 'VARCHAR(150) NULL',
        'date_created' => 'DATE NULL',
        'time_created' => 'VARCHAR(10) NULL',
        'date_updated' => 'DATE NULL',
        'time_updated' => 'VARCHAR(10) NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_excel_attachments', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_excel_attachments}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'user_id' => 'INT(11) NOT NULL',
        'filename' => 'TEXT NOT NULL',
        'type' => 'VARCHAR(50) NOT NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_file_attached', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_file_attached}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'user_id' => 'INT(11) NOT NULL',
        'file_name' => 'VARCHAR(250) NULL',
        'model_id' => 'INT(11) NOT NULL',
        'model_name' => 'VARCHAR(150) NOT NULL',
        'remarks' => 'VARCHAR(250) NULL',
        'extension' => 'VARCHAR(10) NULL',
        'file_folder_type_id' => 'INT(11) NOT NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_plan_budget', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_plan_budget}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'old_plan_id' => 'INT(11) NOT NULL',
        'user_id' => 'INT(11) NULL',
        'record_id' => 'INT(11) NULL',
        'focused_id' => 'INT(11) NULL',
        'inner_category_id' => 'INT(11) NULL',
        'gi_sup_data' => 'TEXT NULL',
        'source' => 'TEXT NULL',
        'cliorg_ppa_attributed_program_id' => 'VARCHAR(50) NULL',
        'ppa_focused_id' => 'INT(11) NULL',
        'ppa_value' => 'VARCHAR(500) NULL',
        'cause_gender_issue' => 'TEXT NULL',
        'objective' => 'TEXT NULL',
        'relevant_lgu_program_project' => 'TEXT NULL',
        'activity_category_id' => 'VARCHAR(150) NULL',
        'activity' => 'TEXT NULL',
        'date_implement_start' => 'DATE NULL',
        'date_implement_end' => 'DATE NULL',
        'performance_target' => 'TEXT NULL',
        'performance_indicator' => 'TEXT NULL',
        'budget_mooe' => 'DECIMAL(18,2) NULL',
        'budget_ps' => 'DECIMAL(18,2) NULL',
        'budget_co' => 'DECIMAL(18,2) NULL',
        'lead_responsible_office' => 'VARCHAR(250) NULL',
        'date_created' => 'DATE NULL',
        'time_created' => 'VARCHAR(10) NULL',
        'date_updated' => 'DATE NULL',
        'time_updated' => 'VARCHAR(10) NULL',
        'sort' => 'DECIMAL(18,2) NULL',
        'record_tuc' => 'VARCHAR(150) NULL',
        'tuc' => 'VARCHAR(150) NULL',
        'upload_status' => 'INT(11) NOT NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_record', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_record}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'create_status_id' => 'INT(11) NULL',
        'report_type_id' => 'INT(11) NULL',
        'attached_ar_record_id' => 'INT(11) NULL',
        'for_revision_record_id' => 'INT(11) NULL',
        'user_id' => 'INT(11) NULL',
        'office_c' => 'INT(11) NULL',
        'isdilg' => 'INT(11) NULL',
        'region_c' => 'VARCHAR(2) NULL',
        'province_c' => 'VARCHAR(2) NULL',
        'citymun_c' => 'VARCHAR(2) NULL',
        'total_lgu_budget' => 'DECIMAL(18,2) NULL',
        'total_gad_budget' => 'DECIMAL(18,2) NULL',
        'year' => 'INT(4) NULL',
        'prepared_by' => 'VARCHAR(150) NULL',
        'approved_by' => 'VARCHAR(150) NULL',
        'footer_date' => 'DATE NULL',
        'form_type' => 'INT(11) NULL',
        'status' => 'INT(11) NULL',
        'is_returned' => 'VARCHAR(3) NULL DEFAULT \'no\'',
        'is_archive' => 'INT(11) NOT NULL',
        'tuc' => 'VARCHAR(150) NULL',
        'date_created' => 'DATE NULL',
        'time_created' => 'VARCHAR(10) NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_report_history', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_report_history}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'remarks' => 'TEXT NULL',
        'tuc' => 'VARCHAR(100) NULL',
        'status' => 'INT(11) NULL',
        'responsible_office_c' => 'INT(11) NULL',
        'responsible_user_id' => 'INT(11) NULL',
        'date_created' => 'DATE NULL',
        'time_created' => 'VARCHAR(10) NULL',
    ], $tableOptions_mysql);
}
}
 
 
$this->createIndex('idx_da_brgy_id_6601_00','gad_cms_values','da_brgy_id',0);
$this->createIndex('idx_category_id_6601_01','gad_cms_values','category_id',0);
$this->createIndex('idx_frequency_details_id_6601_02','gad_cms_values','frequency_details_id',0);
$this->createIndex('idx_indicator_id_6601_03','gad_cms_values','indicator_id',0);
$this->createIndex('idx_sub_question_id_6601_04','gad_cms_values','sub_question_id',0);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190817_085755_gad_transaction_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190817_085755_gad_transaction_table cannot be reverted.\n";

        return false;
    }
    */
}
