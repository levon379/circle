<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductList extends Model
{
    protected $table = "product_list";
    public function product_list_items()
    {
        return $this->hasMany('App\Admin\ProductListItems', "product_list_id", "id");
    }
}
