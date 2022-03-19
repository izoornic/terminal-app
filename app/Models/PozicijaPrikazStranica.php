<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stranica;

class PozicijaPrikazStranica extends Model
{
    use HasFactory;
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'pozicija_tipId',
        'stranicaId',
    ];


    /**
     * Checks if current rolle has access
     *
     * @param  mixed $userPozicijaTipId
     * @param  mixed $routeName
     * @return void
     */
    public static function isRoleHasRightToAccess($userPozicijaTipId, $routeName)
    { 
        try{
            $stranica = Stranica::where('route_name', $routeName)->firstOrFail();
            try{
               $model = PozicijaPrikazStranica::where('pozicija_tipId', $userPozicijaTipId)
                                ->where('stranicaId', $stranica->id)
                                ->firstOrFail();
                return $model ? true : false;
            }catch(\Throwable $th){
                //throw $th
                return false;
            }
        }catch(\Throwable $th){
            //throw $th
            return false;
        }
    }
}
