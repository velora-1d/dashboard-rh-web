<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KitabTalaran extends Model
{
    protected $fillable = [
        'kelas_id',
        'semester',
        'nama_kitab',
    ];
    
    protected $casts = [
        'semester' => 'integer',
    ];
    
    // Relationships
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
