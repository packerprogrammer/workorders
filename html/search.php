<?php

    // configuration
    require("../includes/config.php"); 
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["string"]))
        {
            apologize("You must provide a search item.");
        }
    $positions = getWorkOrders(["query" => $_POST["string"]]);    
    render("orders.php", ["title" => "List All","positions" => $positions]);
    }
 
    
    

?>
