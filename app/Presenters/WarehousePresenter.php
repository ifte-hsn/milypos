<?php

namespace App\Presenters;


class WarehousePresenter
{
    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            [
                'field' => 'checkbox',
                'checkbox' => true
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
                'field' => 'code',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.code'),
                'visible' => true,
                'formatter' => 'warehousesLinkFormatter'
            ],
            [
                'field' => 'name',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.name'),
                'visible' => true,
                'formatter' => 'warehousesLinkFormatter'
            ],
            [
                'field' => 'email',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => __('general.email'),
                'visible' => true,
                'formatter' => 'emailFormatter'
            ],
            [
                'field' => 'phone',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => __('general.phone'),
                'visible' => true,
                'formatter' => 'phoneFormatter',
            ],
            [
                'field' => 'address',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => __('general.address'),
                'visible' => false,
            ],
            [
                'field' => 'created_at',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => __('general.created_at'),
                'visible' => false,
                'formatter' => 'dateDisplayFormatter'
            ],
            [
                'field' => 'actions',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => __('general.actions'),
                'visible' => true,
                'formatter' => 'warehousesActionsFormatter',
            ]
        ];

        return json_encode($layout);
    }
}