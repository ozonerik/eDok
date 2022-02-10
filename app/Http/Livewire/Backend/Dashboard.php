<?php

namespace App\Http\Livewire\Backend;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Dashboard extends Component
{
    use LivewireAlert;
    public function submit()
    {
        $this->alert('success', 'Basic Alert');
    }
    public function render()
    {
        return view('livewire.backend.dashboard');
    }
}
