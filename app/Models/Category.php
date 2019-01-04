<?php

namespace App\Models;

use Watson\Validating\ValidatingTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\SearchableTrait;

class Category extends MilyPosModel
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


    public function products() {
        return $this->hasMany('App\Models\Product');
    }
}
