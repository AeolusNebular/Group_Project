<?php 
    session_start();
    session_unset();
    session_destroy();

    echo "<script>window.location.replace('/Group_Project/GroupProject_Group12/Pages/home.php') </script>";
    exit;
?>