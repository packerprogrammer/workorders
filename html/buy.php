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
        
        // look up the symbol the user entered
        $stock = lookup($_POST["symbol"]);
        
        if ($stock == false)
        {
            apologize("Invalid Symbol");
        }
        
        // validate share quantity
        if (!(preg_match("/^\d+$/", $_POST["shares"])))
        {
            apologize("Invalid Shares");
        }
        else
        {
            // calculate current cash value of the stock they are buying
            $value = $_POST["shares"] * $stock["price"];
            
            // see how much cash the user has to spend
            $result = query("SELECT cash FROM users WHERE id = ?",$_SESSION["id"]);
            
            // handle database error
            if ($result === "false")
            {
                apologize("couldn't find your cash?");
            }  
            
            // handle if user is too poor
            if ($result[0]["cash"] < $value)
            {
                apologize("not enough funds");
            }
            else
            {            
                // update their cash
                $result = query("UPDATE users SET cash = cash - ? WHERE id = ?",$value,$_SESSION["id"]);
            
                if ($result === "false")
                {
                    apologize("could not update cash");
                } 
            
                // convert symbol to uppercase
                $upperSymbol = strtoupper($_POST["symbol"]);
            
                // Update portfolio table with new stock                   
                $result = query("INSERT INTO portfolio (id, symbol, shares) VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)",$_SESSION["id"],$upperSymbol,$_POST["shares"]);
            
                if ($result === "false")
                {
                    apologize("could not update portfolio");
                }
            
                // log the transaction
                addLog($_SESSION["id"],true,$upperSymbol,$_POST["shares"],$stock["price"]);
                
                // render portfolio
                $positions = getPortfolio($_SESSION["id"]);
                render("portfolio.php", ["title" => "Portfolio","positions" => $positions]);
            }
        }   

    }
    else
    {
        // else render form
        render("buy_form.php", ["title" => "Buy Shares"]);
              
    }

?>
