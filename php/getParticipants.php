<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/**
 * getParticipantsData.php
 *
 * Dieses Skript liest Daten aus einer CSV-Datei und gibt sie als JSON-Antwort zurück.
 *
 * PHP-Version 8
 *
 * @category   Data Processing
 * @package    Participant_Registration
 * @author     Toralf Richter
 * @link       https://github.com/richtertoralf/sport-registration/
 */

chdir(__DIR__);

// Pfad zur CSV-Datei
$csvFilePath = '../data/data.csv';

/**
 * Funktion zum Lesen der CSV-Datei und Rückgabe der Teilnehmerdaten als assoziatives Array.
 *
 * @param string $csvFilePath - Der Pfad zur CSV-Datei mit den Teilnehmerdaten.
 * @return array - Ein assoziatives Array, das Teilnehmerdaten enthält (Spalten 1, 2, 4, 5, 6).
 */
function getParticipantsData($csvFilePath)
{
    $participants = [];
    if (($handle = fopen($csvFilePath, "r")) !== FALSE) {
        // Spaltenköpfe aus der ersten Zeile lesen
        $headers = fgetcsv($handle, 1000, ",");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Spalten 1, 2, 4, 5, 6 auslesen und in ein assoziatives Array einfügen
            $participant = [
                $headers[1] => $data[1], // Spalte 2
                $headers[2] => $data[2], // Spalte 3
                $headers[4] => $data[4], // Spalte 5
                $headers[5] => $data[5], // Spalte 6
                $headers[6] => $data[6]  // Spalte 7
            ];
            $participants[] = $participant;
        }
        fclose($handle);
    }
    return $participants;
}

// Teilnehmerdaten aus der CSV-Datei lesen
$participants = getParticipantsData($csvFilePath);

// JSON-Antwort vorbereiten
$response = [
    "success" => true,
    "participants" => $participants
];

// JSON-Antwort zurückgeben
header('Content-Type: application/json');
echo json_encode($response);
