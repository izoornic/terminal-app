<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistLicencaNaplata extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'terminal_lokacijaId',
        'distributerId',
        'licenca_distributer_cenaId',
        'licenca_naplatasId',
        'dist_mesecId',
        'dist_broj_dana',
        'dist_zaduzeno',
        'dist_razduzeno',
        'dist_datum_pocetka_licence',
        'dist_datum_kraj_licence',
        'dist_datum_isteka_prekoracenja'
    ];
}
