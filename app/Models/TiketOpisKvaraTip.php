<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketOpisKvaraTip extends Model
{
    use HasFactory;

    public static function opisList($id)
    {
        $kvar_list =[];
        foreach(TiketOpisKvaraTip::where('termnal_tipId', '=', $id)->orderBy('list_order')->get() as $kvar){
            $kvar_list[$kvar->id] = $kvar->tok_naziv;
        }
        return  $kvar_list;
    }
}
