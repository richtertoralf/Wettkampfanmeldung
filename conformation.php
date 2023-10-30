<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


/**
 * conformation.php
 *
 * Diese Datei verarbeitet die Formulardaten von 'index.php' nach dem Abschicken des Formulars.
 * Die Daten werden in einer CSV-Datei gespeichert und auf der Webseite angezeigt.
 *
 * PHP-Version 8
 *
 * @category   Data Processingg
 * @package    Registration_Form
 * @author     Toralf Richter
 * @link       https://github.com/richtertoralf/sport-registration/
 */
?>

<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Anmeldung</title>
  <link rel="icon" type="image/x-icon" href="skiCC.ico">
  <link rel="stylesheet" href="css/styles.css">
</head>

<body>

  <div class="container registration">

    <header>
      <?php require('php/raceInfo.php'); ?>
    </header>

    <?php

    chdir(__DIR__);

    // Überprüfen, ob die Anfrage vom POST-Formular kommt
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Formulardaten erhalten
      $spNr = $_POST["regEntry"][0]["SpNr"];
      $surname = $_POST["regEntry"][0]["surname"];
      $forename = $_POST["regEntry"][0]["forename"];
      $sex = $_POST["regEntry"][0]["sex"];
      $yearofbirth = $_POST["regEntry"][0]["yearofbirth"];
      $club = $_POST["regEntry"][0]["club"];
      $association = $_POST["regEntry"][0]["association"];
      $group = $_POST["regEntry"][0]["group"];
      $email = $_POST["regEntry"][0]["single_email"];
      $email = $_POST["regEntry"][0]["single_email"];

      // Pfad zur bestehenden CSV-Datei
      $csvFilePath = 'data/data.csv';

      // Spaltenköpfe für die CSV-Datei
      // FIS-Code-Nr.,Name,Vorname,Verband,Verein,Jahrgang,Geschlecht,FIS-Distanzpunkte,FIS-Sprintpunkte,
      // Startnummer,Gruppe,DSV-Code-Nr.,Startpass,Waffen-Nr.,Nation,Transponder-ID
      $headers = ["FIS-Code-Nr.", "Name", "Vorname", "Verband", "Verein", "Jahrgang", "Geschlecht", "FIS-Distanzpunkte", "FIS-Sprintpunkte", "Startnummer", "Gruppe", "DSV-Code-Nr.", "Startpass", "Waffen-Nr.", "Nation", "Transponder-ID", "E-Mail"];
      // $headers = ["Startpassnummer", "Nachname", "Vorname", "Geschlecht", "Geburtsjahr", "Verein", "Gruppe", "E-Mail"];

      // Daten in CSV-Datei speichern
      // Die leeren Felder bleiben in der CSV-Datei leer, da sie in der Einzelmeldung nicht abgefragt werden.
      // Nur über die Sammelmeldung per Datei-Upload können diese Daten geliefert werden.
      $data = [
        "",           // FIS-Code-Nr.
        $surname,     // Name
        $forename,    // Vorname
        $association, // Verband
        $club,        // Verein
        $yearofbirth, // Jahrgang
        $sex,         // Geschlecht
        "",           // FIS-Distanzpunkte
        "",           // FIS-Sprintpunkte
        "",           // Startnummer
        $group,       // Gruppe
        "",           // DSV-Code-Nr.
        $spNr,        // Startpass
        "",           // Waffen-Nr.
        "",           // Nation
        "",           // Transponder-ID
        $email        // E-Mail
      ];

      $csvFile = fopen($csvFilePath, "a"); // öffne die CSV-Datei im Anhänge-Modus

      if (filesize($csvFilePath) == 0) {
        // Wenn die Datei leer ist, schreibe die Spaltenköpfe
        fputcsv($csvFile, $headers);
      }

      fputcsv($csvFile, $data); // schreibe die Daten in die CSV-Datei
      fclose($csvFile); // schließe die CSV-Datei

      // Daten auf der Webseite anzeigen
      echo "<h3>Einzelanmeldung erfolgreich eingegangen:</h2>";
      echo "<table>";
      echo "<tr><td>Startpassnummer:</td><td>$spNr</td></tr>";
      echo "<tr><td>Nachname:</td><td>$surname</td></tr>";
      echo "<tr><td>Vorname:</td><td>$forename</td></tr>";
      echo "<tr><td>Geschlecht:</td><td>$sex</td></tr>";
      echo "<tr><td>Geburtsjahr:</td><td>$yearofbirth</td></tr>";
      echo "<tr><td>Verein:</td><td>$club</td></tr>";
      echo "<tr><td>Verband:</td><td>$association</td></tr>";
      echo "<tr><td>Gruppe:</td><td>$group</td></tr>";
      echo "<tr><td>E-Mail:</td><td>$email</td></tr>";
      echo "</table>";
    } else {
      echo "Ungültige Anfrage";
    }

    // Navigation einfügen
    require('php/navigation.php');
    ?>
  </div>

</body>

</html>
