<?php

namespace App\Http\Livewire;

use App\Models\LicencaDistributerTerminal;
use App\Models\TerminalLokacija;
use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class DistributerTerminal extends Component
{
    use WithPagination;
    
    public $modalFormVisible;
    public $modalConfirmDeleteVisible;
    public $modelId;

    public $distId;

    public $isUpdate;

    //dodaj terminal MODAL
    public $allInPage;
    public $selectAllValue = 1;
    public $selectAll;
    public $searchSN;
    public $searchBK;
    public $selsectedTerminals = [];

    public $licenca_tip_id;
    

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
        $data = LicencaDistributerTerminal::find($this->modelId);
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
        LicencaDistributerTerminal::create($this->modelData());
        $this->modalFormVisible = false;
        $this->reset();
    }

    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return LicencaDistributerTerminal::paginate(5);
    }

    /**
     * The update function
     *
     * @return void
     */
    public function update()
    {
        $this->validate();
        LicencaDistributerTerminal::find($this->modelId)->update($this->modelData());
        $this->modalFormVisible = false;
    }

    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        LicencaDistributerTerminal::destroy($this->modelId);
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
        //$this->reset();
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
        dd($this->terminalsToAdd());
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
        $this->modelId = $id;
        $this->loadModel();
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
     * The data for the model mapped
     * in this component.
     *
     * @return object
     */
    public function tremninaliSaLicencom()
    {
        $DodeljeneLicence = LicencaDistributerTerminal::select('terminal_lokacijaId')->distinct()->pluck('terminal_lokacijaId')->all();

        return $DodeljeneLicence;
    }

    /**
     * terminaliZaLokaciju
     *
     * @param  mixed $id
     * @param  mixed $sn
     * @param  mixed $bk 
     * @return object
     */
    public function terminaliZaLokaciju( $sn = '', $bk = '')
    { 
        $this->allInPage = [];
        //->where('terminal_lokacijas.lokacijaId', $id)
        $terms =  TerminalLokacija::select('terminal_lokacijas.*', 'terminals.sn', 'terminals.broj_kutije', 'terminal_status_tips.ts_naziv', 'terminals.id as tid', 'terminal_tips.model')
                                ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                                ->leftJoin('terminal_tips', 'terminals.terminal_tipId', '=', 'terminal_tips.id')
                                ->leftJoin('terminal_status_tips', 'terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
                                ->where('terminals.sn', 'like', '%'.$sn.'%')
                                ->where('terminals.broj_kutije', 'like', '%'.$bk.'%')
                                ->paginate(Config::get('global.terminal_paginate'), ['*'], 'terminaliLokacija');
        foreach($terms as $terminal){
            array_push($this->allInPage,  $terminal->id);
        }
        //$this->selectAll[1] = false;
        return $terms;
    }

     /**
     * updated
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public function updated($key, $value)
    {
        
        $exp = Str::of($key)->explode(delimiter: '.');
        if($exp[0] === 'selectAll' && is_numeric($value)){
           foreach($this->allInPage as $termid){
               if(!in_array($termid, $this->selsectedTerminals)){
                array_push($this->selsectedTerminals, $termid);
               }  
           }
        }elseif($exp[0] === 'selectAll' && empty($value)){
            $this->selsectedTerminals = array_diff($this->selsectedTerminals, $this->allInPage);
        }
    }

    public function render()
    {
        return view('livewire.distributer-terminal', [
            'data' => $this->read(),
        ]);
    }
}