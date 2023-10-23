<?php
/**
 * index.php
 *
 * Dieses Skript stellt ein einfaches Formular zur Wettkampfanmeldung dar.
 * Es erfasst Informationen wie Startpassnummer, Name, Geschlecht, Geburtsjahr,
 * Verein, Gruppenauswahl und E-Mail-Adresse des Teilnehmers.
 * Die eingegebenen Daten werden an 'conformation.php' zur Bestätigung weitergeleitet.
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
    <title>Wettkampfanmeldung</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Container für das Wettkampfanmeldeformular -->
    <div class="container_registration">
        <!-- Überschrift des Formulars -->
        <h2>Einzelanmeldung</h2>
        
        <!-- Formular zur Einzelanmeldung, leitet Daten an 'conformation.php' weiter -->
        <form action="conformation.php" method="post">
            
            <!-- Eingabefeld für die Startpassnummer -->
            <label for="formSpNr">Startpassnummer SVSAC</label>
            <input type="text" name="regEntry[0][SpNr]" required>
            <!-- Hinweis zur korrekten Formatierung der Startpassnummer -->

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

            <!-- Eingabefeld für den Verein -->
            <label for="formclub">Verein<span class="required">*</span></label>
            <input type="text" name="regEntry[0][club]" required>

            <!-- Dropdown-Menü für die Gruppenauswahl -->
            <label for="formgroup">Gruppe</label>
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

            <!-- Absenden-Button -->
            <nav>
                <button type="submit" name="submit">Abschicken</button>
            </nav>
        </form>
    </div>
</body>

</html>
