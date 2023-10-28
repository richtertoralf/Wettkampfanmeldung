<?php

/**
 * participants.php
 *
 * Diese Datei zeigt die Meldeliste an, indem sie Daten aus der CSV-Datei "data.csv" liest und anzeigt.
 * Dabei werden aber nicht alle Elemente, sondern nur Name, Vorname, Jahrgang, Geschlecht und Gruppe ausgweählt.
 *
 * PHP-Version 8
 *
 * @category   Data Processing
 * @package    Participant_Registration
 * @author     Toralf Richter
 * @link       https://github.com/richtertoralf/sport-registration/
 */
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Meldeliste</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container participants">

        <header>
            <?php require('raceInfo.php'); ?>
            <p><?php echo $eventName; ?></p>
            <p><?php echo $organizer; ?></p>
            <p><?php echo $date; ?></p>
        </header>

        <h2>Meldeliste</h2>

        <?php
        // CSV-Datei öffnen und Inhalte lesen
        $csvFile = fopen("data.csv", "r");

        // Überprüfen, ob die Datei erfolgreich geöffnet wurde
        if ($csvFile !== FALSE) {
            // Header-Zeile (erste Zeile) aus der CSV-Datei lesen
            $headers = fgetcsv($csvFile, 1000, ",");

            // Tabelle für die Anzeige erstellen
            echo '<table border="1">';

            // Header-Zeile als <th> (Header) in der Tabelle anzeigen
            echo '<tr>';
            foreach ($headers as $index => $header) {
                // Zeige den Header nur an, wenn es die gewünschten Spalten sind (Index 1, 2, 4, 5, 6)
                if ($index == 1 || $index == 2 || $index == 4 || $index == 5 || $index == 6) {
                    echo '<th>' . htmlspecialchars($header) . '</th>';
                }
            }
            echo '</tr>';

            // Daten aus der CSV-Datei lesen und in die Tabelle einfügen
            $rowCounter = 0;
            while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE && $rowCounter < 2000) {
                echo '<tr>';
                // Zeige nur bestimmte Spalten (Index 1, 2, 4, 5, 6) aus dem $data-Array in der Tabelle an
                echo '<td>' . htmlspecialchars($data[1]) . '</td>'; // Name
                echo '<td>' . htmlspecialchars($data[2]) . '</td>'; // Vorname
                echo '<td>' . htmlspecialchars($data[4]) . '</td>'; // Jahrgang
                echo '<td>' . htmlspecialchars($data[5]) . '</td>'; // Geschlecht
                echo '<td>' . htmlspecialchars($data[6]) . '</td>'; // Gruppe
                echo '</tr>';
                $rowCounter++;
            }

            // Tabelle schließen
            echo '</table>';

            // CSV-Datei schließen
            fclose($csvFile);
        } else {
            // Fehlermeldung anzeigen, falls die Datei nicht geöffnet werden konnte
            echo 'Fehler beim Öffnen der CSV-Datei.';
        }
        ?>

        <!-- Hier kommen zwei Links, um die Meldeliste herunterzuladen -->
        <a href="download.php?format=csv" class="download-link">Meldeliste als CSV-Datei herunterladen</a>
        <a href="download.php?format=xlsx" class="download-link">Meldeliste als XLSX-Datei herunterladen</a>
        
        <?php
        // Navigation einfügen
        include('navigation.php');
        ?>
    </div>
</body>

</html>
