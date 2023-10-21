<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ihre Titel hier</title>
  <link rel="stylesheet" href="styles.css"> <!-- Hier wird die CSS-Datei eingebunden -->
</head>

<body>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formulardaten erhalten
    $spNr = $_POST["regEntry"][0]["SpNr"];
    $surname = $_POST["regEntry"][0]["surname"];
    $forename = $_POST["regEntry"][0]["forename"];
    $sex = $_POST["regEntry"][0]["sex"];
    $yearofbirth = $_POST["regEntry"][0]["yearofbirth"];
    $group = $_POST["regEntry"][0]["group"];
    $email = $_POST["single_email"];

    // Spaltenköpfe für die CSV-Datei
    $headers = ["Startpassnummer", "Nachname", "Vorname", "Geschlecht", "Geburtsjahr", "Gruppe", "E-Mail"];

    // Daten in CSV-Datei speichern
    $data = [$spNr, $surname, $forename, $sex, $yearofbirth, $group, $email];
    $csvFile = fopen("data.csv", "a"); // öffne die CSV-Datei im Anhänge-Modus

    if (filesize("data.csv") == 0) {
      // Wenn die Datei leer ist, schreibe die Spaltenköpfe
      fputcsv($csvFile, $headers);
    }

    fputcsv($csvFile, $data); // schreibe die Daten in die CSV-Datei
    // fwrite($csvFile, PHP_EOL); // füge einen Zeilenumbruch hinzu
    fclose($csvFile); // schließe die CSV-Datei
    // Daten auf der Webseite anzeigen
    echo "<h2>Einzelanmeldung erfolgreich eingegangen:</h2>";
    echo "<ul>";
    echo "<li><strong>Startpassnummer:</strong> $spNr</li>";
    echo "<li><strong>Nachname:</strong> $surname</li>";
    echo "<li><strong>Vorname:</strong> $forename</li>";
    echo "<li><strong>Geschlecht:</strong> $sex</li>";
    echo "<li><strong>Geburtsjahr:</strong> $yearofbirth</li>";
    echo "<li><strong>Gruppe:</strong> $group</li>";
    echo "<li><strong>E-Mail:</strong> $email</li>";
    echo "</ul>";
  } else {
    echo "Ungültige Anfrage";
  }
  ?>

  <nav>
    <form action="index.php" method="get">
      <button type="submit">Weitere Anmeldung</button>
    </form>
    <form action="participants.php" method="get">
      <button type="submit">Meldeliste anzeigen</button>
    </form>
    <form action="unsubscribe.php" method="get">
      <!-- Ersetzen Sie "abmeldeseite.php" durch die URL Ihrer Abmeldeseite -->
      <button type="submit">Anmeldung beenden</button>
    </form>
  </nav>

</body>

</html>
