<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Sendfile extends Model
{
    use HasFactory;
    use HasRoles;

    protected $fillable = [
        'name',
        'path',
        'is_public',
        'filecategory_id',
        'user_id'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function myfile()
    {
        return $this->belongsTo(Myfile::class);
    }
}
