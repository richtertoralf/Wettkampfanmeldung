<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/**
 * admin.php
 *
 * Diese Datei verwaltet den Administrationsbereich der Veranstaltung. Sie ermöglicht
 * die Anmeldung als Administrator, das Bearbeiten und Speichern von Renninformationen
 * sowie den Download der Meldeliste als xlsx- und csv-Datei
 *
 * PHP-Version 8
 *
 * @category   Administration
 * @package    Participant_Registration
 * @author     Toralf Richter
 * @link       https://github.com/richtertoralf/sport-registration/
 */


session_start();
chdir(__DIR__);

require_once('raceInfo.php');

// Funktion zum Laden der Renninfos aus der raceInfo.ini Datei
function saveRaceInfo($raceInfo)
{
    $iniContent = '';
    foreach ($raceInfo as $key => $value) {
        $iniContent .= "$key = \"$value\"\n";
    }

    // Ausgabe des Inhalts zur Kontrolle
    // echo '<pre>' . htmlspecialchars($iniContent) . '</pre>';

    // Speichern der Daten in die INI-Datei
    file_put_contents('../data/raceInfo.ini', $iniContent);
}

// Laden der Admin-Daten (Username und Passwort)
$admins = parse_ini_file('../ini/user.ini');

// var_dump($_SESSION);
// var_dump($_POST);

// Initialisieren von $raceInfo
// hier werden die bestehenden Daten aus der raceInfo.ini via reaceInfo.php eigebunden
$raceInfo = getRaceInfo();

// Überprüfen, ob das Formular zum Speichern abgeschickt wurde
if (isset($_POST['submitRaceInfo'])) {
    // Aktualisiere die Renninfos mit den Daten aus dem Formular
    $raceInfo['eventName'] = $_POST['eventName'];
    $raceInfo['organizer'] = $_POST['organizer'];
    $raceInfo['date'] = $_POST['date'];

    // Speichern der aktualisierten Renninfos
    saveRaceInfo($raceInfo);
    $infoMessage = 'Die Wettkampfinformationen wurden erfolgreich aktualisiert!';
} else {
    // Überprüfen, ob der Benutzername und das Passwort korrekt sind
    if ($_POST['username'] === $admins['username'] && $_POST['password'] === $admins['password']) {
        // Der Benutzername und das Passwort sind korrekt
        $_SESSION['admin'] = $_POST['username'];
    } else {
        // zurück zur Passworteingabe in der index.php 
        $infoMessage = 'Benutzername oder Passwort sind ungültig!';
        header("Location: ../index.php?triggerAdmin=true&infoMessage=" . urlencode($infoMessage));
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <!-- Meta-Tags und Titel des Dokuments -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anmeldung</title>
    <!-- Favicon und Stylesheet-Verknüpfung -->
    <link rel="icon" type="image/x-icon" href="../skiCC.ico">
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <!-- Header-Bereich mit Renninformationen und Menü-Optionen -->
    <header>
        <?php
        // require('raceInfo.php');
        $raceInfo = getRaceInfo();
        ?>
        <!-- Anzeige der Renninformationen im Header -->
        <div class="event-name"><?php echo $raceInfo['eventName']; ?></div>
        <div class="organizer" rowspan="2"><?php echo $raceInfo['organizer']; ?></div>
        <div class="date"><?php echo $raceInfo['date']; ?></div>
    </header>

    <div class="container admin">
        <!-- Anzeige des Formulars zum Bearbeiten der Renninfos -->
        <form action="" method="post">
            <label for="eventName">Wettkampfname:</label>
            <input type="text" name="eventName" id="eventName" value="<?php echo htmlspecialchars($raceInfo['eventName']); ?>" required><br>
            <label for="organizer">Ausrichter:</label>
            <input type="text" name="organizer" id="organizer" value="<?php echo htmlspecialchars($raceInfo['organizer']); ?>" required><br>
            <label for="date">Wettkampfdatum:</label>
            <input type="text" name="date" id="date" value="<?php echo htmlspecialchars($raceInfo['date']); ?>" required><br>
            <aside>Hier kannst du die Infos zu deinem Wettkampf anpassen und speichern.</aside>
            <input type="submit" name="submitRaceInfo" value="Wettkampfinfos speichern">
        </form>

        <!-- Anzeige des Info-Messages -->
        <aside class="info-message">
            <?php
            echo $infoMessage;
            ?>
        </aside>

        <!-- Hier kommen zwei Links, um die Meldeliste herunterzuladen -->
        <a href="download.php?format=csv" class="download-link">Meldeliste incl. E-Mail Adressen als CSV-Datei herunterladen</a>
        <aside>
            Die csv-Datei enthält auch die erfassten E-Mail Adressen der angemeldeten Sportler. Es wird noch eine Funktion hinzugefügt, um die auf der Webseite vorhandene Meldeliste zu löschen und neu hochzuladen.
        </aside>
        <a href="download.php?format=xlsx" class="download-link">Meldeliste als XLSX-Datei für Winlaufen-Import herunterladen</a>
        <aside>
            Die 'meldeliste.xlsx' kann direkt in Winlaufen importiert werden. Es wird aber empfohlen, die Datei vorher zu überprüfen.
        </aside>
        <nav>
            <a href="logout.php" class="nav-button">Adminbereich verlassen</a>
        </nav>
    </div>
</body>

<!-- JavaScript-Dateien für die Funktionalität der Seite -->
<script src="../js/main.js"></script>

</html>
