<?php

namespace App\Http\Livewire;

use App\Models\TerminalLokacija;
use App\Models\TerminalLokacijaHistory;
use App\Models\Lokacija;
use App\Models\TiketPrioritetTip;
use App\Models\User;
use App\Models\TiketAkcijaKorisnikPozicija;
use App\Models\Tiket;
use App\Models\TiketOpisKvaraTip;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

use Mail;
use App\Mail\NotyfyMail;
use App\Http\Helpers;

class Terminal extends Component
{
    use WithPagination;
    
    public $modalFormVisible;
    public $modalConfirmPremestiVisible;
    public $modelId;

    //promeni statys modal
    public $modalStatus;

    //premesti modal
    public $plokacijaTip;
    public $plokacija;
    public $searchPLokacijaNaziv;
    public $searchPlokacijaMesto;
    public $searchPlokacijaRegion;
    public $canMoveTerminal = 0;
    public $selectedTerminal;
    public $modalStatusPremesti;
    public $datum_premestanja_terminala;

    //select all
    public $selsectedTerminals = [];
    public $selectAll;
    public $allInPage = [];

    //search
    public $searchSB;
    public $searchKutija;
    public $searchName;
    public $searchRegion;
    public $searchTip;
    public $searchStatus;

    //multi selected
    public $multiSelected;
    public $multiSelectedInfo;

    //terminal HISTORY
    public $terminalHistoryVisible;
    public $historyData;

    //add Tiket Modal
    public $newTiketVisible;
    public $userPozicija;
    public $prioritetTiketa;
    public $newTerminalInfo;
    public $newTiketTerminalLokacijaId;
    public $prioritetInfo;
    public $opisKvaraList;
    public $tiketStatusId;
    public $opisKvataTxt;
    public $zatvorioId;
    

    //search korisnika kome se dodeljuje tiket
    public $searchUserName;
    public $searchUserLokacija;
    public $searchUserPozicija;
    
    public $dodeljenUserId;
    public $dodeljenUserInfo;

    public $tiketAkcija;
    public $userRegion;

    public function newTiketShowModal($tid)
    {
        $this->zatvorioId = 0;
        $this->opisKvataTxt = '';
        $this->tiketStatusId = 2;
        $this->opisKvaraList = '';
        $this->searchUserName = '';
        $this->searchUserLokacija ='';
        $this->searchUserPozicija ='';

        $this->dodeljenUserInfo = null;
        $this->dodeljenUserId = null;

        $this->prioritetTiketa = 4;
        $this->newTiketTerminalLokacijaId = TerminalLokacija::select('id')->where('terminalId', '=', $tid)->first()->id;
        $this->modelId = $tid;
        $this->newTerminalInfo = $this->selectedTerminalTiketInfo();
        $this->prioritetInfo = $this->prioritetInfo();
        $this->newTiketVisible = true;
    }
     /**
     * createCallCentar
     *
     * @param  mixed $dodela
     * @return void
     */
    public function createCallCentar($dodela)
    {
        $this->validate();
        $this->dodeljenUserId = ($dodela) ? $this->sefServisa()->id : null;
        $this->tiketStatusId = ($dodela) ? 2 : 1;
        $this->createTiket();
    }

    public function createCallCentarClosedTiket()
    {
        $this->validate();
        $this->tiketStatusId = 3;
        $this->dodeljenUserId = null;
        $this->zatvorioId = auth()->user()->id;
        $this->createTiket(); 
    }
    /**
     * The create novi tiket function.
     *
     * @return void
     */
    public function createTiket()
    {
        $this->validate();
        //dd($this->sefServisa());
        $tik = Tiket::create($this->modelTiketData());
        
        //send email
        
        
        foreach ($this->mail_to_users() as $mail_to_user) {
            try {
                Mail::to($mail_to_user)->send(new NotyfyMail($this->tiketData($tik)));
            } catch (Exception $e) {
                if (count(Mail::failures()) > 0) {
                    $failures[] = $mail_to_user;
                }
            }
        }

        $this->newTiketVisible = false;
    }

    /**
     * mail_to_users # MORA UPDATE
     *  Mail se salje sefu servisa samo ako je prebacen na servis
     * @return void
     */
    private function mail_to_users()
    {
        //$user_email = $this->selectedUserInfo(auth()->user()->id)->email;
        $retval = [];
        if($this->dodeljenUserId != null && $this->dodeljenUserId != auth()->user()->id){
            $dodeljen = $this->selectedUserInfo($this->dodeljenUserId)->email;
            array_push($retval, $dodeljen);
        }
        //sef servisa
        if($this->dodeljenUserId != null && $this->dodeljenUserId != $this->sefServisa()->id){
            $sefservisa = $this->sefServisa()->email;
            array_push($retval, $sefservisa);
        }

        return $retval;
    }

    /**
     * The data for the model mapped
     * in this component.
     *
     * @return void
     */
    public function modelTiketData()
    {
        return [ 
            'tremina_lokacijalId'   =>  $this->newTiketTerminalLokacijaId,
            'tiket_statusId'        =>  $this->tiketStatusId,
            'opis_kvaraId'          =>  $this->opisKvaraList,
            'korisnik_prijavaId'    =>  auth()->user()->id,
            'korisnik_dodeljenId'   =>  $this->dodeljenUserId,
            'opis'                  =>  $this->opisKvataTxt,
            'tiket_prioritetId'     =>  $this->prioritetTiketa,
            'br_komentara'          =>  0,
            'korisnik_zatvorio_id'  =>  $this->zatvorioId

        ];
    }

    /**
     * Podaci koji se prikazuju u email poruci
     *
     * @param  mixed $tik
     * @return void
     */
    private function tiketData($tik)
    {
        $terminal_info = $this->selectedTerminalInfo();
        // Helpers::datumFormat($komentar->created_at)
        $opisKvaraObj = TiketOpisKvaraTip::where('id', '=', $tik->opis_kvaraId)->first();
        $opisKvara = ($opisKvaraObj == null) ? '' : $opisKvaraObj->tok_naziv;

       $mail_data = [
        'subject'   =>  'Novi tiket #'.$tik->id,
        'tiketlink' =>  'https://servis.epos.rs/tiketview?id='.$tik->id,
        'hedaing'   =>  'Na servisnom portalu je otvoren novi tiket #'.$tik->id,
        'row1'      =>  'Prioritet: '.$this->prioritetInfo()->tp_naziv.' | Kreiran: '.Helpers::datumFormat($tik->created_at),
        'row2'      =>  'Otvorio: '.auth()->user()->name,
        'row3'      =>  'Dodeljen: '.$this->selectedUserInfo($this->dodeljenUserId)->name,
        'row4'      =>  'Kvar: '.$opisKvara,
        'row5'      =>  'Opis: '.$tik->	opis,
        'row6'      =>  ' -::- ---  -::-',
        'row7'      =>  'Terminal: sn: '.$terminal_info->sn,
        'row8'      =>  'Status: '.$terminal_info->ts_naziv,
        'row9'      =>  'Lokacija: '.$terminal_info->l_naziv.', '.$terminal_info->mesto,
        'row10'     =>  'Region: '. $terminal_info->r_naziv,
        'row11'     =>  'Kontakt osoba: '. $terminal_info->name.'  tel: '.$terminal_info->tel
        ];
        return $mail_data;
    }

     /**
     * id Sefa Servisa
     *
     * @return void
     */
    private function sefServisa()
    {
        return User::select('users.id', 'users.name', 'users.tel', 'users.email')
            ->join('lokacijas', 'lokacijas.id', '=', 'users.lokacijaId')
            ->join('regions', 'regions.id', '=', 'lokacijas.regionId')
            ->where('users.pozicija_tipId', '=', 3)
            ->where('regions.id', '=', $this->selectedTerminalInfo()->rid)
            ->first();
    }

    /**
     * selectedUserInfo
     *
     * @return void
     */
    private function selectedUserInfo($user_id)
    {
        return User::select('users.id', 'users.name', 'users.email', 'lokacijas.l_naziv', 'lokacijas.mesto', 'pozicija_tips.naziv')
                    ->leftJoin('lokacijas', 'users.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('pozicija_tips', 'users.pozicija_tipId', '=', 'pozicija_tips.id')
                    ->where('users.id', '=', $user_id)
                    ->first();
    }
    private function selectedTerminalTiketInfo(){
        return TerminalLokacija::select('terminal_lokacijas.*', 'terminals.sn', 'terminals.terminal_tipId as tid', 'terminal_status_tips.ts_naziv', 'lokacijas.l_naziv', 'lokacijas.mesto', 'lokacija_kontakt_osobas.name', 'lokacija_kontakt_osobas.tel', 'regions.r_naziv', 'regions.id as rid')
                    ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                    ->leftJoin('terminal_status_tips', 'terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
                    ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('lokacija_kontakt_osobas', 'lokacijas.id', '=', 'lokacija_kontakt_osobas.lokacijaId')
                    ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
                    ->where('terminal_lokacijas.id', $this->newTiketTerminalLokacijaId)
                    -> first();
    }

     /**
     * Pronadji korisnika kome dodeljujes tiket
     *
     * @return void
     */
    public function searchUser()
    {
        return User::select('users.id', 'users.name', 'lokacijas.l_naziv', 'pozicija_tips.naziv')
                    ->leftJoin('lokacijas', 'users.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('pozicija_tips', 'users.pozicija_tipId', '=', 'pozicija_tips.id')
                    ->leftJoin('regions', 'regions.id', '=', 'lokacijas.regionId')
                    ->where('name', 'like', '%'.$this->searchUserName.'%')
                    ->where('l_naziv', 'like', '%'.$this->searchUserLokacija.'%')
                    ->where('naziv', 'like', '%'.$this->searchUserPozicija.'%')
                    ->when($this->tiketAkcija[1] == "region", function ($rtval){
                        return $rtval->where('regions.id', '=', $this->userRegion);
                    })
                    ->paginate(Config::get('global.modal_search'), ['*'], 'usersp');
    }    

     /**
     * prioritetInfo
     *
     * @return void
     */
    private function prioritetInfo()
    {
        return TiketPrioritetTip::where('id', '=', $this->prioritetTiketa)->first();
    }

    /**
     * Put your custom public properties here!
     */
    public function mount()
    {
        $this->userPozicija = auth()->user()->pozicija_tipId;

        $akcija = TiketAkcijaKorisnikPozicija::select('tiket_akcija_tips.id as akcijaid', 'tiket_akcija_tips.tiket_akcija', 'tiket_akcija_vrednost_tips.id as vrednostId', 'tiket_akcija_vrednost_tips.akcija_vrednost_opis')
        ->leftJoin('tiket_akcija_tips', 'tiket_akcija_tips.id', '=', 'tiket_akcija_korisnik_pozicijas.tiket_akcijaId')
        ->leftJoin('tiket_akcija_vrednost_tips', 'tiket_akcija_vrednost_tips.id', '=', 'tiket_akcija_korisnik_pozicijas.tiket_akcijavrednostId')
        ->where('tiket_akcija_korisnik_pozicijas.korisnik_pozicijaId', '=', auth()->user()->pozicija_tipId)
        ->get();
        foreach ($akcija as $value){
            $this->tiketAkcija[$value->akcijaid] = $value->akcija_vrednost_opis;
        }

        $region = Lokacija::select('regions.id as rid')
                                ->leftJoin('regions', 'regions.id', '=', 'lokacijas.regionId')
                                ->where('lokacijas.id', '=', auth()->user()->lokacijaId)
                                ->first();
        $this->userRegion = $region->rid;
    }
    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        if($this->newTiketVisible){
            return [
                'opisKvaraList' => 'required' 
            ];
        }else{
            return [

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
        $this->allInPage = [];

        $terms =  TerminalLokacija::select('lokacijas.*', 'terminals.id as tid', 'terminals.sn', 'terminals.broj_kutije', 'terminal_tips.model', 'lokacija_tips.lt_naziv', 'regions.r_naziv', 'terminal_status_tips.ts_naziv', 'terminal_status_tips.id as statusid')
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
        ->where('lokacijas.lokacija_tipId', ($this->searchTip > 0) ? '=' : '<>', $this->searchTip)
        ->where('terminal_status_tips.id', ($this->searchStatus > 0) ? '=' : '<>', $this->searchStatus)
        ->paginate(Config::get('global.terminal_paginate'), ['*'], 'terminali');

        foreach($terms as $terminal){
            array_push($this->allInPage,  $terminal->tid);
        }

        return $terms;
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
        $this->selectedTerminal = $this->selectedTerminalInfo();
        //$this->resetValidation();
        //$this->reset();
        $this->modalFormVisible = true;
    }

    /**
     * SHows STATUS update Selected terminals
     *
     * @return void
     */
    public function statusSelectedShowModal()
    {
        $this->multiSelected = true;
        $this->multiSelectedInfo = $this->multiSelectedTInfo();
        $this->modalFormVisible = true;
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
     * The update function
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
                    TerminalLokacijaHistory::create(['terminal_lokacijaId' => $cuurent['id'], 'terminalId' => $cuurent['terminalId'], 'lokacijaId' => $cuurent['lokacijaId'], 'terminal_statusId' => $cuurent['terminal_statusId'], 'korisnikId' => $cuurent['korisnikId'], 'korisnikIme' => $cuurent['korisnikIme'], 'created_at' => $cuurent['created_at'], 'updated_at' => $cuurent['updated_at']]);
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
                TerminalLokacijaHistory::create(['terminal_lokacijaId' => $cuurent['id'], 'terminalId' => $cuurent['terminalId'], 'lokacijaId' => $cuurent['lokacijaId'], 'terminal_statusId' => $cuurent['terminal_statusId'], 'korisnikId' => $cuurent['korisnikId'], 'korisnikIme' => $cuurent['korisnikIme'], 'created_at' => $cuurent['created_at'], 'updated_at' => $cuurent['updated_at']]);
                //update current
                TerminalLokacija::where('terminalId', $this->modelId)->update(['terminal_statusId'=> $this->modalStatus, 'korisnikId'=>auth()->user()->id, 'korisnikIme'=>auth()->user()->name ]);
            });
        }
        $this->selsectedTerminals=[];
        $this->modalFormVisible = false;
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
        $this->searchPlokacijaRegion = 0;
        //podaci o terminalu koji se premesta
        $this->selectedTerminal = $this->selectedTerminalInfo();
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

        $this->modalConfirmPremestiVisible = true;

        $this->datum_premestanja_terminala = Helpers::datumKalendarNow();
    }
    /**
     * Info o izabranom terminalu na MODAL pop up-u
     *
     * @return void
     */
    private function selectedTerminalInfo(){
        return TerminalLokacija::select('terminal_lokacijas.*', 'terminals.sn', 'terminals.terminal_tipId as tid', 'terminal_status_tips.ts_naziv', 'lokacijas.l_naziv', 'lokacijas.mesto', 'lokacija_kontakt_osobas.name', 'lokacija_kontakt_osobas.tel', 'regions.r_naziv', 'regions.id as rid')
        ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
        ->leftJoin('terminal_status_tips', 'terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
        ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
        ->leftJoin('lokacija_kontakt_osobas', 'lokacijas.id', '=', 'lokacija_kontakt_osobas.lokacijaId')
        ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
        ->where('terminalId', $this->modelId)
        -> first();
    }

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

        if($this->multiSelected){
            foreach($this->selsectedTerminals as $item){
                DB::transaction(function()use($item){
                    $cuurent = TerminalLokacija::where('terminalId', $item) -> first();
                    //insert to history table
                    TerminalLokacijaHistory::create(['terminal_lokacijaId' => $cuurent['id'], 'terminalId' => $cuurent['terminalId'], 'lokacijaId' => $cuurent['lokacijaId'], 'terminal_statusId' => $cuurent['terminal_statusId'], 'korisnikId' => $cuurent['korisnikId'], 'korisnikIme' => $cuurent['korisnikIme'], 'created_at' => $cuurent['created_at'], 'updated_at' => $cuurent['updated_at']]);
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
                TerminalLokacijaHistory::create(['terminal_lokacijaId' => $cuurent['id'], 'terminalId' => $cuurent['terminalId'], 'lokacijaId' => $cuurent['lokacijaId'], 'terminal_statusId' => $cuurent['terminal_statusId'], 'korisnikId' => $cuurent['korisnikId'], 'korisnikIme' => $cuurent['korisnikIme'], 'created_at' => $cuurent['created_at'], 'updated_at' => $cuurent['updated_at']]);
                //update current
                TerminalLokacija::where('terminalId', $this->modelId)->update(['terminal_statusId'=> $this->modalStatusPremesti, 'lokacijaId' => $this->plokacija, 'korisnikId'=>auth()->user()->id, 'korisnikIme'=>auth()->user()->name, 'updated_at'=>$this->datum_premestanja_terminala ]);
            });
        }
        $this->selsectedTerminals=[];
        $this->modalConfirmPremestiVisible = false;
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
            $this->selectedTerminal = $this->selectedTerminalInfo();
        }

        if($this->multiSelected && ($this->modalFormVisible || $this->modalConfirmPremestiVisible)){
            $this->multiSelectedInfo = $this->multiSelectedTInfo();
        }

        if($this->newTiketVisible){
            $this->newTerminalInfo = $this->selectedTerminalTiketInfo();
            $this->prioritetInfo = $this->prioritetInfo();

            if($this->dodeljenUserId){
                $this->dodeljenUserInfo = $this->selectedUserInfo($this->dodeljenUserId);
            }
        }
    }

        
    /**
     * History MODAL
     *
     * @return void
     */
    public function terminalHistoryShowModal($id)
    {
        $this->historyData = null;
        $this->modelId = $id;
        $this->selectedTerminal = $this->selectedTerminalInfo();
        $this->historyData = TerminalLokacijaHistory::select('terminal_lokacija_histories.*', 'terminal_status_tips.ts_naziv', 'lokacijas.l_naziv', 'lokacijas.mesto')
                                    ->where('terminal_lokacija_histories.terminalId', '=', $this->modelId)
                                    ->leftJoin('terminal_status_tips', 'terminal_lokacija_histories.terminal_statusId', '=', 'terminal_status_tips.id')
                                    ->leftJoin('lokacijas', 'terminal_lokacija_histories.lokacijaId', '=', 'lokacijas.id')
                                    ->orderBy('terminal_lokacija_histories.id', 'desc')
                                    ->get();

        $this->terminalHistoryVisible = true;
    }
    
    /* public function datumFormat($dbdate)
    {
        //return Carbon::parse($dbdate)->setTimezone('Europe/Belgrade')->translatedFormat('d. m. Y. - G:i:s');
        return Helpers::datumFormat($dbdate);
    } */

    public function render()
    {
        return view('livewire.terminal', [
            'data' => $this->read(),
        ]);
    }
}