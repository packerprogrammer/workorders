<?php
    require ("../includes/config.php");
   
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        // configuration
        echo "hello, " . $_SESSION["username"]; 
        render("getserial.php", ["title" => "Get Serial Number"]);
    } else {
        echo "Please log in first to see this page.";
    }
    
?>    


