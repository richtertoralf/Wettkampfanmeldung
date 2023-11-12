<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/**
 * download.php
 *
 * Dieses Skript ermöglicht das Herunterladen der Meldeliste als CSV- oder XLSX-Datei.
 * Es liest die Daten aus der 'data.csv'-Datei, erstellt ein Spreadsheet und bietet die Optionen,
 * die Meldeliste entweder als CSV oder XLSX herunterzuladen.
 *
 * PHP-Version 8
 *
 * @category   Data Download
 * @package    Registration_Form
 * @author     Toralf Richter
 * @link       https://github.com/richtertoralf/sport-registration/
 */

chdir(__DIR__);

// Include Autoloader of PhpSpreadsheet
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Dateipfad zur data.csv-Datei
$csvFile = '../data/data.csv';

// Dateinamen für den Download (CSV)
$downloadCsvFilename = 'meldeliste.csv';

// Dateinamen für den Download (XLSX)
$downloadXlsxFilename = 'meldeliste.xlsx';

// CSV-Datei einlesen
$csvData = file_get_contents($csvFile);
$lines = explode(PHP_EOL, $csvData);

// Daten aus der CSV in ein mehrdimensionales Array einfügen

$dataArray = [];
foreach ($lines as $line) {
    // Zerlege die Zeile in Spalten
    $row = str_getcsv($line);

    // Extrahiere die ersten 16 Spalten (ohne E-Mail, für direkten Winlaufen-Import)
    $first10Columns = array_slice($row, 0, 16);

    // Füge die ersten 16 Spalten in das $dataArray ein
    $dataArray[] = $first10Columns;
}

// Spreadsheet erstellen
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Daten aus dem Array in das Spreadsheet einfügen
$sheet->fromArray($dataArray);

// Speichere das Spreadsheet als XLSX-Datei
$writer = new Xlsx($spreadsheet);
$writer->save($downloadXlsxFilename);

// Content-Disposition für CSV-Datei setzen und als CSV herunterladen
if ($_GET['format'] == 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $downloadCsvFilename . '"');
    readfile($csvFile);
}
// Content-Disposition für XLSX-Datei setzen und als XLSX herunterladen
else {
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $downloadXlsxFilename . '"');
    readfile($downloadXlsxFilename);
    // Lösche die temporäre XLSX-Datei nach dem Download (optional)
    unlink($downloadXlsxFilename);
}
