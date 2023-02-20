<?php

namespace App\Http\Livewire;

use App\Models\TerminalLokacija;
use App\Models\TerminalLokacijaHistory;
use App\Models\Lokacija;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

use App\Http\Helpers;

use App\Ivan\TerminalHistory;
use App\Ivan\SelectedTerminalInfo;
use App\Ivan\TerminalBacklist;

class LicencaTerminal extends Component
{
    use WithPagination;
    
    public $modalFormVisible;

    public $modelId;

    //premesti modal
    public $plokacija;
   
    public $selectedTerminal;
    public $canBlacklist;
    public $canBlacklistErorr;

    //select all
    public $selsectedTerminals = [];
    public $selectAll;
    public $allInPage = [];

    //search
    public $searchSB;
    public $searchKutija;
    public $searchName;
    public $searchRegion;
    public $searchTipTeminal;
    public $searchStatus;
    public $searchBlackist;

    //multi selected
    public $multiSelected;
    public $multiSelectedInfo;

    //terminal HISTORY
    public $terminalHistoryVisible;
    public $historyData;
   
    /**
     * [Description for mount]
     *
     * @return [type]
     * 
     */
    public function mount()
    {
        //dd(session('searchTip'));
        if (session('searchTipTerminal') == null ){
            session(['searchTipTerminal' => 3]);
        };
        $this->searchTipTeminal = session('searchTipTerminal');

        if (session('searchStatus') == null ){
            session(['searchStatus' => 2]);
        };
        $this->searchStatus = session('searchStatus');

        $this->searchBlackist = 0;
    }

    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
       
    }

    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        //dd($this->searchBlackist);
        $this->allInPage = [];

        $terms =  TerminalLokacija::select('lokacijas.*', 'terminals.id as tid', 'terminals.sn', 'terminals.broj_kutije', 'terminal_tips.model', 'lokacija_tips.lt_naziv', 'regions.r_naziv', 'terminal_status_tips.ts_naziv', 'terminal_status_tips.id as statusid', 'terminal_lokacijas.id as tlid', 'terminal_lokacijas.blacklist' )
        ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
        ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
        ->leftJoin('terminal_tips', 'terminals.terminal_tipId', '=', 'terminal_tips.id')
        ->leftJoin('lokacija_tips', 'lokacijas.lokacija_tipId', '=', 'lokacija_tips.id')
        ->leftJoin('regions', 'regions.id', '=', 'lokacijas.regionId')
        ->leftJoin('terminal_status_tips','terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
        ->where('terminals.sn', 'like', '%'.$this->searchSB.'%')
        ->where('terminals.broj_kutije', 'like', '%'.$this->searchKutija.'%')
        ->where('lokacijas.l_naziv', 'like', '%'.$this->searchName.'%')
        ->where('lokacijas.regionId', ($this->searchRegion > 0) ? '=' : '<>', $this->searchRegion)
        ->where('lokacijas.lokacija_tipId', ($this->searchTipTeminal > 0) ? '=' : '<>', $this->searchTipTeminal)
        ->where('terminal_status_tips.id', ($this->searchStatus > 0) ? '=' : '<>', $this->searchStatus)
        ->when($this->searchBlackist != 0, function ($rtval){
           if ($this->searchBlackist == 1){
                return $rtval->where('terminal_lokacijas.blacklist', '=', 1); 
           }else{
                return $rtval->whereNull('terminal_lokacijas.blacklist');
           }
           
        } )
        ->paginate(Config::get('global.terminal_paginate'), ['*'], 'terminali');

        foreach($terms as $terminal){
            array_push($this->allInPage,  $terminal->tid);
        }

        return $terms;
    }

    /**
     * Shows blacklist update modal - multi or sigle
     *
     * @return void
     */
    public function blacklistShowModal($id=0)
    {
        $this->canBlacklist = true;
        $this->canBlacklistErorr = '';

        if($id==0){
            $this->multiSelected = true;
            $this->multiSelectedInfo = $this->multiSelectedTInfo();
        }else{
            $this->multiSelected = false;
            $this->modelId = $id;
            $this->selectedTerminal = SelectedTerminalInfo::selectedTerminalInfoTerminalLokacijaId($this->modelId);
            if($this->selectedTerminal->blacklist == 1){
                $this->canBlacklistErorr = 'Da li ste sigurni da želite da uklonite terminal sa Blackliste?';
            }else{
                $this->canBlacklistErorr = 'Da li ste sigurni da želite da dodate terminal na Blacklistu?';
            }
            if($this->selectedTerminal->lokacija_tipId != 3){
                $this->canBlacklist = false;
                $this->canBlacklistErorr = 'Samo terminali koji su instalirani korisnicima mogu se dodavti na Blacklistu!';
            }
            if($this->selectedTerminal->ts_naziv != 'Instaliran'){
                $this->canBlacklist = false;
                $this->canBlacklistErorr = 'Samo terminali sa statsom "Instaliran" se mogu dodavti na Blacklistu!';
            }
            
        }
        
        $this->modalFormVisible = true;
    }

     /**
     * The update function
     *
     * @return void
     */
    public function blacklistUpdate()
    {
        
        if($this->multiSelected){
            /* foreach($this->selsectedTerminals as $item){
                DB::transaction(function()use($item){
                    //terminal
                    $cuurent = TerminalLokacija::where('terminalId', $item) -> first();
                    //insert to history table
                    TerminalLokacijaHistory::create(['terminal_lokacijaId' => $cuurent['id'], 'terminalId' => $cuurent['terminalId'], 'lokacijaId' => $cuurent['lokacijaId'], 'terminal_statusId' => $cuurent['terminal_statusId'], 'korisnikId' => $cuurent['korisnikId'], 'korisnikIme' => $cuurent['korisnikIme'], 'created_at' => $cuurent['created_at'], 'updated_at' => $cuurent['updated_at']]);
                    //update current
                    TerminalLokacija::where('terminalId', $item)->update(['terminal_statusId'=> $this->modalStatus, 'korisnikId'=>auth()->user()->id, 'korisnikIme'=>auth()->user()->name ]);
                });
            } */
        }else{
            if(TerminalBacklist::AddRemoveBlacklist($this->modelId)){
                TerminalBacklist::CreateBlacklistFile();
            }
            
        }
        $this->selsectedTerminals=[];
        $this->canBlacklistErorr = '';
        $this->modalFormVisible = false;
    }

    private function multiSelectedTInfo()
    {
        return TerminalLokacija::whereIn('terminalId', $this->selsectedTerminals )
        ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
        ->leftJoin('terminal_status_tips', 'terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
        ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
        ->orderBy('lokacijaId')
        ->get();
    }

    /**
     * History MODAL
     *
     * @return void
     */
    public function terminalHistoryShowModal($id)
    {
        $this->historyData = null;
        $this->modelId = $id; //ovo je id terminal lokacija tabele
        $this->selectedTerminal = SelectedTerminalInfo::selectedTerminalInfoTerminalLokacijaId($this->modelId);
        $this->historyData = TerminalHistory::terminalHistoryData($this->modelId);

        $this->terminalHistoryVisible = true;
    }

    /**
     * updated
     *
     * @return void
     */
    public function updated()
    {
        
        session(['searchTipTerminal' =>  $this->searchTipTeminal]);

        if($this->modalFormVisible){
            $this->selectedTerminal = SelectedTerminalInfo::selectedTerminalInfoTerminalId($this->modelId);
        }

        if($this->multiSelected && ($this->modalFormVisible)){
            $this->multiSelectedInfo = $this->multiSelectedTInfo();
        }
    }


    public function render()
    {
        return view('livewire.licenca-terminal', [
            'data' => $this->read(),
        ]);
    }
}
