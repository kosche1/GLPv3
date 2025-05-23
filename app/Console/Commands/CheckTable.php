<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class CheckTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:table {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if a table exists in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $table = $this->argument('table');
        
        if (Schema::hasTable($table)) {
            $this->info("Table '{$table}' exists in the database.");
            
            // List columns
            $columns = Schema::getColumnListing($table);
            $this->info("Columns: " . implode(', ', $columns));
        } else {
            $this->error("Table '{$table}' does not exist in the database.");
        }
        
        return Command::SUCCESS;
    }
}
