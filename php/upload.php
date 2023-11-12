<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

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
 *
 * PHP-Version 8
 *
 * @category   Data Processing
 * @package    Participant_Registration
 * @author     Toralf Richter
 * @link       https://github.com/richtertoralf/sport-registration/
 */

chdir(__DIR__);

// Include Autoloader of PhpSpreadsheet
require '../vendor/autoload.php';

// Pfad zur bestehenden CSV-Datei
$csvFilePath = '../data/data.csv';

/**
 * Konvertiert die Daten aus einer Textdatei in ein mehrdimensionales Array.
 *
 * @param string $data - Die Daten aus der Textdatei.
 * @param bool $hasHeader - Gibt an, ob die Datei eine Kopfzeile enthält.
 * @return array - Ein mehrdimensionales Array mit den Daten aus der Datei.
 */
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

/**
 * Bereitet den Kopf einer CSV-Datei für den Vergleich vor.
 *
 * @param string $header - Der Kopf der CSV-Datei.
 * @return array - Ein vorbereiteter Kopf für den Vergleich.
 */
function prepareHeader($header)
{
    // Alle Arten von Whitespaces und unsichtbaren Zeichen entfernen
    return array_map('trim', array_map('strtoupper', str_getcsv(trim(strtolower(preg_replace('/\s+/', '', $header))))));
}

/**
 * Vergleicht die Spaltenköpfe der hochgeladenen Datei und der internen Meldeliste (data.csv).
 *
 * @param string $csvFilePath - Pfad zur internen Meldeliste.
 * @param string $uploadedData - Daten aus der hochgeladenen Datei.
 * @return bool - Gibt true zurück, wenn die Spaltenköpfe übereinstimmen, ansonsten false.
 */
function compareHeaders($csvFilePath, $uploadedData)
{
    $csvHeader = prepareHeader(fgets(fopen($csvFilePath, 'r')));
    $uploadedLines = explode("\n", $uploadedData);
    $uploadedHeader = prepareHeader($uploadedLines[0]);

    // Vergleiche die Header und prüfe, ob sie übereinstimmen
    if ($csvHeader === $uploadedHeader) {
        return true; // Header stimmen überein
    } else {
        return false; // Header stimmen nicht überein
    }
}

/**
 * Verarbeitet die hochgeladenen Daten und fügt sie der internen Meldeliste hinzu.
 *
 * @param string $uploadedData - Daten aus der hochgeladenen Datei.
 * @param string $csvFilePath - Pfad zur internen Meldeliste.
 * @return string - Eine Meldung über den Erfolg oder Misserfolg der Datenverarbeitung.
 */
function processData($uploadedData, $csvFilePath)
{
    $csvData = file_get_contents($csvFilePath);
    $csvArray = convertDataToArray($csvData);
    $uploadedArray = convertDataToArray($uploadedData, false);

    // Vergleiche die Header
    if (compareHeaders($csvFilePath, $uploadedData)) {
        // echo 'Die Spalten der Datei sehen gut aus.';
    } else {
        // echo 'Die Header der hochgeladenen Datei stimmen nicht mit der data.csv-Datei überein.';
        return 'Die Spalten der hochgeladenen Datei stimmen nicht mit der Musterdatei überein. Deine Meldeliste wurde nicht gespeichert!';
    }

    if (empty($uploadedArray)) {
        return 'Die hochgeladene Datei enthält keine Daten.';
    }

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

/**
 * Prüft das hochgeladene Formular und verarbeitet die hochgeladenen Dateien.
 *
 * @param string $csvFilePath - Pfad zur internen Meldeliste.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['uploadedFile'])) {
    $fileType = $_FILES['uploadedFile']['type'];

    // Verarbeitung der hochgeladenen CSV-Datei
    if ($fileType === 'text/csv') {
        $uploadedData = file_get_contents($_FILES['uploadedFile']['tmp_name']);
        $result = processData($uploadedData, $csvFilePath);
        echo $result;
    }
    // Verarbeitung der hochgeladenen Excel-Datei
    elseif ($fileType === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($_FILES['uploadedFile']['tmp_name']);
        $excelData = $spreadsheet->getActiveSheet()->toArray();
        $excelData = implode("\n", array_map(function ($row) {
            return implode(',', $row);
        }, $excelData));
        $result = processData($excelData, $csvFilePath);
        echo $result;
    } else {
        echo 'Ungültiger Dateityp. Nur CSV- und Excel-Dateien sind erlaubt.';
    }
}
