<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Pengeluaran extends Model
{
    use LogsActivity;
    
    protected $table = 'pengeluaran';
    
    protected $fillable = [
        'jenis_pengeluaran',
        'tanggal',
        'nominal',
        'keterangan',
        'kategori',
    ];
    
    protected $casts = [
        'tanggal' => 'date',
        'nominal' => 'decimal:2',
    ];
}
