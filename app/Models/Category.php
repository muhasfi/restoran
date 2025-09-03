<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = ['category_name', 'description', 'created_at', 'updated_at', 'deleted_at'];
    protected $table = 'categorie.categories';
    protected $dates = ['deleted_at'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
