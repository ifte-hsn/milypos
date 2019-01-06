<?php

namespace App\Presenters;


class SalePresenter
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
                'field' => 'seller',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.seller'),
                'visible' => true,
            ],
            [
                'field' => 'client',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => __('general.customer'),
                'visible' => true,
            ],
            [
                'field' => 'tax',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => __('general.tax'),
                'visible' => true,
                'formatter' => 'sexFormatter'
            ],
            [
                'field' => 'net',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => __('general.net'),
                'visible' => true,
            ],
            [
                'field' => 'total',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => __('general.total'),
                'visible' => true,
            ],
            [
                'field' => 'payment_method',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => __('general.payment_method'),
                'visible' => false,
            ]
        ];

        return json_encode($layout);
    }
}