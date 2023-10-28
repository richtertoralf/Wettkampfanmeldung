<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danke</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container registration">
        <header>
            <?php require('raceInfo.php'); ?>
            <p><?php echo $eventName; ?></p>
            <p><?php echo $organizer; ?></p>
            <p><?php echo $date; ?></p>
        </header>
        <h2>Auf Wiedersehen</h2>
        <div class="frame">
            <p>Danke für deine Anmeldung.</p>
            <p>Wir wünschen dir eine gute Anreise zum Wettkampf.</p>
        </div>
        <?php
        // Navigation einfügen
        include('navigation.php');
        ?>
    </div>
</body>

</html>
