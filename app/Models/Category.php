<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use ValidatingTrait;

    protected $rules = [
      'name' => 'required'
    ];

    protected $fillable = ['name'];
    protected $dates = ['deleted_at'];

    public function scopeGetDeleted($query)
    {
        return $query->withTrashed()->whereNotNull('deleted_at');
    }
}
