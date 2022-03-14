<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sendfile;
use App\Models\Myfile;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Filesend extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perhal = 2 ;
    public $inpsearch = "";
    public $fileid = '';
    public $qrcode = 'null';

    //reset search
    public function resetSearch(){
        $this->inpsearch='';
    }

    public function reading($id){
        $received = Sendfile::find($id);
        $this->fileid = $received->myfile_id;
        $this->qrcode = $received->sendkey;
        $this->dispatchBrowserEvent('show-form-sending');
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

    //lifecylce hook get<namafungsi>Property
    public function getMySendProperty(){
        return $this->MySendQuery->paginate($this->perhal);
    }
    //lifecylce hook get<namafungsi>Property
    public function getMySendQueryProperty(){
        $sending = Sendfile::query();
        $sending->select('sendfiles.*','myfiles.name as file_name','users.name as recipient_name');
        $sending->join('myfiles','sendfiles.myfile_id','=','myfiles.id');
        $sending->join('users','sendfiles.receiveuser_id','=','users.id');
        $sending->where('sendfiles.user_id',Auth::user()->id);
        $sending->where(function($q){
            $q->where('myfiles.name','like','%'.$this->inpsearch.'%');
            $q->orwhere('users.name','like','%'.$this->inpsearch.'%');
        });
        if($this->sortBy=="file_name"){
            $sending->orderby('myfiles.name',$this->sortDirection);
        }else if($this->sortBy=='recipient_name'){
            $sending->orderby('users.name',$this->sortDirection);
        }else if($this->sortBy=='created_at'){
            $sending->orderby('sendfiles.created_at',$this->sortDirection);
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
        $data['myfile']=Myfile::where('id',$this->fileid)->get();
        return view('livewire.back.filesend',$data)->layout('layouts.app');
    }
}
