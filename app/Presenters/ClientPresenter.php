<?php

namespace App\Presenters;


class ClientPresenter
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
                'field' => 'image',
                'searchable' => false,
                'sortable' => false,
                'switchable' => true,
                'title' => __('general.image'),
                'visible' => true,
                'formatter' => 'imageFormatter'
            ],
            [
                'field' => 'name',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.name'),
                'visible' => true,
                'formatter' => 'clientsLinkFormatter'
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
                'field' => 'sex',
                'searchable' => false,
                'sortable' => false,
                'switchable' => true,
                'title' => __('general.sex'),
                'visible' => true,
                'formatter' => 'sexFormatter'
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
                'field' => 'city',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => __('general.city'),
                'visible' => false,
            ],
            [
                'field' => 'state',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => __('general.state'),
                'visible' => false,
            ],
            [
                'field' => 'country',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => __('general.country'),
                'visible' => false,
            ],
            [
                'field' => 'zip',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => __('general.zip'),
                'visible' => false,
            ],
            [
                'field' => 'role',
                'searchable' => false,
                'sortable' => false,
                'switchable' => true,
                'title' => __('general.role'),
                'visible' => true
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
                'formatter' => 'clientsActionsFormatter',
            ]
        ];

        return json_encode($layout);
    }
}