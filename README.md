# Wettkampfanmeldung (sport-registration)
Dieses Repository stellt ein einfaches Beispiel für eine Webseite zur Wettkampfanmeldung dar.
### Beschreibung
Diese Anwendung ermöglicht Sportlern, sich selbst für einen Wettbewerb anzumelden, indem sie persönliche Informationen wie Name, Vorname, Geschlecht, Geburtsjahr, Verein, Verband, Startgruppe und E-Mail-Adresse über ein Formular eingeben. Zusätzlich besteht die Option, sich gruppenweise über einen Dateiupload anzumelden. Dazu wird eine Vorlage verwendet, die es Vereinen ermöglicht auch zusätzliche Angaben, wie z.B. DSV-Code, FIS-Code, Nation und waffen-Nr. für Biathlonwettbewerbe anzugeben.  
Es gibt einen Admin-Bereich, über den die Wettkampfinformationen (Wettkampfname, Wettkampfdatum und Ausrichter) füe die Webseite eingetragen werden können.  
Adinistratoren können die komplette Meldeliste für den direkten Import in Winlaufen herunterladen.

### Adminzugang
In der Datei `ini/user.ini` sind die Zugangsdaten für den Adminbereich abgelegt.
```
; user.ini
[admin]
username=admin
password=winlaufen
```

## Installation per cloud-init
>In der Datei cloud-init findest du einen Vorschlag, um den Server automatisch aufzusetzen und die Webanwendung einzurichten. Du solltest nur darauf achten, eine Ubuntu Distribution z. B. 22.04, auzuwählen. Getestet habe ich diese cloud-init bei Hetzner.

## Installation in VirtualBox per vagrant
>Du kannst das Vagrantfile nutzen, um in Oracle VirtualBox automatisch diese Webanwendung für Testzwecke zu installieren.

## Installation per Hand
### nginx und php auf Ubuntu 22.04
```
# Aktualisiere das System und installiere nginx und php mit composer
sudo apt update -y && sudo apt upgrade -y
sudo apt install nginx php-fpm composer git -y
sudo apt install php-dom php-gd php-xml php-xmlreader php-xmlwriter php-zip -y

# Überprüfe die installierten Versionen
php -v && nginx -v
# zeige alle installierten Pakete an
dpkg-query -W -f='${Status} ${Package}\n' | grep '^install ok installed' | grep php

# Füge deinen Benutzer zur www-data Gruppe hinzu, um Änderungen an den Webseite-Inhaltsdateien vornehmen zu können
sudo adduser $USER www-data

# Logge dich aus und wieder ein, um die Gruppenänderungen zu übernehmen
```
### Konfiguration von nginx und php
Nach der Installation von nginx und php müssen die Konfigurationsdateien entsprechend angepasst werden. In diesem Fall folgen wir dem Debian/Ubuntu-Sonderweg für die nginx-Konfiguration.
```
# Lösche den Symlink zur vorhandenen Konfigurationsdatei, um Konflikte zu vermeiden
sudo rm /etc/nginx/sites-enabled/default

# Definiere den Inhalt der Nginx-Konfigurationsdatei für die Verwendung von php
CONFIG=$(cat << 'EOL'
server {
    listen 80;
    server_name _;
    root /var/www/html/sport-registration;
    index index.php index.html index.htm;
    location / {
        try_files $uri $uri/ =404;
    }
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
    }
    location ~ /\.ht {
        deny all;
    }
}
EOL
)

# Schreibe den Konfigurationsinhalt in die Datei
echo "$CONFIG" | sudo tee /etc/nginx/sites-available/sport-registration.conf

# Aktiviere die sport-registration.conf, indem du den Symlink setzt
sudo ln -s /etc/nginx/sites-available/sport-registration.conf /etc/nginx/sites-enabled/

# Setze die Berechtigungen für das Webverzeichnis
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 775 /var/www/html

# Überprüfe die nginx-Konfiguration
sudo nginx -t

# Starte Nginx und php-fpm neu, um die Änderungen zu übernehmen
sudo systemctl restart nginx
sudo systemctl restart php8.1-fpm

```
### Seiteninhalte einfügen
```
# Wechsle zum Webverzeichnis
cd /var/www/html

# Klone das sport-registration-Repository
git clone https://github.com/richtertoralf/sport-registration/

# Wechsel ins Projektverzeichnis und installiere phpoffice/phpspreadsheet per composer
cd /var/www/html/sport-registration
composer require phpoffice/phpspreadsheet
# Dieses Modul wird zum Upload und Download von Microsoft Excel-Dateien benötigt.

# Setze die Berechtigungen für das Repository
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 775 /var/www/html
```
### Konfiguration der Webseite
>In der Datei `data/raceInfo.ini` befinden sich die Daten zum Wettkampf: Wettkampfname, Ausrichter und Wettkampfdatum. Über den Adminbereich können diese daten geändert werden. In diesem einfachen Beispiel wird auf eine Datenbank verzichtet, um die Komplexität gering zu halten.

```
; raceInfo.ini
EventName = "Silvesterlauf"
Organizer = "SSV 1863 Sayda"
Date = "31.12.2023"
```
>In der Datei `ini/user.ini` sind die Zugangsdaten für den Adminbereich abgelegt.
```
; user.ini
[admin]
username=admin
password=winlaufen
```

>Die gemeldeten Sportler werden in der Datei `data/data.csv` gespeichert, weil das ein einfaches und gut lesbares Format ist. Ich verwende folgende Spalten, die der aktuellen Vorlage für Winlaufen zuzüglich einem Feld für "E-Mail" entsprechen.

```
FIS-Code-Nr.,Name,Vorname,Verband,Verein,Jahrgang,Geschlecht,FIS-Distanzpunkte,FIS-Sprintpunkte,Startnummer,Gruppe,DSV-Code-Nr.,Startpass,Waffen-Nr.,Nation,Transponder-ID,E-Mail
```
