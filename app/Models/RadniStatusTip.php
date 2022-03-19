<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadniStatusTip extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'rs_naziv'
    ];
    
        
    /**
     * Radni statusi koji mogu da se dodele korisniku
     *
     * @return void
     */
    public static function userRadniStatusList(){
        foreach(RadniStatusTip::all() as $pozicija){
            $pozicija_list[$pozicija->id] = $pozicija->rs_naziv;
        }
        return  $pozicija_list;
    }
}
