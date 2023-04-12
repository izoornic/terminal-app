<?php
namespace App\Ivan;

use App\Models\TerminalLokacija;

class SelectedTerminalInfo 
{

    public static function selectedTerminalInfo($tlid)
    {
        return TerminalLokacija::select('terminal_lokacijas.*', 'terminals.sn', 'terminals.terminal_tipId as tid', 'terminal_status_tips.ts_naziv', 'lokacijas.l_naziv', 'lokacijas.adresa', 'lokacijas.mesto', 'lokacijas.pib', 'lokacijas.lokacija_tipId', 'lokacija_kontakt_osobas.name', 'lokacija_kontakt_osobas.tel', 'regions.r_naziv', 'regions.id as rid')
                    ->where('terminal_lokacijas.id',  $tlid)
                    ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                    ->leftJoin('terminal_status_tips', 'terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
                    ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('lokacija_kontakt_osobas', 'lokacijas.id', '=', 'lokacija_kontakt_osobas.lokacijaId')
                    ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
                    -> first();
    }

    public static function selectedTerminalInfoSerialNumber($sn)
    {
        return TerminalLokacija::select('terminal_lokacijas.*', 'terminals.sn', 'terminals.terminal_tipId as tid', 'terminal_status_tips.ts_naziv', 'lokacijas.l_naziv', 'lokacijas.mesto', 'lokacijas.pib', 'lokacija_kontakt_osobas.name', 'lokacija_kontakt_osobas.tel', 'regions.r_naziv')
                    ->where('terminals.sn',  $sn)
                    ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                    ->leftJoin('terminal_status_tips', 'terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
                    ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('lokacija_kontakt_osobas', 'lokacijas.id', '=', 'lokacija_kontakt_osobas.lokacijaId')
                    ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
                    ->first();
    }

    public static function selectedTerminalInfoTerminalId($tid)
    {
        return TerminalLokacija::select('terminal_lokacijas.*', 'terminals.sn', 'terminals.terminal_tipId as tid', 'terminal_status_tips.ts_naziv', 'lokacijas.l_naziv', 'lokacijas.mesto', 'lokacijas.pib', 'lokacija_kontakt_osobas.name', 'lokacija_kontakt_osobas.tel', 'regions.r_naziv', 'regions.id as rid')
                    ->where('terminalId', $tid)            
                    ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                    ->leftJoin('terminal_status_tips', 'terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
                    ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('lokacija_kontakt_osobas', 'lokacijas.id', '=', 'lokacija_kontakt_osobas.lokacijaId')
                    ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
                    -> first(); 
    }

    public static function selectedTerminalInfoTerminalLokacijaId($tid)
    {
        return TerminalLokacija::select('terminal_lokacijas.*', 'terminals.sn', 'terminals.terminal_tipId as tid', 'terminal_status_tips.ts_naziv', 'lokacijas.l_naziv', 'lokacijas.mesto', 'lokacijas.pib','lokacijas.lokacija_tipId', 'lokacija_kontakt_osobas.name', 'lokacija_kontakt_osobas.tel', 'regions.r_naziv', 'regions.id as rid')
                    ->where('terminal_lokacijas.id', $tid)            
                    ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                    ->leftJoin('terminal_status_tips', 'terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
                    ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('lokacija_kontakt_osobas', 'lokacijas.id', '=', 'lokacija_kontakt_osobas.lokacijaId')
                    ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
                    -> first(); 
    }

    public function terminalInfo($id, $typeOf)
    { 
        return TerminalLokacija::select('terminal_lokacijas.*', 'terminals.sn', 'terminals.terminal_tipId as tid', 'terminal_status_tips.ts_naziv', 'lokacijas.l_naziv', 'lokacijas.adresa', 'lokacijas.mesto', 'lokacija_kontakt_osobas.name', 'lokacija_kontakt_osobas.tel', 'regions.r_naziv', 'regions.id as rid')
                    ->when($typeOf == "terminal_lokacija", function ($rtval) use($id){
                        return $rtval->where('terminal_lokacijas.id',  $id);
                    })
                    ->when($typeOf == "terminalID", function ($rtval) use($id){
                        return $rtval->where('terminalId', $id);
                    })
                    ->when($typeOf == "terminalSN", function ($rtval) use($id){
                        return $rtval->where('terminals.sn', $id);
                    })
                    ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                    ->leftJoin('terminal_status_tips', 'terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
                    ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('lokacija_kontakt_osobas', 'lokacijas.id', '=', 'lokacija_kontakt_osobas.lokacijaId')
                    ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
                    -> first();
        
    }

}