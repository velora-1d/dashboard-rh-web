<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kobong extends Model
{
    protected $table = 'kobong';
    
    protected $fillable = [
        'asrama_id',
        'nomor_kobong',
    ];
    
    public function asrama()
    {
        return $this->belongsTo(Asrama::class);
    }
    
    public function santri()
    {
        return $this->hasMany(Santri::class);
    }
}
