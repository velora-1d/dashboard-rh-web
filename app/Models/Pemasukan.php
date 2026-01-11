<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Pemasukan extends Model
{
    use LogsActivity;
    
    protected $table = 'pemasukan';
    
    protected $fillable = [
        'sumber_pemasukan',
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
