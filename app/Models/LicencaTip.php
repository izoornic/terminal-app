<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicencaTip extends Model
{
    use HasFactory;

    protected $fillable = [
        'licenca_naziv',
        'licenca_opis',
        'osnovna_licenca',
        'broj_parametara_licence'
    ];

    public static function imeLicence($id)
    {
        $lic_obj = LicencaTip::where('id', '=', $id)->first();
        return ($lic_obj) ? $lic_obj->licenca_naziv : 'N/A';
    }
}
