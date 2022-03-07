<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sendfile;
use Illuminate\Support\Facades\Auth;

class Filereceive extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $sortBy = 'updated_at';
    public $sortDirection = 'desc';
    public $perhal = 2 ;
    public $inpsearch = "";

    public function reading($id){
        $received = Sendfile::find($id);
        $received->is_read = true;
        $received->save();
        $this->emitTo('comp.getnotread', 'refreshnotread');
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
        $received->where('receiveuser_id',Auth::user()->id);
        if($this->sortBy=="sendkey"){
            $received->orderby('sendkey',$this->sortDirection);
        }else if($this->sortBy=="myfile_id"){
            $received->orderby('myfile_id',$this->sortDirection);
        }else if($this->sortBy=='receiveuser_id'){
            $received->orderby('receiveuser_id',$this->sortDirection);
        }else if($this->sortBy=='user_id'){
            $received->orderby('user_id',$this->sortDirection);
        }else if($this->sortBy=='updated_at'){
            $received->orderby('updated_at',$this->sortDirection);
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
        //$data['notread']=Sendfile::where('receiveuser_id',Auth::user()->id)->where('is_read',false)->count();
        return view('livewire.back.filereceive',$data)->layout('layouts.app');
    }
}
