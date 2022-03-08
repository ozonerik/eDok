<?php

namespace App\Http\Livewire\Front;

use Livewire\Component;

class Download extends Component
{
    public function render()
    {
        return view('livewire.front.download')->layout('layouts.home');
    }
}
