
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) 
    {
    echo '<p align="right" style="padding:0.5cm">hello, ' . $_SESSION["username"];
    echo '<a href=/logout.php>(logout)</a>';
    echo '</p>';
    }
?>
<br>
<form action="request.php" method="post">
  <div id="formdiv">
    <div id="left">
	    Please Enter Serial Number: 
    </div>
    <div id="right">
        <input autofocus type="text" name="serial" value="<?php echo $serial; ?>">
        
      <div id="btns">
      <input type="submit" name="getread" value="Get Read">
      <input type="submit" name="lastread" value="Last Read">
      </div>
      
    </div>
    <div id ="barcode">
        <button type="button" onclick="myFunction()" style="font-size:24px"><i class="fa fa-barcode"></i></button>
    </div>
  </div>  
</form>

