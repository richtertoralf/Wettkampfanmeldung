<?php
// Lese die Werte aus der INI-Datei
$raceinfo = parse_ini_file('raceInfo.ini');

// Werte aus der INI-Datei extrahieren
$eventName = $raceinfo['EventName'];
$organizer = $raceinfo['Organizer'];
$date = $raceinfo['Date'];
