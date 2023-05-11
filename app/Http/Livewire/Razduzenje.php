<?php

namespace App\Http\Livewire;

use App\Models\LicencaMesec;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Config;

class Razduzenje extends Component
{
    use WithPagination;
    

    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return LicencaMesec::selectRaw(
                                'licenca_mesecs.*, 
                                COUNT(licenca_distributer_mesecs.distributerId) as distCount, 
                                SUM(licenca_distributer_mesecs.sum_zaduzeno) as sumZaduzeno, 
                                COUNT(licenca_distributer_mesecs.sum_razaduzeno) as distRazduzeni, 
                                SUM(licenca_distributer_mesecs.sum_razaduzeno) as sumRazduzeno')
            ->leftJoin('licenca_distributer_mesecs', 'licenca_distributer_mesecs.mesecId', '=', 'licenca_mesecs.id' )
            ->groupBy('licenca_distributer_mesecs.mesecId')
            ->orderBy('licenca_mesecs.mesec_datum', 'DESC')
            ->paginate(Config::get('global.paginate'));
    }



    public function render()
    {
        return view('livewire.razduzenje', [
            'data' => $this->read(),
        ]);
    }
}