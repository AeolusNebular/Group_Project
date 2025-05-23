<?php
    function CSVData($TypeOfCSV,$Year,$Network) {
            
        $FirstLine = true; 

        // Variable that acts as the file path as well as the open condition with assigned variables from above to allow for dynamic file choice
        $fp = fopen ( "../CSV_Files/". $TypeOfCSV ."/". $Network ."_". $TypeOfCSV ."_". $Year .".csv" , "r" );
               
        // Assigns values to empty array
        $Values = [];
    
        
        // 🔄 Loops through all lines of CSV while end of file isn't reached
        while (( $data = fgetcsv( $fp )) !== FALSE ) {
            // Skips the first line as it is full of all the headings then continues the loop starting from second line
            if  ($FirstLine) {
                $FirstLine = false;
                continue;
            }

            // Assigns all values of data to a list of all columns of the CSV to pick and choose from
            list($net_manager,$purchase_area,$street,$zipcode_from,$zipcode_to,$city,$num_connections,$delivery_perc,$perc_of_active_connections,$type_conn_perc,$type_of_connection,$annual_consume,$annual_consume_lowtarif_perc,$smartmeter_perc) = $data;

            // If value for the city is not Set set it to the annual cost and num of connections *Can implement more if needed*
            if (!isset($Values[$city])) {
                $Values[$city] = array(intval($annual_consume), $num_connections, $delivery_perc, $type_conn_perc);
            } else {
                $TempCity = $Values[$city];
                $TempCity[0] += intval($annual_consume);
                $TempCity[1] += intval($num_connections);  
                $TempCity[2] += intval($delivery_perc);  
               
                $Values[$city] = $TempCity;            
            }                
        } 
        // 📁 Close file and return array values
        fclose ( $fp );
        return $Values;
    }
    
    function FilterByCityCSV($TypeOfCSV,$Year,$Network,$GetFilter) {
        $FirstLine = true;
        $CSVfilter = array(strtoupper($GetFilter));
        $words = array_map('preg_quote', $CSVfilter);
        $regex = '/'.implode('|', $words).'/';
        $NoOfCities = array();
        
        $fp = fopen ( "../CSV_Files/". $TypeOfCSV ."/". $Network ."_". $TypeOfCSV ."_". $Year .".csv" , "r" );       
        $Values = [];
        
        while (( $data = fgetcsv( $fp )) !== FALSE ) {
            if  ($FirstLine) {
                $FirstLine = false;
                continue;
            }
            list($net_manager,$purchase_area,$street,$zipcode_from,$zipcode_to,$city,$num_connections,$delivery_perc,$perc_of_active_connections,$type_conn_perc,$type_of_connection,$annual_consume,$annual_consume_lowtarif_perc,$smartmeter_perc) = $data;                    
            if (preg_match($regex, $city)) {
                if (!isset($NoOfCities[$city])) {
                    $NoOfCities[$city] = [];
                }
                $NoOfCities[$city] = $data;
            }
            
        }
        
        /* foreach ($NoOfCities as $Key => $City) {
            foreach ($City as $Data => $Value) {
                debug_to_console($Value);
            }
            
        }
        */
        
        fclose ( $fp );
        return $NoOfCities;
    }
?>