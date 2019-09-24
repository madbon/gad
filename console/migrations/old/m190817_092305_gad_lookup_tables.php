<?php

use yii\db\Migration;

/**
 * Class m190817_092305_gad_lookup_tables
 */
class m190817_092305_gad_lookup_tables extends Migration
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
if (!in_array('gad_activity_category', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_activity_category}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'title' => 'VARCHAR(250) NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_checklist', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_checklist}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'report_type_id' => 'INT(11) NOT NULL',
        'title' => 'VARCHAR(250) NULL',
        'is_hidden' => 'INT(11) NOT NULL',
        'sort' => 'DOUBLE NOT NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_create_status', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_create_status}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'code' => 'INT(11) NOT NULL',
        'title' => 'VARCHAR(250) NULL',
        'is_active' => 'INT(11) NOT NULL DEFAULT \'1\'',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_file_folder_type', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_file_folder_type}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'title' => 'VARCHAR(250) NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_focused', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_focused}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'title' => 'VARCHAR(150) NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_form_type', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_form_type}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'title' => 'VARCHAR(150) NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_inner_category', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_inner_category}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'title' => 'VARCHAR(150) NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_ppa_attributed_program', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_ppa_attributed_program}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'title' => 'VARCHAR(250) NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_report_type', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_report_type}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'title' => 'VARCHAR(250) NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_score_type', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_score_type}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'code' => 'INT(11) NULL',
        'title' => 'VARCHAR(250) NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_status', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_status}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'code' => 'INT(11) NOT NULL',
        'title' => 'VARCHAR(250) NULL',
    ], $tableOptions_mysql);
}
}
 
 
$this->execute('SET foreign_key_checks = 0');
$this->insert('{{%gad_activity_category}}',['id'=>'1','title'=>'CapDev / Trainings - Gender Sensitivity Trainings (GST)']);
$this->insert('{{%gad_activity_category}}',['id'=>'2','title'=>'CapDev / Trainings - Gender Analysis']);
$this->insert('{{%gad_activity_category}}',['id'=>'3','title'=>'CapDev / Trainings - Gender Responsive Planning and Budgeting']);
$this->insert('{{%gad_activity_category}}',['id'=>'4','title'=>'CapDev / Trainings - GAD Related Policies']);
$this->insert('{{%gad_activity_category}}',['id'=>'5','title'=>'Development of IEC Materials']);
$this->insert('{{%gad_activity_category}}',['id'=>'6','title'=>'GAD Advocacy Activities']);
$this->insert('{{%gad_activity_category}}',['id'=>'7','title'=>'PPAs related to the implementation of Republic Act No. 10354-Reproductive Health Law']);
$this->insert('{{%gad_activity_category}}',['id'=>'8','title'=>'Establishment of Violence Against Women and their Children (VAWC)  Center']);
$this->insert('{{%gad_activity_category}}',['id'=>'9','title'=>'Establishment / Maintenance of Day Care Center']);
$this->insert('{{%gad_activity_category}}',['id'=>'10','title'=>'Establishment / Maintenance of Women Crisis Center']);
$this->insert('{{%gad_activity_category}}',['id'=>'11','title'=>'Establishment / Maintenance of Halfway houses for trafficked women and girls']);
$this->insert('{{%gad_activity_category}}',['id'=>'12','title'=>'Institutional Mechanism to Implement the MCW - Creation and/or Strengthening the LGU GFPS']);
$this->insert('{{%gad_activity_category}}',['id'=>'13','title'=>'Institutional Mechanism to Implement the MCW - Establishment & Maintenance of GAD Database']);
$this->insert('{{%gad_activity_category}}',['id'=>'14','title'=>'Institutional Mechanism to Implement the MCW - GAD Planning & Budgeting Local Development Plans']);
$this->insert('{{%gad_activity_category}}',['id'=>'15','title'=>'Institutional Mechanism to Implement the MCW - Mainstreaming Gender Perspectives in Local Development Plans']);
$this->insert('{{%gad_activity_category}}',['id'=>'16','title'=>'Institutional Mechanism to Implement the MCW - Formulation/Enhancement and Implementation of the LGU GAD Code']);
$this->insert('{{%gad_checklist}}',['id'=>'1','report_type_id'=>'1','title'=>'Generic','is_hidden'=>'0','sort'=>'1']);
$this->insert('{{%gad_checklist}}',['id'=>'2','report_type_id'=>'1','title'=>'Agricultural and Agrarian Reform','is_hidden'=>'0','sort'=>'2']);
$this->insert('{{%gad_checklist}}',['id'=>'3','report_type_id'=>'1','title'=>'Natural Resource Management','is_hidden'=>'0','sort'=>'3']);
$this->insert('{{%gad_checklist}}',['id'=>'4','report_type_id'=>'1','title'=>'Private Sector Development','is_hidden'=>'0','sort'=>'5']);
$this->insert('{{%gad_checklist}}',['id'=>'5','report_type_id'=>'1','title'=>'Social Sector : Education','is_hidden'=>'0','sort'=>'6']);
$this->insert('{{%gad_checklist}}',['id'=>'6','report_type_id'=>'1','title'=>'Social Sector : Health','is_hidden'=>'0','sort'=>'7']);
$this->insert('{{%gad_checklist}}',['id'=>'7','report_type_id'=>'1','title'=>'Social Sector : Housing and Settlement','is_hidden'=>'0','sort'=>'8']);
$this->insert('{{%gad_checklist}}',['id'=>'8','report_type_id'=>'1','title'=>'Social Sector Women in Areas Under Armed Conflict','is_hidden'=>'0','sort'=>'9']);
$this->insert('{{%gad_checklist}}',['id'=>'9','report_type_id'=>'1','title'=>'Justice','is_hidden'=>'0','sort'=>'10']);
$this->insert('{{%gad_checklist}}',['id'=>'10','report_type_id'=>'1','title'=>'Information and Communication Technologies','is_hidden'=>'0','sort'=>'11']);
$this->insert('{{%gad_checklist}}',['id'=>'11','report_type_id'=>'1','title'=>'Microfinance','is_hidden'=>'0','sort'=>'12']);
$this->insert('{{%gad_checklist}}',['id'=>'12','report_type_id'=>'1','title'=>'Labor and Employment','is_hidden'=>'0','sort'=>'13']);
$this->insert('{{%gad_checklist}}',['id'=>'13','report_type_id'=>'1','title'=>'Child Labor','is_hidden'=>'0','sort'=>'14']);
$this->insert('{{%gad_checklist}}',['id'=>'14','report_type_id'=>'1','title'=>'Migration','is_hidden'=>'0','sort'=>'15']);
$this->insert('{{%gad_checklist}}',['id'=>'15','report_type_id'=>'1','title'=>'Infrastructure','is_hidden'=>'0','sort'=>'4']);
$this->insert('{{%gad_checklist}}',['id'=>'16','report_type_id'=>'1','title'=>'Tourism','is_hidden'=>'0','sort'=>'16']);
$this->insert('{{%gad_checklist}}',['id'=>'17','report_type_id'=>'1','title'=>'Energy','is_hidden'=>'0','sort'=>'17']);
$this->insert('{{%gad_checklist}}',['id'=>'18','report_type_id'=>'1','title'=>'Disaster Risk Reduction and Management','is_hidden'=>'0','sort'=>'18']);
$this->insert('{{%gad_checklist}}',['id'=>'19','report_type_id'=>'1','title'=>'Development Planning','is_hidden'=>'0','sort'=>'19']);
$this->insert('{{%gad_checklist}}',['id'=>'20','report_type_id'=>'1','title'=>'Funding Facilities','is_hidden'=>'0','sort'=>'20']);
$this->insert('{{%gad_checklist}}',['id'=>'21','report_type_id'=>'1','title'=>'Fisheries','is_hidden'=>'0','sort'=>'21']);
$this->insert('{{%gad_checklist}}',['id'=>'22','report_type_id'=>'2','title'=>'Project Implementation and Management, and Monitoring Evaluation','is_hidden'=>'0','sort'=>'1']);
$this->insert('{{%gad_create_status}}',['id'=>'1','code'=>'1','title'=>'New Plan','is_active'=>'1']);
$this->insert('{{%gad_create_status}}',['id'=>'2','code'=>'2','title'=>' For Revision','is_active'=>'1']);
$this->insert('{{%gad_create_status}}',['id'=>'3','code'=>'3','title'=>'Supplemental Plan','is_active'=>'1']);
$this->insert('{{%gad_file_folder_type}}',['id'=>'1','title'=>'Narrative Project Accomplishment Report']);
$this->insert('{{%gad_file_folder_type}}',['id'=>'2','title'=>'Result of HGDG Checklist']);
$this->insert('{{%gad_file_folder_type}}',['id'=>'3','title'=>'Endorsing LGU Attachment(s)']);
$this->insert('{{%gad_file_folder_type}}',['id'=>'4','title'=>'For Revision Attachment(s)']);
$this->insert('{{%gad_focused}}',['id'=>'1','title'=>'CLIENT-FOCUSED']);
$this->insert('{{%gad_focused}}',['id'=>'2','title'=>'ORGANIZATION-FOCUSED']);
$this->insert('{{%gad_form_type}}',['id'=>'1','title'=>'Annual Gender and Development (GAD) Plan and Budget']);
$this->insert('{{%gad_form_type}}',['id'=>'2','title'=>'Annual Gender and Development (GAD) Accomplishment Report']);
$this->insert('{{%gad_inner_category}}',['id'=>'1','title'=>'Gender Issue']);
$this->insert('{{%gad_inner_category}}',['id'=>'2','title'=>'GAD Mandate']);
$this->insert('{{%gad_ppa_attributed_program}}',['id'=>'1','title'=>'Economic']);
$this->insert('{{%gad_ppa_attributed_program}}',['id'=>'2','title'=>'Social']);
$this->insert('{{%gad_ppa_attributed_program}}',['id'=>'3','title'=>'Infrastructure']);
$this->insert('{{%gad_ppa_attributed_program}}',['id'=>'4','title'=>'Environmental']);
$this->insert('{{%gad_ppa_attributed_program}}',['id'=>'5','title'=>'Institutional']);
$this->insert('{{%gad_report_type}}',['id'=>'1','title'=>'ANNUAL GENDER AND DEVELOPMENT (GAD) PLAN AND BUDGET']);
$this->insert('{{%gad_report_type}}',['id'=>'2','title'=>'ANNUAL GENDER AND DEVELOPMENT (GAD) ACCOMPLISHMENT REPORT']);
$this->insert('{{%gad_score_type}}',['id'=>'1','code'=>'1','title'=>'PIMME']);
$this->insert('{{%gad_score_type}}',['id'=>'2','code'=>'2','title'=>'FIMME']);
$this->insert('{{%gad_status}}',['id'=>'1','code'=>'0','title'=>'Encoding Process (CC/M)']);
$this->insert('{{%gad_status}}',['id'=>'2','code'=>'1','title'=>'For Review by PPDO']);
$this->insert('{{%gad_status}}',['id'=>'3','code'=>'2','title'=>'Submitted to DILG Provincial Office']);
$this->insert('{{%gad_status}}',['id'=>'4','code'=>'4','title'=>'Endorsed By DILG (Province)']);
$this->insert('{{%gad_status}}',['id'=>'5','code'=>'5','title'=>'Returned to PPDO by DILG Provincial Office']);
$this->insert('{{%gad_status}}',['id'=>'6','code'=>'3','title'=>'Submitted to Regional Office']);
$this->insert('{{%gad_status}}',['id'=>'7','code'=>'6','title'=>'Returned to LGU by Regional Office']);
$this->insert('{{%gad_status}}',['id'=>'8','code'=>'7','title'=>' Returned to LGU C/M Office by PPDO']);
$this->insert('{{%gad_status}}',['id'=>'9','code'=>'8','title'=>'Encoding Process (HUC/ICC)']);
$this->insert('{{%gad_status}}',['id'=>'10','code'=>'9','title'=>'Encoding Process (Province)']);
$this->insert('{{%gad_status}}',['id'=>'11','code'=>'10','title'=>'Endorsed by DILG (Region)']);
$this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190817_092305_gad_lookup_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190817_092305_gad_lookup_tables cannot be reverted.\n";

        return false;
    }
    */
}
