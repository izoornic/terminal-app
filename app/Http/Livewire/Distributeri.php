<?php

namespace App\Http\Livewire;

use App\Models\LicencaDistributerTip;
use App\Models\LicencaDistributerCena;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use Livewire\WithPagination;

class Distributeri extends Component
{
    use WithPagination;
    
    /**
     * Put your custom public properties here!
     */
    //Create update
    public $modalFormVisible;
    public $modelId;
    public $isUpdate;

    public $d_naziv;
    public $d_adresa;
    public $d_zip;
    public $d_mesto;
    public $d_email;
    public $d_pib;
    public $d_mb;
    public $broj_ugovora;
    public $datum_ugovora;
    public $datum_kraj_ugovora;
    public $dani_prekoracenja_licence;

    
    //delete
    public $modalConfirmDeleteVisible;
    
    //OREDER BY
    public $orderBy;

    //SEARCH
    public $searchName;
    public $searchMesto;
    public $searchPib;


    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        return [ 
            'd_naziv' => 'required',
            'd_adresa' => 'required',
            'd_zip' => ['required', 'digits:5'],
            'd_mesto' => 'required',
            'd_email' => ['required','email'],
            'd_pib' => ['required', 'digits:8'],
            'd_mb' => ['required', 'digits:8'],
            'datum_ugovora' => ['required', 'date_format:Y-m-d'],
            'datum_kraj_ugovora'=> ['required', 'date_format:Y-m-d'],
            'dani_prekoracenja_licence' => ['required', 'numeric'],      
        ];
    }

    /**
     * Loads the model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        $data = LicencaDistributerTip::find($this->modelId);
        
        $this->d_naziv      = $data->distributer_naziv;
        $this->d_adresa     = $data->distributer_adresa;
        $this->d_zip        = $data->distributer_zip;
        $this->d_mesto      = $data->distributer_mesto;
        $this->d_email      = $data->distributer_email;
        $this->d_pib        = $data->distributer_pib;
        $this->d_mb         = $data->distributer_mb;
        $this->broj_ugovora     = $data->broj_ugovora;
        $this->datum_ugovora    = $data->datum_ugovora;
        $this->datum_kraj_ugovora       = $data->datum_kraj_ugovora;
        $this->dani_prekoracenja_licence     = $data->dani_prekoracenja_licence;
    }

    /**
     * Resets the model data
     * of this component.
     *
     * @return void
     */
    public function resetModel()
    {
        $data = LicencaDistributerTip::find($this->modelId);
        
       $this->d_naziv = '';
       $this->d_adresa = '';
       $this->d_zip = '';
       $this->d_mesto = '';
       $this->d_email = '';
       $this->d_pib = '';
       $this->d_mb = '';
       $this->broj_ugovora = '';
       $this->datum_ugovora = '';
       $this->datum_kraj_ugovora = '';
       $this->dani_prekoracenja_licence = '';
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
            'distributer_naziv' => $this->d_naziv,
            'distributer_adresa' => $this->d_adresa,
            'distributer_zip' => $this->d_zip,
            'distributer_mesto' => $this->d_mesto,
            'distributer_email' => $this->d_email,
            'distributer_pib' => $this->d_pib,
            'distributer_mb' => $this->d_mb,
            'broj_ugovora' => $this->broj_ugovora,
            'datum_ugovora' => $this->datum_ugovora,
            'datum_kraj_ugovora' => $this->datum_kraj_ugovora,
            'dani_prekoracenja_licence' => $this->dani_prekoracenja_licence       
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
        LicencaDistributerTip::create($this->modelData());
        $this->modalFormVisible = false;
        $this->resetModel();
    }

    /**
     * The read function.
     *
     * @return void
     */
    public function read() 
    {
       return LicencaDistributerTip::select('licenca_distributer_tips.*')
            ->paginate(Config::get('global.paginate'), ['*'], 'lokacije'); 
    }

    /**
     * The update function
     *
     * @return void
     */
    public function update()
    {
        $this->validate();
        LicencaDistributerTip::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible = false;
    }

    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        //LicencaDistributerTip::destroy($this->modelId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }

    /**
     * Shows the create modal
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->resetModel();
        $this->isUpdate = false;
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
        $this->resetModel();
        $this->modelId = $id;
        $this->loadModel();
        $this->isUpdate = true;
        $this->modalFormVisible = true;
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
        return view('livewire.distributeri', [
            'data' => $this->read(),
        ]);
    }
}