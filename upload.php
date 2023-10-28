<?php

/**
 * upload.php
 *
 * Diese Datei ermöglicht es den Benutzern, eine eigene Meldeliste (CSV-Datei) hochzuladen,
 * die dann an die bestehende "data.csv"-Datei angefügt wird.
 * Es werden die Spaltenköpfe der hochgeladenen Datei mit der internen Meldeliste (data.csv)
 * verglichen. Dabei werden Leerzeichen sowie Groß- und Kleinschreibung ignoriert.
 * Achtung!
 * Die Upload-Datei im csv(!)-Format muss folgende Spalten enthalten:
 * FIS-Code-Nr.,Name,Vorname,Verband,Verein,Jahrgang,Geschlecht,FIS-Distanzpunkte,FIS-Sprintpunkte,
 * Startnummer,Gruppe,DSV-Code-Nr.,Startpass,Waffen-Nr.,Nation,Transponder-ID, E-Mail
 * Die Spalte "E-Mail" soll es dem Wettkampfausrichter ermöglichen, Kontakt mit dem Meldenden aufzunehmen.
 * Diese Datei-Struktur entspricht der Winlaufen-Importdatei plus das Feld "E-Mail".
 * Um diese Datei nach dem Download, in Winlaufen importierten zu können, muss derzeit noch die
 * heruntergeladene csv-Datei in eine xls-Datei umgewandelt und die Spalte "E-Mail" entfernt werden.
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
    <title>Sammelanmeldung</title>
    <link rel="stylesheet" href="styles.css">
</head>
<!DOCTYPE html>
<html lang="de">

<body>

    <div class="container registration">

        <header>
            <?php require('raceInfo.php'); ?>
            <p><?php echo $eventName; ?></p>
            <p><?php echo $organizer; ?></p>
            <p><?php echo $date; ?></p>
        </header>

        <h2>Sammelanmeldung</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="uploadedFile" accept=".csv" required>
            <button type="submit">Meldedatei hochladen</button>
            <details>
                <summary>
                    Bitte verwende unbedingt diese Vorlage für die Meldedatei: <a href="VorlageMeldedatei.csv" download>VorlageMeldedatei.csv</a>
                </summary>
                <p>Die Meldeliste muss den Vorgaben für das Programm Winlaufen des Deutschen Skiverbandes entsprechen.</p>
                <p>Die Spaltenköpfe dürfen nicht verändert werden.</p>
            </details>
        </form>

        <?php
        // Pfad zur bestehenden CSV-Datei
        $csvFilePath = 'data.csv';
        // Prüfen, ob das Formular abgeschickt wurde
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['uploadedFile'])) {
            // Hochgeladene Datei öffnen und ihren Inhalt lesen
            $uploadedData = file_get_contents($_FILES['uploadedFile']['tmp_name']);

            // Spaltenköpfe der hochgeladenen Datei extrahieren und Leerzeichen entfernen sowie zu Kleinbuchstaben umwandeln
            $uploadedLines = explode("\n", $uploadedData);
            $uploadedHeaders = str_getcsv(trim(strtolower(str_replace(' ', '', $uploadedLines[0]))));

            // Spaltenköpfe der bestehenden Datei extrahieren und Leerzeichen entfernen sowie zu Kleinbuchstaben umwandeln
            $existingData = file_get_contents($csvFilePath);
            $existingLines = explode("\n", $existingData);
            $existingHeaders = str_getcsv(trim(strtolower(str_replace(' ', '', $existingLines[0]))));

            // Überprüfen, ob die Spaltenköpfe übereinstimmen
            if ($uploadedHeaders === $existingHeaders) {
                // Daten aus der hochgeladenen Datei zur bestehenden CSV-Datei hinzufügen
                $dataToAdd = implode("\n", array_slice($uploadedLines, 1)); // Nur die Zeilen mit den tatsächlichen Daten
                if (file_put_contents($csvFilePath, $dataToAdd, FILE_APPEND | LOCK_EX) !== FALSE) {
                    echo '<aside><p>Die Daten wurden erfolgreich zur Meldeliste hinzugefügt.</p></aside>';
                } else {
                    echo '<aside><p>Es gab ein Problem beim Hinzufügen der Daten zur Meldeliste.</p></aside>';
                }
            } else {
                echo '<aside><p>Die Spaltenköpfe der hochgeladenen Datei stimmen nicht mit denen der bestehenden Datei überein.</p></aside>';
            }
        }

        // Navigation einfügen
        include('navigation.php');
        ?>
    </div>

</body>

</html>
