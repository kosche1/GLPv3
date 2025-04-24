<?php

namespace App\Console\Commands;

use Database\Seeders\CoreSubjectsSeeder;
use Illuminate\Console\Command;

class SeedCoreSubjects extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:core-subjects';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the core subjects with their tasks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Seeding core subjects...');
        
        $seeder = new CoreSubjectsSeeder();
        $seeder->setCommand($this);
        $seeder->run();
        
        $this->info('Core subjects seeded successfully!');
        
        return Command::SUCCESS;
    }
}
