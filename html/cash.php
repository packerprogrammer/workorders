<?php

    // configuration
    require("../includes/config.php"); 

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["cash"]))
        {
            apologize("You must provide a cash amount.");
        }
        
        // Don't allow more than 10000 deposits...because i said so.
        if ($_POST["cash"] > 10000)
        {
            apologize("I doubt you have more than $10,000 lying around, try again.");
        }
       
        // sorry you can't withrdrawl money...muah hahaha
        if ($_POST["cash"] <= 0)
        {
            apologize("Please enter a positive cash amount...");
        }
        
        // update the users cash
        $result = query("UPDATE users SET cash = cash + ? WHERE id = ?",$_POST["cash"],$_SESSION["id"]);
        if ($result === false)
        {
            apologize("Error trying to update cash");
        }        
        
        // render portfolio
        $positions = getPortfolio($_SESSION["id"]);
        render("portfolio.php", ["title" => "Portfolio","positions" => $positions]);
        
    }
    else
    {
        // else render form
        render("cash_form.php", ["title" => "Add Cash"]);
              
    }

?>
