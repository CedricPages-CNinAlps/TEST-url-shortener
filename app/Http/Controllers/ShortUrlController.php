<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Util\Str;
use Random\RandomException;

/**
 * @method middleware(\Closure $param)
 * @method authorizeForUser($id, string $string, ShortUrl $shortUrl)
 */
class ShortUrlController extends Controller
{
    protected $user;  // Variable accessible dans TOUTES les méthodes

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();  // Chargée UNE SEULE FOIS
            return $next($request);
        });
    }
    public function index()
    {
        $shortUrls = ShortUrl::where('user_id', $this->user->id)->orderByDesc('created_at')->paginate(10);
        return view('shorturls.index', compact('shortUrls'));
    }

    public function create()
    {
        return view('shorturls.create');
    }

    public function store(Request $request)
    {
        $request->validate([
           'original_url' => ['required', 'url'],
        ]);

        do {
          $code = $this->random();
        } while (ShortUrl::where('code',$code)->exists());

        ShortUrl::created([
            'user_id' => $this->user->id,
            'code' => $code,
            'original_url' => $request->input('original_url'),
        ]);

        return redirect()->route('shorturls.index')->with('status','Lien raccourci créé avec succès.');
    }

    public function random(){
        try {
            return str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        } catch (RandomException $e) {
        }
    }

    public function edit(ShortUrl $shortUrl)
    {
        $this->authorizeForUser($this->user->id, 'update', $shortUrl);
        return view('shorturls.edit', compact('shortUrl'));
    }

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

    public function destroy(ShortUrl $shortUrl)
    {
        $this->authorizeForUser($this->user->id, 'delete', $shortUrl);
        $shortUrl->delete();
        return redirect()->route('shorturls.index')->with('status','Lien supprimé.');
    }
}
