<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Myfile;
use Zip;

class Otherfile extends Component
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
    public $myfile_id = [];

    //lifecylce hook get<namafungsi>Property
    public function getMyfileProperty(){
        return $this->MyfileQuery->paginate($this->perhal);
    }
    //lifecylce hook get<namafungsi>Property
    public function getMyfileQueryProperty(){
        $myfile = Myfile::query();
        $myfile->select('myfiles.*','users.name as user_name','filecategories.name as category_name');
        $myfile->join('users','myfiles.user_id','=','users.id');
        $myfile->join('filecategories','myfiles.filecategory_id','=','filecategories.id');
        $myfile->where('myfiles.name','like','%'.$this->inpsearch.'%');
        $myfile->orwhere('filecategories.name','like','%'.$this->inpsearch.'%');
        $myfile->orwhere('users.name','like','%'.$this->inpsearch.'%');
        if($this->sortBy=="name"){
            $myfile->orderby('myfiles.name',$this->sortDirection);
        }else if($this->sortBy=="user_name"){
            $myfile->orderby('users.name',$this->sortDirection);
        }else if($this->sortBy=='category_name'){
            $myfile->orderby('filecategories.name',$this->sortDirection);
        }else if($this->sortBy=='file_size'){
            $myfile->orderby('myfiles.file_size',$this->sortDirection);
        }else if($this->sortBy=='updated_at'){
            $myfile->orderby('myfiles.updated_at',$this->sortDirection);
        }else if($this->sortBy=='is_public'){
            $myfile->orderby('myfiles.is_public',$this->sortDirection);
        }
        
        return $myfile;
    }
    //lifecylce hook updated<namavariable>
    public function updatedSelectPage($value){
        if($value){
            $this->checked = $this->Myfile->pluck('id')->map(fn($item) => (string) $item)->toArray();
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
            $this->checked = $this->MyfileQuery->pluck('id')->map(fn($item) => (string) $item)->toArray();
        }else{
            $this->checked = [];
        }
    }
    public function deselectAll(){
        $this->selectAll=false;
        $this->selectPage=false;
        $this->checked = [];
    }
    public function is_checked($fileid){
        return in_array($fileid,$this->checked);
    }
    //end selection
    
    //remove
    public function removeselection()
    {
        $this->myfile_id = $this->checked;
        $this->dispatchBrowserEvent('show-form-del');
    }
    public function removesingle($id){
        $this->myfile_id = [$id];
        $this->dispatchBrowserEvent('show-form-del');
    }
    private function deletefile($pathfile){
        if(Storage::disk('public')->exists($pathfile)){
            Storage::disk('public')->delete($pathfile);
        }
    }
    public function delete()
    {
        $myfiles = Myfile::whereIn('id',$this->myfile_id);
        foreach($myfiles->pluck('path') as $path){
            $this->deletefile($path);
        }
        $myfiles->delete();
        $this->selectPage=false;
        $this->checked = array_diff($this->checked,$this->myfile_id );
        $this->dispatchBrowserEvent('hide-form-del');
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>'Deleted items successfully.'
        ]);
    }
    //end remove

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
    
    //download zip
    public function zipdownload(){
        $myfiles = Myfile::with(['user','filecategory'])->whereIn('id',$this->checked)->get();
        $filename='eDokFile_'.Str::random(10).'.zip';
        $zip=Zip::create($filename);
        foreach($myfiles as $row){
            $file=pathinfo($row->path);
            $date=Carbon::now()->format('Y-m-d');
            $rename=$row->name." (".$row->user->name.") (".$date.")".".".$file['extension'];
            if(Storage::disk('public')->exists($row->path)){
                $zip->add(Storage::disk('public')->path($row->path),$rename);
            } 
        }
        $pathzip='ZipFiles/';
        $zip->saveTo(Storage::disk('public')->path($pathzip));
        $downloadpath=Storage::disk('public')->path($pathzip.$filename);
        return response()->download($downloadpath)->deleteFileAfterSend(true);
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

    public function render()
    {
        $data['myfile']=$this->Myfile;
        $data['delsel']=$this->MyfileQuery->find($this->myfile_id);
        $data['auth_id']=Auth::user()->id;
        return view('livewire.back.otherfile',$data)->layout('layouts.appclear');
    }
}
