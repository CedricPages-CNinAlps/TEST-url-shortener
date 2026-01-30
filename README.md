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
Nous mettons ensuite en place le modèle ci-dessous :
```
class ShortUrl extends Model
{
    // Ajoute le trait permettant d’utiliser des factories pour ce modèle, utile pour les tests, les seeders.
    use HasFactory;
    
    // Déclare quels champs peuvent être remplis en assignation de masse
    protected $fillable = [
       'user_id',
       'code',
       'original_url' 
    ];
    
    //  Cette méthode déclare une relation Many-to-One : chaque ShortUrl appartient à un User.
    public function user() {
        return $this->belongsTo(User::class);
    }
}
```

### 2.3 Lancement de la migration
```bash
php artisan migrate
```

## 3. Mise en place du contrôleur, routes et views
Création de la branche Git "Controller-ShortUrl"
```bash
git checkout -b Controller-ShortUrl
```

### 3.1 Controller ShortUrlController
Pour la création du contrôleur, on vient créer cela via la ligne de commande suivante :
```bash
php artisan make:controller ShortUrlController
```

Mise en place des méthodes suivantes :
````
# Globalisation de la variable d'appel du User Authentifié
    // Variable accessible dans TOUTES les méthodes ce qui permets de reduire les nombre d'appel
    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
        // Chargée UNE SEULE FOIS
            $this->user = Auth::user();  
            return $next($request);
        });
    }
    
# Affichige des urls créé par l'utilisateur
     public function index()
    {
        $shortUrls = ShortUrl::where('user_id', $this->user->id)->orderByDesc('created_at')->paginate(10);
        return view('shorturls.index', compact('shortUrls'));
    }

# Création d'une shorturl
    public function create()
    {
        return view('shorturls.create');
    }

# Enregistrement d'une shorturl
    public function store(Request $request)
    {
        $request->validate([
           'original_url' => ['required', 'url'],
        ]);

        do {
          $code = $this->random();
        } while (ShortUrl::where('code',$code)->exists());

        ShortUrl::created([
        // Lie l'information créé au USER connecté
            'user_id' => $this->user->id,
            'code' => $code,
            'original_url' => $request->input('original_url'),
        ]);

        return redirect()->route('shorturls.index')->with('status','Lien raccourci créé avec succès.');
    }

# Création d'un chiffre unique pour la shorturl
    public function random(){
        try {
            return str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        } catch (RandomException $e) {
        }
    }

# Edition d'une shorturl
    public function edit(ShortUrl $shortUrl)
    {
        $this->authorizeForUser($this->user->id, 'update', $shortUrl);
        return view('shorturls.edit', compact('shortUrl'));
    }

# Mise à jour d'une url d'origine
    public function update(Request $request,ShortUrl $shortUrl)
    {
        $this->authorizeForUser($this->user->id, 'update', $shortUrl);
        $request->validate([
            'original_url' => ['required', 'url'],
        ]);

        $shortUrl->update([
            'original_url' => $request->input('original_url'),
        ]);

        return redirect()->route('shorturls.index')->with('status','Lien mis à jour.');
    }

# Suppression d'une url
    public function destroy(ShortUrl $shortUrl)
    {
        $this->authorizeForUser($this->user->id, 'delete', $shortUrl);
        $shortUrl->delete();
        return redirect()->route('shorturls.index')->with('status','Lien supprimé.');
    }
````

### 3.2 Création des routes
Pour un bon fonctionnement du système, je viens éditer mes routes pour mes différentes méthodes :
```
    Route::get('/shorturls',[ShortUrlController::class, 'index'])->name('shorturls.index');
    Route::get('/shorturls/create',[ShortUrlController::class, 'create'])->name('shorturls.create');
    Route::post('/shorturls/store',[ShortUrlController::class, 'store'])->name('shorturls.store');
    Route::get('/shorturls/{shorturl}/edit',[ShortUrlController::class, 'edit'])->name('shorturls.edit');
    Route::put('/shorturls/{shorturl}',[ShortUrlController::class, 'update'])->name('shorturls.update');
    Route::delete('/shorturls/{shorturl}',[ShortUrlController::class, 'destroy'])->name('shorturls.destroy');
```

### 3.3 Mise en place des views
