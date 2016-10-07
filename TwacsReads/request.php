<script language="javascript">
// handles the click event for link 1, sends the query
var d = new Date();
var tbase = d.getTime() / 1000;
var myVar = setInterval(getOutput,3000);

function bob() {
    document.write('5');
}

function getOutput() {
    if (document.getElementById("reads") === null ) {
        var Serialurl = 'getread.php?serial=' + document.getElementById("serial").value + '&reqtype=' + document.getElementById("reqtype").value; 
        if (document.getElementById("getread") === null) {
            var header = document.createElement("h3");
            header.setAttribute("id","getread");
            var node = document.createTextNode("Getting result for serial number: " + document.getElementById("serial").value);
            header.appendChild(node);
            var mydiv = document.getElementById("header");
            mydiv.appendChild(header);
        } else {
            var txtWait = document.getElementById("getread").innerHTML;
            document.getElementById("getread").innerHTML = txtWait + " .";
            console.log (txtWait);
        } 
    //var Serialurl = "getread.php?serial=8667290";
    console.log (Serialurl);
    //document.write ('checking');
    //var x = 0;
    d = new Date();
    var tcurrent = d.getTime() / 1000;
    console.log (tbase);
    console.log (tcurrent);
    if (tcurrent - tbase > 120) {
        clearInterval(myVar);
    }    
    var x = 0
    x = x + 1;
    console.log(x);
    //document.write ('.');
    getRequest(
        Serialurl, // URL for the PHP file
        drawOutput,  // handle successful request
        drawError    // handle error
    );
  
  
        
    }
    return false;
  }
// handles drawing an error message
function drawError() {
    var container = document.getElementById('output');
    container.innerHTML = 'Bummer: there was an error!';
}
// handles the response, adds the html
function drawOutput(responseText) {
    var container = document.getElementById('output');
    container.innerHTML = responseText;
}
// helper function for cross-browser request object
function getRequest(url, success, error) {
    var req = false;
    try{
        // most browsers
        req = new XMLHttpRequest();
    } catch (e){
        // IE
        try{
            req = new ActiveXObject("Msxml2.XMLHTTP");
        } catch(e) {
            // try an older version
            try{
                req = new ActiveXObject("Microsoft.XMLHTTP");
            } catch(e) {
                return false;
            }
        }
    }
    if (!req) return false;
    if (typeof success != 'function') success = function () {};
    if (typeof error!= 'function') error = function () {};
    req.onreadystatechange = function(){
        if(req.readyState == 4) {
            return req.status === 200 ? 
                success(req.responseText) : error(req.status);
        }
    }
   req.open("GET", url, true);
   req.send(null);
    return req;
}
</script>
<?php
   
   
   
   require ("includes/config.php");
   $readserial = $_POST["serial"];
   if (isset($_POST['getread'])) {
       //update action
       render("output.php", ["title" => "Get Serial Number","request" => "read", "readserial" => $readserial]);
       $request = sendrequest($readserial);
       render("sendingread.php", ["title" => "Get Serial Number","readserial" => $readserial]);
    } else if (isset($_POST['lastread'])) {
        //delete action
        //put the serial number in a hidden input to retrieve it from javascript
        render("output.php", ["title" => "Get Serial Number","request" => "last", "readserial" => $readserial]);
    } else {
    //no button pressed
        echo 'how did this get here?';
    }
   
   
   ?>
<div id="header"></div>
<div id="output"></div> 
 

