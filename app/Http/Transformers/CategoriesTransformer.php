<?php

namespace App\Http\Transformers;


use Illuminate\Database\Eloquent\Collection;
use Auth;

class CategoriesTransformer
{

    public function transformCategories(Collection $categories, $total) {
        $array = array();
        foreach ($categories as $category) {
            $array[] = self::transformCategory($category);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    private static function transformCategory($category)
    {
        $array = [
            'id' => (int) $category->id,
            'name' => $category->name,
        ];

        // Permissions
        $permissions_array['available_actions'] = [
            'update' => (Auth::user()->can('Update Category') && ($category->deleted_at==''))  ? true : false,
            // TODO: this option will only available when there is no asset in this category
            'delete' =>(Auth::user()->can('Delete Category') && ($category->deleted_at=='')) ? true : false,
            'restore' => (Auth::user()->can('Create Category') && ($category->deleted_at!='')) ? true : false,
        ];

        $array += $permissions_array;
        return $array;
    }
}