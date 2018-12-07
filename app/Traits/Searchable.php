<?php

namespace App\Traits;


use Illuminate\Database\Eloquent\Builder as Builder;

/**
 * This trait allows for cleaner searching of models, moving
 * from complex queries to an easier declarative syntax.
 *
 * @author Till Deeke <kontakt@tilldeeke.de>
 */
trait Searchable
{
    /**
     * Performs a search on the model, using the provided search terms
     *
     * @param $query
     * @param $search
     * @return Builder
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
                if (!preg_match('/^[0-9 :-]++$/', $term) && is_array($column, $this->getDates())) {
                    continue;
                }

                /**
                 * We need to form the query properly, starting with a
                 * "where" otherwise the generated select is wrong
                 */
                if (!$firstConditionAdded) {
                    $query->where($table . '.' . $column, 'LIKE', '%' . $term . '%');
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
        foreach ($this->getSearchableRelations() as $relation => $columns) {
            $query->orWhereHas($relation, function ($query) use ($relation, $columns, $terms) {
                $table = $this->getRelationTable($relation);

                /**
                 * We need to form the query properly, starting with a "where",
                 * otherwise the generated nested select is wrong.
                 */

                $firstConditionAdded = false;

                foreach ($columns as $column) {
                    foreach ($terms as $term) {
                        if (!$firstConditionAdded) {
                            $query->where($table . '.' . $column, 'LIKE', '%' . $term . '%');
                            $firstConditionAdded = true;
                            continue;
                        }

                        $query->orWhere($table . '.' . $column, 'LIKE', '%' . $term . '%');
                    }
                }
            });
        }
        return $query;
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
    private function getSearchableRelations()
    {
        return isset($this->searchableRelations) ? $this->searchableRelations : [];
    }


    /**
     * Get the table name of relation.
     *
     * This method loops over a relation name, getting the table name
     * of the last relation in the series.
     *
     * So categories would get the table name for the Category model
     * "model.manufacturer" would be get the tablename for the
     * Manufacturer model.
     *
     * @param $relation
     * @return string   The table name
     */
    private function getRelationTable($relation)
    {
        $related = $this;

        foreach (explode('.', $relation) as $relationName) {
            $related = $related->{$relationName}()->getRelated();
        }

        /**
         * Are we referencing the model that are called?
         * Then get the internal join-tablename, since
         * Laravel has trouble selecting the
         * correct one in this type of
         * parent-child self-json
         */
        if ($this instanceof $related) {
            /**
             * Since Laravel increases counter on the hash on
             * retrieval, we have to count it down again.
             *
             * This causes side effects! Every time we access
             * this method, Laravel increase the counter
             *
             * Format: laravel_reserved_XXX
             */

            $relationCountHash = $this->{$relationName}()->getRelationCountHash();
            $parts = collect(explode('_', $relationCountHash));

            $counter = $parts->pop();
            $parts->push($counter - 1);
            return implode('_', $parts->toArray());
        }

        return $related->getTable();
    }

    /**
     * Run additional, advanced searches that can't
     * be done using the attributes or relations.
     *
     * @param Builder $query
     * @param array $terms
     * @return Builder
     */
    private function advancedTextSearch(Builder $query, array $terms)
    {
        return $query;
    }
}