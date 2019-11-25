<?php
use common\modules\cms\controllers\DocumentController;
    /* Note: any element you append to a document must reside inside of a Section. */
        // Adding an empty Section to the document...
        $section = $phpWord->createSection();
        // Adding Text element with font customized using named font style...
        $fontStyleName = 'oneUserDefinedStyle';
        $phpWord->addFontStyle(
            $fontStyleName,
            array('name' => 'Verdana', 'size' => 11, 'color' => 'black')
        );
        $phpWord->addParagraphStyle('docsTitle', ['align'=>'center']);
        $section->addText('',
            $fontStyleName,'docsTitle'
        );
        $section->addText('',
            $fontStyleName,'docsTitle'
        );
         $section->addText('',
            $fontStyleName,'docsTitle'
        );
          $section->addText('',
            $fontStyleName,'docsTitle'
        );
        $phpWord->addParagraphStyle('dateStyle', ['align'=>'right']);
        $section->addText($generated_date,
            $fontStyleName,'dateStyle'
        );

        $phpWord->addFontStyle(
            'letterToFontStyle',
            array('name' => 'Verdana', 'size' => 11, 'color' => 'black')
        );
        $phpWord->addParagraphStyle('letterTo', ['align'=>'left','spacing' => 120,'lineHeight'=>1,'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)]);
        $section->addText("Hon. ".$lce_name,
            'letterToFontStyle','letterTo'
        );
        $section->addText("Mayor/Governor",
            'letterToFontStyle','letterTo'
        );
        $section->addText($address_lgu,
            'letterToFontStyle','letterTo'
        );

        $section->addText('',
            $fontStyleName,'docsTitle'
        );
        $section->addText('',
            $fontStyleName,'docsTitle'
        );

        $section->addText("Dear Mayor/Governor ".$lce_name,
            'letterToFontStyle','letterTo'
        );
        $section->addText('',
            $fontStyleName,'docsTitle'
        );

        $phpWord->addParagraphStyle('bodyParaStyle',[]);
        $section->addText("        This Office acknowledges receipt of the GAD Plan and Budget (GPB) FY ".$fy." of ".$name_lgu.". We, however, defer endorsement of the same to the DILG Office due to the following general observations and recommendations:",
            'letterToFontStyle','bodyParaStyle'
        );
        $section->addTextBreak(2);
        $section->addText("        The following programs, projects or activities are not aligned with the provincial plan PPAs:",
            'letterToFontStyle','bodyParaStyle'
        );
        
        $cellstyle= array('align'=>'center','name' => 'Verdana', 'size' => 11);
        $header = array('size' => 16, 'bold' => true);

        // -------------------- Table Start
        $section->addTextBreak(1);
        $fancyTableStyleName = '';
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => 'black', 'cellMargin' => 50, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'cellSpacing' => 1);
        $fancyTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => 'black', 'bgColor' => 'white');
        $fancyTableCellStyle = array('valign' => 'center');
        $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $fancyTableFontStyle = array('bold' => true);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
        $table = $section->addTable($fancyTableStyleName,array('wrappingStyle' => 'behind', 'positioning' => 'absolute'));
        $table->addRow(900);
        $table->addCell(3000, $fancyTableCellStyle)->addText('City/Municipal PPAs', $fancyTableFontStyle,$cellstyle);
        $table->addCell(6000, $fancyTableCellStyle)->addText('Inconsistent/not aligned with the Provincial PPAs', $fancyTableFontStyle,$cellstyle);

        // $count_table_row = 0;

        foreach ($qryComment as $key => $row) {
            $table->addRow();
            $table->addCell(3000)->addText($row["column_title"]."<w:br/>".DocumentController::WrapText(DocumentController::ChangeAmpersand($row['column_value'])));
            $table->addCell(6000)->addText(DocumentController::WrapText(DocumentController::ChangeAmpersand($row['comment_value'])));
        }
        // --------------------- Table End

        $section->addText('',
            $fontStyleName,'docsTitle'
        );
        $section->addText("        Following the provisions  of  PCW-DILG-DBM-NEDA JMC 2013-01 and  2016-01 please revise and   comply  with said  observations/recommendations  and   submit  your  plan and budget within  five (5)  working  days  for review and    submission to  DILG.",
            'letterToFontStyle','bodyParaStyle'
        );
        $section->addText('',
            $fontStyleName,'docsTitle'
        );
        $section->addText('',
            $fontStyleName,'docsTitle'
        );
        $section->addText("                                                                         Very truly yours,",
            'letterToFontStyle','bodyParaStyle'
        );
         $section->addText('',
            $fontStyleName,'docsTitle'
        );
        $section->addText('',
            $fontStyleName,'docsTitle'
        );
        $phpWord->addParagraphStyle('signatory', ['spacing' => 120,'lineHeight'=>1,'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)]);

        $section->addText("                                                               ".$prepared_by,
            'letterToFontStyle','bodyParaStyle','signatory'
        );
        $section->addText('                                                        Provincial Planning and Development Coordinator',
            $fontStyleName,'docsTitle','signatory'
        );
         

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Letter1.docx');
        $path = Yii::getAlias('@webroot').'/Letter1.docx';
        $name = 'Letter of Review for PPDO.docx';
        return Yii::$app->response->sendFile($path, $name);
?>
