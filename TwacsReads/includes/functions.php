<?php
/***********************************************************************
     * functions.php
     *
     * twacs get read application 
     * 
     *
     * Helper functions.
     **********************************************************************/

require_once("constants.php");

/**
     * Apologizes to user with message.
     */
    function apologize($message)
    {
        //render("apology.php", ["message" => $message]);
        require("../templates/apology.php");
        exit;
    }

function dbconnect()
{
    $conn = oci_connect('dcsi', 'dcsi', '10.6.16.53:1521/ACLARA');
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
}

function dbclose()
{
    oci_free_statement($stid);
    oci_close($conn);
}

function getread($serialnumber,$reqtype)
{
    $reads = [];	
    // print '<h3 id="reading">Getting result for serial number: ' . $serialnumber . '</h3>';
    // echo "reqtype=" . $reqtype;
    $conn = oci_connect(USERNAME, PASSWORD, CONNECTION_STRING);
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    
    if ($reqtype == "last") {
        $systemdate = "trunc(sysdate)";
    }
    else {
        $systemdate = "sysdate-(10/1440)";
    }

    // Prepare the statement
    $stid = oci_parse($conn, "select TO_CHAR(mm.metermitreaddt, 'MM-DD-YYYY HH24:MI:SS') kwh_dt, "
            . "trunc(mm.metermitdata1*mc.meterconvkh/mc.meterconvdivisor/mc.meterconvmpd) kwh_read, "
            . "metermitqualitycode QC, "
            . "mm.metermitdata2/mc.meterconvdivisor/mc.meterconvmpd*mc.meterconvkh*mc.demmultiplier kW "
            . "from metermitresponselogdata mm, meterconv mc, meteraccts ma "
            . "where mm.serialnumber = ma.serialnumber and mc.metertype = ma.metertype and mm.metermitreaddt > $systemdate"
            . "and mm.metermitdata1id = 111 and mm.metermitdata2id in(112,125)"
            . "and mm.serialnumber = $serialnumber "
            . "union "
            . "select TO_CHAR(mm.metertcrespcurdatetime, 'MM-DD-YYYY HH24:MI:SS') kwh_dt, trunc(mm.metertcresptotalconsumpt*mc.meterconvkh/mc.meterconvdivisor) kwh_read, metertcrespqualitycode QC, null kW "
            . "from metertcresponselog mm, meterconv mc, meteraccts ma "
            . "where mm.serialnumber = ma.serialnumber and mc.metertype = ma.metertype and mm.metertcrespcurdatetime > $systemdate"
            . "and mm.serialnumber = $serialnumber");
    if (!$stid) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Perform the logic of the query
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    
    $numrows = 0;
          
    
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	//var_dump($row);
        //echo "<tr>\n";
        $numrows = $numrows + 1;
	//foreach ($row as $item) {
            $reads[$numrows] = [
		"date" => $row['KWH_DT'],
		"read" => $row['KWH_READ'],
                "kw" => $row['KW'],
                "qc" => $row['QC']
	    ];
            
        //}
    }
    
    oci_free_statement($stid);
    oci_close($conn);
    
    return $reads;	
}
/*
 * This function takes a serial number and does an insert on the database to send a read
 * request. 
 */
function sendrequest($serialnumber)
{
    $reads = [];
    //print '<h3>Sending read command for serial number: ' . $serialnumber . '</h3>';
    $conn = oci_connect(USERNAME, PASSWORD, CONNECTION_STRING);
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Prepare the statement
    $stid = oci_parse($conn, "select mc.meterconvmit ID from meterconv mc, meteraccts ma where mc.metertype=ma.metertype "
            . "and ma.serialnumber = $serialnumber"); 
    if (!$stid) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Perform the logic of the query    
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    
    $numrows = 0;
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    //var_dump($row);
        $numrows = $numrows + 1;
        foreach ($row as $item) {
            $id = $row['ID'];
        }
    }
       
    if ($numrows < 1) { 
        //echo "Serial number not found.";
        apologize("Serial number not found");
    }

    if ($id == 0) {
        $cmd = "ONREQ";
    }
    elseif ($id == 3) {
        $cmd = "ALTIMUSONREQUEST";
    }
    oci_free_statement($stid);
    $stid = oci_parse($conn, "INSERT INTO meter_inpq(subsysid, priority,stamp,username,groupid,pri,cmddata) values ('30', '100', SYSDATE, 'DCSI', 555555, '100', '$cmd|1|$serialnumber|0|2|1|0')");
    if (!$stid) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Perform the logic of the query    
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    oci_free_statement($stid);
    oci_close($conn);

    
}


     /**
     * Renders template, passing in values.
     */
    function render($template, $values = [])
    {
        // if template exists, render it
        if (file_exists("../templates/$template"))
        {
            // extract variables into local scope
            extract($values);
            
            // render header
            require("../templates/header.php");

            // render menu
            // require("templates/menu.php");

            // render template
            require("../templates/$template");

            // render footer
            //require("templates/footer.php");
        }

        // else err
        else
        {
            trigger_error("Invalid template: $template", E_USER_ERROR);
        }
    }
    /**
     * Redirects user to destination, which can be
     * a URL or a relative path on the local host.
     *
     * Because this function outputs an HTTP header, it
     * must be called before caller outputs any HTML.
     */
    function redirect($destination)
    {
        // handle URL
        if (preg_match("/^https?:\/\//", $destination))
        {
            header("Location: " . $destination);
        }

        // handle absolute path
        else if (preg_match("/^\//", $destination))
        {
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            header("Location: $protocol://$host$destination");
        }

        // handle relative path
        else
        {
            // adapted from http://www.php.net/header
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            header("Location: $protocol://$host$path/$destination");
        }

        // exit immediately since we're redirecting anyway
        exit;
    }
    
    
    // verifies if serialnumber exists in serialnumber table
    function serialexists($serialnumber)
    {	
    $conn = oci_connect(USERNAME, PASSWORD, CONNECTION_STRING);
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    
    // Prepare the statement
    $stid = oci_parse($conn, "select serialnumber from serialnumber where serialnumber = $serialnumber");
    if (!$stid) {
        $e = oci_error($conn);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Perform the logic of the query
    $r = oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }
    
    $numrows = 0;
          
    
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
        $numrows = $numrows + 1;
    }

    oci_free_statement($stid);
    oci_close($conn);
     if ($numrows > 0) {
        return true;
    }
    else {
        return false;
    }
    	
}

/**
     * Logs out current user, if any.  Based on Example #1 at
     * http://us.php.net/manual/en/function.session-destroy.php.
     */
    function logout()
    {
        // unset any session variables
        $_SESSION = array();

        // expire cookie
        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 42000);
        }

        // destroy session
        session_destroy();
    }




?>
