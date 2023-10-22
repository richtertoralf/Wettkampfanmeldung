# Wettkampfanmeldung (sport-registration)
simples Beispiel für eine Webseite zur Anmeldung bei einem Wettkampf
## Installation von nginx und php auf Ubuntu 22.04
```
# Installierenvon nginx und php
sudo apt update -y && sudo apt upgrade -y
sudo apt install nginx php-fpm -y
# welche Versionen wurde installiert?
php -v && nginx -v
# mich der Gruppe www-data hinzufügen, damit ich Änderungen an den Inhaltsdateien für die Webseite vornehmen kann:
sudo adduser $USER www-data
# danach ab- und wieder anmelden
```
## nginx und php konfigurieren
Debian und Ubuntu Distributionen haben für die Konfiguration die Datei /etc/nginx/sites-available/default hinzugefügt und dann einen Symlink zu /etc/nginx/sites-enabled/ gesetzt. Das ist typisch für einen Apache2-Server, nicht aber für nginx. Der nginx-Standart ist die Verwendung von Konfigurationsdateien im Ordner /etc/nginx/conf.d/ Dieser Ordner ist nach der Installation leer. Dort könnte eine Konfigurationsdatei abelegt werden.  
Ich bleibe aber bei dem Debian/Ubuntu Sonderweg.
```
# Symlink zur vorhandenen Konfiguratiionsdatei löschen, damit diese Einstellungen nicht zu Konflikten führen. 
# sudo rm /etc/nginx/sites-available/default
sudo rm /etc/nginx/sites-enabled/default
```
```
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
# schalte die sport-registration.conf ein, indem ich den Symlink setze:
sudo ln -s /etc/nginx/sites-available/sport-registration.conf /etc/nginx/sites-enabled/
# Berechtigungen setzen
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 775 /var/www/html
# teste die Konfiguration
sudo nginx -t
# Starte Nginx neu, um die Änderungen zu übernehmen
sudo systemctl restart nginx
sudo systemctl restart php*
# Testen ob nginx und php läuft_
sudo systemctl status nginx.service
sudo systemctl status php*
# sudo systemctl status php$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;")-fpm
# zum Testen, eine phpinfo Datei anlegen:
# echo "<?php phpinfo(); ?>" | sudo tee /var/www/html/sport-registration/phpinfo.php
# und im Browser aufrufen...
```
## Seiteninhalte einfügen
```
cd /var/www/html
git clone https://github.com/richtertoralf/sport-registration/
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 775 /var/www/html
```
