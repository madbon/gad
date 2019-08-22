<?php

use yii\db\Migration;

/**
 * Class m190817_092657_gad_auth_item_and_child
 */
class m190817_092657_gad_auth_item_and_child extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
 
$this->createIndex('idx_rule_name_0282_00','auth_item','rule_name',0);
$this->createIndex('idx_type_0282_01','auth_item','type',0);
$this->createIndex('idx_child_0373_02','auth_item_child','child',0);
 
$this->execute('SET foreign_key_checks = 0');
$this->addForeignKey('fk_auth_rule_0277_00','{{%auth_item}}', 'rule_name', '{{%auth_rule}}', 'name', 'CASCADE', 'NO ACTION' );
$this->addForeignKey('fk_auth_item_0369_01','{{%auth_item_child}}', 'parent', '{{%auth_item}}', 'name', 'CASCADE', 'NO ACTION' );
$this->addForeignKey('fk_auth_item_0369_02','{{%auth_item_child}}', 'child', '{{%auth_item}}', 'name', 'CASCADE', 'NO ACTION' );
$this->execute('SET foreign_key_checks = 1;');
 
$this->execute('SET foreign_key_checks = 0');
$this->insert('{{%auth_item}}',['name'=>'gad_admin','type'=>'1','description'=>'ISTMS','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554696631','updated_at'=>'1560133863']);
$this->insert('{{%auth_item}}',['name'=>'gad_admin_permission','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1559624730','updated_at'=>'1563890819']);
$this->insert('{{%auth_item}}',['name'=>'gad_attach_accomplishment','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1561201182','updated_at'=>'1561201182']);
$this->insert('{{%auth_item}}',['name'=>'gad_central','type'=>'1','description'=>'BLGD','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554693484','updated_at'=>'1560133651']);
$this->insert('{{%auth_item}}',['name'=>'gad_central_permission','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1559624718','updated_at'=>'1563890833']);
$this->insert('{{%auth_item}}',['name'=>'gad_cms_admin','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1563019426','updated_at'=>'1563019426']);
$this->insert('{{%auth_item}}',['name'=>'gad_cms_super_admin','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1563019436','updated_at'=>'1563020634']);
$this->insert('{{%auth_item}}',['name'=>'gad_comment_activity','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1562637534','updated_at'=>'1562637534']);
$this->insert('{{%auth_item}}',['name'=>'gad_comment_attributed_pro_budget','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1566367307','updated_at'=>'1566367307']);
$this->insert('{{%auth_item}}',['name'=>'gad_comment_co','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1562637613','updated_at'=>'1562637613']);
$this->insert('{{%auth_item}}',['name'=>'gad_comment_for_dilg_province','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1562637755','updated_at'=>'1566367629']);
$this->insert('{{%auth_item}}',['name'=>'gad_comment_for_dilg_region','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1562637880','updated_at'=>'1566367488']);
$this->insert('{{%auth_item}}',['name'=>'gad_comment_for_ppdo','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1562637678','updated_at'=>'1562637678']);
$this->insert('{{%auth_item}}',['name'=>'gad_comment_gender_issue','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1562637490','updated_at'=>'1562637490']);
$this->insert('{{%auth_item}}',['name'=>'gad_comment_hgdg_score','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1566367261','updated_at'=>'1566367261']);
$this->insert('{{%auth_item}}',['name'=>'gad_comment_lead','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1562637623','updated_at'=>'1562637623']);
$this->insert('{{%auth_item}}',['name'=>'gad_comment_lgu_program','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1566367240','updated_at'=>'1566367240']);
$this->insert('{{%auth_item}}',['name'=>'gad_comment_mooe','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1562637598','updated_at'=>'1562637598']);
$this->insert('{{%auth_item}}',['name'=>'gad_comment_objective','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1562637509','updated_at'=>'1562637509']);
$this->insert('{{%auth_item}}',['name'=>'gad_comment_performance','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1562637584','updated_at'=>'1562637584']);
$this->insert('{{%auth_item}}',['name'=>'gad_comment_ps','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1562637605','updated_at'=>'1562637605']);
$this->insert('{{%auth_item}}',['name'=>'gad_comment_relevant','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1562637523','updated_at'=>'1562637523']);
$this->insert('{{%auth_item}}',['name'=>'gad_comment_total_annual_pro_budget','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1566367286','updated_at'=>'1566367286']);
$this->insert('{{%auth_item}}',['name'=>'gad_create_accomplishment','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554693785','updated_at'=>'1554694234']);
$this->insert('{{%auth_item}}',['name'=>'gad_create_comment','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554694114','updated_at'=>'1554694242']);
$this->insert('{{%auth_item}}',['name'=>'gad_create_letter','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1561201213','updated_at'=>'1561201213']);
$this->insert('{{%auth_item}}',['name'=>'gad_create_letter_menu','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1564014326','updated_at'=>'1564014326']);
$this->insert('{{%auth_item}}',['name'=>'gad_create_planbudget','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554693588','updated_at'=>'1554694267']);
$this->insert('{{%auth_item}}',['name'=>'gad_dashboard_citymun','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1563025366','updated_at'=>'1563025366']);
$this->insert('{{%auth_item}}',['name'=>'gad_dashboard_menu','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1563890775','updated_at'=>'1563890775']);
$this->insert('{{%auth_item}}',['name'=>'gad_dashboard_national','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1563025320','updated_at'=>'1563025320']);
$this->insert('{{%auth_item}}',['name'=>'gad_dashboard_provincial','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1563025342','updated_at'=>'1563025342']);
$this->insert('{{%auth_item}}',['name'=>'gad_dashboard_regional','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1563025329','updated_at'=>'1563025329']);
$this->insert('{{%auth_item}}',['name'=>'gad_delete_accomplishment_report','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1560130622','updated_at'=>'1560130622']);
$this->insert('{{%auth_item}}',['name'=>'gad_delete_attachment','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1562631326','updated_at'=>'1562631326']);
$this->insert('{{%auth_item}}',['name'=>'gad_delete_plan_budget','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1560130613','updated_at'=>'1560130613']);
$this->insert('{{%auth_item}}',['name'=>'gad_delete_rowaccomplishment','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1560912922','updated_at'=>'1560912922']);
$this->insert('{{%auth_item}}',['name'=>'gad_delete_rowplanbudget','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1560912904','updated_at'=>'1560912904']);
$this->insert('{{%auth_item}}',['name'=>'gad_delete_uploaded_files_endorsing','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1564038760','updated_at'=>'1564038760']);
$this->insert('{{%auth_item}}',['name'=>'gad_document_menu','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1564066242','updated_at'=>'1564066242']);
$this->insert('{{%auth_item}}',['name'=>'gad_edit_cell','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554694358','updated_at'=>'1554694358']);
$this->insert('{{%auth_item}}',['name'=>'gad_edit_gisupdata','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1560912443','updated_at'=>'1560912443']);
$this->insert('{{%auth_item}}',['name'=>'gad_endorse_report','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554694849','updated_at'=>'1554694849']);
$this->insert('{{%auth_item}}',['name'=>'gad_field','type'=>'1','description'=>'DILG C/M Office','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554693407','updated_at'=>'1560841878']);
$this->insert('{{%auth_item}}',['name'=>'gad_field_permission','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1559261305','updated_at'=>'1561201362']);
$this->insert('{{%auth_item}}',['name'=>'gad_hgdg_score_standard','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1560145164','updated_at'=>'1560145164']);
$this->insert('{{%auth_item}}',['name'=>'gad_letter_endorsement_dilg','type'=>'2','description'=>'CERTIFICATE OF REVIEW AND ENDORSEMENT','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1563933025','updated_at'=>'1563933025']);
$this->insert('{{%auth_item}}',['name'=>'gad_letter_endorsement_ppdo','type'=>'2','description'=>'letter of review and endorsement from the Municipal/City/Provincial Planning and Coordinating Office','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1563932912','updated_at'=>'1563932912']);
$this->insert('{{%auth_item}}',['name'=>'gad_letter_general_observation','type'=>'2','description'=>'Letter of Review (General Observations and Recommendations)','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1563933157','updated_at'=>'1563933157']);
$this->insert('{{%auth_item}}',['name'=>'gad_letter_review_ppdo','type'=>'2','description'=>'Provincial Planning and Coordinating Office (If the GPB is not aligned with the Higher LGU’s Plan/Priorities)','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1563932802','updated_at'=>'1563932802']);
$this->insert('{{%auth_item}}',['name'=>'gad_lgu','type'=>'1','description'=>'LGU C/M Office','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554953029','updated_at'=>'1560841796']);
$this->insert('{{%auth_item}}',['name'=>'gad_lgu_permission','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1559184586','updated_at'=>'1566273008']);
$this->insert('{{%auth_item}}',['name'=>'gad_lgu_province','type'=>'1','description'=>'LGU Provincial Office','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1559619251','updated_at'=>'1560841787']);
$this->insert('{{%auth_item}}',['name'=>'gad_lgu_province_permission','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1559618290','updated_at'=>'1566273022']);
$this->insert('{{%auth_item}}',['name'=>'gad_load_plan','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1564014499','updated_at'=>'1564014499']);
$this->insert('{{%auth_item}}',['name'=>'gad_load_uploaded_files','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1564014526','updated_at'=>'1564014526']);
$this->insert('{{%auth_item}}',['name'=>'gad_lookup_tables','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1563020615','updated_at'=>'1563020615']);
$this->insert('{{%auth_item}}',['name'=>'gad_menu_create','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1559261611','updated_at'=>'1559261611']);
$this->insert('{{%auth_item}}',['name'=>'gad_menu_report','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1559261737','updated_at'=>'1559261737']);
$this->insert('{{%auth_item}}',['name'=>'gad_ppdo','type'=>'1','description'=>'Provincial, Planning and Development office (PPDO)','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1560841746','updated_at'=>'1560842627']);
$this->insert('{{%auth_item}}',['name'=>'gad_ppdo_permission','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1560841727','updated_at'=>'1564066261']);
$this->insert('{{%auth_item}}',['name'=>'gad_province','type'=>'1','description'=>'DILG Provincial Office','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554693438','updated_at'=>'1563272513']);
$this->insert('{{%auth_item}}',['name'=>'gad_province_permission','type'=>'2','description'=>'dilg province permission','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1559624654','updated_at'=>'1566367572']);
$this->insert('{{%auth_item}}',['name'=>'gad_region','type'=>'1','description'=>'DILG Regional Office','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554693450','updated_at'=>'1559625085']);
$this->insert('{{%auth_item}}',['name'=>'gad_region_permission','type'=>'2','description'=>'DILG Region Permission','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1559624636','updated_at'=>'1564066283']);
$this->insert('{{%auth_item}}',['name'=>'gad_return_report','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554697004','updated_at'=>'1554697004']);
$this->insert('{{%auth_item}}',['name'=>'gad_review_report','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554694745','updated_at'=>'1554695057']);
$this->insert('{{%auth_item}}',['name'=>'gad_submit_all_to_central','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1559729102','updated_at'=>'1559729102']);
$this->insert('{{%auth_item}}',['name'=>'gad_submit_report','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554695225','updated_at'=>'1554695225']);
$this->insert('{{%auth_item}}',['name'=>'gad_submit_to_central','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1559284732','updated_at'=>'1559284732']);
$this->insert('{{%auth_item}}',['name'=>'gad_submit_to_cmlgoo','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1559284692','updated_at'=>'1559284692']);
$this->insert('{{%auth_item}}',['name'=>'gad_submit_to_province','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1559284712','updated_at'=>'1559284712']);
$this->insert('{{%auth_item}}',['name'=>'gad_submit_to_region','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1559284722','updated_at'=>'1559284722']);
$this->insert('{{%auth_item}}',['name'=>'gad_update_other_details','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1565749656','updated_at'=>'1565749656']);
$this->insert('{{%auth_item}}',['name'=>'gad_upload_files_endorsing','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1564038707','updated_at'=>'1564038707']);
$this->insert('{{%auth_item}}',['name'=>'gad_upload_files_row','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1561684818','updated_at'=>'1561684818']);
$this->insert('{{%auth_item}}',['name'=>'gad_upload_later','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1566270199','updated_at'=>'1566270199']);
$this->insert('{{%auth_item}}',['name'=>'gad_user_management','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1563020592','updated_at'=>'1563020592']);
$this->insert('{{%auth_item}}',['name'=>'gad_view_comment','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554694424','updated_at'=>'1554694424']);
$this->insert('{{%auth_item}}',['name'=>'gad_viewreport_accomplishment','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554694040','updated_at'=>'1554694294']);
$this->insert('{{%auth_item}}',['name'=>'gad_viewreport_planbudget','type'=>'2','description'=>'','rule_name'=>NULL,'data'=>NULL,'created_at'=>'1554694001','updated_at'=>'1554694001']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_admin','child'=>'gad_admin_permission']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_admin_permission','child'=>'gad_cms_super_admin']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_admin_permission','child'=>'gad_dashboard_menu']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_admin_permission','child'=>'gad_menu_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_admin_permission','child'=>'gad_review_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_admin_permission','child'=>'gad_view_comment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_admin_permission','child'=>'gad_viewreport_accomplishment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_admin_permission','child'=>'gad_viewreport_planbudget']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_central','child'=>'gad_central_permission']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_central_permission','child'=>'gad_cms_admin']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_central_permission','child'=>'gad_dashboard_menu']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_central_permission','child'=>'gad_menu_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_central_permission','child'=>'gad_review_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_central_permission','child'=>'gad_view_comment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_central_permission','child'=>'gad_viewreport_accomplishment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_central_permission','child'=>'gad_viewreport_planbudget']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_cms_super_admin','child'=>'gad_lookup_tables']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_cms_super_admin','child'=>'gad_user_management']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_province','child'=>'gad_comment_activity']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_province','child'=>'gad_comment_attributed_pro_budget']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_province','child'=>'gad_comment_co']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_province','child'=>'gad_comment_gender_issue']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_province','child'=>'gad_comment_hgdg_score']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_province','child'=>'gad_comment_lead']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_province','child'=>'gad_comment_lgu_program']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_province','child'=>'gad_comment_mooe']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_province','child'=>'gad_comment_objective']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_province','child'=>'gad_comment_performance']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_province','child'=>'gad_comment_ps']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_province','child'=>'gad_comment_relevant']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_province','child'=>'gad_comment_total_annual_pro_budget']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_region','child'=>'gad_comment_activity']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_region','child'=>'gad_comment_attributed_pro_budget']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_region','child'=>'gad_comment_co']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_region','child'=>'gad_comment_gender_issue']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_region','child'=>'gad_comment_hgdg_score']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_region','child'=>'gad_comment_lgu_program']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_region','child'=>'gad_comment_mooe']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_region','child'=>'gad_comment_objective']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_region','child'=>'gad_comment_performance']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_region','child'=>'gad_comment_ps']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_region','child'=>'gad_comment_relevant']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_dilg_region','child'=>'gad_comment_total_annual_pro_budget']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_ppdo','child'=>'gad_comment_activity']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_comment_for_ppdo','child'=>'gad_comment_relevant']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_field','child'=>'gad_field_permission']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_field_permission','child'=>'gad_attach_accomplishment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_field_permission','child'=>'gad_create_comment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_field_permission','child'=>'gad_create_letter']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_field_permission','child'=>'gad_endorse_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_field_permission','child'=>'gad_hgdg_score_standard']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_field_permission','child'=>'gad_menu_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_field_permission','child'=>'gad_return_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_field_permission','child'=>'gad_review_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_field_permission','child'=>'gad_submit_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_field_permission','child'=>'gad_view_comment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_field_permission','child'=>'gad_viewreport_accomplishment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_field_permission','child'=>'gad_viewreport_planbudget']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu','child'=>'gad_lgu_permission']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_attach_accomplishment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_create_accomplishment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_create_planbudget']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_delete_accomplishment_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_delete_attachment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_delete_plan_budget']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_delete_rowaccomplishment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_delete_rowplanbudget']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_edit_cell']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_edit_gisupdata']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_endorse_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_load_plan']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_load_uploaded_files']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_menu_create']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_menu_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_submit_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_update_other_details']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_upload_files_row']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_upload_later']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_view_comment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_viewreport_accomplishment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_permission','child'=>'gad_viewreport_planbudget']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province','child'=>'gad_lgu_province_permission']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_attach_accomplishment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_create_accomplishment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_create_comment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_create_planbudget']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_delete_accomplishment_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_delete_plan_budget']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_edit_cell']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_endorse_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_load_plan']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_load_uploaded_files']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_menu_create']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_menu_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_review_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_submit_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_update_other_details']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_upload_files_row']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_upload_later']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_view_comment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_viewreport_accomplishment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_lgu_province_permission','child'=>'gad_viewreport_planbudget']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_ppdo','child'=>'gad_ppdo_permission']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_ppdo_permission','child'=>'gad_comment_for_ppdo']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_ppdo_permission','child'=>'gad_create_comment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_ppdo_permission','child'=>'gad_create_letter_menu']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_ppdo_permission','child'=>'gad_dashboard_menu']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_ppdo_permission','child'=>'gad_document_menu']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_ppdo_permission','child'=>'gad_endorse_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_ppdo_permission','child'=>'gad_letter_endorsement_ppdo']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_ppdo_permission','child'=>'gad_letter_review_ppdo']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_ppdo_permission','child'=>'gad_menu_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_ppdo_permission','child'=>'gad_return_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_ppdo_permission','child'=>'gad_review_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_ppdo_permission','child'=>'gad_submit_to_cmlgoo']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_ppdo_permission','child'=>'gad_upload_files_endorsing']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_ppdo_permission','child'=>'gad_view_comment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_ppdo_permission','child'=>'gad_viewreport_accomplishment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_ppdo_permission','child'=>'gad_viewreport_planbudget']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_province','child'=>'gad_province_permission']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_province_permission','child'=>'gad_comment_for_dilg_province']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_province_permission','child'=>'gad_create_letter_menu']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_province_permission','child'=>'gad_dashboard_menu']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_province_permission','child'=>'gad_document_menu']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_province_permission','child'=>'gad_letter_endorsement_dilg']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_province_permission','child'=>'gad_letter_general_observation']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_province_permission','child'=>'gad_menu_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_province_permission','child'=>'gad_return_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_province_permission','child'=>'gad_review_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_province_permission','child'=>'gad_submit_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_province_permission','child'=>'gad_upload_files_endorsing']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_province_permission','child'=>'gad_view_comment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_province_permission','child'=>'gad_viewreport_accomplishment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_province_permission','child'=>'gad_viewreport_planbudget']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region','child'=>'gad_region_permission']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_attach_accomplishment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_comment_for_dilg_region']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_create_comment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_create_letter']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_create_letter_menu']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_dashboard_menu']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_delete_uploaded_files_endorsing']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_document_menu']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_endorse_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_hgdg_score_standard']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_letter_endorsement_dilg']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_letter_general_observation']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_menu_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_return_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_review_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_submit_all_to_central']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_submit_report']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_submit_to_central']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_upload_files_endorsing']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_view_comment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_viewreport_accomplishment']);
$this->insert('{{%auth_item_child}}',['parent'=>'gad_region_permission','child'=>'gad_viewreport_planbudget']);
$this->execute('SET foreign_key_checks = 1;');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190817_092657_gad_auth_item_and_child cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190817_092657_gad_auth_item_and_child cannot be reverted.\n";

        return false;
    }
    */
}
