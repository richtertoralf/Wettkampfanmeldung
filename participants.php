<?php
/**
 * participants.php
 *
 * Diese Datei zeigt die Meldeliste an, indem sie Daten aus der CSV-Datei "data.csv" liest und anzeigt.
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
    <div class="container_participants">
        <h2>Meldeliste</h2>

        <?php
        // CSV-Datei öffnen und Inhalte lesen
        $csvFile = fopen("data.csv", "r");

        // Überprüfen, ob die Datei erfolgreich geöffnet wurde
        if ($csvFile !== FALSE) {
            // Tabelle für die Anzeige erstellen
            echo '<table border="1">';

            // Spaltenköpfe aus der ersten Zeile der CSV-Datei lesen und in die Tabelle einfügen
            $headers = fgetcsv($csvFile, 1000, ",");
            echo '<tr>';
            foreach ($headers as $header) {
                echo '<th>' . htmlspecialchars($header) . '</th>';
            }
            echo '</tr>';

            // Daten aus der CSV-Datei lesen und in die Tabelle einfügen
            $rowCounter = 0;
            while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE && $rowCounter < 2000) {
                echo '<tr>';
                foreach ($data as $value) {
                    echo '<td>' . htmlspecialchars($value) . '</td>';
                }
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

        <!-- Hier kommt ein Link, um die Meldeliste herunterzuladen -->
        <a href="download.php" class="download-link">Meldeliste als CSV herunterladen</a>

        <?php
        // Navigation einfügen
        include('navigation.php');
        ?>
    </div>
</body>

</html>
