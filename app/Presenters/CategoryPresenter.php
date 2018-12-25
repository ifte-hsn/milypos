<?php

namespace App\Presenters;


class CategoryPresenter
{
    public static function dataTableLayout()
    {
        $layout = [
            [
                'field' => 'checkboc',
                'checkbox' => 'true',
            ],
            [
                'field' => 'id',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => __('general.id'),
                'visible' => false
            ],
            [
                'field' => 'name',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.name'),
                'visible' => true,
                'formatter' => 'categoriesLinkFormatter'
            ],
            [
                'field' => 'actions',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => __('general.actions'),
                'visible' => true,
                'formatter' => 'categoriesActionsFormatter'
            ]
        ];

        return json_encode($layout);
    }
}