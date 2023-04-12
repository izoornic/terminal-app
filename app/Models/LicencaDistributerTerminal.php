<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicencaDistributerTerminal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'distributerId',
        'terminal_lokacijaId',
        'licenca_distributer_cenaId',
        'datum_pocetak',
        'datum_kraj',
        'nenaplativ',
        'licenca_broj_dana',
        'auto_obnova',
        'broj_parametara'
    ];

}
