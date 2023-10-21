# Wettkampfanmeldung
simples Beispiel für eine Webseite zur Anmeldung bei einem Wettkampf
## Installation von nginx und php auf Ubuntu 22.04
```
# Installieren
sudo apt update -y && sudo apt upgrade -y
sudo apt install nginx
sudo apt install php-fpm
# Testen ob nginx und php läuft_
sudo systemctl status nginx.service
php -v
sudo systemctl status php$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;")-fpm
```
## nginx und php konfigurieren
```
# Definiere den Inhalt der Nginx-Konfigurationsdatei
CONFIG=$(cat << 'EOL'
server {
    listen 80;
    server_name _;
    root /var/www/html; # Der Pfad zum Root-Verzeichnis der Website
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
echo "$CONFIG" | sudo tee /etc/nginx/conf.d/sport-registration.conf > /dev/null
# Starte Nginx neu, um die Änderungen zu übernehmen
sudo systemctl restart nginx
```
