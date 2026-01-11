<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IjazahSetting extends Model
{
    protected $fillable = [
        'tanggal_ijazah',
        'last_nomor_ibtida',
        'last_nomor_tsanawi',
        'tahun_ajaran',
    ];

    protected $casts = [
        'tanggal_ijazah' => 'date',
    ];

    /**
     * Get the singleton settings record
     */
    public static function getSettings()
    {
        return self::first() ?? self::create([
            'tanggal_ijazah' => now(),
            'last_nomor_ibtida' => 0,
            'last_nomor_tsanawi' => 0,
            'tahun_ajaran' => date('Y') . '/' . (date('Y') + 1),
        ]);
    }

    /**
     * Generate next nomor ijazah for Ibtida
     */
    public function generateNomorIbtida()
    {
        $this->increment('last_nomor_ibtida');
        $nomor = str_pad($this->last_nomor_ibtida, 3, '0', STR_PAD_LEFT);
        $tahun = date('Y');
        return "{$nomor}/IJZ-IBT/{$tahun}";
    }

    /**
     * Generate next nomor ijazah for Tsanawi
     */
    public function generateNomorTsanawi()
    {
        $this->increment('last_nomor_tsanawi');
        $nomor = str_pad($this->last_nomor_tsanawi, 3, '0', STR_PAD_LEFT);
        $tahun = date('Y');
        return "{$nomor}/IJZ-TSN/{$tahun}";
    }

    /**
     * Generate auto NIP
     */
    public static function generateNIP($prefix = 'GTY')
    {
        $random = str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
        return "{$prefix}.{$random}";
    }
}
