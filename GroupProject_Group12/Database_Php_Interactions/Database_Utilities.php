<?php
    
    echo "<script>console.log('Database utilities triggered');</script>";
    
    // Function to write data into the console for error checking
    function debug_to_console($data) {
        // Assigns data given into local variable
        $output = $data;
        // Checks if variable is an array then implods (returns string of variable in array) and then Echos the problem into console
        if (is_array($output))
            $output = implode(',', $output);
        echo "<script>console.log('Debug Objects: " . $output . "');</script>";
    }
    
    // Function to open the data base *Note does not close connection*
    function Open_Database() {
        // Tries to open database, debugs to console on failure
        try  {
            
            // 🔗 Assigns database path to variable to be used later and creates connection
            $db = new SQLite3('../database/users.db');
            
            // If connection is made, console log database connection success, else shows error
            if ($db) {
                echo "<script> console.log('Database opened successfully') </script>";
            } else {
                echo "<script> console.log('Failed to open Database : " . $db -> lastErrorMsg() ."') </script>";
                exit;
            }
        } catch (Exception $e) {
            debug_to_console($e->getMessage());
        }
        // Returns database connection to use for queries
        return $db;
    }
    
?>