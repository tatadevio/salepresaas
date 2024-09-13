<?php

namespace Modules\Ecommerce\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class PageWidgets extends Model
{
     use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'page_id',
        'order',
        'product_category_title',
        'product_category_id',
        'product_category_type',
        'product_category_slider_loop',
        'product_category_slider_autoplay',
        'product_category_limit',
        'tab_product_collection_id',
        'tab_product_collection_type',
        'tab_product_collection_slider_loop',
        'tab_product_collection_slider_autoplay',
        'tab_product_collection_limit',
        'product_collection_title',
        'product_collection_id',
        'product_collection_type',
        'product_collection_slider_loop',
        'product_collection_slider_autoplay',
        'product_collection_limit',
        'category_slider_title',
        'category_slider_loop',
        'category_slider_autoplay',
        'category_slider_ids',
        'brand_slider_title',
        'brand_slider_loop',
        'brand_slider_autoplay',
        'brand_slider_ids',
        '3c_banner_link1',
        '3c_banner_image1',
        '3c_banner_link2',
        '3c_banner_image2',
        '3c_banner_link3',
        '3c_banner_image3',
        '2c_banner_link1',
        '2c_banner_image1',
        '2c_banner_link2',
        '2c_banner_image2',
        '1c_banner_link1',
        '1c_banner_image1',
        'text_title',
        'text_content',
    ];
}
