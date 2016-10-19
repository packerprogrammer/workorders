<!-- the variable $read is passed to this page via the render function -->
<table id="reads" class="display" cellspacing="0" border='1'>

    <thead>
	<tr>
	    <th>DATE</th>
	    <th>kWh</th>
            
           <!-- if kw is null then don't print the header for kW -->
            <?php if (!is_null($read[0]["kw"])) { 
                print("<th>kW</th>");
            }
            ?>
            
            <th>QC</th>
	</tr>
    </thead>
    <tbody>
<?php
    foreach ($read as $r) {
        // loop through all the records
    }   
    // then print the last record
    print("<tr>");
    print("<td>{$r["date"]}</td>");
    print("<td>{$r["read"]}</td>");
    
    // if there is no value for kW don't include it
    if (!is_null($r["kw"])) {
       print("<td>{$r["kw"]}</td>"); 
    }

    // if the quality code is either 3 or 6 then print ok, otherwise print BAD
    if ($r["qc"]== '3' or $r["qc"] == '6'){
        $qc='OK';
    }
    else {
        $qc='BAD';
    }    
    print("<td>{$qc}</td>");
    print("</tr>");    
?>
</tbody>
</table>
