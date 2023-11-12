/**
 * Funktionen zur Steuerung der Container-Anzeige
 * @namespace
 */

document.addEventListener('DOMContentLoaded', function () {

    /**
     * Zeigt das Registrierungsformular an und setzt es zurück.
     * @function
     */
    function showRegistrationForm() {
        hideAllContainers();
        var registrationForm = document.getElementById('registrationForm');
        registrationForm.reset(); // Formular zurücksetzen
        document.querySelector('.container.registration').style.display = 'block';
    }

    /**
     * Zeigt die Teilnehmerliste an und ruft die Daten vom Server ab.
     * @function
     */
    function showParticipants() {
        hideAllContainers();
        var participantsContainer = document.querySelector('.container.participants');
        var tableParticipantsContainer = document.getElementById('table_participants'); // ID des Containers

        // AJAX-Anfrage, um Teilnehmerdaten vom Server abzurufen
        fetch('php/getParticipants.php')
            .then(response => response.json())
            .then(data => {
                // console.log('JSON-Daten vom Server:', data); // JSON-Daten in der Konsole anzeigen
                // Hier die Antwort vom Server verarbeiten
                if (data.success) {
                    var participantsTableHTML = '<table border="1"><tr><th>Name</th><th>Vorname</th><th>Verein</th><th>Jahrgang</th><th>m/w</th></tr>';

                    data.participants.forEach(participant => {
                        participantsTableHTML += '<tr>';
                        participantsTableHTML += '<td>' + participant.Name + '</td>';
                        participantsTableHTML += '<td>' + participant.Vorname + '</td>';
                        participantsTableHTML += '<td>' + participant.Verein + '</td>';
                        participantsTableHTML += '<td>' + participant.Jahrgang + '</td>';
                        participantsTableHTML += '<td>' + participant.Geschlecht + '</td>';
                        participantsTableHTML += '</tr>';
                    });

                    participantsTableHTML += '</table>';

                    // Tabelle nur innerhalb des table_participants-Containers einfügen
                    tableParticipantsContainer.innerHTML = participantsTableHTML;
                    participantsContainer.style.display = 'block';
                } else {
                    tableParticipantsContainer.innerHTML = 'Fehler beim Laden der Teilnehmerdaten.';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                tableParticipantsContainer.innerHTML = 'Fehler beim Laden der Teilnehmerdaten.';
            });
    }

    /**
     * Zeigt die Abmeldeseite an.
     * @function
     */
    function showUnsubscribeForm() {
        hideAllContainers();
        document.querySelector('.container.unsubscribe').style.display = 'block';
    }

    /**
     * Zeigt das Formular für den Dateiupload an.
     * @function
     */
    function showFileUpload() {
        hideAllContainers();
        document.querySelector('.container.fileupload').style.display = 'block';
    }

    /**
     * Zeigt die Adminseite an.
     * @function
     */
    function showAdminForm() {
        hideAllContainers();
        document.querySelector('.container.admin').style.display = 'block';
    }

    /**
     * Versteckt alle Container auf der Seite.
     * @function
     */
    function hideAllContainers() {
        var containers = document.querySelectorAll('.container');
        containers.forEach(function (container) {
            container.style.display = 'none';
        });
    }

    // Eventlistener für das Burger-Menu
    document.querySelector('.burger-menu').addEventListener('click', function () {
        var navBurgers = document.querySelectorAll('.nav-burger');
        navBurgers.forEach(function (burger) {
            var currentDisplay = window.getComputedStyle(burger).getPropertyValue('display');
            burger.style.display = (currentDisplay === 'none') ? 'block' : 'none';
        });

        // Ändere das Burger-Symbol basierend auf dem aktuellen Status
        var burgerMenu = document.getElementById('burger-menu');
        var isOpen = burgerMenu.innerHTML === '☰';

        // Wenn das Menü geöffnet ist, zeige ein Kreuzsymbol an, sonst die drei Balken
        burgerMenu.innerHTML = isOpen ? '✕' : '☰';
    });


    // Selektiere die Navigationslinks
    // für die untere Navigationsleiste
    var registrationLinkBottom = document.getElementById('registration-link-bottom');
    var participantsLinkBottom = document.getElementById('participants-link-bottom');
    var unsubscribeLinkBottom = document.getElementById('unsubscribe-link-bottom');
    // für die anderen Navigationslinks
    var registrationLink = document.getElementById('registration-link');
    var participantsLink = document.getElementById('participants-link');
    var unsubscribeLink = document.getElementById('unsubscribe-link');
    var fileuploadLink = document.getElementById('fileupload-link');
    var adminLink = document.getElementById('admin-link');

    /**
     * Event-Listener für den Klick auf den Registrierungslink.
     * Zeigt das Registrierungsformular als Standart beim Neuladen der Seite an.
     * @event
     */
    registrationLink.addEventListener('click', function (event) {
        event.preventDefault(); // Verhindert das Standardverhalten des Links
        showRegistrationForm();
    });

    registrationLinkBottom.addEventListener('click', function (event) {
        event.preventDefault(); // Verhindert das Standardverhalten des Links
        showRegistrationForm();
    });

    /**
     * Event-Listener für den Klick auf den Teilnehmerlistenlink.
     * Zeigt die Teilnehmerliste an und ruft die Daten vom Server ab.
     * @event
     */
    participantsLink.addEventListener('click', function (event) {
        event.preventDefault(); // Verhindert das Standardverhalten des Links
        showParticipants();
    });
    participantsLinkBottom.addEventListener('click', function (event) {
        event.preventDefault(); // Verhindert das Standardverhalten des Links
        showParticipants();
    });

    /**
     * Event-Listener für den Klick auf den Dateiupload-Link.
     * Zeigt das Formular für den Dateiupload an.
     * @event
     */
    fileuploadLink.addEventListener('click', function (event) {
        event.preventDefault(); // Verhindert das Standardverhalten des Links
        showFileUpload();
    });

    /**
     * Event-Listener für den Klick auf den Abmelde-Link.
     * Zeigt die Abmeldeseite an.
     * @event
     */
    unsubscribeLink.addEventListener('click', function (event) {
        event.preventDefault(); // Verhindert das Standardverhalten des Links
        showUnsubscribeForm();
    });
    unsubscribeLinkBottom.addEventListener('click', function (event) {
        event.preventDefault(); // Verhindert das Standardverhalten des Links
        showUnsubscribeForm();
    });

    /**
     * Event-Listener für den Klick auf den Admin-Link.
     * Zeigt die Adminseite an.
     * @event
     */
    adminLink.addEventListener('click', function (event) {
        event.preventDefault(); // Verhindert das Standardverhalten des Links
        showAdminForm();
    });

    // Zeigt standardmäßig, bei jedem Neuladen der Seite, das Registrierungsformular an
    // showRegistrationForm();

    var urlParams = new URLSearchParams(window.location.search);
    var triggerAdmin = urlParams.get('triggerAdmin');

    if (triggerAdmin === 'true') {
        console.log('Triggering admin form');
        showAdminForm();
        console.log('Is admin container visible:', document.querySelector('.container.admin').style.display);
    } else {
        // Wenn der triggerAdmin-Parameter nicht vorhanden ist oder 'false' ist
        // Zeige standardmäßig das Registrierungsformular an
        console.log('Triggering registration form');
        showRegistrationForm();
        console.log('Is registration container visible:', document.querySelector('.container.registration').style.display);
    }


    /**
     * Event-Listener für das Absenden des Einzelanmeldeformulars.
     * Validiert die Formularfelder und sendet die Daten an den Server.
     * @event
     */
    document.getElementById('registrationForm').addEventListener('submit', function (event) {
        // Verhindere das Standardverhalten des Formulars (Seitenneuladen)
        event.preventDefault();

        // Validierung aller Formularfelder
        var formFields = document.querySelectorAll('#registrationForm input, #registrationForm select');
        var allFieldsValid = true;

        // Wenn alle Felder gültig sind, sende die Daten mit Fetch
        if (allFieldsValid) {
            var formData = new FormData(document.getElementById('registrationForm'));

            // console.log('Formular abgeschickt'); // Überprüfen, ob der Event-Listener ausgelöst wird
            // FormData-Objekt erstellen und Formulardaten hinzufügen
            var formData = new FormData(document.getElementById('registrationForm'));

            // Zeige den Inhalt von formData in der Konsole an
            // console.log('Formulardaten:', formData);

            // AJAX-Anfrage senden, um die Formulardaten an den Server zu schicken
            fetch('php/conformation.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json()) // Antwort vom Server als json empfangen
                .then(data => {
                    // Hier die Antwort vom Server verarbeiten
                    if (data.success) {
                        console.log(data);
                        var tableHTML = '<table>';

                        // Nachricht als Caption in die Tabelle einfügen
                        tableHTML += '<caption>' + data.message + '</caption>';

                        for (var key in data.data) {
                            tableHTML += '<tr><td>' + key + ':</td><td>' + data.data[key] + '</td></tr>';
                        }
                        tableHTML += '</table>';

                        // Container einblenden
                        hideAllContainers();
                        document.querySelector('.container.conformation').style.display = 'block';

                        // Daten in den Container einfügen
                        document.querySelector('.container.conformation').innerHTML = tableHTML;

                    } else {
                        console.error('Fehler beim Server: ' + data.message);
                    }

                })
                .catch(error => {
                    // Hier kannst du Fehler beim Senden der Daten behandeln
                    console.error('Error:', error);
                });
        } else {
            console.log("Das Formular ist ungültig, die HTML5-Validierung zeigt Fehlermeldungen an");
        }
    });

    document.getElementById('uploadButton').addEventListener('click', function () {
        var formData = new FormData(document.getElementById('uploadForm'));

        // AJAX-Anfrage senden, um die Formulardaten an den Server zu schicken
        fetch('php/upload.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text()) // Antwort vom Server als Text empfangen
            .then(data => {
                // Hier die Antwort vom Server verarbeiten und anzeigen
                document.getElementById('uploadResult').innerHTML = data;
            })
            .catch(error => {
                // Hier kannst du Fehler beim Senden der Daten behandeln
                console.error('Error:', error);
            });
    });

});
