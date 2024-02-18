<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicencaDistributerTip extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'distributer_naziv',
        'distributer_adresa',
        'distributer_zip',
        'distributer_mesto',
        'distributer_email',
        'distributer_pib',
        'distributer_mb',
        'broj_ugovora',
        'datum_ugovora',
        'datum_kraj_ugovora',
        'dani_prekoracenja_licence',
        'broj_lokacija'
    ];

    public static function DistributerName($id)
    {
        return (string) LicencaDistributerTip::find($id)->distributer_naziv;
    }

    public static function DistributerNameByUserId($userid)
    {
        return (string) LicencaDistributerTip::select('distributer_naziv')
            ->join('distributer_user_indices', 'distributer_user_indices.licenca_distributer_tipsId', '=', 'licenca_distributer_tips.id')
            ->where('distributer_user_indices.userId', '=', $userid)
            ->first()
            ->distributer_naziv;
    }

    public static function distributerIdByUserId($userid)
    {
        return (string) LicencaDistributerTip::select('licenca_distributer_tips.id')
            ->join('distributer_user_indices', 'distributer_user_indices.licenca_distributer_tipsId', '=', 'licenca_distributer_tips.id')
            ->where('distributer_user_indices.userId', '=', $userid)
            ->first()
            ->id;
    }

    /**
     * Distributeri koji se dodeljuju test korisniku
     *
     * @return void
     */
    public static function testUserDistributerList(){
        foreach(LicencaDistributerTip::all() as $dist){
            $dist_list[$dist->id] = $dist->distributer_naziv;
        }
        return $dist_list;
    }

}
