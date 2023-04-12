<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicencaParametar extends Model
{
    use HasFactory;

    protected $fillable = [
        'licenca_tipId',
        'param_opis'
    ];


    public static function parametriLicence($licencaId)
    {
        return LicencaParametar::where('licenca_tipId', '=', $licencaId)->get();
    }
}
