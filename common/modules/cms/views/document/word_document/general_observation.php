<?php
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
        $section->addText($arrCategory7[0],
            $fontStyleName,'dateStyle'
        );

        $phpWord->addFontStyle(
            'letterToFontStyle',
            array('name' => 'Verdana', 'size' => 11, 'color' => 'black')
        );
        $phpWord->addParagraphStyle('letterTo', ['align'=>'left','spacing' => 120,'lineHeight'=>1,'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0)]);
        $section->addText("Hon. ".$approvedBy,
            'letterToFontStyle','letterTo'
        );
        $section->addText("Mayor",
            'letterToFontStyle','letterTo'
        );
        $section->addText($arrCategory7[2],
            'letterToFontStyle','letterTo'
        );

        $section->addText('',
            $fontStyleName,'docsTitle'
        );
        $section->addText('',
            $fontStyleName,'docsTitle'
        );

        $section->addText("Dear ".$arrCategory7[1],
            'letterToFontStyle','letterTo'
        );
        $section->addText('',
            $fontStyleName,'docsTitle'
        );

        $phpWord->addParagraphStyle('bodyParaStyle',[]);
        $section->addText("        This Office acknowledges receipt of the GAD Plan and Budget (GPB) FY ".$arrCategory7[3]." of your LGU. We, however, defer endorsement of the same due to the following general observations and recommendations and enclosed/attached specific observations and recommendations:",
            'letterToFontStyle','bodyParaStyle'
        );
        $section->addText('',
            $fontStyleName,'docsTitle'
        );
        
        $cellstyle= array('align'=>'center','name' => 'Verdana', 'size' => 11);
        $header = array('size' => 16, 'bold' => true);
        // -------------------- Table Start
        // $section->addTextBreak(1);
        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => 'black', 'cellMargin' => 50, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'cellSpacing' => 1);
        $fancyTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => 'black', 'bgColor' => 'white');
        $fancyTableCellStyle = array('valign' => 'center');
        $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $fancyTableFontStyle = array('bold' => true);
        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
        $table = $section->addTable($fancyTableStyleName);
        $table->addRow(900);
        $table->addCell(500, $fancyTableCellStyle)->addText('No.', $fancyTableFontStyle,$cellstyle);
        $table->addCell(8500, $fancyTableCellStyle)->addText('General Observations and Recommendations', $fancyTableFontStyle,$cellstyle);

        $count_table_row = 0;
        foreach ($queryCatCom as $key => $row) {
            $count_table_row += 1;
            $table->addRow();
            $table->addCell(500)->addText("{$count_table_row}");
            $table->addCell(8500)->addText("{$row['value']}");
        }
        // --------------------- Table End

        $section->addText('',
            $fontStyleName,'docsTitle'
        );
        $section->addText("        In consultation with your GFPS (GAD Focal Point System), we strongly urge your   LGU to please comply with the indicated deficiencies within ten (10) working days after receipt of this letter or as soon as possible to give us time to review and issue a Certificate of Endorsement.",
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

        $section->addText("                                                              ".$arrCategory7[4]." ",
            'letterToFontStyle','bodyParaStyle','signatory'
        );
        $section->addText('                                                        '.$arrCategory7[5],
            $fontStyleName,'docsTitle','signatory'
        );
         

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Letter1.docx');
        $path = Yii::getAlias('@webroot').'/Letter1.docx';
        $name = 'General Observations and Recommendations.docx';
        return Yii::$app->response->sendFile($path, $name);
?>