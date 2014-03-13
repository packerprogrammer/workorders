
<form action="sell.php" method="post">
    <fieldset>
        <div class="control-group">
            <select name="symbol">
            <option value>select a symbol...</option>
            <?php
            foreach ($symbols as $symbol) 
            {
                print("<option value='{$symbol}'>{$symbol}</option>");          
            }
            ?>
            
            </select>
        </div>
        
        <div class="control-group">
            <button type="submit" class="btn">Sell</button>
        </div>
    </fieldset>
</form>
