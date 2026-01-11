<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class KalenderPendidikan extends Model
{
    use HasFactory, LogsActivity;
    
    protected $table = 'kalender_pendidikan';
    
    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'kategori',
        'warna'
    ];
    
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];
    
    // Helper to get color based on category if not set
    public static function getCategoryColor($category)
    {
        return match($category) {
            'Libur' => '#ef4444', // Red
            'Ujian' => '#f59e0b', // Amber
            'Kegiatan' => '#3b82f6', // Blue
            'Rapat' => '#8b5cf6', // Purple
            'Lainnya' => '#6b7280', // Gray
            default => '#3b82f6',
        };
    }
}
