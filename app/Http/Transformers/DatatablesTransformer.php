<?php

namespace App\Http\Transformers;


class DatatablesTransformer
{
    public function transformDatatables($objects, $total = null)
    {
        (isset($total)) ? $objects_array['total'] = $total : $objects_array['total'] = count($objects);

        $objects_array['rows'] = $objects;

        return $objects_array;
    }
}