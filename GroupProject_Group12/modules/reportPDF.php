<?php
require('../fpdf186/fpdf.php');
include('../Database_Php_Interactions/Database_Utilities.php');

class PDF extends FPDF {
    
    // Table
    function BasicTable($header, $data)
    {
        $FirstHeader = true;
        $this->SetFont('Arial','B',12);
        // Header
        foreach($header as $col){
            if ($FirstHeader){
                $this->Cell(80,7,$col,1);
                $FirstHeader = false;
            } else {
                $this->Cell(35,7,$col,1);
            }
        }
        $this->Ln(); // New line after print the header
        
        $this->SetFont('Arial','',12);
        // Data
        foreach($data as $City => $CityConsumes)
        {   
            
            $this->Cell(80, 7, $City, 1);
            foreach($CityConsumes as $ConsumeType =>  $Value ) {                            
                $this->Cell(35,7,$Value,1);
            }
            $this->Ln();
        
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    
    if (isset($_POST['CityValuesForPDF'])) {
        $data = html_entity_decode($_POST['CityValuesForPDF']);
    }
    $DecodedData = json_decode($data);
    $CityValuesinArray = [];
    foreach ($DecodedData as $ConsumeType => $CityConsumes){
        //['City','Electricity','Gas']
        foreach ($CityConsumes as $City => $CityConsumeValue) {
            if (!isset($CityValuesinArray[$City])) {
                $CityValuesinArray[$City] = [];
            } 
            // EG [GOOR][ELECTRICITY,GAS][241241,321454]
            $CityValuesinArray[$City][$ConsumeType] = $CityConsumeValue; 
        }
    }

    $pdf = new PDF(); // 📄 Create PDF object
    $pdf->SetFont('Arial','B',12);
    
    $pdf->AddPage();
    $pdf->Cell(60,25,'Energy Costs');
    $pdf->Ln(25);
    $pdf->SetFont('Arial','',12);
    $header = array("City","Gas","Electricity");
    $base64Image = $_POST['ImageURLForPDF'];

    if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
        $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
        $imageType = $type[1];
        $decodedImage = base64_decode($base64Image);
    
        if ($decodedImage === false) {
            die('Base64 decode failed');
        } 

        $imageFilePath = '../Images/Report.jpg';

        file_put_contents($imageFilePath, $decodedImage);
        
    }
    $pdf->Image($imageFilePath, 10, 10, 190);
    $pdf->Ln(90);
    $pdf->BasicTable($header,$CityValuesinArray);
    $pdf->Output();
}
?>