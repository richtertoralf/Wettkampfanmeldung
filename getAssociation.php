<?php
// Lese die POST-Daten (ausgewählter Vereinsname)
$selectedClub = $_POST['selectedClub'];

// Lies die Clubs und deren Verbände aus der CSV-Datei
function readClubsFromCSV($filename) {
    $clubs = [];

    if (($handle = fopen($filename, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $club = $data[0];
            $association = $data[1];
            $clubs[$club] = $association;
        }
        fclose($handle);
    }

    return $clubs;
}

// Lies die Clubs und deren Verbände aus der CSV-Datei
$clubs = readClubsFromCSV('clubs.csv');

// Finde den Verband für den ausgewählten Verein
$association = isset($clubs[$selectedClub]) ? $clubs[$selectedClub] : 'Verein nicht in Datenbank';

// Gib den Verband zurück
echo $association;
