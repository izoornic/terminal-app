<?php

namespace App\Models;

use App\Models\LicencaTip;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicencaDistributerCena extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'distributerId',
        'licenca_tipId',
        'licenca_cena'
    ];

    /**
       * 
       * Licence koje nisu dodate distributeru
       *
       * @param integer $did
       * 
    */
    public static function OstaleLicenceZaDistributera($did)
    {
        $DodeljeneLicence = LicencaDistributerCena::select('*')->where('distributerId', $did)->pluck('licenca_tipId')->all();
        $licence_list = [];
        //dd($licence_list);
        foreach(LicencaTip::select('*')->whereNotIn('id', $DodeljeneLicence)->get() as $licenc){
            $licence_list[$licenc->id] = $licenc->licenca_naziv;
        }
        return $licence_list;
    }

    /**
       * 
       * Licence koje su dodate distributeru
       *
       * @param integer $did
       * 
    */
    public static function LicenceDistributera($did)
    {
        $licence_list = [];
        $lic = LicencaTip::select('licenca_distributer_cenas.id', 'licenca_tips.licenca_naziv')
                ->leftJoin('licenca_distributer_cenas', 'licenca_tips.id', '=', 'licenca_distributer_cenas.licenca_tipId')
                ->where('licenca_distributer_cenas.distributerId', $did)
                ->get();
        foreach($lic as $licenc)
        {
            $licence_list[$licenc->id] = $licenc->licenca_naziv;
        }
        return $licence_list;
    }

    /**
       * 
       * ID osnovne licence dodate distributeru
       *
       * @param integer $did
       * 
    */
    public static function OsnovnaLicencaDistributera($did)
    {
        $licid = LicencaDistributerCena::select('licenca_distributer_cenas.id', 'licenca_tips.licenca_naziv')
                                        ->leftJoin('licenca_tips', 'licenca_distributer_cenas.licenca_tipId', '=', 'licenca_tips.id')
                                        ->where('licenca_tips.osnovna_licenca', '=', 1)
                                        ->where('licenca_distributer_cenas.distributerId', '=', $did)
                                        ->first();                                                         
        return (isset($licid->id)) ? [$licid->id, $licid->licenca_naziv] : [0, 0];
    }

     /**
       * 
       * Nazivi licenci dodatih novom terminalu
       * Niz sa id-jevima licenci u tabeli LicencaDistributerCena
       * 
       * @param array $licence
       * 
    */
    public static function naziviDodatihLicenci($licence)
    {
        return LicencaTip::select('licenca_distributer_cenas.id', 'licenca_tips.licenca_naziv', 'licenca_distributer_cenas.licenca_tipId')
        ->leftJoin('licenca_distributer_cenas', 'licenca_tips.id', '=', 'licenca_distributer_cenas.licenca_tipId')
        ->whereIn('licenca_distributer_cenas.id', $licence)
        ->get();
    }

    /**
       * 
       * Nazivi licenci koje mogu da se dodaju novom terminalu
       * Niz sa id-jevima licenci u tabeli LicencaDistributerCena
       * 
       * @param array $licence
       * 
       * ->whereNotIn('licenca_distributer_cenas.id', $licence)
    */
    public static function naziviNeDodatihLicenci($licence, $distId, $ranije_dodate = [])
    {
        if(count($ranije_dodate)) $licence = array_merge($licence, $ranije_dodate);
        return LicencaTip::select('licenca_distributer_cenas.id', 'licenca_tips.licenca_naziv', 'licenca_distributer_cenas.licenca_tipId')
        ->leftJoin('licenca_distributer_cenas', 'licenca_tips.id', '=', 'licenca_distributer_cenas.licenca_tipId')
        ->where('licenca_distributer_cenas.distributerId', '=', $distId)
        ->where('licenca_tips.osnovna_licenca', '=', 0)
        ->get();
    }

}
