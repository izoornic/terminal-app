<?php

namespace App\Http\Livewire;

use Auth;

use App\Models\User;
use App\Models\Terminal;
use App\Models\Lokacija;
use App\Models\TerminalLokacija;
use App\Models\LokacijaKontaktOsoba;
use App\Models\TerminalLokacijaHistory;
use App\Models\DistributerLokacijaIndex;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use App\Http\Helpers;

use App\Ivan\SelectedTerminalInfo;

class Lokacijes extends Component
{
    use WithPagination;
    
    public $modalFormVisible;
    public $modalConfirmDeleteVisible;
    public $modelId;

    public $l_naziv;
    public $mesto;
    public $adresa;
    public $latitude;
    public $longitude;

    public $regionId;
    public $lokacija_tipId;

    public $isUpdate;

    public $validation_modal;

    //pretraga
    public $searchName;
    public $searchMesto;
    public $searchTip = 0;
    public $searchRegion = 0;
    public $searchPib;

    //order
    public $orderBy;

    //delete check
    public $odabranaLokacija;
    public $deletePosible;
    public $brTerminala;
    public $terminaliList;

    //ADD terminal to location
    public $modalAddTerminalVisible;
    public $addingType;
    public $p_lokacija_tipId;
    public $p_lokacijaId;

    public $searchSN;
    public $searchBK;
    public $selsectedTerminals = [];
    public $selectAll;
    public $allInPage = [];
    public $selectAllValue = 1;
    public $t_status;

    public $errAddMsg = '';

    public $searchPLokacijaNaziv;
    public $searchPlokacijaMesto;
    public $searchPlokacijaRegion;

    public $lokacijaSaKojeUzima;
    public $datum_dodavanja_terminala;

    //Error licenca MODAL
    public $licencaError;
    public $modalErorLicencaVisible;

    //dodaj novi terminal
    public $noviSN;
    public $noviKutijaNO;
    public $new_terminal_tip;


    //kontakt osoba u prodavnici
    public $kontaktOsobaVisible;
    public $kontaktOsobaInfo;

    public $nameKo;
    public $telKo;

    public $pib;
    public $mb;
    public $email;

    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        if($this->validation_modal == 'new_terminal'){
            return [
                'noviSN' => 'required',
                'noviKutijaNO' => 'required',
            ];
        }else{
            return [   
                'l_naziv' => 'required',  
                'regionId' => ['required', 'not_in:0'],
                'lokacija_tipId' => ['required', 'not_in:0'],
                'latitude' => ['regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', 'nullable'],             
                'longitude' => ['regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', 'nullable'],
                'pib' => ($this->isUpdate) ? ['digits_between:8,16'] : ['digits_between:8,16', 'unique:lokacijas'],
                'email' => ['string', 'email', 'max:255', 'unique:lokacijas', 'nullable']   
            ];
        }
        
    }


    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        $order = 'id';
        switch($this->orderBy){
            case 'uid':
                $order = 'id';
            break;
            case 'name':
                $order = 'l_naziv';
            break;
            case 'mesto':
                $order = 'mesto';
            break;
            case 'region':
                $order = 'regionId';
            break;
            case 'tip':
                $order = 'lokacija_tipId';
            break;
        };
        
        return Lokacija::select('lokacijas.*', 'lokacija_tips.lt_naziv', 'regions.r_naziv', 'lokacija_kontakt_osobas.name as kontakt', 'lokacija_tips.id as tipid')
        ->leftJoin('regions', 'regions.id', '=', 'lokacijas.regionId')
        ->leftJoin('lokacija_tips', 'lokacijas.lokacija_tipId', '=', 'lokacija_tips.id')
        ->leftJoin('lokacija_kontakt_osobas', 'lokacijas.id', '=', 'lokacija_kontakt_osobas.lokacijaId')
        ->where('lokacijas.l_naziv', 'like', '%'.$this->searchName.'%')
        ->where('lokacijas.mesto', 'like', '%'.$this->searchMesto.'%')
        ->when($this->searchPib, function ($rtval){
            return $rtval->where('lokacijas.pib', 'like', '%'.$this->searchPib.'%');
        } )
        ->where('lokacijas.regionId', ($this->searchRegion > 0) ? '=' : '<>', $this->searchRegion)
        ->where('lokacijas.lokacija_tipId', ($this->searchTip > 0) ? '=' : '<>', $this->searchTip)
        ->orderBy($order)
        ->paginate(Config::get('global.paginate'), ['*'], 'lokacije');
    }

    protected function loc_reset()
    {
        // Assign the variables here
        $this->modelId = 0;
        $this->l_naziv = '';
        $this->mesto = '';
        $this->adresa = '';
        $this->latitude = '';
        $this->longitude = '';

        $this->regionId = 0;
        $this->lokacija_tipId = 0;

        $this->nameKo = '';
        $this->telKo = '';
        $this->pib = '';
        $this->mb = '';
        $this->email = '';
    }

    /**
     * Shows the create New lokacija modal
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->validation_modal = 'new_location';
        $this->isUpdate = false;
        $this->resetValidation();
        $this->loc_reset();
        $this->modalFormVisible = true;
    }

     /**
     * Shows the form modal
     * in update mode.
     *
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id)
    {
        $this->isUpdate = true;
        $this->resetValidation();
        $this->loc_reset();
        $this->modelId = $id;
        $this->loadModel();

        $this->modalFormVisible = true;
    }

    /**
     * Loads the model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        $data = Lokacija::find($this->modelId);
        // Assign the variables here
        $this->l_naziv = $data->l_naziv;
        $this->mesto = $data->mesto;
        $this->adresa = $data->adresa;
        $this->latitude = $data->latitude;
        $this->longitude = $data->longitude;
        $this->pib = $data->pib;
        $this->mb = $data->mb;
        $this->email = $data->email;

        $this->regionId = $data->regionId;
        $this->lokacija_tipId = $data->lokacija_tipId;

        if($this->kontaktOsobaInfo = $this->kontaktOsobaGetInfo()){
            $this->nameKo = $this->kontaktOsobaInfo->name;
            $this->telKo  = ($this->kontaktOsobaInfo->tel) ? ltrim($this->kontaktOsobaInfo->tel, '+381') : '';
            //$this->telKo = $this->kontaktOsobaInfo->tel;
        }else{
            $this->nameKo = ''; 
            $this->telKo = '';
        }
    }

    /**
     * The data for the model mapped
     * in this component.
     *
     * @return void
     */
    public function modelData()
    {
        return [  
            'l_naziv'          => $this->l_naziv,
            'mesto'            => $this->mesto,
            'adresa'           => $this->adresa,
            'latitude'         => ($this->latitude == '') ? NULL : $this->latitude,
            'longitude'        =>($this->longitude == '') ? NULL : $this->longitude,
            'regionId'         => $this->regionId,
            'lokacija_tipId'   => $this->lokacija_tipId,
            'pib'              => $this->pib, 
            'mb'               => $this->mb, 
            'email'            => (filter_var($this->email, FILTER_VALIDATE_EMAIL)) ? $this->email : NULL
        ];
    }

    /**
     * The create function.
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        $new_loc = Lokacija::create($this->modelData());
        if($this->lokacija_tipId == 3){
            if($this->nameKo != ''){
                //dd('Add new KO');
                $tell = ($this->telKo != '') ? '+381'.$this->telKo : '';
                LokacijaKontaktOsoba::create(['lokacijaId'=>$new_loc->id, 'name' => $this->nameKo, 'tel' => $tell]);
            }
        }
        $this->modalFormVisible = false;
        $this->loc_reset();
    }

    /**
     * The update function
     *
     * @return void
     */
    public function update()
    {
        $this->validate();
        Lokacija::find($this->modelId)->update($this->modelData());

        if($this->lokacija_tipId == 3){
            $db_name = $this->kontaktOsobaInfo->name ?? '';
            $db_tel = $this->kontaktOsobaInfo->tel ?? '';
            $tell = ($this->telKo != '') ? '+381'.$this->telKo : '';
            if($this->nameKo != $db_name || $this->telKo != $db_tel ){
                LokacijaKontaktOsoba::updateOrCreate(
                    ['lokacijaId' => $this->modelId],
                    ['name' => $this->nameKo, 'tel' => $tell]
                );
            }
        }
        $this->modalFormVisible = false;
    }

    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        if($this->kontaktOsobaGetInfo()){
            LokacijaKontaktOsoba::where('lokacijaId', '=', $this->modelId)->delete();
        }
        Lokacija::destroy($this->modelId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }

    /**
     * Shows the delete confirmation modal.
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id)
    {
        $this->modelId = $id;
        $this->odabranaLokacija = $this->lokacijaInfo();
       
        $this->deletePosible = false;
        
        //check if lokacija zakacena za nekog
        $data = User::where('lokacijaId', $id)->first();
        if($data === NULL){
            $this->deletePosible = true;
        };//else if($data)

        //check if lokacija ima terminale 
        $this->brTerminala = TerminalLokacija::brojTerminalaNalokaciji($id);
        if($this->brTerminala){
            $this->deletePosible = false;
        };

        //prikazi terminale na lokaciji koja je korisnik
        
        if($this->odabranaLokacija->lokacija_tipId == 3){
            $this->terminaliList = $this->terminalsAtLocation();
        }

        $this->modalConfirmDeleteVisible = true;
    }    

    private function terminalsAtLocation()
    {
        return TerminalLokacija::select('terminal_status_tips.ts_naziv', 'terminals.sn', 'terminals.terminal_tipId', 'terminals.broj_kutije', 'terminal_lokacijas.blacklist', 'licenca_distributer_tips.distributer_naziv')
                ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                ->leftJoin('terminal_status_tips', 'terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
                ->leftJoin('licenca_distributer_tips', 'terminal_lokacijas.distributerId', '=', 'licenca_distributer_tips.id')
                ->where('lokacijaId', $this->modelId )
                ->get();
    }

    public function render()
    {
        return view('livewire.lokacijes', [
            'data' => $this->read(),
        ]);
    }
    
    /**
     * Lists all rows in all tables that use particular location
     *
     * @param  mixed $id
     * @return void
     */
    public function locationUsers($id)
    {
        $retval = [];
        $retval['users'] = [];
        foreach(User::where('lokacijaId', $id)->get() as $row){
            array_push($retval['users'], $row['name']);
        };
        //MORA DA SE UPDATUJE I FUNKCIJA deleteShowModal($id)
        if(TerminalLokacija::brojTerminalaNalokaciji($id)){
            $retval['terminal'] = [];
            array_push($retval['terminal'], TerminalLokacija::brojTerminalaNalokaciji($id));
        } 
        //dd($retval); 
       return $retval;
    }

    //ADD TERMINAL MODAL    
    /**
     * addTerminalShowModal
     *
     * @param  mixed $id
     * @return void
     */
    public function addTerminalShowModal($id)
    {
        $this->validation_modal = 'new_terminal';
        $this->noviSN = '';
        $this->noviKutijaNO = '';
        $this->new_terminal_tip = 0;

        $this->modelId = $id;
        $this->odabranaLokacija = $this->lokacijaInfo();
        $this->errAddMsg = '';
        $this->t_status = 0;
        $this->addingType = 'location';
        $this->selsectedTerminals = [];
        $this->searchSN = '';
        $this->p_lokacija_tipId = 0;
        $this->p_lokacijaId = 0;
        $this->datum_dodavanja_terminala = Helpers::datumKalendarNow();
        $this->licencaError = '';

        $this->modalAddTerminalVisible = true;
    }
        
    /**
     * lokacijaInfo
     *
     * @return object
     */
    private function lokacijaInfo()
    {
        return Lokacija::select('lokacijas.*', 'lokacija_tips.lt_naziv', 'regions.r_naziv')
        ->leftJoin('lokacija_tips', 'lokacijas.lokacija_tipId', '=', 'lokacija_tips.id')
        ->leftJoin('regions', 'regions.id', '=', 'lokacijas.regionId')
        ->where('lokacijas.id', '=', $this->modelId)
        ->first();
    }
    
    /**
     * lokacjaSaKojeUzimaInfo
     *
     * @return void
     */
    private function lokacjaSaKojeUzimaInfo()
    {
        return Lokacija::select('lokacijas.*', 'lokacija_tips.lt_naziv', 'regions.r_naziv')
            ->leftJoin('lokacija_tips', 'lokacijas.lokacija_tipId', '=', 'lokacija_tips.id')
            ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
            ->where('lokacijas.id', '=', $this->p_lokacijaId)
            ->first();
    }
    /**
     * terminaliZaLokaciju
     *
     * @param  mixed $id
     * @param  mixed $sn
     * @param  mixed $bk 
     * @return void
     */
    public function terminaliZaLokaciju($id, $sn = '', $bk = '')
    { 
        $this->allInPage = [];
        
        $terms =  TerminalLokacija::leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                                ->leftJoin('terminal_tips', 'terminals.terminal_tipId', '=', 'terminal_tips.id')
                                ->leftJoin('terminal_status_tips', 'terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
                                ->select('terminal_lokacijas.*', 'terminals.sn', 'terminals.broj_kutije', 'terminal_status_tips.ts_naziv', 'terminals.id as tid', 'terminal_tips.model')
                                ->where('terminal_lokacijas.lokacijaId', $id)
                                ->where('terminals.sn', 'like', '%'.$sn.'%')
                                ->where('terminals.broj_kutije', 'like', '%'.$bk.'%')
                                ->paginate(Config::get('global.terminal_paginate'), ['*'], 'terminaliLokacija');
        foreach($terms as $terminal){
            array_push($this->allInPage,  $terminal->id);
        }
        //$this->selectAll[1] = false;
        return $terms;
    }
    
    /**
     * lokacijeTipa
     *
     * @param  mixed $tipId
     * @return void
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
     * addTerminal
     *
     * @return void
     */
    public function addTerminal()
    {
        //da li se terminal dodaje Distributeru?
        $distributer_tip_id = ($this->odabranaLokacija->lokacija_tipId == 4) ? DistributerLokacijaIndex::where('lokacijaId', '=', $this->modelId)->first()->licenca_distributer_tipsId : null;
        //dd($distributer_tip_id);
        
        if($this->addingType == 'location'){
            //ima li izabranih terminala
            if(!count($this->selsectedTerminals)){
                $this->errAddMsg = 'Niste izabrali terminal';
                return;
            }

            if($this->t_status < 1){
                $this->errAddMsg = 'Niste izabrali status terminal';
                return;
            }
            
            $this->errAddMsg = '';

            //Da li treminali imaju licencu?
            foreach($this->selsectedTerminals as $item){
                if(SelectedTerminalInfo::terminalImaLicencu($item)){
                    $this->licencaError = 'multi';
                    $this->modalErorLicencaVisible = true;
                    $this->selsectedTerminals=[];
                    $this->modalAddTerminalVisible = false;
                    return;
                }
            }
            
            //PREMESTI TERMINALE
            $terminali_premesteni = TerminalLokacija::premestiTerminale($this->selsectedTerminals, $this->modelId, $this->datum_dodavanja_terminala, $this->t_status, $distributer_tip_id);
        
            if(!$terminali_premesteni){
                $this->licencaError = 'db';
                $this->modalErorLicencaVisible = true;
                $this->selsectedTerminals=[];
                $this->modalAddTerminalVisible = false;
                return;
            }

            $this->modalAddTerminalVisible = false;
                   
        }elseif($this->addingType == 'addNew'){
            // ADDING NEW TERMINAL
            $this->validate();
            
            if($this->t_status < 1 || $this->new_terminal_tip < 1){
                $this->errAddMsg = 'Niste izabrali status ili tip terminala';
                return;
            }
            
            if(Terminal::where('sn', 'like', $this->noviSN)->first()){
                $this->errAddMsg = 'Terminal sa serijskim brojem koji ste uneli već postoji!';
                return;
            }
            
            $this->errAddMsg = '';
            DB::transaction(function()use($distributer_tip_id){
                //add to terminal table
                $newTerminal = Terminal::create(['sn' => $this->noviSN, 'terminal_tipId' => $this->new_terminal_tip, 'broj_kutije' => $this->noviKutijaNO]);
                TerminalLokacija::create(['terminalId' => $newTerminal->id, 'lokacijaId' => $this->modelId, 'terminal_statusId'=> $this->t_status, 'korisnikId'=>auth()->user()->id, 'korisnikIme'=>auth()->user()->name, 'updated_at'=>$this->datum_dodavanja_terminala, 'distributerId' => $distributer_tip_id ]);
            });
            $this->modalAddTerminalVisible = false; 
        }
    }
    
    /**
     * Prikazuje Kontakt osoba Modal
     *
     * @param  mixed $id
     * @return void
     */
    public function showKontaktOsobaModal($id)
    {
        $this->modelId = $id;
        $this->odabranaLokacija = $this->lokacijaInfo();
        $this->kontaktOsobaInfo = $this->kontaktOsobaGetInfo();



        $this->kontaktOsobaVisible = true;
    }

    private function kontaktOsobaGetInfo()
    {
        return LokacijaKontaktOsoba::where('lokacijaId', '=', $this->modelId)
                                ->first();
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

        if($this->modalAddTerminalVisible || $this->kontaktOsobaVisible){
            $this->odabranaLokacija = $this->lokacijaInfo();
        }

        if($this->modalAddTerminalVisible && $this->p_lokacijaId){
            $this->lokacijaSaKojeUzima = $this->lokacjaSaKojeUzimaInfo();
        }
    }
}