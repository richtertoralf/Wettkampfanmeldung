<?php
// Dateipfad zur data.csv-Datei
$csvFile = 'data.csv';

// Dateinamen für den Download
$downloadFilename = 'meldeliste.csv';

// CSV-Datei herunterladen
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $downloadFilename . '"');

// CSV-Datei ausgeben
readfile($csvFile);
