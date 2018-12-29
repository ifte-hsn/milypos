<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\SearchableTrait;
use Watson\Validating\ValidatingTrait;

class Role extends \Spatie\Permission\Models\Role
{
    use SoftDeletes, ValidatingTrait;
    use SearchableTrait;

    protected $presenter = 'App\Presenters\RolePresenter';

    protected $rules = [
        'name' => 'required'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableAttributes = [
        'name',
    ];

    public function scopeGetDeleted($query)
    {
        return $query->withTrashed()->whereNotNull('deleted_at');
    }
}