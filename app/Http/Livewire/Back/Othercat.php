<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Filecategory;

class Othercat extends Component
{
    public $modeEdit=false;
    public $category_id,$category_name,$by;
    public $delfolder='';

    public function remove($id)
    {
        $this->modeEdit=false;
        $filecategory = Filecategory::with(['user'])->findOrFail($id);
        $this->category_id = $id;
        $this->category_name = $filecategory->name;
        $this->by = $filecategory->user->name;
        $this->delfolder='myfiles/'.$filecategory->user_id.'/'.$filecategory->id;
        $this->dispatchBrowserEvent('show-form-del');
    }
    public function delete($id)
    {
        Filecategory::find($id)->delete();
        Storage::disk('local')->deleteDirectory($this->delfolder);
        $this->dispatchBrowserEvent('alert',[
            'type'=>'error',
            'message'=>'Data deleted successfully.'
        ]);
        $this->dispatchBrowserEvent('hide-form-del');
        return redirect()->route('othercat');
    }

    public function render()
    {
        $catUser = Filecategory::orderBy('updated_at', 'desc')->get();
        $data['myfilecat']=$catUser;
        $data['auth_id']=Auth::user()->id;
        return view('livewire.back.othercat',$data)->layout('layouts.app');
    }
}
