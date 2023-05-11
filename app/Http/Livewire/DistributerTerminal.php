<?php

namespace App\Http\Livewire;

use App\Models\TerminalLokacija;
use App\Models\LicencaParametar;
use App\Models\LicenceZaTerminal;
use App\Models\LicencaDistributerTip;
use App\Models\LicencaDistributerCena;
use App\Models\LicencaParametarTerminal;
use App\Models\LicencaDistributerTerminal;

use App\Http\Helpers;
use App\Ivan\CryptoSign;
use App\Ivan\SelectedTerminalInfo;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;

class DistributerTerminal extends Component
{
    use WithPagination;
    
    public $modalFormVisible;
    public $modalConfirmDeleteVisible;
    public $modelId; //ID u tabeli terminal_lokacias

    //set on MOUNT
    public $distId;
    public $dist_name;
    public $osnovna_licenca_id;
    public $osnovna_licenca_naziv;
    public $ditributer_info;
    
    //SEARCH MAIN
    public $searchTerminalSn;
    public $searchMesto;
    public $searchTipLicence;
    public $searchNenaplativ;

    //dodaj terminal MODAL
    public $isUpdate;
    public $allInPage;
    public $selectAllValue = 1;
    public $selectAll;
    public $searchSN;
    public $searchBK;
    public $selsectedTerminals = [];

    public $datum_kraja_licence;
    public $datum_pocetka_licence;
    
    public $licence_za_dodavanje = [];
    public $dani_trajanja;

    public $parametri = [];

    //DODAJ LICENCU MODAL
    public $dodajLicencuModalVisible;
    //public $terminal_info;
    public $licence_dodate_terminalu = [];
    public $distrib_terminal_id;

    //DELETE MODAL
    public $deleteAction;
    public $canDelete;
    public $briseSe;

    //terminal info modal
    public $modalTerminalInfoVisible;
    public $terminalInfo;
    public $licenceNaziviInfo;

    public $licparams;

    //PARAMETRI LICENCE MODAL
    public $parametriModalVisible;
    public $pm_licenca_tip_id;
    //niz sa globalno dodeljenim parametrima za licencu
    public $licenca_tip_parametri;
    public $pm_licenca_naziv;

   /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->distId = request()->query('id');
        $lic_ar = LicencaDistributerCena::OsnovnaLicencaDistributera($this->distId);
        $this->dist_name = LicencaDistributerTip::DistributerName($this->distId);
        $this->osnovna_licenca_id =  $lic_ar[0];
        $this->osnovna_licenca_naziv = $lic_ar[1];
        $this->ditributer_info = LicencaDistributerTip::where('id', '=', $this->distId)->first();
        
    }

    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'datum_pocetka_licence' => ['required', 'date_format:"Y-m-d"'],
            'datum_kraja_licence' => ['required', 'date_format:"Y-m-d"']       
        ];
    }

    /**
     * The reset form for new teminal
     *
     * @return void
     */
    public function resetTerm()
    {
        $this->allInPage = [];
        $this->selectAllValue = 0;
        $this->selectAll = null;
        $this->selsectedTerminals = [];
        $this->datum_pocetka_licence = Helpers::datumKalendarNow();
        $this->datum_kraja_licence = Helpers::firstDayOfMounth(Helpers::addMonthsToDate($this->datum_pocetka_licence, 1));
        //$this->datum_kraja_licence = Helpers::lastDayOfManth($this->datum_pocetka_licence, 1);
        $this->licence_za_dodavanje = [];
        $this->distrib_terminal_id = 0;
        $this->dani_trajanja = 1;
        $this->parametri = [];
    }

   /**
     * Koliko terminala ima distributer function.
     *
     * @return object
     */
    public function prebrojTerminaleDistributera()
    {
        return LicencaDistributerTerminal::select()
        ->where('distributerId', '=', $this->distId)
        ->distinct('terminal_lokacijaId')
        ->count();
    }

    /**
     * Shows the create modal
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->resetTerm();
        $this->modalFormVisible = true;
    }

     /**
     * The create function. 
     *
     * @return void
     */
    public function create()
    {
        $ima_licenci = count($this->licence_za_dodavanje);
        if($ima_licenci){
            $this->validate();
            $this->dani_trajanja = Helpers::numberOfDaysBettwen($this->datum_pocetka_licence, $this->datum_kraja_licence);
            if(!$this->dani_trajanja){
                return;
            }

            //parametri
            $parametriAll = $this->parametersAll();
        }
        if( count($this->selsectedTerminals)){
            $model_data = [
                'distributerId' => $this->distId,
                'licenca_distributer_cenaId' => null,
                'datum_pocetak' => ($ima_licenci) ? $this->datum_pocetka_licence : null,
                'datum_kraj' => ($ima_licenci) ? $this->datum_kraja_licence : null,
                'licenca_broj_dana' => ($ima_licenci) ? $this->dani_trajanja : 0,
            ];

            foreach($this->selsectedTerminals as $tre_loc_id){
                $model_data['terminal_lokacijaId'] = $tre_loc_id;
                $terminal_info = SelectedTerminalInfo::selectedTerminalInfoTerminalLokacijaId($tre_loc_id);
                if($ima_licenci){
                    foreach ($this->licence_za_dodavanje as $licenca_id){
                        $licenca_tip_id = LicencaDistributerCena::where('id', '=', $licenca_id)->first()->licenca_tipId;
                        $model_data['licenca_distributer_cenaId'] = $licenca_id;
                        $new_licence = LicencaDistributerTerminal::create($model_data);
                        $this->addParametersToLicence($new_licence->id, $parametriAll, $licenca_tip_id);

                        $nazivLicence = LicencaDistributerCena::nazivLicence($licenca_id);
                        
                        //dodaj licence terminalu za prezimanje
                        $key_arr = [
                            'terminal_lokacijaId' => $tre_loc_id,
                            'distributerId' => $this->distId,
                            'licenca_distributer_cenaId' => $licenca_id,
                        ];
                        $vals_ins = [
                            'mesecId'=> 0,
                            'terminal_sn' => $terminal_info->sn,
                            'datum_pocetak' => $this->datum_pocetka_licence,
                            'datum_kraj' => $this->datum_kraja_licence,
                            'datum_prekoracenja' => Helpers::addDaysToDate($this->datum_kraja_licence, $this->ditributer_info->dani_prekoracenja_licence),
                            'naziv_licence' => $nazivLicence
                        ];
                        $this->AddToLicenceZaTerminal($key_arr, $vals_ins);
                    }
                }else{
                    LicencaDistributerTerminal::create($model_data);
                }
            }
            $this->updateBrTerminalaDistributeru();
        }
        $this->modalFormVisible = false;
       $this->resetTerm();
    }

    private function AddToLicenceZaTerminal($key_arr, $vals_ins)
    {
         //update or create zapis u tabeli licenca_terminas 
         
        $signature_cripted =  CryptoSign::criptSignature($vals_ins);
        $vals_ins['signature'] = $signature_cripted;

        LicenceZaTerminal::updateOrCreate( $key_arr, $vals_ins );
    }

    private function parametersAll()
    {
        $parametriAll = [];
        foreach ($this->licence_za_dodavanje as $licencaa_id){
            $licenca_tip_id = LicencaDistributerCena::where('id', '=', $licencaa_id)->first()->licenca_tipId;
            $parametri_licence = LicencaParametar::where('licenca_tipId', '=', $licenca_tip_id)->pluck('id')->all();
            $parametriAll[$licenca_tip_id] = $parametri_licence;
        }
        return $parametriAll;
    }

    private function addParametersToLicence($lic_dist_termId, $parametriAll, $licenca_tip_id)
    {
        foreach($parametriAll[$licenca_tip_id] as $parametarJedneLicence){
            if(in_array($parametarJedneLicence, $this->parametri)){
                LicencaParametarTerminal::create(['licenca_distributer_terminalId' => $lic_dist_termId, 'licenca_parametarId' => $parametarJedneLicence]);
            }
        }
        $this->updateBrojParametaraLicence($lic_dist_termId);
    }

    private function updateBrojParametaraLicence($lic_dist_termId)
    {
        $br_parametara = LicencaParametarTerminal::where('licenca_distributer_terminalId', '=', $lic_dist_termId)->count();
        LicencaDistributerTerminal::find($lic_dist_termId)->update(['broj_parametara' => $br_parametara]);
    }

    private function updateBrTerminalaDistributeru()
    {
        LicencaDistributerTip::where('id', '=', $this->distId) ->update(['broj_terminala' => $this->prebrojTerminaleDistributera()]);
    }

    /**
     * Shows dodaj Licenca modal.
     *
     * @return void
     */
    public function dodajLicencaShowModal($tre_loc_id, $ldtidd)
    {
        $this->resetTerm();
        $this->distrib_terminal_id = $ldtidd;
        $this->modelId = $tre_loc_id;
        $this->licence_za_dodavanje = [];
        $this->licence_dodate_terminalu = $this->licenceDodateTerminalu();
        //dd($this->licence_dodate_terminalu);
        if ($this->licence_dodate_terminalu[0] == null) $this->licence_dodate_terminalu = [];
        $this->dodajLicencuModalVisible = true;
    }

    private function licenceDodateTerminalu()
    {
        return LicencaDistributerTerminal::where('terminal_lokacijaId', '=', $this->modelId)
                    ->pluck('licenca_distributer_cenaId')->all();
    }

    /**
     * Dodaj licence function.
     *
     * @return void
     */
    public function dodajLicenceTerminalu()
    {
        $this->validate();
        //parametri
        $parametriAll = $this->parametersAll();

        $terminal_info = SelectedTerminalInfo::selectedTerminalInfoTerminalLokacijaId($this->modelId);

        $this->dani_trajanja = Helpers::numberOfDaysBettwen($this->datum_pocetka_licence, $this->datum_kraja_licence);
        if($this->dani_trajanja){
            if(count($this->licence_za_dodavanje)){
                $model_data = [
                    'distributerId' => $this->distId,
                    'terminal_lokacijaId' => $this->modelId,
                    'datum_pocetak' => $this->datum_pocetka_licence,
                    'datum_kraj' => $this->datum_kraja_licence,
                    'licenca_broj_dana' => $this->dani_trajanja
                ];

                foreach($this->licence_za_dodavanje as $lc){
                    $licenca_tip_id = LicencaDistributerCena::where('id', '=', $lc)->first()->licenca_tipId;

                    $model_data['licenca_distributer_cenaId'] = $lc;
                    $nazivLicence = LicencaDistributerCena::nazivLicence($lc);

                    if($lc == $this->osnovna_licenca_id){
                        $new_licence = $this->distrib_terminal_id;
                        LicencaDistributerTerminal::where('id', '=', $this->distrib_terminal_id)
                            ->update([
                                'licenca_distributer_cenaId' =>  $lc,
                                'datum_pocetak' => $this->datum_pocetka_licence,
                                'datum_kraj' => $this->datum_kraja_licence,
                                'licenca_broj_dana' => $this->dani_trajanja
                            ]);
                    }else{
                        $new_licence = LicencaDistributerTerminal::create($model_data)->id; 
                    } 
                    $this->addParametersToLicence($new_licence, $parametriAll, $licenca_tip_id);

                     //dodaj licence terminalu za prezimanje
                     $key_arr = [
                        'terminal_lokacijaId' => $this->modelId,
                        'distributerId' => $this->distId,
                        'licenca_distributer_cenaId' => $lc,
                    ];
                    $vals_ins = [
                        'mesecId'=> 0,
                        'terminal_sn' => $terminal_info->sn,
                        'datum_pocetak' => $this->datum_pocetka_licence,
                        'datum_kraj' => $this->datum_kraja_licence,
                        'datum_prekoracenja' => Helpers::addDaysToDate($this->datum_kraja_licence, $this->ditributer_info->dani_prekoracenja_licence),
                        'naziv_licence' => $nazivLicence
                    ];
                    $this->AddToLicenceZaTerminal($key_arr, $vals_ins);
                }
                $this->updateBrTerminalaDistributeru();
            }
            $this->resetTerm();
            $this->dodajLicencuModalVisible = false;
        }        
    }

    public function deleteLicencuShowModal($tre_loc_id, $ldtidd)
    {
        $this->licence_dodate_terminalu = [];
        $this->deleteAction = 'licenca';
        $this->modelId = $tre_loc_id;
        $this->distrib_terminal_id = $ldtidd;
        $this->briseSe = '';
        

        // 1. provera, da li brise osnovnu licencu
        if(LicencaDistributerTerminal::select('licenca_distributer_cenaId')->where('id', '=', $ldtidd)->first()->licenca_distributer_cenaId == $this->osnovna_licenca_id){
            //2. provera, da li ima jos licenci sem osnovne
            $this->licence_dodate_terminalu = $this->licenceDodateTerminalu();
            if(count($this->licence_dodate_terminalu) > 1){
                //ima vise licnci
                $this->briseSe = 'osnovnaIdodatne';
            }else{
                $this->briseSe = 'osnovna';
            }
        }else{
            $this->briseSe = 'dodatna';
        }
        $this->modalConfirmDeleteVisible = true;
    }

    public function delteLicenca()
    {
        switch($this->briseSe){
            case 'osnovnaIdodatne':
                $rows = LicencaDistributerTerminal::select('id', 'licenca_distributer_cenaId')->where('terminal_lokacijaId', '=', $this->modelId)->get();
                foreach($rows as $row){
                    if($row->licenca_distributer_cenaId == $this->osnovna_licenca_id){
                        //update
                        LicencaDistributerTerminal::where('id', '=', $row->id)->update(['licenca_distributer_cenaId' => null, 'datum_pocetak' => null, 'datum_kraj' => null, 'nenaplativ' => 0]);
                    }else{
                        //delete
                        LicencaDistributerTerminal::destroy($row->id);
                    }
                    $this->deleteParams($row->id);
                }
                break;
            case 'osnovna':
                LicencaDistributerTerminal::where('id', '=', $this->distrib_terminal_id)->update(['licenca_distributer_cenaId' => null, 'datum_pocetak' => null, 'datum_kraj' => null, 'nenaplativ' => 0]);
                $this->deleteParams($this->distrib_terminal_id);
                break;
            case 'dodatna':
                LicencaDistributerTerminal::destroy($this->distrib_terminal_id);
                $this->deleteParams($this->distrib_terminal_id);
                break;
        }
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }

    private function deleteParams($distributer_terminal_licId)
    {
        LicencaParametarTerminal::where('licenca_distributer_terminalId', '=', $distributer_terminal_licId)->delete();
    }

    /**
     * Returns id from tabe licenca_distributer_terminal.
     *
     * @param  integer $terminl_lokacija_id
     * @return object
     */
    private function dodatneLicenceIdes($terminl_lokacija_id)
    {
        return LicencaDistributerTerminal::where('terminal_lokacijaId', '=', $this->modelId)
                    ->pluck('id')->all();
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

    /**
     * Shows the delete confirmation modal.
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id, $ldtidd)
    {
        $this->deleteAction = 'terminal';
        $this->modelId = $id;
        $this->distrib_terminal_id = $ldtidd;
        $this->terminalInfo = SelectedTerminalInfo::selectedTerminalInfoTerminalLokacijaId($this->modelId);
        $this->modalConfirmDeleteVisible = true;
    }  
    
     /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        LicencaDistributerTerminal::destroy($this->distrib_terminal_id);
        $this->updateBrTerminalaDistributeru();
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }

    /**
     * Lista terminala koji imaju licencu 
     * pa ne mogu biti dodati kao novi
     *
     * @return object
     */
    private function tremninaliSaLicencom()
    {
        $DodeljeneLicence = LicencaDistributerTerminal::select('terminal_lokacijaId')->distinct()->pluck('terminal_lokacijaId')->all();

        return $DodeljeneLicence;
    }

    /**
     * terminaliZaLokaciju
     *
     * @param  mixed $id
     * @param  mixed $sn
     * @param  mixed $bk 
     * @return object
     */
    public function terminaliZaLokaciju( $sn = '', $bk = '')
    { 
        $this->allInPage = [];
        //->where('terminal_lokacijas.lokacijaId', $id)
        $terms =  TerminalLokacija::select('terminal_lokacijas.*', 'terminals.sn', 'terminals.broj_kutije', 'terminal_status_tips.ts_naziv', 'terminal_tips.model')
                                ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                                ->leftJoin('terminal_tips', 'terminals.terminal_tipId', '=', 'terminal_tips.id')
                                ->leftJoin('terminal_status_tips', 'terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
                                ->whereNotIn('terminal_lokacijas.id', $this->tremninaliSaLicencom())
                                ->where('terminals.sn', 'like', '%'.$sn.'%')
                                ->where('terminals.broj_kutije', 'like', '%'.$bk.'%')
                                ->paginate(Config::get('global.modal_search'), ['*'], 'terminaliLokacija');
        foreach($terms as $terminal){
            array_push($this->allInPage,  $terminal->id);
        }
        //$this->selectAll[1] = false;
        return $terms;
    }

     

     /**
     * The read function. searchTipLicence
     *
     * @return void
     */
    public function read()
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
                            'licenca_tips.broj_parametara_licence')
                    ->leftJoin('terminal_lokacijas', 'licenca_distributer_terminals.terminal_lokacijaId', '=', 'terminal_lokacijas.id')
                    ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                    ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('licenca_distributer_cenas', 'licenca_distributer_terminals.licenca_distributer_cenaId', '=', 'licenca_distributer_cenas.id')
                    ->leftJoin('licenca_tips', 'licenca_distributer_cenas.licenca_tipId', '=', 'licenca_tips.id')
                    ->where('licenca_distributer_terminals.distributerId', '=', $this->distId)
                    ->where('terminals.sn', 'like', '%'.$this->searchTerminalSn.'%')
                    ->where('lokacijas.mesto', 'like', '%'.$this->searchMesto.'%')
                    ->when($this->searchTipLicence > 0, function ($rtval){
                        return $rtval->where('licenca_distributer_cenas.id', '=', ($this->searchTipLicence == 1000) ? null : $this->searchTipLicence);
                    })
                    ->when($this->searchNenaplativ > 0, function ($rtval){
                        return $rtval->where('licenca_distributer_terminals.nenaplativ', '=', 1);
                    })
                    ->orderBy('terminal_lokacijas.id')
                    ->orderBy('licenca_distributer_cenas.licenca_tipId')
                    ->paginate(Config::get('terminal_paginate'), ['*'], 'terminali');
    }

    public function parametriLicenceShowModal($licencaDistributerTerminalid, $naziv)
    {
        $this->resetTerm();
        $this->distrib_terminal_id = $licencaDistributerTerminalid;
        $this->pm_licenca_tip_id = $this->licencaTipInfo();
        $this->pm_licenca_naziv = $naziv;
        
        //PARAMETI ZA IZABRANU LICENCU
        $this->parametri = LicencaParametarTerminal::where('licenca_distributer_terminalId', '=', $this->distrib_terminal_id)->pluck('licenca_parametarId')->all();

        //GLOBALNO DODELJENI parametri za tip licence
        $this->licenca_tip_parametri = LicencaParametar::where('licenca_tipId', '=', $this->pm_licenca_tip_id)->pluck('id')->all();
        
        $this->parametriModalVisible = true;
    }

    public function updateParametreLicence()
    {
        $this->deleteParams($this->distrib_terminal_id);
        foreach($this->parametri as $parametarId){
            if(in_array($parametarId, $this->licenca_tip_parametri)){
                LicencaParametarTerminal::create(['licenca_distributer_terminalId' => $this->distrib_terminal_id, 'licenca_parametarId' => $parametarId]);
            }  
        }
        
        $this->parametriModalVisible = false;
    }

    private function licencaTipInfo(){
        return LicencaDistributerTerminal::select('licenca_distributer_cenas.licenca_tipId')
        ->leftJoin('licenca_distributer_cenas', 'licenca_distributer_cenas.id', '=', 'licenca_distributer_terminals.licenca_distributer_cenaId')
        ->where('licenca_distributer_terminals.id', '=', $this->distrib_terminal_id )
        ->first()
        ->licenca_tipId;
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
        if($this->modalFormVisible || $this->dodajLicencuModalVisible){
            $this->datum_kraja_licence = Helpers::firstDayOfMounth($this->datum_kraja_licence);
        }

        /*if($this->dodajLicencuModalVisible){
            $this->licence_dodate_terminalu = array_merge($this->licence_dodate_terminalu, $this->licence_za_dodavanje);
        }
         if($this->parametriModalVisible){
            $this->pm_licenca_tip_id = $this->licencaInfo();
        } */
    }

    public function render()
    {
        return view('livewire.distributer-terminal', [
            'data' => $this->read(), 'br_terminala' => $this->prebrojTerminaleDistributera(),
        ]);
    }
}