<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    use HasFactory;
    protected $fillable = [
        'role', 'route_name'
    ];
    
    /**
     * The list of rutes when autentifcated
     *
     * @return void
     */
    public static function routeNameList()
    {
        return[
            'dashboard', 
            'pages', 
            'users', 
            'user-permissions'
        ];
    }
    
    /**
     * Checks if current rolle has access
     *
     * @param  mixed $userRole
     * @param  mixed $routeName
     * @return void
     */
    public static function isRoleHasRightToAccess($userRole, $routeName)
    {
        try{
            $model = static::where('role', $userRole)
                ->where('route_name', $routeName)
                ->first();
            
            return $model ? true : false;
        }catch(\Throwable $th){
            //throw $th
            return false;
        }
    }
}
