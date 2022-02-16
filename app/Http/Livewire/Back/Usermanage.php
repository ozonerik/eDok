<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Collection;

class Usermanage extends Component
{
    public $modeEdit=false;
    public $user_id,$user_name;
    public $states=[];
    public $old_user_password;
    public $delfolder='';
    public $checked=[];
    public $checkedValue;

    public function render()
    {
        $data['roles'] = Role::all();
        $user = User::orderBy('name', 'desc')->get();
        $data['users']=$user;
        return view('livewire.back.usermanage',$data)->layout('layouts.app');
    }
    public function updatedsub_check($value){
        dd('hallo');
    }
    
    private function resetCreateForm(){
        $this->modeEdit=false;
        $this->user_id = null;
        $this->states['name'] = '';
        $this->states['email'] = '';
        $this->states['password'] = '';
        $this->states['password_confirmation'] = '';
        $this->states['role'] = '';
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function add()
    {
        $this->modeEdit=false;
        $this->dispatchBrowserEvent('show-form');
        $this->resetCreateForm();
    }
    
    public function remove($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->user_name = $user->name;
        $this->delfolder='myfiles/'.$user->id;
        $this->dispatchBrowserEvent('show-form-del');
    }

    public function removesel()
    {
        $this->checkedValue = User::whereIn('id',$this->checked)->get();
        $this->dispatchBrowserEvent('show-form-delsel');
    }

    public function postremovesel()
    {
        User::whereIn('id',$this->checked)->delete();
        $this->dispatchBrowserEvent('hide-form-delsel');
        return redirect()->route('userman');
    }

    public function store()
    {
        if(!$this->modeEdit){ 
            Validator::make($this->states,[
                'name' => 'required',
                'email' => [
                    'required','email',
                    Rule::unique('users')->ignore($this->user_id),
                ],
                'password' => 'required|min:8|confirmed',
                'role' => 'required',
            ])->validate();
        }else{
            Validator::make($this->states,[
                'name' => 'required',
                'email' => [
                    'required','email',
                    Rule::unique('users')->ignore($this->user_id),
                ],
                'password' => 'nullable|min:8|confirmed',
                'role' => 'required',
            ])->validate();
        }

        if(!empty($this->states['password'])) {
            $password=Hash::make($this->states['password']);
        } else {
            $password=$this->old_user_password;
        }
        $user=User::updateOrCreate(['id' => $this->user_id], [
            'name' => $this->states['name'],
            'email' => $this->states['email'],
            'password' => $password,
        ]);
        $user->assignRole($this->states['role']);
        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>$this->user_id ? 'Data updated successfully.' : 'Data added successfully.'
        ]);
        $this->resetCreateForm();
        return redirect()->route('userman');
    }
    
    public function edit($id)
    {
        $this->modeEdit=true;
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->states['name'] = $user->name;
        $this->states['email'] = $user->email;
        $this->states['password'] = '';
        $this->states['password_confirmation'] = '';
        $this->old_user_password = $user->password;
        $this->states['role'] = $user->roles->pluck('name')->implode(', ');
        $this->dispatchBrowserEvent('show-form');
    }
    
    public function delete($id)
    {
        User::find($id)->delete();
        Storage::disk('local')->deleteDirectory($this->delfolder);
        $this->dispatchBrowserEvent('alert',[
            'type'=>'error',
            'message'=>'Data deleted successfully.'
        ]);
        $this->dispatchBrowserEvent('hide-form-del');
        $this->resetCreateForm();
        return redirect()->route('userman');
    }
}
