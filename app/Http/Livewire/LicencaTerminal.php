<?php

namespace App\Http\Livewire;

use App\Models\Lokacija;
use App\Models\TerminalLokacija;
use App\Models\LicenceZaTerminal;
use App\Models\LicencaDistributerTip;
use App\Models\DistributerLokacijaIndex;
use App\Models\TerminalLokacijaHistory;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use App\Http\Helpers;

use App\Ivan\TerminalHistory;
use App\Ivan\TerminalBacklist;
use App\Ivan\SelectedTerminalInfo;

class LicencaTerminal extends Component
{
    use WithPagination;
    
    public $modelId;

    //premesti modal
    public $modalConfirmPremestiVisible;

    public $plokacijaTip;
    public $plokacija;
    public $searchPLokacijaNaziv;
    public $searchPlokacijaMesto;
    public $searchPlokacijaRegion;
    public $canMoveTerminal = 0;
    public $modalStatusPremesti;
    public $datum_premestanja_terminala;

    public $selectedTerminal;

    //LICENCA GRESKA MODAL
    public $licencaError;
    public $modalErorLicencaVisible;
   
    //BLACKLIST
    public $modalFormVisible;
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

    //licence modal
    public $licencaModalVisible;
    public $licencaData;
   
    /**
     * [Description for mount]
     *
     * @return [type]
     * 
     */
    public function mount()
    {
        //dd(session('searchTip'));
        /* if (session('searchTipTerminal') == null ){
            session(['searchTipTerminal' => 3]);
        };
        $this->searchTipTeminal = session('searchTipTerminal');

        if (session('searchStatus') == null ){
            session(['searchStatus' => 2]);
        };
        $this->searchStatus = session('searchStatus'); */

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

        $terms =  TerminalLokacija::select('lokacijas.*', 'terminals.id as tid', 'terminals.sn', 'terminals.broj_kutije', 'terminal_tips.model', 'lokacija_tips.lt_naziv', 'regions.r_naziv', 'terminal_status_tips.ts_naziv', 'terminal_status_tips.id as statusid', 'terminal_lokacijas.id as tlid', 'terminal_lokacijas.blacklist', 'terminal_lokacijas.distributerId')
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

        $terms->each(function ($item, $key){
            $item->tzlid = (LicenceZaTerminal::where('terminal_lokacijaId', '=', $item->tlid)->first()) ? 1 : 0;
            array_push($this->allInPage,  $item->tid);
        });

        /* foreach($terms as $terminal){
            array_push($this->allInPage,  $terminal->tid);
        } */

        return $terms;
    }

    /**
     * Shows the premesti modal.
     *
     * @param  mixed $id
     * @return void
     */
    public function premestiShowModal($id, $status)
    {
        $this->multiSelected = false;
        $this->modelId = $id;
        $this->plokacijaTip = 0;
        $this->plokacija = 0;
        $this->canMoveTerminal = 0;
        $this->modalStatusPremesti = $status;
        $this->licencaError = '';

        $this->searchPLokacijaNaziv ='';
        $this->searchPlokacijaMesto ='';
        $this->searchPlokacijaRegion = 0;
        //podaci o terminalu koji se premesta
        $this->selectedTerminal = SelectedTerminalInfo::selectedTerminalInfoTerminalId($this->modelId);
        //dd($this->selectedTerminal);
        $this->modalConfirmPremestiVisible = true;

        $this->datum_premestanja_terminala = Helpers::datumKalendarNow();
    } 

    public function premestiSelectedShowModal(){
        
        $this->multiSelected = true;
        $this->multiSelectedInfo = $this->multiSelectedTInfo();

        //status na listi se setuje prema prvom izabranom terminalu
        $this->modalStatusPremesti = TerminalLokacija::where('terminalId', $this->selsectedTerminals[0])->first()->terminal_statusId;
        //dd($this->modalStatusPremesti);

        $this->plokacijaTip = 0;
        $this->plokacija = 0;
        $this->canMoveTerminal = 0;

        $this->searchPLokacijaNaziv ='';
        $this->searchPlokacijaMesto ='';
        $this->searchPlokacijaRegion = 0;
        $this->licencaError = '';

        $this->modalConfirmPremestiVisible = true;

        $this->datum_premestanja_terminala = Helpers::datumKalendarNow();
    }

    /**
     * Premesta terminal na novu lokaciju
     *
     * @return void
     */
    public function moveTerminal(){
        //dodam datum ako ne valja
        if(!(bool)strtotime($this->datum_premestanja_terminala)) $this->datum_premestanja_terminala = Helpers::datumKalendarNow();
        //zalepim vreme za timestamp
        $this->datum_premestanja_terminala.= ' '.Helpers::vremeKalendarNow();

        //da li se terminal dodaje Distributeru?
        $distributer_tip_id = ($this->plokacijaTip == 4) ? DistributerLokacijaIndex::where('lokacijaId', '=', $this->plokacija)->first()->licenca_distributer_tipsId : null;
       
        if(!$this->multiSelected) $this->selsectedTerminals[0] = $this->modelId;

        //Da li terminal ima aktivnu licencu
        foreach($this->selsectedTerminals as $item){
            if(SelectedTerminalInfo::terminalImaLicencu($item)){
                $this->licencaError = 'multi';
                $this->modalErorLicencaVisible = true;
                $this->selsectedTerminals=[];
                $this->modalConfirmPremestiVisible = false;
                return;
            }
        }

        //PREMESTI TERMINALE
        $terminali_premesteni = TerminalLokacija::premestiTerminale($this->selsectedTerminals, $this->plokacija, $this->datum_premestanja_terminala, $this->modalStatusPremesti, $distributer_tip_id);
       
        if(!$terminali_premesteni){
            $this->licencaError = 'db';
            $this->modalErorLicencaVisible = true;
            $this->selsectedTerminals=[];
            $this->modalConfirmPremestiVisible = false;
            return;
        }

        
        $this->selsectedTerminals=[];
        $this->modalConfirmPremestiVisible = false;
    }
    /**
     * Prikazuje naziv lokacije na koju se premesta terminal
     *
     * @return void
     */
    public function novaLokacija()
    {
        return Lokacija::select('lokacijas.*', 'regions.r_naziv')
                            ->leftJoin('lokacija_tips', 'lokacijas.lokacija_tipId', '=', 'lokacija_tips.id')
                            ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
                            ->where('lokacijas.id', '=', $this->plokacija)
                            ->first();
    }
    
    /**
     * Puni tabelu u modalu iz koje se bira lokacija
     *
     * @param mixed $tipId
     * 
     * @return [type]
     * 
     */
    public function lokacijeTipa($tipId)
    {
        return Lokacija::select('lokacijas.*', 'regions.r_naziv')
            ->where('lokacija_tipId', '=', $tipId)
            ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
            ->where('l_naziv', 'like', '%'.$this->searchPLokacijaNaziv.'%')
            ->where('mesto', 'like', '%'.$this->searchPlokacijaMesto.'%')
            ->where('lokacijas.regionId', ($this->searchPlokacijaRegion > 0) ? '=' : '<>', $this->searchPlokacijaRegion)
            ->paginate(Config::get('global.modal_search'), ['*'], 'loc');
    }

    /**
     * Shows blacklist update modal - multi or sigle
     *
     * @return void
     */
    public function blacklistShowModal($id=0)
    {
        $this->canBlacklistErorr = '';
        $this->canBlacklist = true;
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
            
        
        $this->modalFormVisible = true;
    }

     /**
     * The update function
     *
     * @return void
     */
    public function blacklistUpdate()
    {
        if(TerminalBacklist::AddRemoveBlacklist($this->modelId)){
            TerminalBacklist::CreateBlacklistFile();
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
     * Prikaz aktivnih licenci
     *
     * @param mixed $tlid
     * 
     * @return [type]
     * 
     */
    public function licencaShowModal($id)
    {
        $this->modelId = $id; //ovo je id terminal lokacija tabele
        $this->selectedTerminal = SelectedTerminalInfo::selectedTerminalInfoTerminalLokacijaId($this->modelId);
        $this->licencaData = LicenceZaTerminal::sveAktivneLicenceTerminala($id);
        //dd($this->licencaData);
        $this->licencaModalVisible = true;
    }

    /**
     * updated
     *
     * @return void
     */
    public function updated($key, $value)
    {
        
        session(['searchTipTerminal' =>  $this->searchTipTeminal]);
        $exp = Str::of($key)->explode(delimiter: '.');
        if($exp[0] === 'selectAll' && is_numeric($value)){
           foreach($this->allInPage as $termid){
               if(!in_array($termid, $this->selsectedTerminals)){
                array_push($this->selsectedTerminals, $termid);
               }  
           }
        }elseif($exp[0] === 'selectAll' && empty($value)){
            $this->selsectedTerminals = array_diff($this->selsectedTerminals, $this->allInPage);
        }

        if($this->modalConfirmPremestiVisible || $this->modalFormVisible){
            $this->selectedTerminal = SelectedTerminalInfo::selectedTerminalInfoTerminalId($this->modelId);
        }

        if($this->multiSelected && $this->modalConfirmPremestiVisible){
            $this->multiSelectedInfo = $this->multiSelectedTInfo();
        }

        if($this->modalFormVisible){
            //blacklist modal
            $this->selectedTerminal = SelectedTerminalInfo::selectedTerminalInfoTerminalId($this->modelId);
        }

        /* if($this->multiSelected && ($this->modalFormVisible)){
            $this->multiSelectedInfo = $this->multiSelectedTInfo();
        } */
    }


    public function render()
    {
        return view('livewire.licenca-terminal', [
            'data' => $this->read(),
        ]);
    }
}
