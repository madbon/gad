<?php
use common\modules\cms\controllers\DocumentController;
use common\modules\report\controllers\DefaultController as Tools;
// echo "<pre>";
// print_r($arrCategory7); exit;
    /* Note: any element you append to a document must reside inside of a Section. */
        // Note (arrCategory7) :
        // 0 - Month
        // 1 - Office of the?
        // 2 - Name of Regional/provincial director
        // 3 - Regional or Proivincial Director?
        // 4 - Day

        $city_lgu = !empty(Tools::GetCitymunName($ruc)) ? ucwords(strtolower(Tools::GetCitymunName($ruc))).", " : "";
        $province_name = ucwords(strtolower(Tools::GetProvinceName($ruc)));
        // Adding an empty Section to the document...
        $section = $phpWord->createSection();
        $phpWord->setDefaultFontSize(11);
        $phpWord->setDefaultFontName('Calibri');
        // Adding Text element with font customized using named font style...
        $fontStyleName = 'oneUserDefinedStyle';
        $phpWord->addFontStyle(
            $fontStyleName,
            array('color' => 'black')
        );
        
        // --------------------- TITLE part
        $phpWord->addParagraphStyle('docsTitle', ['align'=>'center']);
        $section->addText('CERTIFICATE OF REVEIW AND ENDORSEMENT', ['bold' => true, 'align' => 'center'],'docsTitle');

        // --------------------- 1st paragraph
        $section->addTextBreak(1);
        $phpWord->addFontStyle(
            'letterToFontStyle',
            array('color' => 'black')
        );
        $phpWord->addParagraphStyle('textJustify', ['align'=>'both','spacing' => 120,'lineHeight'=>1.3,'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)]);
        $section->addText("               This is to certify that the GAD Plan and Budget (GPB) for FY  ".(Tools::GetPlanYear($ruc))." of ".($city_lgu.$province_name)." has been reviewed and was found fully compliant in form and contents  with the provisions of Republic Act No. 9710 and its Implementing Rules and Regulations, and PCW-DILG-DBM-NEDA Joint Memorandum Circular Nos. 2013-01 and 2016-01. Per DILG’s review, the GPB of ".($city_lgu.$province_name)." was found complaint with the following:",
            'letterToFontStyle','textJustify'
        );

        // --------------------- Listing  part
        $section->addTextBreak(1);
        $phpWord->addNumberingStyle(
            'multilevel',
            [
                'type' => 'multilevel',
                'levels' => array(
                    array('format' => 'upperLetter','text' => '-', 'left' => 1000, 'hanging' => 360, 'tabPos' => 700),
                )
            ]
        );
        $phpWord->addFontStyle(
            'listingStyle',
            array('color' => 'black')
        );
        $section->addListItem('At least five (5%) of LGUs’ total annual budget was allocated to GAD PPAs addressing gender issues;', 0, null, 'multilevel','listingStyle');
        $section->addListItem('ALL Programs, Projects and Activities (PPAs) are responsive to LGUs identified Gender Issues and /or GAD Mandate', 0, null, 'multilevel','listingStyle');

        // --------------------- 2nd paragraph
        $section->addTextBreak(1);
        $section->addText("               Thus, said GPB of ".($city_lgu.$province_name)." is hereby officially endorsed for incorporation in the Provincial / City / Municipal’s Annual Investment Program (AIP) and Annual Budget.",
            'letterToFontStyle','textJustify'
        );

        $section->addTextBreak(1);
        $section->addText("               Issued this ".$arrCategory7[4]." day of ".$arrCategory7[0].", ".(date("Y"))." at the Office of the ".($arrCategory7[1])." ",
            'letterToFontStyle','textJustify'
        );

        
        $section->addTextBreak(4);
        $section->addText(strtoupper($arrCategory7[2]), ['align' => 'center'],'docsTitle');
        $section->addText($arrCategory7[3], ['align' => 'center'],'docsTitle');
        

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Letter1.docx');
        $path = Yii::getAlias('@webroot').'/Letter1.docx';
        $name = 'Certificate of Review and Endorsement ('.($city_lgu.$province_name).').docx';
        return Yii::$app->response->sendFile($path, $name);
?>