<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Watson\Validating\ValidatingTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\SearchableTrait;

class Category extends Model
{
    use SoftDeletes, ValidatingTrait;
    use SearchableTrait;

    protected $presenter = 'App\Presenters\CategoryPresenter';

    protected $rules = [
      'name' => 'required'
    ];

    protected $fillable = ['name'];
    protected $dates = ['deleted_at'];
    protected $injectUniqueIdentifier = true;

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
