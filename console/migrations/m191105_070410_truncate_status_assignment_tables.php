<?php

use yii\db\Migration;

/**
 * Class m191105_070410_truncate_status_assignment_tables
 */
class m191105_070410_truncate_status_assignment_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('gad_status_assignment', 'rbac_role', 'VARCHAR(150) NULL AFTER `role` ');
        $this->addColumn('gad_status_assignment', 'status_code', 'INT(11) NULL AFTER `rbac_role` ');
        $this->addColumn('gad_status', 'class', 'VARCHAR(250) NULL AFTER `future_tense` ');

        Yii::$app->db->createCommand()->truncateTable('gad_status')->execute();  
        Yii::$app->db->createCommand()->truncateTable('gad_status_assignment')->execute();   
 
        $this->execute('SET foreign_key_checks = 0');
$this->insert('{{%gad_status}}',['id'=>'1','code'=>'0','title'=>'Encoding process (non-huc/icc lgu)','future_tense'=>'','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'2','code'=>'1','title'=>'For review (by ppdo)','future_tense'=>'Submit to PPDO','class'=>'label label-success']);
$this->insert('{{%gad_status}}',['id'=>'3','code'=>'2','title'=>'Submitted to DILG Province (by ppdo)','future_tense'=>'Submit to DILG Provincial Office','class'=>'label label-info']);
$this->insert('{{%gad_status}}',['id'=>'4','code'=>'4','title'=>'Endorsed By DILG Province','future_tense'=>'Endorse LGU CC/M','class'=>'label label-primary']);
$this->insert('{{%gad_status}}',['id'=>'5','code'=>'5','title'=>'Returned to PPDO (by dilg province)','future_tense'=>'Return to PPDO','class'=>'label label-danger']);
$this->insert('{{%gad_status}}',['id'=>'6','code'=>'3','title'=>'Submitted to DILG Region (by huc/icc lgu)','future_tense'=>'Submit to DILG Region','class'=>'label label-info']);
$this->insert('{{%gad_status}}',['id'=>'7','code'=>'6','title'=>'Returned to LGU HUC/ICC (by dilg region)','future_tense'=>'Return to LGU HUC/ICC','class'=>'label label-danger']);
$this->insert('{{%gad_status}}',['id'=>'8','code'=>'7','title'=>'Returned to LGU (by ppdo)','future_tense'=>'Return to LGU CC/M','class'=>'label label-danger']);
$this->insert('{{%gad_status}}',['id'=>'9','code'=>'8','title'=>'Encoding process (huc/icc)','future_tense'=>'','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'10','code'=>'9','title'=>'Encoding process (province lgu)','future_tense'=>'','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'11','code'=>'10','title'=>'LGU HUC/ICC Endorsed by DILG Region','future_tense'=>'Endorse LGU HUC/ICC','class'=>'label label-primary']);
$this->insert('{{%gad_status}}',['id'=>'12','code'=>'11','title'=>'Pending submission to Regional Office (by lgu)','future_tense'=>'Cancel Endorsement of LGU','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'13','code'=>'12','title'=>'Pending submission to PPDO (by lgu)','future_tense'=>'','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'14','code'=>'13','title'=>'Pending submission to Provincial Office (by ppdo)','future_tense'=>'','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'15','code'=>'14','title'=>'Pending endorsement of LGU HUC/ICC (by dilg region)','future_tense'=>'Cancel Endorsement of LGU HUC/ICC','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'16','code'=>'15','title'=>'Pending endorsement of LGU CC/M (by dilg province)','future_tense'=>'Cancel Endorsement of LGU CC/M','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'17','code'=>'16','title'=>'Returned to LGU (by dilg province)','future_tense'=>'Return to LGU CC/M','class'=>'label label-danger']);
$this->insert('{{%gad_status}}',['id'=>'18','code'=>'17','title'=>'Submitted to DILG Province (by lgu) (revised)','future_tense'=>'Submit to DILG Province (revised)','class'=>'label label-info']);
$this->insert('{{%gad_status}}',['id'=>'19','code'=>'18','title'=>'Submitted to DILG Region (by lgu province) (revised)','future_tense'=>'Submit to DILG Region (revised)','class'=>'label label-info']);
$this->insert('{{%gad_status}}',['id'=>'20','code'=>'19','title'=>'For review by PPDO (revised)','future_tense'=>'Submit to PPDO (revised)','class'=>'label label-success']);
$this->insert('{{%gad_status}}',['id'=>'21','code'=>'20','title'=>'Pending submission to PPDO (by lgu) (revised)','future_tense'=>'','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'22','code'=>'21','title'=>'Pending submission to DILG Region (by lgu) (revised)','future_tense'=>'','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'23','code'=>'22','title'=>'Pending submission to DILG Province (by lgu) (revised)','future_tense'=>'','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'24','code'=>'23','title'=>'Returned to LGU CC/M (for archiving)','future_tense'=>'Return to LGU (for archiving)','class'=>'label label-danger']);
$this->insert('{{%gad_status}}',['id'=>'25','code'=>'24','title'=>'Returned to LGU Province (for archiving)','future_tense'=>'Return to LGU Province (for archiving)','class'=>'label label-danger']);
$this->insert('{{%gad_status}}',['id'=>'26','code'=>'25','title'=>'Returned to LGU HUC/ICC (for archiving)','future_tense'=>'Return to LGU HUC/ICC (for archiving)','class'=>'label label-danger']);
$this->insert('{{%gad_status}}',['id'=>'27','code'=>'26','title'=>'Submitted to DILG Region (by lgu huc/icc) (revised)','future_tense'=>'Submit to DILG Region (by lgu huc/icc) (revised)','class'=>'label label-info']);
$this->insert('{{%gad_status}}',['id'=>'28','code'=>'27','title'=>'Pending Endorsement of LGU Province (by dilg region)','future_tense'=>'Cancel Endorsement of LGU Province','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'29','code'=>'28','title'=>'LGU Province Endorsed by DILG Region','future_tense'=>'Endorse LGU Province','class'=>'label label-primary']);
$this->insert('{{%gad_status}}',['id'=>'31','code'=>'30','title'=>'Returned to LGU Province (by dilg region)','future_tense'=>'Return to LGU Province','class'=>'label label-danger']);
$this->insert('{{%gad_status}}',['id'=>'32','code'=>'31','title'=>'Submitted to DILG Province (reviewed by ppdo) (revised by lgu)','future_tense'=>'Submit to DILG Province','class'=>'label label-info']);
$this->insert('{{%gad_status}}',['id'=>'33','code'=>'29','title'=>'Submitted to DILG Region (by lgu province)','future_tense'=>'Submit to DILG Region','class'=>'label label-info']);
$this->insert('{{%gad_status}}',['id'=>'34','code'=>'32','title'=>'Cancelled Returning of Report to LGU CC/M (dilg province)','future_tense'=>'Cancel Returning of Report to LGU CC/M','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'35','code'=>'33','title'=>'Cancelled Returning of Report to LGU HUC/ICC (dilg region)','future_tense'=>'Cancel returning report','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'36','code'=>'34','title'=>'Cancelled Returning of Report to LGU Province (dilg region)','future_tense'=>'Cancel Returning of Report to LGU Province','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'37','code'=>'35','title'=>'AR - Encoding Process (huc/icc)','future_tense'=>'','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'38','code'=>'36','title'=>'AR - Encoding Process (cc/m)','future_tense'=>'','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'39','code'=>'37','title'=>'AR - Encoding Process (province)','future_tense'=>'','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'40','code'=>'38','title'=>'AR - Submitted to DILG Region (by huc/icc)','future_tense'=>'Submit to DILG Region','class'=>'label label-info']);
$this->insert('{{%gad_status}}',['id'=>'41','code'=>'39','title'=>'AR - Submitted to DILG Region (by lgu province)','future_tense'=>'Submit to DILG Region','class'=>'label label-info']);
$this->insert('{{%gad_status}}',['id'=>'42','code'=>'40','title'=>'AR - Submitted to DILG Province (by cc/m)','future_tense'=>'Submit to DILG Province','class'=>'label label-info']);
$this->insert('{{%gad_status}}',['id'=>'43','code'=>'41','title'=>'AR - Reviewed by DILG Region (huc/icc)','future_tense'=>'Mark as Reviewed','class'=>'label label-primary']);
$this->insert('{{%gad_status}}',['id'=>'44','code'=>'42','title'=>'AR - Reviewed by DILG Region (lgu province)','future_tense'=>'Mark as Reviewed','class'=>'label label-primary']);
$this->insert('{{%gad_status}}',['id'=>'45','code'=>'43','title'=>'AR - Reviewed by DILG Province (cc/m)','future_tense'=>'Mark as Reviewed','class'=>'label label-primary']);
$this->insert('{{%gad_status}}',['id'=>'46','code'=>'44','title'=>'AR - Returned to LGU HUC/ICC (by dilg region)','future_tense'=>'Return to LGU HUC/ICC','class'=>'label label-danger']);
$this->insert('{{%gad_status}}',['id'=>'47','code'=>'45','title'=>'AR - Returned to LGU Province (by dilg region)','future_tense'=>'Return to LGU Province','class'=>'label label-danger']);
$this->insert('{{%gad_status}}',['id'=>'48','code'=>'46','title'=>'AR - Returned to LGU CC/M (by dilg province)','future_tense'=>'Return to LGU CC/M','class'=>'label label-danger']);
$this->insert('{{%gad_status}}',['id'=>'49','code'=>'47','title'=>'AR - Submitted to DILG Region (by huc/icc) (revised)','future_tense'=>'Submit to DILG Region','class'=>'label label-info']);
$this->insert('{{%gad_status}}',['id'=>'50','code'=>'48','title'=>'AR - Submitted to DILG Region (by lgu province) (revised)','future_tense'=>'Submit to DILG Region','class'=>'label label-info']);
$this->insert('{{%gad_status}}',['id'=>'51','code'=>'49','title'=>'AR - Submitted to DILG Province (by cc/m) (revised)','future_tense'=>'Submit to DILG Province','class'=>'label label-info']);
$this->insert('{{%gad_status}}',['id'=>'52','code'=>'50','title'=>'AR - Marked as Pending (by dilg region) (huc/icc)','future_tense'=>'Mark as Pending','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'53','code'=>'51','title'=>'AR - Marked as Pending (by dilg region) (lgu province)','future_tense'=>'Mark as Pending','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'54','code'=>'52','title'=>'AR - Marked as Pending (by dilg province) (cc/m)','future_tense'=>'Mark as Pending','class'=>'label label-warning']);
$this->insert('{{%gad_status}}',['id'=>'55','code'=>'53','title'=>'Returned to LGU CC/M (by ppdo and dilg province)','future_tense'=>'Return to LGU CC/M','class'=>'label label-danger']);
$this->insert('{{%gad_status_assignment}}',['id'=>'1','role'=>'gad_region_dilg','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'3,6,8,9,10,14,18,24,25,26,27,28,30,29']);
$this->insert('{{%gad_status_assignment}}',['id'=>'2','role'=>'gad_ppdo','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'0,1,2,4,5,7,15,16,17,19,31']);
$this->insert('{{%gad_status_assignment}}',['id'=>'3','role'=>'gad_province_dilg','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'0,2,4,7,15,16,17,31']);
$this->insert('{{%gad_status_assignment}}',['id'=>'4','role'=>'gad_lgu_non_huc','rbac_role'=>'','status_code'=>'','description'=>'GAD LGU CC/M filtered reports','status'=>'0,1,2,4,7,15,16,17,19,23,31,36,40,43,46,49,52']);
$this->insert('{{%gad_status_assignment}}',['id'=>'5','role'=>'gad_lgu_huc','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'3,6,8,10,14,25,26']);
$this->insert('{{%gad_status_assignment}}',['id'=>'6','role'=>'gad_province_lgu','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'9,18,24,27,28,30,29']);
$this->insert('{{%gad_status_assignment}}',['id'=>'7','role'=>'gad_all_status','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'0,1,2,4,5,3,6,7,8,9,10,14,15,16,17,18,19,26,27,28,30,31']);
$this->insert('{{%gad_status_assignment}}',['id'=>'8','role'=>'gad_field_huc','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'3,6,8,10,11,14,18,21']);
$this->insert('{{%gad_status_assignment}}',['id'=>'9','role'=>'gad_field_non_huc','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'0,1,2,4,5,7,12,13,15,16,17,19,20,22']);
$this->insert('{{%gad_status_assignment}}',['id'=>'10','role'=>'delete_report_for_lgu','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'0,7,16,36']);
$this->insert('{{%gad_status_assignment}}',['id'=>'11','role'=>'archive_report_for_lgu','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'0,4,7,16,23']);
$this->insert('{{%gad_status_assignment}}',['id'=>'12','role'=>'delete_report_for_huc','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'6,8,25']);
$this->insert('{{%gad_status_assignment}}',['id'=>'13','role'=>'delete_report_for_lgu_province','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'9,24,30']);
$this->insert('{{%gad_status_assignment}}',['id'=>'14','role'=>'view_report_for_huc','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'3,6,8,10,14,26']);
$this->insert('{{%gad_status_assignment}}',['id'=>'15','role'=>'archive_report_for_lgu_province','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'9,30']);
$this->insert('{{%gad_status_assignment}}',['id'=>'16','role'=>'modify_report_lgu','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'0,7,16,23']);
$this->insert('{{%gad_status_assignment}}',['id'=>'17','role'=>'modify_report_huc','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'6,8,25']);
$this->insert('{{%gad_status_assignment}}',['id'=>'18','role'=>'modify_report_lgu_province','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'9,24,30']);
$this->insert('{{%gad_status_assignment}}',['id'=>'19','role'=>'view_report_for_region','rbac_role'=>'','status_code'=>'','description'=>'view report button','status'=>'3,6,10,14,18,24,25,26,27,28,29']);
$this->insert('{{%gad_status_assignment}}',['id'=>'20','role'=>'view_report_for_ppdo','rbac_role'=>'','status_code'=>'','description'=>'view report button','status'=>'1,2,4,5,7,15,16,17,19,23,31']);
$this->insert('{{%gad_status_assignment}}',['id'=>'21','role'=>'view_report_for_province','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'2,4,5,15,16,17,31']);
$this->insert('{{%gad_status_assignment}}',['id'=>'22','role'=>'archive_report_for_region','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'3,10,14,18,26,28,29']);
$this->insert('{{%gad_status_assignment}}',['id'=>'23','role'=>'archive_report_for_ppdo','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'1,19']);
$this->insert('{{%gad_status_assignment}}',['id'=>'24','role'=>'archive_report_for_province','rbac_role'=>'','status_code'=>'','description'=>'','status'=>'2,4,15,17,31']);
$this->insert('{{%gad_status_assignment}}',['id'=>'25','role'=>'lgu_huc_report_action_when_encoding','rbac_role'=>'gad_lgu','status_code'=>'8','description'=>'Encoding process (huc/icc)','status'=>'3']);
$this->insert('{{%gad_status_assignment}}',['id'=>'26','role'=>'ppdo_report_action_when_for_review','rbac_role'=>'gad_ppdo','status_code'=>'1','description'=>'For review (by ppdo)','status'=>'2,7']);
$this->insert('{{%gad_status_assignment}}',['id'=>'27','role'=>'lgu_ccm_report_action_when_encoding_process','rbac_role'=>'gad_lgu','status_code'=>'0','description'=>'Encoding process (non-huc/icc lgu)','status'=>'1']);
$this->insert('{{%gad_status_assignment}}',['id'=>'28','role'=>'lgu_ccm_report_action_when_returned_by_ppdo','rbac_role'=>'gad_lgu','status_code'=>'7','description'=>'Returned to LGU (by ppdo)','status'=>'19']);
$this->insert('{{%gad_status_assignment}}',['id'=>'29','role'=>'dilg_province_report_action_when_lgu_submitted_revised','rbac_role'=>'gad_province','status_code'=>'17','description'=>'Submitted to DILG Province (by lgu) (revised)','status'=>'4,16']);
$this->insert('{{%gad_status_assignment}}',['id'=>'30','role'=>'dilg_province_report_action_when_ppdo_submitted','rbac_role'=>'gad_province','status_code'=>'2','description'=>'Submitted to DILG Provincial Office (by ppdo)','status'=>'4,16']);
$this->insert('{{%gad_status_assignment}}',['id'=>'31','role'=>'region_report_action_when_huc_submitted','rbac_role'=>'gad_region','status_code'=>'3','description'=>'Submitted to DILG Region (by huc/icc lgu)','status'=>'6,10']);
$this->insert('{{%gad_status_assignment}}',['id'=>'32','role'=>'dilg_province_report_action_when_endorsed','rbac_role'=>'gad_province','status_code'=>'4','description'=>'Endorsed By DILG (provincial office)','status'=>'15']);
$this->insert('{{%gad_status_assignment}}',['id'=>'33','role'=>'ppdo_report_action_when_returned','rbac_role'=>'gad_ppdo','status_code'=>'5','description'=>'Returned to PPDO (by dilg province)','status'=>'2,53']);
$this->insert('{{%gad_status_assignment}}',['id'=>'34','role'=>'region_report_action_when_huc_endorsed','rbac_role'=>'gad_region','status_code'=>'10','description'=>'LGU HUC/ICC ENDORSED BY DILG REGION','status'=>'14']);
$this->insert('{{%gad_status_assignment}}',['id'=>'35','role'=>'region_report_action_when_huc_pending','rbac_role'=>'gad_region','status_code'=>'14','description'=>'Pending endorsement of LGU HUC/ICC (by dilg region)','status'=>'6,10']);
$this->insert('{{%gad_status_assignment}}',['id'=>'36','role'=>'dilg_province_report_action_when_pending','rbac_role'=>'gad_province','status_code'=>'15','description'=>'Pending endorsement of LGU CC/M (by dilg province)','status'=>'4,16']);
$this->insert('{{%gad_status_assignment}}',['id'=>'37','role'=>'lgu_ccm_report_action_when_returned_by_dilg','rbac_role'=>'gad_lgu','status_code'=>'16','description'=>'Returned to LGU (by dilg province) (for revision)','status'=>'17,19']);
$this->insert('{{%gad_status_assignment}}',['id'=>'38','role'=>'region_report_action_when_province_submitted_revised','rbac_role'=>'gad_region','status_code'=>'18','description'=>'Submitted to DILG Region (by lgu province) (revised)','status'=>'28,30']);
$this->insert('{{%gad_status_assignment}}',['id'=>'39','role'=>'ppdo_report_action_when_submitted','rbac_role'=>'gad_ppdo','status_code'=>'19','description'=>'For review by PPDO (revised)','status'=>'7,31']);
$this->insert('{{%gad_status_assignment}}',['id'=>'40','role'=>'region_report_action_when_submitted_huc','rbac_role'=>'gad_region','status_code'=>'26','description'=>'Submitted to DILG Region (by lgu huc/icc) (revised)','status'=>'6,10']);
$this->insert('{{%gad_status_assignment}}',['id'=>'41','role'=>'region_report_action_when_pending_lguprovince','rbac_role'=>'gad_region','status_code'=>'27','description'=>'Pending Endorsement of LGU Province (by dilg region)','status'=>'28,30']);
$this->insert('{{%gad_status_assignment}}',['id'=>'42','role'=>'region_report_action_after_endorsed','rbac_role'=>'gad_region','status_code'=>'28','description'=>'','status'=>'27']);
$this->insert('{{%gad_status_assignment}}',['id'=>'43','role'=>'lgu_huc_report_action_when_returned_by_region','rbac_role'=>'gad_lgu','status_code'=>'6','description'=>'Returned to LGU HUC/ICC (by dilg region)','status'=>'26']);
$this->insert('{{%gad_status_assignment}}',['id'=>'44','role'=>'lgu_province_returned_report_action','rbac_role'=>'gad_lgu_province','status_code'=>'30','description'=>'','status'=>'18']);
$this->insert('{{%gad_status_assignment}}',['id'=>'45','role'=>'dilg_province_report_action_when_revised_submitted_by_ppdo','rbac_role'=>'gad_province','status_code'=>'31','description'=>'Submitted to DILG Province (reviewed by ppdo) (revised by lgu)','status'=>'4,16']);
$this->insert('{{%gad_status_assignment}}',['id'=>'46','role'=>'lgu_province_encoding_plan','rbac_role'=>'gad_lgu_province','status_code'=>'9','description'=>'','status'=>'29']);
$this->insert('{{%gad_status_assignment}}',['id'=>'47','role'=>'region_report_action','rbac_role'=>'gad_region','status_code'=>'29','description'=>'Submitted to DILG Region (by lgu province)','status'=>'28,30']);
$this->insert('{{%gad_status_assignment}}',['id'=>'48','role'=>'lgu_huc_encoding_ar','rbac_role'=>'gad_lgu','status_code'=>'35','description'=>'AR - Encoding Process (huc/icc)','status'=>'38']);
$this->insert('{{%gad_status_assignment}}',['id'=>'49','role'=>'lgu_ccm_encoding_ar','rbac_role'=>'gad_lgu','status_code'=>'36','description'=>'','status'=>'40']);
$this->insert('{{%gad_status_assignment}}',['id'=>'50','role'=>'lgu_province_encoding_process_ar','rbac_role'=>'gad_lgu_province','status_code'=>'37','description'=>'AR - Encoding Process (province)','status'=>'39']);
$this->insert('{{%gad_status_assignment}}',['id'=>'51','role'=>'encode_ar','rbac_role'=>'','status_code'=>'','description'=>'permission to encode accomplishment report','status'=>'35,36,37,44,45,46']);
$this->insert('{{%gad_status_assignment}}',['id'=>'52','role'=>'encode_plan','rbac_role'=>'','status_code'=>'','description'=>'Permission to encode plan and budget','status'=>'0,6,7,8,9,16,23,24,25,30']);
$this->insert('{{%gad_status_assignment}}',['id'=>'53','role'=>'edit_plan','rbac_role'=>'gad_lgu','status_code'=>'','description'=>'Permission to edit plan for LGU','status'=>'0,7,16,23']);
$this->insert('{{%gad_status_assignment}}',['id'=>'54','role'=>'edit_plan','rbac_role'=>'gad_lgu_province','status_code'=>'','description'=>'Permission to Edit Plan for LGU Province','status'=>'9,24,30']);
$this->insert('{{%gad_status_assignment}}',['id'=>'55','role'=>'edit_plan','rbac_role'=>'gad_lgu','status_code'=>'','description'=>'Edit Plan for HUC/ICC','status'=>'6,8']);
$this->insert('{{%gad_status_assignment}}',['id'=>'56','role'=>'delete_row_plan','rbac_role'=>'gad_lgu','status_code'=>'','description'=>'delete plan row for gad lgu cc/m','status'=>'0,7,16,23']);
$this->insert('{{%gad_status_assignment}}',['id'=>'57','role'=>'delete_row_plan','rbac_role'=>'gad_lgu_province','status_code'=>'','description'=>'delete row plan for lgu province','status'=>'9,24,30']);
$this->insert('{{%gad_status_assignment}}',['id'=>'58','role'=>'delete_row_plan','rbac_role'=>'gad_lgu','status_code'=>'','description'=>'delete row plan for huc','status'=>'8,30']);
$this->insert('{{%gad_status_assignment}}',['id'=>'59','role'=>'plan_upload_files_row','rbac_role'=>'gad_lgu','status_code'=>'','description'=>'upload files per row for lgu cc/m','status'=>'0,6,7,16,23,25']);
$this->insert('{{%gad_status_assignment}}',['id'=>'60','role'=>'plan_upload_files_row','rbac_role'=>'gad_lgu_province','status_code'=>'','description'=>'upload files per row for lgu province','status'=>'9,24,30']);
$this->insert('{{%gad_status_assignment}}',['id'=>'61','role'=>'create_general_observation','rbac_role'=>'gad_region','status_code'=>'','description'=>'permission to access the creation of general observation module','status'=>'3,10,18,26,28,29']);
$this->insert('{{%gad_status_assignment}}',['id'=>'62','role'=>'create_general_observation','rbac_role'=>'gad_province','status_code'=>'','description'=>'','status'=>'2,4,17,31']);
$this->insert('{{%gad_status_assignment}}',['id'=>'63','role'=>'menu_document','rbac_role'=>'gad_region','status_code'=>'','description'=>'','status'=>'']);
$this->insert('{{%gad_status_assignment}}',['id'=>'64','role'=>'menu_document','rbac_role'=>'gad_province','status_code'=>'','description'=>'','status'=>'']);
$this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191105_070410_truncate_status_assignment_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191105_070410_truncate_status_assignment_tables cannot be reverted.\n";

        return false;
    }
    */
}
