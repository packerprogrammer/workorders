<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
print_r($_SESSION);
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        // configuration
        require ("includes/config.php");
        render("getserial.php", ["title" => "Get Serial Number"]);
    } else {
        echo "Please log in first to see this page.";
    }

