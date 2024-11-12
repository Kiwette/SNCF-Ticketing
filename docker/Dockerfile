# Utilisez une image de base de PHP avec Apache
FROM php:8.1-apache

# Activer les modules Apache nécessaires
RUN a2enmod rewrite

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Copier le code source de l'application dans le conteneur
COPY . /var/www/html

# Exposer le port 80
EXPOSE 80

# Lancer Apache en mode foreground
CMD ["apache2-foreground"]
