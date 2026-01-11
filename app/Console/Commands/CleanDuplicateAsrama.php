<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Asrama;
use App\Models\Santri;
use App\Models\Kobong;
use Illuminate\Support\Facades\DB;

class CleanDuplicateAsrama extends Command
{
    protected $signature = 'asrama:clean-duplicates';
    protected $description = 'Remove duplicate asrama entries and migrate references to the primary entry';

    public function handle()
    {
        $this->info('Checking for duplicate asrama entries...');
        
        // Get all asramas grouped by name and gender
        $asramas = Asrama::all();
        $grouped = $asramas->groupBy(function($a) {
            return $a->nama_asrama . '|' . $a->gender;
        });
        
        $duplicatesFound = 0;
        
        DB::beginTransaction();
        try {
            foreach ($grouped as $key => $group) {
                if ($group->count() > 1) {
                    $duplicatesFound++;
                    $this->warn("Found duplicate: {$key} ({$group->count()} entries)");
                    
                    // Keep the first one (lowest ID) as the primary
                    $primary = $group->first();
                    $duplicates = $group->slice(1);
                    
                    foreach ($duplicates as $duplicate) {
                        $this->info("  - Migrating data from ID {$duplicate->id} to ID {$primary->id}");
                        
                        // Update santri references
                        $santriCount = Santri::where('asrama_id', $duplicate->id)->count();
                        Santri::where('asrama_id', $duplicate->id)->update(['asrama_id' => $primary->id]);
                        $this->info("    Updated {$santriCount} santri records");
                        
                        // Update kobong references
                        $kobongCount = Kobong::where('asrama_id', $duplicate->id)->count();
                        Kobong::where('asrama_id', $duplicate->id)->update(['asrama_id' => $primary->id]);
                        $this->info("    Updated {$kobongCount} kobong records");
                        
                        // Delete the duplicate
                        $duplicate->delete();
                        $this->info("    Deleted duplicate asrama ID {$duplicate->id}");
                    }
                }
            }
            
            DB::commit();
            
            if ($duplicatesFound === 0) {
                $this->info('No duplicate asrama entries found.');
            } else {
                $this->info("Successfully cleaned {$duplicatesFound} duplicate asrama groups.");
            }
            
            // Show remaining asramas
            $this->info("\nRemaining asrama entries:");
            foreach (Asrama::orderBy('id')->get() as $a) {
                $this->line("  ID: {$a->id} | Name: {$a->nama_asrama} | Gender: {$a->gender}");
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
