<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketOpisKvaraTip extends Model
{
    use HasFactory;

    public static function opisList($id = 1)
    {
        //ne bas tako sjajan hak
        //Lista vise ne zavisi od ID-a tipa terminala
        // where('termnal_tipId', '=', $id)
        $kvar_list =[];
        foreach(TiketOpisKvaraTip::orderBy('list_order')->get() as $kvar){
            $kvar_list[$kvar->id] = $kvar->tok_naziv;
        }
        return  $kvar_list;
    }

    
}
