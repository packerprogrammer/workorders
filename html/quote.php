<?php

    // configuration
    require("../includes/config.php"); 

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["symbol"]))
        {
            apologize("You must provide a symbol name.");
        }
        
        // get the stock symbol info
        $stock = lookup($_POST["symbol"]);
        
        if ($stock == false)
        {
            apologize("Invalid Symbol");
        }
        
        // sho the symbol form
        else
        {
            render("symbol_form.php", ["title" => "Your Quote","cost" => $stock["price"],
                "symbol" => $stock["symbol"],"name" => $stock["name"]]);
        }

    }
    else
    {
        // else render form
        render("lookup_form.php", ["title" => "Symbol Lookup"]);
    }

?>
