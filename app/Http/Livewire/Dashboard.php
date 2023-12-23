<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public $too = 50;

    public function render()
    {
        //dd($userRole = auth()->user()->pozicija_tipId);
        return view('livewire.dashboard');
    }

    
}
