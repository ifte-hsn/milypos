<?php

namespace App\Traits;


/**
 * This trait allows for cleaner searching of models,
 * moving from complex queries to an easier declarative syntax.
 *
 * @author Till Deeke <kontakt@tilldeeke.de>
 */
trait Searchable
{
    /**
     * Performs a search on the model, using the provided search terms
     *
     * @param  Illuminate\Database\Eloquent\Builder $query The query to start the search on
     *
     * @param  string $search
     *
     * @return Illuminate\Database\Eloquent\Builder A query with added "where" clauses
     */

    public function scopeTextSearch($query, $search) {
        
    }
}