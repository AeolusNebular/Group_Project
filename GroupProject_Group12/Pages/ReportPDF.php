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




//access csv here

function CSVData($TypeOfCSV,$Year,$Network) {
            
    $FirstLine = true; 
    $fp = fopen ( "../CSV_Files/". $TypeOfCSV ."/". $Network ."_". $TypeOfCSV ."_". $Year .".csv" , "r" );
           
    // Assigns Values to a empty array
    $Values = [];
    
    while (( $data = fgetcsv( $fp )) !== FALSE ) {
        if  ($FirstLine) {
            $FirstLine = false;
            continue;
        }

        list($net_manager,$purchase_area,$street,$zipcode_from,$zipcode_to,$city,$num_connections,$delivery_perc,$perc_of_active_connections,$type_conn_perc,$type_of_connection,$annual_consume,$annual_consume_lowtarif_perc,$smartmeter_perc) = $data;

        if (!isset($Values[$city])) {
            $Values[$city] = array(intval($annual_consume), $num_connections);
        } else {
            $TempCity = $Values[$city];
            $TempCity[0] += intval($annual_consume);
            $TempCity[1] += intval($num_connections);  
            $Values[$city] = $TempCity;            
        }                
    }      
    fclose ( $fp );
    return $Values;     
}





//writes pdf
$pdf = new PDF(); //create an object of PDF
$pdf->SetFont('Arial','B',12);

$pdf->AddPage();
$pdf->Cell(60,25,'List');
$pdf->Ln(25);
$pdf->SetFont('Arial','',12);
$header = array("NetManager","Purchase Area","Street","Zipcode_From","Zipcode To", "City", "num_connections", "delivery_perc", "perc_of_active_connections","type_conn_perc", "type_of_connection", "annual_consume", "annual_consume_lowtarif_perc", "smartmeter_perc");

$pdf->BasicTable($header,$res);
$pdf->Output();
