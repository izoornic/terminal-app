<?php

namespace App\Http\Livewire;

use App\Http\Helpers;
use App\Models\LicencaMesec;
use App\Models\LicencaDistributerMesec;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Config;

class Zaduzenje extends Component
{
    use WithPagination;
    
    //Create Update
    public $modalFormVisible;
    public $modelId;
    public $mesec;
    public $mesecZaduzenjaDisplay;
    public $isError;

    public $mesecModel;

    //Delete
    public $modalConfirmDeleteVisible;


    /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->mesec = Helpers::firstDayOfMounth(Helpers::datumKalendarNow());
    }

    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        return [  
            'mesec' => ['required', 'date_format:"Y-m-d"']       
        ];
    }

    
    /**
     * The read function
     *
     * @return colection
     * 
     */
    public function read()
    {
        return LicencaMesec::selectRaw('licenca_mesecs.*, COUNT(licenca_distributer_mesecs.distributerId) as distCount, sum(licenca_distributer_mesecs.sum_zaduzeno) as sumZaduzeno')
            ->leftJoin('licenca_distributer_mesecs', 'licenca_distributer_mesecs.mesecId', '=', 'licenca_mesecs.id' )
            ->groupBy('licenca_distributer_mesecs.mesecId')
            ->orderBy('licenca_mesecs.mesec_datum', 'DESC')
            ->paginate(Config::get('global.paginate'));
    }

    /**
     * Loads the model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        $data = LicencaMesec::find($this->modelId);
        // Assign the variables here
        $this->mesec = $data->mesec_datum;
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
            'mesec_datum'  => $this->mesec,
            'mesec_naziv'  => Helpers::nameOfTheMounth($this->mesec),
            'm_broj_dana' => Helpers::noOfDaysInMounth($this->mesec)
        ];
    }

    /**
     * Shows the create modal
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->isError = false;
        $this->mesec = Helpers::firstDayOfMounth(Helpers::datumKalendarNow());
        $this->resetValidation();
        $this->mesecGodinaDisplay();
        $this->modalFormVisible = true;
    }

    /**
     * The create function.
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        //check date
        if(LicencaMesec::where('mesec_datum', '=', $this->mesec)->first()){
            $this->isError = true;
        }else{
            LicencaMesec::create($this->modelData());
            $this->modalFormVisible = false;
        }  
    }

    public function mesecGodinaDisplay()
    {
        $this->mesecZaduzenjaDisplay = Helpers::nameOfTheMounth($this->mesec). ', '. Helpers::yearNumber($this->mesec).'.';
    }

    /**
     * Shows the delete confirmation modal.
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id)
    {
        $this->isError = false;
        $this->modelId = $id;
        $this->mesecModel = LicencaMesec::where('id', '=', $this->modelId)->first();
        $this->modalConfirmDeleteVisible = true;
    }    

    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        if(LicencaDistributerMesec::where('mesecId', '=', $this->modelId)->first()){
            $this->isError = true;
            return;
        }
        
        LicencaMesec::destroy($this->modelId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }

    /**
     * updated
     *
     * @return void
     */
    public function updated()
    {
        if($this->modalFormVisible){
            $this->mesec = Helpers::firstDayOfMounth($this->mesec);
            $this->mesecGodinaDisplay();
        }
    }
    public function render()
    {
        return view('livewire.zaduzenje', [
            'data' => $this->read(),
        ]);
    }
}