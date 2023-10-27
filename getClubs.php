<?php

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

/**
 * Diese Funktion liest Vereine und ihre Verbände aus einer CSV-Datei.
 *
 * @param string $filename Der Pfad zur CSV-Datei.
 * @return array Ein assoziatives Array, das Vereinsnamen als Schlüssel und Verbände als Werte enthält.
 */

function readClubsFromCSV($filename)
{
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

$clubs = readClubsFromCSV('clubs.csv');
