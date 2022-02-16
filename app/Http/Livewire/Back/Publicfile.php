<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use App\Models\Myfile;
use App\Models\Filecategory;
use Carbon\Carbon;

class Publicfile extends Component
{

    public function export($id){
        //dd('ini export '.$id);
        $date=Carbon::now()->format('Y-m-d');
        $myfile = Myfile::with(['user'])->findOrFail($id);
        $url=$myfile->path;
        $rename=$myfile->name." (".$myfile->user->name.") (".$date.").pdf";
        $headers = ['Content-Type: application/pdf'];
        return response()->download(storage_path('app/'.$url),$rename,$headers);
    }
    public function render()
    {
        $publicfile = Myfile::whereRelation('filecategory', 'is_public', true)
        ->orWhere('is_public',true)
        ->orderBy('updated_at', 'desc')
        ->get();
        $data['publicfile']=$publicfile;
        return view('livewire.back.publicfile',$data)->layout('layouts.app');
    }
}
