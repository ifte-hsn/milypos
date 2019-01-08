<?php

namespace App\Models;


class Sale extends MilyPosModel
{

    /**
     * Seller
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }
}
