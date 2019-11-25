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
        
        $section->addTextBreak(3);
        // --------------------- Date
        $phpWord->addParagraphStyle('docsTitle', ['align'=>'center']);
        $section->addText($arrCategory7[0],[],['align' => 'right']);

        // --------------------- 1st paragraph
        $section->addTextBreak(2);
        $phpWord->addFontStyle(
            'letterToFontStyle',
            array('color' => 'black')
        );
        $phpWord->addParagraphStyle('toNames', ['align'=>'left','spacing' => 120,'lineHeight'=>1,'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)]);
        $section->addText($arrCategory7[1]."<w:br/>Provincial Director<w:br/>DILG ".$province_name,
            'letterToFontStyle','toNames'
        );

        $section->addTextBreak(1);

        $section->addText('Dear Provincial Director '.$arrCategory7[1],
            'letterToFontStyle','toNames'
        );

        $phpWord->addParagraphStyle('textJustify', ['align'=>'both','spacing' => 120,'lineHeight'=>1.3,'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)]);

        $section->addTextBreak(1);
        $section->addText("         This is in reference to the GAD Plan and Budget (GPB) FY ".Tools::GetPlanYear($ruc)." of ".($city_lgu.$province_name).".  <w:br/><w:br/>         Please be informed that per review of this Office, the said GPB is aligned with the Provincial priorities/plans.<w:br/><w:br/>          Following the provisions of Republic Act No. 9710 and its Implementing Rules and Regulations, and PCW-DILG-DBM-NEDA Joint Memorandum Circular Nos. 2013-01 and 2016-01, we are forwarding to your office the GAD Plan and Budget FY ".(Tools::GetPlanYear($ruc))." of ".($city_lgu.$province_name)." for your review and issuance of endorsement to incorporate the said GPB to their Annual Investment Program and Annual Budget.",
            'letterToFontStyle','textJustify'
        );
        
        $section->addTextBreak(4);
        $section->addText("Very truly yours,",[],['align' => 'right']);
        $section->addTextBreak(1);
        $phpWord->addParagraphStyle('signatory', ['align'=>'right','spacing' => 120,'lineHeight'=>1,'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)]);
        $section->addText($arrCategory7[2]."<w:br/>Provincial Planning and Development Coordinator<w:br/>".$province_name,
            'letterToFontStyle','signatory'
        );

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Letter1.docx');
        $path = Yii::getAlias('@webroot').'/Letter1.docx';
        $name = 'Letter of Review and Endorsement from Provincial Planning and Development Coordinating Office ('.($city_lgu.$province_name).').docx';
        return Yii::$app->response->sendFile($path, $name);
?>