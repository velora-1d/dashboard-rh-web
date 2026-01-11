<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asrama extends Model
{
    protected $table = 'asrama';
    
    protected $fillable = [
        'nama_asrama',
        'gender',
    ];
    
    public function santri()
    {
        return $this->hasMany(Santri::class);
    }
    
    public function kobong()
    {
        return $this->hasMany(Kobong::class);
    }
}
