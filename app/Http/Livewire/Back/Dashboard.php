<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use App\Models\Myfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $pilihtahun,$labelbln,$databln;

    public function mount(){
        $this->pilihtahun = Carbon::now()->format('Y');
        $this->labelbln=array_column(get_bulan($this->JumFileBln->get()->where('tahun', $this->pilihtahun ) ),"bulan");
        $this->databln=array_column(get_bulan($this->JumFileBln->get()->where('tahun', $this->pilihtahun ) ),"jumfile");
    }

    public function changetahun(){
        $this->labelbln=array_column(get_bulan($this->JumFileBln->get()->where('tahun', $this->pilihtahun ) ),"bulan");
        $this->databln=array_column(get_bulan($this->JumFileBln->get()->where('tahun', $this->pilihtahun ) ),"jumfile");
        $this->dispatchBrowserEvent('update-tahun');
    }
    public function getJumFileUserProperty(){
        $myfile = Myfile::query();
        $myfile->join('users','myfiles.user_id','=','users.id');
        $myfile->groupBy('username');
        $myfile->select(DB::raw('count(*) as jumfile'),'users.name as username');
        $myfile->orderby('jumfile','desc');
        return $myfile;
    }
    public function getJumFileBlnProperty(){
        $myfile = Myfile::query();
        $myfile->select(
            DB::raw('DATE_FORMAT(created_at, "%m") as bulan'),
            DB::raw('DATE_FORMAT(created_at, "%Y") as tahun'),
            DB::raw('count(*) as jumfile'));
        $myfile->groupBy('tahun','bulan');
        $myfile->orderby('tahun','desc');
        $myfile->orderby('bulan','asc');
        return $myfile;
    }
    public function render()
    {
        $data['labeluser']=$this->JumFileUser->take(5)->get()->pluck('username')->toArray();
        $data['datauser']=$this->JumFileUser->take(5)->get()->pluck('jumfile')->toArray();
        //$data['chartbln']=Carbon::now()->format('Y');
        
        return view('livewire.back.dashboard',$data)->layout('layouts.app');
    }
}
