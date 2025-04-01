<?php

require('../fpdf186/fpdf.php');

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