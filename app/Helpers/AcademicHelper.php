<?php

namespace App\Helpers;

class AcademicHelper
{
    /**
     * Generate list of academic years.
     * Range: Current year - 3 to Current year + 3.
     * Format: YYYY/YYYY+1
     * 
     * @return array
     */
    public static function getAcademicYears()
    {
        $currentYear = date('Y');
        $years = [];
        
        // Range -3 to +3
        $start = $currentYear - 3;
        $end = $currentYear + 3;

        for ($y = $start; $y <= $end; $y++) {
            $next = $y + 1;
            $years[] = "{$y}/{$next}";
        }

        // Sort descending so current/upcoming years are on top usually
        rsort($years);

        return $years;
    }
}
