<?php

require('C:\xampp\htdocs\Group_Project\GroupProject_Group12\fpdf186\fpdf.php');

class PDF extends FPDF {

    // table
    function BasicTable($header, $data)
    {
        $this->SetFont('Arial','B',12);
        // Header
        foreach($header as $col){
            $this->Cell(35,7,$col,1);
        }
        $this->Ln(); //new line after print the header

        $this->SetFont('Arial','',12);
        // Data
        foreach($data as $row)
        {
            foreach($row as $col)
                $this->Cell(35,7,$col,1);
            $this->Ln();
        }
    }
}








//writes pdf
$pdf = new PDF(); //create an object of PDF
$pdf->SetFont('Arial','B',12);

$pdf->AddPage();
$pdf->Cell(60,25,'List');
$pdf->Ln(25);
$pdf->SetFont('Arial','',12);
$header = array("Net_Manager","Purchase_Area","Street","Zipcode_From","Zipcode To", "City", "num_connections", "delivery_perc", "perc_of_active_connections","type_conn_perc", "type_of_connection", "annual_consume", "annual_consume_lowtarif_perc", "smartmeter_perc");

$pdf->BasicTable($header, $data);
$pdf->Output();
