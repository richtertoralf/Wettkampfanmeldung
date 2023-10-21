<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wettkampfanmeldung</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h2>Einzelanmeldung</h2>
        <form action="conformation.php" method="post">
            <label for="formSpNr">Startpassnummer SVSAC</label>
            <input type="text" name="regEntry[0][SpNr]" required>
            <small>Die Startpassnummer besteht aus zwei vierstelligen Zahlenreihen, die mit einem Bindestrich verbunden sind, z.B. 2487-8421.</small>

            <label for="formsurname">Nachname<span class="required">*</span></label>
            <input type="text" name="regEntry[0][surname]" required>

            <label for="formforename">Vorname<span class="required">*</span></label>
            <input type="text" name="regEntry[0][forename]" required>

            <label for="formsex">Geschlecht<span class="required">*</span></label>
            <select name="regEntry[0][sex]" required>
                <option value="m">männlich</option>
                <option value="w">weiblich</option>
            </select>

            <label for="formyearofbirth">Geburtsjahr<span class="required">*</span></label>
            <input type="text" name="regEntry[0][yearofbirth]" required>

            <label for="formgroup">Gruppe</label>
            <input type="number" name="regEntry[0][group]">
            <small>Gültige Gruppen sind 1, 2, 3 und 4.</small>

            <label for="formsingle_email">E-Mail<span class="required">*</span></label>
            <input type="email" name="single_email" required>
            <nav>
                <button type="submit" name="submit">Abschicken</button>
            </nav>
        </form>
    </div>
</body>

</html>
