<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use App\Models\Myfile;

class Dashboard extends Component
{
    public function getJumFileUserProperty(){
        $myfile = Myfile::query();
        $myfile->join('users','myfiles.user_id','=','users.id');
        $myfile->groupBy('username');
        $myfile->selectRaw('count(*) as jumfile, users.name as username');
        $myfile->orderby('jumfile','desc');
        
        return $myfile;
    }
    public function render()
    {
        $data['labeluser']=$this->JumFileUser->take(5)->get()->pluck('username')->toArray();
        $data['datauser']=$this->JumFileUser->take(5)->get()->pluck('jumfile')->toArray();
        return view('livewire.back.dashboard',$data)->layout('layouts.app');
    }
}
