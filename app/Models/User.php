<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\Searchable;
use Spatie\Permission\Traits\HasRoles;
use DB;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes, ValidatingTrait;
    use Searchable;
    use HasRoles;

    protected $presenter = 'App\Presenters\UserPresenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'activated',
        'address',
        'city',
        'country',
        'first_name',
        'last_name',
        'phone',
        'state',
        'zip',
        'sex',
        'last_login'
    ];

    protected $casts = [
        'activated' => 'boolean',
    ];

    /**
     * Model validation rules
     *
     * @var array
     */

    protected $rules = [
        'first_name'              => 'required|string|min:1',
        'email'                   => 'required|email|nullable|unique',
        'password'                => 'required|min:6',
        'website'                => 'nullable|url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];
    protected $injectUniqueIdentifier = true;


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
        'employee_num'
    ];

    public function scopeGetDeleted($query)
    {
        return $query->withTrashed()->whereNotNull('deleted_at');
    }

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
            $query = $query->orWhereRaw('CONCAT('.DB::getTablePrefix().'users.first_name," ",'.DB::getTablePrefix().'users.last_name) LIKE ?', ["%$term%", "%$term%"]);
        }
        return $query;
    }

    public function country() {
        return $this->belongsTo('App\Models\Country');
    }

}
