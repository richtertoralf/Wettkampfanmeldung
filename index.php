<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Wettkampfanmeldung</title>
</head>

<body>
    <div class="container">
        <h2>Einzelanmeldung</h2>
        <form action="https://www.atsv-sport.de/ski/anmeldung" method="post">
            <div class="form-group">
                <label for="formSpNr">Startpassnummer SVSAC</label>
                <input type="text" class="form-control" id="formSpNr" name="regEntry[0][SpNr]" required>
                <small class="form-text text-muted">Die Startpassnummer besteht aus zwei vierstelligen Zahlenreihen, die mit einem Bindestrich verbunden sind, z.B. 2487-8421.</small>
            </div>
            <div class="form-group">
                <label for="formsurname">Nachname<span class="atsv-ski-reg-required">*</span></label>
                <input type="text" class="form-control" id="formsurname" name="regEntry[0][surname]" required>
            </div>
            <div class="form-group">
                <label for="formforename">Vorname<span class="atsv-ski-reg-required">*</span></label>
                <input type="text" class="form-control" id="formforename" name="regEntry[0][forename]" required>
            </div>
            <div class="form-group">
                <label for="formsex">Geschlecht<span class="atsv-ski-reg-required">*</span></label>
                <select class="custom-select" id="formsex" name="regEntry[0][sex]" required>
                    <option value="m">männlich</option>
                    <option value="w">weiblich</option>
                </select>
            </div>
            <div class="form-group">
                <label for="formgroup">Gruppe</label>
                <input type="number" class="form-control" id="formgroup" name="regEntry[0][group]">
                <small class="form-text text-muted">Gültige Gruppen sind 1, 2, 3 und 4.</small>
            </div>
            <div class="form-group">
                <label for="formsingle_email">E-Mail<span class="atsv-ski-reg-required">*</span></label>
                <input type="email" class="form-control" id="formsingle_email" name="single_email" required>
            </div>
            <div class="form-group">
                <label for="formMessage">Anmerkung</label>
                <textarea class="form-control" id="formMessage" name="single_message" maxlength="4000"></textarea>
            </div>
               <button type="submit" name="submit" class="btn btn-primary mt-3">Abschicken</button>
        </form>
    </div>
</body>

</html>
