<?php

namespace App\Http\Livewire;

use App\Http\Helpers;
use App\Models\LicencaMesec;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Config;

class Zaduzenje extends Component
{
    use WithPagination;
    
    //Create Update
    public $modalFormVisible;
    public $modelId;
    public $isUpdate;
    public $mesec;
    public $mesecZaduzenjaDisplay;
    public $isError;

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
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return LicencaMesec::orderBy('mesec_datum', 'DESC')
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
        $this->isUpdate = false;
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
     * Shows the form modal
     * in update mode.
     *
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->isUpdate = true;
        $this->modalFormVisible = true;
        $this->modelId = $id;
        $this->loadModel();
    }

    /**
     * The update function
     *
     * @return void
     */
    public function update()
    {
        $this->validate();
        LicencaMesec::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible = false;
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

    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
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