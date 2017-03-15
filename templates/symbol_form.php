<form action="quote.php" method="post">
    <fieldset>
        <div>
            A share of <?= htmlspecialchars($name) ?>
            ( <?= htmlspecialchars($symbol) ?> ) costs 
            <strong><?= htmlspecialchars($cost) ?></strong>
        </div>
    </fieldset>
</form>
