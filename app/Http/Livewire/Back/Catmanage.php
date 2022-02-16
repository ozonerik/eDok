<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Filecategory;

class Catmanage extends Component
{
    public $modeEdit=false;
    public $states=[];
    public $category_id,$category_name,$by;
    public $delfolder='';

    private function resetCreateForm(){
        $this->modeEdit=false;
        $this->states['name'] = '';
        $this->states['is_public'] = '';
        $this->resetErrorBag();
        $this->resetValidation();
    }
    
    public function remove($id)
    {
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
        $this->resetCreateForm();
        return redirect()->route('mycatman');
    }
    public function add()
    {
        $this->modeEdit=false;
        $this->dispatchBrowserEvent('show-form');
        $this->resetCreateForm();
    }
    public function edit($id)
    {
        $this->modeEdit=true;
        $filecategory = Filecategory::findOrFail($id);
        $this->category_id = $id;
        $this->states['name'] = $filecategory->name;
        $this->states['is_public'] = $filecategory->is_public;
        $this->dispatchBrowserEvent('show-form');
    }
    public function store()
    {
        Validator::make($this->states,[
            'name' => 'required',
            'is_public' => 'required',
        ])->validate();

        if(!empty($this->states['is_public'])) {
            $is_public=$this->states['is_public'];
        } else {
            $is_public=false;
        }
        Filecategory::updateOrCreate(['id' => $this->category_id], [
            'name' => $this->states['name'],
            'is_public' => $is_public,
            'user_id' => Auth::user()->id
        ]);
        $this->dispatchBrowserEvent('hide-form');       
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>$this->category_id ? 'Data updated successfully.' : 'Data added successfully.'
        ]);
        $this->resetCreateForm();
        return redirect()->route('mycatman');
    }

    public function render()
    {
        $catUser = Filecategory::where('user_id',Auth::user()->id)
        ->orderBy('updated_at', 'desc')
        ->get();
        $data['myfilecat']=$catUser;
        return view('livewire.back.catmanage',$data)->layout('layouts.app');
    }
}
