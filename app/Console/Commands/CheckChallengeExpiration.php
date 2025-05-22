<?php

namespace App\Console\Commands;

use App\Models\Challenge;
use Illuminate\Console\Command;

class CheckChallengeExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'challenge:check-expiration {search?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if challenges are expired';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $search = $this->argument('search');
        
        $query = Challenge::query();
        
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        
        $challenges = $query->get();
        
        $this->info("Found " . $challenges->count() . " challenges");
        
        foreach ($challenges as $challenge) {
            $this->info("ID: {$challenge->id}, Name: {$challenge->name}");
            $this->info("End Date: " . ($challenge->end_date ?? 'null'));
            $this->info("Is Expired: " . ($challenge->is_expired ? 'Yes' : 'No'));
            $this->info("Raw isExpired() method: " . ($challenge->isExpired() ? 'Yes' : 'No'));
            $this->info("-----------------------------------");
        }
    }
}
