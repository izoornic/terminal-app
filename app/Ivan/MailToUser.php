<?php
namespace App\Ivan;

use Auth;

use App\Models\Region;
use App\Models\Tiket;
use App\Models\User;
use App\Models\Lokacija;
use App\Models\TiketOpisKvaraTip;
use App\Models\TiketPrioritetTip;

use App\Ivan\SelectedTerminalInfo;

use App\Http\Helpers;

use Mail;
use App\Mail\NotyfyMail;

class MailToUser 
{
    public $tiketId;
    public $tiket;
    public $tiketRegion;
    public $userLogovan;

    public $email_primaoci;

    function __construct($tid) {
        $this->tiketId = $tid;
        $this->tiketRegion = $this->tiketRegion($this->tiketId);
            
        $this->tiket = Tiket::select('*')
            ->where('tikets.id', '=', $this->tiketId)
            ->first();

        $this->userLogovan = (auth()->user() == null) ? 0 : 1;

       $this->email_primaoci = $this->setEmailPrimaoce();
    }
    
    public function sendEmails($subject, $comentari = null)
    {
        foreach ($this->email_primaoci as $mail_address) {
            try {
                Mail::to($mail_address)->send(new NotyfyMail($this->tiketData($subject), $comentari));
            } catch (Exception $e) {
                if (count(Mail::failures()) > 0) {
                    $failures[] = $mail_address;
                }
            }
        }
        //dd($this->email_primaoci);
    }

    /**
     * setEmailPrimaoce
     *
     * @return void
     */
    private function setEmailPrimaoce()
    {
        $retval = [];
        $email_primaci = [
            'kreirao' => ($this->tiket->korisnik_prijavaId == null) ? null : $this->userEmail($this->tiket->korisnik_prijavaId),
            'dodeljen' => ($this->tiket->korisnik_dodeljenId == null) ? null : $this->userEmail($this->tiket->korisnik_dodeljenId),
            'sef' => $this->sefServisa()
        ];

        foreach($email_primaci as $primac){
            if($primac != null){
                if($this->userLogovan){
                    //user kreiran tiket ili komentar
                    if($primac->id != auth()->user()->id){
                        if(!in_array($primac->email, $retval)){
                            if($primac->pozicija_tipId != 2){
                                array_push($retval, $primac->email);
                            }
                        }
                    }   
                }else{
                    //online tiket
                    //zavisi od tipa kvara tiket je vec otvoren dakle gledam samo id dodeljenog
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
     * userEmail
     *
     * @return void
     */
    private function userEmail($id)
    {
        return User::select('id','email','pozicija_tipId')
                    ->where('id', '=', $id)
                    ->first();
    }
    
    /**
     * tiketRegion
     *
     * @param  mixed $tikid
     * @return void
     */
    private function tiketRegion($tikid)
    {
        return Region::select('regions.id as rid')
                    ->join('lokacijas', 'lokacijas.regionId', '=', 'regions.id')
                    ->join('terminal_lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                    ->join('tikets', 'tikets.tremina_lokacijalId', '=', 'terminal_lokacijas.id')
                    ->where('tikets.id', '=', $tikid)
                    ->first()->rid;
    }

    /**
     * id Sefa Servisa otvorenog tiketa
     *
     * @return void
     */
    private function sefServisa()
    {
        return User::select('users.id', 'users.name', 'users.tel', 'users.email', 'users.pozicija_tipId')
                    ->join('lokacijas', 'lokacijas.id', '=', 'users.lokacijaId')
                    ->join('regions', 'regions.id', '=', 'lokacijas.regionId')
                    ->where('users.pozicija_tipId', '=', 3)
                    ->where('regions.id', '=', $this->tiketRegion)
                    ->first();
    }
        
    /**
     * userInfo
     *
     * @return void
     */
    private function userInfo($id)
    {
        return User::select('users.id', 'users.name', 'users.tel', 'users.email', 'users.pozicija_tipId')
                        ->where('users.id', '=', $id)
                        ->first();
    }

    /**
     * Podaci koji se prikazuju u email poruci
     *
     * @param  mixed $tik
     * @return void
     */
    private function tiketData($sub)
    {
        $terminal_info = SelectedTerminalInfo::selectedTerminalInfo($this->tiket->tremina_lokacijalId);
        //$this->tikedd(t);
        $dodeljen_ime = ($this->tiket->korisnik_dodeljenId != null) ? $this->userInfo($this->tiket->korisnik_dodeljenId)->name : 'Tiket nije dodeljen';
        $kreirao = ($this->tiket->korisnik_prijavaId != null) ? $this->userInfo($this->tiket->korisnik_prijavaId)->name : 'on line';
        
        $subject = '';
        $heding = '';
        $zatvorio = '';

        switch($sub){
            case 'novi':
                $subject = 'Novi tiket #';
                $heding = 'Na servisnom portalu je otvoren novi tiket #';
            break;
            case 'komentar':
                $subject = 'Novi komentar na tiket - #';
                $heding = 'Novi komentar na tiket - #';
            break;
            case 'dodeljen':
                $subject = 'Dodeljen tiket #';
                $heding = 'Na servisnom portalu dodeljen vam je tiket #';
            break;
            case 'zatvoren':
                $subject = 'Zatvoren tiket #';
                $heding = 'Na servisnom portalu zatvoren je tiket #';
                $zatvorio = ' | Tiket zatvorio: '.auth()->user()->name;
            break;
        }
        
        $opisKvaraObj = TiketOpisKvaraTip::where('id', '=', $this->tiket->opis_kvaraId)->first();
        $opisKvara = ($opisKvaraObj == null) ? '' : $opisKvaraObj->tok_naziv;
       // Helpers::datumFormat($komentar->created_at)
       $mail_data = [
        'subject'   =>  $subject.$this->tiket->id,
        'tiketlink' =>  'https://servis.epos.rs/tiketview?id='.$this->tiket->id,
        'hedaing'   =>  $heding.$this->tiket->id,
        'row1'      =>  'Prioritet: '.TiketPrioritetTip::where('id', '=', $this->tiket->tiket_prioritetId)->first()->tp_naziv.' | Kreiran: '.Helpers::datumFormat($this->tiket->created_at),
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
     * sef Servisa za izabrani Terminal 
     *
     * @param  mixed $terminalLokacijaId
     * @return void
     */
    public static function sefServisaTerminal($terminalLokacijaId)
    {
        //region id
        $regid = Lokacija::select('regionId')
                    ->join('terminal_lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                    ->where('terminal_lokacijas.id', '=', $terminalLokacijaId)
                    ->first()
                    ->regionId;
        //ovde mora dodatna logika
        // da se proveri da li sef servisa radi
    
        return User::select('users.id', 'users.name', 'users.tel', 'users.email', 'users.pozicija_tipId')
        ->join('lokacijas', 'lokacijas.id', '=', 'users.lokacijaId')
        ->where('users.pozicija_tipId', '=', 3)
        ->where('lokacijas.regionId', '=',  $regid)
        ->first();
    }

}