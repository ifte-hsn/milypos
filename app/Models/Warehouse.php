<?php

namespace App\Models;

use App\Traits\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;

class Warehouse extends MilyPosModel
{
    use SoftDeletes, ValidatingTrait;
    use SearchableTrait;

    protected $fillable = [
        'code',
        'email',
        'name',
        'phone',
        'address',
    ];

    protected $presenter = 'App\Presenters\WarehousePresenter';

    protected $rules = [
        'code' => 'required|string|min:1',
        'email' => 'required|email|unique',
        'name' => 'required|string|unique|min:3',
    ];
    protected $dates = ['deleted_at'];

    protected $searchableAttributes = [
        'code',
        'email',
        'name',
        'phone',
        'address',
    ];

    protected $searchableRelations = [
        'user' => ['name']
    ];

    public function contactPersons()
    {
        return $this->hasMany('App\Models\User');
    }
}
