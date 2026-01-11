<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Carbon\Carbon;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup {--keep=7 : Number of days to keep backups}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database automatically';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Starting database backup...');
        
        // Create backups directory if not exists
        $backupPath = storage_path('backups');
        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }
        
        // Generate filename with timestamp
        $filename = 'backup_' . Carbon::now()->format('Y-m-d_His') . '.sql';
        $filepath = $backupPath . '/' . $filename;
        
        // Get database credentials
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port');
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        
        // Build mysqldump command
        $command = sprintf(
            'mysqldump --host=%s --port=%s --user=%s --password=%s %s > %s',
            $host,
            $port,
            $username,
            $password,
            $database,
            $filepath
        );
        
        // Execute backup
        $result = null;
        $output = null;
        exec($command . ' 2>&1', $output, $result);
        
        if ($result === 0 && file_exists($filepath)) {
            $size = round(filesize($filepath) / 1024, 2);
            $this->info("✅ Backup created successfully: {$filename} ({$size} KB)");
            
            // Clean old backups
            $this->cleanOldBackups($backupPath, $this->option('keep'));
            
            return SymfonyCommand::SUCCESS;
        } else {
            $this->error('❌ Backup failed!');
            $this->error(implode("\n", $output));
            return SymfonyCommand::FAILURE;
        }
    }
    
    /**
     * Remove old backup files
     */
    protected function cleanOldBackups($path, $keepDays)
    {
        $this->info("🗑️ Cleaning backups older than {$keepDays} days...");
        
        $files = glob($path . '/backup_*.sql');
        $threshold = Carbon::now()->subDays($keepDays);
        $deleted = 0;
        
        foreach ($files as $file) {
            $fileTime = Carbon::createFromTimestamp(filemtime($file));
            if ($fileTime->lt($threshold)) {
                unlink($file);
                $deleted++;
            }
        }
        
        if ($deleted > 0) {
            $this->info("🗑️ Deleted {$deleted} old backup(s)");
        }
    }
}
