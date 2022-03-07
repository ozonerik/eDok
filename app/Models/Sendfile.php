<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sendfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'sendkey',
        'myfile_id',
        'receiveuser_id',
        'user_id',
        'is_read'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function receiveuser()
    {
        return $this->belongsTo(User::class,'receiveuser_id','id');
    }
    public function myfile()
    {
        return $this->belongsTo(Myfile::class);
    }
}
