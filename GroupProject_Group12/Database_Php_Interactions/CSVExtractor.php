<?php      
        $FirstLine = true;
        $CSVfilter = array($GetFilter);
        $words = array_map('preg_quote', $CSVfilter);
        $regex = '/'.implode('|', $words).'/';
        $NoOfCities = array();

        foreach ($CSVfilter as $x) {
            $NoOfCities[$x] = [];
        }
    
        $fp = fopen ( "../CSV_Files/". $TypeOfCSV ."/". $Network ."_". $TypeOfCSV ."_". $Year .".csv" , "r" );       
        $Values = [];

        while (( $data = fgetcsv( $fp )) !== FALSE ) {
            if  ($FirstLine) {
                $FirstLine = false;
                continue;
            }
            list($net_manager,$purchase_area,$street,$zipcode_from,$zipcode_to,$city,$num_connections,$delivery_perc,$perc_of_active_connections,$type_conn_perc,$type_of_connection,$annual_consume,$annual_consume_lowtarif_perc,$smartmeter_perc) = $data;         
            if (preg_match($regex, $city)) {
                $NoOfCities[$city][] = $data;
            }           
            if (!isset($Values[$city])) {
                $Values[$city] = 0;
            }
            
            $Values[$city] = $Values[$city] + intval($annual_consume);
            
        } 
        //debug_to_console($Values['GOOR']);      
        fclose ( $fp );
        return $Values;
?>