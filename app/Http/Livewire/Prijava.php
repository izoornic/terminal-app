<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

use App\Models\SmsLog;

use App\Http\SmsResponse;

use App\Models\TerminalLokacija;
use Validator;

class Prijava extends Component
{

    public $serialNum;
    public $terminal;
    public $searchClick;
    public $opisKvaraList;
    public $opisKvataTxt;
    public $telefon;
    public $prijavaIme;
    public $verifikacioniKod;
   // public $LocSMS;

    public function mount()
    {
        $this->searchClick = false;
        //$this->serialNum = 'A26-12RB-1K13684';
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
        $this->terminal = $this->selectedTerminalInfo();
        return [  
            'opisKvaraList' => 'required',
            'telefon' => ['required', 'digits_between:8,11'],
            'prijavaIme' => 'required'
        ];
    }
    
    public function SearchTerminal()
    {
        $this->terminal = $this->selectedTerminalInfo();
        $this->searchClick = true;
        //dd($this->terminal);
        $this->telefon = '';
        $this->prijavaIme = '';

    }
    
    public function sendSMS()
    {
        if(substr($this->telefon, 0, 1) == '0') $this->telefon = ltrim($this->telefon,"0");
        $this->validate();
        //dd($this->telefon);
        $this->verifikacioniKod = $this->createVerificationCode();
        //insert data to DB and then send SMS

        $path = '212.62.32.60/BulkWS/SagaBgd.SeP.SMS.BulkStruct.asmx/BulkNizSeparator';
        $method = 'POST';
        $data = [   'ANI'=>'381'.$this->telefon, 
                    'DNIS'=>'Zeta System EPOS', 
                    'poruka'=>'Verifikacioni kod je: '.$this->verifikacioniKod, 
                    'pwd'=>'ZetaSysteM0513', 
                    'guid'=>$this->selectedTerminalInfo()->id,
                    'tip'=>'BULK'
                ];
        //$resp = Http::asForm()->post($path, $data);
        //$request = Request::create( $path, $method, $data );
        //$response = Route::dispatch( $request );
        //dd($data);
    }

    /**
     * Info o izabranom terminalu 
     *
     * @return void
     */
    public function selectedTerminalInfo(){
        return TerminalLokacija::select('terminal_lokacijas.*', 'terminals.sn', 'terminals.terminal_tipId as tid', 'terminal_status_tips.ts_naziv', 'lokacijas.l_naziv', 'lokacijas.mesto', 'lokacija_kontakt_osobas.name', 'lokacija_kontakt_osobas.tel', 'regions.r_naziv')
                    ->where('terminals.sn',  $this->serialNum)
                    ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                    ->leftJoin('terminal_status_tips', 'terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
                    ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('lokacija_kontakt_osobas', 'lokacijas.id', '=', 'lokacija_kontakt_osobas.lokacijaId')
                    ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
                    ->first();
    }

    private function createVerificationCode()
    {
        return mt_rand(100000,999999);
    }

    public function updated()
    {
        $this->terminal = $this->selectedTerminalInfo();
    }

    public function render()
    {
        return view('livewire.prijava');
    }
}
