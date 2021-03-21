<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['ordering'];
    public function image()
    {
        return $this->hasMany('App\Admin\ProductImage', "product_id", "id");
    }

    public function category()
    {
        return $this->belongsTo('App\Admin\Category', "category_id", "id");
    }

    public function specification()
    {
        return $this->hasMany('App\Admin\ProductSpecification', "specification_id", "id");
    }

    public function featured()
    {
        return $this->hasMany('App\Admin\ProductFeatur', "product_id", "id");
    }

    public function product_list()
    {
        return $this->hasMany('App\Admin\ProductList', "product_id", "id");
    }

    public function product_tabs_map()
    {
        //return $this->belongsToMany(ProductTabsMap::class, "",'product_tabs_map');
//        return $this->hasMany('App\Admin\ProductTabsMap', "product_id");
        return $this->hasMany('App\Admin\ProductTabsMap', "product_id")->leftJoin('product_tabs', 'product_tabs_map.tab_id', '=', 'product_tabs.id')->orderBy('product_tabs.ordering');
    }
}
