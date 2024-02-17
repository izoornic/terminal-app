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


class ZaduzenjeDistributeri extends Component
{
    use WithPagination;

    /**
     * Put your custom public properties here!
     */
    public $mid;
    public $mesec_info;

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

    //public function 
    //->leftJoin('licenca_naplatas', 'licenca_naplatas.distributerId', '=','licenca_distributer_tips.id') COUNT(licenca_naplatas.distributerId) as distCount
                //->where('licenca_naplatas.licenca_dist_terminalId', '>', 0)
                                //->groupBy('licenca_naplatas.distributerId')

    public function read()
    {
        $dataPage =  DB::select('SELECT licenca_distributer_tips.*, lic_naplata.broj_zaduzenih_licenci, ldm.sum_zaduzeno, ldm.datum_zaduzenja, ldm.sum_razaduzeno, ldm.datum_razaduzenja
                                FROM licenca_distributer_tips 
                                LEFT JOIN(SELECT distributerId, COUNT(id) as broj_zaduzenih_licenci 
                                    FROM licenca_naplatas WHERE zaduzeno IS NULL 
                                    GROUP BY distributerId) AS lic_naplata 
                                    ON licenca_distributer_tips.id = lic_naplata.distributerId
                                LEFT JOIN licenca_distributer_mesecs AS ldm 
                                    ON licenca_distributer_tips.id = ldm.distributerId AND ldm.mesecId ='. $this->mid);
        
        return PaginationHelper::paginateArray($dataPage, Config::get('global.paginate'));
    }

    /**
     * The read function.
     *
     * @return void
     */
    public function read_()
    {
        return LicencaDistributerTip::select(
                        'licenca_distributer_tips.*', 
                        'licenca_distributer_mesecs.sum_zaduzeno', 
                        'licenca_distributer_mesecs.datum_zaduzenja',
                        'licenca_distributer_mesecs.sum_razaduzeno', 
                        'licenca_distributer_mesecs.datum_razaduzenja',
                        'licenca_distributer_mesecs.id as ldmid'
                )
                ->leftJoin('licenca_distributer_mesecs', function($join)
                    {
                        $join->on('licenca_distributer_tips.id', '=', 'licenca_distributer_mesecs.distributerId');
                        $join->on('licenca_distributer_mesecs.mesecId', '=', DB::raw($this->mid));
                    })
                ->where('licenca_distributer_tips.distributer_naziv', 'like', '%'.$this->searchDistName.'%')
                ->where('licenca_distributer_tips.distributer_mesto', 'like', '%'.$this->searchMesto.'%')
                ->when($this->searchZaduzen == 1, function ($rtval){
                    return $rtval->where('licenca_distributer_mesecs.sum_zaduzeno', '>', 0);
                } )
                ->when($this->searchZaduzen == 2, function ($rtval){
                    return $rtval->whereNull('licenca_distributer_mesecs.sum_zaduzeno');
                } )
                ->paginate(Config::get('global.paginate'));
    }

    private function distInfo($did)
    {
        return LicencaDistributerTip::where('id', '=', $did)->first();
    }

    public function deleteShowModal($d_id, $lmdid)
    {
        $this->isError = false;
        $this->dist_id = $d_id;
        $this->lmd_id = $lmdid;
        $this->dist_info = $this->distInfo($this->dist_id);
        $this->deleteModalVisible = true;
    }

    public function delete()
    {
        $zaduzenje_row = LicencaDistributerMesec::where('id', '=', $this->lmd_id)->first();
        //dd($zaduzenje_row);
        if(!$this->lmd_id || $zaduzenje_row->sum_razaduzeno > 0){
            $this->isError = true;
            return;
        }
        DB::transaction(function(){
            LicencaDistributerMesec::destroy($this->lmd_id);
            LicencaNaplata::where('distributerId', '=', $this->dist_id)
                            ->where('mesecId', '=', $this->mid)
                            ->delete();
        });

    }

    public function render()
    {
        return view('livewire.zaduzenje-distributeri', [
            'data' => $this->read(),
        ]);
    }
}