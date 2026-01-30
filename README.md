# Exercice technique Laravel
Création d'un raccourcisseur d'URL en Laravel 12 et PHP >= 8.2

Vous trouverez ci-dessous la procédure de création du projet.
Pour les besoins du projet, nous publirons exceptionnellement le .env, ce qui ne doitpas être fait en temps normal !
Repo Git : https://github.com/CedricPages-CNinAlps/TEST-url-shortener.git

Initialisation du projet dans la branche master

## 1. Installation et Configuration

### 1.1 Création du projet
```bash
composer create-project laravel/laravel TEST-url-shortener "12.*"
cd url-shortener
```

### 1.2 Configuration de SQLite
```bash
touch database/database.sqlite
```
Dans le .env, ajout du chemin d'accès à la BD
```env
# .env
DB_DATABASE=/database/database.sqlite
```

### 1.3 Mise en place de l'Authentification simple
Création de la branche Git "Breeze"
```bash
git checkout -b Breeze
```
Installation via Composer de Breeze et vérification du fonctionnement
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
php artisan migrate
php artisan serve
```
Dans PHPStorm, j'utilise l'outil de création d'une "Pull resquest" et merge de celle-ci dans la branch "master".
Et retour sur la branche d'origine et j'importe les développements.
```bash
git checkout master
git pull origin master
```

## 2. Mise en place des Modèles et Migration
Création de la branche Git "Migration-ShortUrl"
```bash
git checkout -b Migration-ShortUrl
```
Pour la création du modèle et la migration associé, on vient créer cela via la ligne de commande suivante :
```bash
php artisan make:model ShortUrl -m
```

### 2.1 Migration
Pour un bon fonctionnement, je viens compléter ma migration avec les ligne suivantes :
```
// Cette ligne crée une colonne user_id liée à users.id, et si tu supprimes un user, tous les enregistrements qui lui sont rattachés dans cette table seront supprimés automatiquement. 
$table->foreignId('user_id')->constrained()->onDelete('cascade');
// Crée une colonne code de type VARCHAR(16) avec 16 caratères max
$table->string('code',16)->unique();
//Crée une colonne pour l'enregistrement de l'Url
$table->text('original_url');
```

### 2.2 Modèle
