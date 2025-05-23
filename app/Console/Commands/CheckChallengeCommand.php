<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Challenge;
use Illuminate\Support\Carbon;

class CheckChallengeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-challenge {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check challenge details';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name') ?? 'Oral Communication';

        $challenge = Challenge::where('name', $name)->first();

        if (!$challenge) {
            $this->error("Challenge '$name' not found");
            return 1;
        }

        $this->info("Challenge: {$challenge->name}");
        $this->info("ID: {$challenge->id}");
        $this->info("Start Date: " . ($challenge->start_date ? $challenge->start_date->format('Y-m-d H:i:s') : 'null'));
        $this->info("End Date: " . ($challenge->end_date ? $challenge->end_date->format('Y-m-d H:i:s') : 'null'));
        $this->info("Is Active: " . ($challenge->is_active ? 'Yes' : 'No'));

        $now = Carbon::now();
        $this->info("Current Time: " . $now->format('Y-m-d H:i:s'));

        $this->info("Is Expired: " . ($challenge->isExpired() ? 'Yes' : 'No'));

        if ($challenge->end_date) {
            $this->info("End Date > Now: " . ($challenge->end_date->gt($now) ? 'Yes' : 'No'));
        }

        return 0;
    }
}
