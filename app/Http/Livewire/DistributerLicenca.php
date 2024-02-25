<?php

namespace App\Http\Livewire;

use App\Models\LicencaDistributerCena;
use App\Models\LicencaDistributerTerminal;
use App\Models\LicencaDistributerTip;
use App\Models\LicencaTip;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use Livewire\Component;
use Livewire\WithPagination;


class DistributerLicenca extends Component
{
    use WithPagination;
    
    public $modalFormVisible;
    public $modalConfirmDeleteVisible;
    public $modelId;

    public $distId;
    public $dist_name;
    public $isUpdate;
    public $l_naziv;
    public $licenca_zeta_cena;
    public $licenca_tip_id;

    public $licenca_dist_cena;

    public $prva_licenca;
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
        $this->dist_name = LicencaDistributerTip::DistributerName($this->distId);
    }

    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        return [  
            'licenca_zeta_cena' => ['required', 'numeric'],
            'licenca_tip_id'   =>    ['required', 'numeric'],
            'licenca_dist_cena' =>   ['required', 'numeric']
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
        $this->licenca_zeta_cena = '';
        $this->licenca_tip_id = '';
        $this->modelId = '';
        $this->delete_error = false;
        $this->delete_error_text = '';
        $this->licenca_dist_cena = '';
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

        $this->licenca_zeta_cena = $data->licenca_zeta_cena;
        $this->licenca_tip_id = $data->licenca_tipId;
        $this->licenca_dist_cena = $data->licenca_dist_cena;
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
            'licenca_zeta_cena'  => $this->licenca_zeta_cena,
            'licenca_dist_cena' => $this->licenca_dist_cena
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
            //insert nova licenca
            LicencaDistributerCena::create($this->modelData());
            //update Distributeri tabela
            LicencaDistributerTip::find($this->distId)->increment('broj_licenci');
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
                //insert nova licenca
                LicencaDistributerCena::destroy($this->modelId);
                //update Distributeri tabela
                LicencaDistributerTip::find($this->distId)->decrement('broj_licenci');
            });

            $this->modalConfirmDeleteVisible = false;
            $this->resetPage();
        }else{
            $this->delete_error = true;
        }
    }

    /**
     * Uslov za brisanje function.
     *
     * @return boolean
     */
    private function canDelete()
    {
        //da li ima trminala sa tom licencom
        if(LicencaDistributerTerminal::where('licenca_distributer_cenaId', '=', $this->modelId)->first()){
           //ima
           $this->delete_error_text = 'Licenca se ne može obrisati jer je vezana za jedan ili više terminala!';
           return false;
        }else{
            // da li je osnovna licenca
            $licenca = LicencaDistributerCena::select('licenca_tipId')->where('id', '=', $this->modelId)->first();
            if($licenca->licenca_tipId == 1){
                //jeste osnovna, da li ima jos licenci
                if(LicencaDistributerCena::where('distributerId', '=', $this->distId)->where('licenca_tipId', '<>', 1)->first()){
                    //ima jos licenci
                    $this->delete_error_text = 'Da bi ste obrisali osnovnu licencu, prvo morate obrisati sve dodatne licence';
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        }
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
        //check if it's first
        $this->prva_licenca = (LicencaDistributerCena::OsnovnaLicencaDistributera($this->distId)[0] == 0) ? true : false; 
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
        $this->modelId = $id;
        $this->loadModel();
        $this->isUpdate = true;
        $this->l_naziv = $naziv;
        $this->resetValidation();
        $this->modalFormVisible = true;
       
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