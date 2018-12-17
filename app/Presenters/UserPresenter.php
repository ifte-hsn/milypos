<?php


namespace App\Presenters;


class UserPresenter
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
                'field' => 'avatar',
                'searchable' => false,
                'sortable' => false,
                'switchable' => true,
                'title' => __('general.avatar'),
                'visible' => false,
                'formatter' => 'imageFormatter'
            ],
            [
                'field' => 'name',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.name'),
                'visible' => true,
                'formatter' => 'usersLinkFormatter'
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
                'field' => 'website',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => __('general.website'),
                'visible' => true,
                'formatter' => 'websiteLinkFormatter'
            ],
            [
                'field' => 'activated',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => __('general.activated'),
                'visible' => true,
                'formatter' => 'trueFalseFormatter'
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
                'field' => 'last_login',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => __('general.last_login'),
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
                'formatter' => 'usersActionsFormatter',
            ]
        ];

        return json_encode($layout);
    }
}