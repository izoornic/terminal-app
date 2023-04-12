<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicencaNaplata extends Model
{
    use HasFactory;

    protected $fillable = [
        'terminal_lokacijaId',
        'distributerId',
        'licenca_distributer_cenaId',
        'mesecId',
        'broj_dana',
        'zaduzeno',
        'razduzeno',
        'datum_razduzenja',
        'datum_pocetka_licence',
        'datum_kraj_licence',
        'datum_isteka_prekoracenja'
    ];
}
