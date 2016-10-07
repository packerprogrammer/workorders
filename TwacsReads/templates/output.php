<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ($request == "read") {
    echo '<h3 id="request">Sending Read Request Now.<br> This may take up to 2 minutes.</h3>';
} else {
    echo '<h3 id="request">Getting Last Read.</h3>';
}

// cheap trick to store some values that will be read by javascript
echo '<input type="hidden" id="serial" name="serial" value=' . $readserial . '>';
echo '<input type="hidden" id="reqtype" name="reqtype" value=' . $request . '>';
?>

