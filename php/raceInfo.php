<?php

chdir(__DIR__);

// Lese die Werte aus der INI-Datei
$raceinfo = parse_ini_file('../ini/raceInfo.ini');

// Werte aus der INI-Datei extrahieren
$eventName = $raceinfo['EventName'];
$organizer = $raceinfo['Organizer'];
$date = $raceinfo['Date'];

// Die Werte direkt in HTML ausgeben
echo "<p>$eventName</p>";
echo "<p>$organizer</p>";
echo "<p>$date</p>";
