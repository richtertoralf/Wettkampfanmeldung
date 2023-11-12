<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/**
 * getClubs.php
 *
 * Dieses Skript liest Daten aus einer CSV-Datei und verarbeitet sie.
 * Es enthält eine Funktion zum Lesen von Vereinen und ihren Verbänden aus einer CSV-Datei.
 *
 * PHP-Version 8
 *
 * @category   Data Processing
 * @package    Participant_Registration
 * @author     Toralf Richter
 * @link       https://github.com/richtertoralf/sport-registration/
 */

chdir(__DIR__);

// Dateipfad zur CSV-Datei mit Vereinsinformationen
$clubsFilePath = '../data/clubs.csv';

/**
 * Funktion zum Lesen von Vereinen und ihren Verbänden aus einer CSV-Datei.
 *
 * @param string $filename - Der Pfad zur CSV-Datei mit Vereinsinformationen.
 * @return array - Ein assoziatives Array, das Vereinsnamen als Schlüssel und Verbände als Werte enthält.
 */
function readClubsFromCSV($filename)
{

    $clubs = [];

    // Öffne die CSV-Datei im Lesemodus
    if (($handle = fopen($filename, "r")) !== FALSE) {
        // Lies jede Zeile der CSV-Datei
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $club = $data[0]; // Der Vereinsname befindet sich in der ersten Spalte
            $association = $data[1]; // Der Verband befindet sich in der zweiten Spalte
            $clubs[$club] = $association; // Füge den Vereinsnamen als Schlüssel und den Verband als Wert hinzu
        }
        // Schließe die CSV-Datei
        fclose($handle);
    }

    // Gib das Array mit den Vereinen und Verbänden zurück
    return $clubs;
}

// Rufe die Funktion auf und lese die Vereine und Verbände aus der 'clubs.csv'-Datei
$clubs = readClubsFromCSV($clubsFilePath);
