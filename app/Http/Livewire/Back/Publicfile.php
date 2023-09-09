<?php

namespace App\Http\Livewire\Back;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Myfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Publicfile extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $sortBy = 'updated_at';
    public $sortDirection = 'desc';
    public $perhal = 25 ;
    public $inpsearch = "";

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
        $myfile->where(function($q){            
            $q->where('myfiles.is_public',true);
            $q->orwhere('filecategories.is_public',true);
        });
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
        }
        
        return $myfile;
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
    public function export($id){
        //dd('ini export '.$id);
        $date=Carbon::now()->format('Y-m-d');
        $myfile = Myfile::with(['user'])->findOrFail($id);
        $url=$myfile->path;
        $rename=$myfile->name." (".$myfile->user->name.") (".$date.").pdf";
        $document_name= str_replace(array("/", "\\", ":", "*", "?", "«", "<", ">", "|"), "-", $rename);
        $headers = ['Content-Type: application/pdf'];
        return Storage::disk('public')->download($url, $document_name, $headers);
    }
    public function render()
    {
        $data['myfile']=$this->Myfile;
        return view('livewire.back.publicfile',$data)->layout('layouts.app');
    }
}
