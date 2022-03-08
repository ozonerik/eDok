<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sendfile;
use App\Models\Myfile;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Filereceive extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perhal = 2 ;
    public $inpsearch = "";
    public $fileid = '';
    public $isread = '';
    public $qrcode = 'null';

    public function is_read($val){
        $this->isread=$val;
    }
    public function reading($id){
        $received = Sendfile::find($id);
        $received->is_read = true;
        $this->fileid = $received->myfile_id;
        $this->qrcode = $received->sendkey;
        $received->save();
        $this->emitTo('comp.getnotread', 'refreshnotread');
        $this->dispatchBrowserEvent('show-form-receive');
    }
    //download file
    public function export($id){
        $date=Carbon::now()->format('Y-m-d');
        $myfile = Myfile::with(['user','filecategory'])->findOrFail($id);
        $url=$myfile->path;
        $file=pathinfo($myfile->path);
        $rename=$myfile->name." (".$myfile->user->name.") (".$date.")".".".$file['extension'];
        $headers = ['Content-Type: application/pdf'];
        return Storage::disk('public')->download($url, $rename, $headers);
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
        }else if($this->sortBy=='created_at'){
            $received->orderby('sendfiles.created_at',$this->sortDirection);
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
