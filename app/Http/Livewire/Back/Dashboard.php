<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.back.dashboard')->layout('layouts.app');
    }
}
