<?php

/**
 * upload.php
 *
 * Diese Datei ermöglicht es den Benutzern, eine eigene Meldeliste (CSV-Datei oder Excel-Datei) hochzuladen,
 * die dann an die bestehende "data.csv"-Datei angefügt wird.
 * Es werden die Spaltenköpfe der hochgeladenen Datei mit der internen Meldeliste (data.csv)
 * verglichen. Dabei werden Leerzeichen sowie Groß- und Kleinschreibung ignoriert.
 * Achtung!
 * Die Upload-Datei im csv(!)- oder xlsx-Format muss folgende Spalten enthalten:
 * FIS-Code-Nr.,Name,Vorname,Verband,Verein,Jahrgang,Geschlecht,FIS-Distanzpunkte,FIS-Sprintpunkte,
 * Startnummer,Gruppe,DSV-Code-Nr.,Startpass,Waffen-Nr.,Nation,Transponder-ID, E-Mail
 * Die Spalte "E-Mail" soll es dem Wettkampfausrichter ermöglichen, Kontakt mit dem Meldenden aufzunehmen.
 * Diese Datei-Struktur entspricht der Winlaufen-Importdatei plus das Feld "E-Mail".
 * Um diese Datei nach dem Download, in Winlaufen importieren zu können, muss derzeit noch die
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
    <link rel="icon" type="image/x-icon" href="skiCC.ico">
    <link rel="stylesheet" href="css/styles.css">
</head>
<!DOCTYPE html>
<html lang="de">

<body>

    <div class="container registration">

        <header>
            <?php require('php/raceInfo.php'); ?>
        </header>

        <h2>Sammelanmeldung</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="uploadedFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>

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

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        chdir(__DIR__);

        // Include Autoloader of PhpSpreadsheet
        require 'vendor/autoload.php';

        // Pfad zur bestehenden CSV-Datei
        $csvFilePath = 'data/data.csv';

        function convertDataToArray($data, $hasHeader = true)
        {
            $lines = explode("\n", $data);
            $data = [];
            $start = $hasHeader ? 1 : 0; // Wenn $hasHeader true ist, beginne bei Index 1 (überspringe die Kopfzeile)

            for ($i = $start; $i < count($lines); $i++) {
                $row = str_getcsv(trim($lines[$i]));
                // Prüfe, ob die Zeile nicht leer ist und mindestens ein Element enthält
                if (!empty(array_filter($row)) && count($row) > 1) {
                    $data[] = $row;
                }
            }

            return $data;
        }

        function prepareHeader($header)
        {
            // Alle Arten von Whitespaces und unsichtbaren Zeichen entfernen
            return array_map('trim', array_map('strtoupper', str_getcsv(trim(strtolower(preg_replace('/\s+/', '', $header))))));
        }

        function compareHeaders($csvFilePath, $uploadedData)
        {
            // $csvData = file_get_contents($csvFilePath);
            $csvHeader = prepareHeader(fgets(fopen($csvFilePath, 'r')));
            // $csvHeader = prepareHeader($csvData);

            $uploadedLines = explode("\n", $uploadedData);
            $uploadedHeader = prepareHeader($uploadedLines[0]);

            // echo "<pre>";
            // print_r($csvHeader);
            // print_r($uploadedHeader);
            // echo "</pre>";

            // Vergleiche die Header und prüfe, ob sie übereinstimmen
            if ($csvHeader === $uploadedHeader) {
                return true; // Header stimmen überein
            } else {
                return false; // Header stimmen nicht überein
            }
        }

        function processData($uploadedData, $csvFilePath)
        {
            $csvData = file_get_contents($csvFilePath);
            $csvArray = convertDataToArray($csvData);
            $uploadedArray = convertDataToArray($uploadedData, false);

            // Vergleiche die Header
            if (compareHeaders($csvFilePath, $uploadedData)) {
                echo 'Die Datei sieht gut aus.';
            } else {
                echo 'Die Header der hochgeladenen Datei stimmen nicht mit der data.csv-Datei überein.';
                return 'Die Spalten der hochgeladenen Datei stimmen nicht mit der Musterdatei überein. Deine Meldeliste wurde nicht gespeichert!';
            }

            // Ausgabe der Array zur Fehlersuche
            // echo "<pre>";
            // print_r($csvArray);
            // print_r($uploadedArray);
            // echo "</pre>";

            if (empty($uploadedArray)) {
                return 'Die hochgeladene Datei enthält keine Daten.';
            }

            // Ausgabe der Array zur Fehlersuche
            // echo "<pre>";
            // print_r($csvContent);
            // echo "</br>";
            // print_r($csvFilePath);
            // echo "</pre>";

            // Öffne die Datei im Append-Modus
            $fileHandle = fopen($csvFilePath, 'a');

            // Schreibe die hochgeladenen Daten in die Datei (ohne die erste Zeile, da Spaltenüberschriften)
            $uploadedArrayWithoutHeader = array_slice($uploadedArray, 1);
            foreach ($uploadedArrayWithoutHeader as $row) {
                fputcsv($fileHandle, $row);
            }

            // Schließe die Datei
            fclose($fileHandle);

            return 'Die Daten wurden erfolgreich zur Meldeliste hinzugefügt.';
        }

        // Prüfen, ob das Formular abgeschickt wurde
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['uploadedFile'])) {
            $fileType = $_FILES['uploadedFile']['type'];

            // Verwendung der Funktion für die hochgeladene CSV-Datei
            if ($fileType === 'text/csv') {
                $uploadedData = file_get_contents($_FILES['uploadedFile']['tmp_name']);
                $result = processData($uploadedData, $csvFilePath);
                echo '<aside><p>' . $result . '</p></aside>';
            }
            // Verwendung der Funktion für die hochgeladene Excel-Datei
            elseif ($fileType === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($_FILES['uploadedFile']['tmp_name']);
                $excelData = $spreadsheet->getActiveSheet()->toArray();
                $excelData = implode("\n", array_map(function ($row) {
                    return implode(',', $row);
                }, $excelData));
                $result = processData($excelData, $csvFilePath);
                echo '<aside><p>' . $result . '</p></aside>';
            } else {
                echo '<aside><p>Ungültiger Dateityp. Nur CSV- und Excel-Dateien sind erlaubt.</p></aside>';
            }
        }

        // Navigation einfügen
        require('php/navigation.php');
        ?>
    </div>

</body>

</html>
