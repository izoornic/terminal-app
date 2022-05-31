<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Auth;
use App\Models\Tiket;
use App\Models\TiketHistory;
use App\Models\TerminalLokacija;
use App\Models\TerminalLokacijaHistory;
Use App\Models\TiketKomentar;
use App\Models\User;
use App\Models\TiketOpisAkcijaIndex;
use App\Models\TiketAkcijaKorisnikPozicija;
use App\Models\TiketOpisKvaraTip;
use App\Models\Lokacija;
use App\Models\Region;
use App\Models\TiketPrioritetTip;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use Mail;
use App\Mail\NotyfyMail;
use App\Http\Helpers;

class Tiketview extends Component
{
    public $validTiket;
    public $tikid;
    public $tiket;
    public $kvarAkcijaId;

    public $userKreirao;

    //komentari
    public $newKoment;
    public $brojKomentra;
    
    //akcije nad tiketom u zavisnosti od pozicije korisnika
    //oderdjuje ko koje tikete vidi
    public $tiketAkcija;
    public $userRegion;
    public $tiketRegion;

    //dodeli tiket modal 
    public $modalDodeliTiketVisible;
    public $noviDodeljenUserId;
    public $noviDodeljenUserInfo;
    public $dodeljenUserId;
    public $searchUserName;
    public $searchUserLokacija;
    public $searchUserPozicija;
    public $prioritetTiketa;
    public $prioritetInfo;
    public $dodeljenUserInfo;

    public $listeners = ['tiketRefresh' => 'render'];
    //zatvori tiket MODAL
    public $modalZatvoriTiketVisible;

    public $zatvorioId;
    public $curentUserPozicija;
    /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->tikid = request()->query('id');
        $this->curentUserPozicija = auth()->user()->pozicija_tipId;
        //ovde ide provera ko sme da vidi tiket!!!
        //da li je validan ID
        if($this->validTiket = Tiket::where('id', '=', $this->tikid)->exists()){
            //da li korisnik ima pravo da ga vidi?
            $akcija = TiketAkcijaKorisnikPozicija::select('tiket_akcija_tips.id as akcijaid', 'tiket_akcija_tips.tiket_akcija', 'tiket_akcija_vrednost_tips.id as vrednostId', 'tiket_akcija_vrednost_tips.akcija_vrednost_opis')
                                ->leftJoin('tiket_akcija_tips', 'tiket_akcija_tips.id', '=', 'tiket_akcija_korisnik_pozicijas.tiket_akcijaId')
                                ->leftJoin('tiket_akcija_vrednost_tips', 'tiket_akcija_vrednost_tips.id', '=', 'tiket_akcija_korisnik_pozicijas.tiket_akcijavrednostId')
                                ->where('tiket_akcija_korisnik_pozicijas.korisnik_pozicijaId', '=', auth()->user()->pozicija_tipId)
                                ->get();
            foreach ($akcija as $value){
                $this->tiketAkcija[$value->akcijaid] = $value->akcija_vrednost_opis;
            }
            /*  ADMIN   1(vidi tiket) => "sve"       Call centar 1(vidi tiket) => "sve"         Sef servisa 1(vidi tiket) => "region"       Serviser 1(vidi tiket) => "dodeljen"    Prodavac 1(vidi tiket) => "region"
                        2 (kreira tiket)=> "sve"                 2 (kreira tiket)=> "sve"                   2 (kreira tiket)=> "region"              2 (kreira tiket)=> "ne"                 2 (kreira tiket)=> "ne"
                        3 (dodeljuje tiket)=> "sve"              3 (dodeljuje tiket)=> "sve"                3 (dodeljuje tiket)=> "region"           3 (dodeljuje tiket)=> "ne"              3 (dodeljuje tiket)=> "ne" */

            $this->tiketRegion = Region::select('regions.id as rid')
                                    ->join('lokacijas', 'lokacijas.regionId', '=', 'regions.id')
                                    ->join('terminal_lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                                    ->join('tikets', 'tikets.tremina_lokacijalId', '=', 'terminal_lokacijas.id')
                                    ->where('tikets.id', '=', $this->tikid)
                                    ->first()->rid;
            
            $this->userRegion = Lokacija::select('regions.id as rid')
                                    ->leftJoin('regions', 'regions.id', '=', 'lokacijas.regionId')
                                    ->where('lokacijas.id', '=', auth()->user()->lokacijaId)
                                    ->first()->rid;;
           
            //da li korisnik moze da vidi tiket
           
            if($this->tiketAkcija[1] == "region" ){
                if($this->tiketRegion != $this->userRegion){
                    $this->validTiket = false;
                }
            }
            
            $curTiket = Tiket::select('korisnik_prijavaId', 'korisnik_dodeljenId', 'tiket_prioritetId', 'korisnik_zatvorio_id')->where('tikets.id', '=', $this->tikid)->first();
            $this->prioritetTiketa = $curTiket->tiket_prioritetId;
            $this->dodeljenUserId = $curTiket->korisnik_dodeljenId;
            $this->zatvorioId = $curTiket->korisnik_zatvorio_id;

            if($this->tiketAkcija[1] == "dodeljen" ){
                $this->validTiket = false;
                if($curTiket->korisnik_prijavaId == auth()->user()->id || $curTiket->korisnik_dodeljenId == auth()->user()->id){
                    $this->validTiket = true;
                }
                
            }

            $this->prioritetInfo = $this->prioritetInfo();
            $this->dodeljenUserInfo = $this->selectedUserInfo();
           //dd($this->tiketAkcija[1], $this->tiketRegion != $this->userRegion, $this->tiketRegion, $this->userRegion, $this->validTiket);
        }
    }
    
    private function TiketInfo()
    {
       return Tiket::select('tikets.id as tkid', 'tikets.korisnik_prijavaId', 'tikets.opis', 'tikets.tremina_lokacijalId', 'tikets.created_at', 'tikets.updated_at', 'tikets.br_komentara', 'tikets.opis_kvaraId', 'users.name', 'tiket_status_tips.tks_naziv', 'tiket_prioritet_tips.tp_naziv', 'tiket_prioritet_tips.btn_hover_collor', 'tiket_prioritet_tips.btn_collor', 'tiket_prioritet_tips.tr_bg_collor', 'tiket_opis_kvara_tips.tok_naziv', 'tiket_opis_kvara_tips.id as tokid', 'tikets.korisnik_zatvorio_id')
                    ->leftJoin('tiket_status_tips', 'tikets.tiket_statusId', '=', 'tiket_status_tips.id')
                    ->leftJoin('tiket_prioritet_tips', 'tikets.tiket_prioritetId', '=', 'tiket_prioritet_tips.id')
                    ->leftJoin('users', 'tikets.korisnik_dodeljenId', '=', 'users.id')
                    ->leftJoin('tiket_opis_kvara_tips', 'tiket_opis_kvara_tips.id', '=', 'tikets.opis_kvaraId')
                    ->where('tikets.id', '=', $this->tikid)->first();
    }

    /**
     * podaci o tiketu
     *
     * @return void
     */
    public function read()
    {
        $this->newKoment = '';
        $this->tiket = $this->TiketInfo();
        
        $this->kvarAkcijaId = $this->tiket->tokid;
        $this->brojKomentra = $this->tiket->br_komentara;
        $this->userKreirao = ($this->tiket->korisnik_prijavaId == null) ? '' : User::where('id', '=', $this->tiket->korisnik_prijavaId)->firstOrFail();
        //dd($this->tiket->korisnik_prijavaId);
        return $this->tiket;
    }
    
    /**
     * Lista akcija koje preuzima serviser
     *
     * @return void
     */
    public function kvarAkcije(){
        return TiketOpisAkcijaIndex::select('tka_opis')
                    ->leftJoin('tiket_kvar_akcija_tips', 'tiket_kvar_akcija_tips.id', '=', 'tiket_opis_akcija_indices.tiket_kvar_akcijaId')
                    ->where('tiket_opis_akcija_indices.tiket_opis_kvaraId', '=', $this->kvarAkcijaId)
                    ->orderBy('akcija_order')
                    ->get();
    }

        /**
     * Info o izabranom terminalu 
     *
     * @return void
     */
    public function selectedTerminalInfo(){
        return TerminalLokacija::select('terminal_lokacijas.*', 'terminals.sn', 'terminal_status_tips.ts_naziv', 'lokacijas.l_naziv', 'lokacijas.mesto', 'lokacija_kontakt_osobas.name', 'lokacija_kontakt_osobas.tel', 'regions.r_naziv')
                    ->where('terminalId',  $this->tiket->tremina_lokacijalId)
                    ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                    ->leftJoin('terminal_status_tips', 'terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
                    ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('lokacija_kontakt_osobas', 'lokacijas.id', '=', 'lokacija_kontakt_osobas.lokacijaId')
                    ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
                    -> first();
}

    
    /**
     * history of onre terminal
     *
     * @return void
     */
    public function historyData()
    {
        return TerminalLokacijaHistory::select('terminal_lokacija_histories.*', 'terminal_status_tips.ts_naziv', 'lokacijas.l_naziv', 'lokacijas.mesto')
                    ->where('terminal_lokacija_histories.terminal_lokacijaId', '=',  $this->tiket->tremina_lokacijalId )
                    ->leftJoin('terminal_status_tips', 'terminal_lokacija_histories.terminal_statusId', '=', 'terminal_status_tips.id')
                    ->leftJoin('lokacijas', 'terminal_lokacija_histories.lokacijaId', '=', 'lokacijas.id')
                    ->orderBy('terminal_lokacija_histories.id', 'desc')
                    ->get();
    }

    public function readComments(){
        return TiketKomentar::select('tiket_komentars.*', 'users.name')
                    ->leftJoin('users', 'tiket_komentars.korisnikId', '=', 'users.id' )
                    ->where('tiket_komentars.tiketId', '=', $this->tikid)
                    ->get();
    }


    public function dodeliTiketShowModal(){
       
        $this->noviDodeljenUserId = false;
        $this->searchUserName = '';
        $this->searchUserLokacija = '';
        $this->searchUserPozicija = '';

        $this->modalDodeliTiketVisible = true;
    }
    
     /**
     * Pronadji korisnika kome dodeljujes tiket
     *
     * @return void
     */
    public function searchUser()
    {
        return User::select('users.id', 'users.name', 'lokacijas.l_naziv', 'pozicija_tips.naziv', 'regions.id as rid')
                    ->leftJoin('lokacijas', 'users.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('pozicija_tips', 'users.pozicija_tipId', '=', 'pozicija_tips.id')
                    ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
                    ->when($this->tiketAkcija[3] == "region", function ($rtval){
                        return $rtval->where('regions.id', '=', $this->userRegion);
                    })
                    ->where('name', 'like', '%'.$this->searchUserName.'%')
                    ->where('l_naziv', 'like', '%'.$this->searchUserLokacija.'%')
                    ->where('naziv', 'like', '%'.$this->searchUserPozicija.'%')
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
     * selectedUserInfo
     *
     * @return void
     */
    private function selectedUserInfo()
    {
        return User::select('users.id', 'users.name', 'users.email', 'lokacijas.l_naziv', 'lokacijas.mesto', 'pozicija_tips.naziv')
                    ->leftJoin('lokacijas', 'users.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('pozicija_tips', 'users.pozicija_tipId', '=', 'pozicija_tips.id')
                    ->where('users.id', '=', $this->dodeljenUserId)
                    ->first();
    }

     /**
     * selectedUserInfo
     *
     * @return void
     */
    private function selectedNoviUserInfo()
    {
        return User::select('users.id', 'users.name', 'users.email', 'lokacijas.l_naziv', 'lokacijas.mesto', 'pozicija_tips.naziv')
                    ->leftJoin('lokacijas', 'users.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('pozicija_tips', 'users.pozicija_tipId', '=', 'pozicija_tips.id')
                    ->where('users.id', '=', $this->noviDodeljenUserId)
                    ->first();
    }

     /**
     * selectedUserInfo
     *
     * @return void
     */
    public function zatvorioInfo()
    {
        return User::select('users.id', 'users.name', 'users.email', 'lokacijas.l_naziv', 'lokacijas.mesto', 'pozicija_tips.naziv')
                    ->leftJoin('lokacijas', 'users.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('pozicija_tips', 'users.pozicija_tipId', '=', 'pozicija_tips.id')
                    ->where('users.id', '=', $this->zatvorioId)
                    ->first();
    }
        
    /**
     * changeToServis
     *
     * @return void
     */
    public function changeToServis()
    {
        $this->noviDodeljenUserId = $this->sefServisa()->id;
        $this->changeUser();
    }


    /**
     * Promeni korisnika kome je dodeljen tiket
     *
     * @return void
     */
    public function changeUser()
    {
        $this->dodeljenUserId = $this->noviDodeljenUserId;
        DB::transaction(function(){
            $curent = Tiket::select('*')->where('tikets.id', '=', $this->tikid)->first();
            //insert to history table
            TiketHistory::create(['tiketId' => $curent['id'], 'tremina_lokacijalId' => $curent['tremina_lokacijalId'], 'tiket_statusId' => $curent['tiket_statusId'], 'opis_kvaraId' => $curent['opis_kvaraId'], 'korisnik_prijavaId' => $curent['korisnik_prijavaId'], 'korisnik_dodeljenId' => $curent['korisnik_dodeljenId'],'opis' => $curent['opis'], 'created_at' => $curent['created_at'], 'updated_at' => $curent['updated_at'], 'tiket_prioritetId' => $curent['tiket_prioritetId'], 'br_komentara' => $curent['br_komentara']]);
            //update current
            Tiket::where('tikets.id', $this->tikid)->update(['korisnik_dodeljenId' => $this->dodeljenUserId, 'tiket_prioritetId' => $this->prioritetTiketa, 'tiket_statusId' => 2 ]);
        });

        $this->tiket = $this->TiketInfo();

        
        foreach ($this->mail_to_users() as $mail_to_user) {
            try {
                Mail::to($mail_to_user)->send(new NotyfyMail($this->tiketData('Dodeljen tiket - #')));
            } catch (Exception $e) {
                if (count(Mail::failures()) > 0) {
                    $failures[] = $mail_to_user;
                }
            }
        }

        $this->noviDodeljenUserId = false;
        $this->modalDodeliTiketVisible = false;
        $this->emit('tiketRefresh');
        //$this->mount();
        //$this->redirect('#');
    }

    /**
     * Podaci koji se prikazuju u email poruci
     *
     * @param  mixed $tik
     * @return void
     */
    private function tiketData($sub)
    {
        $this->tiket = $this->TiketInfo();
        $terminal_info = $this->selectedTerminalInfo();
        $dodeljen_ime = ($this->selectedUserInfo($this->dodeljenUserId) != null) ? $this->selectedUserInfo($this->dodeljenUserId)->name : 'Tiket nije dodeljen';
        $kreirao = ($this->userKreirao != '') ? $this->userKreirao->name : 'on line';
        //dd($this->tiket->opis);
        $heding = ($sub == 'Dodeljen tiket - #') ? 'Na servisnom portalu dodeljen vam je tiket #' : $sub;
        $zatvorio = ($sub == 'Zatvoren tiket #') ? ' | Tiket zatvorio: '.auth()->user()->name : '';
        
        $opisKvaraObj = TiketOpisKvaraTip::where('id', '=', $this->tiket->opis_kvaraId)->first();
        $opisKvara = ($opisKvaraObj == null) ? '' : $opisKvaraObj->tok_naziv;
       // Helpers::datumFormat($komentar->created_at)
       $mail_data = [
        'subject'   =>  $sub.$this->tiket->tkid,
        'tiketlink' =>  'https://servis.epos.rs/tiketview?id='.$this->tiket->tkid,
        'hedaing'   =>  $heding.$this->tiket->tkid,
        'row1'      =>  'Prioritet: '.$this->prioritetInfo()->tp_naziv.' | Kreiran: '.Helpers::datumFormat($this->tiket->created_at),
        'row2'      =>  'Otvorio: '.$kreirao,
        'row3'      =>  'Dodeljen: '.$dodeljen_ime. ' '. $zatvorio,
        'row4'      =>  'Kvar: '.$opisKvara,
        'row5'      =>  'Opis: '.$this->tiket->opis,
        'row6'      =>  ' -::-  ---  -::-',
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
            ->where('regions.id', '=', $this->tiketRegion)
            ->first();
    }

    /**
     * Dodeljen/Kreirao Servisa
     *
     * @return void
     */
    private function dodeljenKreirao($id)
    {
        return User::select('users.id', 'users.name', 'users.tel', 'users.email', 'users.pozicija_tipId')
            ->where('users.id', '=', $id)
            ->first();
    }

    /**
     * Posalji Komentar click function
     *
     * @return void
     */
    public function posaljiKomentar($zatvaranje_tiketa = false)
    {   
        //dd($this->mail_to_users());

        if($this->newKoment != ''){
            $this->brojKomentra ++;
            DB::transaction(function(){
                TiketKomentar::create(['tiketId' => $this->tikid, 'komentar'=>$this->newKoment, 'korisnikId' => auth()->user()->id]);
                Tiket::where('id', $this->tikid)->update(['br_komentara' => $this->brojKomentra ]);
            });
            if(!$zatvaranje_tiketa){
                $comentari = $this->readComments();
                foreach ($this->mail_to_users() as $mail_to_user) {
                    try {
                        Mail::to($mail_to_user)->send(new NotyfyMail($this->tiketData('Novi komentar na tiket - #'), $comentari));
                    } catch (Exception $e) {
                        if (count(Mail::failures()) > 0) {
                            $failures[] = $mail_to_user;
                        }
                    }
                }
            }
        }
    }

    private function mail_to_users()
    {
        //dd(gettype($this->userKreirao));
        $retval = [];
        $email_primaci = [
            'kreirao' => (gettype($this->userKreirao) == 'string') ? null : $this->dodeljenKreirao($this->userKreirao->id),
            'dodeljen' => (gettype($this->dodeljenUserId) == 'integer') ? $this->dodeljenKreirao($this->dodeljenUserId) : null,
            'sef' => $this->sefServisa()
        ];

        foreach($email_primaci as $primac){
            if($primac != null){
                if($primac->id != auth()->user()->id){
                    if(!in_array($primac->email, $retval)){
                        if($primac->pozicija_tipId != 2){
                            array_push($retval, $primac->email);
                        }
                    }
                }
            }
        }
        return $retval;
    }
        
    /**
     * zatvoriTiketShowModal
     *
     * @return void
     */
    public function zatvoriTiketShowModal()
    {
        $this->newKoment = '';
        $this->modalZatvoriTiketVisible = true;
    }

    public function closeTiket()
    {
        //dd($this->newKoment);
        $this->posaljiKomentar(true);
        DB::transaction(function(){
            $curent = Tiket::select('*')->where('tikets.id', '=', $this->tikid)->first();
            //insert to history table
            TiketHistory::create(['tiketId' => $curent['id'], 'tremina_lokacijalId' => $curent['tremina_lokacijalId'], 'tiket_statusId' => $curent['tiket_statusId'], 'opis_kvaraId' => $curent['opis_kvaraId'], 'korisnik_prijavaId' => $curent['korisnik_prijavaId'], 'korisnik_dodeljenId' => $curent['korisnik_dodeljenId'],'opis' => $curent['opis'], 'created_at' => $curent['created_at'], 'updated_at' => $curent['updated_at'], 'tiket_prioritetId' => $curent['tiket_prioritetId'], 'br_komentara' => $curent['br_komentara']]);
            //update current
            Tiket::where('tikets.id', $this->tikid)->update([ 'tiket_statusId' => 3, 'korisnik_zatvorio_id'=>auth()->user()->id]);
        });

        $comentari = $this->readComments();
            foreach ($this->mail_to_users() as $mail_to_user) {
                try {
                    Mail::to($mail_to_user)->send(new NotyfyMail($this->tiketData('Zatvoren tiket #'), $comentari));
                } catch (Exception $e) {
                    if (count(Mail::failures()) > 0) {
                        $failures[] = $mail_to_user;
                    }
                }
            }

        $this->modalZatvoriTiketVisible = false;
        $this->emit('tiketRefresh');
    }

    public function updated()
    {
        if($this->modalDodeliTiketVisible){
            if($this->dodeljenUserId){
                $this->dodeljenUserInfo = $this->selectedUserInfo();
            }
            if($this->prioritetTiketa){
                $this->prioritetInfo = $this->prioritetInfo();
            }
            if($this->noviDodeljenUserId){
                $this->noviDodeljenUserInfo = $this->selectedNoviUserInfo();
            }
        }
    }

    public function render()
    {
        if($this->validTiket){
            return view('livewire.tiketview', ['tiket' => $this->read(), 'akcije'=>$this->kvarAkcije(), 'terminal' => $this->selectedTerminalInfo(), 'historyData' => $this->historyData(), 'komentari' => $this->readComments()]);
        }else{
            return view('livewire.errortiket', []);
        }
    }
}
