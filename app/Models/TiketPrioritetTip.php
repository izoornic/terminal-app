<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiketPrioritetTip extends Model
{
    use HasFactory;

    public static function prList()
    {
        return  TiketPrioritetTip::all();
    }

    public static function prioritetInfo($id)
    {
        return TiketPrioritetTip::find($id)->first();
    }

    public static function prioritetiList()
    {
        foreach(TiketPrioritetTip::all() as $pozicija){
            $pozicija_list[$pozicija->id] = $pozicija->tp_naziv;
        }
        return  $pozicija_list;
    }
}
