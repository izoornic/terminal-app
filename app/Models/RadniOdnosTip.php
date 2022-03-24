<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadniOdnosTip extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'ro_naziv',
    ];
    
    /**
     * vraca poyicije koje moze da ima user
     *
     * @return void
     */
    public static function userRadniOdnosList(){
        foreach(RadniOdnosTip::all() as $pozicija){
            $pozicija_list[$pozicija->id] = $pozicija->ro_naziv;
        }
        return  $pozicija_list;
    }
}
