<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    
    protected $fillable = [
        'nama_kelas',
        'kitab_talaran',
        'tingkat',
        'kapasitas',
        'tahun_ajaran',
        'wali_kelas',
        'wali_kelas_ttd_path',
        'tipe_wali_kelas', // 'tunggal' or 'dual'
        'wali_kelas_putra',
        'wali_kelas_putri',
        'wali_kelas_ttd_path_putra',
        'wali_kelas_ttd_path_putri',
    ];
    
    public function santri()
    {
        return $this->hasMany(Santri::class);
    }
    
    // Helper to get Wali Kelas Name based on Student Gender
    public function getWaliKelasName($gender)
    {
        if ($this->tipe_wali_kelas === 'dual') {
            return ($gender === 'putra' || $gender === 'L') ? $this->wali_kelas_putra : $this->wali_kelas_putri;
        }
        return $this->wali_kelas;
    }
    
    // Helper to get TTD Path based on Student Gender
    public function getWaliKelasTtd($gender)
    {
        if ($this->tipe_wali_kelas === 'dual') {
            return ($gender === 'putra' || $gender === 'L') ? $this->wali_kelas_ttd_path_putra : $this->wali_kelas_ttd_path_putri;
        }
        return $this->wali_kelas_ttd_path;
    }

    public function mataPelajaran()
    {
        return $this->belongsToMany(MataPelajaran::class, 'kelas_mata_pelajaran', 'kelas_id', 'mata_pelajaran_id')
                    ->withTimestamps();
    }
}
