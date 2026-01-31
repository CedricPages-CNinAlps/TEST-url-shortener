# TEST-url-shortener

Ce projet est un raccourcisseur d'URL en Laravel 12 et PHP >= 8.2.
Il permet de créer des liens courts, de les visualiser dans une page d'accueil, de les supprimer, de les modifier, et de les rediriger vers l'URL originale.

Il utilise la base de données SQLite, l'Authentification simple via Laravel Breeze, et des tests unitaires et fonctionnels.

Pour initialiser et installer le projet, executez les commandes suivantes :

1. Initialisation du projet
```bash
 git clone https://github.com/CedricPages-CNinAlps/TEST-url-shortener.git
 # Se déplacer dans le répertoire du projet
cd TEST-url-shortener
```
2. Installation et Configuration
```bash
# Installer les dépendances PHP
composer install

# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate

# Configurer la base de données SQLite
touch database/database.sqlite
echo "DB_CONNECTION=sqlite" >> .env
echo "DB_DATABASE="$(pwd)"/database/database.sqlite" >> .env

# Installer les dépendances front-end
npm install
npm run build

# Configurer le cache de l'application
php artisan config:cache
```
3. Mise en place des Modèles et Migration
```bash
# Exécuter les migrations
php artisan migrate

# Optionnel : Lancer les seeders pour les données de test
php artisan db:seed

# Créer le lien de stockage
php artisan storage:link
```
4. Mise en place des tests unitaires / fonctionnels
```bash
 # Lancer les tests
php artisan test

# Pour lancer les tests avec couverture de code
php artisan test --coverage
```
5. Démarrer le serveur de développement
```bash
# Démarrer le serveur
php artisan serve

# L'application sera disponible à l'adresse : http://127.0.0.1:8000
```
