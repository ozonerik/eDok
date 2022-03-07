<?php

namespace App\Http\Livewire\Comp;

use Livewire\Component;
use App\Models\Sendfile;
use Illuminate\Support\Facades\Auth;

class Getnotread extends Component
{

    protected $listeners = ['refreshnotread' => '$refresh'];

    public function render()
    {
        $data['notread']=Sendfile::where('receiveuser_id',Auth::user()->id)->where('is_read',false)->count();
        return view('livewire.comp.getnotread',$data);
    }
}
