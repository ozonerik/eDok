<?php

use App\Models\Myfile;
use Illuminate\Support\Arr;

function get_categories_size($category_id,$user_id){
    $myfile = Myfile::Where('filecategory_id',$category_id)
    ->where('user_id',$user_id)
    ->selectRaw("SUM(file_size) as category_size")
    ->groupBy('filecategory_id')
    ->groupBy('user_id')
    ->first();
    return convert_bytes(Arr::get($myfile, 'category_size'));
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