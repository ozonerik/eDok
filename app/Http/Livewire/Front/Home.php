<?php

namespace App\Http\Livewire\Front;

use Livewire\Component;
use App\Models\Myfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Home extends Component
{
    public $pilihtahun,$labelbln,$databln;
    
    public function mount(){
        $this->pilihtahun = Carbon::now()->format('Y');
        $this->labelbln=array_column(get_bulan($this->JumFileBln->get()->where('tahun', $this->pilihtahun ) ),"bulan");
        $this->databln=array_column(get_bulan($this->JumFileBln->get()->where('tahun', $this->pilihtahun ) ),"jumfile");
    }
    public function changetahun(){
        //dd('hallo');
        $this->labelbln=array_column(get_bulan($this->JumFileBln->get()->where('tahun', $this->pilihtahun ) ),"bulan");
        $this->databln=array_column(get_bulan($this->JumFileBln->get()->where('tahun', $this->pilihtahun ) ),"jumfile");
        $this->dispatchBrowserEvent('update-tahun');
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
        return view('livewire.front.home')->layout('layouts.home');
    }
}
