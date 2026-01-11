<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perizinan extends Model
{
    use HasFactory;

    protected $table = 'perizinan';

    protected $fillable = [
        'santri_id',
        'jenis',
        'tgl_mulai',
        'tgl_selesai',
        'alasan',
        'status',
        'bukti_foto',
        'approved_by'
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
