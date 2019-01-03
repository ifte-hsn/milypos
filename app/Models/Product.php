<?php

namespace App\Models;

use App\Traits\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Watson\Validating\ValidatingTrait;

class Product extends Model
{
    use SoftDeletes, Notifiable;
    use ValidatingTrait;
    use SearchableTrait;

    protected $searchableRelations = [
        'category' => ['name']
    ];

    protected $presenter = 'App\Presenters\ProductPresenter';
    protected $rules = [
      'name' => 'required',
      'code' => 'required',
    ];

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'code',
        'image',
        'stock',
        'description',
        'purchase_price',
        'sell_price',
        'sales',
        'category_id'
    ];

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }
}
