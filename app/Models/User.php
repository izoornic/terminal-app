<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'pozicija_tipId',
        'lokacijaId',
        'telegramId',
        'tel',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Lista stranica i ruta za kreiranje menija
     * u zavisnosti od uloge koju korisnik ima
     *
     * @param  mixed $curentUserId
     * @return void
     */
    public static function userPozicijeList($curentUserId)
    {
        $pozicije = DB::select(
            'SELECT
                s.naziv, s.route_name
            FROM
                stranicas s,
                pozicija_prikaz_stranicas ps,
                pozicija_tips pt,
                users u
            WHERE
                s.id = ps.stranicaId AND ps.pozicija_tipId = pt.id AND pt.id = u.pozicija_tipId AND s.show_in_meni = 1 AND s.sub_menu_order IS NULL AND u.id = ?
            ORDER BY
                s.menu_order' , 
            [$curentUserId]
        );

        $retval = [];
        foreach ($pozicije as $pozicija) {
         $retval[$pozicija->route_name] = $pozicija->naziv;
        }
        return  $retval;
    }
}
