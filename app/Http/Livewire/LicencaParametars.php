<?php

namespace App\Http\Livewire;

use App\Models\LicencaTip;
use App\Models\LicencaParametar;
use App\Models\LicencaParametarTerminal;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use Livewire\Component;
use Livewire\WithPagination;

class LicencaParametars extends Component
{
    use WithPagination;
    
    public $modalFormVisible;
    public $modalConfirmDeleteVisible;
    public $modelId;

    public $licencaIme;
    public $lid;

    //new edit
    public $is_update;
    public $p_naziv;

     /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->lid = request()->query('id');
        $this->licencaIme = LicencaTip::imeLicence($this->lid);
    }

    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        return [ 
            'p_naziv' => 'required'           
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
        $data = LicencaParametar::find($this->modelId);
        // Assign the variables here
        $this->p_naziv = $data->param_opis;
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
            'licenca_tipId' => $this->lid,
            'param_opis'  =>  $this->p_naziv      
        ];
    }

    /**
     * Shows the create modal
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->is_update = false;
        $this->resetValidation();
        $this->p_naziv = '';
        //$this->reset();
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
        LicencaParametar::create($this->modelData());
        $this->updateParamasInLicTable();
        $this->modalFormVisible = false;
       // $this->reset();
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
        $this->is_update = true;
        $this->resetValidation();
        //$this->reset();
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
        LicencaParametar::find($this->modelId)->update($this->modelData());
        $this->updateParamasInLicTable();
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
        $this->loadModel();
        $this->modalConfirmDeleteVisible = true;
    }    

    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        DB::transaction(function(){
            LicencaParametar::destroy($this->modelId);
            LicencaParametarTerminal::where('licenca_parametarId', '=', $this->modelId)->delete();
        });
        $this->updateParamasInLicTable();
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }

    private function updateParamasInLicTable()
    {
        $no_of_params = LicencaParametar::selectRaw('COUNT(licenca_tipId) as params_no')
                        ->where('licenca_tipId', '=', $this->lid)
                        ->first();
        LicencaTip::find($this->lid)->update(['broj_parametara_licence' => $no_of_params->params_no]);
    }
    
    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return LicencaParametar::where('licenca_tipId', '=', $this->lid)
                ->paginate(Config::get('global.paginate'));
    }

    public function render()
    {
        return view('livewire.licenca-parametar', [
            'data' => $this->read(),
        ]);
    }
}