<?php

namespace App\Http\Livewire;

use App\Models\Lokacija;
use App\Models\User;
//use App\Models\Terminal_lokacija;
//use App\Models\Tiket;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Config;


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
    public $searchTip;
    public $searchRegion;

    //order
    public $orderBy;

    //delete check
    public $deletePosible;
    public $delName;

    /**
     * Put your custom public properties here!
     */

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
        return Lokacija::leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
        ->leftJoin('lokacija_tips', 'lokacijas.lokacija_tipId', '=', 'lokacija_tips.id')
        ->select('lokacijas.*', 'lokacija_tips.lt_naziv', 'regions.r_naziv')
        ->where('l_naziv', 'like', '%'.$this->searchName.'%')
        ->where('mesto', 'like', '%'.$this->searchMesto.'%')
        ->where('regionId', ($this->searchRegion > 0) ? '=' : '<>', $this->searchRegion)
        ->where('lokacija_tipId', ($this->searchTip > 0) ? '=' : '<>', $this->searchTip)
        ->orderBy($order)
        ->paginate(Config::get('global.paginate'));
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
        $retval['users'] = [];
        foreach(User::where('lokacijaId', $id)->get() as $row){
            array_push($retval['users'], $row['name']);
        };
        //MORA DA SE UPDATUJE I FUNKCIJA deleteShowModal($id)
        //dd($retval);
        return $retval;
    }
}