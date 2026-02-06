# TEST-url-shortener

Ce projet est un raccourcisseur d'URL en Laravel 12 et PHP >= 8.2.
Il permet de créer des liens courts, de les visualiser dans une page d'accueil, de les supprimer, de les modifier, et de les rediriger vers l'URL originale.

Il utilise la base de données SQLite, l'Authentification simple via Laravel Breeze, et des tests unitaires et fonctionnels.
Vous pouvez retrouver mon processus de développement ici : [Procédure_développement.md](Procédure_développement.md)

Pour initialiser et installer le projet, exécutez les commandes suivantes :

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
6. Génération de la documentation
Attention pour la génération, il faut [Doxygen](https://www.doxygen.nl/download.html) et [Graphviz](https://graphviz.org/download/)
```bash
# Aller dans le dossier "Documentation"
cd Documentation

# Lancer la création de la documentation
Doxygen Doxyfile
```
La documentation sera accessible dans le [lien : ./Documentation/docs/html/index.html](./Documentation/docs/html/index.html)
En fonction de votre IDE, un clis droit et ouvrir dans le navigateur.

Sinon, celle-ci est disponible directement dans la page https://cedricpages-cninalps.github.io/TEST-url-shortener/

7. Utilisation de l'image Docker
```bash
# Préparation du Fichier SQLite
touch database/database.sqlite
chmod 666 database/database.sqlite  # Permissions pour www-data

# Commandes de Lancement
docker-compose up -d --build  # Construit le setup 
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```
Accédez à http://localhost:8000 pour voir l'application.
Par la suite, vous pouvez utiliser les commandes utilent ci-dessous :
```bash
# Arrête les services
docker-compose stop
# Relance les mêmes services à l'identique
docker-compose start
# Arrête + redémarre en une commande
docker-compose restart
# Arrête ET supprime les conteneurs + réseaux
docker-compose down
# Supprime aussi les volumes (SQLite sera effacé !).
docker-compose down -v
```

