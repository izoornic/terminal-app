<?php

namespace App\Http\Livewire;

use App\Models\LicencaNaplata;
use App\Models\LicencaDistributerTip;
use App\Models\LicencaDistributerMesec;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class RazduzenjeDistributeri extends Component
{
    use WithPagination;
    
   /**
     * Put your custom public properties here!
     */
    public $mid;
    public $zaduzeni_distributeri;
    public $razduzeni_distributeri;

    //SEARCH
    public $searchDistName;
    public $searchMesto;
    public $searchZaduzen;

     /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->mid = request()->query('id');
    }

    /**
     * The read function.
     *
     * @return void
     */
    public function read()
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
                return $rtval->where('licenca_distributer_mesecs.sum_razaduzeno', '>', 0);
            } )
            ->when($this->searchZaduzen == 2, function ($rtval){
                return $rtval->whereNull('licenca_distributer_mesecs.sum_razaduzeno');
            } )
            ->paginate(Config::get('global.paginate'));
    }


    public function render()
    {
        return view('livewire.razduzenje-distributeri', [
            'data' => $this->read(),
        ]);
    }
}