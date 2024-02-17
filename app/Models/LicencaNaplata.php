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
        'licenca_dist_terminalId',
        'mesecId',
        'broj_dana',
        'zaduzeno',
        'datum_zaduzenja',
        'razduzeno',
        'datum_razduzenja',
        'datum_pocetka_licence',
        'datum_kraj_licence',
        'datum_isteka_prekoracenja',
        'dist_zaduzeno',
        'dist_datum_zaduzenja',
        'dist_razduzeno',
        'dist_datum_razduzenja'
    ];
}
