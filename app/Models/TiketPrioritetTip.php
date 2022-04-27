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
}
