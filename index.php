<?php

/**
 * index.php
 *
 * Dieses Skript stellt ein einfaches Formular zur Wettkampfanmeldung dar.
 * Es erfasst Informationen wie Name, Vorname, Geschlecht, Jahrgang,
 * Verein, Verband, Gruppenauswahl und E-Mail-Adresse des Teilnehmers.
 * Die eingegebenen Daten werden an 'conformation.php' zur Bestätigung weitergeleitet.
 * Außerdem gibt es die Möglichkeit, eine Sammelanmeldung per Dateiupload durchzuführen.
 * Die Upload-Datei im xls-Format muss folgende Spalten enthalten:
 * FIS-Code-Nr.,Name,Vorname,Verband,Verein,Jahrgang,Geschlecht,FIS-Distanzpunkte,FIS-Sprintpunkte,
 * Startnummer,Gruppe,DSV-Code-Nr.,Startpass,Waffen-Nr.,Nation,Transponder-ID
 * Diese Struktur entspricht der Winlaufen-Importdatei und kann auch direkt in Winlaufen importiert werden.
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anmeldung</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Container für das Wettkampfanmeldeformular -->
    <div class="container registration">
        <!-- Überschrift des Formulars -->
        <h2>Anmeldung</h2>

        <!-- Formular zur Einzelanmeldung, leitet Daten an 'conformation.php' weiter -->
        <form action="conformation.php" method="post">

            <!-- Eingabefeld für die Startpassnummer -->
            <label for="formSpNr">Startpass</label>
            <input type="text" name="regEntry[0][SpNr]">
            <!-- Hinweis zur korrekten Formatierung der Startpassnummer -->
            <!-- <aside>
                <p>Die SVSAC Startpassnummer besteht aus zwei vierstelligen Zahlenreihen, die mit einem Bindestrich verbunden sind, z.B. 2487-8421. Die Nummer findest du auf deinem SVS-Ausweis.</p>
            </aside> -->

            <!-- Eingabefeld für den Nachnamen -->
            <label for="formsurname">Nachname<span class="required">*</span></label>
            <input type="text" name="regEntry[0][surname]" required>

            <!-- Eingabefeld für den Vornamen -->
            <label for="formforename">Vorname<span class="required">*</span></label>
            <input type="text" name="regEntry[0][forename]" required>

            <!-- Dropdown-Menü für das Geschlecht -->
            <label for="formsex">Geschlecht<span class="required">*</span></label>
            <select name="regEntry[0][sex]" required>
                <option value="m">männlich</option>
                <option value="w">weiblich</option>
            </select>

            <!-- Eingabefeld für das Geburtsjahr -->
            <label for="formyearofbirth">Geburtsjahr<span class="required">*</span></label>
            <input type="text" name="regEntry[0][yearofbirth]" required>
            <!-- <aside>
                <p>Der Jahrgang muss als vierstellige Zahl angegeben werden, "1989".</p>
            </aside> -->
            <!-- Eingabefeld für den Verein -->
            <label for="formclub">Verein<span class="required">*</span></label>
            <input type="text" name="regEntry[0][club]" required>

            <!-- Eingabefeld für den Verband -->
            <label for="formclub">Verband</label>
            <input type="text" name="regEntry[0][association]">

            <!-- Dropdown-Menü für die Gruppenauswahl -->
            <label for="formgroup">Startgruppe</label>
            <select name="regEntry[0][group]">
                <?php
                // Schleife zum Generieren von Gruppenoptionen (1 bis 4)
                for ($i = 1; $i <= 4; $i++) {
                    echo "<option value=\"$i\">$i</option>";
                }
                ?>
            </select>

            <!-- Eingabefeld für die E-Mail-Adresse -->
            <label for="formsingle_email">E-Mail<span class="required">*</span></label>
            <input type="email" name="single_email" required>
            <aside>
                <p>Die mit einem roten Stern versehenen Felder sind Pflichtangaben.</p>
            </aside>
            <!-- Absenden-Button -->
            <nav>
                <button type="submit" name="submit" class="nav-button">Einzelmeldung abschicken</button>
                <a href="upload.php" class="nav-button">Meldeliste hochladen</a>
            </nav>

        </form>
    </div>
</body>

</html>
