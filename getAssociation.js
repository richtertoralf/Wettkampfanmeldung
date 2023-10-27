/**
 * Event-Listener für Änderungen am Eingabefeld Verein.
 * Sendet eine XMLHttpRequest an den Server und aktualisiert das Feld "association" mit der Serverantwort.
 *
 * @function
 * @event change
 * @memberof window
 * @name selectedClub~changeListener
 */
document.getElementById("selectedClub").addEventListener("change", function () {
    /**
     * Der ausgewählte Verein.
     * @type {string}
     */
    var selectedClub = this.value;

    /**
     * Neue XMLHttpRequest-Instanz für die Anfrage an den Server.
     * @type {XMLHttpRequest}
     */
    var xhr = new XMLHttpRequest();

    // Anfrage-Parameter festlegen
    xhr.open("POST", "getAssociation.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Fehlerbehandlung für die Anfrage
    xhr.onerror = function () {
        // Konsolenausgabe bei Anfragefehler
        // console.error("Es ist ein Fehler aufgetreten während der Anfrage.");
    };

    /**
     * Funktion, die aufgerufen wird, wenn sich der Status der Anfrage ändert.
     * Aktualisiert das Feld "association" mit der Serverantwort, wenn die Anfrage erfolgreich ist.
     *
     * @callback
     * @param {Event} event - Das Anfrage-Event-Objekt.
     */
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                // Feld "association" mit der Serverantwort aktualisieren
                document.getElementById("association").value = xhr.responseText;
                // Konsolenausgabe der Serverantwort
                // console.log("Antwort des Servers: " + xhr.responseText);
            } else {
                // Konsolenausgabe bei Anfragefehlschlag
                // console.error("Anfrage fehlgeschlagen mit Statuscode: " + xhr.status);
            }
        }
    };

    // Anfrage senden und ausgewählten Verein übermitteln
    xhr.send("selectedClub=" + selectedClub);
});
