<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use App\Http\SmsResponse;

class Prijava extends Component
{
    
   // public $LocSMS;

    public function mount()
    {
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

    public function sendSMS()
    {
        
        //dd($this->LocSMS);
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

    public function render()
    {
        return view('livewire.prijava');
    }
}
