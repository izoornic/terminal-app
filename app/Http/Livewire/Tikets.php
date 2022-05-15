<?php

namespace App\Http\Livewire;

use Auth;
use App\Models\Tiket;
use App\Models\TerminalLokacija;
use App\Models\User;
use App\Models\TiketPrioritetTip;

use App\Models\TiketAkcijaKorisnikPozicija;
use App\Models\Lokacija;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class Tikets extends Component
{
    use WithPagination;
    
    //READ main table
    public $searchLokacijaNaziv;
    public $searchMesto;
    public $searchRegion;
    public $searchPrioritet;
    public $searchStatus = 1;
    

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

    //search korisnika kome se dodeljuje tiket
    public $searchUserName;
    public $searchUserLokacija;
    public $searchUserPozicija;

    public $dodeljenUserId;
    public $dodeljenUserInfo;

    public $prioritetTiketa;
    public $prioritetInfo;

    public $orderBy = 'updated_at';

    //akcije nad tiketom u zavisnosti od pozicije korisnika
    //oderdjuje ko koje tikete vidi
    public $tiketAkcija;
    public $userRegion;

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
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $akcija = TiketAkcijaKorisnikPozicija::select('tiket_akcija_tips.id as akcijaid', 'tiket_akcija_tips.tiket_akcija', 'tiket_akcija_vrednost_tips.id as vrednostId', 'tiket_akcija_vrednost_tips.akcija_vrednost_opis')
                                ->leftJoin('tiket_akcija_tips', 'tiket_akcija_tips.id', '=', 'tiket_akcija_korisnik_pozicijas.tiket_akcijaId')
                                ->leftJoin('tiket_akcija_vrednost_tips', 'tiket_akcija_vrednost_tips.id', '=', 'tiket_akcija_korisnik_pozicijas.tiket_akcijavrednostId')
                                ->where('tiket_akcija_korisnik_pozicijas.korisnik_pozicijaId', '=', auth()->user()->pozicija_tipId)
                                ->get();
        foreach ($akcija as $value){
            $this->tiketAkcija[$value->akcijaid] = $value->akcija_vrednost_opis;
        }

        $region = Lokacija::select('regions.id as rid')
                                ->leftJoin('regions', 'regions.id', '=', 'lokacijas.regionId')
                                ->where('lokacijas.id', '=', auth()->user()->lokacijaId)
                                ->first();
        $this->userRegion = $region->rid;
        //dd($this->tiketAkcija);
    }

    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        

       // searchStatus

        $rtval = Tiket::select('tikets.id as tikid', 'tikets.created_at', 'tikets.updated_at', 'tikets.br_komentara','lokacijas.l_naziv', 'lokacijas.mesto', 'terminals.sn', 'users.name', 'tiket_status_tips.tks_naziv', 'tiket_prioritet_tips.tp_naziv', 'tiket_prioritet_tips.btn_collor', 'tiket_prioritet_tips.tr_bg_collor', 'regions.r_naziv')
            ->leftJoin('tiket_status_tips', 'tikets.tiket_statusId', '=', 'tiket_status_tips.id')
            ->leftJoin('tiket_prioritet_tips', 'tikets.tiket_prioritetId', '=', 'tiket_prioritet_tips.id')
            ->leftJoin('users', 'tikets.korisnik_dodeljenId', '=', 'users.id')
            ->leftJoin('terminal_lokacijas', 'tikets.tremina_lokacijalId', '=', 'terminal_lokacijas.id')
            ->leftJoin('lokacijas', 'lokacijas.id', '=', 'terminal_lokacijas.lokacijaId')
            ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
            ->leftJoin('terminals', 'terminals.id', '=', 'terminal_lokacijas.terminalId')
            ->where('l_naziv', 'like', '%'.$this->searchLokacijaNaziv.'%')
            ->where('mesto', 'like', '%'.$this->searchMesto.'%')
            ->where('regions.id', ($this->searchRegion > 0) ? '=' : '<>', $this->searchRegion)
            ->where('tikets.tiket_prioritetId', ($this->searchPrioritet > 0) ? '=' : '<>', $this->searchPrioritet)
            ->when($this->searchStatus == 1, function ($rtval){
                return $rtval->where('tikets.tiket_statusId', '<>', 3);
            } )
            ->when($this->searchStatus == 2, function ($rtval){
                return $rtval->where('tikets.tiket_statusId', '=', 1);
            } )
            ->when($this->searchStatus == 3, function ($rtval){
                return $rtval->where('tikets.tiket_statusId', '=', 2);
            } )
            ->when($this->searchStatus == 4, function ($rtval){
                return $rtval->where('tikets.tiket_statusId', '=', 3);
            } )
            ->when($this->tiketAkcija[1] == "region", function ($rtval){
                return $rtval->where('regions.id', '=', $this->userRegion);
            })
            ->when($this->tiketAkcija[1] == "dodeljen", function($rtval){
                return  $rtval->where('tikets.korisnik_dodeljenId', '=', auth()->user()->id)
                ->orWhere('tikets.korisnik_prijavaId', '=', auth()->user()->id);
            })
            ->orderBy($this->orderBy, ($this->orderBy=='tiket_prioritet_tips.id') ? 'asc' : 'desc')
            ->paginate(Config::get('global.paginate'), ['*'], 'tik');

       
        return $rtval;
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
        if($this->tiketAkcija[1] == "region"){
            return TerminalLokacija::select('terminal_lokacijas.id', 'lokacijas.l_naziv', 'lokacijas.mesto', 'terminals.sn')
                    ->leftJoin('lokacijas', 'lokacijas.id', '=', 'terminal_lokacijas.lokacijaId')
                    ->leftJoin('terminals', 'terminals.id', '=', 'terminal_lokacijas.terminalId')
                    ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
                    ->where('regions.id', '=', $this->userRegion)
                    ->where('l_naziv', 'like', '%'.$this->searchTerminalLokacijaNaziv.'%')
                    ->where('mesto', 'like', '%'.$this->searchTerminalMesto.'%')
                    ->where('sn', 'like', '%'.$this->searchTerminalSn.'%')
                    ->paginate(Config::get('global.modal_search'), ['*'], 'loc');
        }else{
            return TerminalLokacija::select('terminal_lokacijas.id', 'lokacijas.l_naziv', 'lokacijas.mesto', 'terminals.sn')
                    ->leftJoin('lokacijas', 'lokacijas.id', '=', 'terminal_lokacijas.lokacijaId')
                    ->leftJoin('terminals', 'terminals.id', '=', 'terminal_lokacijas.terminalId')
                    ->where('l_naziv', 'like', '%'.$this->searchTerminalLokacijaNaziv.'%')
                    ->where('mesto', 'like', '%'.$this->searchTerminalMesto.'%')
                    ->where('sn', 'like', '%'.$this->searchTerminalSn.'%')
                    ->paginate(Config::get('global.modal_search'), ['*'], 'loc');
        }
    }

    /**
     * Info o izabranom terminalu na MODAL pop up-u
     *
     * @return void
     */
    private function selectedTerminalInfo(){
        return TerminalLokacija::select('terminal_lokacijas.*', 'terminals.sn', 'terminals.terminal_tipId as tid', 'terminal_status_tips.ts_naziv', 'lokacijas.l_naziv', 'lokacijas.mesto', 'lokacija_kontakt_osobas.name', 'lokacija_kontakt_osobas.tel', 'regions.r_naziv')
                    ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                    ->leftJoin('terminal_status_tips', 'terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
                    ->leftJoin('lokacijas', 'terminal_lokacijas.lokacijaId', '=', 'lokacijas.id')
                    ->leftJoin('lokacija_kontakt_osobas', 'lokacijas.id', '=', 'lokacija_kontakt_osobas.lokacijaId')
                    ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
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