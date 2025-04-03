<?php
require('../fpdf186/fpdf.php');
include('../Database_Php_Interactions/Database_Utilities.php');

class PDF extends FPDF {
    
    // Table
    function BasicTable($header, $data)
    {
        
        $this->SetFont('Arial','B',12);
        // Header
        foreach($header as $col){
            $this->Cell(35,7,$col,1);
        }
        $this->Ln(); // New line after print the header
        
        $this->SetFont('Arial','',12);
        // Data
        foreach($data as $ConsumeType => $Cities)
        {   
            $this->Cell(35, 7, 'Cities', 1);
            foreach($Cities as $City =>  $data ) {                            
                $this->Cell(35,7,$City,1);
            }
            $this->Ln();
            $this->Cell(35, 7, $ConsumeType, 1);
            foreach($Cities as $City =>  $data ) {
                               
                $this->Cell(35,7,$data,1);
            }
            $this->Ln();
        
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' ) {
    
    if (isset($_POST['CityValuesForPDF'])) {
        $data = html_entity_decode($_POST['CityValuesForPDF']);
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
    $pdf->BasicTable($header,json_decode($data));
    $pdf->Output();
}
?>