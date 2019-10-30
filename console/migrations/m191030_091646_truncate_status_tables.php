<?php

use yii\db\Migration;

/**
 * Class m191030_091646_truncate_status_tables
 */
class m191030_091646_truncate_status_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
    Yii::$app->db->createCommand()->truncateTable('gad_status')->execute();  
    Yii::$app->db->createCommand()->truncateTable('gad_status_assignment')->execute();  
 
 
$this->execute('SET foreign_key_checks = 0');
$this->insert('{{%gad_status}}',['id'=>'1','code'=>'0','title'=>'Encoding process (non-huc/icc lgu)']);
$this->insert('{{%gad_status}}',['id'=>'2','code'=>'1','title'=>'For review (by ppdo)']);
$this->insert('{{%gad_status}}',['id'=>'3','code'=>'2','title'=>'Submitted to DILG Provincial Office (by ppdo)']);
$this->insert('{{%gad_status}}',['id'=>'4','code'=>'4','title'=>'Endorsed By DILG (provincial office)']);
$this->insert('{{%gad_status}}',['id'=>'5','code'=>'5','title'=>'Returned to PPDO (by dilg province)']);
$this->insert('{{%gad_status}}',['id'=>'6','code'=>'3','title'=>'Submitted to DILG Region (by huc/icc lgu)']);
$this->insert('{{%gad_status}}',['id'=>'7','code'=>'6','title'=>'Returned to LGU (by dilg region)']);
$this->insert('{{%gad_status}}',['id'=>'8','code'=>'7','title'=>'Returned to LGU (by ppdo)']);
$this->insert('{{%gad_status}}',['id'=>'9','code'=>'8','title'=>'Encoding process (huc/icc)']);
$this->insert('{{%gad_status}}',['id'=>'10','code'=>'9','title'=>'Encoding process (province lgu)']);
$this->insert('{{%gad_status}}',['id'=>'11','code'=>'10','title'=>'Endorsed by DILG (regional office)']);
$this->insert('{{%gad_status}}',['id'=>'12','code'=>'11','title'=>'Pending submission to Regional Office (by lgu)']);
$this->insert('{{%gad_status}}',['id'=>'13','code'=>'12','title'=>'Pending submission to PPDO (by lgu)']);
$this->insert('{{%gad_status}}',['id'=>'14','code'=>'13','title'=>'Pending submission to Provincial Office (by ppdo)']);
$this->insert('{{%gad_status}}',['id'=>'15','code'=>'14','title'=>'Pending endorsement of LGU (by dilg region)']);
$this->insert('{{%gad_status}}',['id'=>'16','code'=>'15','title'=>'Pending endorsement of LGU (by dilg province)']);
$this->insert('{{%gad_status}}',['id'=>'17','code'=>'16','title'=>'Returned to LGU (by dilg province)']);
$this->insert('{{%gad_status}}',['id'=>'18','code'=>'17','title'=>'Submitted to DILG Province (by lgu) (revised)']);
$this->insert('{{%gad_status}}',['id'=>'19','code'=>'18','title'=>'Submitted to DILG Region (by lgu province) (revised)']);
$this->insert('{{%gad_status}}',['id'=>'20','code'=>'19','title'=>'For review by PPDO (revised)']);
$this->insert('{{%gad_status}}',['id'=>'21','code'=>'20','title'=>'Pending submission to PPDO (by lgu) (revised)']);
$this->insert('{{%gad_status}}',['id'=>'22','code'=>'21','title'=>'Pending submission to DILG Region (by lgu) (revised)']);
$this->insert('{{%gad_status}}',['id'=>'23','code'=>'22','title'=>'Pending submission to DILG Province (by lgu) (revised)']);
$this->insert('{{%gad_status}}',['id'=>'24','code'=>'23','title'=>'Returned to LGU CC/M (for archiving)']);
$this->insert('{{%gad_status}}',['id'=>'25','code'=>'24','title'=>'Returned to LGU Province (for archiving)']);
$this->insert('{{%gad_status}}',['id'=>'26','code'=>'25','title'=>'Returned to LGU HUC/ICC (for archiving)']);
$this->insert('{{%gad_status_assignment}}',['id'=>'1','role'=>'gad_region_dilg','status'=>'3,6,8,9,10,14,18']);
$this->insert('{{%gad_status_assignment}}',['id'=>'2','role'=>'gad_ppdo','status'=>'0,1,2,4,5,7,15,16,17,19']);
$this->insert('{{%gad_status_assignment}}',['id'=>'3','role'=>'gad_province_dilg','status'=>'0,1,2,4,5,7,15,16,17,19']);
$this->insert('{{%gad_status_assignment}}',['id'=>'4','role'=>'gad_lgu_non_huc','status'=>'0,1,2,4,5,7,15,16,17,19']);
$this->insert('{{%gad_status_assignment}}',['id'=>'5','role'=>'gad_lgu_huc','status'=>'3,6,8,10,14,18']);
$this->insert('{{%gad_status_assignment}}',['id'=>'6','role'=>'gad_province_lgu','status'=>'3,6,9,10,14,18']);
$this->insert('{{%gad_status_assignment}}',['id'=>'7','role'=>'gad_all_status','status'=>'0,1,2,4,5,3,6,7,8,9,10,14,15,16,17,18,19,23,24,25']);
$this->insert('{{%gad_status_assignment}}',['id'=>'8','role'=>'gad_field_huc','status'=>'3,6,8,10,11,14,18,21']);
$this->insert('{{%gad_status_assignment}}',['id'=>'9','role'=>'gad_field_non_huc','status'=>'0,1,2,4,5,7,12,13,15,16,17,19,20,22']);
$this->insert('{{%gad_status_assignment}}',['id'=>'10','role'=>'delete_report_for_lgu','status'=>'0,7,16']);
$this->insert('{{%gad_status_assignment}}',['id'=>'11','role'=>'archive_report_for_lgu','status'=>'0,7,16,23']);
$this->insert('{{%gad_status_assignment}}',['id'=>'12','role'=>'delete_report_for_huc','status'=>'6,8,25']);
$this->insert('{{%gad_status_assignment}}',['id'=>'13','role'=>'delete_report_for_lgu_province','status'=>'6,9,24']);
$this->insert('{{%gad_status_assignment}}',['id'=>'14','role'=>'archive_report_for_huc','status'=>'6,8,25']);
$this->insert('{{%gad_status_assignment}}',['id'=>'15','role'=>'archive_report_for_lgu_province','status'=>'6,9,24']);
$this->insert('{{%gad_status_assignment}}',['id'=>'16','role'=>'modify_report_lgu','status'=>'0,7,16,23']);
$this->insert('{{%gad_status_assignment}}',['id'=>'17','role'=>'modify_report_huc','status'=>'6,8,25']);
$this->insert('{{%gad_status_assignment}}',['id'=>'18','role'=>'modify_report_lgu_province','status'=>'6,9,24']);
$this->insert('{{%gad_status_assignment}}',['id'=>'19','role'=>'view_report_for_region','status'=>'3,6,10,14,18,24,25']);
$this->insert('{{%gad_status_assignment}}',['id'=>'20','role'=>'view_report_for_ppdo','status'=>'1,2,4,5,7,16,23']);
$this->insert('{{%gad_status_assignment}}',['id'=>'21','role'=>'view_report_for_province','status'=>'2,4,5,16']);
$this->insert('{{%gad_status_assignment}}',['id'=>'22','role'=>'archive_report_for_region','status'=>'3,10,18']);
$this->insert('{{%gad_status_assignment}}',['id'=>'23','role'=>'archive_report_for_ppdo','status'=>'1']);
$this->insert('{{%gad_status_assignment}}',['id'=>'24','role'=>'archive_report_for_province','status'=>'2,4,17']);
$this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191030_091646_truncate_status_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191030_091646_truncate_status_tables cannot be reverted.\n";

        return false;
    }
    */
}
