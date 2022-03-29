<?php

namespace App\Http\Livewire;

use App\Models\Lokacija;
use Livewire\Component;
use Livewire\WithPagination;

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
        //return Lokacija::paginate(5);
        return Lokacija::leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
        ->leftJoin('lokacija_tips', 'lokacijas.lokacija_tipId', '=', 'lokacija_tips.id')
        ->select('lokacijas.*', 'lokacija_tips.lt_naziv', 'regions.r_naziv')
        ->paginate(5);
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
        $this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
    }    

    public function render()
    {
        return view('livewire.lokacijes', [
            'data' => $this->read(),
        ]);
    }

    public static function createGmapLink($lat, $log)
    {
        return 'https://www.google.com/maps/search/?api=1&query='.$lat.','.$log;
    }
}