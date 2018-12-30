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

        $image = '';

        if($category->image) {
            $image = url('/').'/uploads/categories/'.$category->image;
        }

        $array = [
            'id' => (int) $category->id,
            'name' => $category->name,
            'image' => $image,
        ];

        // Permissions
        $permissions_array['available_actions'] = [
            'update' => (Auth::user()->can('Edit Category') && ($category->deleted_at==''))  ? true : false,
            'delete' => (Auth::user()->can('Delete Category') && ($category->deleted_at=='')) ? true : false,
            'restore' => (Auth::user()->can('Restore Category') && ($category->deleted_at!='')) ? true : false,
        ];

        $array += $permissions_array;
        return $array;
    }
}