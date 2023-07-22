<?php

namespace App\Http\Livewire;

use App\Models\LicencaTip;
use App\Models\LicencaParametar;
use App\Models\LicencaDistributerCena;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Validation\Rule;

class Licence extends Component
{
    use WithPagination;
    
    public $modalFormVisible;
    public $modalConfirmDeleteVisible;
    public $modelId;

    public $is_update;

    //create / update
    public $naziv_licence;
    public $opis_licence;
    public $is_osnovna;

    //delete
    public $count_distributre_sa_licencom;
    public $distributeri_sa_licencom;
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
        return ($this->is_update) ? ['naziv_licence' => 'required'] : [  
            'naziv_licence' => 'required',
            'naziv_licence'  => Rule::unique('licenca_tips', 'licenca_naziv')     
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
        $data = LicencaTip::find($this->modelId);
        // Assign the variables here
        $this->naziv_licence = $data->licenca_naziv;
        $this->opis_licence = $data->licenca_opis;
        //$this->is_osnovna = ($data->osnovna_licenca) ? 1 : 0; 
    }

    /**
     * The data for the model mapped
     * in this component.
     *
     * 'osnovna_licenca' =>  ($this->is_osnovna) ? 1 : 0
     * @return void
     */
    public function modelData()
    {
        return [  
            'licenca_naziv' => $this->naziv_licence,
            'licenca_opis' => $this->opis_licence
        ];
    }

    /**
     * Shows the create modal
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->modelId = 0;
        $this->is_update = false;
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
        //$this->is_osnovna = 0;
    }

    /**
     * The create function.
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        LicencaTip::create($this->modelData());
        $this->modalFormVisible = false;
        $this->reset();
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
        $this->is_update = true;
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
        LicencaTip::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible = false;
    }

    /**
     * Shows the delete confirmation modal.
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id, $cdsl)
    {
        $this->count_distributre_sa_licencom = $cdsl;
        $this->modelId = $id;
        $this->loadModel();
        if($this->count_distributre_sa_licencom){
            $this->distributeri_sa_licencom = $this->distributeriSaLicencom();
        }
        $this->modalConfirmDeleteVisible = true;
    } 
    
    private function distributeriSaLicencom()
    {
        return LicencaDistributerCena::select('licenca_distributer_tips.distributer_naziv')
                ->leftJoin('licenca_distributer_tips', 'licenca_distributer_tips.id', '=', 'licenca_distributer_cenas.distributerId')
                ->where('licenca_distributer_cenas.licenca_tipId', '=', $this->modelId)
                ->get();
    }

     /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        DB::transaction(function(){
            LicencaParametar::where('licenca_tipId', '=', $this->modelId)->delete();
            LicencaTip::destroy($this->modelId);
        });
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }

    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return LicencaTip::selectRaw('licenca_tips.*, COUNT(licenca_distributer_cenas.licenca_tipId) as count_tip')
                ->leftJoin('licenca_distributer_cenas', 'licenca_distributer_cenas.licenca_tipId', '=', 'licenca_tips.id')
                ->groupBy('licenca_distributer_cenas.licenca_tipId')
                ->paginate(Config::get('global.paginate'));
    }

    public function render()
    {
        return view('livewire.licence', [
            'data' => $this->read(),
        ]);
    }
}