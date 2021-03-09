<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;


class ProductTabsMap extends Model
{
    protected $table = "product_tabs_map";

    public function get_tabs(){
        return $this->hasOne("App\Admin\ProductTabs","id","tab_id");
    }
}
