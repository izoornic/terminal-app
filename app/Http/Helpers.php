<?php

namespace App\Http;

use Illuminate\Support\Carbon;

class Helpers
{

    public static function datumFormat($dbdate)
    {
        return Carbon::parse($dbdate)->setTimezone('Europe/Belgrade')->translatedFormat('d. m. Y. - G:i:s');
    }
    
}