<?php

namespace App\Http\Livewire;

use App\Models\LicencaDistributerTip;
use App\Models\LicencaNaplata;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Config;

class ZaduzenjeDistributeri extends Component
{
    use WithPagination;

    /**
     * Put your custom public properties here!
     */
    public $mesecId;
    public $zaduzeni_distributeri;

    /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->mesecId = request()->query('id');
        $this->zaduzeni_distributeri = [];
       $z_distributeri = LicencaNaplata::where('mesecId', '=', $this->mesecId)
                                            ->distinct()
                                            ->pluck('distributerId');
        foreach($z_distributeri as $key => $val){
            array_push($this->zaduzeni_distributeri, $val);
        }
    }

    //public function 

    /**
     * The read function.
     *
     * @return void
     */
    public function read()
    {
        return LicencaDistributerTip::paginate(Config::get('global.paginate'));
    }

    public function render()
    {
        return view('livewire.zaduzenje-distributeri', [
            'data' => $this->read(),
        ]);
    }
}