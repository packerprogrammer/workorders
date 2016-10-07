
<table id="reads" class="display" cellspacing="0" border='1'>

    <thead>
	<tr>
	    <th>DATE</th>
	    <th>kWh</th>
	</tr>
    </thead>
    <tbody>
<?php
    foreach ($read as $r)
	    print("<tr>");
            print("<td>{$r["date"]}</td>");
            print("<td>{$r["read"]}</td>");
            print("</tr>");
?>
</tbody>
</table>
