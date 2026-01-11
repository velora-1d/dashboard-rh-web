<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\LogsActivity;

class AbsensiSantri extends Model
{
    use LogsActivity;
    
    protected $table = 'absensi_santri';
    
    protected $fillable = [
        'santri_id',
        'kelas_id',
        'tahun',
        'minggu_ke',
        'tanggal_mulai',
        'tanggal_selesai',
        'alfa_sorogan',
        'alfa_menghafal_malam',
        'alfa_menghafal_subuh',
        'alfa_tahajud',
        'keterangan',
        'created_by',
    ];
    
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'alfa_sorogan' => 'integer',
        'alfa_menghafal_malam' => 'integer',
        'alfa_menghafal_subuh' => 'integer',
        'alfa_tahajud' => 'integer',
    ];
    
    // Relationships
    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class);
    }
    
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }
    
    // Helper methods
    public static function getWeekNumber($date)
    {
        return (int) date('W', strtotime($date));
    }
    
    public static function getMonthName($month)
    {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $months[$month] ?? '';
    }
    
    // Calculate total alfa
    public function getTotalAlfaAttribute()
    {
        return $this->alfa_sorogan + $this->alfa_menghafal_malam + 
               $this->alfa_menghafal_subuh + $this->alfa_tahajud;
    }
    
    // Get 2-week period dates
    public static function getTwoWeekPeriod($weekNumber, $year)
    {
        // Calculate start date from week number
        $dto = new \DateTime();
        $dto->setISODate($year, $weekNumber);
        $startDate = $dto->format('Y-m-d');
        
        // End date is 13 days later (2 weeks)
        $dto->modify('+13 days');
        $endDate = $dto->format('Y-m-d');
        
        return [
            'start' => $startDate,
            'end' => $endDate,
        ];
    }
}
