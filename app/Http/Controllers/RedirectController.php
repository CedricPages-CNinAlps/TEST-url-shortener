<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
/**
 * Controller to redirect to the original URL corresponding to a unique code.
 *
 * This controller provides a single method to redirect to the original URL corresponding to a unique code.
 *
 * @package App\Http\Controllers
 * @author Your Name <your.name@example.com>
 * @copyright Copyright (c) Your Name (year)
 */
class RedirectController extends Controller
{
    /**
     * Redirect to the original URL corresponding to a unique code.
     *
     * This method searches for the original URL corresponding to the unique code.
     * If the original URL does not exist, the method returns a HTTP 404 response.
     * If the original URL exists but has been deleted, the method returns a view with an error message.
     * Otherwise, the method redirects the user to the original URL.
     *
     * @param  string  $code The unique code of the original URL
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function redirect(string $code): Response|RedirectResponse
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
