<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sendfile;

class Filesend extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $sortBy = 'updated_at';
    public $sortDirection = 'desc';
    public $perhal = 2 ;
    public $inpsearch = "";

    //reset search
    public function resetSearch(){
        $this->inpsearch='';
    }

    //lifecylce hook get<namafungsi>Property
    public function getMySendProperty(){
        return $this->MySendQuery->paginate($this->perhal);
    }
    //lifecylce hook get<namafungsi>Property
    public function getMySendQueryProperty(){
        $sending = Sendfile::query();
        if($this->sortBy=="sendkey"){
            $sending->orderby('sendkey',$this->sortDirection);
        }else if($this->sortBy=="myfile_id"){
            $sending->orderby('myfile_id',$this->sortDirection);
        }else if($this->sortBy=='receiveuser_id'){
            $sending->orderby('receiveuser_id',$this->sortDirection);
        }else if($this->sortBy=='user_id'){
            $sending->orderby('user_id',$this->sortDirection);
        }else if($this->sortBy=='updated_at'){
            $sending->orderby('updated_at',$this->sortDirection);
        }
        return $sending;
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
        $data['sending']=$this->MySend;
        return view('livewire.back.filesend',$data)->layout('layouts.app');
    }
}
