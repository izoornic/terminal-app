<?php
namespace App\Ivan;

use App\Models\TerminalLokacija;
use App\Models\TerminalLokacijaHistory;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use File;

class TerminalBacklist
{
    /**
     * [Description for AddRemoveBlacklist]
     *
     * @param mixed $tlid
     * 
     * @return [boolean]
     * 
     */
    public static function AddRemoveBlacklist($tlid)
    {
        try{
            DB::transaction(function()use($tlid){
                $cutren = TerminalLokacija::where('id', $tlid) -> first();
                $bl = ($cutren->blacklist == 1) ? null : 1;
                //insert to history table ZA SAD NE MOZDA DA BUDE POSEBNA TABELA?!?
                //TerminalLokacijaHistory::create(['terminal_lokacijaId' => $cuurent['id'], 'terminalId' => $cuurent['terminalId'], 'lokacijaId' => $cuurent['lokacijaId'], 'terminal_statusId' => $cuurent['terminal_statusId'], 'korisnikId' => $cuurent['korisnikId'], 'korisnikIme' => $cuurent['korisnikIme'], 'created_at' => $cuurent['created_at'], 'updated_at' => $cuurent['updated_at'], 'blacklist' => $cuurent['blacklist']]);
                //update current
                TerminalLokacija::where('id', $tlid)->update(['blacklist'=> $bl, 'korisnikId'=>auth()->user()->id, 'korisnikIme'=>auth()->user()->name]);
            });
        }catch(\Throwable $th){
            //throw $th
            return false;
        }
        return true; 
    }

    public static function CreateBlacklistFile()
    {
        $blaclist_file_content = '';
        $terminals = TerminalLokacija::where('blacklist', 1)
                        ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                        ->get();
        foreach($terminals as $terminal){
            $blaclist_file_content .= $terminal->sn.PHP_EOL; //"\n";
        }
        //dd(base_path().'/public/img/blacklist.txt');
        Storage::disk('public')->put('blacklist.txt', $blaclist_file_content);
        //dd(base_path().'/storage/app/public/storage/blacklist.txt', base_path().'/public/img/blacklist.txt');
        File::copy(base_path().'/storage/app/public/blacklist.txt', base_path().'/public/bl/blacklist.txt');
    }

}