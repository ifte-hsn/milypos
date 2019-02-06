<?php

namespace App\Models;


use Watson\Validating\ValidatingTrait;

class Currency extends MilyPosModel
{
    use ValidatingTrait;

    protected $presenter = 'App\Presenters\CategoryPresenter';

    protected $fillable = [
        'country',
        'currency',
        'symbol',
        'code',
        'thousand_separator',
        'decimal_separator',
    ];

    protected $rules = [
        'country'              => 'required|string|unique|min:3',
        'currency'              => 'required|string|min:1',
        'code'                  => 'required|string|min:1',
    ];

}
