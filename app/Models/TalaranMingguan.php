<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TalaranMingguan extends Model
{
    protected $table = 'talaran_mingguan';
    
    protected $fillable = [
        'santri_id',
        'mapel_id', // Added
        'kelas_id',
        'tahun_ajaran',
        'semester',
        
        // New Weekly Score Fields
        'minggu_1',
        'minggu_2',
        'minggu_3',
        'minggu_4',
        'rata_rata',
    ];
    
    protected $casts = [
        'minggu_1' => 'decimal:2',
        'minggu_2' => 'decimal:2',
        'minggu_3' => 'decimal:2',
        'minggu_4' => 'decimal:2',
        'rata_rata' => 'decimal:2',
    ];
    
    // Relationships
    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class);
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }
    
    // Remove old helpers irrelevant to this new feature
}
