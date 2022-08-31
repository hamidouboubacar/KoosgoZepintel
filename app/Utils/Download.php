<?php

namespace App\Utils;

use App\Models\Facture;

class Download 
{
    public static function facture(Facture $facture) {
        \PhpOffice\PhpWord\Settings::setZipClass(\PhpOffice\PhpWord\Settings::PCLZIP);
        
        $wordTest = new \PhpOffice\PhpWord\PhpWord();
        
        $section = $wordTest->addSection();
        
        $section->addText("Facture proformat #FP0004", array("bold" => true));
        $section->addText("25 Janvier 2022");
        $section->addTextBreak();
        
        // $section->addText("De");
        $section->addText("NETFORCE SARL", array("bold" => true));
        $section->addText("Tanghin, Ouagadougou Burkina Faso");
        $section->addText("Tel: +226 74 26 62 00");
        $section->addText("Email: commercial@netforce-group.com");
        $section->addTextBreak();
        
        // Ajouter le table
        $table = $section->addTable(array(
            'borderColor' => 'FFFFFF',
            'borderSize'  => 6,
            'cellMargin'  => 250,
            'align'       => 'right',
            'bgColor'     => '00BFFF',
            'width' => 100
        ));
        $table->addRow(50);
        $cell = $table->addCell();
        // $cell->addText("A", array(), array("alignment", \PhpOffice\PhpWord\SimpleType\Jc::END));
        $cell->addText("CLIENT", array("bold" => true));
        $cell->addText("Tanghin, Ouagadougou Burkina Faso", array(), array("alignment", \PhpOffice\PhpWord\SimpleType\Jc::RIGHT));
        $cell->addText("Tel: +226 74 26 62 00", array("alignment", \PhpOffice\PhpWord\SimpleType\Jc::CENTER), array("alignment", \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
        $cell->addText("Email: commercial@netforce-group.com", array("position", \PhpOffice\PhpWord\SimpleType\Jc::CENTER), array("position", \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
        $section->addTextBreak();
        
        // Ajouter le table
        $table = $section->addTable(array(
            'borderColor' => 'FFFFFF',
            'borderSize'  => 6,
            'cellMargin'  => 250,
            'align'       => 'center',
            'bgColor'     => '00BFFF',
            'width' => 100
        ));
        $table->addRow(50);
        $cellHeaderStyle = array('bgColor' => '00BFFF', 'color' => 'FFFFFF', 'width' => 1000);
        $textHeaderStyle = array('color' => 'FFFFFF', 'bold' => true);
        $cellHeight = 100;
        $table->addCell($cellHeight, $cellHeaderStyle)->addText("#", $textHeaderStyle);
        $table->addCell($cellHeight, $cellHeaderStyle)->addText("Designation", $textHeaderStyle);
        $table->addCell($cellHeight, $cellHeaderStyle)->addText("Débit", $textHeaderStyle);
        $table->addCell($cellHeight, $cellHeaderStyle)->addText("Quantité", $textHeaderStyle);
        $table->addCell($cellHeight, $cellHeaderStyle)->addText("Prix Unitaire", $textHeaderStyle);
        $table->addCell($cellHeight, $cellHeaderStyle)->addText("Montant", $textHeaderStyle);
        
        $table->addRow(50);
        $cellHeaderStyle = array('bgColor' => '00BFFF', 'color' => 'FFFFFF');
        $textHeaderStyle = array('color' => 'FFFFFF', 'bold' => true);
        $cellHeight = 100;
        $table->addCell()->addText("1");
        $table->addCell()->addText("Platinum");
        $table->addCell()->addText("4Mbps");
        $table->addCell()->addText("3");
        $table->addCell()->addText("30000");
        $table->addCell()->addText("90000");
        
        $table->addRow(50);
        $cellHeaderStyle = array('bgColor' => '00BFFF', 'color' => 'FFFFFF');
        $textHeaderStyle = array('color' => 'FFFFFF', 'bold' => true);
        $cellHeight = 100;
        $table->addCell()->addText("2");
        $table->addCell()->addText("Gold");
        $table->addCell()->addText("5Mbps");
        $table->addCell()->addText("5");
        $table->addCell()->addText("50000");
        $table->addCell()->addText("250000");
        
        $section->addTextBreak();
        $section->addText("TOTAL HT: $facture->montantht F", array("bold" => true, "underline" => true));
        if(isset($facture->tva) && !empty($facture->tva)) 
            $section->addText("TOTAL TVA: $facture->tva F", array("bold" => true, "underline" => true));
        $section->addText("TOTAL TTC: $facture->montantttc F", array("bold" => true, "underline" => true));
        
        $objectWriter = \PhpOffice\PhpWord\IOFactory::createWriter($wordTest, 'Word2007');
        $objectWriter->save(storage_path('facture.docx'));
        
        return response()->download(storage_path('facture.docx'));
    }
}