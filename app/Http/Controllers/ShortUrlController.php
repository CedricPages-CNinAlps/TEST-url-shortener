<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Random\RandomException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

/**
 * Class ShortUrlController
 * Handles the logic for the shortened URLs.
 */
class ShortUrlController extends Controller
{
    use AuthorizesRequests;
    /**
     * Instance of the authenticated user.
     * Stored as a property to avoid repeated calls to Auth::user().
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected ?\Illuminate\Contracts\Auth\Authenticatable $user;

    /**
     * Initialize a new instance of the controller.
     * Retrieve and store the authenticated user.
     */
    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * Display a paginated list of the user's shortened URLs.
     * The URLs are sorted by creation date in descending order.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(): Factory|View
    {
        $shortUrls = ShortUrl::where('user_id', $this->user->id)
                           ->orderByDesc('created_at')
                           ->paginate(10);

        return view('shorturls.index', compact('shortUrls'));
    }

    /**
     * Display the form to create a new shortened URL.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        return view('shorturls.create');
    }

    /**
     * Store a new shortened URL.
     *
     * @param  \Illuminate\Http\Request  $request The request object containing the original URL
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse The view or redirect response
     *
     * @throws \Exception If generating a unique code fails after multiple attempts
     */
    public function store(Request $request): View|RedirectResponse
    {
        // Validate the original URL
        $request->validate([
            'original_url' => 'required|url',
        ]);

        // Generate a unique code using the Random library
        do {
            $code = $this->random();
        } while (
            ShortUrl::where('code',$code)->exists()
        );

        // Create a new shortened URL
        ShortUrl::create([
            'user_id' => $this->user->id,
            'code' => $code,
            'original_url' => $request->input('original_url'),
        ]);

        return redirect()->route('shorturls.index')->with('status','Shortened URL created successfully.');
    }

    /**
     * Generate a unique random code of 6 alphanumeric characters.
     *
     * @return string The unique random code.
     * @throws RandomException If generating a unique code fails after multiple attempts
     */
    public function random(): string
    {
        try {
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomCode = '';
            
            for ($i = 0; $i < 6; $i++) {
                $randomCode .= $characters[random_int(0, $charactersLength - 1)];
            }
            
            return $randomCode;
        } catch (RandomException $e) {
            throw new RandomException('Failed to generate random code: ' . $e->getMessage());
        }
    }

    /**
     * Display the form to edit a shortened URL.
     *
     * @param  int $id The ID of the shortened URL to edit
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory The view or factory
     */
    public function edit($id): Factory|View
    {
        $shortUrl = ShortUrl::findOrFail($id);
        $this->authorize('update', $shortUrl);

        return view('shorturls.edit', ['shortUrl' => $shortUrl]);
    }

    /**
     * Update a shortened URL.
     * The method validates the request contents using the following rules:
     * - The original URL is required and must be well-formed.
     * The method updates the original URL of the corresponding shortened URL.
     * The method redirects the user to the list of shortened URLs page with a success message.
     *
     * @param  \Illuminate\Http\Request  $request The request object containing the original URL
     * @param  int $id The ID of the shortened URL to update
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse The view or redirect response
     */
    public function update(Request $request, $id): View|RedirectResponse
    {
        $shortUrl = ShortUrl::findOrFail($id);
        $this->authorize('update', $shortUrl);

        $request->validate([
            'original_url' => ['required', 'url'],
        ]);

        $shortUrl->update([
            'original_url' => $request->input('original_url'),
        ]);

        return redirect()->route('shorturls.index')->with('status','Shortened URL updated successfully.');
    }

    /**
     * Delete a shortened URL.
     * The method deletes the shortened URL and removes the object from the database.
     * The method redirects the user to the list of shortened URLs page with a success message.
     *
     * @param  int $id The ID of the shortened URL to delete
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse The view or redirect response
     */
    public function destroy($id): View|RedirectResponse
    {
        $shortUrl = ShortUrl::findOrFail($id);
        $this->authorize('delete', $shortUrl);

        $shortUrl->delete();
        return redirect()->route('shorturls.index')->with('status', 'Shortened URL deleted successfully.');
    }

    /**
     * Increment the click count of a shortened URL.
     * The method increments the click count of the shortened URL and updates the last used date.
     * The method returns a JSON response with a boolean "success" and the new click count.
     *
     * @param  ShortUrl $shortUrl The shortened URL to increment the click count
     * @return \Illuminate\Http\JsonResponse The JSON response
     */
    public function incrementClicks(ShortUrl $shortUrl): JsonResponse
    {
        $shortUrl->increment('clicks');
        $shortUrl->last_used_at = now();
        $shortUrl->save();
        $shortUrl->refresh();

        return response()->json([
            'success' => true,
            'clicks' => $shortUrl->clicks  // The new click count
        ]);
    }
}
