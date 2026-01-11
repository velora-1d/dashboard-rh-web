<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\LogsActivity;

class JadwalPelajaran extends Model
{
    use LogsActivity;
    
    protected $table = 'jadwal_pelajaran';
    
    protected $fillable = [
        'kelas_id',
        'mapel_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruangan',
        'tahun_ajaran',
        'semester',
    ];
    
    // protected $casts = [
    //     'jam_mulai' => 'datetime:H:i',
    //     'jam_selesai' => 'datetime:H:i',
    // ];
    
    // Relationships
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }
    
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }
    
    // Alias for shorter name
    public function mapel(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }
}
