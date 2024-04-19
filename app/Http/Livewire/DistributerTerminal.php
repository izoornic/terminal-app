<?php

namespace App\Http\Livewire;

use App\Models\LicencaNaplata;
use App\Models\TerminalLokacija;
use App\Models\LicencaParametar;
use App\Models\LicenceZaTerminal;
use App\Models\LicencaDistributerTip;
use App\Models\LicencaDistributerCena;
use App\Models\LicencaParametarTerminal;
//use App\Models\LicencaDistributerTerminal;

use App\Http\Helpers;
use App\Ivan\CryptoSign;
use App\Ivan\SelectedTerminalInfo;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class DistributerTerminal extends Component
{
    use WithPagination;
    
    public $modalConfirmDeleteVisible;
    public $modelId; //ID u tabeli terminal_lokacias

    //set on MOUNT
    public $distId;
    public $dist_name;
    public $ditributer_info;
    public $broj_terminala;
    public $broj_licenci;
    
    //SEARCH MAIN
    public $searchTerminalSn;
    public $searchMesto;
    public $searchTipLicence;
    public $searchNenaplativ;

    public $licence_dodate_terminalu = [];
    public $distrib_terminal_id;

    //DELETE MODAL
    public $deleteAction;

    //terminal info modal
    public $modalTerminalInfoVisible;
    public $terminalInfo;
    public $licenceNaziviInfo;

   /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->distId = request()->query('id');
        //$this->dist_name = LicencaDistributerTip::DistributerName($this->distId);
        $this->ditributer_info = LicencaDistributerTip::where('id', '=', $this->distId)->first();
        $this->dist_name = $this->ditributer_info->distributer_naziv;
        $this->broj_terminala = $this->ditributer_info->broj_terminala;
        $this->checkAndUpdateBrojTerminala();
    }

    private function checkAndUpdateBrojTerminala()
    {
        $ter_and_lic_info = $this->prebrojLicenceITerminaleDistributera();
        $this->broj_licenci = $ter_and_lic_info['br_licenci'];
        if($ter_and_lic_info['br_terminala'] != $this->broj_terminala){
            $this->broj_terminala = $ter_and_lic_info['br_terminala'];
            //LicencaDistributerTip::where('id', '=', $this->distId)->update(['broj_terminala' => $this->broj_terminala ]);
        }
    }

    /**
     * Koliko terminala ima distributer function.
     *
     * @return object
     */
    private function prebrojLicenceITerminaleDistributera()
    {
        return [
            'br_licenci' => LicencaNaplata::select()->where('distributerId', '=', $this->distId)->where('aktivna', '=', 1)->count(),
            'br_terminala' => TerminalLokacija::select()->where('distributerId', '=', $this->distId)->count()
        ];
    }

    /**
     * Shows terminal info modal.
     *
     * @return void
     */
    public function terminalInfoShowModal($terminal_lokacija_id)
    {
        $this->modelId = $terminal_lokacija_id;
        $this->licenceNaziviInfo = LicencaDistributerCena::naziviDodatihLicenci($this->licenceDodateTerminalu());
        $this->terminalInfo = SelectedTerminalInfo::selectedTerminalInfoTerminalLokacijaId($terminal_lokacija_id);
        $this->modalTerminalInfoVisible = true;
    }
   
    private function licenceDodateTerminalu()
    {
        return LicenceZaTerminal::where('terminal_lokacijaId', '=', $this->modelId)
                    ->pluck('licenca_distributer_cenaId')->all();
    }

   /**
    * Brise sve licence dodate terminalu
    *
    * @return [type]
    * 
    */
   public function deleteLicenceTerminala()
   {
        dd($this->licenceDodateTerminalu());
        foreach ($this->licenceDodateTerminalu() as $key => $value) {
            
        }
        $this->modalTerminalInfoVisible = false;
   }

    private function deleteParams($distributer_terminal_licId)
        {
            LicencaParametarTerminal::where('licenca_distributer_terminalId', '=', $distributer_terminal_licId)->delete();
        }

     /**
     * The read function. searchTipLicence
     *
     * @return void
     */
    public function read()
    {
        
        return TerminalLokacija::select(
            'terminal_lokacijas.id', 
            'terminals.sn', 
            'lokacijas.l_naziv', 
            'lokacijas.mesto', 
            'lokacijas.adresa', 
            'licenca_naplatas.id as lnid', 
            'licenca_naplatas.datum_pocetka_licence', 
            'licenca_naplatas.datum_kraj_licence',
            'licenca_naplatas.nenaplativ', 
            'licenca_tips.licenca_naziv', 
            'licenca_tips.id as ltid', 
            'licenca_tips.broj_parametara_licence')
    ->leftJoin('licenca_naplatas', function($join)
        {
            $join->on('licenca_naplatas.terminal_lokacijaId', '=', 'terminal_lokacijas.id');
            $join->on('licenca_naplatas.aktivna', '=', DB::raw("1"));
        })
    ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
    ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
    ->leftJoin('licenca_distributer_cenas', 'licenca_naplatas.licenca_distributer_cenaId', '=', 'licenca_distributer_cenas.id')
    ->leftJoin('licenca_tips', 'licenca_distributer_cenas.licenca_tipId', '=', 'licenca_tips.id')
    ->where('terminal_lokacijas.distributerId', '=', $this->distId)
    ->where('terminals.sn', 'like', '%'.$this->searchTerminalSn.'%')
    ->where('lokacijas.mesto', 'like', '%'.$this->searchMesto.'%')
    ->when($this->searchTipLicence > 0, function ($rtval){
        return $rtval->where('licenca_distributer_cenas.id', '=', ($this->searchTipLicence == 1000) ? null : $this->searchTipLicence);
    })
    ->when($this->searchNenaplativ > 0, function ($rtval){
        return $rtval->where('licenca_naplatas.nenaplativ', '=', 1);
    })
    ->orderBy(\DB::raw("COALESCE(licenca_naplatas.datum_kraj_licence, '9999-12-31')", 'ASC'))
    ->orderBy('terminal_lokacijas.id')
    ->orderBy('licenca_distributer_cenas.licenca_tipId')
    ->paginate(Config::get('terminal_paginate'), ['*'], 'terminali');
        
    }
    
    public function render()
    {
        return view('livewire.distributer-terminal', [
            'data' => $this->read()
        ]);
    }
}