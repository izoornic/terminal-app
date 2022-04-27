<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketHistory extends Model
{
    use HasFactory;

     /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'tiketId',
        'tremina_lokacijalId',
        'tiket_statusId',
        'opis_kvaraId',
        'korisnik_prijavaId',
        'korisnik_dodeljenId',
        'opis',
        'created_at',
        'updated_at',
        'tiket_prioritetId',
        'br_komentara'
    ];
}
