<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportSettings extends Model
{
    protected $table = 'report_settings';
    
    protected $fillable = [
        'nama_yayasan',
        'nama_pondok',
        'alamat',
        'telepon',
        'kota_terbit',
        'pimpinan_nama',
        'pimpinan_jabatan',
        'pimpinan_ttd_path',
        'logo_pondok_path',
        'logo_pendidikan_path',
    ];

    /**
     * Get the singleton settings record
     */
    public static function getSettings()
    {
        return self::first() ?? new self([
            'nama_yayasan' => 'Yayasan Riyadlul Huda',
            'nama_pondok' => 'Pondok Pesantren Riyadlul Huda',
            'alamat' => 'Jombang, Jawa Timur',
            'kota_terbit' => 'Jombang',
        ]);
    }
}
