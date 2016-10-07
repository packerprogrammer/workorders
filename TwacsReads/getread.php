<?php

//configuration
require ("includes/config.php");


$readserial = $_GET["serial"];
$reqtype = $_GET["reqtype"];

//echo "test";
$read = [];
$read = getread($readserial,$reqtype);

if (empty($read)) {
    //echo '<p>Still Waiting...</p>';
}
else
{
render("printreads.php", ["title" => "Printing KWH Value","read" => $read]);
}
?>

