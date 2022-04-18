<?php

namespace App\Http\Livewire;

use Auth;
use App\Models\Lokacija;
use App\Models\User;
use App\Models\TerminalLokacija;
use App\Models\TerminalLokacijaHistory;
//use App\Models\TerminalStatusTip;
//use App\Models\Tiket;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    //pretraga
    public $searchName;
    public $searchMesto;
    public $searchTip = 0;
    public $searchRegion = 0;

    //order
    public $orderBy;

    //delete check
    public $odabranaLokacija;
    public $deletePosible;
    public $delName;
    public $brTerminala;

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

    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        return [   
            'l_naziv' => 'required',  
            'regionId' => 'required',
            'lokacija_tipId' => 'required',
            'latitude' => ['regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', 'nullable'],             
            'longitude' => ['regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', 'nullable']       
        ];
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
        //return Lokacija::paginate(5);
        return Lokacija::select('lokacijas.*', 'lokacija_tips.lt_naziv', 'regions.r_naziv', 'terminal_lokacijas.lokacijaId as ima_terminala', 'users.lokacijaId as ima_user')
        ->leftJoin('regions', 'regions.id', '=', 'lokacijas.regionId')
        ->leftJoin('lokacija_tips', 'lokacijas.lokacija_tipId', '=', 'lokacija_tips.id')
        ->leftJoin('terminal_lokacijas', 'lokacijas.id', '=', 'terminal_lokacijas.lokacijaId')
        ->leftJoin('users', 'users.lokacijaId', '=', 'lokacijas.id')
        ->where('lokacijas.l_naziv', 'like', '%'.$this->searchName.'%')
        ->where('lokacijas.mesto', 'like', '%'.$this->searchMesto.'%')
        ->where('lokacijas.regionId', ($this->searchRegion > 0) ? '=' : '<>', $this->searchRegion)
        ->where('lokacijas.lokacija_tipId', ($this->searchTip > 0) ? '=' : '<>', $this->searchTip)
        ->groupBy('id')
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
    }

    /**
     * Shows the create New lokacija modal
     *
     * @return void
     */
    public function createShowModal()
    {
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

        $this->regionId = $data->regionId;
        $this->lokacija_tipId = $data->lokacija_tipId;
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
            'l_naziv'   => $this->l_naziv,
            'mesto'     => $this->mesto,
            'adresa'   => $this->adresa,
            'latitude'   => ($this->latitude == '') ? NULL : $this->latitude,
            'longitude'   =>($this->longitude == '') ? NULL : $this->longitude,
            'regionId'   => $this->regionId,
            'lokacija_tipId'   => $this->lokacija_tipId,    
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
        Lokacija::create($this->modelData());
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
        $this->modalFormVisible = false;
    }

    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
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

        $ldat = Lokacija::where('id', $this->modelId)->first();
        $this->delName = $ldat['l_naziv'].', '.$ldat['mesto'];
        //dd($ldat);
        $this->modalConfirmDeleteVisible = true;
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
    }    

    public function render()
    {
        return view('livewire.lokacijes', [
            'data' => $this->read(),
        ]);
    }
    
    /**
     * Creates Gmap link
     *
     * @param  mixed $lat
     * @param  mixed $log
     * @return void
     */
    public static function createGmapLink($lat, $log)
    {
        return 'https://www.google.com/maps/search/?api=1&query='.$lat.','.$log;
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
        $this->modelId = $id;
        $this->odabranaLokacija = $this->lokacijaInfo();
        
        /* $this->errAddMsg = '';
        $this->t_status = 0;
         $this->addingType = 'location'; */
        
        //dd($this->odabranaLokacija);
       
        
        $this->modalAddTerminalVisible = true;
       /*  $this->selsectedTerminals = [];
        $this->searchSN = '';
        $this->p_lokacija_tipId = 0;
        $this->p_lokacijaId = 0; */

        
    }
    
    private function lokacijaInfo()
    {
        return Lokacija::leftJoin('lokacija_tips', 'lokacijas.lokacija_tipId', '=', 'lokacija_tips.id')
            ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
            ->where('lokacijas.id', '=', $this->modelId)
            ->firstOrFail();
    }

    private function lokacjaSaKojeUzimaInfo()
    {
        return Lokacija::leftJoin('lokacija_tips', 'lokacijas.lokacija_tipId', '=', 'lokacija_tips.id')
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
        //ima li izabranih terminala
        if($this->t_status){
            if(count($this->selsectedTerminals)){
                $this->errAddMsg = '';
                foreach($this->selsectedTerminals as $tid){
                    DB::transaction(function() use($tid){
                        //terminal
                       $cuurent = TerminalLokacija::where('terminalId', $tid) -> first();
                        //insert to history table
                         TerminalLokacijaHistory::create(['terminal_lokacijaId' => $cuurent['id'], 'terminalId' => $cuurent['terminalId'], 'lokacijaId' => $cuurent['lokacijaId'], 'terminal_statusId' => $cuurent['terminal_statusId'], 'korisnikId' => $cuurent['korisnikId'], 'korisnikIme' => $cuurent['korisnikIme'], 'created_at' => $cuurent['created_at'], 'updated_at' => $cuurent['updated_at']]);
                        //update current
                        TerminalLokacija::where('terminalId', $tid)->update(['lokacijaId'=> $this->modelId, 'terminal_statusId'=> $this->t_status, 'korisnikId'=>auth()->user()->id, 'korisnikIme'=>auth()->user()->name ]);
                    });
                    $this->modalAddTerminalVisible = false;
                }
            }else{
                $this->errAddMsg = 'Niste izabrali terminal';
            }
        }else{
            $this->errAddMsg = 'Niste izabrali status terminal';
        }
       
       // dd($this->t_status);
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

        if($this->modalAddTerminalVisible){
            $this->odabranaLokacija = $this->lokacijaInfo();
        }

        if($this->modalAddTerminalVisible && $this->p_lokacijaId){
            $this->lokacijaSaKojeUzima = $this->lokacjaSaKojeUzimaInfo();
        }
        
    }
}