<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class GajiPegawai extends Model
{
    use LogsActivity;
    
    protected $table = 'gaji_pegawai';
    
    protected $fillable = [
        'pegawai_id',
        'bulan',
        'tahun',
        'nominal',
        'is_dibayar',
        'tanggal_bayar',
        'keterangan',
    ];
    
    protected $casts = [
        'is_dibayar' => 'boolean',
        'tanggal_bayar' => 'date',
        'nominal' => 'decimal:2',
    ];
    
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
