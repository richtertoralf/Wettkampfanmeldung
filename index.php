<?php

/**
 * index.php
 *
 * Dieses Skript stellt eine Webanwendung für die Wettkampfanmeldung bereit.
 * Es ermöglicht Sportlern, sich für einen Wettbewerb anzumelden, indem sie persönliche
 * Informationen wie Name, Vorname, Geschlecht, Geburtsjahr, Verein, Verband, Startgruppe
 * und E-Mail-Adresse eingeben. Zusätzlich besteht die Option, sich gruppenweise über einen
 * Dateiupload anzumelden.
 *
 * PHP-Version 8
 *
 * @category   Wettkampfanmeldung
 * @package    Registration_Form
 * @author     Toralf Richter
 * @link       https://github.com/richtertoralf/sport-registration/
 */
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <!-- Meta-Tags und Titel des Dokuments -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anmeldung</title>
    <!-- Favicon und Stylesheet-Verknüpfung -->
    <link rel="icon" type="image/x-icon" href="skiCC.ico">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <!-- Hauptinhalt des Dokuments -->
    <div id="app">
        <!-- Header-Bereich mit Renninformationen und Menü-Optionen -->
        <header>
            <?php
            // error_reporting(E_ALL);
            // ini_set('display_errors', 1);
            // Renninformationen via 'php/raceInfo.php' aus 'ini/raceinfo.ini' abrufen
            require('php/raceInfo.php');
            $raceInfo = getRaceInfo();
            // var_dump($raceInfo);
            ?>
            <!-- Anzeige der Renninformationen im Header -->
            <div class="event-name"><?php echo $raceInfo['eventName']; ?></div>
            <div class="organizer" rowspan="2"><?php echo $raceInfo['organizer']; ?></div>
            <div class="date"><?php echo $raceInfo['date']; ?></div>
            <div class="burger-menu" id="burger-menu">&#9776;</div>
            <nav class="burger-links">
                <a href="#" class="nav-burger" id="registration-link">Weitere Anmeldung</a>
                <a href="#" class="nav-burger" id="participants-link">Meldeliste anzeigen</a>
                <a href="#" class="nav-burger" id="unsubscribe-link">Anmeldung beenden</a>
                <a href="#" class="nav-burger" id="admin-link">Adminbereich</a>
            </nav>
        </header>

        <!-- Container für das Einzelanmeldeformular -->
        <div class="container registration">
            <h1>Anmeldung</h1>
            <!-- Formular für die Einzelanmeldung -->
            <fieldset id="single-registration-fieldset">
                <legend>Hier können sich einzelne Sportler anmelden.</legend>
                <form id="registrationForm" method="post">
                    <h2>Einzelanmeldung</h2>
                    <!-- ... (Formularfelder hier) ... -->
                    <div>
                        <label for="formSpNr">Startpass</label>
                        <input type="text" id="formSpNr" name="regEntry[0][SpNr]" placeholder="z.B.: 1357-2468">
                        <small>
                            <p>SVSAC Startpassnummer besteht aus zwei vierstelligen Zahlenreihen, die mit einem Bindestrich verbunden sind, z.B. 2487-8421. Die Nummer findest du auf deinem SVS-Ausweis.
                            <p>
                        </small>
                    </div>
                    <div>
                        <label for="formsurname">Nachname<span class="required">*</span></label>
                        <input type="text" id="formsurname" name="regEntry[0][surname]" required>
                    </div>
                    <div>
                        <label for="formforename">Vorname<span class="required">*</span></label>
                        <input type="text" id="formforename" name="regEntry[0][forename]" required>
                    </div>
                    <div>
                        <label for="formsex">Geschlecht<span class="required">*</span></label>
                        <select id="formsex" name="regEntry[0][sex]" required>
                            <option value="m">männlich</option>
                            <option value="w">weiblich</option>
                        </select>
                    </div>
                    <div>
                        <label for="formyearofbirth">Geburtsjahr<span class="required">*</span></label>
                        <input type="text" id="formyearofbirth" name="regEntry[0][yearofbirth]" pattern="(?:19|20)[0-9]{2}" placeholder="z.B.: 1989" required>
                        <small>
                            <p>Das Geburtsjahr muss als vierstellige Zahl angegeben werden, z.B. "1989".</p>
                        </small>
                    </div>
                    <div>
                        <?php
                        include 'php/getClubs.php';
                        ?>
                        <label for="selectedClub">Verein<span class="required">*</span></label>
                        <input list="vereinsliste" name="regEntry[0][club]" id="selectedClub" autocomplete="off" required>
                        <datalist id="vereinsliste">
                            <?php
                            foreach ($clubs as $club => $association) {
                                echo "<option value=\"$club\">";
                            }
                            ?>
                        </datalist>
                    </div>
                    <div>
                        <label for="formassociation">Verband</label>
                        <input type="text" name="regEntry[0][association]" id="formassociation" placeholder="wird automatisch eingetragen" readonly>
                    </div>
                    <div>
                        <label for="formgroup">Startgruppe</label>
                        <select id="formgroup" name="regEntry[0][group]">
                            <?php
                            // Schleife zum Generieren von Gruppenoptionen (1 bis 4)
                            for ($i = 1; $i <= 4; $i++) {
                                echo "<option value=\"$i\">$i</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="formsingle_email">E-Mail<span class="required">*</span></label>
                        <input type="email" id="formsingle_email" name="regEntry[0][single_email]" required>
                    </div>
                    <small>
                        <p>Die mit einem Stern* versehenen Felder sind Pflichtangaben.</p>
                    </small>
                    <button type="submit" id="submit-single-registration" class="nav-button">Einzelmeldung abschicken</button>
            </fieldset>

            <fieldset id="file-upload-fieldset">
                <!-- ... Sammelanmeldungsformular ... -->
                <legend>Hier kann eine Meldedatei hochgeladen werden.</legend>
                <h2>Sammelanmeldung</h2>
                <div>
                    <a href="#" class="upload-link" id="fileupload-link">Meldedatei hochladen</a>
                    <details>
                        <summary>
                            Bitte verwende nur diese Vorlage für die Meldedatei: <a href="data/VorlageMeldedatei.xlsx" download>VorlageMeldedatei.xlsx</a>
                        </summary>
                        <p>Die Meldeliste muss den Vorgaben für das Programm Winlaufen des Deutschen Skiverbandes entsprechen.</p>
                        <p>Die Spaltenköpfe der Tabelle dürfen von dir nicht verändert werden.</p>
                    </details>
                </div>
            </fieldset>
            </form>
        </div>

        <!-- Container für die Bestätigungsseite nach der Anmeldung -->
        <div class="container conformation">
            <!-- ... (Bestätigungsinformationen hier) ... -->
        </div>

        <!-- Container für die Anzeige der Teilnehmerliste -->
        <div class="container participants">
            <h1>Meldeliste</h1>
            <div id="table_participants">
                <!-- ... (Teilnehmerliste hier) ... -->
            </div>
        </div>

        <!-- Container für das Sammelanmeldeformular per Dateiupload -->
        <div class="container fileupload">
            <h1>Anmeldung</h1>
            <fieldset id="multiple-registration-fieldset">
                <h2>Sammelanmeldung</h2>
                <!-- Formular für den Dateiupload -->
                <form id="uploadForm" enctype="multipart/form-data">
                    <!-- ... (Formularfelder hier) ... -->
                    <input type="file" name="uploadedFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
                    <button type="button" id="uploadButton">Meldedatei hochladen</button>
                    <!-- Rückgabebereich für die Nachricht vom Server -->
                    <aside id="uploadResult">
                        <p></p>
                    </aside>
                </form>
            </fieldset>
        </div>

        <!-- Container für die Abmeldeseite -->
        <div class="container unsubscribe">
            <div class="frame">
                <!-- ... (Abmeldetext hier) ... -->
                <p>Auf Wiedersehen!</p>
                <p>Danke für deine Anmeldung.</p>
                <p>Wir wünschen dir eine gute Anreise zum Wettkampf.</p>
            </div>
        </div>

        <!-- Container für die Adminseite -->
        <div class="container admin" id="admin-container">
            <div class="frame">
                <h1>Adminbereich</h1>
                <form method="post" action="php/admin.php">
                    <label for="username">Benutzername:</label>
                    <input type="text" id="username" name="username" required><br>

                    <label for="password">Passwort:</label>
                    <input type="password" id="password" name="password" required><br>

                    <button type="submit">Anmelden</button>
                </form>
                <!-- Anzeige des Info-Messages -->
                <aside class="info-message">
                    <?php
                    if (isset($_GET['infoMessage'])) {
                        echo htmlspecialchars($_GET['infoMessage']);
                    }
                    ?>
                </aside>
            </div>
        </div>

        <!-- Navigationsleiste mit Verweisen auf verschiedene Formularabschnitte -->
        <!-- Container für die untere Navigation -->
        <nav class="bottom-navigation">
            <a href="#" class="nav-button" id="registration-link-bottom">Weitere Anmeldung</a>
            <a href="#" class="nav-button" id="participants-link-bottom">Meldeliste anzeigen</a>
            <a href="#" class="nav-button" id="unsubscribe-link-bottom">Anmeldung beenden</a>
        </nav>
    </div>
</body>

<!-- JavaScript-Dateien für die Funktionalität der Seite -->
<script src="js/main.js"></script>
<script src="js/getAssociation.js"></script>

</html>
