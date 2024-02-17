<?php

namespace App\Http\Livewire;

use App\Models\User;

use App\Models\Lokacija;
use App\Models\TerminalLokacija;
use App\Models\LicencaDistributerTip;
use App\Models\DistributerLokacijaIndex;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use Livewire\Component;
use Livewire\WithPagination;

class DistributerLokacija extends Component
{
    use WithPagination;

    public $distId;
    public $dist_name;

    //Dodaj lokaciju modal
    public $modalAddLocVisible;
    public $plokacija;
    public $searchPLokacijaNaziv;
    public $searchPlokacijaMesto;
    public $searchPlokacijaRegion;

    //brisanje lokacije
    public $modalDeleteLocVisible;
    public $l_naziv;
    public $delete_error;
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
     * [Description for createShowModal]
     *
     * @return void
     * 
     */
    public function createShowModal()
    {
        $this->plokacija = null;
       $this->modalAddLocVisible = true;
    }

    /**
     * Puni tabelu u modalu iz koje se bira lokacija
     *
     * @param mixed $tipId
     * 
     * @return [type]
     * 
     */
    public function lokacijeTipa($tipId=4)
    {
        return Lokacija::select('lokacijas.*', 'regions.r_naziv')
            ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
            ->whereNotIn('lokacijas.id', function ($q) {
                return $q->select('lokacijaId')->from('distributer_lokacija_indices');
                //->where('licenca_distributer_tipsId', '=', $this->distId );
            })
            ->where('lokacija_tipId', '=', $tipId)
            ->where('l_naziv', 'like', '%'.$this->searchPLokacijaNaziv.'%')
            ->where('mesto', 'like', '%'.$this->searchPlokacijaMesto.'%')
            ->where('lokacijas.regionId', ($this->searchPlokacijaRegion > 0) ? '=' : '<>', $this->searchPlokacijaRegion)
            ->paginate(Config::get('global.modal_search'), ['*'], 'loc');
    }

     /**
     * Prikazuje naziv lokacije na koju se premesta terminal
     *
     * @return void
     */
    public function novaLokacija()
    {
        return Lokacija::select('lokacijas.*', 'regions.r_naziv')
            ->leftJoin('lokacija_tips', 'lokacijas.lokacija_tipId', '=', 'lokacija_tips.id')
            ->leftJoin('regions', 'lokacijas.regionId', '=', 'regions.id')
            ->where('lokacijas.id', '=', $this->plokacija)
            ->first();
    }

    public function create()
    {
        DB::transaction(function(){

            DistributerLokacijaIndex::create([
                'lokacijaId' => $this->plokacija,
                'licenca_distributer_tipsId' => $this->distId
            ]);

            LicencaDistributerTip::find($this->distId)->increment('broj_lokacija');
        });
        $this->modalAddLocVisible = false;
    }
    // Customer::find($customer_id)->decrement('loyalty_points', 50);

    /**
     * Otvara modal ya brisanje lokacije
     *
     * @return [type]
     * 
     */
    public function deleteShowModal($id, $naziv)
    {
        $this->delete_error = [];
        //dd($id, $naziv);
        $this->modelId = $id;
        $this->l_naziv = $naziv;
        //
        if(User::where('lokacijaId', '=', $this->modelId)->where('pozicija_tipId', '=', '8')->first()){
            $this->delete_error[0] = 'Jedan ili više korisnika je povezano sa lokacijom koju želite da uklonite. Korisnici se moraju obrisati pre nego što se lokacija odvoji od Distributera!';  
        }
        if(TerminalLokacija::where('lokacijaId', '=', $this->modelId)->where('distributerId', '=', $this->distId)->first() ){
            array_push($this->delete_error,  'Jedan ili više treminala je povezano sa lokacijom koju želite da uklonite. Terminali se moraju premestiti pre nego što se lokacija odvoji od Distributera!'); 
        }
        
        $this->modalDeleteLocVisible = true;
    }

    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return DistributerLokacijaIndex::select('lokacijas.*', 'regions.r_naziv')
            ->leftJoin('lokacijas', 'lokacijas.id', '=', 'distributer_lokacija_indices.lokacijaId')
            ->leftJoin('regions', 'regions.id', '=', 'lokacijas.regionId')
            ->where('distributer_lokacija_indices.licenca_distributer_tipsId', '=', $this->distId)
            ->paginate(Config::get('global.paginate'), ['*'], 'lokacije'); 
    }

    public function render()
    {
        return view('livewire.distributer-lokacija', [
            'data' => $this->read(),
        ]);
    }
}
