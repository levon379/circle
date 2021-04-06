<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = "shop";
    public static $currency = [
        'amd'=>'AMD', 'usd'=>'USD'
    ];
    public function category()
    {
        return $this->belongsTo('App\Admin\Category', "category_id", "id");
    }
}
