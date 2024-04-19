<?php

namespace App\Models;

use App\Models\LicencaDistributerTip;
use App\Models\TerminalLokacijaHistory;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TerminalLokacija extends Model
{
    use HasFactory;
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'terminalId',
        'lokacijaId',
        'terminal_statusId',
        'korisnikId',
        'korisnikIme',
        'updated_at',
        'blacklist',
        'distributerId'
    ];

    public static function brojTerminalaNalokaciji($id)
    {
       return TerminalLokacija::select('lokacijaId')
                ->where('lokacijaId', '=', $id)
                ->get()
                ->count();
    }

    /**
     * Premesta terminale sa lokacije na lokaciju i updejturje broj terminala kod distributera. 
     * Koristi se na trei stranice: LicencaTerminal, Terminal, Lokacijes
     *
     * @param mixed $termila_ids            ( Array )   idovi terminala koji se premestaju
     * @param mixed $lokacija_id            ( int )
     * @param mixed $datumPremestanja       ( Date )
     * @param mixed $status_terminala_id    ( int )
     * @param mixed $distributer_id         ( int or null )
     * 
     * @return [type]
     * 
     */
    public static function premestiTerminale($termila_ids, $lokacija_id, $datumPremestanja, $status_terminala_id, $distributer_id)
    {
        $retval = false;
        $oduzeti_distributeru = [];

        foreach($termila_ids as $item){
            $cuurent = TerminalLokacija::where('terminalId', $item) -> first();
            //da li se terminal oduzima distributeru?
            if(isset($cuurent->distributerId)){
                if(!in_array($cuurent->distributerId, $oduzeti_distributeru)) array_push($oduzeti_distributeru, $cuurent->distributerId);
            } 

            DB::transaction(function()use($item, $cuurent, $lokacija_id, $distributer_id, $datumPremestanja, $status_terminala_id){
                //insert to history table
                TerminalLokacijaHistory::create(['terminal_lokacijaId' => $cuurent['id'], 'terminalId' => $cuurent['terminalId'], 'lokacijaId' => $cuurent['lokacijaId'], 'terminal_statusId' => $cuurent['terminal_statusId'], 'korisnikId' => $cuurent['korisnikId'], 'korisnikIme' => $cuurent['korisnikIme'], 'created_at' => $cuurent['created_at'], 'updated_at' => $cuurent['updated_at'], 'blacklist' => $cuurent['blacklist'], 'distributerId' => $cuurent['distributerId']]);
                //update current
                TerminalLokacija::where('terminalId', $item)->update(['terminal_statusId'=> $status_terminala_id, 'lokacijaId' => $lokacija_id, 'korisnikId'=>auth()->user()->id, 'korisnikIme'=>auth()->user()->name, 'updated_at'=>$datumPremestanja, 'distributerId' => $distributer_id ]);
            });
        }

        //prebroj i update dodate terminale distributera
        if(isset($distributer_id))LicencaDistributerTip::prebrojUpdateTerminaleDistributera($distributer_id);
        //prebroj i update ako su oduzeti terminali
        if(count($oduzeti_distributeru)){
            foreach($oduzeti_distributeru as $dist_id){
                LicencaDistributerTip::prebrojUpdateTerminaleDistributera($dist_id);
            }
        }
        $retval = true;
        return $retval;
    }
}
