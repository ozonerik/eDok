<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sendfile;
use App\Models\Myfile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class Filesend extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perhal = 25 ;
    public $inpsearch = "";
    public $fileid = '';
    public $qrcode = 'null';
    public $selectPage = false;
    public $selectAll = false;
    public $checked = [];
    public $mysend_id = [];
    public $receiveuser=[];
    public $filesend=[];
    public $searchrecipient='';
    public $searchrfiles='';

    //reset search
    public function resetSearch(){
        $this->inpsearch='';
    }

    public function is_recipient($id){
        array_push($this->receiveuser,$id);
        $this->searchrecipient='';
    }
    public function is_files($id){
        array_push($this->filesend,$id);
        $this->searchrfiles='';
    }

    public function del_recipient($id){
        $this->receiveuser=array_diff($this->receiveuser,array($id));
    }
    public function del_files($id){
        $this->filesend=array_diff($this->filesend,array($id));
    }

    public function getRecipientlistProperty(){
        $user=User::query();
        $user->where('id','!=',Auth::user()->id);
        $user->whereNotIn('id',$this->receiveuser);
        $user->where('name','like','%'.$this->searchrecipient.'%');
        return $user;
    }
    public function getFileslistProperty(){
        $myfile=Myfile::query();
        $myfile->where('user_id','=',Auth::user()->id);
        $myfile->whereNotIn('id',$this->filesend);
        $myfile->where('name','like','%'.$this->searchrfiles.'%');
        return $myfile;
    }

    //reset form
    private function resetCreateForm(){
        $this->mysend_id = [];
        $this->searchrecipient='';
        $this->searchrfiles='';
        $this->resetErrorBag();
        $this->resetValidation();
    }

    //add single
    public function add()
    {
        $this->dispatchBrowserEvent('show-form');
        $this->resetCreateForm();
    }

    public function store(){
        if(!empty($this->receiveuser) && !empty($this->filesend) ){
            foreach($this->receiveuser as $user){
                foreach($this->filesend as $filesid){
                    Sendfile::create([
                        'sendkey' => Str::random(10),
                        'myfile_id' => $filesid,
                        'receiveuser_id' => $user,
                        'user_id' => Auth::user()->id,
                        'is_read' => false,
                    ]);
                }
            }
            $this->dispatchBrowserEvent('hide-form');
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>'Sending successfully.'
            ]);
            $this->resetCreateForm();
        }else{
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>'Sending failed.'
            ]);
            $this->resetCreateForm();
        }

        
    }
    
    //remove
    public function removeselection()
    {     
        $this->mysend_id = $this->checked;
        $this->dispatchBrowserEvent('show-form-del');
    }

    public function removesingle($id){
        $this->mysend_id = [$id];
        $this->dispatchBrowserEvent('show-form-del');
    }

    public function delete()
    {
        $sendfile = Sendfile::whereIn('id',$this->mysend_id);
        $sendfile->delete();
        $this->selectPage=false;
        $this->checked = array_diff($this->checked,$this->mysend_id );
        $this->dispatchBrowserEvent('hide-form-del');
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>'Deleted items successfully.'
        ]);
    }

    //lifecylce hook updated<namavariable>
    public function updatedSelectPage($value){
        if($value){
            $this->checked = $this->MySend->pluck('id')->map(fn($item) => (string) $item)->toArray();
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

    //selection
    public function selectAll(){
        $this->selectAll=true;
        if($this->selectAll){
            $this->checked = $this->MySendQuery->pluck('id')->map(fn($item) => (string) $item)->toArray();
        }else{
            $this->checked = [];
        }
    }
    public function deselectAll(){
        $this->selectAll=false;
        $this->selectPage=false;
        $this->checked = [];
    }
    public function is_checked($sendid){
        return in_array($sendid,$this->checked);
    }
    //end selection

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
        $document_name= str_replace(array("/", "\\", ":", "*", "?", "«", "<", ">", "|"), "-", $rename);
        $headers = ['Content-Type: application/pdf'];
        return Storage::disk('public')->download($url, $document_name, $headers);
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
        $data['delsel']=Sendfile::find($this->mysend_id);
        $data['myfile']=Myfile::where('id',$this->fileid)->get();
        $data['userlist']=$this->Recipientlist->take(3)->get();
        $data['userselect']=User::whereIn('id',$this->receiveuser)->get();
        $data['filelist']=$this->Fileslist->get();
        $data['fileselect']=Myfile::whereIn('id',$this->filesend)->get();
        return view('livewire.back.filesend',$data)->layout('layouts.app');
    }
}
