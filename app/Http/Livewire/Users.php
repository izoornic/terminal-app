<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\UserHistory;
use App\Models\PozicijaTip;
use App\Models\KorisnikRadniStatus;
use App\Models\KorisnikRadniStatusHistory;
use App\Models\KorisnikRadniOdnos;
use App\Models\KorisnikRadniOdnosHistory;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Collection;

use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Config;

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

    //radni odnos
    public $radniOdnosId;
    public $oldRadniOdnosId;

    //new user
    public $newUser;
    //poruka koja se prikazuje posle akcije
    public $actionMessage;
    //pretraga 
    public $searchName;
    public $searchLokacija;
    public $searchRStatus;
    public $searchPozicija;
    //order
    public $orderBy;

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
        $retval = [  
            'name' => 'required',
            'pozicijaId' => 'required',
            'lokacijaId' => 'required',
            'telegramId' => ['digits_between:4,20', 'nullable'],
            'tel' => ['digits_between:9,11', 'nullable'],
            'radniOdnosId' => 'required',
        ];

        if($this->newUser){
            $retval['email'] = ['required', 'string', 'email', 'max:255', 'unique:users'];
            $retval['password'] = ['required', Password::min(8)
            ->letters(),
             ];
        }

        return $retval;
    }

    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        $order = 'id';
        switch($this->orderBy){
            case 'uid':
                $order = 'id';
            break;
            case 'name':
                $order = 'users.name';
            break;
            case 'lokacija':
                $order = 'regions.r_naziv';
            break;
            case 'pozicija':
                $order = 'users.pozicija_tipId';
            break;
            case 'status':
                $order = 'korisnik_radni_statuses.radni_statusId';
            break;
        };

        return User::leftJoin('pozicija_tips', 'users.pozicija_tipId', '=', 'pozicija_tips.id')
            ->leftJoin('korisnik_radni_statuses', 'users.id', '=', 'korisnik_radni_statuses.korisnikId')
            ->leftJoin('radni_status_tips', 'korisnik_radni_statuses.radni_statusId', '=', 'radni_status_tips.id')
            ->leftJoin('lokacijas', 'users.lokacijaId', '=', 'lokacijas.id')
            ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
            ->leftJoin('korisnik_radni_odnos', 'users.id', '=', 'korisnik_radni_odnos.korisnikId')
            ->leftJoin('radni_odnos_tips', 'korisnik_radni_odnos.radni_odnosId', '=', 'radni_odnos_tips.id')
            ->select('users.*', 'pozicija_tips.id as ptid', 'pozicija_tips.naziv as naziv','radni_status_tips.id as rstid', 'radni_status_tips.rs_naziv as rs_naziv', 'lokacijas.l_naziv', 'lokacijas.mesto', 'regions.r_naziv', 'radni_odnos_tips.id as rot_id', 'radni_odnos_tips.ro_naziv')
            ->where('name', 'like', '%'.$this->searchName.'%')
            ->where('lokacijas.id', ($this->searchLokacija > 0) ? '=' : '<>', $this->searchLokacija)
            ->where('radni_status_tips.id', ($this->searchRStatus > 0) ? '=' : '<>', $this->searchRStatus)
            ->where('users.pozicija_tipId', ($this->searchPozicija > 0) ? '=' : '<>', $this->searchPozicija)
            ->orderBy($order)
            ->paginate(Config::get('global.paginate'));
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
        $this->name         = $data->name;
        //$this->email      = $data->email;
        $this->pozicijaId   = $data->pozicija_tipId;
        $this->lokacijaId   = $data->lokacijaId;
        $this->email        = $data->email;
        $this->telegramId   = ($data->telegramId > 0) ? $data->telegramId : "";
        $this->tel          = ($data->tel) ? trim($data->tel, '+381') : '';

        $radniOdnos = KorisnikRadniOdnos::where('korisnikId', $this->modelId)->first();
        $this->radniOdnosId = $radniOdnos->radni_odnosId;
        $this->oldRadniOdnosId = $this->radniOdnosId;
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
        DB::transaction(function(){
            $nUser = User::create($this->modelData());
            KorisnikRadniStatus::create([
                'korisnikId' => $nUser->id,
                'radni_statusId' => 1,
            ]);
            KorisnikRadniOdnos::create([
                'korisnikId' => $nUser->id,
                'radni_odnosId' => $this->radniOdnosId,
            ]);
        });
        $this->modalFormVisible = false;
        $this->reset();
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
        if($this->oldRadniOdnosId != $this->radniOdnosId){
            DB::transaction(function(){
               //prvo trenutna vrednost iz tabele
               $cuurent = KorisnikRadniOdnos::where('korisnikId', $this->modelId)->first();
               //zatim upis u history tabelu
               KorisnikRadniOdnosHistory::create(['korisnik_radni_odnosId' => $cuurent['id'], 'korisnikId' => $cuurent['korisnikId'], 'radni_odnosId' => $cuurent['radni_odnosId']]);
               //update trenutnog stanja
               KorisnikRadniOdnos::where('korisnikId', $this->modelId)->update(['radni_odnosId' => $this->radniOdnosId]);
            });
        }
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
        try {
            DB::transaction(function(){
                $user = User::find($this->modelId);
               
                UserHistory::create([
                    'korisnikId' => $this->modelId,
                    'pozicija_tipId' => $user->pozicija_tipId,
                    'lokacijaId'  => $user->lokacijaId,
                    'telegramId'  => $user->telegramId,
                    'tel'  => $user->tel,
                    'name'  => $user->name,
                    'email'  => $user->email,
                    'email_verified_at'  => $user->email_verified_at,
                    'password'  => $user->password,
                    'remember_token'  => $user->remember_token,
                    'current_team_id'  => $user->current_team_id,
                    'profile_photo_path'  => $user->profile_photo_path,
                ]);
               
                KorisnikRadniOdnos::where('korisnikId', $this->modelId)->delete();
                KorisnikRadniStatus::where('korisnikId', $this->modelId)->delete();
                User::destroy($this->modelId);
            });
        } catch (\Throwable $th) {
            abort(403, 'Unauthorized action.');
        }
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
        $this->name = User::find($this->modelId)->name;
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