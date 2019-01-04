<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MilyPosModel extends Model
{
    public function scopeGetDeleted($query)
    {
        return $query->withTrashed()->whereNotNull('deleted_at');
    }
}
