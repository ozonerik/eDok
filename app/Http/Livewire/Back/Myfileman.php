<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Myfile;
use App\Models\Filecategory;
use Zip;

class Myfileman extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $sortBy = 'updated_at';
    public $sortDirection = 'desc';
    public $perhal = 2 ;
    public $checked = [];
    public $inpsearch = "";
    public $selectPage = false;
    public $selectAll = false;
    public $myfile_id = [];
    public $modeEdit=false;
    public $states=[];
    public $file,$path,$oldpath,$upload_id;
    public $ids,$name,$is_pinned,$filecategory_id,$is_public;
    public $category,$searchcat,$resultcat;

    //reset search
    public function resetSearch(){
        $this->inpsearch='';
    }

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
        $myfile->where('myfiles.user_id',Auth::user()->id);
        $myfile->where(function($q){
            $q->where('myfiles.name','like','%'.$this->inpsearch.'%');
            $q->orwhere('filecategories.name','like','%'.$this->inpsearch.'%');
            $q->orwhere('users.name','like','%'.$this->inpsearch.'%');
        });        
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
        }else if($this->sortBy=='is_pinned'){
            $myfile->orderby('myfiles.is_pinned',$this->sortDirection);
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
    
    //get not admin except auth
    public function get_notadmin(){
        $newchecked=[];
        $myfile=Myfile::WhereIn('id',$this->checked)->get();
        foreach($myfile as $key => $row){
            if(!cek_adminId($row->user_id) or (Auth::user()->id == $row->user_id)){
                $newchecked[$key]=(string)$row->id;
            }   
        }
        return $newchecked;
    }
    
    //remove
    public function removeselection()
    {
        if(!compareArray($this->checked,$this->get_notadmin())){
            $this->selectAll=false;
            $this->selectPage=false;
            $this->checked = $this->get_notadmin();
        }
         
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
        if ($this->category !== null) {
            $this->resultcat = Filecategory::where('user_id',Auth::user()->id)
            ->where('name','like', '%' . $this->category . '%')
            ->orderBy('name')
            ->get(); 
        }else{
            $this->resultcat = Filecategory::where('user_id',Auth::user()->id)
            ->orderBy('name')
            ->get(); 
        }
        
        $data['myfile']=$this->Myfile;
        //$data['delsel']=$this->MyfileQuery->find($this->myfile_id);
        $data['delsel']=Myfile::find($this->myfile_id);
        $data['cat']=Filecategory::where('user_id',Auth::user()->id)
                    ->orderBy('name')
                    ->get();
        $data['auth_id']=Auth::user()->id;
        return view('livewire.back.myfileman',$data)->layout('layouts.app');
    }

    public function searchcat()
    {
        $this->dispatchBrowserEvent('show-form-searchcat');
        $this->dispatchBrowserEvent('hide-form');
        $this->category=null;
    }

    public function close_formsearchcat(){
        $this->dispatchBrowserEvent('hide-form-searchcat');
        $this->dispatchBrowserEvent('show-form');
    }

    public function selectcat($id)
    {
        $this->filecategory_id=$id;
        $this->dispatchBrowserEvent('hide-form-searchcat');
        $this->dispatchBrowserEvent('show-form');
    }

    //reset form
    private function resetCreateForm(){
        $this->ids = '';
        $this->name='';
        $this->is_pinned='';
        $this->filecategory_id='';
        $this->is_public='';
        $this->path='';
        $this->oldpath='';
        $this->modeEdit=false;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    //add single
    public function add()
    {
        $this->modeEdit=false;
        $this->upload_id++;
        $this->dispatchBrowserEvent('show-form');
        $this->resetCreateForm();
    }

    //store add/edit single
    public function store()
    {
        if(Auth::user()->hasRole('user')){
            $this->is_pinned=false;
        }

        $this->upload_id++;
        if(!$this->modeEdit){
            $this->validate([
                'name' => 'required',
                'is_pinned' => 'required',
                'filecategory_id' => 'required',
                'is_public' => 'required',
                'file' => 'required|mimes:pdf|max:10240',
            ]);
        }else{
            $this->validate([
                'name' => 'required',
                'is_pinned' => 'required',
                'filecategory_id' => 'required',
                'is_public' => 'required',
                'file' => 'nullable|mimes:pdf|max:10240',
            ]);
        }

        $dir='myfiles/'.Auth::user()->id.'/'.$this->filecategory_id.'/';
        if(!empty($this->file)){
            $path=$this->file->store($dir,'public');
            $file_size=Storage::disk('public')->size($path);
            $this->deletefile($this->oldpath);
        }else{
            $path=$this->oldpath;
            $file_size=Storage::disk('public')->size($path);
        }
        
        Myfile::updateOrCreate(['id' => $this->ids], [
            'name' => $this->name,
            'is_pinned' => $this->is_pinned,
            'filecategory_id' => $this->filecategory_id,
            'is_public' => $this->is_public,
            'path' => $path,
            'file_size' => $file_size,
            'user_id' => Auth::user()->id
        ]);
        $this->dispatchBrowserEvent('hide-form');       
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>$this->ids ? 'Data updated successfully.' : 'Data added successfully.'
        ]);
        $this->resetCreateForm();
    }
    
    //edit single
    public function edit($id)
    {
        $this->modeEdit=true;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->upload_id++;
        $myfile = Myfile::findOrFail($id);
        $this->ids=$id;
        $this->myfile_id=[$id];
        $this->name = $myfile->name;
        $this->is_pinned = $myfile->is_pinned;
        $this->filecategory_id = $myfile->filecategory_id;
        $this->is_public = $myfile->is_public;
        $this->oldpath = $myfile->path;
        $this->dispatchBrowserEvent('show-form');
    }

    //edit multisel
    public function editselection()
    {
        $this->modeEdit=true;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->upload_id++;
        $this->myfile_id = $this->checked;
        $this->is_pinned = '';
        $this->filecategory_id = '';
        $this->is_public = '';
        $this->path='';
        $this->oldpath='';
        $this->dispatchBrowserEvent('show-form-multiedit');
    }

    //store update multisel
    public function storeupdatesel(){
        
        if(Auth::user()->hasRole('user')){
            $this->is_pinned=false;
        }

        $this->validate([
            'is_pinned' => 'required',
            'filecategory_id' => 'required',
            'is_public' => 'required',
        ]);

        $cat = Myfile::WhereIn('id',$this->myfile_id);
        $cat->update([
            'is_pinned' => $this->is_pinned,
            'filecategory_id' =>  $this->filecategory_id,
            'is_public' =>  $this->is_public,
        ]);
        $this->dispatchBrowserEvent('hide-form-multiedit');
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>'Data updated successfully.'
        ]);
        
        $this->resetCreateForm();  
    }


}
