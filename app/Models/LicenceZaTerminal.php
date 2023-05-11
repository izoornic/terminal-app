<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenceZaTerminal extends Model
{
    use HasFactory;

    protected $fillable = [
        'terminal_lokacijaId',
        'distributerId',
        'licenca_distributer_cenaId',
        'naziv_licence',
        'mesecId',
        'terminal_sn',
        'datum_pocetak',
        'datum_kraj',
        'datum_prekoracenja',
        'signature'
    ];
}
