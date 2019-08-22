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
        $phpWord->addParagraphStyle('docsTitle', ['align'=>'left']);
        $section->addText('SPECIFIC OBSERVATION AND RECOMMENDATION',
            $fontStyleName,'docsTitle'  
        );

        $section->addText('GAD Plan and Budget',
            $fontStyleName,'docsTitle'  
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
        $table->addCell(3000, $fancyTableCellStyle)->addText('SECTION', $fancyTableFontStyle,$cellstyle);
        $table->addCell(6000, $fancyTableCellStyle)->addText('OBSERVATION AND RECOMMENDATION', $fancyTableFontStyle,$cellstyle);

        // $count_table_row = 0;
        // print_r($qryComment); exit;
        foreach ($qryCommentGadPlan as $key => $row) {
            $table->addRow();
            $table->addCell(3000)->addText("Row ".$row["row_no"].". <w:br/>".(DocumentController::WrapText(DocumentController::ChangeAmpersand($row['row_value']))));
            $table->addCell(6000)->addText("Column ".$row["column_no"].". ".(DocumentController::WrapText(DocumentController::ChangeAmpersand($row['column_value'])))." ".DocumentController::WrapText(DocumentController::ChangeAmpersand($row['comment_value'])));
        }
        // --------------------- Table End

        $section->addTextBreak(2);
        $section->addText('ATTRIBUTED PROGRAMS',
            $fontStyleName,'docsTitle'  
        );
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
        $table->addCell(3000, $fancyTableCellStyle)->addText('SECTION', $fancyTableFontStyle,$cellstyle);
        $table->addCell(6000, $fancyTableCellStyle)->addText('OBSERVATION AND RECOMMENDATION', $fancyTableFontStyle,$cellstyle);

        // $count_table_row = 0;
        // print_r($qryComment); exit;
        foreach ($qryCommentAttributed as $key1 => $row1) {
            $table->addRow();
            $table->addCell(3000)->addText("Row ".$row1["row_no"].". <w:br/>".(DocumentController::WrapText(DocumentController::ChangeAmpersand($row1['row_value']))));
            $table->addCell(6000)->addText("Column ".$row1["column_no"].". ".(DocumentController::WrapText(DocumentController::ChangeAmpersand($row1['column_value'])))." ".DocumentController::WrapText(DocumentController::ChangeAmpersand($row['comment_value'])));
        }
        // --------------------- Table End

        $section->addTextBreak(2);
        $section->addText("Reviewed by:",
            'letterToFontStyle','bodyParaStyle'
        );
        $section->addText('',
            $fontStyleName,'docsTitle'
        );
        $section->addText('',
            $fontStyleName,'docsTitle'
        );
        $phpWord->addParagraphStyle('signatory', ['spacing' => 120,'lineHeight'=>1,'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)]);

        $section->addText("(Full name)",
            'letterToFontStyle','bodyParaStyle','signatory'
        );
        $section->addText('(Position Title)',
            $fontStyleName,'docsTitle','signatory'
        );
         

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Letter1.docx');
        $path = Yii::getAlias('@webroot').'/Letter1.docx';
        $name = 'Specific Observation.docx';
        return Yii::$app->response->sendFile($path, $name);
?>