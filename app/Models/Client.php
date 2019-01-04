<?php

namespace App\Models;

use App\Traits\SearchableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;
use DB;
class Client extends MilyPosModel
{
    use SoftDeletes, ValidatingTrait;
    use SearchableTrait;

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'image',
        'sex',
        'phone',
        'fax',
        'address',
        'city',
        'state',
        'zip',
        'country_id'
    ];

    protected $presenter = 'App\Presenters\ClientsPresenter';

    protected $rules = [
        'first_name' => 'required|string|min:1',
        'email' => 'required|email|nullable|unique',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be included when searching the model.
     *
     * @var array
     */
    protected $searchableAttributes = [
        'first_name',
        'last_name',
        'email',
        'phone',
    ];

    protected $searchableRelations = [
        'country' => ['name']
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name;
    }

    /**
     * Run additional advanced searches
     * @param Builder $query
     * @param array $terms
     * @return mixed
     */
    public function advancedTextSearch(Builder $query, array $terms)
    {
        foreach ($terms as $term) {
            $query = $query->orWhereRaw('CONCAT('.DB::getTablePrefix().'clients.first_name," ",'.DB::getTablePrefix().'clients.last_name) LIKE ?', ["%$term%", "%$term%"]);
        }
        return $query;
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }
}
