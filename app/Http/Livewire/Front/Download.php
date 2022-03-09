<?php

namespace App\Http\Livewire\Front;

use Livewire\Component;
use App\Models\Sendfile;
use App\Models\Myfile;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Download extends Component
{
    public $c;
    public $recipientpass;
    public $userpass;
 
    protected $queryString = [ 'c'=> ['except' => ''] ];

    public function getDownQueryProperty(){
        $sendfile=Sendfile::query();
        $sendfile->where('sendkey',$this->c);
        return $sendfile;
    }
    
    public function cobadownload(){
        $sendfile=Sendfile::where('sendkey',$this->c)->first();
        $this->userpass=$sendfile->receiveuser->password;
        $cek=Hash::check($this->recipientpass, $this->userpass);
        if($cek){
            $date=Carbon::now()->format('Y-m-d');
            $myfile = Myfile::with(['user','filecategory'])->findOrFail($sendfile->myfile_id);
            $url=$myfile->path;
            $file=pathinfo($myfile->path);
            $rename=$myfile->name." (".$myfile->user->name.") (".$date.")".".".$file['extension'];
            $headers = ['Content-Type: application/pdf'];
            $this->recipientpass='';
            return Storage::disk('public')->download($url, $rename, $headers);
        }else{
            $this->recipientpass='';
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>'Download Failed !'
            ]);
        }
    }
    public function render()
    {
        $data['myfile']=$this->DownQuery->get();
        return view('livewire.front.download',$data)->layout('layouts.home');
    }
}
