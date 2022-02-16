<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Myfile extends Model
{
    use HasFactory;
    use HasRoles;

    protected $fillable = [
        'name',
        'is_pinned',
        'path',
        'file_size',
        'is_public',
        'filecategory_id',
        'user_id'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function filecategory()
    {
        return $this->belongsTo(Filecategory::class);
    }
    public function sendfile()
    {
        return $this->hasMany(Sendfile::class);
    }
    
}
