<?php
    require('../fpdf186/fpdf.php');
    
    class PDF extends FPDF {
        // 📦 Fill full-page background
        function AddBackground($r, $g, $b) {
            $this->SetFillColor($r, $g, $b);
            $this->Rect(0, 0, 210, 297, 'F'); // A4 size
        }
        
        // 📋 Table renderer
        function BasicTable($header, $data)
        {
            $this->SetFont('Arial','B',12);
            $FirstHeader = true;
            
            // Header
            foreach ($header as $col) {
                if ($FirstHeader) {
                    $this->Cell(80, 7, $col, 1);
                    $FirstHeader = false;
                } else {
                    $this->Cell(35, 7, $col, 1);
                }
            }
            $this->Ln();
            
            $this->SetFont('Arial','',12);
            // Data rows
            foreach ($data as $City => $CityConsumes) {
                $this->Cell(80, 7, $City, 1);
                if (isset($CityConsumes['Gas'])) {
                    $this->Cell(35, 7, $CityConsumes['Gas'], 1);
                } else {
                    $this->Cell(35, 7, 0, 1);
                }

                if (isset($CityConsumes['Electricity'])) {
                    $this->Cell(35, 7, $CityConsumes['Electricity'], 1);
                } else {
                    $this->Cell(35, 7, 0, 1);
                }
                
                // foreach ($CityConsumes as $ConsumeType => $Value) {
                //     $this->Cell(35, 7, $Value, 1);
                // }
                $this->Ln();
            }
        }
    }
    
    // 🔁 Only run when form submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // 📨 Get posted data
        $data = isset($_POST['ValuesForPDF']) ? html_entity_decode($_POST['ValuesForPDF']) : '';
        $DecodedData = json_decode($data, true);
        $CityValuesinArray = [];
        
        foreach ($DecodedData as $ConsumeType => $CityConsumes) {
            foreach ($CityConsumes as $City => $CityConsumeValue) {
                if (!isset($CityValuesinArray[$City])) {
                    $CityValuesinArray[$City] = [];
                }
                $CityValuesinArray[$City][$ConsumeType] = $CityConsumeValue;
            }
        }
        
        // 🎨 Detect theme mode from frontend
        $themeMode = $_POST['ThemeModeForPDF'] ?? 'light';
        
        // 🎯 CSS var equivalents in RGB
        $cssVars = [
            'light' => [255, 255, 255],
            'dark'  => [34, 34, 34]
        ];
        
        $bgRGB = $cssVars[$themeMode] ?? [255, 255, 255];
        
        // 📝 Create and configure PDF
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->AddBackground(...$bgRGB);
        
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(60, 15, 'Energy Costs');
        $pdf->Ln(20);
        
        // 🖼️ Embed chart image
        $base64Image = $_POST['ImageURLForPDF'];
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
            $imageType = $type[1];
            $decodedImage = base64_decode($base64Image);
            
            if ($decodedImage !== false) {
                $imageFilePath = '../Images/Report.jpg';
                file_put_contents($imageFilePath, $decodedImage);
                $pdf->Image($imageFilePath, 10, 35, 190); // Fit to page width
                $pdf->Ln(100);
            }
        }
        
        // 📊 Render table
        $header = ['City', 'Gas', 'Electricity'];
        $pdf->SetFont('Arial', '', 12);
        $pdf->BasicTable($header, $CityValuesinArray);
        
        // 💾 Output PDF
        $pdf->Output();
    }