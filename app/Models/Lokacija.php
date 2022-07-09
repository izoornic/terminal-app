<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokacija extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'regionId',
        'lokacija_tipId',
        'l_naziv',
        'mesto',
        'adresa',
        'latitude',
        'longitude',
        'pib'
    ];

    public static function userLokacijeList()
    {
        foreach(Lokacija::where('lokacija_tipId', '=', 1)->get() as $lokacija){
            $lokacija_list[$lokacija->id] = $lokacija->l_naziv." - ".$lokacija->mesto;
        }
        return  $lokacija_list;
    }

    public static function lokacijeTipa($tipId)
    {
        $lokacija_list = [];
        foreach(Lokacija::where('lokacija_tipId', '=', $tipId)->get() as $lokacija){
            $lokacija_list[$lokacija->id] = $lokacija->l_naziv." - ".$lokacija->mesto;
        }
        
        return  $lokacija_list;
    }

}
