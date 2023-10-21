<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formulardaten erhalten
    $spNr = $_POST["regEntry"][0]["SpNr"];
    $surname = $_POST["regEntry"][0]["surname"];
    $forename = $_POST["regEntry"][0]["forename"];
    $sex = $_POST["regEntry"][0]["sex"];
    $group = $_POST["regEntry"][0]["group"];
    $email = $_POST["single_email"];
    $message = $_POST["single_message"];

    // Daten in CSV-Datei speichern
    $data = [$spNr, $surname, $forename, $sex, $group, $email, $message];
    $csvFile = fopen("data.csv", "a"); // öffne die CSV-Datei im Anhänge-Modus
    fputcsv($csvFile, $data); // schreibe die Daten in die CSV-Datei
    fclose($csvFile); // schließe die CSV-Datei

    // Daten auf der Webseite anzeigen
    echo "<h2>Einzelanmeldung erfolgreich eingegangen:</h2>";
    echo "<ul>";
    echo "<li><strong>Startpassnummer:</strong> $spNr</li>";
    echo "<li><strong>Nachname:</strong> $surname</li>";
    echo "<li><strong>Vorname:</strong> $forename</li>";
    echo "<li><strong>Geschlecht:</strong> $sex</li>";
    echo "<li><strong>Gruppe:</strong> $group</li>";
    echo "<li><strong>E-Mail:</strong> $email</li>";
    echo "<li><strong>Anmerkung:</strong> $message</li>";
    echo "</ul>";
} else {
    echo "Ungültige Anfrage";
}
?>
