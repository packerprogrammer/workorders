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
        else
        {
            // get current value of shares of stock
            $result = query("SELECT shares FROM portfolio where id = ? and symbol = ?", $_SESSION["id"],$stock["symbol"]);
            if ($result === "false")
            {
                apologize("you have no stock to sell");
            }
            
            // store the number of users shares for future use
            $shares = $result[0]["shares"];
            
            // store the value of the share
            $value = $shares * $stock["price"];
          
            // delete the stock from the users portfolo
            $result = query("DELETE FROM portfolio WHERE id = ?  AND symbol = ?",$_SESSION["id"],$stock["symbol"]);
            if ($result === "false")
            {
                apologize("could not sell stock");
            }  
            
            // update the users cash
            $result = query("UPDATE users SET cash = cash + ? WHERE id = ?",$value,$_SESSION["id"]);
            if ($result === "false")
            {
                apologize("could not add cash");
            } 
            
            // log the transaction
            addLog($_SESSION["id"],false,$stock["symbol"],$shares,$stock["price"]);
            
            // render portfolio
            $positions = getPortfolio($_SESSION["id"]);
            render("portfolio.php", ["title" => "Portfolio","positions" => $positions]);

        }

    }
    else
    {
        // get the symbols available to sell
        $result = query("SELECT symbol FROM portfolio WHERE id = ?", $_SESSION["id"]);
        
        if ($result === "false")
        {
            apologize("you have no stock to sell");
        }
        else
        {
            foreach ($result as $row)
            {
                $symbols[] = $row["symbol"];
            } 
           
            // else render form
            render("sell_form.php", ["title" => "Sell Shares","symbols" => $symbols]);
        }    
            
        
    }

?>
