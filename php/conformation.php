<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/**
 * conformation.php
 *
 * Diese Datei verarbeitet die Formulardaten von 'index.php' nach dem Abschicken des Formulars.
 * Die Daten werden in einer CSV-Datei gespeichert und nocmal, als Bestätigung, auf der Webseite angezeigt.
 *
 * PHP-Version 8
 *
 * @category   Data Processingg
 * @package    Registration_Form
 * @author     Toralf Richter
 * @link       https://github.com/richtertoralf/sport-registration/
 */

chdir(__DIR__);

// Überprüfen, ob die Anfrage vom POST-Formular kommt
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Formulardaten erhalten
  $spNr = $_POST["regEntry"][0]["SpNr"]; // Startpassnummer
  $surname = $_POST["regEntry"][0]["surname"]; // Nachname
  $forename = $_POST["regEntry"][0]["forename"]; // Vorname
  $sex = $_POST["regEntry"][0]["sex"]; // Geschlecht
  $yearofbirth = $_POST["regEntry"][0]["yearofbirth"]; // Geburtsjahr
  $club = $_POST["regEntry"][0]["club"]; // Verein
  $association = $_POST["regEntry"][0]["association"]; // Verband
  $group = $_POST["regEntry"][0]["group"]; // Gruppe
  $email = $_POST["regEntry"][0]["single_email"]; // E-Mail

  // Pfad zur bestehenden CSV-Datei
  $csvFilePath = '../data/data.csv';

  // Spaltenköpfe für die CSV-Datei
  $headers = ["FIS-Code-Nr.", "Name", "Vorname", "Verband", "Verein", "Jahrgang", "Geschlecht", "FIS-Distanzpunkte", "FIS-Sprintpunkte", "Startnummer", "Gruppe", "DSV-Code-Nr.", "Startpass", "Waffen-Nr.", "Nation", "Transponder-ID", "E-Mail"];

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

  // Daten als JSON, zur Ausgabe auf der Webseite, vorbereiten
  $response = [
    "success" => true,
    "message" => "Einzelanmeldung erfolgreich eingegangen",
    "data" => [
      "Startpassnummer" => $spNr,
      "Nachname" => $surname,
      "Vorname" => $forename,
      "Geschlecht" => $sex,
      "Geburtsjahr" => $yearofbirth,
      "Verein" => $club,
      "Verband" => $association,
      "Gruppe" => $group,
      "E-Mail" => $email
    ]
  ];

  // Daten als JSON, zur Ausgabe auf der Webseite, zurückgeben
  header('Content-Type: application/json');
  echo json_encode($response);
} else {
  echo "Ungültige Anfrage: " . print_r($_POST, true);
}
