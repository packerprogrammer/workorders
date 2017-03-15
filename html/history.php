<?php

    // configuration
    require("../includes/config.php"); 
    
    // get the users history from the database    
    $result = query("SELECT * FROM translog where ID = ?",$_SESSION["id"]);
    if ($result === false)
    {
        apologize("Could not get log data");
    }
    
    // handle if the user has no history
    if ($result == false)
    {
        apologize("No History found");
    }
    
    // add the resultset to an associative array
    foreach ($result as $row)
    {
        if ($row["type"] == 0)
        {
            $trans = "SELL"; // sell is stored as boolean 0 or false
        }
        else
        {
            $trans = "BUY"; // buy is stored as boolean 1 or true
        }
        $positions[] = [
            "transaction" => $trans,
            "price" => $row["price"],
            "shares" => $row["shares"],
            "symbol" => $row["symbol"],
            "time" => $row["datetime"]
        ];
    }
    
    // render history
    render("display_history.php", ["title" => "History","positions" => $positions]);
    
?>
