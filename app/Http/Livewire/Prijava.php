<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\DB;

use App\Models\SmsLog;
use App\Models\Tiket;
use App\Models\TerminalLokacija;
use App\Models\TiketOpisKvaraTip;

use Validator;

use App\Ivan\MailToUser;
use App\Ivan\SelectedTerminalInfo;

use Auth;

class Prijava extends Component
{

    public $serialNum;
    public $terminal;
    public $searchClick;
    public $opisKvaraList;
    public $opisKvataTxt;
    public $telefon;
    public $telefon_display;
    public $prijavaIme;
    public $verifikacioniKod;

    public $smsSended;
    private $smsSendData;

    public $verifikacioniKodInput;
    public $verifikacijaUspesna;
    public $verifikacijaSubmited;

    public $sms_log_id;
    public $tiket_verifikovan;
   // public $LocSMS;

   private $mailToUserObj;

    public function mount()
    {
        $this->searchClick = false;
        $this->opisKvataTxt = '';
        $this->serialNum = '';
        $this->tiket_verifikovan = false;
    }
    
    /**
     * rules
     *
     * @return void
     */
    public function rules()
    {
        //kakva glupost!!! Ako ne updatujem ovde ne vidi podatke o terminalu....
        // 'telefon' => ['required', 'digits_between:8,11'],
        // 'telefon' => ['phone:RS,mobile', 'required'],
        $this->terminal = SelectedTerminalInfo::selectedTerminalInfoSerialNumber($this->serialNum);
        return [  
            'opisKvaraList' => 'required',
            'telefon' => ['required', 'digits_between:8,11'],
            'prijavaIme' => 'required'
        ];
    }
    
    public function SearchTerminal()
    {
        $this->terminal = SelectedTerminalInfo::selectedTerminalInfoSerialNumber($this->serialNum);
        $this->searchClick = true;
        //dd($this->terminal);
        $this->telefon = '';
        $this->telefon_display = '';
        $this->prijavaIme = '';
        $this->smsSended = false;
    }
    
    public function sendSMS()
    {
        if(substr($this->telefon, 0, 1) == '0') $this->telefon = ltrim($this->telefon,"0");
        $this->validate();
        $this->verifikacioniKod = $this->createVerificationCode();

        $this->telefon_display = substr($this->telefon,0,2).'.....'.substr($this->telefon, 7);
        //insert data to DB and then send SMS

        $path = '212.62.32.60/BulkWS/SagaBgd.SeP.SMS.BulkStruct.asmx/BulkNizSeparator';
        $method = 'POST';
        $data = [   'ANI'=>'381'.$this->telefon, 
                    'DNIS'=>'Zeta System EPOS', 
                    'poruka'=>'Verifikacioni kod je: '.$this->verifikacioniKod, 
                    'pwd'=>'ZetaSysteM0513', 
                    'guid'=>SelectedTerminalInfo::selectedTerminalInfoSerialNumber($this->serialNum)->id,
                    'tip'=>'BULK'
                ];
        
        $this->smsSendData = $this->postDataSmsSevice($path, $data);
        $this->smsSended = true;

        //insert data to DB
       $sms_log = SmsLog::create([
            'terminal_lokacijaId' => SelectedTerminalInfo::selectedTerminalInfoSerialNumber($this->serialNum)->id,
            'prijava_tel' => '381'.$this->telefon,
            'prijava_ime' => $this->prijavaIme,
            'prijava_ip' => $_SERVER['REMOTE_ADDR'],
            'response_time' => $this->smsSendData['response_time'],
            'response_ok' => $this->smsSendData['ok'],
            'response_code' => $this->smsSendData['code']
        ]);
        $this->sms_log_id = $sms_log->id;
    }

    private function postDataSmsSevice($path, $data)
    {
        try {
            $startResponseTime = microtime(true);
            $response = Http::asForm()->post($path, $data);
            $stopResponseTime = microtime(true);
        
            $responseTime = ($stopResponseTime - $startResponseTime) * 1000;
        
            if($response->successful()){
                return [
                    'response_time' => round($responseTime),
                    'code' => $response->getStatusCode(),
                    'ok' => $response->ok(),
                    'json' => $response->json(),
                    'headers' => $response->headers()
                ];
        
            }else{
        
                return [
                    'response_time' => round($responseTime),
                    'code' => $response->getStatusCode(),
                    'ok' => false,
                    'json' => null,
                    'headers' => null
                ];
        
            }
        
        } catch (\Exception $e) {
            return [
                'response_time' => 0,
                'code' => 0,
                'ok' => false,
                'json' => null,
                'headers' => null,
                'message' => $e->getMessage(), //get exception message
            ];
        }
    }

    private function createVerificationCode()
    {
        return mt_rand(100000,999999);
    }

    public function checkVerificationCode()
    {
        $this->terminal =  SelectedTerminalInfo::selectedTerminalInfoSerialNumber($this->serialNum);
        $this->verifikacijaUspesna = ($this->verifikacioniKodInput == $this->verifikacioniKod);
        $this->verifikacijaSubmited = true;
        //update database...
        
        if($this->verifikacijaUspesna){
            //da li se tiket dodeljuje ili ide na call centar
            $tok_dodela_nadleznosti = TiketOpisKvaraTip::select('tok_dodela_nadleznostiId')
                                                        ->where('id', '=', $this->opisKvaraList)
                                                        ->first()
                                                        ->tok_dodela_nadleznostiId;
            $dodeljen = 0;
            if($tok_dodela_nadleznosti == 1){
                //tiket se dodeljuje sefu servisa
                $dodeljen = MailToUser::sefServisaTerminal( $this->terminal->id)->id;
                //dd( $dodeljen);
            }

            DB::transaction(function()use($dodeljen){
                $tikRow = [
                    'tremina_lokacijalId' => $this->terminal->id,
                    'tiket_statusId' => 1,
                    'opis_kvaraId' => $this->opisKvaraList,
                    'opis' => $this->opisKvataTxt,
                    'tiket_prioritetId' => 4,
                ];

                if ($dodeljen) $tikRow['korisnik_dodeljenId'] = $dodeljen;

                $tiket = Tiket::create($tikRow);
                
                SmsLog::find($this->sms_log_id)->update(['tiketId' => $tiket->id ]);
                if($dodeljen){
                    //mora ovde da bi se videla promenjiva $tiket
                    $this->mailToUserObj = new MailToUser($tiket->id);
                    $this->mailToUserObj->sendEmails('novi');
                }
            });
            $this->tiket_verifikovan = true;
            //posalji mailove
            //$this->mailToUserObj->
        }

    }

    public function updated()
    {
        $this->terminal = SelectedTerminalInfo::selectedTerminalInfoSerialNumber($this->serialNum);
    }

    public function render()
    {
        return view('livewire.prijava');
    }
}
