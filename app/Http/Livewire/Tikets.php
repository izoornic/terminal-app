<?php

namespace App\Http\Livewire;

use Auth;
use App\Models\Tiket;
use App\Models\TerminalLokacija;
use App\Models\User;
use App\Models\TiketPrioritetTip;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class Tikets extends Component
{
    use WithPagination;
    
    //READ main table
    //public $

    //MODAL dodaj tiket
    public $modalNewTiketVisible;
    public $modalConfirmDeleteVisible;
    public $modelId;

    //pretraga kada se otvara novi tiket
    public $searchTerminalLokacijaNaziv;
    public $searchTerminalMesto;
    public $searchTerminalSn;
    
    //terminal_lokacija id izabranog terminala
    public $newTerminalId;
    //info o izabranom terminalu iz baze
    public $newTerminalInfo;
    //opis kvara izabran iz liste
    public $opisKvaraList;
    //opis kvara text area
    public $opisKvataTxt;
    public $counter;

    //search korisnika kome se dodeljuje tiket
    public $searchUserName;
    public $searchUserLokacija;
    public $searchUserPozicija;

    public $dodeljenUserId;
    public $dodeljenUserInfo;

    public $prioritetTiketa;
    public $prioritetInfo;

    
    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        return [ 
            'opisKvaraList' => 'required'          
        ];
    }

    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return Tiket::select('tikets.id as tikid', 'tikets.created_at', 'tikets.updated_at', 'tikets.br_komentara','lokacijas.l_naziv', 'lokacijas.mesto', 'terminals.sn', 'users.name', 'tiket_status_tips.tks_naziv', 'tiket_prioritet_tips.tp_naziv', 'tiket_prioritet_tips.btn_collor', 'tiket_prioritet_tips.tr_bg_collor')
                    ->leftJoin('tiket_status_tips', 'tikets.tiket_statusId', '=', 'tiket_status_tips.id')
                    ->leftJoin('tiket_prioritet_tips', 'tikets.tiket_prioritetId', '=', 'tiket_prioritet_tips.id')
                    ->leftJoin('users', 'tikets.korisnik_dodeljenId', '=', 'users.id')
                    ->leftJoin('terminal_lokacijas', 'tikets.tremina_lokacijalId', '=', 'terminal_lokacijas.id')
                    ->leftJoin('lokacijas', 'lokacijas.id', '=', 'terminal_lokacijas.lokacijaId')
                    ->leftJoin('terminals', 'terminals.id', '=', 'terminal_lokacijas.terminalId')
                    ->where('l_naziv', 'like', '%'.$this->searchTerminalLokacijaNaziv.'%')
                    ->where('mesto', 'like', '%'.$this->searchTerminalMesto.'%')
                    ->where('sn', 'like', '%'.$this->searchTerminalSn.'%')
                    ->paginate(Config::get('global.paginate'), ['*'], 'tik');
    }
    /**
     * Loads the model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        $data = Tiket::find($this->modelId);
        // Assign the variables here
    }

    /**
     * Shows the create modal
     *
     * @return void
     */
    public function newTiketShowModal()
    {
        
        $this->resetValidation();
        $this->resetAll();
        $this->modalNewTiketVisible = true;
    }
        
    /**
     * resetAll
     *
     * @return void
     */
    private function resetAll()
    {
        $this->newPretragaPo = 0;
        $this->newTerminalId = 0;
        $this->searchTerminalLokacijaNaziv = '';
        $this->searchTerminalMesto = '';
        $this->searchTerminalSn = '';
        $this->opisKvaraList = null;
        $this->opisKvataTxt = '';

        $this->searchUserName = '';
        $this->searchUserLokacija ='';
        $this->searchUserPozicija ='';

        $this->dodeljenUserId = 0;
        $this->dodeljenUserInfo = null;
        $this->counter = 1;
        
        $this->prioritetTiketa = 0;
        $this->prioritetInfo = null;
    }

    /**
     * searchTerminal
     *
     * @return void
     */
    public function searchTerminal() 
    {
        return TerminalLokacija::select('terminal_lokacijas.id', 'lokacijas.l_naziv', 'lokacijas.mesto', 'terminals.sn')
                    ->leftJoin('lokacijas', 'lokacijas.id', '=', 'terminal_lokacijas.lokacijaId')
                    ->leftJoin('terminals', 'terminals.id', '=', 'terminal_lokacijas.terminalId')
                    ->where('l_naziv', 'like', '%'.$this->searchTerminalLokacijaNaziv.'%')
                    ->where('mesto', 'like', '%'.$this->searchTerminalMesto.'%')
                    ->where('sn', 'like', '%'.$this->searchTerminalSn.'%')
                    ->paginate(Config::get('global.modal_search'), ['*'], 'loc');
    }

    /**
     * Info o izabranom terminalu na MODAL pop up-u
     *
     * @return void
     */
    private function selectedTerminalInfo(){
        return TerminalLokacija::select('terminal_lokacijas.*', 'terminals.sn', 'terminals.terminal_tipId as tid', 'terminal_status_tips.ts_naziv', 'lokacijas.l_naziv', 'lokacijas.mesto')
                    ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                    ->leftJoin('terminal_status_tips', 'terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
                    ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                    ->where('terminalId', $this->newTerminalId)
                    -> first();
    }
    
    /**
     * Pronadji korisnika kome dodeljujes tiket
     *
     * @return void
     */
    public function searchUser()
    {
        return User::select('users.id', 'users.name', 'lokacijas.l_naziv', 'pozicija_tips.naziv')
                    ->leftJoin('lokacijas', 'users.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('pozicija_tips', 'users.pozicija_tipId', '=', 'pozicija_tips.id')
                    ->where('name', 'like', '%'.$this->searchUserName.'%')
                    ->where('l_naziv', 'like', '%'.$this->searchUserLokacija.'%')
                    ->where('naziv', 'like', '%'.$this->searchUserPozicija.'%')
                    ->paginate(Config::get('global.modal_search'), ['*'], 'usersp');
    }    
    /**
     * selectedUserInfo
     *
     * @return void
     */
    private function selectedUserInfo()
    {
        return User::select('users.id', 'users.name', 'lokacijas.l_naziv', 'lokacijas.mesto', 'pozicija_tips.naziv')
                    ->leftJoin('lokacijas', 'users.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('pozicija_tips', 'users.pozicija_tipId', '=', 'pozicija_tips.id')
                    ->where('users.id', '=', $this->dodeljenUserId)
                    ->first();
    }
    
    /**
     * prioritetInfo
     *
     * @return void
     */
    private function prioritetInfo()
    {
        return TiketPrioritetTip::where('id', '=', $this->prioritetTiketa)->first();
    }
    /**
     * The create novi tiket function.
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        Tiket::create($this->modelData());
        $this->modalNewTiketVisible = false;
        $this->resetAll();
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
            'tremina_lokacijalId'   =>  $this->newTerminalId,
            'tiket_statusId'        =>  2,
            'opis_kvaraId'          =>  $this->opisKvaraList,
            'korisnik_prijavaId'    =>  auth()->user()->id,
            'korisnik_dodeljenId'   =>  $this->dodeljenUserId,
            'opis'                  =>  $this->opisKvataTxt,
            'tiket_prioritetId'     =>  $this->prioritetTiketa ,
            'br_komentara'          =>  0

        ];
    }

    /**
     * Shows the form modal
     * in update mode.
     *
     * @param  mixed $id
     * @return void
     */
    /* public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
        $this->modelId = $id;
        $this->loadModel();
    } */

    /**
     * The update function
     *
     * @return void
     */
    public function update()
    {
        $this->validate();
        Tiket::find($this->modelId)->update($this->modelData());
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
        Tiket::destroy($this->modelId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }

    /**
     * updated
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public function updated()
    {
        $this->counter ++;
        if($this->modalNewTiketVisible){
            $this->newTerminalInfo = $this->selectedTerminalInfo();
            if($this->dodeljenUserId){
                $this->dodeljenUserInfo = $this->selectedUserInfo();
            }
            if($this->prioritetTiketa){
                $this->prioritetInfo = $this->prioritetInfo();
            }
        }
    }

    public function render()
    {
        return view('livewire.tiket', [
            'data' => $this->read(),
        ]);
    }

   
}