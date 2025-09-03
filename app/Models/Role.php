<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $fillable = ['role_name', 'description', 'created_at', 'updated_at', 'deleted_at'];
    protected $table = 'users.roles';
    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
