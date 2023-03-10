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
       * Uploads a file
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
}
