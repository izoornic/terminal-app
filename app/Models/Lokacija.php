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
        'pib',
        'distributerId',
        'mb'
    ];

    public static function userLokacijeList($tip_id = 1)
    {
        foreach(Lokacija::where('lokacija_tipId', '=', $tip_id)->get() as $lokacija){
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

    public static function lokacijeDistributera($distId)
    {
        $lokacija_list = [];
        foreach(Lokacija::select('lokacijas.*')
                ->join('distributer_lokacija_indices', 'distributer_lokacija_indices.lokacijaId', '=', 'lokacijas.id')
                ->where('distributer_lokacija_indices.licenca_distributer_tipsId', '=', $distId)
                ->get() as $lokacija){
            $lokacija_list[$lokacija->id] = $lokacija->l_naziv." - ".$lokacija->mesto;
        }
        return  $lokacija_list;
    }

}
