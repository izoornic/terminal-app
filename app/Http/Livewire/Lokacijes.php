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

    //pretraga
    public $searchName;
    public $searchMesto;
    public $searchTip = 0;
    public $searchRegion = 0;

    //order
    public $orderBy;

    //delete check
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
    public $t_status;

    public $errAddMsg = '';

    public function addTerminlaListener()
    {
        dd($this->modalAddTerminalVisible);
    }

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
        return Lokacija::leftJoin('regions', 'regions.id', '=', 'lokacijas.regionId')
        ->leftJoin('lokacija_tips', 'lokacijas.lokacija_tipId', '=', 'lokacija_tips.id')
        ->leftJoin('terminal_lokacijas', 'lokacijas.id', '=', 'terminal_lokacijas.lokacijaId')
        ->leftJoin('users', 'users.lokacijaId', '=', 'lokacijas.id')
        ->select('lokacijas.*', 'lokacijas.regionId', 'lokacija_tips.lt_naziv', 'regions.r_naziv', 'regions.id as rid', 'terminal_lokacijas.lokacijaId as ima_terminala', 'users.lokacijaId as ima_user')
        ->groupBy('lokacijas.id')
        ->orderBy($order)
        ->paginate(Config::get('global.paginate'), ['*'], 'lokacije');
    }

    /**
     * Shows the create New lokacija modal
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->reset();
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
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
        $this->modelId = $id;
        $this->loadModel();
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
            'latitude'   => $this->latitude,
            'longitude'   => $this->longitude,
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
        $this->reset();
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
        //dd($this->locationUsers($id));
        $this->modelId = $id;

        $ldat = Lokacija::find($this->modelId)->first();
        $this->delName = $ldat['l_naziv'].', '.$ldat['mesto'];

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
    public static function locationUsers($id)
    {
        $retval = [];
        foreach(User::where('lokacijaId', $id)->get() as $row){
            $retval['users'] = [];
            array_push($retval['users'], $row['name']);
        };
        //MORA DA SE UPDATUJE I FUNKCIJA deleteShowModal($id)
        //dd($retval);
        if(TerminalLokacija::brojTerminalaNalokaciji($id)){
            $retval['trminal'] = [];
            array_push($retval['trminal'], TerminalLokacija::brojTerminalaNalokaciji($id));
        }  
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
        $this->errAddMsg = '';
        $this->t_status = 0;

        $ldat = Lokacija::find($this->modelId);
        $this->delName = $ldat['l_naziv'].', '.$ldat['mesto'];

        $this->addingType = 'location';
        $this->modalAddTerminalVisible = true;
        //dd($this->addingType);
        $this->selsectedTerminals = [];
        $this->searchSN = '';
        $this->p_lokacija_tipId = 0;
        $this->p_lokacijaId = 0;


    }
    
    /**
     * terminaliZaLokaciju
     *
     * @param  mixed $id
     * @param  mixed $sn
     * @param  mixed $bk
     * @return void
     */
    public static function terminaliZaLokaciju($id, $sn = '', $bk = '')
    { 
        return TerminalLokacija::leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                                ->leftJoin('terminal_status_tips', 'terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
                                ->select('terminal_lokacijas.*', 'terminals.sn', 'terminals.broj_kutije', 'terminal_status_tips.ts_naziv', 'terminals.id as tid')
                                ->where('terminal_lokacijas.lokacijaId', $id)
                                ->where('terminals.sn', 'like', '%'.$sn.'%')
                                ->where('terminals.broj_kutije', 'like', '%'.$bk.'%')
                                ->paginate(Config::get('global.paginate'), ['*'], 'terminaliLokacija');
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
                         TerminalLokacijaHistory::create(['terminal_lokacijaId' => $cuurent['id'], 'terminalId' => $cuurent['terminalId'], 'lokacijaId' => $cuurent['lokacijaId'], 'terminal_statusId' => $cuurent['terminal_statusId'], 'korisnikId' => $cuurent['korisnikId'], 'korisnikIme' => $cuurent['korisnikIme']]);
                        //update current
                        TerminalLokacija::where('terminalId', $tid)->update(['lokacijaId'=> $this->modelId, 'terminal_statusId'=> $this->t_status, 'korisnikId'=>auth()->user()->id, 'korisnikIme'=>auth()->user()->name ]);
                    });

                }
            }else{
                $this->errAddMsg = 'Niste izabrali terminal';
            }
        }else{
            $this->errAddMsg = 'Niste izabrali status terminal';
        }
        $this->modalAddTerminalVisible = false;
       // dd($this->t_status);
    }
}