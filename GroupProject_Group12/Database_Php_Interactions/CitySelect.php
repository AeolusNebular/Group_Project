<?php

    

    $db = Open_Database();

    $result = $db -> query("SELECT * FROM City ORDER BY City_Name");
    

    while ($row = $result -> fetchArray(SQLITE3_ASSOC)){
        $CityName = $row['City_Name'];
        
        echo "<option value='$CityName' > " . $CityName . "</option>";

    }
    $db -> close();
?>