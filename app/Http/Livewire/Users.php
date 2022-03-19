<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\PozicijaTip;
use App\Models\KorisnikRadniStatus;
use App\Models\KorisnikRadniStatusHistory;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection;

use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class Users extends Component 
{
    use WithPagination;
    
    public $modalFormVisible;
    public $modalConfirmDeleteVisible;
    public $modelId;
    public $name;
    public $email;
    public $pozicijaId;
    public $pozicijaList;
    public $telegramId;
    public $tel;
    public $password;

    //Radni status
    public $modalRadniStatusVisible;
    public $radniStatusId;
    public $oldRadniStatusId;

    //lokacija
    public $lokacijaId;

    //new user
    public $newUser;

    /**
     * Put your custom public properties here!
     */

    /**
     * The validation rules
     *
     * 'password' => ['required', 'confirmed', Password::min(8)
     *                   ->mixedCase()
     *                  ->letters()
     *                   ->numbers()
     *                   ->symbols()
     *                   ->uncompromised(),
     *           ],
     * 
     * 
     * @return void
     */
    public function rules()
    {
        if($this->newUser){
            return [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', Password::min(8)
                        ->letters(),
                ],
                'pozicijaId' => 'required',
                'lokacijaId' => 'required',
                'telegramId' => ['digits_between:4,20', 'nullable'],
                'tel' => ['digits_between:9,11', 'nullable'],
            ];
        }else{
            return [  
                'name' => 'required',
                'pozicijaId' => 'required',
                'lokacijaId' => 'required',
                'telegramId' => ['digits_between:4,20', 'nullable'],
                'tel' => ['digits_between:9,11', 'nullable'],
            ];
        }
    }

    /**
     * Shows the create NEW USER modal
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
        $this->newUser = true;
    }

    /**
     * Shows the form modal AFTHER BUTTON CLICK
     * in update mode.
     *
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id)
    {
        $this->newUser = false;
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
        $this->modelId = $id;
        $this->loadModel();
    }

    /**
     * Loads the model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        $data = User::find($this->modelId);
        // Assign the variables here
        $this->name       = $data->name;
        //$this->email      = $data->email;
        $this->pozicijaId = $data->pozicija_tipId;
        $this->lokacijaId = $data->lokacijaId;
        $this->email      = $data->email;
        $this->telegramId = ($data->telegramId > 0) ? $data->telegramId : "";
        $this->tel        = ($data->tel) ? trim($data->tel, '+381') : '';
    }

    /**
     * The data for the model mapped
     * in this component.
     *
     * @return void
     */
    public function modelData()
    {
        $tell = ($this->tel != '') ? '+381'.$this->tel : '';
        $mdata = [  
            'name' => $this->name,
            'pozicija_tipId' => $this->pozicijaId,
            'lokacijaId' => $this->lokacijaId,
            'telegramId' => $this->telegramId,
            'tel' => $tell,
        ];

        if($this->newUser){
            $mdata['email'] = $this->email;
            $mdata['password'] = Hash::make($this->password);
        };
        return $mdata;
    }

    /**
     * The create NEW USER function.
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        $nUser = User::create($this->modelData());
        KorisnikRadniStatus :: create([
            'korisnikId' => $nUser->id,
            'radni_statusId' => 1,
        ]);
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
        return User::leftJoin('pozicija_tips', 'users.pozicija_tipId', '=', 'pozicija_tips.id')
            ->leftJoin('korisnik_radni_statuses', 'users.id', '=', 'korisnik_radni_statuses.korisnikId')
            ->leftJoin('radni_status_tips', 'korisnik_radni_statuses.radni_statusId', '=', 'radni_status_tips.id')
            ->leftJoin('lokacijas', 'users.lokacijaId', '=', 'lokacijas.id')
            ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
            ->select('users.*', 'pozicija_tips.id as ptid', 'pozicija_tips.naziv as naziv','radni_status_tips.id as rstid', 'radni_status_tips.rs_naziv as rs_naziv', 'lokacijas.l_naziv', 'lokacijas.mesto', 'regions.r_naziv')
            ->paginate(5);
    }

    /**
     * The update function
     *
     * @return void
     */
    public function update()
    {
        $this->validate();
        User::find($this->modelId)->update($this->modelData());
       $this->modalFormVisible = false;
    }

    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        //ovde mora transakcija

        //User::destroy($this->modelId);
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
        $this->newUser = false;
        $this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
    }    

    public function render()
    {
        return view('livewire.users', [
            'data' => $this->read(),
        ]);
    }

       /* ----------------------------------- Radni Status Modal ------------------------------------------*/
    /**
     * Shows the create modal
     *
     * @return void
     */
    public function createShowRadniStatusModal()
    {
        $this->modalRadniStatusVisible = true;
    }

    /**
     * Shows the form modal CALLED AFTER BTN CLICK
     * in update mode.
     *
     * @param  mixed $id
     * @return void
     */
    public function updateShowRadniStatusModal($id)
    {
        $this->newUser = false;
        //$this->reset();
        $this->modalRadniStatusVisible = true;
        $this->modelId = $id;
        $this->loadRadniStatusModel();
    }

    /**
     * Loads the model data
     * of this component.
     *
     * @return void
     */
    public function loadRadniStatusModel()
    {
        $data = User::find($this->modelId);
        // Assign the variables here
        $this->name = $data->name;
        $data_status = KorisnikRadniStatus::where('korisnikId', $this->modelId)->first();
        $this->radniStatusId = $data_status->radni_statusId;
        $this->oldRadniStatusId = $this->radniStatusId;
    }

    /**
     * The update Radni Status function
     *
     * @return void
     */
    public function updateRadniStatus()
    {
        if($this->radniStatusId != $this->oldRadniStatusId){
            DB::transaction(function(){
                //prvo trenutna vrednost iz tabele 
                $cuurent = KorisnikRadniStatus::where('korisnikId', $this->modelId)->first();
                //zatim upis u history tabelu
                KorisnikRadniStatusHistory::create(['korisnik_radni_statusId' => $cuurent['id'], 'korisnikId' => $cuurent['korisnikId'], 'radni_statusId' => $cuurent['radni_statusId']]);
                //update trenutnog stanja
                KorisnikRadniStatus::where('korisnikId', $this->modelId)->update(['radni_statusId' => $this->radniStatusId]);
            });
        }
       $this->modalRadniStatusVisible = false;
    }
    
}