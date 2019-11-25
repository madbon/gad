<?php

use yii\db\Migration;

/**
 * Class m191119_032042_gad_cms_table_changes
 */
class m191119_032042_gad_cms_table_changes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
 
Yii::$app->db->createCommand()->truncateTable('gad_cms_indicator')->execute();   
Yii::$app->db->createCommand()->truncateTable('gad_cms_category')->execute();
Yii::$app->db->createCommand()->truncateTable('gad_cms_ind_choices')->execute();
 
$this->execute('SET foreign_key_checks = 0');
$this->insert('{{%gad_cms_category}}',['id'=>'7','title'=>'General Observations and Recommendations (Letter of Deficiencies and GPB Review Form)','frequency'=>'','frequency_id'=>'','lgup_content_type_id'=>'1','lgup_content_width_id'=>'','applicable_to'=>'0','left_or_right'=>'0','sort'=>'','add_comment'=>'0']);
$this->insert('{{%gad_cms_category}}',['id'=>'8','title'=>'Letter of Review and Endorsement from Provincial Planning and Development Coordinating Office (PPDO)','frequency'=>'','frequency_id'=>'','lgup_content_type_id'=>'1','lgup_content_width_id'=>'','applicable_to'=>'0','left_or_right'=>'0','sort'=>'','add_comment'=>'0']);
$this->insert('{{%gad_cms_category}}',['id'=>'9','title'=>'Certificate of Review and Endorsement from DILG Region/Province','frequency'=>'','frequency_id'=>'','lgup_content_type_id'=>'1','lgup_content_width_id'=>'','applicable_to'=>'0','left_or_right'=>'0','sort'=>'','add_comment'=>'0']);
$this->insert('{{%gad_cms_category}}',['id'=>'10','title'=>'Project Implementation and Management, and Monitoring and Evaluation','frequency'=>'','frequency_id'=>'','lgup_content_type_id'=>'1','lgup_content_width_id'=>'','applicable_to'=>'0','left_or_right'=>'0','sort'=>'','add_comment'=>'0']);
$this->insert('{{%gad_cms_indicator}}',['id'=>'156','category_id'=>'7','title'=>'Date: _____________','type_id'=>'2','frequency_id'=>'','unit_id'=>'6','default_choice_id'=>'','parent'=>'0','in_chart'=>'','sort'=>'1','is_required'=>'2']);
$this->insert('{{%gad_cms_indicator}}',['id'=>'161','category_id'=>'7','title'=>'Very truly yours,','type_id'=>'2','frequency_id'=>'','unit_id'=>'6','default_choice_id'=>'','parent'=>'0','in_chart'=>'','sort'=>'5','is_required'=>'2']);
$this->insert('{{%gad_cms_indicator}}',['id'=>'162','category_id'=>'7','title'=>'Signatory Title','type_id'=>'2','frequency_id'=>'','unit_id'=>'7','default_choice_id'=>'1','parent'=>'0','in_chart'=>'','sort'=>'6','is_required'=>'2']);
$this->insert('{{%gad_cms_indicator}}',['id'=>'163','category_id'=>'8','title'=>'Date','type_id'=>'2','frequency_id'=>'','unit_id'=>'6','default_choice_id'=>'','parent'=>'0','in_chart'=>'','sort'=>'1','is_required'=>'2']);
$this->insert('{{%gad_cms_indicator}}',['id'=>'164','category_id'=>'8','title'=>'Name of the Provincial Director','type_id'=>'2','frequency_id'=>'','unit_id'=>'6','default_choice_id'=>'','parent'=>'0','in_chart'=>'','sort'=>'2','is_required'=>'2']);
$this->insert('{{%gad_cms_indicator}}',['id'=>'174','category_id'=>'9','title'=>'day of ___________, ','type_id'=>'2','frequency_id'=>'','unit_id'=>'7','default_choice_id'=>'1','parent'=>'0','in_chart'=>'','sort'=>'6','is_required'=>'2']);
$this->insert('{{%gad_cms_indicator}}',['id'=>'176','category_id'=>'9','title'=>'at the Office of the ______________','type_id'=>'2','frequency_id'=>'','unit_id'=>'6','default_choice_id'=>'','parent'=>'0','in_chart'=>'','sort'=>'8','is_required'=>'2']);
$this->insert('{{%gad_cms_indicator}}',['id'=>'177','category_id'=>'9','title'=>'Signed by:','type_id'=>'2','frequency_id'=>'','unit_id'=>'6','default_choice_id'=>'','parent'=>'0','in_chart'=>'','sort'=>'9','is_required'=>'2']);
$this->insert('{{%gad_cms_indicator}}',['id'=>'178','category_id'=>'9','title'=>'Designation','type_id'=>'2','frequency_id'=>'','unit_id'=>'7','default_choice_id'=>'1','parent'=>'0','in_chart'=>'','sort'=>'10','is_required'=>'2']);
$this->insert('{{%gad_cms_indicator}}',['id'=>'180','category_id'=>'7','title'=>'Mayor/Governor','type_id'=>'2','frequency_id'=>'','unit_id'=>'7','default_choice_id'=>'1','parent'=>'0','in_chart'=>'','sort'=>'3','is_required'=>'2']);
$this->insert('{{%gad_cms_indicator}}',['id'=>'181','category_id'=>'9','title'=>'Issued this _____________','type_id'=>'2','frequency_id'=>'','unit_id'=>'7','default_choice_id'=>'1','parent'=>'0','in_chart'=>'','sort'=>'5','is_required'=>'2']);
$this->insert('{{%gad_cms_indicator}}',['id'=>'182','category_id'=>'8','title'=>'Name of PPDO','type_id'=>'2','frequency_id'=>'','unit_id'=>'6','default_choice_id'=>'','parent'=>'0','in_chart'=>'','sort'=>'3','is_required'=>'2']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'201','indicator_id'=>'162','default_choice_id'=>'','value'=>'Regional Director']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'202','indicator_id'=>'162','default_choice_id'=>'','value'=>'Provincial Director']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'203','indicator_id'=>'178','default_choice_id'=>'','value'=>'Regional Director']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'204','indicator_id'=>'178','default_choice_id'=>'','value'=>'Provincial Director']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'205','indicator_id'=>'174','default_choice_id'=>'','value'=>'January']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'206','indicator_id'=>'174','default_choice_id'=>'','value'=>'February']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'207','indicator_id'=>'174','default_choice_id'=>'','value'=>'March']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'208','indicator_id'=>'174','default_choice_id'=>'','value'=>'April']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'209','indicator_id'=>'174','default_choice_id'=>'','value'=>'May']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'210','indicator_id'=>'174','default_choice_id'=>'','value'=>'June']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'211','indicator_id'=>'174','default_choice_id'=>'','value'=>'July']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'212','indicator_id'=>'174','default_choice_id'=>'','value'=>'August']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'213','indicator_id'=>'174','default_choice_id'=>'','value'=>'September']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'214','indicator_id'=>'174','default_choice_id'=>'','value'=>'October']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'215','indicator_id'=>'174','default_choice_id'=>'','value'=>'November']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'216','indicator_id'=>'174','default_choice_id'=>'','value'=>'December']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'217','indicator_id'=>'180','default_choice_id'=>'','value'=>'Mayor']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'218','indicator_id'=>'180','default_choice_id'=>'','value'=>'Governor']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'219','indicator_id'=>'181','default_choice_id'=>'','value'=>'1st']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'220','indicator_id'=>'181','default_choice_id'=>'','value'=>'2nd']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'221','indicator_id'=>'181','default_choice_id'=>'','value'=>'3rd']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'222','indicator_id'=>'181','default_choice_id'=>'','value'=>'4th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'223','indicator_id'=>'181','default_choice_id'=>'','value'=>'5th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'224','indicator_id'=>'181','default_choice_id'=>'','value'=>'6th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'225','indicator_id'=>'181','default_choice_id'=>'','value'=>'7th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'226','indicator_id'=>'181','default_choice_id'=>'','value'=>'8th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'227','indicator_id'=>'181','default_choice_id'=>'','value'=>'9th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'228','indicator_id'=>'181','default_choice_id'=>'','value'=>'10th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'229','indicator_id'=>'181','default_choice_id'=>'','value'=>'11th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'230','indicator_id'=>'181','default_choice_id'=>'','value'=>'12th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'231','indicator_id'=>'181','default_choice_id'=>'','value'=>'13th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'232','indicator_id'=>'181','default_choice_id'=>'','value'=>'14th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'233','indicator_id'=>'181','default_choice_id'=>'','value'=>'15th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'234','indicator_id'=>'181','default_choice_id'=>'','value'=>'16th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'235','indicator_id'=>'181','default_choice_id'=>'','value'=>'17th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'236','indicator_id'=>'181','default_choice_id'=>'','value'=>'18th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'237','indicator_id'=>'181','default_choice_id'=>'','value'=>'19th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'238','indicator_id'=>'181','default_choice_id'=>'','value'=>'20th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'239','indicator_id'=>'181','default_choice_id'=>'','value'=>'21st']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'240','indicator_id'=>'181','default_choice_id'=>'','value'=>'22nd']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'241','indicator_id'=>'181','default_choice_id'=>'','value'=>'23rd']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'242','indicator_id'=>'181','default_choice_id'=>'','value'=>'24th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'243','indicator_id'=>'181','default_choice_id'=>'','value'=>'25th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'244','indicator_id'=>'181','default_choice_id'=>'','value'=>'26th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'245','indicator_id'=>'181','default_choice_id'=>'','value'=>'27th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'246','indicator_id'=>'181','default_choice_id'=>'','value'=>'28th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'247','indicator_id'=>'181','default_choice_id'=>'','value'=>'29th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'248','indicator_id'=>'181','default_choice_id'=>'','value'=>'30th']);
$this->insert('{{%gad_cms_ind_choices}}',['id'=>'249','indicator_id'=>'181','default_choice_id'=>'','value'=>'31st']);
$this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191119_032042_gad_cms_table_changes cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191119_032042_gad_cms_table_changes cannot be reverted.\n";

        return false;
    }
    */
}
