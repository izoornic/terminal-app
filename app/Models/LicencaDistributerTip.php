<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicencaDistributerTip extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'distributer_naziv',
        'distributer_adresa',
        'distributer_zip',
        'distributer_mesto',
        'distributer_email',
        'distributer_pib',
        'distributer_mb',
        'broj_ugovora',
        'datum_ugovora',
        'datum_kraj_ugovora',
        'dani_prekoracenja_licence'
    ];

    public static function DistributerName($id)
    {
        return (string) LicencaDistributerTip::find($id)->distributer_naziv;
    }

}
