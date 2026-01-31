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
            // Charger une seul fois
            return $this->user = Auth::user();
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
   public function edit(ShortUrl $shortUrl, $id)
    {
        // Vérifie que l'URL appartient bien à l'utilisateur connecté
        $shortUrl = ShortUrl::where('user_id', $this->user->id)->findOrFail($id);
        return view('shorturls.edit', compact('shortUrl'));
    }

# Mise à jour d'une url d'origine
public function update(Request $request,$id)
    {
        $shortUrl = ShortUrl::findOrFail($id);
        $request->validate([
            'original_url' => ['required', 'url'],
        ]);

        $shortUrl->update([
            'original_url' => $request->input('original_url'),
        ]);

        return redirect()->route('shorturls.index')->with('status','Lien mis à jour.');
    }

# Suppression d'une url
    public function destroy(ShortUrl $shortUrl, $id)
    {
        $shortUrl = ShortUrl::where('user_id', $this->user->id)->findOrFail($id);
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

Pour ce faire nous faisons 3 views :
- index.blade.php : qui affiche les informations sur nos URLs ;
- create.blade.php : qui permettra de créé une url ; 
- edite.blade.php : qui affiche l'url existante, que l'on pourra remplace.

### 3.4 Controller de redirection

#### 3.4.1 Controller
Maintenant que nous avons une url raccourcis, nous allons faire une nouveau controller qui permettra la gestion des redirections.
```bash
php artisan make:controller RedirectController
```

Mise en place de la méthode suivante :
```
public function redirect(string $code)
    {
        $shortUrl = ShortUrl::withTrashed()
            ->where('code', $code)
            ->first();
        
        // Lien non trouvé
        if (! $shortUrl) {
            abort(404);
        }
        
        // Lien supprimé => page spécifique
        if ($shortUrl->trashed()) {
            return response()->view('shorturls.deleted', compact('shortUrl'),410);
        }
        
        return redirect()->away($shortUrl->original_url);
    }
```

#### 3.4.2 Mise en place d'une route publique
```
Route::get('/r/{code}', [RedirectController::class, 'redirect'])->name('shorturls.redirect');
```

#### 3.4.3 Création d'une view lien plus valable
Nous faisons une view deleted.blade.php complémentaire.

#### 3.4.4 Mise en place d'un champ 'deleted_at' dans ma table short_urls
Afin d'avoir un bon fonctionnement des redirections, nous ajoutons la notion de SoftDeletes.
- Modification du model ShortUrl en ajoutant :
```
use Illuminate\Database\Eloquent\SoftDeletes;
use HasFactory, SoftDeletes;
```
- Ensuite, création d'une nouvelle migration, pour l'intégration du champ 'deleted_at' :
```
php artisan make:migration add_deleted_at_to_short_urls_table --table=short_url
php artisan migrate
```

A ce stade, nous avons un projet répondant au cahier des charges primaire :
- Zone d'administration avec création d'un compte ou connection ;
- Un tableau affichant les liens courts et pagination ;
- Possibilité de copier le lien court (BONUS) ;
- Gestion des liens, ajout, suppression et édition ;
- Redirection de l'URL avec endpoint fonctionnel ;
- Les liens supprimés n'affiche pas une 404 (BONUS).

## 4. Mise en place des tests unitaires / fonctionnels
Création de la branche Git "Tests-ShortUrl"
```bash
git checkout -b Tests-ShortUrl
```

### 4.1 Tests zone d'administration
Pour ce faire, nous allons déjà créer un test de Feature via :
```bash
php artisan make:test ShortUrlTest
```

J'édite 3 tests
```
# Test 1 : Accès invité au dashboard
Ce que ça teste : Un utilisateur non connecté qui essaie d'accéder à /dashboard est redirigé vers /login.

    public function test_guest_cannot_access_dashboard(): void
    {
        $this->get('/dashboard')
        ->assertRedirect('/login');;
    }
```

```
# Test 2 : Création d'une ShortUrl
Ce que ça teste : Un utilisateur connecté peut créer une shortUrl.
User::factory()->create() : crée un utilisateur fictif en BDD
actingAs($user) : simule une connexion avec cet utilisateur
post('/shorturls', [...]) : simule un POST avec les données du formulaire

    public function test_user_can_create_short_url(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/shorturls', [
                'original_url' => 'https://www.exemple.com'
            ]);

        $response->assertRedirect('/shorturls');
        $this->assertDatabaseCount('short_urls',1);
        $this->assertDatabaseHas('short_urls',[
            'user_id' => $user->id,
            'original_url' => 'https://www.exemple.com'
        ]);
    }
```

```
# Test 3 : Isolation des données utilisateur
Ce que ça teste : User1 ne voit QUE ses propres liens, pas ceux de User2.
Crée 2 users + 1 ShortUrl chacun
Se connecte comme User1 et fait un GET /shorturls

    public function test_user_can_sees_only_own_links(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        ShortUrl::factory()->create(['user_id' => $user1->id]);
        ShortUrl::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)
            ->post('/shorturls');

        $response->assertStatus(200);
        $this->assertEquals(1,$response->viewData('shortUrls')->count());
    }
```

### 4.2 Test pour la redirection
Pour ce faire, nous allons déjà créer un test de Feature via :
```bash
php artisan make:test RedirectTest
```

J'édite 3 tests
```
#Test 1 : Redirection vers l'URL originale
Ce que ça teste : Quand on clique sur /r/123456, on est redirigé vers https://exemple.com.

    public function test_redirects_to_original_url(): void
    {
        $short = ShortUrl::factory()->create([
            'original_url' => 'https://exemple.com',
            'code' => 123456,
        ]);

        $response = $this->get('/r/123456');

        $response->assertRedirect('https://exemple.com');
        $this->assertDatabaseHas('short_urls',[
            'id' => $short->id,
        ]);
    }
```

```
# Test 2 : 404 si code inexistant
Ce que ça teste : Si le code n'existe pas en base → erreur 404 Not Found.

    public function test_returns_404_when_not_found(): void
    {
        $this->get('/r/UNKNOWN')->assertStatus(404);
    }
```

```
#Test 3 : 410 si lien supprimé 
Ce que ça teste : Si quelqu'un essaie d'accéder à un lien supprimé → statut 410 Gone (meilleur que 404 pour les liens supprimés).

    public function test_deleted_link_shows_deleted_page(): void
    {
        $short = ShortUrl::factory()->create([
            'original_url' => 'https://exemple.com',
            'code' => 123456,
        ]);

        $short->delete();
        $this->get('/r/123456')->assertStatus(410);
    }
```

### 4.3 Factory pour ShortUrl
Pour ce faire, nous allons déjà créer un test de Factory via :
```bash
php artisan make:factory ShortUrlFactory --model=ShortUrl
```

J'édite le factory suivant :
```
class ShortUrlFactory extends Factory
{
// Dit à Laravel : cette factory crée des enregistrements pour le modèle ShortUrl.
    protected $model = ShortUrl::class;

    public function definition(): array
    {
        return [
            // Ça crée juste une promesse d'utilisateur.
            'user_id' => User::factory(),
            // Génère un code comme 123456 (chiffres, 6 caractères).
            'code' => str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT),
            // Génère une URL fausse
            'original_url' => $this->faker->url(),
        ];
    }
}
```

### 4.4 Lancement des tests

Pour vérifier les tests, je réalise 2 méthodes :
- Lancement des tests créés ci-dessus, en utilisant la commande :
```bash
php artisan test 
```
- Lancement de l'application, pour des tests manuels de fonctionnement, en utilisant la commade :
```bash
php artisan serve
```


A ce stade, nous avons un projet répondant au cahier des charges primaire :
- Zone d'administration avec création d'un compte ou connection ;
- Un tableau affichant les liens courts et pagination ;
- Possibilité de copier le lien court (BONUS) ;
- Gestion des liens, ajout, suppression et édition ;
- Redirection de l'URL avec endpoint fonctionnel ;
- Les liens supprimés n'affiche pas une 404 (BONUS) ;
- Tests unitaires et fonctionnels.

## 5. Réalisation des bonus
Création de la branche Git "Bonus-ShortUrl"
```bash
git checkout -b Bonus-ShortUrl
```
