<!DOCTYPE html>

<html>

    <head>

        <link href="css/bootstrap.css" rel="stylesheet"/>
        <link href="css/bootstrap-responsive.css" rel="stylesheet"/>
        <link href="css/styles.css" rel="stylesheet"/>

        <?php if (isset($title)): ?>
            <title>Work Orders: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>Work Orders</title>
        <?php endif ?>

        <script src="js/jquery-1.8.2.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/scripts.js"></script>

    </head>

    <body>

        <div class="container">

            <div id="top">
                <a href="/orders"><img alt="C$50 Finance" src="img/logo2.jpg"/></a>
            </div>

            <div id="middle">

