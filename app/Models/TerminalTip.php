<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminalTip extends Model
{
    use HasFactory;

     /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'model',
        'proizvodjac',
    ];

    public static function tipoviList()
    {
        foreach(TerminalTip::all() as $tip_row){
            $tipovi_list[$tip_row->id] = $tip_row->model.' - '.$tip_row->proizvodjac;
        }
        return  $tipovi_list;
    }
}
