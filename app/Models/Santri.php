<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Santri extends Model
{
    use LogsActivity;
    
    protected $table = 'santri';
    
    protected $fillable = [
        'nis',
        'nama_santri',
        'negara',
        'provinsi',
        'kota_kabupaten',
        'kecamatan',
        'desa_kampung',
        'rt_rw',
        'nama_ortu_wali',
        'no_hp_ortu_wali',
        'asrama_id',
        'kobong_id',
        'kelas_id',
        'gender',
        'is_active',
        'tanggal_masuk',
        'virtual_account_number',
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'tanggal_masuk' => 'date',
    ];
    
    // Relationships
    public function asrama()
    {
        return $this->belongsTo(Asrama::class);
    }
    
    public function kobong()
    {
        return $this->belongsTo(Kobong::class);
    }
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    
    public function mutasi()
    {
        return $this->hasMany(MutasiSantri::class);
    }

    public function nilai()
    {
        return $this->hasMany(NilaiSantri::class);
    }

    public function ujianMingguan()
    {
        return $this->hasMany(UjianMingguan::class);
    }

    public function syahriah()
    {
        return $this->hasMany(Syahriah::class);
    }
}
