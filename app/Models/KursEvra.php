<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KursEvra extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'kupovni_kurs',
        'srednji_kurs',
        'prodajni_kurs',
        'datum_preuzimanja',
        'datum_kursa'
    ];

    public static function insertDailyKurs($data){
        KursEvra::updateOrCreate( ['datum_preuzimanja'=>$data['date']], ['datum_kursa' => $data['date_from'], 'kupovni_kurs' => $data['exchange_buy'], 'srednji_kurs' => $data['exchange_middle'], 'prodajni_kurs' => $data['exchange_sell']] );
    }
}
