Vagrant.configure("2") do |config|
  config.vm.box = "ubuntu/jammy64"
  
  # Hostnamen festlegen
  config.vm.hostname = "webserver01"

  # Netzwerkkarte 2: Netzwerkbrücke mit DHCP
  config.vm.network "public_network"
  
  # Netzwerkkarte 3: Host Only Adapter mit statischer IP-Adresse
  config.vm.network "private_network", type: "static", ip: "172.20.1.201"

  config.vm.provider "virtualbox" do |vb|
    vb.memory = "1024"
    vb.cpus = 2
    vb.name = "Webserver01"
  end
  
  config.vm.provision "shell", inline: <<-SHELL
    apt-get update
    apt-get install -y nginx php-fpm git composer php-dom php-gd php-xml php-xmlreader php-xmlwriter php-zip

    # Nginx-Konfiguration erstellen
    configuration=$(cat <<'EOF'
    server {
        listen 80;
        server_name _;
        root /var/www/html/sport-registration;
        index index.php index.html index.htm;
        location / {
            try_files \$uri \$uri/ =404;
        }
        location ~ \\.php$ {
            include snippets/fastcgi-php.conf;
            fastcgi_pass unix:/var/run/php/php-fpm.sock;
        }
        location ~ /\\.ht {
            deny all;
        }
    }
EOF
    )

    echo "$configuration" > /etc/nginx/sites-available/sport-registration.conf

    PHP_VERSION=$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;")
    sed -i "s|fastcgi_pass unix:/var/run/php/php-fpm.sock;|fastcgi_pass unix:/var/run/php/php${PHP_VERSION}-fpm.sock;|" /etc/nginx/sites-available/sport-registration.conf
    rm /etc/nginx/sites-enabled/default
    ln -s /etc/nginx/sites-available/sport-registration.conf /etc/nginx/sites-enabled/
    systemctl restart nginx
    systemctl restart php${PHP_VERSION}-fpm

    cd /var/www/html
    git clone https://github.com/richtertoralf/sport-registration/
    cd /var/www/html/sport-registration
    composer require phpoffice/phpspreadsheet

    chown -R www-data:www-data /var/www/html/
    chmod -R 775 /var/www/html

    # Benutzer "tori" mit Passwort "linux" anlegen
    useradd -m -p $(openssl passwd -1 linux) -s /bin/bash tori
    usermod -aG adm,sudo tori
    
    # Erlaube die Anmeldung per Passwort in der SSH-Konfiguration
    sed -i 's/PasswordAuthentication no/PasswordAuthentication yes/g' /etc/ssh/sshd_config
    systemctl restart ssh
  SHELL
end
