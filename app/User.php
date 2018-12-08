<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\Searchable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes, ValidatingTrait;
    use Searchable;

    protected $presenter = 'App\Presenters\UserPresenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'activated',
        'address',
        'city',
        'company_id',
        'country',
        'first_name',
        'last_name',
        'phone',
        'state',
        'zip',
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
        'email'                   => 'email|nullable|unique',
        'password'                => 'required|min:6',
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
        'username',
        'notes',
        'phone',
        'jobtitle',
        'employee_num'
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
            $query = $query->orWhereRaw('CONCAT('.DB::getTablePrefix().'users.first_name," ",'.DB::getTablePrefix().'users.last_name) LIKE ?', ["%$term%", "%$term%"]);
        }
        return query;
    }

}
