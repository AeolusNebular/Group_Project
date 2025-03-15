<?php  
    function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);                        
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }


    function Open_Database() {
        try  { 
            $db = new SQLite3('../database/users.db');
        
            if ($db) {
                echo "<script> console.log('Database Opened Successfully') </script>";
            } else {
                echo "<script> console.log('Failed to open Database : " . $db -> lastErrorMsg() ."') </script>";
                exit;
            }
        } catch (Exception $e) {
            debug_to_console(  $e->getMessage());
        }
        return $db;
    }
   
    function Execute_N_Close($db , $stmt , $Success , $Failed) {
        
        $Q_Res = false;
        do{
            $Q_Res = $stmt -> execute();

            if ($Q_Res) {
                debug_to_console($Success);
                
            }   else {
                debug_to_console( $Failed . $db -> lastErrorMsg());
            }
            
        } while (!$Q_Res);

        do{
            $Q_Res = $db-> exec('COMMIT');

            if ($Q_Res) {
                debug_to_console("Commited Successfully");
                
            }   else {
                debug_to_console("Failed to Commit");
            }
            
        } while (!$Q_Res);
            
        $db -> close();   

    }

?>