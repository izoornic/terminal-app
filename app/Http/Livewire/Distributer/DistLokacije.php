<?php

namespace App\Http\Livewire\Distributer;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;
use App\Models\Lokacija;
use App\Models\TerminalLokacija;
use App\Models\DistributerUserIndex;
use App\Models\LokacijaKontaktOsoba;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use App\Helpers\PaginationHelper;

class DistLokacije extends Component
{
    use WithPagination;
    public $distId;

    public $dataAll; 

    //pretraga
    public $searchName;
    public $searchMesto;
    public $searchTip = 0;
    public $searchRegion = 0;
    public $searchPib;

    //dodaj update modal
    public $modalFormVisible;
    public $modelId;
    public $l_naziv;
    public $mesto;
    public $adresa;
    public $latitude;
    public $longitude;

    public $regionId;
    public $lokacija_tipId;
    public $pib;
    public $mb;

    public $nameKo;
    public $telKo;

    public $isUpdate;

    //kontakt osoba u prodavnici
    public $kontaktOsobaVisible;
    public $kontaktOsobaInfo;

    //delete or info modal
    public $deletePosible;
    public $modalConfirmDeleteVisible;

    //search PIB
    public $modalSearchPIBFormVisible;
    public $search_pib;
    public $search_pib_error;
    public $lokacija_row;
    public $nova_lokacija_postoji_u_bazi;

    public function mount()
    {
        $this->distId = DistributerUserIndex::select('licenca_distributer_tipsId')->where('userId', '=', auth()->user()->id)->first()->licenca_distributer_tipsId;
    }

    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        return [   
            'l_naziv' => 'required',  
            'regionId' => ['required', 'not_in:0'],
            'latitude' => ['regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', 'nullable'],             
            'longitude' => ['regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', 'nullable'],
            'pib' => ($this->isUpdate) ? ['digits_between:8,16'] : ['digits_between:8,16', 'unique:lokacijas'] 
        ];        
    }

    public function doajPostojecuLokacijuDistributeru()
    {
       // dd($this->lokacija_row);
        Lokacija::where('id', '=', $this->lokacija_row->id)->update(['distributerId' => $this->distId]);
        $this->modalSearchPIBFormVisible = false;
    }

    /**
     * Reset forme posle edita ili nove lokacije
     *
     * @return [type]
     * 
     */
    protected function loc_reset()
    {
        // Assign the variables here
        $this->modelId = 0;
        $this->l_naziv = '';
        $this->mesto = '';
        $this->adresa = '';
        $this->latitude = '';
        $this->longitude = '';

        $this->regionId = 0;
        $this->lokacija_tipId = 0;

        $this->nameKo = '';
        $this->telKo = '';
        //$this->pib = '';
        $this->mb = '';
    }

    /**
     * Pretrazi pib modal
     *
     * @return [type]
     * 
     */
    public function searchPIBShowModal()
    {
        $this->nova_lokacija_postoji_u_bazi = '';
        $this->search_pib = '';
        $this->search_pib_error = '';
        $this->modalSearchPIBFormVisible = true;
    }

    public function pib_search()
    {
        $this->nova_lokacija_postoji_u_bazi = false;
        //validate input ONLU DIGITS
        if(preg_match('/^[0-9]+$/', $this->search_pib)){
            $this->search_pib_error = 'Pib sadrži 9 cifara!';
            //DUZINA 9 karaktera
            if(strlen($this->search_pib) == 9){
                $this->lokacija_row = Lokacija::where('pib', '=', $this->search_pib)->first();
                $this->search_pib_error = '';

                if($this->lokacija_row){
                    $this->nova_lokacija_postoji_u_bazi = 'da';
                }else{
                    $this->nova_lokacija_postoji_u_bazi = 'ne';
                    $this->search_pib_error = 'Lokacija sa unetim PIB-om ne postoji u bazi.';
                }
            }
        }else{
            $this->search_pib_error = 'Pib sadrži samo brojeve!';
        }
    }

    public function novaLokacija()
    {
        $this->pib = $this->search_pib;
        $this->modalSearchPIBFormVisible = false;
        $this->createShowModal();
    }

     /**
     * Shows the create New lokacija modal
     *
     * @return void
     */
    public function createShowModal()
    {
        $this->isUpdate = false;
        $this->resetValidation();
        $this->loc_reset();
        $this->lokacija_tipId = 3;
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
        $this->isUpdate = true;
        $this->resetValidation();
        $this->loc_reset();
        $this->modelId = $id;
        $this->loadModel();

        $this->modalFormVisible = true;
    }

    /**
     * Loads the model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        $data = Lokacija::find($this->modelId);
        // Assign the variables here
        $this->l_naziv = $data->l_naziv;
        $this->mesto = $data->mesto;
        $this->adresa = $data->adresa;
        $this->latitude = $data->latitude;
        $this->longitude = $data->longitude;
        $this->pib = $data->pib;
        $this->mb = $data->mb;

        $this->regionId = $data->regionId;
        $this->lokacija_tipId = $data->lokacija_tipId;

        if($this->kontaktOsobaInfo = $this->kontaktOsobaGetInfo()){
            $this->nameKo = $this->kontaktOsobaInfo->name;
            $this->telKo  = ($this->kontaktOsobaInfo->tel) ? ltrim($this->kontaktOsobaInfo->tel, '+381') : '';
            //$this->telKo = $this->kontaktOsobaInfo->tel;
        }else{
            $this->nameKo = ''; 
            $this->telKo = '';
        }
    }

    /**
     * The create function.
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        $new_loc = Lokacija::create($this->modelData());
        if($this->lokacija_tipId == 3){
            if($this->nameKo != ''){
                //dd('Add new KO');
                $tell = ($this->telKo != '') ? '+381'.$this->telKo : '';
                LokacijaKontaktOsoba::create(['lokacijaId'=>$new_loc->id, 'name' => $this->nameKo, 'tel' => $tell]);
            }
        }
        $this->modalFormVisible = false;
        $this->loc_reset();
    }

    /**
     * The update function
     *
     * @return void
     */
    public function update()
    {
        //dd($this->nameKo);
        $this->validate();
        Lokacija::find($this->modelId)->update($this->modelData());

        if($this->lokacija_tipId == 3){
            $db_name = $this->kontaktOsobaInfo->name ?? '';
            $db_tel = $this->kontaktOsobaInfo->tel ?? '';
            $tell = ($this->telKo != '') ? '+381'.$this->telKo : '';
            if($this->nameKo != $db_name || $this->telKo != $db_tel ){
                LokacijaKontaktOsoba::updateOrCreate(
                    ['lokacijaId' => $this->modelId],
                    ['name' => $this->nameKo, 'tel' => $tell]
                );
            }
        }
        $this->modalFormVisible = false;
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
            'l_naziv'          => $this->l_naziv,
            'mesto'            => $this->mesto,
            'adresa'           => $this->adresa,
            'latitude'         => ($this->latitude == '') ? NULL : $this->latitude,
            'longitude'        => ($this->longitude == '') ? NULL : $this->longitude,
            'regionId'         => $this->regionId,
            'lokacija_tipId'   => $this->lokacija_tipId,
            'pib'              => $this->pib, 
            'mb'               => $this->mb, 
            'distributerId'    => $this->distId
        ];
    }

    /**
     * Prikazuje Kontakt osoba Modal
     *
     * @param  mixed $id
     * @return void
     */
    public function showKontaktOsobaModal($id)
    {
        $this->modelId = $id;
        $this->odabranaLokacija = $this->lokacijaInfo();
        $this->kontaktOsobaInfo = $this->kontaktOsobaGetInfo();

        $this->kontaktOsobaVisible = true;
    }

    private function kontaktOsobaGetInfo()
    {
        return LokacijaKontaktOsoba::where('lokacijaId', '=', $this->modelId)
                                ->first();
    }

    /**
     * lokacijaInfo
     *
     * @return object
     */
    private function lokacijaInfo()
    {
        return Lokacija::select('lokacijas.*', 'lokacija_tips.lt_naziv', 'regions.r_naziv')
        ->leftJoin('lokacija_tips', 'lokacijas.lokacija_tipId', '=', 'lokacija_tips.id')
        ->leftJoin('regions', 'regions.id', '=', 'lokacijas.regionId')
        ->where('lokacijas.id', '=', $this->modelId)
        ->first();
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
        $this->odabranaLokacija = $this->lokacijaInfo();
       
        $this->deletePosible = false;
        
        //check if lokacija zakacena za nekog
        $data = User::where('lokacijaId', $id)->first();
        if($data === NULL){
            $this->deletePosible = true;
        };//else if($data)

        //check if lokacija ima terminale 
        $this->brTerminala = TerminalLokacija::brojTerminalaNalokaciji($id);
        if($this->brTerminala){
            $this->deletePosible = false;
        };

        //prikazi terminale na lokaciji koja je korisnik
        
        if($this->odabranaLokacija->lokacija_tipId == 3){
            $this->terminaliList = $this->terminalsAtLocation();
        }

        $this->modalConfirmDeleteVisible = true;
    } 

    private function terminalsAtLocation()
    {
        return TerminalLokacija::select('terminal_status_tips.ts_naziv', 'terminals.sn', 'terminals.terminal_tipId', 'terminals.broj_kutije', 'terminal_lokacijas.blacklist', 'licenca_distributer_tips.distributer_naziv')
                ->leftJoin('terminals', 'terminal_lokacijas.terminalId', '=', 'terminals.id')
                ->leftJoin('terminal_status_tips', 'terminal_lokacijas.terminal_statusId', '=', 'terminal_status_tips.id')
                ->leftJoin('licenca_distributer_tips', 'terminal_lokacijas.distributerId', '=', 'licenca_distributer_tips.id')
                ->where('lokacijaId', $this->modelId )
                ->get();
    }
    
    /**
     * Lists all rows in all tables that use particular location
     *
     * @param  mixed $id
     * @return void
     */
    public function locationUsers($id)
    {
        $retval = [];
        $retval['users'] = [];
        foreach(User::where('lokacijaId', $id)->get() as $row){
            array_push($retval['users'], $row['name']);
        };
        //MORA DA SE UPDATUJE I FUNKCIJA deleteShowModal($id)
        if(TerminalLokacija::brojTerminalaNalokaciji($id)){
            $retval['terminal'] = [];
            array_push($retval['terminal'], TerminalLokacija::brojTerminalaNalokaciji($id));
        } 
        //dd($retval); 
       return $retval;
    }

    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        if($this->kontaktOsobaGetInfo()){
            LokacijaKontaktOsoba::where('lokacijaId', '=', $this->modelId)->delete();
        }
        Lokacija::destroy($this->modelId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }

    /**
     * Rucno napravljeni filteri na starnici
     *
     * @param mixed $sn
     * @param mixed $mesto
     * @param mixed $licenca
     * 
     * @return boolean
     * 
     */
    private function filterFields($naziv, $mesto, $region_id, $lokacija_tip, $pib)
    {
        $filter_naziv = ($this->searchName != '') ? true : false;
        $filter_mesto = ($this->searchMesto != '') ? true : false;
        $filter_region = ($this->searchRegion > 0) ? true : false;
        $filter_tip = ($this->searchTip > 0) ? true : false;
        $filter_pib = ($this->searchPib != '') ? true : false;

        $naziv_retval = true;
        $mest_retval = true;
        $region_retval = true;
        $tip_retval = true;
        $pib_retval = true;
        
        if($filter_naziv){
            $naziv_retval = preg_match("/".$this->searchName."/i", $naziv);
        }
        if($filter_mesto){
            $mest_retval = preg_match("/".$this->searchMesto."/i", $mesto);
        }
        if($filter_region){
            $region_retval = ($this->searchRegion == $region_id) ? true : false;
        }
        if($filter_tip){
            $tip_retval = ($this->searchTip == $lokacija_tip) ? true : false;
        }
        if($filter_pib){
            $pib_retval = preg_match("/".$this->searchPib."/i", $pib);
        }

        return ($naziv_retval && $mest_retval && $region_retval && $tip_retval && $pib_retval) ? true : false;
    }

    /**
     * Prikaz kolekcije sa filterima
     *
     * @return collection
     * 
     */
    public function displayData()
    {
        $retval = $this->dataAll->filter(function ($value, $key) {
            return $this->filterFields($value->l_naziv, $value->mesto, $value->regionId, $value->lokacija_tipId, $value->pib);
        });

        return $retval;
    }

     /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        $this->prepareData();
        return PaginationHelper::paginate($this->displayData(), Config::get('global.paginate'));
    }

   /**
     * Priprema podatke za prikaz.
     *
     * @return void
     */
    private function prepareData()
    {        
        $this->dataAll =  Lokacija::select('lokacijas.*', 'lokacija_tips.lt_naziv', 'regions.r_naziv', 'lokacija_kontakt_osobas.name as kontakt', 'lokacija_tips.id as tipid')
        ->leftJoin('regions', 'regions.id', '=', 'lokacijas.regionId')
        ->leftJoin('lokacija_tips', 'lokacijas.lokacija_tipId', '=', 'lokacija_tips.id')
        ->leftJoin('lokacija_kontakt_osobas', 'lokacijas.id', '=', 'lokacija_kontakt_osobas.lokacijaId')
        ->whereIn('lokacijas.id', function($q){
            $q->select('lokacijaId')
                ->from('terminal_lokacijas')
                ->where('terminal_lokacijas.distributerId', '=', $this->distId);
        })
        ->orWhere('lokacijas.distributerId', '=', $this->distId)
        ->get();
    }

    public function render()
    {
        return view('livewire.distributer.dist-lokacije', [
            'data' => $this->read(),
        ]);
    }
}
