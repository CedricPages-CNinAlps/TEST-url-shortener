<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ShortUrl;

/**
 * Clean up expired short URLs.
 *
 * This command deletes short URLs that have not been used for more than 3 months,
 * shortened URLs that are not clickable or not copiable.
 */
class CleanOldShortUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shorturls:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Supprime les short URLs non utilisées depuis plus de 3 mois, URLs courtes non cliquées ou non copiées.';

    /**
     * Execute the console command.
     *
     * This command deletes short URLs that have not been used for more than 3 months,
     * shortened URLs that are not clickable or not copiable.
     *
     * @return int The number of deleted short URLs.
     */
    public function handle(): int
    {
        $deleted = ShortUrl::where(function ($query) {
            $query->where('last_used_at', '<', now()->subMonths(3));
        })->delete();

        $this->info("{$deleted} short URLs deleted (not used for +3 months)");

        return $deleted;
    }
}
