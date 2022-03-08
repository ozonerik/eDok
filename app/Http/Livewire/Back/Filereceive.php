<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sendfile;
use App\Models\Myfile;
use Illuminate\Support\Facades\Auth;

class Filereceive extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $sortBy = 'updated_at';
    public $sortDirection = 'desc';
    public $perhal = 2 ;
    public $inpsearch = "";
    public $fileid = '';
    public $isread = '';

    public function is_read($val){
        $this->isread=$val;
    }
    public function reading($id){
        $received = Sendfile::find($id);
        $received->is_read = true;
        $this->fileid = $received->myfile_id;
        $received->save();
        $this->emitTo('comp.getnotread', 'refreshnotread');
        $this->dispatchBrowserEvent('show-form-receive');
    }
    //reset search
    public function resetSearch(){
        $this->inpsearch='';
    }

    //lifecylce hook get<namafungsi>Property
    public function getMyReceivedProperty(){
        return $this->MyReceivedQuery->paginate($this->perhal);
    }
    //lifecylce hook get<namafungsi>Property
    public function getMyReceivedQueryProperty(){
        $received = Sendfile::query();
        $received->select('sendfiles.*','myfiles.name as file_name','users.name as from_name');
        $received->join('users','users.id', '=', 'sendfiles.user_id');
        $received->join('myfiles','sendfiles.myfile_id','=','myfiles.id');        
        $received->where('receiveuser_id',Auth::user()->id);
        if($this->isread==='yes'){
            $received->where('is_read',true);
        }else if ($this->isread==='no'){
            $received->where('is_read',false);
        }
        $received->where(function($q){
            $q->where('myfiles.name','like','%'.$this->inpsearch.'%');
            $q->orwhere('users.name','like','%'.$this->inpsearch.'%');
        });
        if($this->sortBy=="file_name"){
            $received->orderby('myfiles.name',$this->sortDirection);
        }else if($this->sortBy=='from_name'){
            $received->orderby('users.name',$this->sortDirection);
        }else if($this->sortBy=='updated_at'){
            $received->orderby('sendfiles.updated_at',$this->sortDirection);
        }
        return $received;
    }
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
        $data['received']=$this->MyReceived;
        $data['myfile']=Myfile::where('id',$this->fileid)->get();
        return view('livewire.back.filereceive',$data)->layout('layouts.app');
    }
}
