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
                "field" => "checkbox",
                "checkbox" => true
            ],
            [
                "field" => "id",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => __('general.id'),
                "visible" => false
            ],
            [
                "field" => "avatar",
                "searchable" => false,
                "sortable" => false,
                "switchable" => true,
                "title" => __('general.avatar'),
                "visible" => false,
                "formatter" => "imageFormatter"
            ],
            [
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "title" => __('general.name'),
                "visible" => true,
                "formatter" => "usersLinkFormatter"
            ],
            [
                "field" => "email",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => __('general.email'),
                "visible" => true,
                "formatter" => "emailFormatter"
            ],
            [
                "field" => "phone",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => __('general.phone'),
                "visible" => true,
                "formatter"    => "phoneFormatter",
            ],
            [
                "field" => "address",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => __('general.address'),
                "visible" => false,
            ],
            [
                "field" => "city",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.city'),
                "visible" => false,
            ],
            [
                "field" => "state",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.state'),
                "visible" => false,
            ],
            [
                "field" => "country",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.country'),
                "visible" => false,
            ],
            [
                "field" => "zip",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.zip'),
                "visible" => false,
            ],
            [
                "field" => "activated",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.activated'),
                "visible" => true,
                'formatter' => 'trueFalseFormatter'
            ],
            [
                "field" => "created_at",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.created_at'),
                "visible" => false,
                'formatter' => 'dateDisplayFormatter'
            ],
            [
                "field" => "last_login",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.last_login'),
                "visible" => false,
                'formatter' => 'dateDisplayFormatter'
            ],
            [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "visible" => true,
                "formatter" => "usersActionsFormatter",
            ]
        ];

        return json_encode($layout);
    }
}