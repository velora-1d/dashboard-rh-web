<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hafalan extends Model
{
    use HasFactory;

    protected $table = 'hafalan';

    protected $fillable = [
        'santri_id',
        'jenis', // Quran, Kitab
        'nama_hafalan', // e.g. Juz 30
        'progress', // e.g. Surat An-Naba
        'tanggal',
        'nilai',
        'catatan',
        'created_by'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'nilai' => 'integer',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
