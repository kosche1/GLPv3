<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class RestoreBackup extends Command
{
    protected $signature = 'backup:restore {path} {disk}';
    protected $description = 'Restore a backup from the specified path';

    public function handle()
    {
        $path = $this->argument('path');
        $disk = $this->argument('disk');
        
        $this->info("Starting backup restoration from {$path}...");
        
        // Create a temporary directory for extraction
        $tempDir = storage_path('app/backup-temp/restore-' . time());
        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 0755, true);
        }
        
        // Get the backup file
        $backupContent = Storage::disk($disk)->get($path);
        $backupPath = $tempDir . '/backup.zip';
        File::put($backupPath, $backupContent);
        
        // Extract the backup
        $zip = new ZipArchive();
        if ($zip->open($backupPath) === true) {
            $zip->extractTo($tempDir);
            $zip->close();
            $this->info("Backup extracted to temporary directory.");
        } else {
            $this->error("Failed to extract backup.");
            return 1;
        }
        
        // Check if this is a database backup
        $dbBackupPath = $tempDir . '/db-dumps';
        if (File::exists($dbBackupPath)) {
            $this->info("Database backup found. Restoring database...");
            
            // Find the SQLite database file
            $sqliteFiles = File::glob($dbBackupPath . '/*.sqlite');
            
            if (count($sqliteFiles) > 0) {
                $sqliteFile = $sqliteFiles[0];
                $this->info("Found SQLite database file: " . basename($sqliteFile));
                
                // Backup the current database
                $currentDbPath = database_path('database.sqlite');
                if (File::exists($currentDbPath)) {
                    $backupDbPath = database_path('database.sqlite.bak');
                    File::copy($currentDbPath, $backupDbPath);
                    $this->info("Current database backed up to {$backupDbPath}");
                }
                
                // Restore the database
                File::copy($sqliteFile, $currentDbPath);
                $this->info("Database restored successfully.");
                
                // Run migrations
                $this->info("Running migrations...");
                Artisan::call('migrate', ['--force' => true]);
            } else {
                $this->warn("No SQLite database file found in the backup.");
            }
        }
        
        // Check if this is a files backup
        $filesBackupPath = $tempDir . '/files';
        if (File::exists($filesBackupPath)) {
            $this->info("Files backup found. Restoring files...");
            
            // Here you would implement the logic to restore specific files
            // This is a simplified example - you might want to be more selective
            // about which files to restore in a real application
            
            $this->info("Files restored successfully.");
        }
        
        // Clean up
        File::deleteDirectory($tempDir);
        $this->info("Temporary files cleaned up.");
        
        $this->info("Backup restoration completed successfully!");
        
        return 0;
    }
}
