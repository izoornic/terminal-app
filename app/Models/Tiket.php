<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

     /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'tremina_lokacijalId',
        'tiket_statusId',
        'opis_kvaraId',
        'korisnik_prijavaId',
        'korisnik_dodeljenId',
        'opis',
        'tiket_prioritetId',
        'br_komentara'
    ];

    public static function daliTerminalImaOtvorenTiket($tlid)
    {
        return Tiket::select('id', 'created_at')
                    ->where('tremina_lokacijalId', '=',  $tlid)
                    ->where('tiket_statusId', '<', 3)
                    ->first();
    }
}
