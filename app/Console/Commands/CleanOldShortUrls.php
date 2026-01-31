<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ShortUrl;

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
     */
    public function handle()
    {
        $deleted = ShortUrl::where(function ($query) {
            $query->Where('last_used_at', '<', now()->subMonths(3));
        })->delete();

        $this->info("{$deleted} short URLs supprimées (non utilisées depuis +3 mois)");

        return 0;
    }
}
