<form action="index.php" method="get">
	</div>
    <fieldset>
        <div class="control-group">
            <input autofocus name="string" placeholder="What are you looking for..." type="text"/> 	     
            <button type="submit" class="btn">Search</button>
        </div>
    </fieldset>
</form>

<?php
    if (!empty($name))
    {
        print("<h3>Hello, {$name}</h3>");
    }
    if (empty($dir))
    {
	$dir = "ASC";
    }	
    
    	
?>
<table class="table table-striped">

    <thead>
        <tr>
            <th><a href="index.php?orderby=order_no&dir=<?php echo $dir; if(!empty($prev)) {echo '&string='; echo $prev;} ?>">Order #</a></th>
            <th><a href="index.php?orderby=acct_no&dir=<?php echo $dir; if(!empty($prev)) {echo '&string='; echo $prev;} ?>">Acct #</a></th>
            <th><a href="index.php?orderby=pole_no&dir=<?php echo $dir; if(!empty($prev)) {echo '&string='; echo $prev;} ?>">Pole #</a></th>
            <th><a href="index.php?orderby=name&dir=<?php echo $dir; if(!empty($prev)) {echo '&string='; echo $prev;} ?>">Name</a></th>
	    <th><a href="index.php?orderby=meter_no&dir=<?php echo $dir; if(!empty($prev)) {echo '&string='; echo $prev;} ?>">Meter #</a></th>
            <th><a href="index.php?orderby=date_w&dir=<?php echo $dir; if(!empty($prev)) {echo '&string='; echo $prev;} ?>">Date W.</a></th>
            <th><a href="index.php?orderby=const_no&dir=<?php echo $dir; if(!empty($prev)) {echo '&string='; echo $prev;} ?>">Const. Sum</a></th>		
	    <th>Meter Set</th>
        </tr>
    </thead>

    <tbody>
    <?php
	
        $count = 0;
        foreach ($positions as $position) 
        {
	    if ($position["order"] > 0)
            {
	    	$wo = $position["order"];
		$first = '00' . substr($position["order"],0,2);
	   	$path = "file://workordr\D_Drive\Workordr\WO\\" . $first . "\W0" ;

	    	if (strlen($wo)	== 4)
		{
	    	    $first = '0000';
	   	    $path = "file://workordr\D_Drive\Workordr\WO\\" . $first . "\W000" ;
	     	}
		if (strlen($wo)	== 5)
		{
	    	    $first = '000' . substr($position["order"],0,1);
	   	    $path = "file://workordr\D_Drive\Workordr\WO\\" . $first . "\W00" ;
	     	}
		if (strlen($wo) == 6)
		{
	    	    $first = '00' . substr($position["order"],0,2);
	   	    $path = "file://workordr\D_Drive\Workordr\WO\\" . $first . "\W0" ;
	     	}
                print("<tr>");
	        echo "<td><a href=$path";
	        echo $position["order"];
	        echo ".GIF target=_blank>";	
	        echo $position["order"];
	        echo "</a></td>";
	    }	
	    else
	    {
		print("<td></td>");
	    }
            print("<td>{$position["acct"]}</td>");
            print("<td>{$position["pole"]}</td>");
            print("<td>{$position["name"]}</td>");
            print("<td>{$position["meter"]}</td>");
	    print("<td>{$position["date"]}</td>");
            

	    if ($position["const"] > 0)
            {
	
                $constr = $position["const"];
		if (strlen($constr) == 4)
                {
              		$constfile = '00' . $constr;
		}
		if (strlen($constr) == 5)
		{
			$constfile = '0' . $constr;
		}
		if (strlen($constr) == 3)
		{
			$constfile = '000' . $constr;
		}
		$filenameB = "/home/administrator/mounts/windowsshare/Workordr/CS/C" . $constfile . "B.GIF";
                $filenameC = "/home/administrator/mounts/windowsshare/Workordr/CS/C" . $constfile . "C.GIF";
                $filenameD = "/home/administrator/mounts/windowsshare/Workordr/CS/C" . $constfile . "D.GIF";
                $filenameE = "/home/administrator/mounts/windowsshare/Workordr/CS/C" . $constfile . "E.GIF";
                $filenameF = "/home/administrator/mounts/windowsshare/Workordr/CS/C" . $constfile . "F.GIF";
                $filenameG = "/home/administrator/mounts/windowsshare/Workordr/CS/C" . $constfile . "G.GIF";
                echo "<td><a href=file://workordr\D_Drive\Workordr\CS\C" . $constfile;
	    	echo "A.GIF target=_blank>";
		

		echo $position["const"];

		if (file_exists($filenameB))
		{
			echo "<a href=file://workordr\D_Drive\Workordr\CS\C" . $constfile;	
			echo "B.GIF target=_blank>";
			echo ", B";
		}

		if (file_exists($filenameC))
                {
	                echo "<a href=file://workordr\D_Drive\Workordr\CS\C" . $constfile;
        	        echo "C.GIF target=_blank>";
                	echo ", C";
                }

		if (file_exists($filenameD))
                {
                        echo "<a href=file://workordr\D_Drive\Workordr\CS\C" . $constfile;
                        echo "D.GIF target=_blank>";
                        echo ", D";
                }
		if (file_exists($filenameE))
                {
                        echo "<a href=file://workordr\D_Drive\Workordr\CS\C" . $constfile;
                        echo "E.GIF target=_blank>";
                        echo ", E";
                }

		if (file_exists($filenameF))
                {
                        echo "<a href=file://workordr\D_Drive\Workordr\CS\C" . $constfile;
                        echo "F.GIF target=_blank>";
                        echo ", F";
                }
		if (file_exists($filenameG))
                {
                        echo "<a href=file://workordr\D_Drive\Workordr\CS\C" . $constfile;
                        echo "G.GIF target=_blank>";
                        echo ", G";
                }
	    	
	    	echo "</a></td>";
	    	print("<td>{$position["mset"]}</td>");
            	print("</tr>");
	    	$count = $count + 1;	
	    }
	    else
	    {
		print("<td></td>");
	    }

        }
	
    ?>
    </tbody>
</table>
<?php
	print("{$count} rows returned");
?>
