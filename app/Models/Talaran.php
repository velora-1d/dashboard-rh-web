<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Talaran extends Model
{
    use SoftDeletes;

    protected $table = 'talaran_santri';
    
    protected $fillable = [
        'santri_id',
        'bulan',
        'tahun',
        'minggu_1',
        'minggu_2',
        'minggu_3',
        'minggu_4',
        'jumlah',
        'tamat',
        'alfa',
        'total',
        'tamat_1_2',
        'alfa_1_2',
        'jumlah_1_2',
        'jumlah_3_4',
        'total_1_2',
        'total_3_4',
    ];
    
    protected $casts = [
        'tahun' => 'integer',
        'minggu_1' => 'integer',
        'minggu_2' => 'integer',
        'minggu_3' => 'integer',
        'minggu_4' => 'integer',
        'jumlah' => 'integer',
        'tamat' => 'integer',
        'alfa' => 'integer',
        'tamat_1_2' => 'integer',
        'alfa_1_2' => 'integer',
        'jumlah_1_2' => 'integer',
        'jumlah_3_4' => 'integer',
    ];

    // Auto-calculate before saving
    // Auto-calculation removed - moved to Controller
    // protected static function booted() { ... }
    
    private static function formatTotalString($jumlah, $tamat)
    {
        if ($tamat > 0) {
            return "{$tamat}x tamat + {$jumlah} bait/jajar";
        }
        return "{$jumlah} bait/jajar";
    }

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class);
    }
}
