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
        $section->addText("        This Office acknowledges receipt of the GAD Plan and Budget (GPB) FY ".$arrCategory7[3]." of ".$arrCategory7[4].". We, however, defer endorsement of the same to the DILG Office due to the following general observations and recommendations:",
            'letterToFontStyle','bodyParaStyle'
        );
        $section->addText('',
            $fontStyleName,'docsTitle'
        );
        foreach ($queryCatCom as $key => $row) {
            $section->addText('           '.$row["value"],
                $fontStyleName
            );
        }
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
        $section->addText('                                                                     '.$arrCategory7[5],
            $fontStyleName,'docsTitle','signatory'
        );
         $section->addText("                                                              ".$arrCategory7[6].", ".$arrCategory7[4]." ",
            'letterToFontStyle','bodyParaStyle','signatory'
        );

        $file = 'Letter1.docx';
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $xmlWriter->save($file);
        $xmlWriter->save("php://output");

?>