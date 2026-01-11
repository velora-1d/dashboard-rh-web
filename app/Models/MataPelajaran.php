<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\LogsActivity;

class MataPelajaran extends Model
{
    use LogsActivity;
    
    protected $table = 'mata_pelajaran';
    
    protected $fillable = [
        'nama_mapel',
        'kode_mapel',
        'kategori',
        'guru_pengampu',
        'waktu_pelajaran',
        'deskripsi',
        'is_active',
        'is_talaran',
        'has_weekly_exam',
        'kkm', // Added
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'is_talaran' => 'boolean',
        'has_weekly_exam' => 'boolean',
    ];
    
    // Relationships
    public function nilaiSantri(): HasMany
    {
        return $this->hasMany(NilaiSantri::class, 'mapel_id');
    }
    
    public function jadwalPelajaran(): HasMany
    {
        return $this->hasMany(JadwalPelajaran::class, 'mapel_id');
    }
    
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'kelas_mata_pelajaran', 'mata_pelajaran_id', 'kelas_id')
                    ->withTimestamps()
                    ->withPivot('is_kelas_umum');
    }
}
