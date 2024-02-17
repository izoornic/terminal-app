<?php

namespace App\Http\Livewire\Distributer;

use Livewire\Component;

use App\Models\Lokacija;
use App\Models\TerminalLokacija;
use App\Models\DistributerUserIndex;
use App\Models\LicencaDistributerTip;
use App\Models\TerminalLokacijaHistory;
use App\Models\DistributerLokacijaIndex;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use App\Http\Helpers;

use App\Ivan\TerminalHistory;
use App\Ivan\SelectedTerminalInfo;

use App\Helpers\PaginationHelper;

class DistributerTerminal extends Component
{
    public $distId;
    public $distData;

    //read fnc
    public $searchSB;
    public $searchKutija;
    public $searchName;
    public $searchPib;
    public $searchTip;
    public $searchStatus;

    //select all
    public $selsectedTerminals = [];
    public $selectAll;
    public $allInPage = [];
    public $multiSelected;

    //promeni statys modal
    public $modalStatus;
    public $modalFormVisible;
    public $modelId;

    //premesti modal
    public $modalConfirmPremestiVisible;
    public $plokacijaTip;
    public $plokacija;
    public $searchPLokacijaNaziv;
    public $searchPlokacijaMesto;
    public $searchPlokacijaPib;
    public $canMoveTerminal = 0;
    public $selectedTerminal;
    public $modalStatusPremesti;
    public $datum_premestanja_terminala;

    public function mount()
    {
        $this->distId = DistributerUserIndex::select('licenca_distributer_tipsId')->where('userId', '=', auth()->user()->id)->first()->licenca_distributer_tipsId;
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

        $this->searchPLokacijaNaziv ='';
        $this->searchPlokacijaMesto ='';
        $this->searchPlokacijaPib = '';
        //podaci o terminalu koji se premesta
        $this->selectedTerminal = SelectedTerminalInfo::selectedTerminalInfoTerminalId($this->modelId);
        //dd($this->selectedTerminal);
        $this->modalConfirmPremestiVisible = true;

        $this->datum_premestanja_terminala = Helpers::datumKalendarNow();
    }
    
    /**
     * Modal kada je multi selected
     *
     * @return [type]
     * 
     */
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
        $this->searchPlokacijaPib = '';

        $this->modalConfirmPremestiVisible = true;

        $this->datum_premestanja_terminala = Helpers::datumKalendarNow();
    }

    /**
     * Prikazuje info za terminale kada je multi selected
     *
     * @return [type]
     * 
     */
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
     * Rucno napravljeni filteri na starnici
     *
     * @param mixed $sn
     * @param mixed $mesto
     * @param mixed $licenca
     * 
     * @return boolean
     * 
     */
    private function filterFields($naziv, $mesto, $pib)
    {
        $filter_naziv = ($this->searchPLokacijaNaziv != '') ? true : false;
        $filter_mesto = ($this->searchPlokacijaMesto != '') ? true : false;
        $filter_pib = ($this->searchPlokacijaPib != '') ? true : false;

        $naziv_retval = true;
        $mest_retval = true;
        $pib_retval = true;
        
        if($filter_naziv){
            $naziv_retval = preg_match("/".$this->searchPLokacijaNaziv."/i", $naziv);
        }
        if($filter_mesto){
            $mest_retval = preg_match("/".$this->searchPlokacijaMesto."/i", $mesto);
        }
        if($filter_pib){
            $pib_retval = preg_match("/".$this->searchPlokacijaPib."/i", $pib);
        }

        return ($naziv_retval && $mest_retval && $pib_retval) ? true : false;
    }

    /**
     * Prikaz kolekcije sa filterima
     *
     * @return collection
     * 
     */
    public function displayData($dataAll)
    {
        $retval = $dataAll->filter(function ($value, $key) {
            return $this->filterFields($value->l_naziv, $value->mesto, $value->pib);
        });
        return $retval;
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
        $dataAll =  Lokacija::select('lokacijas.*', 'lokacija_tips.lt_naziv', 'regions.r_naziv', 'lokacija_kontakt_osobas.name as kontakt', 'lokacija_tips.id as tipid')
        ->leftJoin('regions', 'regions.id', '=', 'lokacijas.regionId')
        ->leftJoin('lokacija_tips', 'lokacijas.lokacija_tipId', '=', 'lokacija_tips.id')
        ->leftJoin('lokacija_kontakt_osobas', 'lokacijas.id', '=', 'lokacija_kontakt_osobas.lokacijaId')
        ->whereIn('lokacijas.id', function($q){
            $q->select('lokacijaId')
                ->from('terminal_lokacijas')
                ->where('terminal_lokacijas.distributerId', '=', $this->distId);
        })
        ->orWhere('lokacijas.distributerId', '=', $this->distId)
        ->get();

        return PaginationHelper::paginate($this->displayData($dataAll), Config::get('global.paginate'));
        
        
        /* return Lokacija::select('lokacijas.*', 'regions.r_naziv')
            ->leftJoin('regions', 'regions.id', '=', 'lokacijas.regionId')
            ->leftJoin('lokacija_tips', 'lokacijas.lokacija_tipId', '=', 'lokacija_tips.id')
            ->leftJoin('lokacija_kontakt_osobas', 'lokacijas.id', '=', 'lokacija_kontakt_osobas.lokacijaId')
            ->whereIn('lokacijas.id', function($q){
                $q->select('lokacijaId')
                    ->from('terminal_lokacijas')
                    ->where('terminal_lokacijas.distributerId', '=', $this->distId);
            })
            ->orWhere('lokacijas.distributerId', '=', $this->distId)
            ->where('lokacijas.l_naziv', 'like', '%'.$this->searchPLokacijaNaziv.'%')
            ->where('lokacijas.mesto', 'like', '%'.$this->searchPlokacijaMesto.'%')
            ->when($this->searchPib, function ($rtval){
                return $rtval->where('lokacijas.pib', 'like', '%'.$this->searchPlokacijaPib.'%');
            } )
            ->where('lokacijas.lokacija_tipId', '=', $tipId)
            ->paginate(Config::get('global.paginate'), ['*'], 'lokacije'); */


        /* return Lokacija::select('lokacijas.*', 'regions.r_naziv')
            ->where('lokacija_tipId', '=', $tipId)
            ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
            ->where('l_naziv', 'like', '%'.$this->searchPLokacijaNaziv.'%')
            ->where('mesto', 'like', '%'.$this->searchPlokacijaMesto.'%')    
            ->where('pib', 'like', '%'.$this->searchPlokacijaPib.'%')
            ->paginate(Config::get('global.modal_search'), ['*'], 'loc'); */
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
     * Premesta terminal na novu lokaciju
     *
     * @return void
     */
    public function moveTerminal(){

        if(!(bool)strtotime($this->datum_premestanja_terminala)) $this->datum_premestanja_terminala = Helpers::datumKalendarNow();
        $this->datum_premestanja_terminala.= ' '.Helpers::vremeKalendarNow();

        //da li se terminal dodaje Distributeru?
        //$this->distId = ($this->plokacijaTip == 4) ? DistributerLokacijaIndex::where('lokacijaId', '=', $this->plokacija)->first()->licenca_distributer_tipsId : NULL;
        //dd($this->distId);          

        if($this->multiSelected){
            foreach($this->selsectedTerminals as $item){
                DB::transaction(function()use($item){
                    $cuurent = TerminalLokacija::where('terminalId', $item) -> first();
                    //insert to history table
                    TerminalLokacijaHistory::create(['terminal_lokacijaId' => $cuurent['id'], 'terminalId' => $cuurent['terminalId'], 'lokacijaId' => $cuurent['lokacijaId'], 'terminal_statusId' => $cuurent['terminal_statusId'], 'korisnikId' => $cuurent['korisnikId'], 'korisnikIme' => $cuurent['korisnikIme'], 'created_at' => $cuurent['created_at'], 'updated_at' => $cuurent['updated_at'], 'blacklist' => $cuurent['blacklist'], 'distributerId' => $cuurent['distributerId']]);
                    //update current
                    TerminalLokacija::where('terminalId', $item)->update(['terminal_statusId'=> $this->modalStatusPremesti, 'lokacijaId' => $this->plokacija, 'korisnikId'=>auth()->user()->id, 'korisnikIme'=>auth()->user()->name, 'updated_at'=>$this->datum_premestanja_terminala ]);
                });
            }
        }else{
            //$this->validate();
            DB::transaction(function(){
                //terminal
                $cuurent = TerminalLokacija::where('terminalId', $this->modelId) -> first();
                //insert to history table
                TerminalLokacijaHistory::create(['terminal_lokacijaId' => $cuurent['id'], 'terminalId' => $cuurent['terminalId'], 'lokacijaId' => $cuurent['lokacijaId'], 'terminal_statusId' => $cuurent['terminal_statusId'], 'korisnikId' => $cuurent['korisnikId'], 'korisnikIme' => $cuurent['korisnikIme'], 'created_at' => $cuurent['created_at'], 'updated_at' => $cuurent['updated_at'], 'blacklist' => $cuurent['blacklist'], 'distributerId' => $cuurent['distributerId']]);
                //update current
                TerminalLokacija::where('terminalId', $this->modelId)->update(['terminal_statusId'=> $this->modalStatusPremesti, 'lokacijaId' => $this->plokacija, 'korisnikId'=>auth()->user()->id, 'korisnikIme'=>auth()->user()->name, 'updated_at'=>$this->datum_premestanja_terminala ]);
            });
        }
        $this->selsectedTerminals=[];
        $this->modalConfirmPremestiVisible = false;
    }

    /**
     * Shows STATUS update modal
     *
     * @param  mixed $id
     * @return void
     */
    public function statusShowModal($id, $status)
    {
        $this->multiSelected = false;
        $this->modelId = $id;
        $this->modalStatus = $status;
        $this->selectedTerminal = SelectedTerminalInfo::selectedTerminalInfoTerminalId($this->modelId);
        //$this->resetValidation();
        //$this->reset();
        $this->modalFormVisible = true;
    }

    /**
     * Status update function
     *
     * @return void
     */
    public function statusUpdate()
    {
        if($this->multiSelected){
            foreach($this->selsectedTerminals as $item){
                DB::transaction(function()use($item){
                    //terminal
                    $cuurent = TerminalLokacija::where('terminalId', $item) -> first();
                    //insert to history table
                    TerminalLokacijaHistory::create(['terminal_lokacijaId' => $cuurent['id'], 'terminalId' => $cuurent['terminalId'], 'lokacijaId' => $cuurent['lokacijaId'], 'terminal_statusId' => $cuurent['terminal_statusId'], 'korisnikId' => $cuurent['korisnikId'], 'korisnikIme' => $cuurent['korisnikIme'], 'created_at' => $cuurent['created_at'], 'updated_at' => $cuurent['updated_at'], 'blacklist' => $cuurent['blacklist'], 'distributerId' => $cuurent['distributerId']]);
                    //update current
                    TerminalLokacija::where('terminalId', $item)->update(['terminal_statusId'=> $this->modalStatus, 'korisnikId'=>auth()->user()->id, 'korisnikIme'=>auth()->user()->name ]);
                });
            }
        }else{
            //$this->validate();
            DB::transaction(function(){
                //terminal
                $cuurent = TerminalLokacija::where('terminalId', $this->modelId) -> first();
                //insert to history table
                TerminalLokacijaHistory::create(['terminal_lokacijaId' => $cuurent['id'], 'terminalId' => $cuurent['terminalId'], 'lokacijaId' => $cuurent['lokacijaId'], 'terminal_statusId' => $cuurent['terminal_statusId'], 'korisnikId' => $cuurent['korisnikId'], 'korisnikIme' => $cuurent['korisnikIme'], 'created_at' => $cuurent['created_at'], 'updated_at' => $cuurent['updated_at'], 'blacklist' => $cuurent['blacklist'], 'distributerId' => $cuurent['distributerId']]);
                //update current
                TerminalLokacija::where('terminalId', $this->modelId)->update(['terminal_statusId'=> $this->modalStatus, 'korisnikId'=>auth()->user()->id, 'korisnikIme'=>auth()->user()->name ]);
            });
        }
        $this->selsectedTerminals=[];
        $this->modalFormVisible = false;
    }

    /**
     * updated
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public function updated($key, $value)
    {
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

        if($this->multiSelected && ($this->modalFormVisible || $this->modalConfirmPremestiVisible)){
            $this->multiSelectedInfo = $this->multiSelectedTInfo();
        }
    }

    public function read()
    {
        $this->allInPage = [];

        $terms = TerminalLokacija::select('lokacijas.*', 'terminals.id as tid', 'terminals.sn', 'terminals.broj_kutije', 'terminal_tips.model', 'lokacija_tips.lt_naziv', 'regions.r_naziv', 'terminal_status_tips.ts_naziv', 'terminal_status_tips.id as statusid', 'terminal_lokacijas.id as tlid', 'terminal_lokacijas.blacklist', 'terminal_lokacijas.distributerId')
        ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
        ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
        ->leftJoin('terminal_tips', 'terminals.terminal_tipId', '=', 'terminal_tips.id')
        ->leftJoin('lokacija_tips', 'lokacijas.lokacija_tipId', '=', 'lokacija_tips.id')
        ->leftJoin('regions', 'regions.id', '=', 'lokacijas.regionId')
        ->leftJoin('terminal_status_tips','terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
        ->where('terminals.sn', 'like', '%'.$this->searchSB.'%')
        ->where('terminals.broj_kutije', 'like', '%'.$this->searchKutija.'%')
        ->where('lokacijas.l_naziv', 'like', '%'.$this->searchName.'%')
        ->where('lokacijas.pib','like', '%'.$this->searchPib.'%')
        ->where('lokacijas.lokacija_tipId', ($this->searchTip > 0) ? '=' : '<>', $this->searchTip)
        ->where('terminal_status_tips.id', ($this->searchStatus > 0) ? '=' : '<>', $this->searchStatus)
        ->where('terminal_lokacijas.distributerId', '=', $this->distId)
        ->paginate(Config::get('global.terminal_paginate'), ['*'], 'terminali');

        foreach($terms as $terminal){
            array_push($this->allInPage,  $terminal->tid);
        }

        return $terms; 
    }

    public function render()
    {
        return view('livewire.distributer.distributer-terminal' , [
            'data' => $this->read(),
        ]);
    }
}
