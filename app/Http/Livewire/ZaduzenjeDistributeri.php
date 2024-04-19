<?php

namespace App\Http\Livewire;

use App\Models\LicencaMesec;
use App\Models\LicencaNaplata;
use App\Models\LicencaDistributerTip;
use App\Models\LicencaDistributerMesec;

use App\Http\Helpers;
use App\Helpers\PaginationHelper;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Collection;


class ZaduzenjeDistributeri extends Component
{
    use WithPagination;

    /**
     * Put your custom public properties here!
     */
    public $mid;
    public $mesec_info;

    public $dataAll;

    //SEARCH
    public $searchDistName;
    public $searchMesto;
    public $searchZaduzen;

    //delete zaduzenje
    public $dist_id;
    public $dist_info;
    public $deleteModalVisible;
    public $isError;
    public $lmd_id;

    /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->mid = request()->query('id');
        $this->mesec_info = LicencaMesec::find($this->mid)->first();
    }

    public function read()
    {
        $this->prepareData();
        return PaginationHelper::paginate($this->displayData(), Config::get('global.paginate'));
    }

    public function prepareData()
    {
        $this->dataAll =  collect(DB::select('SELECT     licenca_distributer_tips.*, 
                                            lic_naplata.broj_zaduzenih_licenci, 
                                            ldm.sum_zaduzeno, 
                                            ldm.datum_zaduzenja, 
                                            ldm.sum_razaduzeno, 
                                            ldm.datum_razaduzenja
                                FROM licenca_distributer_tips 
                                LEFT JOIN(SELECT distributerId, COUNT(id) as broj_zaduzenih_licenci 
                                    FROM licenca_naplatas WHERE zaduzeno IS NULL 
                                    GROUP BY distributerId) AS lic_naplata 
                                    ON licenca_distributer_tips.id = lic_naplata.distributerId
                                LEFT JOIN licenca_distributer_mesecs AS ldm 
                                    ON licenca_distributer_tips.id = ldm.distributerId AND ldm.mesecId ='. $this->mid));
        
        //return PaginationHelper::paginateArray($dataPage, Config::get('global.paginate'));
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
            return $this->filterFields($value->distributer_naziv, $value->distributer_mesto, $value->sum_zaduzeno);
        });

        return $retval;
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
   
    private function filterFields($naziv, $mesto, $zaduzeno)
    {
        $filter_naziv = ($this->searchDistName != '') ? true : false;
        $filter_adresa = ($this->searchMesto != '') ? true : false;
        $filter_zaduzeno = ($this->searchZaduzen > 0) ? true : false;

        $naziv_retval = true;
        $mest_retval = true;
        $zaduzen_retval = true;
        
        if($filter_naziv){
            $naziv_retval = preg_match("/".$this->searchDistName."/i", $naziv);
        }
        if($filter_adresa){
            $mest_retval = preg_match("/".$this->searchMesto."/i", $mesto);
        }
        if($filter_zaduzeno){
            $zaduzenje = (isset($zaduzeno)) ? true : false;
            $zaduzen_retval = ($this->searchZaduzen == 1) ? $zaduzenje : !$zaduzenje;
        }

        return ($naziv_retval && $mest_retval &&  $zaduzen_retval) ? true : false;
    }

    private function distInfo($did)
    {
        return LicencaDistributerTip::where('id', '=', $did)->first();
    }

    public function deleteZaduzenjeShowModal($d_id, $mid)
    {
        $this->isError = false;
        $this->dist_id = $d_id;
        $this->lmd_id = $mid;
        $this->dist_info = $this->distInfo($this->dist_id);
        $this->deleteModalVisible = true;
    }

    public function delete()
    {
        DB::transaction(function(){
            LicencaDistributerMesec::where('distributerId', '=', $this->dist_id)
                                    ->where('mesecId', '=', $this->lmd_id)
                                    ->delete();
            LicencaNaplata::where('distributerId', '=', $this->dist_id)
                        ->where('mesecId', '=', $this->lmd_id)
                        ->whereNotNull('zaduzeno')
                        ->update(['zaduzeno' => null, 'datum_zaduzenja' => null, 'mesecId' => null]);
        });
        $this->deleteModalVisible = false;
    }

    public function render()
    {
        return view('livewire.zaduzenje-distributeri', [
            'data' => $this->read(),
        ]);
    }
}