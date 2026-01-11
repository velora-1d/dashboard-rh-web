<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class UjianMingguan extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'ujian_mingguan';

    protected $fillable = [
        'santri_id',
        'mapel_id',
        'tahun_ajaran',
        'semester',
        'minggu_1',
        'minggu_2',
        'minggu_3',
        'minggu_4',
        'jumlah_keikutsertaan',
        'status',
        'nilai_hasil_mingguan',
    ];

    protected $casts = [
        'minggu_1' => 'decimal:2',
        'minggu_2' => 'decimal:2',
        'minggu_3' => 'decimal:2',
        'minggu_4' => 'decimal:2',
        'nilai_hasil_mingguan' => 'decimal:2',
        'jumlah_keikutsertaan' => 'integer',
    ];

    /**
     * Relationship to Santri
     */
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    /**
     * Relationship to Mata Pelajaran
     */
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    /**
     * Get all weekly scores as an array
     */
    public function getWeeklyScoresAttribute()
    {
        return [
            $this->minggu_1,
            $this->minggu_2,
            $this->minggu_3,
            $this->minggu_4,
        ];
    }

    /**
     * Calculate and update status and nilai_hasil_mingguan
     */
    public function calculateStatus()
    {
        $weeks = $this->weekly_scores;
        
        // Count attended weeks (non-null values)
        $attended = collect($weeks)->filter(fn($v) => !is_null($v))->count();
        $this->jumlah_keikutsertaan = $attended;
        
        // Determine status based on attendance
        if ($attended >= 3) {
            $this->status = 'SAH';
            // Calculate average of attended weeks
            $attendedScores = collect($weeks)->filter(fn($v) => !is_null($v));
            $this->nilai_hasil_mingguan = $attendedScores->avg();
        } else {
            $this->status = 'TIDAK SAH';
            $this->nilai_hasil_mingguan = null;
        }
        
        return $this;
    }
}
