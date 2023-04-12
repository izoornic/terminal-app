<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Helpers;

class LicencaMesec extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'mesec_datum',
        'mesec_naziv',
        'm_broj_dana'
    ];

    public static function mesecZaduzenja($id)
    {
        $m_obj = LicencaMesec::where('id', '=', $id)->first();
        return ($m_obj) ? LicencaMesec::mesecGodinaZaduzenja($m_obj) : 'N/A';
    }

    public static function mesecGodinaZaduzenja($row)
    {
        return $row->mesec_naziv.' '.Helpers::yearNumber($row->mesec_datum).'.';
    }
}
