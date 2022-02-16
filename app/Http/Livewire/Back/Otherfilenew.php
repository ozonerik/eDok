<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Myfile;
use Carbon\Carbon;

class Otherfilenew extends Component
{
    public $modeEdit=false;
    public $myfile_id,$file_name,$file_path,$by;
    public $delfolder='';

    public function remove($id)
    {
        $this->modeEdit=false;
        $myfile = Myfile::with(['user','filecategory'])->findOrFail($id);
        $this->myfile_id = $id;
        $this->file_name = $myfile->name;
        $this->file_path = $myfile->path;
        $this->by = $myfile->user->name;
        $this->dispatchBrowserEvent('show-form-del');
    }
    private function deletefile($pathfile){
        if(Storage::disk('local')->exists($pathfile)){
            Storage::disk('local')->delete($pathfile);
        }
    }
    public function delete($id)
    {
        $this->deletefile($this->file_path);
        Myfile::find($id)->delete();
        $this->dispatchBrowserEvent('alert',[
            'type'=>'error',
            'message'=>'Data deleted successfully.'
        ]);
        $this->dispatchBrowserEvent('hide-form-del');
        return redirect()->route('otherfile');
    }
    public function export($id){
        $date=Carbon::now()->format('Y-m-d');
        $myfile = Myfile::with(['user','filecategory'])->findOrFail($id);
        $path=$myfile->path;
        $rename=$myfile->name." (".$myfile->user->name.") (".$date.").pdf";
        $headers = ['Content-Type: application/pdf'];
        return response()->download(storage_path('app/'.$path),$rename,$headers);
    }
    public function render()
    {
        $myfile = Myfile::orderBy('updated_at', 'desc')
        ->get();
        $data['myfile']=$myfile;
        $data['auth_id']=Auth::user()->id;
        return view('livewire.back.otherfilenew',$data)->layout('layouts.app');
    }
}
