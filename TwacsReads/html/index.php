<script>
function myFunction() {
    console.log ("test");
    location.href = "zxing://scan/?ret=http%3A%2F%2Ftwacs.glps.net%2Findex.php?serial=%7BCODE%7D&SCAN_FORMATS=CODE_39";
}
</script>

<?php

    // configuration
    require ("../includes/config.php");
        
    $serial = $_GET["serial"];    
    render("getserial.php", ["title" => "Get Serial Number","serial" => $serial]);
   
?>    


