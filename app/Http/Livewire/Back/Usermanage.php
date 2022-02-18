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
use Livewire\WithPagination;

class Usermanage extends Component
{
    public $modeEdit=false;
    public $user_id,$user_name;
    public $states=[];
    public $old_user_password;
    public $delfolder='';
    public $checkedValue;

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $sortBy = 'updated_at';
    public $sortDirection = 'desc';
    public $perhal = 2 ;
    public $checked = [];
    public $inpsearch = "";
    public $selectPage = false;
    public $selectAll = false;

    //lifecylce hook get<namafungsi>Property
    public function getUserProperty(){
        return $this->UserQuery->paginate($this->perhal);
    }
    //lifecylce hook get<namafungsi>Property
    public function getUserQueryProperty(){
        $user = User::query();        
        return $user;
    }
    //lifecylce hook updated<namavariable>
    public function updatedSelectPage($value){
        if($value){
            $this->checked = $this->User->pluck('id')->map(fn($item) => (string) $item)->toArray();
        }else{
            $this->checked = [];
            $this->selectAll=false;
        }
    }
    //lifecylce hook updated<namavariable>
    public function updatedChecked($value){
        $this->selectPage=false;
        $this->selectAll=false;
    }
    //end lifecycle

    //store checked checkbox value to array
    public function is_checked($id){
        return in_array($id,$this->checked);
    }
    //select All
    public function selectAll(){
        $this->selectAll=true;
        if($this->selectAll){
            $this->checked = $this->UserQuery->pluck('id')->map(fn($item) => (string) $item)->toArray();
        }else{
            $this->checked = [];
        }
    }
    //deselect All
    public function deselectAll(){
        $this->selectAll=false;
        $this->selectPage=false;
        $this->checked = [];
    }

    public function render()
    {
        $data['roles'] = Role::all();
        $data['users']=$this->User;
        return view('livewire.back.usermanage',$data)->layout('layouts.appclear');
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
        Storage::disk('public')->deleteDirectory($this->delfolder);
        $this->dispatchBrowserEvent('alert',[
            'type'=>'error',
            'message'=>'Data deleted successfully.'
        ]);
        $this->dispatchBrowserEvent('hide-form-del');
        $this->resetCreateForm();
        return redirect()->route('userman');
    }
}
