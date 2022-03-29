<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'r_naziv',
    ];

    public static function regioni()
    {
        foreach(Region::all() as $region){
            $region_list[$region->id] = $region->r_naziv;
        }
        return  $region_list;
    }
}
