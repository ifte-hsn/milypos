<?php
/**
 * Created by PhpStorm.
 * User: Shishir
 * Date: 1/1/2019
 * Time: 11:27 AM
 */

namespace App\Presenters;


class ProductPresenter
{
    public static function dataTableLayout() {
        $layout = [
            [
                'field' => 'checkbox',
                'checkbox' => true
            ],
            [
                'field' => 'id',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => __('general.id'),
                'visible' => false
            ],
            [
                'field' => 'image',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => __('general.image'),
                'visible' => true,
                'formatter' => 'imageFormatter'
            ],
            [
                'field' => 'code',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.code'),
                'visible' => true,
                'formatter' => 'productsLinkFormatter',
            ],
            [
                'field' => 'name',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.name'),
                'visible' => true,
                'formatter' => 'productsLinkFormatter',
            ],
            [
                'field' => 'description',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.description'),
                'visible' => true,
                'formatter' => 'productsLinkFormatter',
            ],
            [
                'field' => 'category',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.category'),
                'visible' => true,
                'formatter' => 'productsLinkFormatter',
            ],
            [
                'field' => 'stock',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.stock'),
                'visible' => true,
                'formatter' => 'productsLinkFormatter',
            ],

            [
                'field' => 'purchase_price',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.purchase_price'),
                'visible' => true,
                'formatter' => 'productsLinkFormatter',
            ],
            [
                'field' => 'selling_price',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.selling_price'),
                'visible' => true,
                'formatter' => 'productsLinkFormatter',
            ],
            [
                'field' => 'created_at',
                'searchable' => false,
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
                'formatter' => 'productsActionsFormatter',
            ]
        ];
        return json_encode($layout);
    }

    public static function dataTableLayoutForSale() {
        $layout = [
            [
                'field' => 'id',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => __('general.id'),
                'visible' => false
            ],
            [
                'field' => 'image',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => __('general.image'),
                'visible' => true,
                'formatter' => 'imageFormatter'
            ],
            [
                'field' => 'code',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.code'),
                'visible' => true,
                'formatter' => 'productsLinkFormatter',
            ],
            [
                'field' => 'name',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.name'),
                'visible' => true,
                'formatter' => 'productsLinkFormatter',
            ],
            [
                'field' => 'description',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.description'),
                'visible' => true,
                'formatter' => 'productsLinkFormatter',
            ],
            [
                'field' => 'category',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.category'),
                'visible' => true,
                'formatter' => 'productsLinkFormatter',
            ],
            [
                'field' => 'stock',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.stock'),
                'visible' => true,
                'formatter' => 'productsLinkFormatter',
            ],

            [
                'field' => 'selling_price',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.selling_price'),
                'visible' => true,
                'formatter' => 'productsLinkFormatter',
            ],
            [
                'field' => 'actions',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => __('general.actions'),
                'visible' => true,
                'formatter' => 'salesActionsFormatter',
            ]
        ];
        return json_encode($layout);
    }
}