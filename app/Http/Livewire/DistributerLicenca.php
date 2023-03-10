<?php

namespace App\Http\Livewire;

use App\Models\LicencaDistributerCena;
use App\Models\LicencaDistributerTip;
use App\Models\LicencaTip;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class DistributerLicenca extends Component
{
    use WithPagination;
    
    public $modalFormVisible;
    public $modalConfirmDeleteVisible;
    public $modelId;

    public $distId;
    public $isUpdate;
    public $l_naziv;
    public $licenca_cena;
    public $licenca_tip_id;

    public $delete_error;
    public $delete_error_text;

     /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->distId = request()->query('id');
    }

    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        return [  
            'licenca_cena' => ['required', 'numeric']          
        ];
    }

    /**
     * Reset the model data
     * of this component.
     *
     * @return void
     */
    public function resetLic()
    {
        $this->isUpdate = false;
        $this->l_naziv = '';
        $this->licenca_cena = '';
        $this->licenca_tip_id = '';
        $this->modelId = '';
        $this->delete_error = false;
        $this->delete_error_text = '';
    }

    /**
     * Loads the model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        $data = LicencaDistributerCena::find($this->modelId);
        // Assign the variables here
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
            'distributerId' => $this->distId,
            'licenca_tipId' => $this->licenca_tip_id,
            'licenca_cena'  => $this->licenca_cena
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
        
        DB::transaction(function() {
            //Distributeri tabela
            $cuurent = LicencaDistributerTip::where('id', $this->distId) -> first();
            $new_br = $cuurent->broj_licenci;
            $new_br ++;
            //insert nova licenca
            LicencaDistributerCena::create($this->modelData());
            //update Distributeri tabela
            LicencaDistributerTip::where('id', $this->distId)->update(['broj_licenci' => $new_br ]);
        });
        
        $this->modalFormVisible = false;
        $this->resetLic();
    }

    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return LicencaDistributerCena::select('licenca_distributer_cenas.*', 'licenca_tips.licenca_naziv', 'licenca_tips.licenca_opis')
                ->leftJoin('licenca_tips', 'licenca_tips.id', '=', 'licenca_distributer_cenas.licenca_tipId')
                ->where('licenca_distributer_cenas.distributerId', '=', $this->distId)
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
        LicencaDistributerCena::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible = false;
        $this->resetLic();
    }

    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        if($this->canDelete()){
            DB::transaction(function() {
                //Distributeri tabela
                $cuurent = LicencaDistributerTip::where('id', $this->distId) -> first();
                $new_br = $cuurent->broj_licenci;
                $new_br --;
                //insert nova licenca
                LicencaDistributerCena::destroy($this->modelId);
                //update Distributeri tabela
                LicencaDistributerTip::where('id', $this->distId)->update(['broj_licenci' => $new_br ]);
            });

            $this->modalConfirmDeleteVisible = false;
            $this->resetPage();
        }else{
            $this->delete_error = true;
            $this->delete_error_text = 'Licenca se ne može obrisati jer je vezana za jedan ili više terminala!';
        }
    }

    /**
     * The delete function.
     *
     * @return boolean
     */
    private function canDelete()
    {
        return false;
    }

    /**
     * Shows the create modal
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->resetLic();
        $this->isUpdate = false;
        $this->resetValidation();
        $this->modalFormVisible = true;
    }

    /**
     * Shows the form modal
     * in update mode.
     *
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id, $naziv)
    {
        $this->resetLic();
        $this->isUpdate = true;
        $this->l_naziv = $naziv;
        $licencaCenaRow = LicencaDistributerCena::find($id);
        $this->licenca_cena = $licencaCenaRow->licenca_cena;
        $this->licenca_tip_id = $licencaCenaRow->licenca_tipId;
        $this->resetValidation();
        $this->modalFormVisible = true;
        $this->modelId = $id;
       //$this->loadModel();
    }

    /**
     * Shows the delete confirmation modal.
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id, $naziv)
    {
        $this->resetLic();
        $this->modelId = $id;
        $this->l_naziv = $naziv;
        $this->modalConfirmDeleteVisible = true;
    }    

    public function render()
    {
        return view('livewire.distributer-licenca', [
            'data' => $this->read(),
        ]);
    }
}