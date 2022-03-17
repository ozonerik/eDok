<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Filecategory;
use App\Models\Myfile;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Zip;

class Catmanage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $sortBy = 'updated_at';
    public $sortDirection = 'desc';
    public $perhal = 25 ;
    public $checked = [];
    public $inpsearch = "";
    public $selectPage = false;
    public $selectAll = false;
    public $modeEdit=false;
    public $category_id=[];
    public $states=[];
    public $ids;
    
    //reset search
    public function resetSearch(){
        $this->inpsearch='';
    }
    
    //lifecylce hook get<namafungsi>Property
    public function getMycatProperty(){
        return $this->MycatQuery->paginate($this->perhal);
    }
    //lifecylce hook get<namafungsi>Property
    public function getMycatQueryProperty(){
        
        $sizeCat = DB::table('myfiles')
                   ->select('user_id','filecategory_id',DB::raw('SUM(file_size) as file_size_category'))
                   ->groupBy('user_id')
                   ->groupBy('filecategory_id');

        $cat = Filecategory::query();
        $cat->select('filecategories.*','size_cat.file_size_category','users.name as user_name');
        $cat->where('filecategories.user_id',Auth::user()->id);
        $cat->where('filecategories.name','like','%'.$this->inpsearch.'%');
        $cat->join('users','filecategories.user_id','=','users.id');
        $cat->leftjoinSub($sizeCat, 'size_cat', function ($join) {
            $join->on('filecategories.id', '=', 'size_cat.filecategory_id');
            $join->on('filecategories.user_id', '=', 'size_cat.user_id');
        });
        if($this->sortBy=="category_name"){
            $cat->orderby('filecategories.name',$this->sortDirection);
        }else if($this->sortBy=="owner"){
            $cat->orderby('users.name',$this->sortDirection);
        }else if($this->sortBy=='cat_size'){
            $cat->orderby('size_cat.file_size_category',$this->sortDirection);
        }else if($this->sortBy=='updated_at'){
            $cat->orderby('filecategories.updated_at',$this->sortDirection);
        }else if($this->sortBy=='is_public'){
            $cat->orderby('filecategories.is_public',$this->sortDirection);
        }

        return $cat;
    }
    //lifecylce hook updated<namavariable>
    public function updatedSelectPage($value){
        if($value){
            $this->checked = $this->Mycat->pluck('id')->map(fn($item) => (string) $item)->toArray();
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
            $this->checked = $this->MycatQuery->pluck('id')->map(fn($item) => (string) $item)->toArray();
        }else{
            $this->checked = [];
        }
    }
    public function deselectAll(){
        $this->selectAll=false;
        $this->selectPage=false;
        $this->checked = [];
    }
    public function is_checked($id){
        return in_array($id,$this->checked);
    }
    //end selection
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
    

    //remove
    public function removeselection()
    {
        $this->category_id = $this->checked;
        $this->dispatchBrowserEvent('show-form-del');
    }
    public function removesingle($id){
        $this->category_id = [$id];
        $this->dispatchBrowserEvent('show-form-del');
    }

    public function delete()
    {
        $cat = Filecategory::whereIn('id',$this->category_id);
        foreach($cat->get() as $path){
            Storage::disk('public')->deleteDirectory('myfiles/'.$path->user_id.'/'.$path->id);
        }
        $cat->delete();
        $this->selectPage=false;
        $this->checked = array_diff($this->checked,$this->category_id );
        $this->dispatchBrowserEvent('hide-form-del');
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>'Deleted items successfully.'
        ]);
    }
    //end remove
    //download zip
    public function zipdownload(){
        $myfiles = Myfile::with(['user','filecategory'])->whereIn('filecategory_id',$this->checked)->get();
        $filename='eDokCat_'.Str::random(10).'.zip';
        $zip=Zip::create($filename);
        $pathzip='ZipFiles/';
        foreach($myfiles as $key => $row){
            $file=pathinfo($row->path);
            $user_name=$row->user->name;
            $cat_name=$row->filecategory->name;
            $date=Carbon::now()->format('Y-m-d');
            $rename=$row->name." (".$row->user->name.") (".$date.")".".".$file['extension'];

            if(Storage::disk('public')->exists($row->path)){
                $zip->add(Storage::disk('public')->path($row->path),$user_name.'/'.$cat_name.'/'.$rename);
            }
        }
        $zip->saveTo(Storage::disk('public')->path($pathzip));
        $downloadpath=Storage::disk('public')->path($pathzip.$filename);
        return response()->download($downloadpath)->deleteFileAfterSend(true);
    }
    //download file
    public function export($id){
        $myfiles = Myfile::with(['user','filecategory'])->whereIn('filecategory_id',[$id])->get();
        $filename='eDokCat_'.Str::random(10).'.zip';
        $zip=Zip::create($filename);
        $pathzip='ZipFiles/';
        foreach($myfiles as $key => $row){
            $file=pathinfo($row->path);
            $user_name=$row->user->name;
            $cat_name=$row->filecategory->name;
            $date=Carbon::now()->format('Y-m-d');
            $rename=$row->name." (".$row->user->name.") (".$date.")".".".$file['extension'];

            if(Storage::disk('public')->exists($row->path)){
                $zip->add(Storage::disk('public')->path($row->path),$user_name.'/'.$cat_name.'/'.$rename);
            }
        }
        $zip->saveTo(Storage::disk('public')->path($pathzip));
        $downloadpath=Storage::disk('public')->path($pathzip.$filename);
        return response()->download($downloadpath)->deleteFileAfterSend(true);
    }
    public function render()
    {
        $data['myfilecat']=$this->MyCat;
        $data['delsel']= Filecategory::find($this->category_id);
        $data['auth_id']=Auth::user()->id;
        return view('livewire.back.catmanage',$data)->layout('layouts.app');
    }

    //reset form
    private function resetCreateForm(){
        $this->modeEdit=false;
        $this->category_id = [];
        $this->ids = '';
        $this->states['name'] = '';
        $this->states['is_public'] = '';
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
        Validator::make($this->states,[
            'name' => 'required',
            'is_public' => 'required',
        ])->validate();
        
        Filecategory::updateOrCreate(['id' => $this->ids], [
            'name' => $this->states['name'],
            'is_public' => $this->states['is_public'],
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
        $filecategory = Filecategory::findOrFail($id);
        $this->ids = $id;
        $this->category_id = [$id];
        $this->states['name'] = $filecategory->name;
        $this->states['is_public'] = $filecategory->is_public;
        $this->dispatchBrowserEvent('show-form');
    }

    //edit multisel
    public function editselection()
    {
        $this->modeEdit=true;
        $this->resetErrorBag();
        $this->resetValidation();
        $this->category_id = $this->checked;
        $this->states['is_public'] = '';
        $this->dispatchBrowserEvent('show-form-multiedit');
    }

    //store update multisel
    public function storeupdatesel(){
        
        Validator::make($this->states,[
            'is_public' => 'required',
        ])->validate();

        $cat = Filecategory::WhereIn('id',$this->category_id);
        $cat->update([
            'is_public' => $this->states['is_public']
        ]);
        $this->dispatchBrowserEvent('hide-form-multiedit');
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>'Data updated successfully.'
        ]);
        
        $this->resetCreateForm();  
    }

}
