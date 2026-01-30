<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrl;
use Carbon\Carbon;

class RedirectController extends Controller
{
    public function redirect(string $code)
    {
        $shortUrl = ShortUrl::withTrashed()
            ->where('code', $code)
            ->first();

        if (! $shortUrl) {
            abort(404);
        }

        if ($shortUrl->trashed()) {
            return response()->view('shorturls.deleted', compact('shortUrl'),410);
        }

        return redirect()->away($shortUrl->original_url);
    }
}
