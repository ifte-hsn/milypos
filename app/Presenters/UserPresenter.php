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
                "title" => trans('general.id'),
                "visible" => false
            ],
            [
                "field" => "avatar",
                "searchable" => false,
                "sortable" => false,
                "switchable" => true,
                "title" => 'Avatar',
                "visible" => false,
                "formatter" => "imageFormatter"
            ],
            [
                "field" => "company",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/companies/table.title'),
                "visible" => false,
                "formatter" => "companiesLinkObjFormatter"
            ],
            [
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/users/table.name'),
                "visible" => true,
                "formatter" => "usersLinkFormatter"
            ],
            [
                "field" => "jobtitle",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/users/table.title'),
                "visible" => true,
                "formatter" => "usersLinkFormatter"
            ],
            [
                "field" => "email",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/users/table.email'),
                "visible" => true,
                "formatter" => "emailFormatter"
            ],
            [
                "field" => "phone",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/users/table.phone'),
                "visible" => true,
                "formatter"    => "phoneFormatter",
            ],
            [
                "field" => "address",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.address'),
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
                "field" => "employee_num",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/users/table.employee_num'),
                "visible" => false
            ],
            [
                "field" => "location",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/users/table.location'),
                "visible" => true,
                "formatter" => "locationsLinkObjFormatter"
            ],
            [
                "field" => "manager",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/users/table.manager'),
                "visible" => true,
                "formatter" => "usersLinkObjFormatter"
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