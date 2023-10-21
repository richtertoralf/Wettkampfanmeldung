<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meldeliste</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Meldeliste</h1>

    <?php
    // CSV-Datei öffnen und Inhalte lesen
    $csvFile = fopen("data.csv", "r");
    if ($csvFile !== FALSE) {
        // Tabelle für die Anzeige erstellen
        echo '<table border="1">
                <tr>
                    <th>Startpassnummer</th>
                    <th>Nachname</th>
                    <th>Vorname</th>
                    <th>Geschlecht</th>
                    <th>Geburtsjahr</th>
                    <th>Gruppe</th>
                    <th>E-Mail</th>
                </tr>';

        // Daten aus der CSV-Datei lesen und in die Tabelle einfügen
        while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE) {
            echo '<tr>';
            foreach ($data as $value) {
                echo '<td>' . htmlspecialchars($value) . '</td>';
            }
            echo '</tr>';
        }

        // Tabelle schließen
        echo '</table>';

        // CSV-Datei schließen
        fclose($csvFile);
    } else {
        echo 'Fehler beim Öffnen der CSV-Datei.';
    }

    ?>

    <!-- Hier kommt ein Link, um die Meldeliste herunterzuladen -->
    <a href="download.php">Meldeliste als CSV herunterladen</a>

    <nav>
        <form action="index.php" method="get">
            <button type="submit">Weitere Anmeldung</button>
        </form>
        <form action="participants.php" method="get">
            <button type="submit">Meldeliste anzeigen</button>
        </form>
        <form action="unsubscribe.php" method="get">
            <!-- Ersetzen Sie "abmeldeseite.php" durch die URL Ihrer Abmeldeseite -->
            <button type="submit">Anmeldung beenden</button>
        </form>
    </nav>

</body>

</html>
