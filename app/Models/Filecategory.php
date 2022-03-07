<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filecategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_public',
        'user_id'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function myfile()
    {
        return $this->hasMany(Myfile::class);
    }
}
