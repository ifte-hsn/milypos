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
                'formatter' => 'descriptionsFormatter',
            ],
            [
                'field' => 'category',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.category'),
                'visible' => true,
                'formatter' => 'productCategoryFormatter',
            ],
            [
                'field' => 'stock',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.stock'),
                'visible' => true,
                'formatter' => 'stockFormatter',
            ],
            [
                'field' => 'purchase_price',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.purchase_price'),
                'visible' => true,
                'formatter' => 'priceFormatter',
            ],
            [
                'field' => 'purchase_price',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.purchase_price'),
                'visible' => true,
                'formatter' => 'purchasePriceFormatter',
            ],
            [
                'field' => 'sale_price',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.sale_price'),
                'visible' => true,
                'formatter' => 'salePriceFormatter',
            ],
            [
                'field' => 'rack',
                'searchable' => true,
                'sortable' => true,
                'title' => __('general.rack'),
                'visible' => true,
                'formatter' => 'rackFormatter',
            ]
        ];
        return $layout;
    }
}