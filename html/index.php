<?php

    // configuration
    require("../includes/config.php"); 
    // if the multiple pages checkbox is selected then set flag to return multiple const. summary pages
    if (isset($_GET["constr"]))
    {
    	$pages = 1;
    }
    else
    {
	$pages = 0;
    }	
    // if form was submitted
    if (isset($_GET['string']))
    {
	
        // validate submission
        if (empty($_GET["string"]))
        {
            apologize("You must provide a search item.");
        }
	$myquery = $_GET["string"];
	
	if (isset($_GET['orderby']))
	{
	    $sortby = $_GET["orderby"];
	}
	else
	{
	    $sortby = "order_no";
	}
	$dir = null;
	if (isset($_GET["dir"]))
	{
	    $dir = $_GET["dir"];	
	}
	else
	{
	    $dir = "ASC";    	
	}
        $positions = getWorkOrders(["query" => $myquery,"sortby" => $sortby, "dir" => $dir]); 
	if (isset($_GET["dir"]))
        {    
	    if ($_GET["dir"] == "ASC") 
	    {
	   	$dir = "DESC";
	    }
	    else 
	    {	
		$dir = "ASC";
	    }	   
	}
        render("orders.php", ["title" => "Search","positions" => $positions,"prev" => $myquery,"dir" => $dir,"pages" => $pages]);
    }
    else if (!empty($_GET["orderby"]) && !empty($_GET["dir"]))
    {	
	
	
	$sortby = $_GET["orderby"];
	
	$dir = $_GET["dir"];	
	$positions = getWorkOrders(["sortby" => $sortby,"dir" => $dir]);

	if ($dir == "ASC") 
	{
	    $dir = "DESC";
	}
	else 
	{	
	    $dir = "ASC";
	}	
    	render("orders.php", ["title" => "List All","positions" => $positions,"dir" => $dir]);
    }
    else
    {
	$dir = "ASC";
	$sortby = "order_no";	
	$positions = getWorkOrders(["sortby" => $sortby,"dir" => $dir]);
	render("orders.php", ["title" => "List All","positions" => $positions,"dir" => $dir,"pages" => $pages]);
    	
    }
?>
