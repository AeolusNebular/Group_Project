<?php
    
    // 🔗 Create database connection 
    $db = Open_Database();
    
    // Query selects all city names from table city in DB and Orders by city Name
    $result = $db -> query("SELECT * FROM City ORDER BY City_Name");
    
    // 🔄Loops through every row of db and saves to City name variable 
    while ($row = $result -> fetchArray(SQLITE3_ASSOC)){
        $CityName = $row['City_Name'];
        
        // Echos into a option value *Note must be paired with select statement to work correctly*
        echo "<option value='$CityName' > " . $CityName . "</option>";
    }
    // 🔒 Close database
    $db -> close();
    
?>