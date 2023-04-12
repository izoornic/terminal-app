<?php

namespace App\Http\Livewire;

use App\Models\LicencaNaplata;
use App\Models\LicencaDistributerTip;
use App\Models\LicencaMesec;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Config;

class ZaduzenjePregled extends Component
{
    use WithPagination;

    /**
     * Put your custom public properties here!
     */
    //mount
    public $did;
    public $mid;
    public $sum_zaduzenja;
    public $distributer_info;
    public $mesecRow;

    public $modalConfirmDeleteVisible;

     /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->did = request()->query('id');
        $this->mid = request()->query('mid');
        $this->sum_zaduzenja = LicencaNaplata::where('distributerId', '=', $this->did)
                                            ->where('mesecId', '=', $this->mid)
                                            ->sum('zaduzeno');
        $this->distributer_info = LicencaDistributerTip::where('id', '=', $this->did)->first();
        $this->mesecRow = LicencaMesec::where('id', '=', $this->mid)->first();
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
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        //LicencaNaplata::destroy($this->modelId);
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
        //$this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
    }    

    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return LicencaNaplata::select(
                        'terminal_lokacijas.id', 
                        'terminals.sn', 
                        'lokacijas.l_naziv', 
                        'lokacijas.mesto', 
                        'lokacijas.adresa',
                        'licenca_naplatas.broj_dana',
                        'licenca_naplatas.zaduzeno',
                        'licenca_naplatas.datum_pocetka_licence', 
                        'licenca_naplatas.datum_kraj_licence', 
                        'licenca_naplatas.datum_isteka_prekoracenja', 
                        'licenca_naplatas.licenca_distributer_cenaId',
                        'licenca_tips.licenca_naziv', 
                        'licenca_tips.id as ltid',
                        )
                        ->leftJoin('terminal_lokacijas', 'licenca_naplatas.terminal_lokacijaId', '=', 'terminal_lokacijas.id')
                        ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                        ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                        ->leftJoin('licenca_distributer_cenas', 'licenca_naplatas.licenca_distributer_cenaId', '=', 'licenca_distributer_cenas.id')
                        ->leftJoin('licenca_tips', 'licenca_distributer_cenas.licenca_tipId', '=', 'licenca_tips.id')
                        ->where('licenca_naplatas.distributerId', '=', $this->did)
                        ->where('licenca_naplatas.mesecId', '=', $this->mid)
                        ->orderBy('terminal_lokacijas.id')
                        ->orderBy('licenca_distributer_cenas.licenca_tipId')
                        ->paginate(Config::get('global.paginate'));
    }

    public function render()
    {
        return view('livewire.zaduzenje-pregled', [
            'data' => $this->read(),
        ]);
    }
}