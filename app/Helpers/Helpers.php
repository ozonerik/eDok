<?php

use App\Models\Myfile;
use App\Models\User;
use App\Models\Sendfile;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use Spatie\Permission\Traits\HasRoles;

function get_categories_size($category_id,$user_id){
    $myfile = Myfile::Where('filecategory_id',$category_id)
    ->where('user_id',$user_id)
    ->selectRaw("SUM(file_size) as category_size")
    ->groupBy('filecategory_id')
    ->groupBy('user_id')
    ->first();
    return convert_bytes(Arr::get($myfile, 'category_size'));
}

function getfilescat($category_id){
    $myfile = Myfile::Where('filecategory_id',$category_id)
    ->get()
    ->pluck('path')
    ->toArray();
    return $myfile;
}

function getfilesuser($user_id){
    $myfile = Myfile::where('user_id',$user_id)
    ->get()
    ->pluck('path')
    ->toArray();
    return $myfile;
}

function cek_adminId($id){
    $user=User::role('admin')->get();
    $id_admin = $user->pluck('id')->toArray();
    return in_array($id,$id_admin);
}

function compareArray($array1,$array2){
    if (array_diff($array1,$array2) == array_diff($array2,$array1)) {
        return true;
    }else{
        return false;
    }
}

function get_bulan($q){

    $blnmcount = [];
    $blnArr = [];

    foreach ($q as $key => $value) {
        $blnmcount[(int)$value->bulan] = $value->jumfile;
    }

    $month = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nop', 'Des'];

    for ($i = 1; $i <= 12; $i++) {
        if (!empty($blnmcount[$i])) {
            $blnArr[$i]['jumfile'] = $blnmcount[$i];
        } else {
            $blnArr[$i]['jumfile'] = 0;
        }
        $blnArr[$i]['bulan'] = $month[$i - 1];
    }
    return $blnArr;
}

function convert_bytes($set_bytes){
    $set_kb = 1024;
    $set_mb = $set_kb * 1024;
    $set_gb = $set_mb * 1024;
    $set_tb = $set_gb * 1024;
    if (($set_bytes >= 0) && ($set_bytes < $set_kb))
        {
            return ceil($set_bytes) . ' B';
        }
    elseif (($set_bytes >= $set_kb) && ($set_bytes < $set_mb))
        {
            return ceil(($set_bytes / $set_kb)) . ' kB';
        }
    elseif (($set_bytes >= $set_mb) && ($set_bytes < $set_gb))
        {
            return ceil(($set_bytes / $set_mb)) . ' MB';
        }
    elseif (($set_bytes >= $set_gb) && ($set_bytes < $set_tb))
        {
            return ceil(($set_bytes / $set_gb)) . ' GB';
        }
    elseif ($set_bytes >= $set_tb)
        {
            return ceil(($set_bytes / $set_tb)) . ' TB';
        }
}