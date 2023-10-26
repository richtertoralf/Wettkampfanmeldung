<?php

/**
 * index.php
 *
 * Dieses Skript stellt ein einfaches Formular zur Wettkampfanmeldung dar.
 * Es erfasst Informationen wie Name, Vorname, Geschlecht, Jahrgang,
 * Verein, Verband, Gruppenauswahl und E-Mail-Adresse des Teilnehmers.
 * Die eingegebenen Daten werden an 'conformation.php' zur Bestätigung weitergeleitet.
 * Außerdem gibt es die Möglichkeit, eine Sammelanmeldung per Dateiupload durchzuführen.
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

    <div class="container registration">
        <h2>Anmeldung</h2>
        <nav>
            <a href="participants.php" class="nav-button">Meldeliste anzeigen</a>
        </nav>
        <!-- Formular zur Einzelanmeldung, leitet Daten an 'conformation.php' weiter -->
        <form action="conformation.php" method="post">

            <fieldset>
                <legend>Hier können sich einzelne Sportler anmelden.</legend>
                <h3>Einzelanmeldung</h3>
                <div>
                    <label for="formSpNr">Startpass</label>
                    <input type="text" name="regEntry[0][SpNr]">
                    <small>
                        <p>SVSAC Startpassnummer besteht aus zwei vierstelligen Zahlenreihen, die mit einem Bindestrich verbunden sind, z.B. 2487-8421. Die Nummer findest du auf deinem SVS-Ausweis.
                        <p>
                    </small>
                </div>
                <div>
                    <label for="formsurname">Nachname<span class="required">*</span></label>
                    <input type="text" name="regEntry[0][surname]" required>
                </div>
                <div>
                    <label for="formforename">Vorname<span class="required">*</span></label>
                    <input type="text" name="regEntry[0][forename]" required>
                </div>
                <div>
                    <label for="formsex">Geschlecht<span class="required">*</span></label>
                    <select name="regEntry[0][sex]" required>
                        <option value="m">männlich</option>
                        <option value="w">weiblich</option>
                    </select>
                </div>
                <div>
                    <label for="formyearofbirth">Geburtsjahr<span class="required">*</span></label>
                    <input type="text" name="regEntry[0][yearofbirth]" pattern="(?:19|20)[0-9]{2}" required>
                    <small>
                        <p>Das Geburtsjahr muss als vierstellige Zahl angegeben werden, z.B. "1989".</p>
                    </small>
                </div>
                <div>
                    <label for="formclub">Verein<span class="required">*</span></label>
                    <input type="text" name="regEntry[0][club]" required>
                </div>
                <div>
                    <label for="formclub">Verband</label>
                    <input type="text" name="regEntry[0][association]">
                </div>
                <div>
                    <label for="formgroup">Startgruppe</label>
                    <select name="regEntry[0][group]">
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
                    <input type="email" name="single_email" required>
                </div>
                <small>
                    <p>Die mit einem Stern* versehenen Felder sind Pflichtangaben.</p>
                </small>
                <button type="submit" name="submit" class="nav-button">Einzelmeldung abschicken</button>
            </fieldset>

            <fieldset>
                <legend>Hier kann eine Meldedatei hochgeladen werden.</legend>
                <h3>Sammelanmeldung</h3>
                <div>
                    <a href="upload.php" class="nav-button">Meldedatei hochladen</a>
                    <details>
                        <summary>
                            Bitte verwende unbedingt diese Vorlage für die Meldedatei: <a href="VorlageMeldedatei.csv" download>VorlageMeldedatei.csv</a>
                        </summary>
                        <p>Die Meldeliste muss den Vorgaben für das Programm Winlaufen des Deutschen Skiverbandes entsprechen.</p>
                        <p>Die Spaltenköpfe dürfen nicht verändert werden.</p>
                    </details>
                </div>
            </fieldset>

        </form>
    </div>
</body>

</html>
