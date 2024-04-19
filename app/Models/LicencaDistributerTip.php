<?php

namespace App\Models;

use App\Models\LicencaNaplata;
use App\Models\TerminalLokacija;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'broj_licenci',
        'broj_terminala',
        'broj_lokacija',
        'distributer_tr',
        'distributer_banka',
        'distributer_tel'
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

    public static function prebrojUpdateTerminaleDistributera($distId)
    {
        //$br_licenci = LicencaNaplata::select()->where('distributerId', '=', $distId)->where('aktivna', '=', 1)->count();
        $br_terminala = TerminalLokacija::select()->where('distributerId', '=', $distId)->count();

        LicencaDistributerTip::where('id', '=', $distId)->update(['broj_terminala' => $br_terminala]);
    }

}
