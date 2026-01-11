<?php

namespace App\Helpers;

class RaporHelper
{
    public static function getPredikat($nilai)
    {
        $nilai = floatval($nilai);
        
        if ($nilai >= 90) return 'A'; // Sangat Baik
        if ($nilai >= 80) return 'B'; // Baik
        if ($nilai >= 70) return 'C'; // Cukup
        if ($nilai >= 60) return 'D'; // Kurang
        return 'E'; // Sangat Kurang
    }
    
    public static function getKeterangan($predikat)
    {
        switch ($predikat) {
            case 'A': return 'Sangat Baik';
            case 'B': return 'Baik';
            case 'C': return 'Cukup';
            case 'D': return 'Kurang';
            default: return 'Peralu Bimbingan';
        }
    }
}
