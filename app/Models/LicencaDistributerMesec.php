<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicencaDistributerMesec extends Model
{
    use HasFactory;

    protected $fillable = [
        'distributerId',
        'mesecId',
        'srednji_kurs',
        'sum_zaduzeno',
        'datum_zaduzenja',
        'predracun_email',
        'predracun_pdf',
        'sum_razaduzeno',
        'datum_razaduzenja',
        'racun_email',
        'racun_pdf'
    ];
}
