<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use App\Http\SmsResponse;

use App\Models\TerminalLokacija;

class Prijava extends Component
{

    public $serialNum;
    public $terminal;
    public $searchClick;
    public $opisKvaraList;
    public $opisKvataTxt;
   // public $LocSMS;

    public function mount()
    {
        $this->searchClick = false;
        $data = [   
            'ANI'=>'381637265275', 
            'DNIS'=>'Epos Servis', 
            'poruka'=>'Verifikacioni kod je: 123 456', 
            'pwd'=>'ZetaSysteM0513', 
            'guid'=>'987654',
            'tip'=>'BULK'
    ];
        //$this->LocSMS = "HOHI"; //$this->sendSMS();
        //dd($this->LocSMS);
        //$this->LocSMS = Http::get('212.62.32.60/BulkWS/SagaBgd.SeP.SMS.BulkStruct.asmx/BulkNizSeparator?ANI=381637265275&DNIS=Epos servis&poruka=Poruka 3&pwd=ZetaSysteM0513&guid=123456&tip=BULK');
        //$resp = Http::asForm()->post('212.62.32.60/BulkWS/SagaBgd.SeP.SMS.BulkStruct.asmx/BulkNizSeparator', $data);
        //print_r($this->LocSMS);
        //print_r($resp->transferStats->response);
        //dd($resp->transferStats);
    }

    public function SearchTerminal()
    {
        $this->terminal = $this->selectedTerminalInfo();
        $this->searchClick = true;
        //dd($this->terminal);
        $this->serialNum;
    }
    
    public function sendSMS()
    {
        $this->koko = 'Upadd';
       
        /* $path = '212.62.32.60/BulkWS/SagaBgd.SeP.SMS.BulkStruct.asmx/BulkNizSeparator';
        $method = 'POST';
        //$data = 'ANI=381637265275&DNIS=Epos Servis&poruka=Verifikacioni kod je: 123 456&pwd=ZetaSysteM0513&guid=987654&tip=BULK';
        $data = [   'ANI'=>'381637265275', 
                    'DNIS'=>'Epos Servis', 
                    'poruka'=>'Verifikacioni kod je: 123 456', 
                    'pwd'=>'ZetaSysteM0513', 
                    'guid'=>'987654',
                    'tip'=>'BULK'
                ];
        $request = Request::create( $path, $method, $data );
        return $response = Route::dispatch( $request ); */
        //$response = Http::get('212.62.32.60/BulkWS/SagaBgd.SeP.SMS.BulkStruct.asmx/BulkNizSeparator?ANI=381637265275&DNIS=Epos servis&poruka=Poruka 3&pwd=ZetaSysteM0513&guid=123456&tip=BULK');
        $this->LocSMS = 'U funkciji';//$response;
    }

    /**
     * Info o izabranom terminalu 
     *
     * @return void
     */
    public function selectedTerminalInfo(){
        return TerminalLokacija::select('terminal_lokacijas.*', 'terminals.terminal_tipId as tid', 'terminals.sn', 'terminal_status_tips.ts_naziv', 'lokacijas.l_naziv', 'lokacijas.mesto', 'lokacija_kontakt_osobas.name', 'lokacija_kontakt_osobas.tel', 'regions.r_naziv')
                    ->where('terminals.sn',  $this->serialNum)
                    ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                    ->leftJoin('terminal_status_tips', 'terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
                    ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('lokacija_kontakt_osobas', 'lokacijas.id', '=', 'lokacija_kontakt_osobas.lokacijaId')
                    ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
                    ->first();
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
