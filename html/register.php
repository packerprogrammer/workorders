<?php

    // configuration
    require("../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // insert the user into the users table
        $result = query("INSERT INTO users (username, hash, cash) VALUES(?, ?, 10000.00)", $_POST["username"], crypt($_POST["password"]));
        if ($result === false)
        {
            apologize("Username may already exist...");
            
        }
        
        // get the id for the user just inserted
        $rows = query("SELECT LAST_INSERT_ID() AS id"); 
        $id = $rows[0]["id"];
            
        // remember that user's now logged in by storing user's ID in session
        $_SESSION["id"] = $id;
        
        // redirect to portfolio
        redirect("/");
        
    }
    else
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

?>
