document.getElementById("selectedClub").addEventListener("change", function () {
    var selectedClub = this.value;

    // console.log("Ausgewählter Verein: " + selectedClub);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "getAssociation.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onerror = function() {
        // console.error("Es ist ein Fehler aufgetreten während der Anfrage.");
    };

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                document.getElementById("association").value = xhr.responseText;
                // console.log("Antwort des Servers: " + xhr.responseText);
            } else {
                // console.error("Anfrage fehlgeschlagen mit Statuscode: " + xhr.status);
            }
        }
    };

    xhr.send("selectedClub=" + selectedClub);
});
