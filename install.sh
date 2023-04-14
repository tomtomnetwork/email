#!/bin/bash
#ubuntu 20.04

host=mail.asf.com \

 apt-get update; apt-get dist-upgrade -y; \
 echo "$host" > /etc/hostname; \
 echo "$host" > /proc/sys/kernel/hostname; \
 apt-get install -y software-properties-common; \
 add-apt-repository ppa:ondrej/php -y; \
 apt-get update -y; \
 debconf-set-selections <<< "postfix postfix/mailname string $host"; \
 debconf-set-selections <<< "postfix postfix/main_mailer_type string 'Internet Site'"; \
 apt-get install -y nano apache2 php7.2 libapache2-mod-php7.2 php7.2-cli \
 php7.2-mysql php7.2-gd php7.2-imagick php7.2-tidy php7.2-xmlrpc php7.2-common \
 php7.2-xml php7.2-curl php7.2-dev php7.2-imap php7.2-mbstring php7.2-opcache \
 php7.2-soap php7.2-zip php7.2-intl toilet unzip \
 curl postfix --allow-unauthenticated --assume-yes; \
 toilet --filter metal 'Deboxe /2022' > \
 /etc/motd; ufw disable; apt-get install sendmail -y; reboot


exit 0