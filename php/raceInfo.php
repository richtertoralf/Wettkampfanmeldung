<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/**
 * raceInfo.php
 *
 * Dieses Skript liest Renninformationen aus einer INI-Datei und gibt sie als assoziatives Array zurück.
 *
 * PHP-Version 8
 *
 * @category   Data Processing
 * @package    Participant_Registration
 * @author     Toralf Richter
 * @link       https://github.com/richtertoralf/sport-registration/
 */

chdir(__DIR__);

/**
 * Funktion zum Lesen von Renninformationen aus einer INI-Datei.
 *
 * @return array - Ein assoziatives Array mit den Renninformationen (EventName, Organizer, Date).
 */
function getRaceInfo()
{
    // Lese die Werte aus der INI-Datei
    $raceinfo = parse_ini_file('../data/raceInfo.ini');
    // var_dump($raceinfo);
    // Werte aus der INI-Datei extrahieren
    $eventName = $raceinfo['eventName'];
    $organizer = $raceinfo['organizer'];
    $date = $raceinfo['date'];

    // Gib ein Array mit den Werten zurück
    return array('eventName' => $eventName, 'organizer' => $organizer, 'date' => $date);
}
