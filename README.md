# Wettkampfanmeldung (sport-registration)
Dieses Repository stellt ein einfaches Beispiel für eine Webseite zur Wettkampfanmeldung dar.

## Installation per cloud-init
>In der Datei cloud-init findest du einen Vorschlag, um den Server automatisch zu installieren und zu konfigurieren. Du solltest nur darauf achten, eine Ubuntu Distribution z. B. 22.04, auzuwählen. Getestet habe ich diese cloud-init bei Hetzner.
## Installation von nginx und php auf Ubuntu 22.04
```
# Aktualisiere das System und installiere nginx und php mit composer
sudo apt update -y && sudo apt upgrade -y
sudo apt install nginx php-fpm composer git -y
# fehlender Pakete für composer nachinstallieren
sudo apt install php-dom php-gd php-simplexml php-xml php-xmlreader php-xmlwriter php-zip
# composer aktivieren
cd /var/www/html
composer init --no-interaction --name="$USER/html" --description="sport-registration"
composer require phpoffice/phpspreadsheet

# Überprüfe die installierten Versionen
php -v && nginx -v
# zeige alle installierten Pakete an
dpkg-query -W -f='${Status} ${Package}\n' | grep '^install ok installed' | grep php

# Füge deinen Benutzer zur www-data Gruppe hinzu, um Änderungen an den Webseite-Inhaltsdateien vornehmen zu können
sudo adduser $USER www-data

# Logge dich aus und wieder ein, um die Gruppenänderungen zu übernehmen
```
## Konfiguration von nginx und php
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
## Seiteninhalte einfügen
```
# Wechsle zum Webverzeichnis
cd /var/www/html

# Klone das sport-registration-Repository
git clone https://github.com/richtertoralf/sport-registration/

# Setze die Berechtigungen für das Repository
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 775 /var/www/html

```
