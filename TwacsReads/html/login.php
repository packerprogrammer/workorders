<?php

    // configuration
    require("../includes/config.php"); 
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["username"]))
        {
            // render blank page for styling
            render("blank.php");
            apologize("You must provide your username.");
        }
        else if (empty($_POST["password"]))
        {
            // render blank page for styling
            render("blank.php");
            
            apologize("You must provide your password.");
        }
        
        $ldapuser = "glps\\" . strtolower($_POST["username"]);
        $ldappass = $_POST["password"];
        
        
        $ldapconn = ldap_connect("10.6.16.200") or die("Could not connect to LDAP Server.");
        //echo 'good here';
        if ($bind = ldap_bind($ldapconn, $ldapuser,$ldappass)) {
           // remember that user's now logged in by storing user's ID in session
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $_POST["username"];
                // redirect to home
                redirect("/index.php");
            
        }
        else
        {
            // render blank page for styling
            render("blank.php");
            
            apologize("Invalid username or password");
        }
        
    }
    else
    {
        // else render form
        render("login_form.php", ["title" => "Log In"]);
    }

?>
