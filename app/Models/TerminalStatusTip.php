<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminalStatusTip extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'ts_naziv',
    ];

    public static function tipoviList()
    {
        foreach(TerminalStatusTip::all() as $status){
            $status_list[$status->id] = $status->ts_naziv;
        }
        return  $status_list;
    }
}
