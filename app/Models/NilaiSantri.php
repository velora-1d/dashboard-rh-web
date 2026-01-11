<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\LogsActivity;

class NilaiSantri extends Model
{
    use LogsActivity;
    
    protected $table = 'nilai_santri';
    
    protected $fillable = [
        'santri_id',
        'mapel_id',
        'kelas_id',
        'semester',
        'tahun_ajaran',
        'nilai_ujian_semester', // Renamed from nilai_uts
        'nilai_uas',
        'nilai_tugas',
        'nilai_praktik',
        'nilai_akhir',
        'nilai_asli', // For ranking
        'nilai_rapor', // For report card (min 5)
        'source_type', // Source tracking
        'source_metadata', // Transparency data
        'grade',
        'catatan',
        // Compensation fields
        'nilai_original',
        'nilai_kompensasi',
        'is_compensated',
        'compensation_metadata',
    ];
    
    protected $casts = [
        'nilai_ujian_semester' => 'decimal:2',
        'nilai_uas' => 'decimal:2',
        'nilai_tugas' => 'decimal:2',
        'nilai_praktik' => 'decimal:2',
        'nilai_akhir' => 'decimal:2',
        'nilai_asli' => 'decimal:2',
        'nilai_rapor' => 'decimal:2',
        'source_metadata' => 'array',
        'compensation_metadata' => 'array',
        'is_compensated' => 'boolean',
    ];
    
    // Relationships
    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class);
    }
    
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }
    
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }
    
    /**
     * Calculate nilai_rapor from nilai_asli
     * Rule: If nilai_asli < 5, nilai_rapor = 5 (administrative minimum)
     *       Otherwise, nilai_rapor = nilai_asli
     */
    public function calculateNilaiRapor()
    {
        if ($this->nilai_asli !== null) {
            $this->nilai_rapor = $this->nilai_asli < 5 ? 5 : $this->nilai_asli;
        }
        return $this;
    }
    
    // Calculate final grade
    public function calculateNilaiAkhir()
    {
        $uts = floatval($this->nilai_ujian_semester ?? 0);
        $uas = floatval($this->nilai_uas ?? 0);
        $tugas = floatval($this->nilai_tugas ?? 0);
        $praktik = floatval($this->nilai_praktik ?? 0);
        
        // Formula: UTS 30%, UAS 40%, Tugas 20%, Praktik 10%
        // NOTE: For 'Talaran' subjects, the 30% Weekly + 70% Exam weight is handled in PendidikanController/NilaiMingguanController
        $nilaiAkhir = ($uts * 0.3) + ($uas * 0.4) + ($tugas * 0.2) + ($praktik * 0.1);
        
        $this->attributes['nilai_akhir'] = round($nilaiAkhir, 2);
        $this->grade = $this->calculateGrade($nilaiAkhir);
        
        return $this->nilai_akhir;
    }
    
    // Calculate grade based on final score
    private function calculateGrade($nilai)
    {
        if ($nilai >= 85) return 'A';
        if ($nilai >= 70) return 'B';
        if ($nilai >= 60) return 'C';
        if ($nilai >= 50) return 'D';
        return 'E';
    }
}
