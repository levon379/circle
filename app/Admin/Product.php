<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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
}
