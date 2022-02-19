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
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $sortBy = 'updated_at';
    public $sortDirection = 'desc';
    public $perhal = 2 ;
    public $checked = [];
    public $inpsearch = "";
    public $selectPage = false;
    public $selectAll = false;
    public $modeEdit=false;
    public $user_id=[];
    public $states=[];
    public $old_user_password;

    //lifecylce hook get<namafungsi>Property
    public function getUserProperty(){
        return $this->UserQuery->paginate($this->perhal);
    }
    //lifecylce hook get<namafungsi>Property
    public function getUserQueryProperty(){
        $user = User::query();
        $user->select('users.*','roles.name as roles_name');
        $user->leftJoin('model_has_roles','model_has_roles.model_id','=','users.id');
        $user->join('roles','roles.id','=','model_has_roles.role_id');
        $user->where('users.name','like','%'.$this->inpsearch.'%');
        $user->orwhere('users.email','like','%'.$this->inpsearch.'%');
        $user->orwhereHas('roles', function($q) {
            $q->where('name', 'like', '%'.$this->inpsearch.'%');
        });
        if($this->sortBy=="name"){
            $user->orderby('users.name',$this->sortDirection);
        }else if($this->sortBy=="email"){
            $user->orderby('users.email',$this->sortDirection);
        }else if($this->sortBy=='updated_at'){
            $user->orderby('users.updated_at',$this->sortDirection);
        }else if($this->sortBy=='roles'){
            $user->orderby('roles.name',$this->sortDirection);
        }         
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
    //remove from selection
    public function removeselection()
    {
        $this->user_id = $this->checked;
        $this->dispatchBrowserEvent('show-form-del');
    }
    //remove from single
    public function removesingle($id){
        $this->user_id = [$id];
        $this->dispatchBrowserEvent('show-form-del');
    }

    //proses remove
    public function delete()
    {
        $user = User::whereIn('id',$this->user_id);
        foreach($this->user_id as $path){
            Storage::disk('public')->deleteDirectory('myfiles/'.$path);
        }
        $user->delete();
        
        $this->selectPage=false;
        $this->checked = array_diff($this->checked,$this->user_id );
        $this->resetCreateForm();
        $this->dispatchBrowserEvent('hide-form-del');
        $this->dispatchBrowserEvent('alert',[
            'type'=>'error',
            'message'=>'Data deleted successfully.'
        ]); 
    }

    //sorting
    public function sortBy($field)
    {
        if($this->sortDirection == 'asc'){
            $this->sortDirection = 'desc';
        }else{
            $this->sortDirection = 'asc';
        }
        return $this->sortBy = $field;
    }

    public function render()
    {
        $data['roles'] = Role::all();
        $data['users']=$this->User;
        $data['delsel']=User::find($this->user_id);
        return view('livewire.back.usermanage',$data)->layout('layouts.appclear');
    }
    
    //reset form
    private function resetCreateForm(){
        $this->modeEdit=false;
        $this->user_id = [];
        $this->states['name'] = '';
        $this->states['email'] = '';
        $this->states['password'] = '';
        $this->states['password_confirmation'] = '';
        $this->states['role'] = '';
        $this->resetErrorBag();
        $this->resetValidation();
    }

    //add single
    public function add()
    {
        $this->modeEdit=false;
        $this->dispatchBrowserEvent('show-form');
        $this->resetCreateForm();
    }

    //store add/edit single
    public function store()
    {
        $ids=collect($this->user_id)->implode(',');
        if(!$this->modeEdit){ 
            Validator::make($this->states,[
                'name' => 'required',
                'email' => [
                    'required','email',
                    Rule::unique('users')->ignore($ids),
                ],
                'password' => 'required|min:8|confirmed',
                'role' => 'required',
            ])->validate();

        }else{
            Validator::make($this->states,[
                'name' => 'required',
                'email' => [
                    'required','email',
                    Rule::unique('users')->ignore($ids),
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
        $user=User::updateOrCreate(['id' => $ids], [
            'name' => $this->states['name'],
            'email' => $this->states['email'],
            'password' => $password,
        ]);
        $user->syncRoles($this->states['role']);
        $this->dispatchBrowserEvent('hide-form');
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>$this->user_id ? 'Data updated successfully.' : 'Data added successfully.'
        ]);
        $this->resetCreateForm();
    }
    
    //edit single
    public function edit($id)
    {
        $this->modeEdit=true;
        $user = User::findOrFail($id);
        $this->user_id = [$id];
        $this->states['name'] = $user->name;
        $this->states['email'] = $user->email;
        $this->states['password'] = '';
        $this->states['password_confirmation'] = '';
        $this->old_user_password = $user->password;
        $this->states['role'] = $user->roles->pluck('name')->implode(', ');
        $this->dispatchBrowserEvent('show-form');
    }

    //edit multisel
    public function editselection()
    {
        $this->modeEdit=true;
        $this->user_id = $this->checked;
        $this->states['password'] = '';
        $this->states['password_confirmation'] = '';
        $this->states['role'] = '';
        $this->dispatchBrowserEvent('show-form-multiedit');
    }

    public function storeupdatesel(){
        
        Validator::make($this->states,[
            'password' => 'nullable|min:8|confirmed',
            'role' => 'nullable',
        ])->validate();

        $users = User::WhereIn('id',$this->user_id);
        
        if(!empty($this->states['role'])) {
            $users->each(function($q) {
                $q->syncRoles($this->states['role']);
            });
        }

        if(!empty($this->states['password'])) {
            $password=Hash::make($this->states['password']);
            $users->update(['password' => $password]);
        }

        if(empty($this->states['password']) && empty($this->states['role'])){
            $this->dispatchBrowserEvent('hide-form-multiedit');
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>'Data updated failed.'
            ]);
        }else{
            $this->dispatchBrowserEvent('hide-form-multiedit');
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>'Data updated successfully.'
            ]);
        }
        
        $this->resetCreateForm();
        
    }
    
    
}
