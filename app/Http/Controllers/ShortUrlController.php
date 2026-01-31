<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Random\RandomException;

class ShortUrlController extends Controller
{
    protected $user;

    public function __construct()
    {
            return $this->user = Auth::user();
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
           'original_url' => 'required|url',
        ]);

        do {
          $code = $this->random();
        } while (
            ShortUrl::where('code',$code)->exists()
        );

        ShortUrl::create([
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

    public function edit(ShortUrl $shortUrl, $id)
    {
        $shortUrl = ShortUrl::where('user_id', $this->user->id)->findOrFail($id);
        return view('shorturls.edit', compact('shortUrl'));
    }

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

    public function destroy(ShortUrl $shortUrl, $id)
    {
        $shortUrl = ShortUrl::where('user_id', $this->user->id)->findOrFail($id);
        $shortUrl->delete();
        return redirect()->route('shorturls.index')->with('status','Lien supprimé.');
    }

    public function incrementClicks(ShortUrl $shortUrl)
    {
        $shortUrl->increment('clicks');
        $shortUrl->refresh(); // Recharge le modèle avec la nouvelle valeur

        return response()->json([
            'success' => true,
            'clicks' => $shortUrl->clicks  // ← Nouveau compteur
        ]);
    }

}
