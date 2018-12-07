<?php

namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;

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

    public function scopeTextSearch($query, $search)
    {
        $terms = $this->prepareSearchTerms($search);

        /**
         * Search the attributes of the models
         */
        $query = $this->searchAttributes($query, $terms);

        /**
         * Search through the relations of model
         */
        $query = $this->searchRelations($query, $terms);

        /**
         * Search additional attributes defined by the model
         */
        $query = $this->advancedTextSearch($query, $terms);

        return $query;
    }


    /**
     * Prepare the search terms, splitting and cleaning it up
     *
     * @param $search string $search The search term
     * @return array    An array of search terms
     */
    private function prepareSearchTerms($search)
    {
        return explode("OR", $search);
    }

    /**
     * Searches the model attribute for search terms
     *
     * @param Builder $query
     * @param array $terms
     * @return Builder
     */
    private function searchAttributes(Builder $query, array $terms)
    {
        $table = $this->getTable();

        $firstConditionAdded = false;

        foreach ($this->getSearchableAttributes() as $column) {

            foreach ($terms as $term) {
                /**
                 * Making sure if only search in date column if search term
                 * consists of characters that can makeup MySQL timestamp!
                 */
                if(!preg_match('/^[0-9 :-]++$/', $term) && is_array($column, $this->getDates())) {
                    continue;
                }

                /**
                 * We need to form the query properly, starting with a "where"
                 * otherwise the generated select is wrong
                 */
                if(!$firstConditionAdded) {
                    $query->where($table . '.' . $column, 'LIKE', '%' . $term. '%');
                    $firstConditionAdded = true;
                    continue;
                }
                $query->orWhere($table . '.' . $column, 'LIKE', '%' . $term . '%');
            }
        }
        return $query;
    }

    /**
     * Searches the models relations for the search terms
     *
     * @param Builder $query
     * @param array $terms
     * @return Builder
     */
    private function searchRelations(Builder $query, array $terms)
    {
        foreach ($this->getSearchableRelations() as $relation => $column )
        {
            $query->orWhereHas($relation, function ($query) use ($relation, $column, $terms) {
                $table = $this->getRelationTable($relation);
            });
        }
    }

    /**
     * Get the searchable attributes, if defined.
     * Otherwise return an empty array
     *
     * @return array
     */
    private function getSearchableAttributes()
    {
        return isset($this->searchableAttributes) ? $this->searchableAttributes : [];
    }

    /**
     * Get searchable relations, if defined.
     * Otherwise it returns empty array
     *
     * @return array The relations to search in
     */
    private function getSearchableRelations() {
        return isset($this->searchableRelations) ? $this->searchableRelations : [];
    }


    private function getRelationTable($relation) {
        $related = $this;

        foreach(explode('.', $relation) as $relationName) {
            $related = $related->{$relationName}()->getRelated();
        }

    }
}