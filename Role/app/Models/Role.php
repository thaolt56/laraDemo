<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permisson;
class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name','description'];

    function permission(){
        return $this->belongsToMany(Permisson::class, 'role_permissions');
    }
}
