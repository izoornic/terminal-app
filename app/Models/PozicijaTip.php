<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PozicijaTip extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'naziv',
        'opis',
    ];
    
    /**
     * vraca poyicije koje moze da ima user
     *
     * @return void
     */
    public static function userRoleList(){
        foreach(PozicijaTip::all() as $pozicija){
            $pozicija_list[$pozicija->id] = $pozicija->naziv;
        }
        return  $pozicija_list;
    }

}
