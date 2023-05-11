<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Config;

class LicencaDistributerTerminal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'distributerId',
        'terminal_lokacijaId',
        'licenca_distributer_cenaId',
        'datum_pocetak',
        'datum_kraj',
        'nenaplativ',
        'licenca_broj_dana',
        'auto_obnova',
        'broj_parametara'
    ];


    /**
     * [Description for nenaplativeLicenceDistributera]
     *
     * @param int $did
     * @param array $searchParams
     * $searchParams['searchTerminalSnNpl'=>'searchString']
     * $searchParams['searchMestoNpl'=>'searchString']
     * $searchParams['searchTipLicenceNpl'=>'searchInteger']
     * 
     * @return [type]
     * 
     */
    public static function nenaplativeLicenceDistributera($did, $searchParams)
    {
        return LicencaDistributerTerminal::select(
                'terminal_lokacijas.id', 
                'terminals.sn', 
                'lokacijas.l_naziv', 
                'lokacijas.mesto', 
                'lokacijas.adresa', 
                'licenca_distributer_terminals.id as ldtid', 
                'licenca_distributer_terminals.datum_pocetak', 
                'licenca_distributer_terminals.datum_kraj',
                'licenca_distributer_terminals.nenaplativ',
                'licenca_tips.licenca_naziv', 
                'licenca_tips.id as ltid',
                'licenca_distributer_terminals.licenca_broj_dana',
                'licenca_distributer_terminals.licenca_distributer_cenaId'
                )
        ->leftJoin('terminal_lokacijas', 'licenca_distributer_terminals.terminal_lokacijaId', '=', 'terminal_lokacijas.id')
        ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
        ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
        ->leftJoin('licenca_distributer_cenas', 'licenca_distributer_terminals.licenca_distributer_cenaId', '=', 'licenca_distributer_cenas.id')
        ->leftJoin('licenca_tips', 'licenca_distributer_cenas.licenca_tipId', '=', 'licenca_tips.id')
        ->where('licenca_distributer_terminals.distributerId', '=', $did)
        ->where('licenca_distributer_terminals.nenaplativ', '=', 1)
        ->whereNotNull('licenca_distributer_terminals.licenca_distributer_cenaId')
        ->where('terminals.sn', 'like', '%'.$searchParams['searchTerminalSnNpl'].'%')
        ->where('lokacijas.mesto', 'like', '%'.$searchParams['searchMestoNpl'].'%')
        ->when($searchParams['searchTipLicenceNpl'] > 0, function ($rtval){
            return $rtval->where('licenca_distributer_terminals.licenca_distributer_cenaId', '=', $searchParams['searchTipLicenceNpl']);
        } )
        ->orderBy('terminal_lokacijas.id')
        ->orderBy('licenca_distributer_cenas.licenca_tipId')
        ->paginate(Config::get('global.paginate'));
    }

}
