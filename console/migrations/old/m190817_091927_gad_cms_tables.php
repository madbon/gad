<?php

use yii\db\Migration;

/**
 * Class m190817_091927_gad_cms_tables
 */
class m190817_091927_gad_cms_tables extends Migration
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
if (!in_array('gad_cms_category', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_cms_category}}', [
        'id' => 'INT(255) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'title' => 'TEXT NOT NULL',
        'frequency' => 'VARCHAR(30) NOT NULL',
        'frequency_id' => 'INT(255) NULL',
        'lgup_content_type_id' => 'INT(11) NOT NULL DEFAULT \'1\'',
        'lgup_content_width_id' => 'INT(11) NULL',
        'applicable_to' => 'INT(11) NOT NULL',
        'left_or_right' => 'INT(11) NOT NULL',
        'sort' => 'DOUBLE NULL',
        'add_comment' => 'INT(11) NOT NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_cms_choice_with_subquestion', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_cms_choice_with_subquestion}}', [
        'id' => 'INT(255) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'indicator_id' => 'INT(255) NULL',
        'answer' => 'VARCHAR(200) NOT NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_cms_content_type', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_cms_content_type}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'type' => 'VARCHAR(50) NOT NULL',
        'description' => 'VARCHAR(250) NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_cms_content_width', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_cms_content_width}}', [
        'id' => 'INT(11) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'class_name' => 'VARCHAR(50) NOT NULL',
        'description' => 'VARCHAR(250) NOT NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_cms_frequency', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_cms_frequency}}', [
        'id' => 'INT(255) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'title' => 'VARCHAR(150) NOT NULL',
        'count' => 'INT(100) NOT NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_cms_frequency_details', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_cms_frequency_details}}', [
        'id' => 'INT(255) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'frequency_id' => 'INT(255) NOT NULL',
        'details' => 'VARCHAR(100) NOT NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_cms_ind_choices', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_cms_ind_choices}}', [
        'id' => 'INT(255) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'indicator_id' => 'INT(255) NULL',
        'default_choice_id' => 'INT(255) NULL',
        'value' => 'VARCHAR(300) NOT NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_cms_ind_default_choices', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_cms_ind_default_choices}}', [
        'id' => 'INT(255) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'title' => 'VARCHAR(100) NOT NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_cms_indicator', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_cms_indicator}}', [
        'id' => 'INT(255) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'category_id' => 'INT(255) NOT NULL',
        'title' => 'TEXT NOT NULL',
        'type_id' => 'INT(255) NULL',
        'frequency_id' => 'INT(255) NULL',
        'unit_id' => 'INT(255) NULL',
        'default_choice_id' => 'INT(255) NULL',
        'parent' => 'INT(255) NOT NULL',
        'in_chart' => 'INT(11) NULL',
        'sort' => 'DOUBLE NULL',
        'is_required' => 'INT(11) NULL DEFAULT \'1\'',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_cms_sub_question', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_cms_sub_question}}', [
        'id' => 'INT(255) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'indicator_id' => 'INT(255) NULL',
        'sub_question' => 'VARCHAR(1000) NOT NULL',
        'type' => 'INT(255) NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_cms_type', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_cms_type}}', [
        'id' => 'INT(255) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'title' => 'VARCHAR(50) NOT NULL',
    ], $tableOptions_mysql);
}
}
 
/* MYSQL */
if (!in_array('gad_cms_unit', $tables))  { 
if ($dbType == "mysql") {
    $this->createTable('{{%gad_cms_unit}}', [
        'id' => 'INT(255) NOT NULL AUTO_INCREMENT',
        0 => 'PRIMARY KEY (`id`)',
        'title' => 'VARCHAR(50) NOT NULL',
    ], $tableOptions_mysql);
}
}
 
 
$this->createIndex('idx_frequency_id_8075_00','gad_cms_category','frequency_id',0);
$this->createIndex('idx_indicator_id_8171_01','gad_cms_choice_with_subquestion','indicator_id',0);
$this->createIndex('idx_frequency_id_8488_02','gad_cms_frequency_details','frequency_id',0);
$this->createIndex('idx_default_choice_id_8559_03','gad_cms_ind_choices','default_choice_id',0);
$this->createIndex('idx_indicator_id_856_04','gad_cms_ind_choices','indicator_id',0);
$this->createIndex('idx_category_id_8711_05','gad_cms_indicator','category_id',0);
$this->createIndex('idx_frequency_id_8712_06','gad_cms_indicator','frequency_id',0);
$this->createIndex('idx_type_id_8712_07','gad_cms_indicator','type_id',0);
$this->createIndex('idx_unit_id_8712_08','gad_cms_indicator','unit_id',0);
$this->createIndex('idx_indicator_id_8786_09','gad_cms_sub_question','indicator_id',0);
$this->createIndex('idx_type_8786_10','gad_cms_sub_question','type',0);
 
$this->execute('SET foreign_key_checks = 0');
$this->insert('{{%gad_cms_category}}',['id'=>'7','title'=>'General Observations and Recommendations (DILG)','frequency'=>'','frequency_id'=>'','lgup_content_type_id'=>'1','lgup_content_width_id'=>'','applicable_to'=>'0','left_or_right'=>'0','sort'=>'','add_comment'=>'0']);
$this->insert('{{%gad_cms_category}}',['id'=>'8','title'=>'Letter of Review and Endorsement from Provincial Planning and Development Coordinating Office','frequency'=>'','frequency_id'=>'','lgup_content_type_id'=>'1','lgup_content_width_id'=>'','applicable_to'=>'0','left_or_right'=>'0','sort'=>'','add_comment'=>'0']);
$this->insert('{{%gad_cms_category}}',['id'=>'9','title'=>'Certificate of Review and Endorsement from DILG Region/Province','frequency'=>'','frequency_id'=>'','lgup_content_type_id'=>'1','lgup_content_width_id'=>'','applicable_to'=>'0','left_or_right'=>'0','sort'=>'','add_comment'=>'0']);
$this->insert('{{%gad_cms_category}}',['id'=>'10','title'=>'Letter of Deficiencies and GPB Review Form (General Observations and Recommendations)','frequency'=>'','frequency_id'=>'','lgup_content_type_id'=>'1','lgup_content_width_id'=>'','applicable_to'=>'0','left_or_right'=>'0','sort'=>'','add_comment'=>'0']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'1','indicator_id'=>'1','answer'=>'others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'2','indicator_id'=>'2','answer'=>'others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'3','indicator_id'=>'3','answer'=>'others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'4','indicator_id'=>'4','answer'=>'others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'5','indicator_id'=>'5','answer'=>'others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'6','indicator_id'=>'7','answer'=>'others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'7','indicator_id'=>'10','answer'=>'others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'8','indicator_id'=>'11','answer'=>'others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'9','indicator_id'=>'12','answer'=>'others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'10','indicator_id'=>'13','answer'=>'others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'11','indicator_id'=>'16','answer'=>'others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'12','indicator_id'=>'19','answer'=>'Others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'13','indicator_id'=>'20','answer'=>'Others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'14','indicator_id'=>'21','answer'=>'Others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'15','indicator_id'=>'22','answer'=>'Others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'16','indicator_id'=>'24','answer'=>'Others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'17','indicator_id'=>'27','answer'=>'Others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'18','indicator_id'=>'28','answer'=>'Others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'19','indicator_id'=>'29','answer'=>'Others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'20','indicator_id'=>'30','answer'=>'Others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'21','indicator_id'=>'32','answer'=>'Others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'24','indicator_id'=>'41','answer'=>'Others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'25','indicator_id'=>'43','answer'=>'Others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'26','indicator_id'=>'45','answer'=>'Others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'27','indicator_id'=>'50','answer'=>'Others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'28','indicator_id'=>'52','answer'=>'Others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'29','indicator_id'=>'54','answer'=>'Others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'30','indicator_id'=>'64','answer'=>'YES']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'31','indicator_id'=>'77','answer'=>'YES']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'32','indicator_id'=>'101','answer'=>'others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'33','indicator_id'=>'103','answer'=>'others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'34','indicator_id'=>'105','answer'=>'Others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'36','indicator_id'=>'111','answer'=>'Others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'37','indicator_id'=>'113','answer'=>'Others']);
$this->insert('{{%gad_cms_choice_with_subquestion}}',['id'=>'38','indicator_id'=>'115','answer'=>'Others']);
$this->insert('{{%gad_cms_content_type}}',['id'=>'1','type'=>'Detailed View','description'=>'Detailed LGU Information']);
$this->insert('{{%gad_cms_content_type}}',['id'=>'2','type'=>'Grid View','description'=>'']);
$this->insert('{{%gad_cms_content_type}}',['id'=>'4','type'=>'Image','description'=>'']);
$this->insert('{{%gad_cms_content_type}}',['id'=>'5','type'=>'Slide Images','description'=>'']);
$this->insert('{{%gad_cms_content_type}}',['id'=>'6','type'=>'PDF Preview','description'=>'']);
$this->insert('{{%gad_cms_content_type}}',['id'=>'7','type'=>'Map','description'=>'']);
$this->insert('{{%gad_cms_content_type}}',['id'=>'8','type'=>'Pie Chart','description'=>'']);
$this->insert('{{%gad_cms_content_type}}',['id'=>'9','type'=>'Bar Graph','description'=>'']);
$this->insert('{{%gad_cms_content_type}}',['id'=>'10','type'=>'Line Graph','description'=>'']);
$this->insert('{{%gad_cms_content_type}}',['id'=>'11','type'=>'Downloadables','description'=>'']);
$this->insert('{{%gad_cms_content_type}}',['id'=>'12','type'=>'List of Links','description'=>'']);
$this->insert('{{%gad_cms_content_width}}',['id'=>'1','class_name'=>'col-sm-12','description'=>'column for small devices 100%']);
$this->insert('{{%gad_cms_content_width}}',['id'=>'2','class_name'=>'col-md-12','description'=>'column for medium devices 100%']);
$this->insert('{{%gad_cms_content_width}}',['id'=>'3','class_name'=>'col-lg-12','description'=>'column for large devices 100%']);
$this->insert('{{%gad_cms_frequency}}',['id'=>'1','title'=>'Term','count'=>'0']);
$this->insert('{{%gad_cms_frequency}}',['id'=>'2','title'=>'Annually','count'=>'1']);
$this->insert('{{%gad_cms_frequency}}',['id'=>'3','title'=>'Semi-annually','count'=>'2']);
$this->insert('{{%gad_cms_frequency}}',['id'=>'4','title'=>'Quarterly','count'=>'4']);
$this->insert('{{%gad_cms_frequency}}',['id'=>'5','title'=>'Monthly','count'=>'12']);
$this->insert('{{%gad_cms_frequency}}',['id'=>'6','title'=>'Weekly','count'=>'0']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'1','frequency_id'=>'1','details'=>'Term']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'2','frequency_id'=>'2','details'=>'Year']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'3','frequency_id'=>'3','details'=>'First Semester']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'4','frequency_id'=>'3','details'=>'Second Semester']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'5','frequency_id'=>'4','details'=>'First Quarter']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'6','frequency_id'=>'4','details'=>'Second Quarter']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'7','frequency_id'=>'4','details'=>'Third Quarter']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'8','frequency_id'=>'4','details'=>'Fourth Quarter']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'9','frequency_id'=>'5','details'=>'January']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'10','frequency_id'=>'5','details'=>'February']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'11','frequency_id'=>'5','details'=>'March']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'12','frequency_id'=>'5','details'=>'April']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'13','frequency_id'=>'5','details'=>'May']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'14','frequency_id'=>'5','details'=>'June']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'15','frequency_id'=>'5','details'=>'July']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'16','frequency_id'=>'5','details'=>'August']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'17','frequency_id'=>'5','details'=>'September']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'18','frequency_id'=>'5','details'=>'October']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'19','frequency_id'=>'5','details'=>'November']);
$this->insert('{{%gad_cms_frequency_details}}',['id'=>'20','frequency_id'=>'5','details'=>'December']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'201','indicator_id'=>'162','default_choice_id'=>'','value'=>'Regional Director']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'202','indicator_id'=>'162','default_choice_id'=>'','value'=>'Provincial Director']);
$this->insert('{{%gad_cms_ind_default_choices}}',['id'=>'1','title'=>'OTHERS']);
$this->insert('{{%gad_cms_ind_default_choices}}',['id'=>'2','title'=>'YES/NO']);
$this->insert('{{%gad_cms_ind_default_choices}}',['id'=>'3','title'=>'PRESENCE/ABSENCE']);
$this->insert('{{%gad_cms_ind_default_choices}}',['id'=>'4','title'=>'POSTED/NOT POSTED']);
$this->insert('{{%gad_cms_ind_default_choices}}',['id'=>'5','title'=>'ON-GOING/COMPLETED']);
$this->insert('{{%gad_cms_ind_default_choices}}',['id'=>'6','title'=>'1/0']);
$this->insert('{{%gad_cms_indicator}}',['id'=>'156','category_id'=>'7','title'=>'Date: _____________','type_id'=>'2','frequency_id'=>'','unit_id'=>'6','default_choice_id'=>'','parent'=>'0','in_chart'=>'','sort'=>'1','is_required'=>'2']);
$this->insert('{{%gad_cms_indicator}}',['id'=>'157','category_id'=>'7','title'=>'Dear _______________,','type_id'=>'2','frequency_id'=>'','unit_id'=>'6','default_choice_id'=>'','parent'=>'0','in_chart'=>'','sort'=>'3','is_required'=>'2']);
$this->insert('{{%gad_cms_indicator}}',['id'=>'158','category_id'=>'7','title'=>'Address of LGU','type_id'=>'2','frequency_id'=>'','unit_id'=>'6','default_choice_id'=>'','parent'=>'0','in_chart'=>'','sort'=>'2','is_required'=>'2']);
$this->insert('{{%gad_cms_indicator}}',['id'=>'159','category_id'=>'7','title'=>'This Office acknowledges receipt of the GAD Plan and Budget (GPB) FY ______ of your LGU. We, however, defer endorsement of the same due to the following general observations and recommendations and enclosed/attached specific observations and recommendations:','type_id'=>'2','frequency_id'=>'','unit_id'=>'2','default_choice_id'=>'','parent'=>'0','in_chart'=>'','sort'=>'','is_required'=>'2']);
$this->insert('{{%gad_cms_indicator}}',['id'=>'161','category_id'=>'7','title'=>'Very truly yours,','type_id'=>'2','frequency_id'=>'','unit_id'=>'6','default_choice_id'=>'','parent'=>'0','in_chart'=>'','sort'=>'','is_required'=>'2']);
$this->insert('{{%gad_cms_indicator}}',['id'=>'162','category_id'=>'7','title'=>'Signatory Title','type_id'=>'2','frequency_id'=>'','unit_id'=>'7','default_choice_id'=>'1','parent'=>'0','in_chart'=>'','sort'=>'','is_required'=>'2']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'1','indicator_id'=>'1','sub_question'=>'Please specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'2','indicator_id'=>'2','sub_question'=>'Please specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'3','indicator_id'=>'3','sub_question'=>'Please specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'4','indicator_id'=>'4','sub_question'=>'Please specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'5','indicator_id'=>'5','sub_question'=>'Please specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'6','indicator_id'=>'7','sub_question'=>'Please specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'7','indicator_id'=>'10','sub_question'=>'Please specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'8','indicator_id'=>'11','sub_question'=>'Please specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'9','indicator_id'=>'12','sub_question'=>'Please specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'10','indicator_id'=>'13','sub_question'=>'Please specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'11','indicator_id'=>'16','sub_question'=>'Please specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'12','indicator_id'=>'19','sub_question'=>'Please Specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'13','indicator_id'=>'20','sub_question'=>'Please Specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'14','indicator_id'=>'21','sub_question'=>'Please Specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'15','indicator_id'=>'22','sub_question'=>'Please Specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'16','indicator_id'=>'24','sub_question'=>'Please Specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'17','indicator_id'=>'27','sub_question'=>'Please Specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'18','indicator_id'=>'28','sub_question'=>'Please Specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'19','indicator_id'=>'29','sub_question'=>'Please Specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'20','indicator_id'=>'30','sub_question'=>'Please Specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'21','indicator_id'=>'32','sub_question'=>'Please Specify','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'24','indicator_id'=>'41','sub_question'=>'Please Specify','type'=>'2']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'25','indicator_id'=>'43','sub_question'=>'Please Specify','type'=>'2']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'26','indicator_id'=>'45','sub_question'=>'Please Specify','type'=>'2']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'27','indicator_id'=>'50','sub_question'=>'Please Specify','type'=>'2']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'28','indicator_id'=>'52','sub_question'=>'Please Specify','type'=>'2']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'29','indicator_id'=>'54','sub_question'=>'Please Specify','type'=>'2']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'30','indicator_id'=>'64','sub_question'=>'Agencies involved','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'31','indicator_id'=>'77','sub_question'=>'Agencies involved','type'=>'6']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'32','indicator_id'=>'101','sub_question'=>'Please Specify','type'=>'2']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'33','indicator_id'=>'103','sub_question'=>'Please Specify','type'=>'2']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'34','indicator_id'=>'105','sub_question'=>'Please Specify','type'=>'2']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'36','indicator_id'=>'111','sub_question'=>'Please Specify','type'=>'2']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'37','indicator_id'=>'113','sub_question'=>'Please Specify','type'=>'2']);
$this->insert('{{%gad_cms_sub_question}}',['id'=>'38','indicator_id'=>'115','sub_question'=>'Please Specify','type'=>'2']);
$this->insert('{{%gad_cms_type}}',['id'=>'1','title'=>'title']);
$this->insert('{{%gad_cms_type}}',['id'=>'2','title'=>'question']);
$this->insert('{{%gad_cms_type}}',['id'=>'3','title'=>'second-level-title']);
$this->insert('{{%gad_cms_type}}',['id'=>'4','title'=>'third-level-title']);
$this->insert('{{%gad_cms_type}}',['id'=>'5','title'=>'question-main-title']);
$this->insert('{{%gad_cms_type}}',['id'=>'6','title'=>'question-second-level-title']);
$this->insert('{{%gad_cms_type}}',['id'=>'7','title'=>'question-third-level-title']);
$this->insert('{{%gad_cms_unit}}',['id'=>'1','title'=>'NONE']);
$this->insert('{{%gad_cms_unit}}',['id'=>'2','title'=>'NUMERICAL']);
$this->insert('{{%gad_cms_unit}}',['id'=>'3','title'=>'AMOUNT']);
$this->insert('{{%gad_cms_unit}}',['id'=>'4','title'=>'YEAR']);
$this->insert('{{%gad_cms_unit}}',['id'=>'5','title'=>'DATE']);
$this->insert('{{%gad_cms_unit}}',['id'=>'6','title'=>'TEXT']);
$this->insert('{{%gad_cms_unit}}',['id'=>'7','title'=>'DROPDOWN']);
$this->insert('{{%gad_cms_unit}}',['id'=>'8','title'=>'NUMERICAL (WITH DECIMAL)']);
$this->insert('{{%gad_cms_unit}}',['id'=>'9','title'=>'TEXTAREA']);
$this->insert('{{%gad_cms_unit}}',['id'=>'10','title'=>'FILE ATTACHMENT']);
$this->insert('{{%gad_cms_unit}}',['id'=>'11','title'=>'CHECKBOX']);
$this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190817_091927_gad_cms_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190817_091927_gad_cms_tables cannot be reverted.\n";

        return false;
    }
    */
}
