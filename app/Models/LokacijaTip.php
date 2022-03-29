<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokacijaTip extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'lt_naziv',
    ];

    public static function tipoviList()
    {
        foreach(LokacijaTip::all() as $lokacija){
            $lokacija_list[$lokacija->id] = $lokacija->lt_naziv;
        }
        return  $lokacija_list;
    }
}
