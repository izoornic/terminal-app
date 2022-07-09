<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public $too = 50;

    public function render()
    {
        return view('livewire.dashboard');
    }
}
